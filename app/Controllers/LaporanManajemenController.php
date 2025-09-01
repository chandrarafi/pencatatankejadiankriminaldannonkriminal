<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasusModel;
use App\Models\PelaporModel;
use App\Models\KorbanModel;
use App\Models\TersangkaModel;
use App\Models\SaksiModel;
use App\Models\AnggotaModel;
use App\Models\JenisKasusModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanManajemenController extends BaseController
{
    protected $kasusModel;
    protected $pelaporModel;
    protected $korbanModel;
    protected $tersangkaModel;
    protected $saksiModel;
    protected $anggotaModel;
    protected $jenisKasusModel;
    protected $session;

    public function __construct()
    {
        $this->kasusModel = new KasusModel();
        $this->pelaporModel = new PelaporModel();
        $this->korbanModel = new KorbanModel();
        $this->tersangkaModel = new TersangkaModel();
        $this->saksiModel = new SaksiModel();
        $this->anggotaModel = new AnggotaModel();
        $this->jenisKasusModel = new JenisKasusModel();
        $this->session = \Config\Services::session();
    }

    // ==================== DASHBOARD KAPOLSEK ====================
    public function dashboardKapolsek()
    {
        // Check login and role
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['kapolsek', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        // Get statistics
        $currentYear = date('Y');
        $currentMonth = date('Y-m');

        // Total cases
        $totalKasus = $this->kasusModel->countAll();
        $kasusThisMonth = $this->kasusModel->where('DATE_FORMAT(created_at, "%Y-%m")', $currentMonth)->countAllResults();
        $kasusThisYear = $this->kasusModel->where('YEAR(created_at)', $currentYear)->countAllResults();

        // Status distribution
        $statusStats = [
            'dilaporkan' => $this->kasusModel->where('status', 'dilaporkan')->countAllResults(),
            'dalam_proses' => $this->kasusModel->where('status', 'dalam_proses')->countAllResults(),
            'selesai' => $this->kasusModel->where('status', 'selesai')->countAllResults(),
            'ditutup' => $this->kasusModel->where('status', 'ditutup')->countAllResults(),
        ];

        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i month"));
            $monthLabel = date('M Y', strtotime("-$i month"));
            $count = $this->kasusModel->where('DATE_FORMAT(created_at, "%Y-%m")', $month)->countAllResults();
            $monthlyTrend[] = ['month' => $monthLabel, 'count' => $count];
        }

        // Case type distribution
        $jenisKasusStats = $this->kasusModel
            ->select('jenis_kasus.nama_jenis, COUNT(*) as jumlah')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->groupBy('kasus.jenis_kasus_id')
            ->orderBy('jumlah', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        // Performance metrics
        $clearanceRate = $totalKasus > 0 ? round((($statusStats['selesai'] + $statusStats['ditutup']) / $totalKasus) * 100, 2) : 0;

        // Average case processing time
        $avgProcessingTime = $this->kasusModel
            ->selectAvg('DATEDIFF(updated_at, created_at)', 'avg_days')
            ->where('status', 'selesai')
            ->get()
            ->getRow();

        $data = [
            'title' => 'Dashboard Eksekutif - KAPOLSEK',
            'user' => $this->session->get(),
            'role' => $role,
            'totalKasus' => $totalKasus,
            'kasusThisMonth' => $kasusThisMonth,
            'kasusThisYear' => $kasusThisYear,
            'statusStats' => $statusStats,
            'monthlyTrend' => $monthlyTrend,
            'jenisKasusStats' => $jenisKasusStats,
            'clearanceRate' => $clearanceRate,
            'avgProcessingTime' => $avgProcessingTime->avg_days ? round($avgProcessingTime->avg_days, 1) : 0,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Dashboard Eksekutif', 'url' => '']
            ]
        ];

        return view('laporan_manajemen/dashboard_kapolsek', $data);
    }

    // ==================== LAPORAN KINERJA UNIT ====================
    public function kinerjaUnit()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['kapolsek', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        // Unit performance data
        $units = ['SPKT', 'RESKRIM', 'KASIUM'];
        $unitStats = [];

        foreach ($units as $unit) {
            $unitStats[$unit] = [
                'total_anggota' => $this->anggotaModel->where('unit_kerja', $unit)->countAllResults(),
                'kasus_ditangani' => 0, // Will be calculated based on role
                'tingkat_penyelesaian' => 0
            ];
        }

        // SPKT Performance (cases received)
        $spktCases = $this->kasusModel->countAll();
        $unitStats['SPKT']['kasus_ditangani'] = $spktCases;

        // RESKRIM Performance (cases processed)
        $reskrimCases = $this->kasusModel->where('status !=', 'dilaporkan')->countAllResults();
        $unitStats['RESKRIM']['kasus_ditangani'] = $reskrimCases;

        // Calculate completion rates
        foreach ($units as $unit) {
            if ($unitStats[$unit]['kasus_ditangani'] > 0) {
                $completed = $this->kasusModel->whereIn('status', ['selesai', 'ditutup'])->countAllResults();
                $unitStats[$unit]['tingkat_penyelesaian'] = round(($completed / $unitStats[$unit]['kasus_ditangani']) * 100, 2);
            }
        }

        $data = [
            'title' => 'Laporan Kinerja Unit',
            'user' => $this->session->get(),
            'role' => $role,
            'unitStats' => $unitStats,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('laporan_manajemen/kinerja_unit', $data);
    }

    // ==================== DASHBOARD RESKRIM ====================
    public function dashboardReskrim()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['reskrim', 'kasium', 'kapolsek'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        // Investigation statistics
        $totalInvestigasi = $this->kasusModel->where('status !=', 'dilaporkan')->countAllResults();
        $ongoingInvestigasi = $this->kasusModel->where('status', 'dalam_proses')->countAllResults();
        $completedInvestigasi = $this->kasusModel->where('status', 'selesai')->countAllResults();

        // Evidence and persons statistics
        $totalKorban = $this->korbanModel->countAll();
        $totalTersangka = $this->tersangkaModel->countAll();
        $totalSaksi = $this->saksiModel->countAll();

        // Case workload by investigator (mock data - would need user assignment)
        $investigatorWorkload = [
            ['nama' => 'Investigator A', 'active_cases' => 5, 'completed_cases' => 12],
            ['nama' => 'Investigator B', 'active_cases' => 3, 'completed_cases' => 8],
            ['nama' => 'Investigator C', 'active_cases' => 7, 'completed_cases' => 15],
        ];

        // Recent activities
        $recentActivities = $this->kasusModel
            ->select('kasus.*, jenis_kasus.nama_jenis')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->where('kasus.status !=', 'dilaporkan')
            ->orderBy('kasus.updated_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        // Case priority distribution
        $priorityStats = [
            'tinggi' => $this->kasusModel->where('prioritas', 'tinggi')->where('status', 'dalam_proses')->countAllResults(),
            'sedang' => $this->kasusModel->where('prioritas', 'sedang')->where('status', 'dalam_proses')->countAllResults(),
            'rendah' => $this->kasusModel->where('prioritas', 'rendah')->where('status', 'dalam_proses')->countAllResults(),
        ];

        $data = [
            'title' => 'Dashboard Investigasi - RESKRIM',
            'user' => $this->session->get(),
            'role' => $role,
            'totalInvestigasi' => $totalInvestigasi,
            'ongoingInvestigasi' => $ongoingInvestigasi,
            'completedInvestigasi' => $completedInvestigasi,
            'totalKorban' => $totalKorban,
            'totalTersangka' => $totalTersangka,
            'totalSaksi' => $totalSaksi,
            'investigatorWorkload' => $investigatorWorkload,
            'recentActivities' => $recentActivities,
            'priorityStats' => $priorityStats,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Dashboard Investigasi', 'url' => '']
            ]
        ];

        return view('laporan_manajemen/dashboard_reskrim', $data);
    }

    // ==================== LAPORAN STATISTIK KRIMINALITAS ====================
    public function statistikKriminalitas()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['kapolsek', 'kasium', 'reskrim'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $tahun = $this->request->getGet('tahun') ?: date('Y');
        $bulan = $this->request->getGet('bulan') ?: '';

        // Crime statistics by type
        $crimeByType = $this->kasusModel
            ->select('jenis_kasus.nama_jenis, jenis_kasus.kode_jenis, COUNT(*) as jumlah')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->where('YEAR(kasus.created_at)', $tahun)
            ->groupBy('kasus.jenis_kasus_id')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        // Monthly distribution for the year
        $monthlyDistribution = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1));
            $count = $this->kasusModel
                ->where('YEAR(created_at)', $tahun)
                ->where('MONTH(created_at)', $m)
                ->countAllResults();
            $monthlyDistribution[] = ['month' => $monthName, 'count' => $count];
        }

        // Location-based statistics (simplified)
        $locationStats = $this->kasusModel
            ->select('lokasi_kejadian, COUNT(*) as jumlah')
            ->where('YEAR(created_at)', $tahun)
            ->where('lokasi_kejadian IS NOT NULL')
            ->where('lokasi_kejadian !=', '')
            ->groupBy('lokasi_kejadian')
            ->orderBy('jumlah', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        // Clearance rate by month
        $clearanceByMonth = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('M', mktime(0, 0, 0, $m, 1));
            $totalCases = $this->kasusModel
                ->where('YEAR(created_at)', $tahun)
                ->where('MONTH(created_at)', $m)
                ->countAllResults();

            $solvedCases = $this->kasusModel
                ->where('YEAR(created_at)', $tahun)
                ->where('MONTH(created_at)', $m)
                ->whereIn('status', ['selesai', 'ditutup'])
                ->countAllResults();

            $rate = $totalCases > 0 ? round(($solvedCases / $totalCases) * 100, 2) : 0;
            $clearanceByMonth[] = ['month' => $monthName, 'rate' => $rate];
        }

        $data = [
            'title' => 'Statistik Kriminalitas',
            'user' => $this->session->get(),
            'role' => $role,
            'tahun' => $tahun,
            'crimeByType' => $crimeByType,
            'monthlyDistribution' => $monthlyDistribution,
            'locationStats' => $locationStats,
            'clearanceByMonth' => $clearanceByMonth,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('laporan_manajemen/statistik_kriminalitas', $data);
    }

    // ==================== LAPORAN PROGRESS INVESTIGASI ====================
    public function progressInvestigasi()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['reskrim', 'kasium', 'kapolsek'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        // Cases in investigation
        $ongoingCases = $this->kasusModel
            ->select('kasus.*, jenis_kasus.nama_jenis, pelapor.nama as pelapor_nama')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
            ->where('kasus.status', 'dalam_proses')
            ->orderBy('kasus.created_at', 'ASC')
            ->get()
            ->getResultArray();

        // Add investigation progress details
        foreach ($ongoingCases as &$case) {
            $case['korban_count'] = $this->korbanModel->where('kasus_id', $case['id'])->countAllResults();
            $case['tersangka_count'] = $this->tersangkaModel->where('kasus_id', $case['id'])->countAllResults();
            $case['saksi_count'] = $this->saksiModel->where('kasus_id', $case['id'])->countAllResults();
            $case['days_in_progress'] = floor((time() - strtotime($case['created_at'])) / (60 * 60 * 24));

            // Calculate progress percentage
            $progress = 0;
            if ($case['korban_count'] > 0) $progress += 25;
            if ($case['tersangka_count'] > 0) $progress += 25;
            if ($case['saksi_count'] > 0) $progress += 25;
            if ($case['keterangan']) $progress += 25;
            $case['progress_percentage'] = $progress;
        }

        $data = [
            'title' => 'Progress Investigasi',
            'user' => $this->session->get(),
            'role' => $role,
            'ongoingCases' => $ongoingCases,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('laporan_manajemen/progress_investigasi', $data);
    }

    // ==================== API METHODS ====================
    public function getStatisticsData($type)
    {
        if (!$this->session->get('is_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            switch ($type) {
                case 'monthly-trend':
                    $data = [];
                    for ($i = 11; $i >= 0; $i--) {
                        $month = date('Y-m', strtotime("-$i month"));
                        $count = $this->kasusModel->where('DATE_FORMAT(created_at, "%Y-%m")', $month)->countAllResults();
                        $data[] = ['month' => date('M Y', strtotime("-$i month")), 'count' => $count];
                    }
                    break;

                case 'status-distribution':
                    $data = [
                        ['status' => 'Dilaporkan', 'count' => $this->kasusModel->where('status', 'dilaporkan')->countAllResults()],
                        ['status' => 'Dalam Proses', 'count' => $this->kasusModel->where('status', 'dalam_proses')->countAllResults()],
                        ['status' => 'Selesai', 'count' => $this->kasusModel->where('status', 'selesai')->countAllResults()],
                        ['status' => 'Ditutup', 'count' => $this->kasusModel->where('status', 'ditutup')->countAllResults()]
                    ];
                    break;

                case 'crime-types':
                    $data = $this->kasusModel
                        ->select('jenis_kasus.nama_jenis as name, COUNT(*) as count')
                        ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
                        ->groupBy('kasus.jenis_kasus_id')
                        ->orderBy('count', 'DESC')
                        ->limit(10)
                        ->get()
                        ->getResultArray();
                    break;

                default:
                    return $this->response->setJSON(['success' => false, 'message' => 'Invalid type']);
            }

            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanManajemenController::getStatisticsData: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}

