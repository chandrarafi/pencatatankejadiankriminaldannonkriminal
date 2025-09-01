<?php

namespace App\Controllers;

use App\Models\TersangkaModel;

class LaporanTersangkaController extends BaseController
{
    protected $tersangkaModel;

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

        $this->tersangkaModel = new TersangkaModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Data Tersangka',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_tersangka/index', $data);
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
        $columns = ['nama', 'nik', 'jenis_kelamin', 'umur', 'alamat', 'status_tersangka', 'tempat_penahanan', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query with kasus join
            $builder = $this->tersangkaModel->select('tersangka.*, kasus.nomor_kasus, kasus.judul_kasus, jenis_kasus.nama_jenis')
                ->join('kasus', 'kasus.id = tersangka.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('tersangka.nama', $searchValue)
                    ->orLike('tersangka.nik', $searchValue)
                    ->orLike('tersangka.alamat', $searchValue)
                    ->orLike('tersangka.jenis_kelamin', $searchValue)
                    ->orLike('tersangka.status_tersangka', $searchValue)
                    ->orLike('tersangka.tempat_penahanan', $searchValue)
                    ->orLike('kasus.nomor_kasus', $searchValue)
                    ->orLike('kasus.judul_kasus', $searchValue)
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
                    'umur' => $record['umur'] . ' tahun',
                    'alamat' => $record['alamat'] ?: '-',
                    'status_tersangka' => ucfirst(str_replace('_', ' ', $record['status_tersangka'])),
                    'tempat_penahanan' => $record['tempat_penahanan'] ?: '-',
                    'nomor_kasus' => $record['nomor_kasus'] ?: '-',
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
            log_message('error', 'Error in LaporanTersangkaController getData: ' . $e->getMessage());
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
            $tersangka = $this->tersangkaModel->select('tersangka.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.tanggal_kejadian, kasus.status as status_kasus, jenis_kasus.nama_jenis')
                ->join('kasus', 'kasus.id = tersangka.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->find($id);

            if (!$tersangka) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tersangka tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $tersangka
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanTersangkaController getDetail: ' . $e->getMessage());
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

        // Get all tersangka data with kasus info
        $tersangkaData = $this->tersangkaModel->select('tersangka.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.tanggal_kejadian, jenis_kasus.nama_jenis')
            ->join('kasus', 'kasus.id = tersangka.kasus_id', 'left')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->orderBy('tersangka.nama', 'ASC')
            ->findAll();

        // Get statistics
        $totalTersangka = count($tersangkaData);

        $data = [
            'title' => 'Laporan Data Tersangka',
            'user' => $user,
            'role' => $role,
            'tersangkaData' => $tersangkaData,
            'totalTersangka' => $totalTersangka,
            'isPrint' => true
        ];

        return view('laporan_tersangka/print', $data);
    }

    public function getStatistics()
    {
        try {
            // Get all tersangka data
            $tersangkaData = $this->tersangkaModel->findAll();

            $stats = [
                'total' => count($tersangkaData),
                'laki_laki' => 0,
                'perempuan' => 0,
                'dengan_nik' => 0,
                'tanpa_nik' => 0,
                'ditahan' => 0,
                'tidak_ditahan' => 0,
                'dpo' => 0,
                'tersangka' => 0,
                'terdakwa' => 0,
                'terpidana' => 0
            ];

            foreach ($tersangkaData as $tersangka) {
                // Count by gender
                if ($tersangka['jenis_kelamin'] === 'laki-laki') {
                    $stats['laki_laki']++;
                } else {
                    $stats['perempuan']++;
                }

                // Count by NIK
                if (!empty($tersangka['nik'])) {
                    $stats['dengan_nik']++;
                } else {
                    $stats['tanpa_nik']++;
                }

                // Count by detention status
                if (!empty($tersangka['tempat_penahanan'])) {
                    $stats['ditahan']++;
                } else {
                    $stats['tidak_ditahan']++;
                }

                // Count by status
                switch ($tersangka['status_tersangka']) {
                    case 'dpo':
                        $stats['dpo']++;
                        break;
                    case 'tersangka':
                        $stats['tersangka']++;
                        break;
                    case 'terdakwa':
                        $stats['terdakwa']++;
                        break;
                    case 'terpidana':
                        $stats['terpidana']++;
                        break;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanTersangkaController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}

