<?php

namespace App\Controllers;

use App\Models\PelaporModel;

class LaporanPelaporController extends BaseController
{
    protected $pelaporModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!session()->get('is_logged_in')) {
            redirect()->to('/login')->send();
            exit();
        }

        // Check role access - only kapolsek and reskrim can access
        $role = session()->get('role');
        if (!in_array($role, ['kapolsek', 'reskrim'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }

        $this->pelaporModel = new PelaporModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Data Pelapor',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_pelapor/index', $data);
    }

    public function getData()
    {
        $request = service('request');

        // Get DataTables parameters
        $draw = $request->getPost('draw');
        $start = (int) $request->getPost('start');
        $length = (int) $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? '';
        $orderColumnIndex = (int) $request->getPost('order')[0]['column'];
        $orderDirection = $request->getPost('order')[0]['dir'];

        // Column mapping for ordering
        $columns = ['nama', 'nik', 'jenis_kelamin', 'alamat', 'telepon', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query
            $builder = $this->pelaporModel->select('*');

            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('nama', $searchValue)
                    ->orLike('nik', $searchValue)
                    ->orLike('alamat', $searchValue)
                    ->orLike('telepon', $searchValue)
                    ->orLike('jenis_kelamin', $searchValue)
                    ->groupEnd();
            }

            // Get total records
            $totalRecords = $builder->countAllResults(false);

            // Apply ordering and pagination
            $builder->orderBy($orderColumn, $orderDirection)
                ->limit($length, $start);

            $records = $builder->get()->getResultArray();

            // Format data for DataTables
            $data = [];
            foreach ($records as $record) {
                $data[] = [
                    'id' => $record['id'],
                    'nama' => $record['nama'],
                    'nik' => $record['nik'] ?: '-',
                    'jenis_kelamin' => ucfirst($record['jenis_kelamin']),
                    'alamat' => $record['alamat'] ?: '-',
                    'telepon' => $record['telepon'] ?: '-',
                    'created_at' => date('d/m/Y H:i', strtotime($record['created_at'])),
                    'actions' => '<button type="button" class="btn btn-sm btn-info" onclick="showDetail(' . $record['id'] . ')">
                                    <i class="fas fa-eye"></i> Detail
                                  </button>'
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPelaporController getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function getDetail($id)
    {
        try {
            $pelapor = $this->pelaporModel->find($id);

            if (!$pelapor) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data pelapor tidak ditemukan'
                ]);
            }

            // Get related cases
            $kasusModel = new \App\Models\KasusModel();
            $relatedCases = $kasusModel->select('kasus.*, jenis_kasus.nama_jenis')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->where('kasus.pelapor_id', $id)
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $pelapor,
                'related_cases' => $relatedCases
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPelaporController getDetail: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function print()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        // Get all pelapor data
        $pelaporData = $this->pelaporModel->orderBy('nama', 'ASC')->findAll();

        // Get statistics
        $totalPelapor = count($pelaporData);
        $jenisKelaminStats = [];

        foreach ($pelaporData as $pelapor) {
            $jenisKelamin = ucfirst($pelapor['jenis_kelamin']);
            $jenisKelaminStats[$jenisKelamin] = ($jenisKelaminStats[$jenisKelamin] ?? 0) + 1;
        }

        $data = [
            'title' => 'Laporan Data Pelapor',
            'user' => $user,
            'role' => $role,
            'pelaporData' => $pelaporData,
            'totalPelapor' => $totalPelapor,
            'jenisKelaminStats' => $jenisKelaminStats,
            'isPrint' => true
        ];

        return view('laporan_pelapor/print', $data);
    }

    public function getStatistics()
    {
        try {
            // Get all pelapor data
            $pelaporData = $this->pelaporModel->findAll();

            $stats = [
                'total' => count($pelaporData),
                'laki_laki' => 0,
                'perempuan' => 0,
                'dengan_nik' => 0,
                'tanpa_nik' => 0,
                'dengan_telepon' => 0,
                'tanpa_telepon' => 0
            ];

            foreach ($pelaporData as $pelapor) {
                // Count by gender
                if ($pelapor['jenis_kelamin'] === 'laki-laki') {
                    $stats['laki_laki']++;
                } else {
                    $stats['perempuan']++;
                }

                // Count by NIK
                if (!empty($pelapor['nik'])) {
                    $stats['dengan_nik']++;
                } else {
                    $stats['tanpa_nik']++;
                }

                // Count by phone
                if (!empty($pelapor['telepon'])) {
                    $stats['dengan_telepon']++;
                } else {
                    $stats['tanpa_telepon']++;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPelaporController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}

