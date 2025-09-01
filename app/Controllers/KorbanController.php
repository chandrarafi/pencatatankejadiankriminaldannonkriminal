<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KorbanModel;
use App\Models\KasusModel;
use CodeIgniter\HTTP\ResponseInterface;

class KorbanController extends BaseController
{
    protected $korbanModel;
    protected $kasusModel;
    protected $session;

    public function __construct()
    {
        $this->korbanModel = new KorbanModel();
        $this->kasusModel = new KasusModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Data Korban',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Korban', 'url' => '']
            ]
        ];

        return view('reskrim/korban/index', $data);
    }

    public function getData()
    {
        try {
            // Check role access
            if ($this->session->get('role') !== 'reskrim') {
                return $this->response->setJSON(['error' => 'Akses ditolak']);
            }

            $request = $this->request->getPost();

            $start = (int)($request['start'] ?? 0);
            $length = (int)($request['length'] ?? 10);
            $searchValue = $request['search']['value'] ?? '';

            // Get column for ordering
            $orderColumnIndex = (int)($request['order'][0]['column'] ?? 0);
            $orderDir = $request['order'][0]['dir'] ?? 'desc';

            $columns = ['nik', 'nama', 'jenis_kelamin', 'umur', 'status_korban', 'nomor_kasus', 'judul_kasus', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->korbanModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                $statusBadge = '';
                $statusClass = [
                    'hidup' => 'success',
                    'meninggal' => 'danger',
                    'hilang' => 'warning',
                    'luka' => 'info'
                ];
                $statusText = [
                    'hidup' => 'Hidup',
                    'meninggal' => 'Meninggal',
                    'hilang' => 'Hilang',
                    'luka' => 'Luka'
                ];
                $badgeClass = $statusClass[$row['status_korban']] ?? 'secondary';
                $statusLabel = $statusText[$row['status_korban']] ?? ucfirst($row['status_korban']);
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . $statusLabel . '</span>';

                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('reskrim/korban/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . base_url('reskrim/korban/edit/' . $row['id']) . '" 
                           class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                data-id="' . $row['id'] . '" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';

                $data[] = [
                    'nik' => $row['nik'] ?: '-',
                    'nama' => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan',
                    'umur' => $row['umur'] ?: '-',
                    'status_korban' => $statusBadge,
                    'nomor_kasus' => $row['nomor_kasus'] ?: '-',
                    'judul_kasus' => $row['judul_kasus'] ?: '-',
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
            log_message('error', 'Error in KorbanController::getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Tambah Data Korban',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Korban', 'url' => base_url('reskrim/korban')],
                ['title' => 'Tambah Data', 'url' => '']
            ]
        ];

        return view('reskrim/korban/create', $data);
    }

    public function storeAjax()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $data = $this->request->getPost();

            if ($this->korbanModel->save($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data korban berhasil disimpan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi Gagal!',
                    'errors' => $this->korbanModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $korban = $this->korbanModel->getWithKasus($id);

        if (!$korban) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data korban tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Korban',
            'user' => $this->session->get(),
            'role' => $role,
            'korban' => $korban,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Korban', 'url' => base_url('reskrim/korban')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/korban/show', $data);
    }

    public function edit($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $korban = $this->korbanModel->find($id);

        if (!$korban) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data korban tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Korban',
            'user' => $this->session->get(),
            'role' => $role,
            'korban' => $korban,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Korban', 'url' => base_url('reskrim/korban')],
                ['title' => 'Edit Data', 'url' => '']
            ]
        ];

        return view('reskrim/korban/edit', $data);
    }

    public function updateAjax($id)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $data = $this->request->getPost();

            if ($this->korbanModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data korban berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi Gagal!',
                    'errors' => $this->korbanModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteAjax($id)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            if ($this->korbanModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data korban berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data korban tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function getById($id)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['error' => 'Akses ditolak']);
        }

        $korban = $this->korbanModel->find($id);

        if ($korban) {
            return $this->response->setJSON(['success' => true, 'data' => $korban]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }

    public function search()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['error' => 'Akses ditolak']);
        }

        $searchTerm = $this->request->getPost('search');

        $korbanList = $this->korbanModel->like('nama', $searchTerm)
            ->orLike('nik', $searchTerm)
            ->limit(10)
            ->findAll();

        $results = [];
        foreach ($korbanList as $korban) {
            $results[] = [
                'id' => $korban['id'],
                'text' => $korban['nama'] . ' (' . ($korban['nik'] ?: 'NIK tidak ada') . ')'
            ];
        }

        return $this->response->setJSON(['results' => $results]);
    }

    public function getKasusData()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            // Get kasus data with pelapor information
            $kasusData = $this->kasusModel
                ->select('kasus.*, pelapor.nama as pelapor_nama')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
                ->where('kasus.status !=', 'batal')
                ->orderBy('kasus.created_at', 'DESC')
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $kasusData
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in KorbanController::getKasusData: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kasus'
            ]);
        }
    }

    public function getByKasus($kasusId)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $korbanData = $this->korbanModel->getByKasusId($kasusId);
            return $this->response->setJSON(['success' => true, 'data' => $korbanData]);
        } catch (\Exception $e) {
            log_message('error', 'Error in KorbanController::getByKasus: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}
