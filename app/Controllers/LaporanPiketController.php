<?php

namespace App\Controllers;

use App\Models\PiketModel;
use App\Models\PiketDetailModel;
use App\Models\AnggotaModel;

class LaporanPiketController extends BaseController
{
    protected $piketModel;
    protected $piketDetailModel;
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

        $this->piketModel = new PiketModel();
        $this->piketDetailModel = new PiketDetailModel();
        $this->anggotaModel = new AnggotaModel();
    }

    // ===============================
    // DAILY REPORT (Per Tanggal)
    // ===============================

    public function index()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Piket Per Tanggal',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_piket/index', $data);
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

        // Get date filters
        $startDate = $request->getPost('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $request->getPost('end_date') ?: date('Y-m-d');

        try {
            // Use PiketModel's DataTable method with date filter
            $result = $this->piketModel->getPiketForDataTableWithDateFilter(
                $searchValue,
                $start,
                $length,
                $orderColumnIndex,
                $orderDirection,
                $startDate,
                $endDate
            );

            // Format data for DataTables
            $data = [];
            foreach ($result['data'] as $record) {
                // Status mapping
                $statusClass = [
                    'dijadwalkan' => 'warning',
                    'selesai' => 'success',
                    'diganti' => 'info',
                    'tidak_hadir' => 'danger'
                ];
                $badgeClass = $statusClass[$record['status']] ?? 'secondary';
                $statusBadge = '<span class="badge badge-' . $badgeClass . '">' . strtoupper($record['status']) . '</span>';

                // Shift mapping
                $shiftClass = [
                    'pagi' => 'info',
                    'siang' => 'warning',
                    'malam' => 'dark'
                ];
                $shiftBadge = '<span class="badge badge-' . ($shiftClass[$record['shift']] ?? 'secondary') . '">' . strtoupper($record['shift']) . '</span>';

                $data[] = [
                    'id' => $record['id'],
                    'tanggal_piket' => date('d/m/Y', strtotime($record['tanggal_piket'])),
                    'shift' => $shiftBadge,
                    'jam_mulai' => substr($record['jam_mulai'], 0, 5),
                    'jam_selesai' => substr($record['jam_selesai'], 0, 5),
                    'lokasi_piket' => $record['lokasi_piket'] ?: '-',
                    'anggota_list' => $record['anggota_list'] ?: '-',
                    'jumlah_anggota' => $record['jumlah_anggota'] ?: 0,
                    'status' => $statusBadge,
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
            log_message('error', 'Error in LaporanPiketController getData: ' . $e->getMessage());
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
            $piket = $this->piketModel->find($id);

            if (!$piket) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data piket tidak ditemukan'
                ]);
            }

            // Get piket detail with anggota
            $piketDetail = $this->piketDetailModel->getPiketDetailWithAnggota($id);

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'piket' => $piket,
                    'anggota' => $piketDetail
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPiketController getDetail: ' . $e->getMessage());
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

        // Get date filters from GET parameters
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');

        // Get piket data with date filter
        $piketData = $this->piketModel->getPiketByDateRange($startDate, $endDate);

        // Get statistics
        $stats = $this->getStatisticsByDateRange($startDate, $endDate);

        $data = [
            'title' => 'Laporan Piket Per Tanggal',
            'user' => $user,
            'role' => $role,
            'piketData' => $piketData,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'stats' => $stats,
            'isPrint' => true
        ];

        return view('laporan_piket/print', $data);
    }

    public function getStatistics()
    {
        try {
            $request = service('request');
            $startDate = $request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
            $endDate = $request->getGet('end_date') ?: date('Y-m-d');

            $stats = $this->getStatisticsByDateRange($startDate, $endDate);

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPiketController getStatistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // ===============================
    // MONTHLY REPORT (Per Bulan)
    // ===============================

    public function monthly()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $data = [
            'title' => 'Laporan Piket Per Bulan',
            'user' => $user,
            'role' => $role
        ];

        return view('laporan_piket/monthly', $data);
    }

    public function getMonthlyData()
    {
        $request = service('request');

        // Get parameters
        $draw = $request->getPost('draw');
        $month = $request->getPost('month') ?: date('m');
        $year = $request->getPost('year') ?: date('Y');

        try {
            $monthlyStats = $this->piketModel->getMonthlyStatistics($year, $month);

            $data = [];
            foreach ($monthlyStats as $stat) {
                $data[] = [
                    'tanggal' => date('d/m/Y', strtotime($stat['tanggal_piket'])),
                    'total_piket' => $stat['total_piket'],
                    'dijadwalkan' => $stat['dijadwalkan'],
                    'selesai' => $stat['selesai'],
                    'diganti' => $stat['diganti'],
                    'tidak_hadir' => $stat['tidak_hadir'],
                    'total_anggota' => $stat['total_anggota']
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in LaporanPiketController getMonthlyData: ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function printMonthly()
    {
        $user = session()->get('user_data');
        $role = session()->get('role');

        $month = $this->request->getGet('month') ?: date('m');
        $year = $this->request->getGet('year') ?: date('Y');

        $monthlyStats = $this->piketModel->getMonthlyStatistics($year, $month);
        $monthlyTotals = $this->piketModel->getMonthlyTotals($year, $month);

        $monthNames = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $data = [
            'title' => 'Laporan Piket Per Bulan',
            'user' => $user,
            'role' => $role,
            'data' => $monthlyStats,
            'totals' => $monthlyTotals,
            'month' => $month,
            'year' => $year,
            'monthName' => $monthNames[$month] ?? 'Unknown',
            'isPrint' => true
        ];

        return view('laporan_piket/print_monthly', $data);
    }

    // ===============================
    // HELPER METHODS
    // ===============================

    private function getStatisticsByDateRange($startDate, $endDate)
    {
        $piketData = $this->piketModel->getPiketByDateRange($startDate, $endDate);

        $stats = [
            'total_piket' => count($piketData),
            'dijadwalkan' => 0,
            'selesai' => 0,
            'diganti' => 0,
            'tidak_hadir' => 0,
            'total_anggota' => 0,
            'shift_pagi' => 0,
            'shift_siang' => 0,
            'shift_malam' => 0
        ];

        foreach ($piketData as $piket) {
            // Count by status
            if (isset($stats[$piket['status']])) {
                $stats[$piket['status']]++;
            }

            // Count by shift
            if (isset($stats['shift_' . $piket['shift']])) {
                $stats['shift_' . $piket['shift']]++;
            }

            // Count total anggota
            $anggotaCount = $this->piketDetailModel->where('piket_id', $piket['id'])->countAllResults();
            $stats['total_anggota'] += $anggotaCount;
        }

        return $stats;
    }
}
