<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AnggotaModel;
use App\Models\PiketModel;
use App\Models\PiketDetailModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $session;
    protected $userModel;
    protected $anggotaModel;
    protected $piketModel;
    protected $piketDetailModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new UserModel();
        $this->anggotaModel = new AnggotaModel();
        $this->piketModel = new PiketModel();
        $this->piketDetailModel = new PiketDetailModel();
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $user = $this->session->get();
        $role = $user['role'];

        // Data untuk ditampilkan di dashboard berdasarkan role
        $data = [
            'title' => 'Dashboard ' . ucfirst($role),
            'user' => $user,
            'role' => $role
        ];

        // Load dashboard sesuai role
        switch ($role) {
            case 'spkt':
                return $this->dashboardSpkt($data);
            case 'kasium':
                return $this->dashboardKasium($data);
            case 'reskrim':
                return $this->dashboardReskrim($data);
            case 'kapolsek':
                return $this->dashboardKapolsek($data);
            default:
                return redirect()->to('/auth');
        }
    }

    /**
     * Dashboard untuk SPKT
     * Kelola data pelapor, kelola data jenis kasus, kelola data kasus, lihat data piket
     */
    private function dashboardSpkt($data)
    {
        // Statistik untuk SPKT
        $data['stats'] = [
            'total_kasus' => 0, // TODO: implement setelah tabel kasus dibuat
            'total_pelapor' => 0, // TODO: implement setelah tabel pelapor dibuat
            'total_jenis_kasus' => 0, // TODO: implement setelah tabel jenis_kasus dibuat
            'piket_hari_ini' => 0 // TODO: implement setelah tabel piket dibuat
        ];

        $data['menu_items'] = [
            'kelola_pelapor' => true,
            'kelola_jenis_kasus' => true,
            'kelola_kasus' => true,
            'lihat_piket' => true
        ];

        return view('dashboard/spkt', $data);
    }

    /**
     * Dashboard untuk Kasium
     * Kelola data anggota, kelola data piket
     */
    private function dashboardKasium($data)
    {
        // Get real statistics
        $anggotaStats = $this->anggotaModel->getStatistics();
        $piketStats = $this->piketModel->getStatistics();

        // Statistik untuk Kasium
        $data['stats'] = [
            'total_anggota' => $anggotaStats['total'] ?? 0,
            'anggota_aktif' => $anggotaStats['aktif'] ?? 0,
            'anggota_non_aktif' => $anggotaStats['non_aktif'] ?? 0,
            'total_piket' => $piketStats['total'] ?? 0,
            'piket_hari_ini' => $piketStats['hari_ini'] ?? 0,
            'piket_bulan_ini' => $piketStats['bulan_ini'] ?? 0,
            'piket_dijadwalkan' => $piketStats['dijadwalkan'] ?? 0,
            'piket_selesai' => $piketStats['selesai'] ?? 0
        ];

        // Get recent anggota
        $data['recent_anggota'] = $this->anggotaModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        // Get piket hari ini
        $data['piket_hari_ini'] = $this->piketModel->getPiketHariIni();

        // Get piket minggu ini (7 hari ke depan dari hari ini)
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+6 days'));
        $data['piket_minggu_ini'] = $this->piketModel->getPiketByWeek($startDate, $endDate);

        // Format jadwal piket per hari
        $jadwalHarian = [];
        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        for ($i = 0; $i < 7; $i++) {
            $tanggal = date('Y-m-d', strtotime("+$i days"));
            $hari = $namaHari[date('w', strtotime($tanggal))];

            $jadwalHarian[$hari] = [
                'tanggal' => $tanggal,
                'pagi' => [],
                'siang' => [],
                'malam' => []
            ];
        }

        // Group piket by hari dan shift
        foreach ($data['piket_minggu_ini'] as $piket) {
            $hari = $namaHari[date('w', strtotime($piket['tanggal_piket']))];
            $shift = $piket['shift'];

            if (isset($jadwalHarian[$hari])) {
                // Get anggota untuk piket ini
                $anggotaPiket = $this->piketDetailModel->getPiketDetailWithAnggota($piket['id']);
                $piket['anggota'] = $anggotaPiket;
                $jadwalHarian[$hari][$shift][] = $piket;
            }
        }

        $data['jadwal_harian'] = $jadwalHarian;

        $data['menu_items'] = [
            'kelola_anggota' => true,
            'kelola_piket' => true
        ];

        return view('dashboard/kasium', $data);
    }

    /**
     * Dashboard untuk Reskrim
     * Lihat data kasus, kelola data korban, kelola data tersangka, kelola data saksi, 
     * lihat data pelapor, lihat data piket, lihat semua laporan
     */
    private function dashboardReskrim($data)
    {
        // Statistik untuk Reskrim
        $data['stats'] = [
            'total_kasus' => 0,
            'total_tersangka' => 0,
            'total_korban' => 0,
            'total_saksi' => 0,
            'laporan_bulan_ini' => 0
        ];

        $data['menu_items'] = [
            'lihat_kasus' => true,
            'kelola_korban' => true,
            'kelola_tersangka' => true,
            'kelola_saksi' => true,
            'lihat_pelapor' => true,
            'lihat_piket' => true,
            'lihat_semua_laporan' => true
        ];

        return view('dashboard/reskrim', $data);
    }

    /**
     * Dashboard untuk Kapolsek
     * Lihat semua laporan
     */
    private function dashboardKapolsek($data)
    {
        // Statistik untuk Kapolsek
        $data['stats'] = [
            'total_laporan' => 0,
            'laporan_selesai' => 0,
            'laporan_proses' => 0,
            'laporan_pending' => 0
        ];

        $data['menu_items'] = [
            'lihat_semua_laporan' => true
        ];

        return view('dashboard/kapolsek', $data);
    }
}
