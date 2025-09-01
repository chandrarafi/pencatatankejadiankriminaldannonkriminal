<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasusModel;
use App\Models\PelaporModel;
use App\Models\PiketModel;
use CodeIgniter\HTTP\ResponseInterface;

class ReskrimController extends BaseController
{
    protected $kasusModel;
    protected $pelaporModel;
    protected $piketModel;
    protected $session;

    public function __construct()
    {
        $this->kasusModel = new KasusModel();
        $this->pelaporModel = new PelaporModel();
        $this->piketModel = new PiketModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        //
    }

    // KASUS MANAGEMENT (READ-ONLY ACCESS)
    public function kasus()
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Data Kasus',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Kasus', 'url' => '']
            ]
        ];

        return view('reskrim/kasus/index', $data);
    }

    public function getKasusData()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
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

            $columns = ['nomor_kasus', 'judul_kasus', 'tanggal_kejadian', 'status', 'pelapor_nama', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->kasusModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
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
                        <a href="' . base_url('reskrim/kasus/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                ';

                $data[] = [
                    'nomor_kasus' => $row['nomor_kasus'],
                    'judul_kasus' => $row['judul_kasus'],
                    'tanggal_kejadian' => date('d/m/Y', strtotime($row['tanggal_kejadian'])),
                    'status' => $statusBadge,
                    'pelapor_nama' => $row['pelapor_nama'] ?: '-',
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
            log_message('error', 'Error in ReskrimController::getKasusData: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function showKasus($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $kasus = $this->kasusModel->getWithPelapor($id);

        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kasus tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Kasus',
            'user' => $this->session->get(),
            'role' => $role,
            'kasus' => $kasus,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Kasus', 'url' => base_url('reskrim/kasus')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/kasus/show', $data);
    }

    public function updateKasusStatus($id)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        try {
            $kasus = $this->kasusModel->find($id);
            if (!$kasus) {
                return $this->response->setJSON(['success' => false, 'message' => 'Kasus tidak ditemukan']);
            }

            $newStatus = $this->request->getPost('status');
            $keterangan = $this->request->getPost('keterangan');

            // Validate status
            $allowedStatuses = ['dalam_proses', 'selesai', 'ditutup'];
            if (!in_array($newStatus, $allowedStatuses)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
            }

            $updateData = [
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($keterangan) {
                $updateData['keterangan'] = $keterangan;
            }

            if ($this->kasusModel->update($id, $updateData)) {
                // Log status change
                log_message('info', "RESKRIM updated case {$kasus['nomor_kasus']} status from {$kasus['status']} to {$newStatus} by user {$this->session->get('user_id')}");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status kasus berhasil diperbarui',
                    'new_status' => $newStatus
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status kasus']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in ReskrimController::updateKasusStatus: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // PELAPOR MANAGEMENT (READ-ONLY ACCESS)
    public function pelapor()
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Data Pelapor',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Pelapor', 'url' => '']
            ]
        ];

        return view('reskrim/pelapor/index', $data);
    }

    public function getPelaporData()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
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

            $columns = ['nama', 'nik', 'telepon', 'alamat', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->pelaporModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                $statusBadge = '';
                if ($row['is_active'] == 1) {
                    $statusBadge = '<span class="badge badge-success">Aktif</span>';
                } else {
                    $statusBadge = '<span class="badge badge-secondary">Nonaktif</span>';
                }

                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('reskrim/pelapor/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                ';

                $data[] = [
                    'nama' => $row['nama'],
                    'nik' => $row['nik'] ?: '-',
                    'telepon' => $row['telepon'] ?: '-',
                    'alamat' => strlen($row['alamat']) > 50 ? substr($row['alamat'], 0, 50) . '...' : $row['alamat'],
                    'status' => $statusBadge,
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
            log_message('error', 'Error in ReskrimController::getPelaporData: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function showPelapor($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $pelapor = $this->pelaporModel->find($id);

        if (!$pelapor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pelapor tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Pelapor',
            'user' => $this->session->get(),
            'role' => $role,
            'pelapor' => $pelapor,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Pelapor', 'url' => base_url('reskrim/pelapor')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/pelapor/show', $data);
    }

    public function searchPelapor()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['error' => 'Akses ditolak']);
        }

        try {
            $search = $this->request->getGet('search');

            $pelaporList = $this->pelaporModel
                ->groupStart()
                ->like('nama', $search)
                ->orLike('nik', $search)
                ->orLike('telepon', $search)
                ->groupEnd()
                ->where('is_active', 1)
                ->orderBy('nama', 'ASC')
                ->limit(20)
                ->findAll();

            return $this->response->setJSON($pelaporList);
        } catch (\Exception $e) {
            log_message('error', 'Error in ReskrimController::searchPelapor: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // PIKET MANAGEMENT (READ-ONLY ACCESS)
    public function piket()
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Data Piket',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Piket', 'url' => '']
            ]
        ];

        return view('reskrim/piket/index', $data);
    }

    public function getPiketData()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
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

            $result = $this->piketModel->getPiketForDataTable($searchValue, $start, $length, $orderColumnIndex, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                // Status badge
                $statusBadge = '';
                $statusClass = [
                    'draft' => 'secondary',
                    'aktif' => 'success',
                    'selesai' => 'primary',
                    'dibatalkan' => 'danger'
                ];
                $statusText = [
                    'draft' => 'Draft',
                    'aktif' => 'Aktif',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan'
                ];
                $badgeClass = $statusClass[$row['status']] ?? 'secondary';
                $statusLabel = $statusText[$row['status']] ?? ucfirst($row['status']);
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . $statusLabel . '</span>';

                // Shift badge
                $shiftBadge = '';
                $shiftClass = [
                    'pagi' => 'info',
                    'siang' => 'warning',
                    'malam' => 'dark'
                ];
                $badgeClassShift = $shiftClass[strtolower($row['shift'])] ?? 'secondary';
                $shiftBadge = '<span class="badge badge-' . $badgeClassShift . '">' . ucfirst($row['shift']) . '</span>';

                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('reskrim/piket/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                ';

                $data[] = [
                    'tanggal_piket' => date('d/m/Y', strtotime($row['tanggal_piket'])),
                    'shift' => $shiftBadge,
                    'lokasi_piket' => $row['lokasi_piket'] ?: '-',
                    'anggota_list' => $row['anggota_list'] ?: '-',
                    'status' => $statusBadge,
                    'created_at' => date('d/m/Y H:i', strtotime($row['created_at'])),
                    'actions' => $actions
                ];
            }

            return $this->response->setJSON([
                'draw' => intval($request['draw']),
                'recordsTotal' => $result['recordsTotal'],
                'recordsFiltered' => $result['recordsFiltered'],
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in ReskrimController::getPiketData: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function showPiket($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $piket = $this->piketModel->find($id);

        if (!$piket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data piket tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Piket',
            'user' => $this->session->get(),
            'role' => $role,
            'piket' => $piket,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Piket', 'url' => base_url('reskrim/piket')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/piket/show', $data);
    }
}
