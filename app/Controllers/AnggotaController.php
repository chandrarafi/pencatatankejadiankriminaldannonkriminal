<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class AnggotaController extends BaseController
{
    protected $anggotaModel;
    protected $session;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->session = \Config\Services::session();

        // Cek apakah user adalah kasium
        if ($this->session->get('role') !== 'kasium') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access denied');
        }
    }

    /**
     * Tampilkan halaman index anggota
     */
    public function index()
    {
        $data = [
            'title' => 'Data Anggota',
            'user' => $this->session->get(),
            'role' => $this->session->get('role')
        ];

        return view('kasium/anggota/index', $data);
    }

    /**
     * Tampilkan halaman tambah anggota
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Anggota',
            'user' => $this->session->get(),
            'role' => $this->session->get('role')
        ];

        return view('kasium/anggota/create', $data);
    }

    /**
     * Tampilkan halaman edit anggota
     */
    public function edit($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (!$anggota) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan');
            return redirect()->to('kasium/anggota');
        }

        $data = [
            'title' => 'Edit Anggota',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'anggota' => $anggota
        ];

        return view('kasium/anggota/edit', $data);
    }

    /**
     * Ajax: Get data anggota untuk DataTables
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDir = $this->request->getPost('order')[0]['dir'] ?? 'asc';

        $result = $this->anggotaModel->getAnggotaForDataTable(
            $searchValue,
            $start,
            $length,
            $orderColumnIndex,
            $orderDir
        );

        // Format data untuk DataTables
        $formattedData = [];
        foreach ($result['data'] as $row) {
            $statusBadge = $this->getStatusBadge($row['status']);

            $actions = '
                <div class="btn-group btn-group-sm">
                    <a href="' . base_url('kasium/anggota/show/' . $row['id']) . '" class="btn btn-success" title="Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('kasium/anggota/edit/' . $row['id']) . '" class="btn btn-info" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                                                        <a href="' . base_url('kasium/anggota/delete/' . $row['id']) . '" class="btn btn-danger" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus?\')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                </div>
            ';

            $formattedData[] = [
                $row['nrp'],
                $row['nama'],
                $row['pangkat'],
                $row['jabatan'],
                $statusBadge,
                $actions
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($this->request->getPost('draw')),
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $formattedData
        ]);
    }

    /**
     * Simpan anggota baru
     */
    public function store()
    {
        // Jika AJAX request
        if ($this->request->isAJAX()) {
            return $this->storeAjax();
        }

        // Default non-AJAX (fallback)
        $data = [
            'nrp' => $this->request->getPost('nrp'),
            'nama' => $this->request->getPost('nama'),
            'pangkat' => $this->request->getPost('pangkat'),
            'jabatan' => $this->request->getPost('jabatan'),
            'unit_kerja' => $this->request->getPost('unit_kerja') ?: 'Polsek Lunang Silaut',
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk') ?: null,
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $this->uploadFoto($foto);
            if ($fotoName) {
                $data['foto'] = $fotoName;
            } else {
                session()->setFlashdata('error', 'Gagal upload foto. Pastikan file adalah gambar dan ukuran maksimal 2MB.');
                return redirect()->back()->withInput();
            }
        }

        if ($this->anggotaModel->insert($data)) {
            session()->setFlashdata('success', 'Data anggota berhasil ditambahkan');
            return redirect()->to('kasium/anggota');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data anggota');
            session()->setFlashdata('errors', $this->anggotaModel->errors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * AJAX: Simpan anggota baru
     */
    private function storeAjax()
    {
        try {
            $data = [
                'nrp' => $this->request->getPost('nrp'),
                'nama' => $this->request->getPost('nama'),
                'pangkat' => $this->request->getPost('pangkat'),
                'jabatan' => $this->request->getPost('jabatan'),
                'unit_kerja' => $this->request->getPost('unit_kerja') ?: 'Polsek Lunang Silaut',
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
                'status' => $this->request->getPost('status'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk') ?: null,
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Handle foto upload
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $fotoName = $this->uploadFoto($foto);
                if ($fotoName) {
                    $data['foto'] = $fotoName;
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal upload foto. Pastikan file adalah gambar dan ukuran maksimal 2MB.',
                        'errors' => ['foto' => 'Format atau ukuran file tidak valid']
                    ]);
                }
            }

            if ($this->anggotaModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data anggota berhasil ditambahkan',
                    'redirect' => base_url('kasium/anggota')
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan data anggota',
                    'errors' => $this->anggotaModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in storeAjax: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'errors' => []
            ]);
        }
    }

    /**
     * Tampilkan halaman detail anggota
     */
    public function show($id)
    {
        $anggota = $this->anggotaModel->find($id);

        if (!$anggota) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan');
            return redirect()->to('kasium/anggota');
        }

        $data = [
            'title' => 'Detail Anggota',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'anggota' => $anggota
        ];

        return view('kasium/anggota/show', $data);
    }

    /**
     * Update anggota
     */
    public function update($id)
    {
        // Jika AJAX request
        if ($this->request->isAJAX()) {
            return $this->updateAjax($id);
        }

        // Default non-AJAX (fallback)
        $existingAnggota = $this->anggotaModel->find($id);

        if (!$existingAnggota) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan');
            return redirect()->to('kasium/anggota');
        }

        $data = [
            'nrp' => $this->request->getPost('nrp'),
            'nama' => $this->request->getPost('nama'),
            'pangkat' => $this->request->getPost('pangkat'),
            'jabatan' => $this->request->getPost('jabatan'),
            'unit_kerja' => $this->request->getPost('unit_kerja') ?: 'Polsek Lunang Silaut',
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk') ?: null,
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $this->uploadFoto($foto);
            if ($fotoName) {
                $data['foto'] = $fotoName;

                // Delete old photo if exists
                if ($existingAnggota['foto']) {
                    $this->deleteFoto($existingAnggota['foto']);
                }
            } else {
                session()->setFlashdata('error', 'Gagal upload foto. Pastikan file adalah gambar dan ukuran maksimal 2MB.');
                return redirect()->back()->withInput();
            }
        }

        if ($this->anggotaModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data anggota berhasil diupdate');
            return redirect()->to('kasium/anggota');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate data anggota');
            session()->setFlashdata('errors', $this->anggotaModel->errors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * AJAX: Update anggota
     */
    private function updateAjax($id)
    {
        try {
            $existingAnggota = $this->anggotaModel->find($id);

            if (!$existingAnggota) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data anggota tidak ditemukan',
                    'errors' => []
                ]);
            }

            $data = [
                'nrp' => $this->request->getPost('nrp'),
                'nama' => $this->request->getPost('nama'),
                'pangkat' => $this->request->getPost('pangkat'),
                'jabatan' => $this->request->getPost('jabatan'),
                'unit_kerja' => $this->request->getPost('unit_kerja') ?: 'Polsek Lunang Silaut',
                'alamat' => $this->request->getPost('alamat'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
                'status' => $this->request->getPost('status'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk') ?: null,
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Handle foto upload
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $fotoName = $this->uploadFoto($foto);
                if ($fotoName) {
                    $data['foto'] = $fotoName;

                    // Delete old photo if exists
                    if ($existingAnggota['foto']) {
                        $this->deleteFoto($existingAnggota['foto']);
                    }
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal upload foto. Pastikan file adalah gambar dan ukuran maksimal 2MB.',
                        'errors' => ['foto' => 'Format atau ukuran file tidak valid']
                    ]);
                }
            }

            if ($this->anggotaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data anggota berhasil diupdate',
                    'redirect' => base_url('kasium/anggota')
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate data anggota',
                    'errors' => $this->anggotaModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in updateAjax: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'errors' => []
            ]);
        }
    }

    /**
     * Hapus anggota
     */
    public function delete($id)
    {
        // Get anggota data to delete photo
        $anggota = $this->anggotaModel->find($id);

        if (!$anggota) {
            session()->setFlashdata('error', 'Data anggota tidak ditemukan');
            return redirect()->to('kasium/anggota');
        }

        if ($this->anggotaModel->delete($id)) {
            // Delete photo if exists
            if ($anggota['foto']) {
                $this->deleteFoto($anggota['foto']);
            }

            session()->setFlashdata('success', 'Data anggota berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data anggota');
        }

        return redirect()->to('kasium/anggota');
    }

    /**
     * Ajax: Get data anggota untuk DataTables (untuk AJAX saja)
     */
    public function deleteAjax($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        // Get anggota data to delete photo
        $anggota = $this->anggotaModel->find($id);

        if ($this->anggotaModel->delete($id)) {
            // Delete photo if exists
            if ($anggota && $anggota['foto']) {
                $this->deleteFoto($anggota['foto']);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data anggota berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data anggota'
            ]);
        }
    }

    /**
     * Ajax: Get list anggota aktif untuk dropdown
     */
    public function getActiveAnggota()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $anggota = $this->anggotaModel->getActiveAnggota();

        return $this->response->setJSON([
            'success' => true,
            'data' => $anggota
        ]);
    }

    /**
     * Helper: Generate status badge
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'non_aktif' => '<span class="badge badge-warning">Non Aktif</span>',
            'pensiun' => '<span class="badge badge-secondary">Pensiun</span>',
            'mutasi' => '<span class="badge badge-info">Mutasi</span>',
        ];

        return $badges[$status] ?? '<span class="badge badge-light">' . ucfirst($status) . '</span>';
    }

    /**
     * Helper: Upload foto anggota
     */
    private function uploadFoto($file)
    {
        // Validasi file
        if (!$file->isValid()) {
            return false;
        }

        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return false;
        }

        // Validasi ukuran file (max 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return false;
        }

        // Generate nama file unik
        $fileName = uniqid() . '_' . time() . '.' . $file->getExtension();

        // Upload ke direktori public/uploads/anggota
        $uploadPath = FCPATH . 'uploads/anggota/';

        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($file->move($uploadPath, $fileName)) {
            return $fileName;
        }

        return false;
    }

    /**
     * Helper: Delete foto anggota
     */
    private function deleteFoto($fileName)
    {
        if ($fileName) {
            $filePath = FCPATH . 'uploads/anggota/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
