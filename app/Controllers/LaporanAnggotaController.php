<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class LaporanAnggotaController extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!session()->get('is_logged_in')) {
            redirect()->to('/login')->send();
            exit();
        }

        // Check role access - reskrim and kapolsek can access
        $role = session()->get('role');
        if (!in_array($role, ['reskrim', 'kapolsek'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }

        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Data Anggota',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_anggota/index', $data);
    }

    public function getData()
    {
        $request = service('request');

        // Get DataTables parameters
        $draw = $request->getPost('draw');
        $start = (int) $request->getPost('start');
        $length = (int) $request->getPost('length');
        $searchValue = $request->getPost('search')['value'] ?? '';
        $orderColumnIndex = (int) $request->getPost('order')[0]['column'];
        $orderDirection = $request->getPost('order')[0]['dir'];

        try {
            // Use AnggotaModel's DataTable method
            $result = $this->anggotaModel->getAnggotaForDataTable(
                $searchValue,
                $start,
                $length,
                $orderColumnIndex,
                $orderDirection
            );

            // Format data for DataTables
            $data = [];
            foreach ($result['data'] as $record) {
                // Status mapping - updated for anggota statuses
                $statusClass = [
                    'aktif' => 'success',
                    'non_aktif' => 'danger',
                    'pensiun' => 'warning',
                    'mutasi' => 'info'
                ];
                $badgeClass = $statusClass[$record['status']] ?? 'secondary';
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . strtoupper($record['status']) . '</span>';

                $data[] = [
                    'id' => $record['id'],
                    'nama' => $record['nama'],
                    'nrp' => $record['nrp'] ?: '-',
                    'pangkat' => $record['pangkat'] ?: '-',
                    'jabatan' => $record['jabatan'] ?: '-',
                    'unit_kerja' => $record['unit_kerja'] ?: '-',
                    'telepon' => $record['telepon'] ?: '-',
                    'email' => $record['email'] ?: '-',
                    'status' => $statusBadge,
                    'tanggal_masuk' => $record['tanggal_masuk'] ? date('d/m/Y', strtotime($record['tanggal_masuk'])) : '-',
                    'actions' => '<button type="button" class="btn btn-sm btn-info" onclick="showDetail(' . $record['id'] . ')">
                                    <i class="fas fa-eye"></i> Detail
                                  </button>'
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $result['recordsTotal'],
                'recordsFiltered' => $result['recordsFiltered'],
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanAnggotaController getData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function getDetail($id)
    {
        try {
            $anggota = $this->anggotaModel->find($id);

            if (!$anggota) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data anggota tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $anggota
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanAnggotaController getDetail: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function print()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        // Get all anggota data
        $anggotaData = $this->anggotaModel->orderBy('pangkat', 'ASC')
            ->orderBy('nama', 'ASC')
            ->findAll();

        // Get statistics
        $totalAnggota = count($anggotaData);

        $data = [
            'title' => 'Laporan Data Anggota',
            'user' => $user,
            'role' => $role,
            'anggotaData' => $anggotaData,
            'totalAnggota' => $totalAnggota,
            'isPrint' => true
        ];

        return view('laporan_anggota/print', $data);
    }

    public function getStatistics()
    {
        try {
            // Use AnggotaModel's statistics method
            $modelStats = $this->anggotaModel->getStatistics();

            // Get all anggota data for additional statistics
            $anggotaData = $this->anggotaModel->findAll();

            $stats = [
                'total' => $modelStats['total_anggota'],
                'aktif' => $modelStats['anggota_aktif'],
                'non_aktif' => $modelStats['anggota_non_aktif'],
                'pensiun' => $modelStats['anggota_pensiun'],
                'mutasi' => 0,
                'dengan_nrp' => 0,
                'tanpa_nrp' => 0,
                'unit_kerja' => []
            ];

            // Count additional statistics
            foreach ($anggotaData as $anggota) {
                // Count by NRP
                if (!empty($anggota['nrp'])) {
                    $stats['dengan_nrp']++;
                } else {
                    $stats['tanpa_nrp']++;
                }

                // Count by status (additional ones not in model)
                if ($anggota['status'] === 'mutasi') {
                    $stats['mutasi']++;
                }

                // Count by unit_kerja
                $unit = $anggota['unit_kerja'] ?: 'Tidak Diketahui';
                if (!isset($stats['unit_kerja'][$unit])) {
                    $stats['unit_kerja'][$unit] = 0;
                }
                $stats['unit_kerja'][$unit]++;
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanAnggotaController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
