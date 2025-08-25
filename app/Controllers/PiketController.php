<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PiketModel;
use App\Models\PiketDetailModel;
use App\Models\AnggotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class PiketController extends BaseController
{
    protected $piketModel;
    protected $piketDetailModel;
    protected $anggotaModel;
    protected $session;

    public function __construct()
    {
        $this->piketModel = new PiketModel();
        $this->piketDetailModel = new PiketDetailModel();
        $this->anggotaModel = new AnggotaModel();
        $this->session = \Config\Services::session();

        // Cek apakah user memiliki akses (kasium atau spkt)
        $allowedRoles = ['kasium', 'spkt'];
        if (!in_array($this->session->get('role'), $allowedRoles)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Access denied');
        }
    }

    /**
     * Tampilkan halaman index piket
     */
    public function index()
    {
        $role = $this->session->get('role');

        $data = [
            'title' => 'Data Piket',
            'user' => $this->session->get(),
            'role' => $role
        ];

        // Tentukan view berdasarkan role
        if ($role === 'spkt') {
            $data['breadcrumb'] = [
                'Dashboard' => base_url('spkt/dashboard'),
                'Data Piket' => ''
            ];
            return view('spkt/piket/index', $data);
        } else {
            return view('kasium/piket/index', $data);
        }
    }

    /**
     * AJAX: Get data piket untuk DataTables
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

        $result = $this->piketModel->getPiketForDataTable(
            $searchValue,
            $start,
            $length,
            $orderColumnIndex,
            $orderDir
        );

        // Format data untuk DataTables berdasarkan role
        $role = $this->session->get('role');
        $formattedData = [];

        foreach ($result['data'] as $row) {
            if ($role === 'spkt') {
                // Format untuk SPKT (return object data untuk client-side rendering)
                $formattedData[] = [
                    'id' => $row['id'],
                    'tanggal_piket' => $row['tanggal_piket'],
                    'anggota_count' => $row['jumlah_anggota'] ?? 0,
                    'shift' => $row['shift'],
                    'jam_mulai' => $row['jam_mulai'],
                    'jam_selesai' => $row['jam_selesai'],
                    'lokasi_piket' => $row['lokasi_piket'] ?: '-',
                    'status' => $row['status']
                ];
            } else {
                // Format untuk Kasium (server-side rendering dengan HTML)
                $statusBadge = $this->getStatusBadge($row['status']);
                $shiftBadge = $this->getShiftBadge($row['shift']);

                // Format daftar anggota dengan badge
                $anggotaList = $row['anggota_list'] ?
                    '<span class="badge badge-info mr-1">' . $row['jumlah_anggota'] . ' orang</span><br>' .
                    '<small>' . $row['anggota_list'] . '</small>' :
                    '<span class="text-muted">Belum ada anggota</span>';

                $actions = '
                    <div class="btn-group btn-group-sm">
                        <a href="' . base_url('kasium/piket/show/' . $row['id']) . '" class="btn btn-success" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . base_url('kasium/piket/edit/' . $row['id']) . '" class="btn btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="' . base_url('kasium/piket/delete/' . $row['id']) . '" class="btn btn-danger" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus?\')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                ';

                $formattedData[] = [
                    date('d/m/Y', strtotime($row['tanggal_piket'])),
                    $anggotaList,
                    $shiftBadge,
                    $row['jam_mulai'] . ' - ' . $row['jam_selesai'],
                    $row['lokasi_piket'] ?: '-',
                    $statusBadge,
                    $actions
                ];
            }
        }

        return $this->response->setJSON([
            'draw' => intval($this->request->getPost('draw')),
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $formattedData
        ]);
    }

    /**
     * Tampilkan halaman tambah piket
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Piket',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'anggotaList' => $this->anggotaModel->getActiveAnggota()
        ];

        return view('kasium/piket/create', $data);
    }

    /**
     * Simpan piket baru
     */
    public function store()
    {
        // Jika AJAX request
        if ($this->request->isAJAX()) {
            return $this->storeAjax();
        }

        // Default non-AJAX (fallback)
        $data = [
            'anggota_id' => $this->request->getPost('anggota_id'),
            'tanggal_piket' => $this->request->getPost('tanggal_piket'),
            'shift' => $this->request->getPost('shift'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'lokasi_piket' => $this->request->getPost('lokasi_piket') ?: 'Polsek Lunang Silaut',
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'dijadwalkan',
            'created_by' => $this->session->get('user_id')
        ];

        if ($this->piketModel->insert($data)) {
            session()->setFlashdata('success', 'Data piket berhasil ditambahkan');
            return redirect()->to('kasium/piket');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data piket');
            session()->setFlashdata('errors', $this->piketModel->errors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * AJAX: Simpan piket baru
     */
    private function storeAjax()
    {
        try {
            $data = [
                'tanggal_piket' => $this->request->getPost('tanggal_piket'),
                'shift' => $this->request->getPost('shift'),
                'jam_mulai' => $this->request->getPost('jam_mulai'),
                'jam_selesai' => $this->request->getPost('jam_selesai'),
                'lokasi_piket' => $this->request->getPost('lokasi_piket') ?: 'Polsek Lunang Silaut',
                'keterangan' => $this->request->getPost('keterangan'),
                'status' => 'dijadwalkan',
                'created_by' => $this->session->get('user_id')
            ];

            // Get anggota yang dipilih
            $anggotaIdsString = $this->request->getPost('anggota_ids');
            log_message('debug', 'anggota_ids received in storeAjax: ' . var_export($anggotaIdsString, true));

            if (empty($anggotaIdsString)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimal harus memilih satu anggota',
                    'errors' => ['anggota_ids' => 'Anggota harus dipilih']
                ]);
            }

            // Convert string to array
            $anggotaIds = explode(',', $anggotaIdsString);
            $anggotaIds = array_filter($anggotaIds); // Remove empty values
            $anggotaIds = array_map('trim', $anggotaIds); // Remove whitespace

            log_message('debug', 'anggota_ids processed in storeAjax: ' . var_export($anggotaIds, true));

            if (empty($anggotaIds)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimal harus memilih satu anggota',
                    'errors' => ['anggota_ids' => 'Anggota harus dipilih']
                ]);
            }

            // Insert piket utama
            $piketId = $this->piketModel->insert($data);

            if ($piketId) {
                // Insert detail anggota
                $success = $this->piketDetailModel->insertAnggotaToPiket($piketId, $anggotaIds);

                if ($success) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data piket berhasil ditambahkan dengan ' . count($anggotaIds) . ' anggota',
                        'redirect' => base_url('kasium/piket')
                    ]);
                } else {
                    // Rollback piket jika gagal insert detail
                    $this->piketModel->delete($piketId);
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal menambahkan detail anggota',
                        'errors' => []
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan data piket',
                    'errors' => $this->piketModel->errors()
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
     * Tampilkan halaman detail piket
     */
    public function show($id)
    {
        $role = $this->session->get('role');
        $piket = $this->piketModel->find($id);

        if (!$piket) {
            session()->setFlashdata('error', 'Data piket tidak ditemukan');
            $redirectUrl = $role === 'spkt' ? 'spkt/piket' : 'kasium/piket';
            return redirect()->to($redirectUrl);
        }

        // Get anggota yang terdaftar dalam piket ini
        $anggotaPiket = $this->piketDetailModel->getPiketDetailWithAnggota($id);

        $data = [
            'title' => 'Detail Piket',
            'user' => $this->session->get(),
            'role' => $role,
            'piket' => $piket,
            'anggotaPiket' => $anggotaPiket
        ];

        // Tentukan view berdasarkan role
        if ($role === 'spkt') {
            $data['breadcrumb'] = [
                'Dashboard' => base_url('spkt/dashboard'),
                'Data Piket' => base_url('spkt/piket'),
                'Detail Piket' => ''
            ];
            return view('spkt/piket/show', $data);
        } else {
            return view('kasium/piket/show', $data);
        }
    }

    /**
     * Tampilkan halaman edit piket
     */
    public function edit($id)
    {
        $piket = $this->piketModel->find($id);

        if (!$piket) {
            session()->setFlashdata('error', 'Data piket tidak ditemukan');
            return redirect()->to('kasium/piket');
        }

        // Get anggota yang sudah terpilih untuk piket ini
        $selectedAnggota = $this->piketDetailModel->getPiketDetailWithAnggota($id);

        $data = [
            'title' => 'Edit Piket',
            'user' => $this->session->get(),
            'role' => $this->session->get('role'),
            'piket' => $piket,
            'anggotaList' => $this->anggotaModel->getActiveAnggota(),
            'selectedAnggota' => $selectedAnggota
        ];

        return view('kasium/piket/edit', $data);
    }

    /**
     * Update piket
     */
    public function update($id)
    {
        // Jika AJAX request
        if ($this->request->isAJAX()) {
            return $this->updateAjax($id);
        }

        // Default non-AJAX (fallback)
        $existingPiket = $this->piketModel->find($id);

        if (!$existingPiket) {
            session()->setFlashdata('error', 'Data piket tidak ditemukan');
            return redirect()->to('kasium/piket');
        }

        $data = [
            'anggota_id' => $this->request->getPost('anggota_id'),
            'tanggal_piket' => $this->request->getPost('tanggal_piket'),
            'shift' => $this->request->getPost('shift'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'lokasi_piket' => $this->request->getPost('lokasi_piket') ?: 'Polsek Lunang Silaut',
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->piketModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data piket berhasil diupdate');
            return redirect()->to('kasium/piket');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate data piket');
            session()->setFlashdata('errors', $this->piketModel->errors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * AJAX: Update piket
     */
    private function updateAjax($id)
    {
        try {
            $existingPiket = $this->piketModel->find($id);

            if (!$existingPiket) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data piket tidak ditemukan',
                    'errors' => []
                ]);
            }

            $data = [
                'tanggal_piket' => $this->request->getPost('tanggal_piket'),
                'shift' => $this->request->getPost('shift'),
                'jam_mulai' => $this->request->getPost('jam_mulai'),
                'jam_selesai' => $this->request->getPost('jam_selesai'),
                'lokasi_piket' => $this->request->getPost('lokasi_piket') ?: 'Polsek Lunang Silaut',
                'keterangan' => $this->request->getPost('keterangan'),
                'status' => $this->request->getPost('status'),
            ];

            // Get anggota yang dipilih
            $anggotaIdsString = $this->request->getPost('anggota_ids');
            if (empty($anggotaIdsString)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimal harus memilih satu anggota',
                    'errors' => ['anggota_ids' => 'Anggota harus dipilih']
                ]);
            }

            // Convert string to array
            $anggotaIds = explode(',', $anggotaIdsString);
            $anggotaIds = array_filter($anggotaIds); // Remove empty values
            $anggotaIds = array_map('trim', $anggotaIds); // Remove whitespace

            if (empty($anggotaIds)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimal harus memilih satu anggota',
                    'errors' => ['anggota_ids' => 'Anggota harus dipilih']
                ]);
            }

            // Update piket utama
            if ($this->piketModel->update($id, $data)) {
                // Hapus detail anggota lama
                $this->piketDetailModel->deleteByPiketId($id);

                // Insert detail anggota baru
                $success = $this->piketDetailModel->insertAnggotaToPiket($id, $anggotaIds);

                if ($success) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data piket berhasil diperbarui dengan ' . count($anggotaIds) . ' anggota',
                        'redirect' => base_url('kasium/piket')
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal memperbarui detail anggota',
                        'errors' => []
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui data piket',
                    'errors' => $this->piketModel->errors()
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
     * Hapus piket
     */
    public function delete($id)
    {
        $piket = $this->piketModel->find($id);

        if (!$piket) {
            session()->setFlashdata('error', 'Data piket tidak ditemukan');
            return redirect()->to('kasium/piket');
        }

        if ($this->piketModel->delete($id)) {
            session()->setFlashdata('success', 'Data piket berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data piket');
        }

        return redirect()->to('kasium/piket');
    }

    /**
     * AJAX: Get jadwal mingguan
     */
    public function getWeeklySchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d');
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d', strtotime($startDate . ' +6 days'));

        $schedule = $this->piketModel->getPiketByWeek($startDate, $endDate);

        return $this->response->setJSON([
            'success' => true,
            'data' => $schedule
        ]);
    }

    /**
     * Helper: Generate status badge
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'dijadwalkan' => '<span class="badge badge-primary">Dijadwalkan</span>',
            'selesai' => '<span class="badge badge-success">Selesai</span>',
            'diganti' => '<span class="badge badge-warning">Diganti</span>',
            'tidak_hadir' => '<span class="badge badge-danger">Tidak Hadir</span>',
        ];

        return $badges[$status] ?? '<span class="badge badge-light">' . ucfirst($status) . '</span>';
    }

    /**
     * Helper: Generate shift badge
     */
    private function getShiftBadge($shift)
    {
        $badges = [
            'pagi' => '<span class="badge badge-info">Pagi</span>',
            'siang' => '<span class="badge badge-warning">Siang</span>',
            'malam' => '<span class="badge badge-dark">Malam</span>',
        ];

        return $badges[$shift] ?? '<span class="badge badge-light">' . ucfirst($shift) . '</span>';
    }
}
