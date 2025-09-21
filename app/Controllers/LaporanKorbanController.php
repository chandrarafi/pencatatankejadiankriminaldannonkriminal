<?php

namespace App\Controllers;

use App\Models\KorbanModel;

class LaporanKorbanController extends BaseController
{
    protected $korbanModel;

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

        $this->korbanModel = new KorbanModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Data Korban',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_korban/index', $data);
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
        $columns = ['nama', 'nik', 'jenis_kelamin', 'umur', 'alamat', 'status_korban', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query with kasus join
            $builder = $this->korbanModel->select('korban.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
                ->join('kasus', 'kasus.id = korban.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('korban.nama', $searchValue)
                    ->orLike('korban.nik', $searchValue)
                    ->orLike('korban.alamat', $searchValue)
                    ->orLike('korban.jenis_kelamin', $searchValue)
                    ->orLike('korban.status_korban', $searchValue)
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
                    'status_korban' => ucfirst(str_replace('_', ' ', $record['status_korban'])),
                    'nomor_kasus' => $record['nomor_kasus'] ?: '-',
                    'kode_jenis' => $record['kode_jenis'] ?? '-',
                    'judul_kasus' => $record['judul_kasus'] ?? '-',
                    'deskripsi' => $record['deskripsi_kasus'] ? mb_strimwidth($record['deskripsi_kasus'], 0, 80, '...') : '-',
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
            log_message('error', 'Error in LaporanKorbanController getData: ' . $e->getMessage());
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
            $korban = $this->korbanModel->select('korban.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, kasus.tanggal_kejadian, kasus.status as status_kasus, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
                ->join('kasus', 'kasus.id = korban.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->find($id);

            if (!$korban) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data korban tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $korban
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKorbanController getDetail: ' . $e->getMessage());
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

        // Get all korban data dengan info kasus lengkap
        $korbanData = $this->korbanModel->select('korban.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, kasus.tanggal_kejadian, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
            ->join('kasus', 'kasus.id = korban.kasus_id', 'left')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->orderBy('korban.nama', 'ASC')
            ->findAll();

        // Get statistics
        $totalKorban = count($korbanData);

        $data = [
            'title' => 'Laporan Data Korban',
            'user' => $user,
            'role' => $role,
            'korbanData' => $korbanData,
            'totalKorban' => $totalKorban,
            'isPrint' => true
        ];

        return view('laporan_korban/print', $data);
    }

    public function getStatistics()
    {
        try {
            // Get all korban data
            $korbanData = $this->korbanModel->findAll();

            $stats = [
                'total' => count($korbanData),
                'laki_laki' => 0,
                'perempuan' => 0,
                'dengan_nik' => 0,
                'tanpa_nik' => 0,
                'meninggal' => 0,
                'luka_berat' => 0,
                'luka_ringan' => 0,
                'tidak_luka' => 0
            ];

            foreach ($korbanData as $korban) {
                // Count by gender
                if ($korban['jenis_kelamin'] === 'laki-laki') {
                    $stats['laki_laki']++;
                } else {
                    $stats['perempuan']++;
                }

                // Count by NIK
                if (!empty($korban['nik'])) {
                    $stats['dengan_nik']++;
                } else {
                    $stats['tanpa_nik']++;
                }

                // Count by status
                switch ($korban['status_korban']) {
                    case 'meninggal':
                        $stats['meninggal']++;
                        break;
                    case 'luka_berat':
                        $stats['luka_berat']++;
                        break;
                    case 'luka_ringan':
                        $stats['luka_ringan']++;
                        break;
                    case 'tidak_luka':
                        $stats['tidak_luka']++;
                        break;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKorbanController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
