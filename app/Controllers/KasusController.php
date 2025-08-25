<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasusModel;
use App\Models\JenisKasusModel;
use App\Models\UserModel;
use App\Models\PelaporModel;
use CodeIgniter\HTTP\ResponseInterface;

class KasusController extends BaseController
{
    protected $kasusModel;
    protected $jenisKasusModel;
    protected $userModel;
    protected $pelaporModel;
    protected $session;

    public function __construct()
    {
        $this->kasusModel = new KasusModel();
        $this->jenisKasusModel = new JenisKasusModel();
        $this->userModel = new UserModel();
        $this->pelaporModel = new PelaporModel();
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
     * Display kasus list
     */
    public function index()
    {
        $data = [
            'title' => 'Kelola Data Kasus',
            'page' => 'kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Kasus' => ''
            ]
        ];

        return view('spkt/kasus/index', $data);
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

        $result = $this->kasusModel->getKasusForDataTable(
            $searchValue,
            $start,
            $length,
            $orderColumnIndex,
            $orderDir
        );

        // Format data for display
        $formattedData = [];
        foreach ($result['data'] as $row) {
            $statusBadge = $this->kasusModel->getStatusBadge($row['status']);
            $prioritasBadge = $this->kasusModel->getPrioritasBadge($row['prioritas']);

            $actions = '
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail(' . $row['id'] . ')" title="Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="editData(' . $row['id'] . ')" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' . $row['id'] . ', \'' . htmlspecialchars($row['nomor_kasus']) . '\')" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';

            $formattedData[] = [
                $row['nomor_kasus'],
                $row['judul_kasus'],
                $row['nama_jenis'] ?? '-',
                date('d/m/Y', strtotime($row['tanggal_kejadian'])),
                $statusBadge,
                $prioritasBadge,
                $row['pelapor_nama'],
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
            'title' => 'Tambah Data Kasus',
            'page' => 'kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'jenisKasusList' => $this->jenisKasusModel->getActiveJenisKasus(),
            'petugasList' => $this->userModel->where('role !=', 'spkt')->findAll(),
            'pelaporList' => $this->pelaporModel->getActivePelapor(),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Kasus' => base_url('spkt/kasus'),
                'Tambah Data Kasus' => ''
            ]
        ];

        return view('spkt/kasus/create', $data);
    }

    /**
     * Store new kasus (AJAX)
     */
    public function storeAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = [
            'jenis_kasus_id'  => $this->request->getPost('jenis_kasus_id'),
            'judul_kasus'     => trim($this->request->getPost('judul_kasus')),
            'deskripsi'       => trim($this->request->getPost('deskripsi')),
            'tanggal_kejadian' => $this->request->getPost('tanggal_kejadian'),
            'lokasi_kejadian' => trim($this->request->getPost('lokasi_kejadian')),
            'status'          => $this->request->getPost('status'),
            'prioritas'       => $this->request->getPost('prioritas'),
            'pelapor_id'      => $this->request->getPost('pelapor_id') ?: null,
            'pelapor_nama'    => trim($this->request->getPost('pelapor_nama')),
            'pelapor_telepon' => trim($this->request->getPost('pelapor_telepon')),
            'pelapor_alamat'  => trim($this->request->getPost('pelapor_alamat')),
            'petugas_id'      => $this->request->getPost('petugas_id') ?: null,
            'created_by'      => $this->session->get('user_id')
        ];

        // Always auto generate nomor kasus
        $data['nomor_kasus'] = '';

        if ($this->kasusModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kasus berhasil ditambahkan!'
            ]);
        } else {
            $errors = $this->kasusModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Show detail kasus
     */
    public function show($id)
    {
        $kasus = $this->kasusModel->getKasusWithJenis($id);

        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kasus tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Kasus',
            'page' => 'kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'kasus' => $kasus,
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Kasus' => base_url('spkt/kasus'),
                'Detail Data Kasus' => ''
            ]
        ];

        return view('spkt/kasus/show', $data);
    }

    /**
     * Show edit form page
     */
    public function edit($id)
    {
        $kasus = $this->kasusModel->find($id);

        if (!$kasus) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kasus tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Kasus',
            'page' => 'kasus',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'kasus' => $kasus,
            'jenisKasusList' => $this->jenisKasusModel->getActiveJenisKasus(),
            'petugasList' => $this->userModel->where('role !=', 'spkt')->findAll(),
            'pelaporList' => $this->pelaporModel->getActivePelapor(),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Kasus' => base_url('spkt/kasus'),
                'Edit Data Kasus' => ''
            ]
        ];

        return view('spkt/kasus/edit', $data);
    }

    /**
     * Update kasus (AJAX)
     */
    public function updateAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $kasus = $this->kasusModel->find($id);
        if (!$kasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kasus tidak ditemukan!'
            ]);
        }

        $data = [
            'jenis_kasus_id'  => $this->request->getPost('jenis_kasus_id'),
            'judul_kasus'     => trim($this->request->getPost('judul_kasus')),
            'deskripsi'       => trim($this->request->getPost('deskripsi')),
            'tanggal_kejadian' => $this->request->getPost('tanggal_kejadian'),
            'lokasi_kejadian' => trim($this->request->getPost('lokasi_kejadian')),
            'status'          => $this->request->getPost('status'),
            'prioritas'       => $this->request->getPost('prioritas'),
            'pelapor_id'      => $this->request->getPost('pelapor_id') ?: null,
            'pelapor_nama'    => trim($this->request->getPost('pelapor_nama')),
            'pelapor_telepon' => trim($this->request->getPost('pelapor_telepon')),
            'pelapor_alamat'  => trim($this->request->getPost('pelapor_alamat')),
            'petugas_id'      => $this->request->getPost('petugas_id') ?: null
        ];

        if ($this->kasusModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kasus berhasil diperbarui!'
            ]);
        } else {
            $errors = $this->kasusModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Delete kasus (AJAX)
     */
    public function deleteAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $kasus = $this->kasusModel->find($id);
        if (!$kasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kasus tidak ditemukan!'
            ]);
        }

        if ($this->kasusModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kasus berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!'
            ]);
        }
    }

    /**
     * Get kasus by ID (AJAX)
     */
    public function getById($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $kasus = $this->kasusModel->getKasusWithJenis($id);

        if (!$kasus) {
            return $this->response->setJSON(['error' => 'Data kasus tidak ditemukan']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $kasus
        ]);
    }

    /**
     * Get petugas data for modal (AJAX)
     */
    public function getPetugasData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $search = $this->request->getPost('search') ?? '';
        $role = $this->request->getPost('role') ?? '';

        $builder = $this->userModel->builder();
        $builder->select('id, username, fullname, role')
            ->where('role !=', 'spkt');

        // Search functionality
        if (!empty($search)) {
            $builder->groupStart()
                ->like('fullname', $search)
                ->orLike('username', $search)
                ->orLike('role', $search)
                ->groupEnd();
        }

        // Role filter
        if (!empty($role)) {
            $builder->where('role', $role);
        }

        $petugas = $builder->orderBy('fullname', 'ASC')->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $petugas
        ]);
    }

    /**
     * Update status kasus (AJAX)
     */
    public function updateStatus($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $kasus = $this->kasusModel->find($id);
        if (!$kasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kasus tidak ditemukan!'
            ]);
        }

        $newStatus = $this->request->getPost('status');
        $validStatus = ['dilaporkan', 'dalam_proses', 'selesai', 'ditutup'];

        if (!in_array($newStatus, $validStatus)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak valid!'
            ]);
        }

        if ($this->kasusModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status kasus berhasil diperbarui!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status!'
            ]);
        }
    }
}
