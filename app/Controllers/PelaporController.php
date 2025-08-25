<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelaporModel;
use CodeIgniter\HTTP\ResponseInterface;

class PelaporController extends BaseController
{
    protected $pelaporModel;
    protected $session;

    public function __construct()
    {
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
     * Display pelapor list
     */
    public function index()
    {
        $data = [
            'title' => 'Kelola Data Pelapor',
            'page' => 'pelapor',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Pelapor' => ''
            ]
        ];

        return view('spkt/pelapor/index', $data);
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

        $result = $this->pelaporModel->getPelaporForDataTable(
            $searchValue,
            $start,
            $length,
            $orderColumnIndex,
            $orderDir
        );

        // Format data for display
        $formattedData = [];
        foreach ($result['data'] as $row) {
            $jenisKelamin = '';
            if ($row['jenis_kelamin'] == 'L') {
                $jenisKelamin = '<span class="badge badge-primary">Laki-laki</span>';
            } elseif ($row['jenis_kelamin'] == 'P') {
                $jenisKelamin = '<span class="badge badge-pink">Perempuan</span>';
            } else {
                $jenisKelamin = '<span class="badge badge-secondary">-</span>';
            }

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
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' . $row['id'] . ', \'' . htmlspecialchars($row['nama']) . '\')" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';

            $formattedData[] = [
                $row['nama'],
                $row['nik'] ?: '-',
                $row['telepon'] ?: '-',
                $row['email'] ?: '-',
                $jenisKelamin,
                $row['kota_kabupaten'] ?: '-',
                $isActive,
                $actions,
                $row['id'] // Add ID as hidden column for modal selection
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
            'title' => 'Tambah Data Pelapor',
            'page' => 'pelapor',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Pelapor' => base_url('spkt/pelapor'),
                'Tambah Data Pelapor' => ''
            ]
        ];

        return view('spkt/pelapor/create', $data);
    }

    /**
     * Store new pelapor (AJAX)
     */
    public function storeAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = [
            'nama'            => trim($this->request->getPost('nama')),
            'nik'             => trim($this->request->getPost('nik')),
            'telepon'         => trim($this->request->getPost('telepon')),
            'email'           => trim($this->request->getPost('email')),
            'alamat'          => trim($this->request->getPost('alamat')),
            'kelurahan'       => trim($this->request->getPost('kelurahan')),
            'kecamatan'       => trim($this->request->getPost('kecamatan')),
            'kota_kabupaten'  => trim($this->request->getPost('kota_kabupaten')),
            'provinsi'        => trim($this->request->getPost('provinsi')),
            'kode_pos'        => trim($this->request->getPost('kode_pos')),
            'jenis_kelamin'   => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir'   => $this->request->getPost('tanggal_lahir') ?: null,
            'pekerjaan'       => trim($this->request->getPost('pekerjaan')),
            'keterangan'      => trim($this->request->getPost('keterangan')),
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
            'created_by'      => $this->session->get('user_id')
        ];

        if ($this->pelaporModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pelapor berhasil ditambahkan!'
            ]);
        } else {
            $errors = $this->pelaporModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Show detail pelapor
     */
    public function show($id)
    {
        $pelapor = $this->pelaporModel->find($id);

        if (!$pelapor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pelapor tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Pelapor',
            'page' => 'pelapor',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'pelapor' => $pelapor,
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Pelapor' => base_url('spkt/pelapor'),
                'Detail Data Pelapor' => ''
            ]
        ];

        return view('spkt/pelapor/show', $data);
    }

    /**
     * Show edit form page
     */
    public function edit($id)
    {
        $pelapor = $this->pelaporModel->find($id);

        if (!$pelapor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pelapor tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Pelapor',
            'page' => 'pelapor',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'pelapor' => $pelapor,
            'breadcrumb' => [
                'Dashboard' => base_url('spkt/dashboard'),
                'Kelola Data Pelapor' => base_url('spkt/pelapor'),
                'Edit Data Pelapor' => ''
            ]
        ];

        return view('spkt/pelapor/edit', $data);
    }

    /**
     * Update pelapor (AJAX)
     */
    public function updateAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $pelapor = $this->pelaporModel->find($id);
        if (!$pelapor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data pelapor tidak ditemukan!'
            ]);
        }

        $data = [
            'nama'            => trim($this->request->getPost('nama')),
            'nik'             => trim($this->request->getPost('nik')),
            'telepon'         => trim($this->request->getPost('telepon')),
            'email'           => trim($this->request->getPost('email')),
            'alamat'          => trim($this->request->getPost('alamat')),
            'kelurahan'       => trim($this->request->getPost('kelurahan')),
            'kecamatan'       => trim($this->request->getPost('kecamatan')),
            'kota_kabupaten'  => trim($this->request->getPost('kota_kabupaten')),
            'provinsi'        => trim($this->request->getPost('provinsi')),
            'kode_pos'        => trim($this->request->getPost('kode_pos')),
            'jenis_kelamin'   => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir'   => $this->request->getPost('tanggal_lahir') ?: null,
            'pekerjaan'       => trim($this->request->getPost('pekerjaan')),
            'keterangan'      => trim($this->request->getPost('keterangan')),
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->pelaporModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pelapor berhasil diperbarui!'
            ]);
        } else {
            $errors = $this->pelaporModel->errors();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Delete pelapor (AJAX)
     */
    public function deleteAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $pelapor = $this->pelaporModel->find($id);
        if (!$pelapor) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data pelapor tidak ditemukan!'
            ]);
        }

        // Check if pelapor is used in kasus table
        $kasusModel = new \App\Models\KasusModel();
        $usedInKasus = $kasusModel->where('pelapor_id', $id)->first();

        if ($usedInKasus) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data pelapor tidak dapat dihapus karena masih digunakan dalam data kasus!'
            ]);
        }

        if ($this->pelaporModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pelapor berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!'
            ]);
        }
    }

    /**
     * Get pelapor by ID (AJAX)
     */
    public function getById($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $pelapor = $this->pelaporModel->find($id);

        if (!$pelapor) {
            return $this->response->setJSON(['error' => 'Data pelapor tidak ditemukan']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $pelapor
        ]);
    }

    /**
     * Search pelapor for AJAX autocomplete
     */
    public function search()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $keyword = $this->request->getPost('keyword') ?? '';
        $pelapor = $this->pelaporModel->searchPelapor($keyword);

        $results = [];
        foreach ($pelapor as $p) {
            $results[] = [
                'id' => $p['id'],
                'nama' => $p['nama'],
                'nik' => $p['nik'],
                'telepon' => $p['telepon'],
                'alamat' => $this->pelaporModel->getFullAddress($p),
                'text' => $p['nama'] . ' (' . ($p['nik'] ?: 'NIK: -') . ')'
            ];
        }

        return $this->response->setJSON($results);
    }
}
