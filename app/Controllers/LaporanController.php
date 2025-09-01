<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasusModel;
use App\Models\PelaporModel;
use App\Models\KorbanModel;
use App\Models\TersangkaModel;
use App\Models\SaksiModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{
    protected $kasusModel;
    protected $pelaporModel;
    protected $korbanModel;
    protected $tersangkaModel;
    protected $saksiModel;
    protected $session;

    public function __construct()
    {
        $this->kasusModel = new KasusModel();
        $this->pelaporModel = new PelaporModel();
        $this->korbanModel = new KorbanModel();
        $this->tersangkaModel = new TersangkaModel();
        $this->saksiModel = new SaksiModel();
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
            'title' => 'Laporan Kasus',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Laporan Kasus', 'url' => '']
            ]
        ];

        return view('laporan/index', $data);
    }

    public function kasusLengkap($id = null)
    {
        // Check login
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }

        $role = $this->session->get('role');
        if (!in_array($role, ['spkt', 'reskrim', 'kasium'])) {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID kasus diperlukan');
        }

        // Get kasus with pelapor data
        $kasus = $this->kasusModel->getWithPelapor($id);
        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kasus tidak ditemukan');
        }

        // Get related parties
        $korbanList = $this->korbanModel->getByKasusId($id);
        $tersangkaList = $this->tersangkaModel->getByKasusId($id);
        $saksiList = $this->saksiModel->getByKasusId($id);

        $data = [
            'title' => 'Laporan Lengkap Kasus ' . $kasus['nomor_kasus'],
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'korbanList' => $korbanList,
            'tersangkaList' => $tersangkaList,
            'saksiList' => $saksiList,
            'isPrint' => $this->request->getGet('print') === '1',
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Laporan Kasus', 'url' => base_url('laporan')],
                ['title' => 'Detail Laporan', 'url' => '']
            ]
        ];

        return view('laporan/kasus_lengkap', $data);
    }

    public function getData()
    {
        // Check login
        if (!$this->session->get('is_logged_in')) {
            return $this->response->setJSON(['error' => 'Akses ditolak']);
        }

        try {
            $request = $this->request->getPost();

            $start = (int)($request['start'] ?? 0);
            $length = (int)($request['length'] ?? 10);
            $searchValue = $request['search']['value'] ?? '';

            // Get column for ordering
            $orderColumnIndex = (int)($request['order'][0]['column'] ?? 0);
            $orderDir = $request['order'][0]['dir'] ?? 'desc';

            $columns = ['nomor_kasus', 'judul_kasus', 'tanggal_kejadian', 'status', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->kasusModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                // Get counts
                $korbanCount = $this->korbanModel->where('kasus_id', $row['id'])->countAllResults();
                $tersangkaCount = $this->tersangkaModel->where('kasus_id', $row['id'])->countAllResults();
                $saksiCount = $this->saksiModel->where('kasus_id', $row['id'])->countAllResults();

                $statusBadge = '';
                $statusClass = [
                    'dilaporkan' => 'warning',
                    'dalam_proses' => 'info',
                    'selesai' => 'success',
                    'ditutup' => 'secondary'
                ];
                $statusText = [
                    'dilaporkan' => 'Dilaporkan',
                    'dalam_proses' => 'Dalam Proses',
                    'selesai' => 'Selesai',
                    'ditutup' => 'Ditutup'
                ];
                $badgeClass = $statusClass[$row['status']] ?? 'secondary';
                $statusLabel = $statusText[$row['status']] ?? ucfirst($row['status']);
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . $statusLabel . '</span>';

                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('laporan/kasus-lengkap/' . $row['id']) . '" 
                           class="btn btn-primary btn-sm" title="Laporan Lengkap">
                            <i class="fas fa-file-alt"></i>
                        </a>
                        <a href="' . base_url('laporan/kasus-lengkap/' . $row['id'] . '?print=1') . '" 
                           class="btn btn-info btn-sm" title="Print" target="_blank">
                            <i class="fas fa-print"></i>
                        </a>
                    </div>
                ';

                $data[] = [
                    'id' => $row['id'], // Add ID field for JavaScript functions
                    'nomor_kasus' => $row['nomor_kasus'],
                    'judul_kasus' => $row['judul_kasus'],
                    'tanggal_kejadian' => date('d/m/Y', strtotime($row['tanggal_kejadian'])),
                    'status' => $statusBadge,
                    'korban_count' => $korbanCount,
                    'tersangka_count' => $tersangkaCount,
                    'saksi_count' => $saksiCount,
                    'total_parties' => $korbanCount + $tersangkaCount + $saksiCount + 1, // +1 for pelapor
                    'created_at' => date('d/m/Y H:i', strtotime($row['created_at'])),
                    'actions' => $actions
                ];
            }

            return $this->response->setJSON([
                'draw' => intval($request['draw']),
                'recordsTotal' => $result['total'],
                'recordsFiltered' => $result['total'],
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanController::getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
