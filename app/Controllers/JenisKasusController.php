<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisKasusModel;
use CodeIgniter\HTTP\ResponseInterface;

class JenisKasusController extends BaseController
{
    protected $jenisKasusModel;
    protected $session;

    public function __construct()
    {
        $this->jenisKasusModel = new JenisKasusModel();
        $this->session = \Config\Services::session();

        // Check if user is logged in
        if (!$this->session->get('is_logged_in')) {
            redirect()->to(base_url('auth'))->send();
            exit;
        }

        // Check if user has SPKT role
        if ($this->session->get('role') !== 'spkt') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    /**
     * Display jenis kasus list
     */
    public function index()
    {
        $data = [
            'title' => 'Kelola Jenis Kasus',
            'page' => 'jenis_kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Jenis Kasus' => ''
            ]
        ];

        return view('spkt/jenis_kasus/index', $data);
    }

    /**
     * Get data for DataTables (AJAX)
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDir = $this->request->getPost('order')[0]['dir'] ?? 'asc';

        $result = $this->jenisKasusModel->getJenisKasusForDataTable(
            $searchValue,
            $start,
            $length,
            $orderColumnIndex,
            $orderDir
        );

        // Format data for display
        $formattedData = [];
        foreach ($result['data'] as $row) {
            $isActive = $row['is_active'] ?
                '<span class="badge badge-success">Aktif</span>' :
                '<span class="badge badge-secondary">Non-Aktif</span>';

            $actions = '
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail(' . $row['id'] . ')" title="Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="editData(' . $row['id'] . ')" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' . $row['id'] . ', \'' . htmlspecialchars($row['nama_jenis']) . '\')" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';

            $formattedData[] = [
                $row['kode_jenis'],
                $row['nama_jenis'],
                $row['deskripsi'] ? substr($row['deskripsi'], 0, 50) . '...' : '-',
                $isActive,
                date('d/m/Y H:i', strtotime($row['created_at'])),
                $actions
            ];
        }

        return $this->response->setJSON([
            'draw' => (int)$draw,
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $formattedData
        ]);
    }

    /**
     * Show create form page
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Jenis Kasus',
            'page' => 'jenis_kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Jenis Kasus' => base_url('spkt/jenis-kasus'),
                'Tambah Jenis Kasus' => ''
            ]
        ];

        return view('spkt/jenis_kasus/create', $data);
    }

    /**
     * Store new jenis kasus (AJAX)
     */
    public function storeAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = [
            'kode_jenis' => strtoupper(trim($this->request->getPost('kode_jenis'))),
            'nama_jenis' => trim($this->request->getPost('nama_jenis')),
            'deskripsi'  => trim($this->request->getPost('deskripsi')),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->jenisKasusModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jenis kasus berhasil ditambahkan!'
            ]);
        } else {
            $errors = $this->jenisKasusModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Show detail jenis kasus
     */
    public function show($id)
    {
        $jenisKasus = $this->jenisKasusModel->find($id);

        if (!$jenisKasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis kasus tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Jenis Kasus',
            'page' => 'jenis_kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'jenisKasus' => $jenisKasus,
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Jenis Kasus' => base_url('spkt/jenis-kasus'),
                'Detail Jenis Kasus' => ''
            ]
        ];

        return view('spkt/jenis_kasus/show', $data);
    }

    /**
     * Show edit form page
     */
    public function edit($id)
    {
        $jenisKasus = $this->jenisKasusModel->find($id);

        if (!$jenisKasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis kasus tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Jenis Kasus',
            'page' => 'jenis_kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'jenisKasus' => $jenisKasus,
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Jenis Kasus' => base_url('spkt/jenis-kasus'),
                'Edit Jenis Kasus' => ''
            ]
        ];

        return view('spkt/jenis_kasus/edit', $data);
    }

    /**
     * Update jenis kasus (AJAX)
     */
    public function updateAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $jenisKasus = $this->jenisKasusModel->find($id);
        if (!$jenisKasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jenis kasus tidak ditemukan!'
            ]);
        }

        $data = [
            'kode_jenis' => strtoupper(trim($this->request->getPost('kode_jenis'))),
            'nama_jenis' => trim($this->request->getPost('nama_jenis')),
            'deskripsi'  => trim($this->request->getPost('deskripsi')),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->jenisKasusModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jenis kasus berhasil diperbarui!'
            ]);
        } else {
            $errors = $this->jenisKasusModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Delete jenis kasus (AJAX)
     */
    public function deleteAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $jenisKasus = $this->jenisKasusModel->find($id);
        if (!$jenisKasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jenis kasus tidak ditemukan!'
            ]);
        }

        // Check if jenis kasus is used in kasus table
        $kasusModel = new \App\Models\KasusModel();
        $usedInKasus = $kasusModel->where('jenis_kasus_id', $id)->first();

        if ($usedInKasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jenis kasus tidak dapat dihapus karena masih digunakan dalam data kasus!'
            ]);
        }

        if ($this->jenisKasusModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jenis kasus berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!'
            ]);
        }
    }

    /**
     * Get jenis kasus by ID (AJAX)
     */
    public function getById($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $jenisKasus = $this->jenisKasusModel->find($id);

        if (!$jenisKasus) {
            return $this->response->setJSON(['error' => 'Jenis kasus tidak ditemukan']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $jenisKasus
        ]);
    }
}
