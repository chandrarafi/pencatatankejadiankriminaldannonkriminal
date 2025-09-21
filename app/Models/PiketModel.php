<?php

namespace App\Models;

use CodeIgniter\Model;

class PiketModel extends Model
{
    protected $table            = 'piket';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal_piket',
        'shift',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'status',
        'lokasi_piket',
        'created_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $validationRules = [
        'tanggal_piket'  => 'required|valid_date[Y-m-d]',
        'shift'          => 'required|in_list[pagi,siang,malam]',
        'jam_mulai'      => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/]',
        'jam_selesai'    => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/]',
        'status'         => 'required|in_list[dijadwalkan,selesai,diganti,tidak_hadir]',
        'lokasi_piket'   => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'tanggal_piket' => [
            'required'   => 'Tanggal piket harus diisi',
            'valid_date' => 'Format tanggal tidak valid, gunakan format YYYY-MM-DD.',
        ],
        'shift' => [
            'required' => 'Shift harus dipilih',
            'in_list'  => 'Shift tidak valid',
        ],
        'jam_mulai' => [
            'required'   => 'Jam mulai harus diisi',
            'regex_match' => 'Format jam mulai tidak valid (HH:MM atau HH:MM:SS)',
        ],
        'jam_selesai' => [
            'required'   => 'Jam selesai harus diisi',
            'regex_match' => 'Format jam selesai tidak valid (HH:MM atau HH:MM:SS)',
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list'  => 'Status tidak valid',
        ],
        'lokasi_piket' => [
            'max_length' => 'Lokasi piket maksimal 255 karakter',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Temukan piket berdasarkan tanggal dan shift
     */
    public function findByTanggalAndShift(string $tanggalPiket, string $shift)
    {
        return $this->where('tanggal_piket', $tanggalPiket)
            ->where('shift', $shift)
            ->first();
    }

    /**
     * Get single piket with anggota data
     */
    public function getPiketWithAnggota($id)
    {
        return $this->find($id);
    }

    /**
     * Get piket with pagination for DataTables
     */
    public function getPiketForDataTable($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        $columns = ['tanggal_piket', 'anggota_list', 'shift', 'jam_mulai', 'lokasi_piket', 'status'];

        $builder = $this->builder();


        $builder->select("piket.*, 
            (SELECT GROUP_CONCAT(anggota.nama SEPARATOR ', ') 
             FROM piket_detail 
             JOIN anggota ON anggota.id = piket_detail.anggota_id 
             WHERE piket_detail.piket_id = piket.id) as anggota_list,
            (SELECT COUNT(*) 
             FROM piket_detail 
             WHERE piket_detail.piket_id = piket.id) as jumlah_anggota ");


        if (!empty($search)) {
            $builder->groupStart()
                ->like('piket.shift', $search)
                ->orLike('piket.lokasi_piket', $search)
                ->orLike('piket.status', $search)
                ->orLike('piket.tanggal_piket', $search)
                ->orHavingLike('anggota_list', $search)
                ->groupEnd();
        }


        if (isset($columns[$orderColumn])) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $builder->orderBy('piket.tanggal_piket', 'desc');
        }


        $totalRecords = $builder->countAllResults(false);


        $data = $builder->limit($length, $start)->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $this->countAll(),
            'recordsFiltered' => $totalRecords
        ];
    }

    /**
     * Get piket hari ini
     */
    public function getPiketHariIni()
    {
        return $this->where('tanggal_piket', date('Y-m-d'))
            ->findAll();
    }

    /**
     * Get piket by week
     */
    public function getPiketByWeek($startDate, $endDate)
    {
        return $this->where('tanggal_piket >=', $startDate)
            ->where('tanggal_piket <=', $endDate)
            ->orderBy('tanggal_piket', 'ASC')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();
    }

    /**
     * Check conflict jadwal piket - deprecated for multi-anggota system
     */
    public function checkConflict($anggotaId, $tanggalPiket, $shift, $excludeId = null)
    {


        return false;
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');

        return [
            'total_piket' => $this->countAll(),
            'piket_hari_ini' => $this->where('tanggal_piket', $today)->countAllResults(),
            'piket_bulan_ini' => $this->like('tanggal_piket', $thisMonth)->countAllResults(),
            'piket_dijadwalkan' => $this->where('status', 'dijadwalkan')->countAllResults(),
            'piket_selesai' => $this->where('status', 'selesai')->countAllResults(),
        ];
    }

    /**
     * Get piket with pagination for DataTables with date filter
     */
    public function getPiketForDataTableWithDateFilter($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc', $startDate = null, $endDate = null)
    {
        $columns = ['tanggal_piket', 'anggota_list', 'shift', 'jam_mulai', 'lokasi_piket', 'status'];

        $builder = $this->builder();


        $builder->select("piket.*, 
            (SELECT GROUP_CONCAT(anggota.nama SEPARATOR ', ') 
             FROM piket_detail 
             JOIN anggota ON anggota.id = piket_detail.anggota_id 
             WHERE piket_detail.piket_id = piket.id) as anggota_list,
            (SELECT COUNT(*) 
             FROM piket_detail 
             WHERE piket_detail.piket_id = piket.id) as jumlah_anggota");


        if ($startDate && $endDate) {
            $builder->where('piket.tanggal_piket >=', $startDate)
                ->where('piket.tanggal_piket <=', $endDate);
        }


        if (!empty($search)) {
            $builder->groupStart()
                ->like('piket.shift', $search)
                ->orLike('piket.lokasi_piket', $search)
                ->orLike('piket.status', $search)
                ->orLike('piket.tanggal_piket', $search)
                ->orHavingLike('anggota_list', $search)
                ->groupEnd();
        }


        if (isset($columns[$orderColumn])) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $builder->orderBy('piket.tanggal_piket', 'desc');
        }


        $totalRecords = $builder->countAllResults(false);


        $data = $builder->limit($length, $start)->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $this->countAll(),
            'recordsFiltered' => $totalRecords
        ];
    }

    /**
     * Get piket by date range
     */
    public function getPiketByDateRange($startDate, $endDate)
    {
        return $this->select("piket.*, 
            (SELECT GROUP_CONCAT(anggota.nama SEPARATOR ', ') 
             FROM piket_detail 
             JOIN anggota ON anggota.id = piket_detail.anggota_id 
             WHERE piket_detail.piket_id = piket.id) as anggota_list,
            (SELECT COUNT(*) 
             FROM piket_detail 
             WHERE piket_detail.piket_id = piket.id) as jumlah_anggota")
            ->where('tanggal_piket >=', $startDate)
            ->where('tanggal_piket <=', $endDate)
            ->orderBy('tanggal_piket', 'ASC')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();
    }

    /**
     * Get monthly statistics
     */
    public function getMonthlyStatistics($year, $month)
    {

        $sql = "SELECT 
            DATE(p.tanggal_piket) as tanggal_piket,
            COUNT(*) as total_piket,
            SUM(CASE WHEN p.status = 'dijadwalkan' THEN 1 ELSE 0 END) as dijadwalkan,
            SUM(CASE WHEN p.status = 'selesai' THEN 1 ELSE 0 END) as selesai,
            SUM(CASE WHEN p.status = 'diganti' THEN 1 ELSE 0 END) as diganti,
            SUM(CASE WHEN p.status = 'tidak_hadir' THEN 1 ELSE 0 END) as tidak_hadir,
            COALESCE(SUM(pd_count.anggota_count), 0) as total_anggota
        FROM piket p
        LEFT JOIN (
            SELECT 
                piket_id,
                COUNT(*) as anggota_count
            FROM piket_detail
            GROUP BY piket_id
        ) pd_count ON p.id = pd_count.piket_id
        WHERE YEAR(p.tanggal_piket) = ? AND MONTH(p.tanggal_piket) = ?
        GROUP BY DATE(p.tanggal_piket)
        ORDER BY tanggal_piket ASC";

        return $this->db->query($sql, [$year, $month])->getResultArray();
    }

    /**
     * Get monthly totals
     */
    public function getMonthlyTotals($year, $month)
    {

        $sql = "SELECT 
            COUNT(*) as total_piket,
            SUM(CASE WHEN p.status = 'dijadwalkan' THEN 1 ELSE 0 END) as dijadwalkan,
            SUM(CASE WHEN p.status = 'selesai' THEN 1 ELSE 0 END) as selesai,
            SUM(CASE WHEN p.status = 'diganti' THEN 1 ELSE 0 END) as diganti,
            SUM(CASE WHEN p.status = 'tidak_hadir' THEN 1 ELSE 0 END) as tidak_hadir,
            COALESCE(SUM(pd_count.anggota_count), 0) as total_anggota
        FROM piket p
        LEFT JOIN (
            SELECT 
                piket_id,
                COUNT(*) as anggota_count
            FROM piket_detail
            GROUP BY piket_id
        ) pd_count ON p.id = pd_count.piket_id
        WHERE YEAR(p.tanggal_piket) = ? AND MONTH(p.tanggal_piket) = ?";

        $result = $this->db->query($sql, [$year, $month])->getRowArray();
        return $result ?: [
            'total_piket' => 0,
            'dijadwalkan' => 0,
            'selesai' => 0,
            'diganti' => 0,
            'tidak_hadir' => 0,
            'total_anggota' => 0
        ];
    }
}
