<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasusModel;
use App\Models\PelaporModel;
use App\Models\KorbanModel;
use App\Models\TersangkaModel;
use App\Models\SaksiModel;
use App\Models\AnggotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class SuratController extends BaseController
{
    protected $kasusModel;
    protected $pelaporModel;
    protected $korbanModel;
    protected $tersangkaModel;
    protected $saksiModel;
    protected $anggotaModel;
    protected $session;

    public function __construct()
    {
        $this->kasusModel = new KasusModel();
        $this->pelaporModel = new PelaporModel();
        $this->korbanModel = new KorbanModel();
        $this->tersangkaModel = new TersangkaModel();
        $this->saksiModel = new SaksiModel();
        $this->anggotaModel = new AnggotaModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Check login
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['spkt', 'reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Sistem Surat & Laporan',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Surat & Laporan', 'url' => '']
            ]
        ];

        return view('surat/index', $data);
    }

    // ==================== LAPORAN POLISI (LP) ====================
    public function laporanPolisi($kasusId = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['spkt', 'reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        if (!$kasusId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus diperlukan');
        }

        // Get kasus with pelapor data
        $kasus = $this->kasusModel->getWithPelapor($kasusId);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        // Generate nomor LP
        $nomorLP = 'LP/' . str_replace('/', '/LP/', $kasus['nomor_kasus']) . '/' . date('Y');

        $data = [
            'title' => 'Laporan Polisi (LP)',
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'nomorLP' => $nomorLP,
            'tanggalLP' => date('d F Y'),
            'jamLP' => date('H:i') . ' WIB',
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/laporan_polisi', $data);
    }

    // ==================== BERITA ACARA PEMERIKSAAN (BAP) ====================
    public function beritaAcaraPemeriksaan($kasusId = null, $type = 'saksi', $personId = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Hanya RESKRIM yang dapat membuat BAP');
        }

        if (!$kasusId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus diperlukan');
        }

        // Get kasus data
        $kasus = $this->kasusModel->getWithPelapor($kasusId);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        // Get person data based on type
        $person = null;
        $personTitle = '';
        switch ($type) {
            case 'saksi':
                if ($personId) {
                    $person = $this->saksiModel->getWithKasus($personId);
                }
                $personTitle = 'Saksi';
                break;
            case 'tersangka':
                if ($personId) {
                    $person = $this->tersangkaModel->getWithKasus($personId);
                }
                $personTitle = 'Tersangka';
                break;
            case 'korban':
                if ($personId) {
                    $person = $this->korbanModel->getWithKasus($personId);
                }
                $personTitle = 'Korban';
                break;
        }

        // Generate nomor BAP
        $nomorBAP = 'BAP/' . strtoupper($type) . '/' . str_replace('/', '/', $kasus['nomor_kasus']) . '/' . date('Y');

        // Get pemeriksa (current user as investigator)
        $pemeriksa = $this->anggotaModel->find($this->session->get('user_id'));

        $data = [
            'title' => 'Berita Acara Pemeriksaan ' . $personTitle,
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'person' => $person,
            'personType' => $type,
            'personTitle' => $personTitle,
            'nomorBAP' => $nomorBAP,
            'tanggalBAP' => date('d F Y'),
            'jamBAP' => date('H:i') . ' WIB',
            'pemeriksa' => $pemeriksa,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/berita_acara_pemeriksaan', $data);
    }

    // ==================== SURAT PANGGILAN ====================
    public function suratPanggilan($kasusId = null, $type = 'saksi', $personId = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Hanya RESKRIM yang dapat membuat surat panggilan');
        }

        if (!$kasusId || !$personId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus dan person diperlukan');
        }

        // Get kasus data
        $kasus = $this->kasusModel->getWithPelapor($kasusId);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        // Get person data based on type
        $person = null;
        $personTitle = '';
        switch ($type) {
            case 'saksi':
                $person = $this->saksiModel->getWithKasus($personId);
                $personTitle = 'Saksi';
                break;
            case 'tersangka':
                $person = $this->tersangkaModel->getWithKasus($personId);
                $personTitle = 'Tersangka';
                break;
            case 'korban':
                $person = $this->korbanModel->getWithKasus($personId);
                $personTitle = 'Korban';
                break;
        }

        if (!$person) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $personTitle . ' tidak ditemukan');
        }

        // Generate nomor surat
        $nomorSurat = 'SP/' . strtoupper($type) . '/' . str_replace('/', '/', $kasus['nomor_kasus']) . '/' . date('Y');

        // Get penandatangan (current user or kapolsek)
        $penandatangan = $this->anggotaModel->find($this->session->get('user_id'));

        $data = [
            'title' => 'Surat Panggilan ' . $personTitle,
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'person' => $person,
            'personType' => $type,
            'personTitle' => $personTitle,
            'nomorSurat' => $nomorSurat,
            'tanggalSurat' => date('d F Y'),
            'penandatangan' => $penandatangan,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/surat_panggilan', $data);
    }

    // ==================== RESUME KASUS ====================
    public function resumeKasus($kasusId = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        if (!$kasusId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus diperlukan');
        }

        // Get kasus with all related data
        $kasus = $this->kasusModel->getWithPelapor($kasusId);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        $korbanList = $this->korbanModel->getByKasusId($kasusId);
        $tersangkaList = $this->tersangkaModel->getByKasusId($kasusId);
        $saksiList = $this->saksiModel->getByKasusId($kasusId);

        // Generate nomor resume
        $nomorResume = 'RESUME/' . str_replace('/', '/', $kasus['nomor_kasus']) . '/' . date('Y');

        // Get pembuat resume (current user)
        $pembuat = $this->anggotaModel->find($this->session->get('user_id'));

        $data = [
            'title' => 'Resume Kasus',
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'korbanList' => $korbanList,
            'tersangkaList' => $tersangkaList,
            'saksiList' => $saksiList,
            'nomorResume' => $nomorResume,
            'tanggalResume' => date('d F Y'),
            'pembuat' => $pembuat,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/resume_kasus', $data);
    }

    // ==================== SURAT KETERANGAN ====================
    public function suratKeterangan($kasusId = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['spkt', 'reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        if (!$kasusId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus diperlukan');
        }

        // Get kasus data
        $kasus = $this->kasusModel->getWithPelapor($kasusId);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        // Generate nomor surat keterangan
        $nomorSurat = 'SKET/' . str_replace('/', '/', $kasus['nomor_kasus']) . '/' . date('Y');

        // Get penandatangan
        $penandatangan = $this->anggotaModel->find($this->session->get('user_id'));

        $data = [
            'title' => 'Surat Keterangan',
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'nomorSurat' => $nomorSurat,
            'tanggalSurat' => date('d F Y'),
            'penandatangan' => $penandatangan,
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/surat_keterangan', $data);
    }

    // ==================== LAPORAN HARIAN ====================
    public function laporanHarian($tanggal = null)
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['kasium', 'kapolsek'])) {
            return redirect()->to('/auth')->with('error', 'Hanya KASIUM yang dapat mengakses laporan harian');
        }

        $tanggal = $tanggal ?: date('Y-m-d');

        // Get data statistik untuk tanggal tertentu
        $kasusHarian = $this->kasusModel
            ->where('DATE(created_at)', $tanggal)
            ->findAll();

        $kasusSelesaiHarian = $this->kasusModel
            ->where('DATE(updated_at)', $tanggal)
            ->where('status', 'selesai')
            ->findAll();

        $data = [
            'title' => 'Laporan Harian',
            'user' => $this->session->get(),
            'role' => $role,
            'tanggal' => $tanggal,
            'tanggalFormat' => date('d F Y', strtotime($tanggal)),
            'kasusHarian' => $kasusHarian,
            'kasusSelesaiHarian' => $kasusSelesaiHarian,
            'totalKasusBaru' => count($kasusHarian),
            'totalKasusSelesai' => count($kasusSelesaiHarian),
            'isPrint' => $this->request->getGet('print') === '1'
        ];

        return view('surat/laporan_harian', $data);
    }

    // ==================== API METHOD ====================
    public function getPersons($kasusId)
    {
        if (!$this->session->get('is_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $korbanList = $this->korbanModel->getByKasusId($kasusId);
            $tersangkaList = $this->tersangkaModel->getByKasusId($kasusId);
            $saksiList = $this->saksiModel->getByKasusId($kasusId);

            return $this->response->setJSON([
                'success' => true,
                'korban' => $korbanList,
                'tersangka' => $tersangkaList,
                'saksi' => $saksiList
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in SuratController::getPersons: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}
