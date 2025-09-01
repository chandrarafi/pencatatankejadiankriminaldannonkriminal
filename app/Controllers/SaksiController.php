<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaksiModel;
use App\Models\KasusModel;
use CodeIgniter\HTTP\ResponseInterface;

class SaksiController extends BaseController
{
    protected $saksiModel;
    protected $kasusModel;
    protected $session;

    public function __construct()
    {
        $this->saksiModel = new SaksiModel();
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
            'title' => 'Data Saksi',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Saksi', 'url' => '']
            ]
        ];

        return view('reskrim/saksi/index', $data);
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

            $columns = ['nik', 'nama', 'jenis_kelamin', 'umur', 'jenis_saksi', 'nomor_kasus', 'judul_kasus', 'created_at'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->saksiModel->getDataTableData($searchValue, $start, $length, $orderColumn, $orderDir);

            $data = [];
            foreach ($result['data'] as $row) {
                // Jenis saksi badge
                $jenisClass = [
                    'ahli' => 'primary',
                    'fakta' => 'info',
                    'korban' => 'warning',
                    'mahkota' => 'success'
                ];
                $jenisText = [
                    'ahli' => 'Ahli',
                    'fakta' => 'Fakta',
                    'korban' => 'Korban',
                    'mahkota' => 'Mahkota'
                ];
                $badgeClass = $jenisClass[$row['jenis_saksi']] ?? 'secondary';
                $jenisLabel = $jenisText[$row['jenis_saksi']] ?? ucfirst($row['jenis_saksi']);
                $jenisBadge = '<span class="badge badge-' . $badgeClass . '">' . $jenisLabel . '</span>';

                // Action buttons
                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('reskrim/saksi/show/' . $row['id']) . '" 
                           class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . base_url('reskrim/saksi/edit/' . $row['id']) . '" 
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
                    'jenis_saksi' => $jenisBadge,
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
            log_message('error', 'Error in SaksiController::getData: ' . $e->getMessage());
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
            'title' => 'Tambah Data Saksi',
            'user' => $this->session->get(),
            'role' => $role,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Saksi', 'url' => base_url('reskrim/saksi')],
                ['title' => 'Tambah Data', 'url' => '']
            ]
        ];

        return view('reskrim/saksi/create', $data);
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
            'jenis_saksi' => 'required|in_list[ahli,fakta,korban,mahkota]',
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
                'jenis_saksi' => $this->request->getPost('jenis_saksi'),
                'hubungan_dengan_korban' => $this->request->getPost('hubungan_dengan_korban'),
                'hubungan_dengan_tersangka' => $this->request->getPost('hubungan_dengan_tersangka'),
                'keterangan_kesaksian' => $this->request->getPost('keterangan_kesaksian'),
                'dapat_dihubungi' => $this->request->getPost('dapat_dihubungi') ? 'ya' : 'tidak',
                'keterangan' => $this->request->getPost('keterangan')
            ];

            if ($this->saksiModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data saksi berhasil disimpan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data saksi',
                    'errors' => $this->saksiModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in SaksiController::storeAjax: ' . $e->getMessage());
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

        $saksi = $this->saksiModel->getWithKasus($id);

        if (!$saksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data saksi tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Data Saksi',
            'user' => $this->session->get(),
            'role' => $role,
            'saksi' => $saksi,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Saksi', 'url' => base_url('reskrim/saksi')],
                ['title' => 'Detail Data', 'url' => '']
            ]
        ];

        return view('reskrim/saksi/show', $data);
    }

    public function edit($id)
    {
        // Check role access
        $role = $this->session->get('role');
        if ($role !== 'reskrim') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak');
        }

        $saksi = $this->saksiModel->find($id);

        if (!$saksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data saksi tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Saksi',
            'user' => $this->session->get(),
            'role' => $role,
            'saksi' => $saksi,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'url' => base_url('dashboard')],
                ['title' => 'Data Saksi', 'url' => base_url('reskrim/saksi')],
                ['title' => 'Edit Data', 'url' => '']
            ]
        ];

        return view('reskrim/saksi/edit', $data);
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

        $saksi = $this->saksiModel->find($id);
        if (!$saksi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data saksi tidak ditemukan'
            ]);
        }

        // Validation rules
        $rules = [
            'kasus_id' => 'required|integer|is_not_unique[kasus.id]',
            'nama' => 'required|max_length[255]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'jenis_saksi' => 'required|in_list[ahli,fakta,korban,mahkota]',
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
                'jenis_saksi' => $this->request->getPost('jenis_saksi'),
                'hubungan_dengan_korban' => $this->request->getPost('hubungan_dengan_korban'),
                'hubungan_dengan_tersangka' => $this->request->getPost('hubungan_dengan_tersangka'),
                'keterangan_kesaksian' => $this->request->getPost('keterangan_kesaksian'),
                'dapat_dihubungi' => $this->request->getPost('dapat_dihubungi') ? 'ya' : 'tidak',
                'keterangan' => $this->request->getPost('keterangan')
            ];

            if ($this->saksiModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data saksi berhasil diupdate'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate data saksi',
                    'errors' => $this->saksiModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in SaksiController::updateAjax: ' . $e->getMessage());
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
            $saksi = $this->saksiModel->find($id);
            if (!$saksi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data saksi tidak ditemukan'
                ]);
            }

            if ($this->saksiModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data saksi berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus data saksi'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in SaksiController::deleteAjax: ' . $e->getMessage());
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
            log_message('error', 'Error in SaksiController::getKasusData: ' . $e->getMessage());
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
            $saksiData = $this->saksiModel->getByKasusId($kasusId);
            return $this->response->setJSON(['success' => true, 'data' => $saksiData]);
        } catch (\Exception $e) {
            log_message('error', 'Error in SaksiController::getByKasus: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}
