<?php

namespace App\Controllers;

use App\Models\SaksiModel;

class LaporanSaksiController extends BaseController
{
    protected $saksiModel;

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

        $this->saksiModel = new SaksiModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Data Saksi',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_saksi/index', $data);
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
        $columns = ['nama', 'nik', 'jenis_kelamin', 'umur', 'alamat', 'jenis_saksi', 'dapat_dihubungi', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query with kasus join
            $builder = $this->saksiModel->select('saksi.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
                ->join('kasus', 'kasus.id = saksi.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('saksi.nama', $searchValue)
                    ->orLike('saksi.nik', $searchValue)
                    ->orLike('saksi.alamat', $searchValue)
                    ->orLike('saksi.jenis_kelamin', $searchValue)
                    ->orLike('saksi.jenis_saksi', $searchValue)
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
                    'jenis_saksi' => ucfirst(str_replace('_', ' ', $record['jenis_saksi'])),
                    'dapat_dihubungi' => $record['dapat_dihubungi'] ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-danger">Tidak</span>',
                    'kode_jenis' => $record['kode_jenis'] ?? '-',
                    'judul_kasus' => $record['judul_kasus'] ?? '-',
                    'deskripsi' => $record['deskripsi_kasus'] ? mb_strimwidth($record['deskripsi_kasus'], 0, 80, '...') : '-',
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
            log_message('error', 'Error in LaporanSaksiController getData: ' . $e->getMessage());
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
            $saksi = $this->saksiModel->select('saksi.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, kasus.tanggal_kejadian, kasus.status as status_kasus, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
                ->join('kasus', 'kasus.id = saksi.kasus_id', 'left')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->find($id);

            if (!$saksi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data saksi tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $saksi
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanSaksiController getDetail: ' . $e->getMessage());
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

        // Get all saksi data dengan info kasus lengkap
        $saksiData = $this->saksiModel->select('saksi.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.deskripsi as deskripsi_kasus, kasus.tanggal_kejadian, jenis_kasus.nama_jenis, jenis_kasus.kode_jenis')
            ->join('kasus', 'kasus.id = saksi.kasus_id', 'left')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->orderBy('saksi.nama', 'ASC')
            ->findAll();

        // Get statistics
        $totalSaksi = count($saksiData);

        $data = [
            'title' => 'Laporan Data Saksi',
            'user' => $user,
            'role' => $role,
            'saksiData' => $saksiData,
            'totalSaksi' => $totalSaksi,
            'isPrint' => true
        ];

        return view('laporan_saksi/print', $data);
    }

    public function getStatistics()
    {
        try {
            // Get all saksi data
            $saksiData = $this->saksiModel->findAll();

            $stats = [
                'total' => count($saksiData),
                'laki_laki' => 0,
                'perempuan' => 0,
                'dengan_nik' => 0,
                'tanpa_nik' => 0,
                'dapat_dihubungi' => 0,
                'tidak_dapat_dihubungi' => 0,
                'saksi_korban' => 0,
                'saksi_ahli' => 0,
                'saksi_mata' => 0,
                'saksi_telinga' => 0
            ];

            foreach ($saksiData as $saksi) {
                // Count by gender
                if ($saksi['jenis_kelamin'] === 'laki-laki') {
                    $stats['laki_laki']++;
                } else {
                    $stats['perempuan']++;
                }

                // Count by NIK
                if (!empty($saksi['nik'])) {
                    $stats['dengan_nik']++;
                } else {
                    $stats['tanpa_nik']++;
                }

                // Count by contactability
                if ($saksi['dapat_dihubungi']) {
                    $stats['dapat_dihubungi']++;
                } else {
                    $stats['tidak_dapat_dihubungi']++;
                }

                // Count by jenis saksi
                switch ($saksi['jenis_saksi']) {
                    case 'saksi_korban':
                        $stats['saksi_korban']++;
                        break;
                    case 'saksi_ahli':
                        $stats['saksi_ahli']++;
                        break;
                    case 'saksi_mata':
                        $stats['saksi_mata']++;
                        break;
                    case 'saksi_telinga':
                        $stats['saksi_telinga']++;
                        break;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanSaksiController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
