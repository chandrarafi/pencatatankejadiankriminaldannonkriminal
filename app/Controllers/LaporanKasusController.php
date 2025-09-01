<?php

namespace App\Controllers;

use App\Models\KasusModel;
use App\Models\JenisKasusModel;
use App\Models\PelaporModel;
use CodeIgniter\Controller;

class LaporanKasusController extends Controller
{
    protected $kasusModel;
    protected $jenisKasusModel;
    protected $pelaporModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!session()->get('is_logged_in')) {
            redirect()->to('/auth/login');
        }

        // Check if user has access (kapolsek or reskrim)
        $role = session()->get('role');
        if (!in_array($role, ['kapolsek', 'reskrim'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access denied');
        }

        $this->kasusModel = new KasusModel();
        $this->jenisKasusModel = new JenisKasusModel();
        $this->pelaporModel = new PelaporModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Kasus Per Tanggal',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_kasus/index', $data);
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

        // Get filter parameters
        $tanggalMulai = $request->getPost('tanggal_mulai');
        $tanggalSelesai = $request->getPost('tanggal_selesai');

        // Column mapping for ordering
        $columns = ['nomor_kasus', 'judul_kasus', 'jenis_kasus_nama', 'pelapor_nama', 'tanggal_kejadian', 'status'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query with filters
            $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

            // Apply date filters
            if ($tanggalMulai && $tanggalSelesai) {
                $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai)
                    ->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
            } elseif ($tanggalMulai) {
                $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai);
            } elseif ($tanggalSelesai) {
                $builder->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
            }



            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('kasus.nomor_kasus', $searchValue)
                    ->orLike('kasus.judul_kasus', $searchValue)
                    ->orLike('jenis_kasus.nama_jenis', $searchValue)
                    ->orLike('pelapor.nama', $searchValue)
                    ->orLike('kasus.status', $searchValue)
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
                // Format tanggal
                $tanggalKejadian = date('d/m/Y', strtotime($record['tanggal_kejadian']));

                // Status badge
                $statusClass = match ($record['status']) {
                    'dilaporkan' => 'badge-warning',
                    'dalam_proses' => 'badge-info',
                    'selesai' => 'badge-success',
                    'ditutup' => 'badge-secondary',
                    default => 'badge-light'
                };

                $data[] = [
                    'id' => $record['id'],
                    'nomor_kasus' => $record['nomor_kasus'] ?: '-',
                    'judul_kasus' => $record['judul_kasus'],
                    'jenis_kasus_nama' => $record['jenis_kasus_nama'] ?: '-',
                    'pelapor_nama' => $record['pelapor_nama'] ?: '-',
                    'tanggal_kejadian' => $tanggalKejadian,
                    'status' => '<span class="badge ' . $statusClass . '">' . ucfirst(str_replace('_', ' ', $record['status'])) . '</span>',
                    'actions' => '<a href="' . base_url('laporan-kasus/detail/' . $record['id']) . '" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                  </a>'
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function print()
    {
        $request = service('request');
        $user = session()->get('user_data');
        $role = session()->get('role');

        // Get filter parameters
        $tanggalMulai = $request->getGet('tanggal_mulai');
        $tanggalSelesai = $request->getGet('tanggal_selesai');

        // Build query with filters
        $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.telepon as pelapor_telepon')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

        // Apply date filters
        if ($tanggalMulai && $tanggalSelesai) {
            $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai)
                ->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
        } elseif ($tanggalMulai) {
            $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai);
        } elseif ($tanggalSelesai) {
            $builder->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
        }

        $kasusData = $builder->orderBy('kasus.tanggal_kejadian', 'DESC')->findAll();

        // Generate statistics
        $totalKasus = count($kasusData);
        $statusStats = [];
        $jenisStats = [];

        foreach ($kasusData as $kasus) {
            // Count by status
            $statusStats[$kasus['status']] = ($statusStats[$kasus['status']] ?? 0) + 1;

            // Count by jenis
            $jenisName = $kasus['jenis_kasus_nama'] ?: 'Tidak Dikategorikan';
            $jenisStats[$jenisName] = ($jenisStats[$jenisName] ?? 0) + 1;
        }

        $data = [
            'title' => 'Laporan Kasus Per Tanggal',
            'user' => $user,
            'role' => $role,
            'kasusData' => $kasusData,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'totalKasus' => $totalKasus,
            'statusStats' => $statusStats,
            'jenisStats' => $jenisStats,
            'isPrint' => true
        ];

        return view('laporan_kasus/print', $data);
    }

    public function getStatistics()
    {
        $request = service('request');

        // Get filter parameters
        $tanggalMulai = $request->getGet('tanggal_mulai');
        $tanggalSelesai = $request->getGet('tanggal_selesai');
        $groupBy = $request->getGet('group_by') ?: 'month'; // day, month, year

        try {
            // Build base query
            $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

            // Apply filters
            if ($tanggalMulai && $tanggalSelesai) {
                $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai)
                    ->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
            } elseif ($tanggalMulai) {
                $builder->where('DATE(kasus.tanggal_kejadian) >=', $tanggalMulai);
            } elseif ($tanggalSelesai) {
                $builder->where('DATE(kasus.tanggal_kejadian) <=', $tanggalSelesai);
            }

            $kasusData = $builder->findAll();

            // Group data by time period
            $groupedData = [];
            foreach ($kasusData as $kasus) {
                $date = strtotime($kasus['tanggal_kejadian']);

                switch ($groupBy) {
                    case 'day':
                        $key = date('Y-m-d', $date);
                        $label = date('d/m/Y', $date);
                        break;
                    case 'year':
                        $key = date('Y', $date);
                        $label = date('Y', $date);
                        break;
                    default: // month
                        $key = date('Y-m', $date);
                        $label = date('M Y', $date);
                        break;
                }

                if (!isset($groupedData[$key])) {
                    $groupedData[$key] = [
                        'label' => $label,
                        'total' => 0,
                        'dilaporkan' => 0,
                        'dalam_proses' => 0,
                        'selesai' => 0,
                        'ditutup' => 0
                    ];
                }

                $groupedData[$key]['total']++;
                $groupedData[$key][$kasus['status']]++;
            }

            // Sort by key
            ksort($groupedData);

            return $this->response->setJSON([
                'success' => true,
                'data' => array_values($groupedData)
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function detail($id)
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        try {
            // Get case data with related information
            $kasus = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.telepon as pelapor_telepon, pelapor.alamat as pelapor_alamat')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
                ->find($id);

            if (!$kasus) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
            }

            $data = [
                'title' => 'Detail Kasus - ' . $kasus['nomor_kasus'],
                'user' => $user,
                'role' => $role,
                'kasus' => $kasus
            ];

            return view('laporan_kasus/detail', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController detail: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }
    }

    public function printDetail($id)
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        try {
            // Get case data with related information
            $kasus = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.telepon as pelapor_telepon, pelapor.alamat as pelapor_alamat')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
                ->find($id);

            if (!$kasus) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
            }

            $data = [
                'title' => 'Detail Kasus - ' . $kasus['nomor_kasus'],
                'user' => $user,
                'role' => $role,
                'kasus' => $kasus,
                'isPrint' => true
            ];

            return view('laporan_kasus/print_detail', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController printDetail: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }
    }

    public function monthly()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Kasus Per Bulan',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_kasus/monthly', $data);
    }

    public function getMonthlyData()
    {
        $request = service('request');

        // Get DataTables parameters
        $draw = $request->getPost('draw');
        $start = (int) $request->getPost('start');
        $length = (int) $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? '';
        $orderColumnIndex = (int) $request->getPost('order')[0]['column'];
        $orderDirection = $request->getPost('order')[0]['dir'];

        // Get filter parameters
        $bulan = $request->getPost('bulan');
        $tahun = $request->getPost('tahun');

        // Column mapping for ordering
        $columns = ['nomor_kasus', 'judul_kasus', 'jenis_kasus_nama', 'pelapor_nama', 'tanggal_kejadian', 'status'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        try {
            // Build query with filters
            $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

            // Apply month/year filters
            if ($bulan && $tahun) {
                $builder->where('MONTH(kasus.tanggal_kejadian)', $bulan)
                    ->where('YEAR(kasus.tanggal_kejadian)', $tahun);
            } elseif ($tahun) {
                $builder->where('YEAR(kasus.tanggal_kejadian)', $tahun);
            }

            // Apply search
            if ($searchValue) {
                $builder->groupStart()
                    ->like('kasus.nomor_kasus', $searchValue)
                    ->orLike('kasus.judul_kasus', $searchValue)
                    ->orLike('jenis_kasus.nama_jenis', $searchValue)
                    ->orLike('pelapor.nama', $searchValue)
                    ->orLike('kasus.status', $searchValue)
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
                // Format tanggal
                $tanggalKejadian = date('d/m/Y', strtotime($record['tanggal_kejadian']));

                // Status badge
                $statusClass = match ($record['status']) {
                    'dilaporkan' => 'badge-warning',
                    'dalam_proses' => 'badge-info',
                    'selesai' => 'badge-success',
                    'ditutup' => 'badge-secondary',
                    default => 'badge-light'
                };

                $data[] = [
                    'id' => $record['id'],
                    'nomor_kasus' => $record['nomor_kasus'] ?: '-',
                    'judul_kasus' => $record['judul_kasus'],
                    'jenis_kasus_nama' => $record['jenis_kasus_nama'] ?: '-',
                    'pelapor_nama' => $record['pelapor_nama'] ?: '-',
                    'tanggal_kejadian' => $tanggalKejadian,
                    'status' => '<span class="badge ' . $statusClass . '">' . ucfirst(str_replace('_', ' ', $record['status'])) . '</span>',
                    'actions' => '<a href="' . base_url('laporan-kasus/detail/' . $record['id']) . '" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                  </a>'
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController getMonthlyData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function printMonthly()
    {
        $request = service('request');
        $user = session()->get('user_data');
        $role = session()->get('role');

        // Get filter parameters
        $bulan = $request->getGet('bulan');
        $tahun = $request->getGet('tahun');

        // Build query with filters
        $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.telepon as pelapor_telepon')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

        // Apply month/year filters
        if ($bulan && $tahun) {
            $builder->where('MONTH(kasus.tanggal_kejadian)', $bulan)
                ->where('YEAR(kasus.tanggal_kejadian)', $tahun);
        } elseif ($tahun) {
            $builder->where('YEAR(kasus.tanggal_kejadian)', $tahun);
        }

        $kasusData = $builder->orderBy('kasus.tanggal_kejadian', 'DESC')->findAll();

        // Generate statistics
        $totalKasus = count($kasusData);
        $statusStats = [];
        $jenisStats = [];

        foreach ($kasusData as $kasus) {
            // Count by status
            $statusStats[$kasus['status']] = ($statusStats[$kasus['status']] ?? 0) + 1;

            // Count by jenis
            $jenisName = $kasus['jenis_kasus_nama'] ?: 'Tidak Dikategorikan';
            $jenisStats[$jenisName] = ($jenisStats[$jenisName] ?? 0) + 1;
        }

        // Get month name
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $data = [
            'title' => 'Laporan Kasus Per Bulan',
            'user' => $user,
            'role' => $role,
            'kasusData' => $kasusData,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulanNama' => $bulan ? $monthNames[$bulan] : null,
            'totalKasus' => $totalKasus,
            'statusStats' => $statusStats,
            'jenisStats' => $jenisStats,
            'isPrint' => true
        ];

        return view('laporan_kasus/print_monthly', $data);
    }

    public function yearly()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Kasus Per Tahun',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_kasus/yearly', $data);
    }

    public function getYearlyData()
    {
        $request = service('request');

        // Get filter parameters
        $tahun = $request->getGet('tahun');

        try {
            // Build query with filters
            $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama')
                ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

            // Apply year filter
            if ($tahun) {
                $builder->where('YEAR(kasus.tanggal_kejadian)', $tahun);
            }

            $kasusData = $builder->findAll();

            // Group data by month
            $monthlyData = [];
            $monthNames = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];

            // Initialize all months
            for ($i = 1; $i <= 12; $i++) {
                $monthlyData[$i] = [
                    'bulan' => $monthNames[$i],
                    'total' => 0,
                    'dilaporkan' => 0,
                    'dalam_proses' => 0,
                    'selesai' => 0,
                    'ditutup' => 0
                ];
            }

            foreach ($kasusData as $kasus) {
                $bulan = (int) date('n', strtotime($kasus['tanggal_kejadian']));
                $monthlyData[$bulan]['total']++;
                $monthlyData[$bulan][$kasus['status']]++;
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => array_values($monthlyData),
                'tahun' => $tahun
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanKasusController getYearlyData: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function printYearly()
    {
        $request = service('request');
        $user = session()->get('user_data');
        $role = session()->get('role');

        // Get filter parameters
        $tahun = $request->getGet('tahun');

        // Build query with filters
        $builder = $this->kasusModel->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

        // Apply year filter
        if ($tahun) {
            $builder->where('YEAR(kasus.tanggal_kejadian)', $tahun);
        }

        $kasusData = $builder->orderBy('kasus.tanggal_kejadian', 'DESC')->findAll();

        // Generate monthly statistics
        $monthlyStats = [];
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Initialize all months
        for ($i = 1; $i <= 12; $i++) {
            $monthlyStats[$i] = [
                'bulan' => $monthNames[$i],
                'total' => 0,
                'dilaporkan' => 0,
                'dalam_proses' => 0,
                'selesai' => 0,
                'ditutup' => 0
            ];
        }

        $totalKasus = count($kasusData);
        $statusStats = [];
        $jenisStats = [];

        foreach ($kasusData as $kasus) {
            $bulan = (int) date('n', strtotime($kasus['tanggal_kejadian']));

            // Monthly stats
            $monthlyStats[$bulan]['total']++;
            $monthlyStats[$bulan][$kasus['status']]++;

            // Overall stats
            $statusStats[$kasus['status']] = ($statusStats[$kasus['status']] ?? 0) + 1;
            $jenisName = $kasus['jenis_kasus_nama'] ?: 'Tidak Dikategorikan';
            $jenisStats[$jenisName] = ($jenisStats[$jenisName] ?? 0) + 1;
        }

        $data = [
            'title' => 'Laporan Kasus Per Tahun',
            'user' => $user,
            'role' => $role,
            'kasusData' => $kasusData,
            'tahun' => $tahun,
            'monthlyStats' => $monthlyStats,
            'totalKasus' => $totalKasus,
            'statusStats' => $statusStats,
            'jenisStats' => $jenisStats,
            'isPrint' => true
        ];

        return view('laporan_kasus/print_yearly', $data);
    }
}
