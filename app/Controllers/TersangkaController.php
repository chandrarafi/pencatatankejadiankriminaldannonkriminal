<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TersangkaModel;
use App\Models\KasusModel;
use CodeIgniter\HTTP\ResponseInterface;

class TersangkaController extends BaseController
{
    protected $tersangkaModel;
    protected $kasusModel;
    protected $session;

    public function __construct()
    {
        $this->tersangkaModel = new TersangkaModel();
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
            'title' => 'Data Tersangka',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Tersangka', 'url' => '']
            ]
        ];

        return view('reskrim/tersangka/index', $data);
    }

    public function getData()
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

            $columns = ['nik', 'nama', 'jenis_kelamin', 'umur', 'status_tersangka', 'nomor_kasus', 'judul_kasus', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->tersangkaModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                // Status badge
                $statusClass = [
                    'ditetapkan' => 'warning',
                    'ditahan' => 'danger',
                    'dibebaskan' => 'success',
                    'buron' => 'dark'
                ];
                $statusText = [
                    'ditetapkan' => 'Ditetapkan',
                    'ditahan' => 'Ditahan',
                    'dibebaskan' => 'Dibebaskan',
                    'buron' => 'Buron'
                ];
                $badgeClass = $statusClass[$row['status_tersangka']] ?? 'secondary';
                $statusLabel = $statusText[$row['status_tersangka']] ?? ucfirst($row['status_tersangka']);
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . $statusLabel . '</span>';

                // Action buttons
                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('reskrim/tersangka/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . base_url('reskrim/tersangka/edit/' . $row['id']) . '" 
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
                    'umur' => $row['umur'] ? $row['umur'] . ' th' : '-',
                    'status_tersangka' => $statusBadge,
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
            log_message('error', 'Error in TersangkaController::getData: ' . $e->getMessage());
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
            'title' => 'Tambah Data Tersangka',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Tersangka', 'url' => base_url('reskrim/tersangka')],
                ['title' => 'Tambah Data', 'url' => '']
            ]
        ];

        return view('reskrim/tersangka/create', $data);
    }

    public function storeAjax()
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        // Validation rules
        $rules = [
            'kasus_id' => 'required|integer|is_not_unique[kasus.id]',
            'nama' => 'required|max_length[255]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'status_tersangka' => 'required|in_list[ditetapkan,ditahan,dibebaskan,buron]',
            'alamat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            $data = [
                'kasus_id' => $this->request->getPost('kasus_id'),
                'nama' => $this->request->getPost('nama'),
                'nik' => $this->request->getPost('nik'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'umur' => $this->request->getPost('umur') ?: null,
                'alamat' => $this->request->getPost('alamat'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
                'status_tersangka' => $this->request->getPost('status_tersangka'),
                'tempat_penahanan' => $this->request->getPost('tempat_penahanan'),
                'tanggal_penahanan' => $this->request->getPost('tanggal_penahanan') ?: null,
                'pasal_yang_disangkakan' => $this->request->getPost('pasal_yang_disangkakan'),
                'barang_bukti' => $this->request->getPost('barang_bukti'),
                'keterangan' => $this->request->getPost('keterangan')
            ];

            if ($this->tersangkaModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data tersangka berhasil disimpan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data tersangka',
                    'errors' => $this->tersangkaModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in TersangkaController::storeAjax: ' . $e->getMessage());
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

        $tersangka = $this->tersangkaModel->getWithKasus($id);

        if (!$tersangka) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersangka tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Tersangka',
            'user' => $this->session->get(),
            'role' => $role,
            'tersangka' => $tersangka,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Tersangka', 'url' => base_url('reskrim/tersangka')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/tersangka/show', $data);
    }

    public function edit($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $tersangka = $this->tersangkaModel->find($id);

        if (!$tersangka) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersangka tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Tersangka',
            'user' => $this->session->get(),
            'role' => $role,
            'tersangka' => $tersangka,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Tersangka', 'url' => base_url('reskrim/tersangka')],
                ['title' => 'Edit Data', 'url' => '']
            ]
        ];

        return view('reskrim/tersangka/edit', $data);
    }

    public function updateAjax($id)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $tersangka = $this->tersangkaModel->find($id);
        if (!$tersangka) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tersangka tidak ditemukan'
            ]);
        }

        // Validation rules
        $rules = [
            'kasus_id' => 'required|integer|is_not_unique[kasus.id]',
            'nama' => 'required|max_length[255]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'status_tersangka' => 'required|in_list[ditetapkan,ditahan,dibebaskan,buron]',
            'alamat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            $data = [
                'kasus_id' => $this->request->getPost('kasus_id'),
                'nama' => $this->request->getPost('nama'),
                'nik' => $this->request->getPost('nik'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'umur' => $this->request->getPost('umur') ?: null,
                'alamat' => $this->request->getPost('alamat'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
                'status_tersangka' => $this->request->getPost('status_tersangka'),
                'tempat_penahanan' => $this->request->getPost('tempat_penahanan'),
                'tanggal_penahanan' => $this->request->getPost('tanggal_penahanan') ?: null,
                'pasal_yang_disangkakan' => $this->request->getPost('pasal_yang_disangkakan'),
                'barang_bukti' => $this->request->getPost('barang_bukti'),
                'keterangan' => $this->request->getPost('keterangan')
            ];

            if ($this->tersangkaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data tersangka berhasil diupdate'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate data tersangka',
                    'errors' => $this->tersangkaModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in TersangkaController::updateAjax: ' . $e->getMessage());
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
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        try {
            $tersangka = $this->tersangkaModel->find($id);
            if (!$tersangka) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tersangka tidak ditemukan'
                ]);
            }

            if ($this->tersangkaModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data tersangka berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus data tersangka'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in TersangkaController::deleteAjax: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }

    public function getKasusData()
    {
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $kasusData = $this->kasusModel
                ->select('kasus.*, pelapor.nama as pelapor_nama')
                ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
                ->where('kasus.status !=', 'ditutup')
                ->orderBy('kasus.created_at', 'DESC')
                ->findAll();

            return $this->response->setJSON(['success' => true, 'data' => $kasusData]);
        } catch (\Exception $e) {
            log_message('error', 'Error in TersangkaController::getKasusData: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan saat mengambil data kasus']);
        }
    }

    public function getByKasus($kasusId)
    {
        // Check role access
        if ($this->session->get('role') !== 'reskrim') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        try {
            $tersangkaData = $this->tersangkaModel->getByKasusId($kasusId);
            return $this->response->setJSON(['success' => true, 'data' => $tersangkaData]);
        } catch (\Exception $e) {
            log_message('error', 'Error in TersangkaController::getByKasus: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}
