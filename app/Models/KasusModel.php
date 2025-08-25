<?php

namespace App\Models;

use CodeIgniter\Model;

class KasusModel extends Model
{
    protected $table            = 'kasus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_kasus',
        'jenis_kasus_id',
        'judul_kasus',
        'deskripsi',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'status',
        'prioritas',
        'pelapor_id',
        'pelapor_nama',
        'pelapor_telepon',
        'pelapor_alamat',
        'petugas_id',
        'created_by',
        'keterangan'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nomor_kasus'     => 'permit_empty|max_length[50]|is_unique[kasus.nomor_kasus,id,{id}]',
        'jenis_kasus_id'  => 'required|integer|is_not_unique[jenis_kasus.id]',
        'judul_kasus'     => 'required|max_length[255]',
        'deskripsi'       => 'permit_empty',
        'tanggal_kejadian' => 'required|valid_date',
        'lokasi_kejadian' => 'required|max_length[255]',
        'status'          => 'required|in_list[dilaporkan,dalam_proses,selesai,ditutup]',
        'prioritas'       => 'required|in_list[rendah,sedang,tinggi,darurat]',
        'pelapor_id'      => 'permit_empty|integer|is_not_unique[pelapor.id]',
        'pelapor_nama'    => 'required|max_length[255]',
        'pelapor_telepon' => 'permit_empty|max_length[20]',
        'pelapor_alamat'  => 'permit_empty',
        'petugas_id'      => 'permit_empty|integer|is_not_unique[users.id]',
        'created_by'      => 'required|integer|is_not_unique[users.id]'
    ];

    protected $validationMessages = [
        'nomor_kasus' => [
            'required'   => 'Nomor kasus harus diisi',
            'max_length' => 'Nomor kasus maksimal 50 karakter',
            'is_unique'  => 'Nomor kasus sudah digunakan'
        ],
        'jenis_kasus_id' => [
            'required'      => 'Jenis kasus harus dipilih',
            'integer'       => 'Jenis kasus tidak valid',
            'is_not_unique' => 'Jenis kasus tidak ditemukan'
        ],
        'judul_kasus' => [
            'required'   => 'Judul kasus harus diisi',
            'max_length' => 'Judul kasus maksimal 255 karakter'
        ],
        'tanggal_kejadian' => [
            'required'   => 'Tanggal kejadian harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'lokasi_kejadian' => [
            'required'   => 'Lokasi kejadian harus diisi',
            'max_length' => 'Lokasi kejadian maksimal 255 karakter'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list'  => 'Status tidak valid'
        ],
        'prioritas' => [
            'required' => 'Prioritas harus dipilih',
            'in_list'  => 'Prioritas tidak valid'
        ],
        'pelapor_nama' => [
            'required'   => 'Nama pelapor harus diisi',
            'max_length' => 'Nama pelapor maksimal 255 karakter'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateNomorKasus'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Generate nomor kasus otomatis
     */
    protected function generateNomorKasus(array $data)
    {
        if (empty($data['data']['nomor_kasus'])) {
            $year = date('Y');
            $month = date('m');

            // Get last number for this month
            $lastKasus = $this->where('nomor_kasus LIKE', "K-$year$month-%")
                ->orderBy('nomor_kasus', 'DESC')
                ->first();

            $nextNumber = 1;
            if ($lastKasus) {
                $lastNumber = (int) substr($lastKasus['nomor_kasus'], -4);
                $nextNumber = $lastNumber + 1;
            }

            $data['data']['nomor_kasus'] = sprintf('K-%s%s-%04d', $year, $month, $nextNumber);
        }

        return $data;
    }

    /**
     * Get kasus with jenis kasus data and pelapor data
     */
    public function getKasusWithJenis($id)
    {
        return $this->select('kasus.*, jenis_kasus.nama_jenis, users.fullname as petugas_nama, creator.fullname as creator_nama, pelapor.nama as pelapor_nama_lengkap, pelapor.nik as pelapor_nik, pelapor.email as pelapor_email')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('users', 'users.id = kasus.petugas_id', 'left')
            ->join('users creator', 'creator.id = kasus.created_by', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
            ->where('kasus.id', $id)
            ->first();
    }

    /**
     * Get kasus with pagination for DataTables
     */
    public function getKasusForDataTable($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        $columns = ['nomor_kasus', 'judul_kasus', 'nama_jenis', 'tanggal_kejadian', 'status', 'prioritas', 'pelapor_nama'];

        $builder = $this->builder();
        $builder->select('kasus.*, jenis_kasus.nama_jenis')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left');

        // Search functionality
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kasus.nomor_kasus', $search)
                ->orLike('kasus.judul_kasus', $search)
                ->orLike('jenis_kasus.nama_jenis', $search)
                ->orLike('kasus.pelapor_nama', $search)
                ->orLike('kasus.status', $search)
                ->orLike('kasus.prioritas', $search)
                ->groupEnd();
        }

        // Order
        if (isset($columns[$orderColumn])) {
            if ($orderColumn == 2) { // nama_jenis
                $builder->orderBy('jenis_kasus.nama_jenis', $orderDir);
            } else {
                $builder->orderBy($columns[$orderColumn], $orderDir);
            }
        } else {
            $builder->orderBy('kasus.created_at', 'desc');
        }

        // Get total records
        $totalRecords = $builder->countAllResults(false);

        // Pagination
        $data = $builder->limit($length, $start)->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $this->countAll(),
            'recordsFiltered' => $totalRecords
        ];
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');

        return [
            'total' => $this->countAll(),
            'hari_ini' => $this->where('DATE(created_at)', $today)->countAllResults(),
            'bulan_ini' => $this->where('DATE_FORMAT(created_at, "%Y-%m")', $thisMonth)->countAllResults(),
            'dilaporkan' => $this->where('status', 'dilaporkan')->countAllResults(),
            'dalam_proses' => $this->where('status', 'dalam_proses')->countAllResults(),
            'selesai' => $this->where('status', 'selesai')->countAllResults(),
            'ditutup' => $this->where('status', 'ditutup')->countAllResults(),
            'prioritas_tinggi' => $this->where('prioritas', 'tinggi')->countAllResults(),
            'prioritas_darurat' => $this->where('prioritas', 'darurat')->countAllResults()
        ];
    }

    /**
     * Get kasus terbaru
     */
    public function getKasusTerbaru($limit = 5)
    {
        return $this->select('kasus.*, jenis_kasus.nama_jenis')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->orderBy('kasus.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadge($status)
    {
        $badges = [
            'dilaporkan' => '<span class="badge badge-warning">Dilaporkan</span>',
            'dalam_proses' => '<span class="badge badge-info">Dalam Proses</span>',
            'selesai' => '<span class="badge badge-success">Selesai</span>',
            'ditutup' => '<span class="badge badge-secondary">Ditutup</span>'
        ];

        return $badges[$status] ?? '<span class="badge badge-light">' . ucfirst($status) . '</span>';
    }

    /**
     * Get prioritas badge color
     */
    public function getPrioritasBadge($prioritas)
    {
        $badges = [
            'rendah' => '<span class="badge badge-light">Rendah</span>',
            'sedang' => '<span class="badge badge-primary">Sedang</span>',
            'tinggi' => '<span class="badge badge-warning">Tinggi</span>',
            'darurat' => '<span class="badge badge-danger">Darurat</span>'
        ];

        return $badges[$prioritas] ?? '<span class="badge badge-light">' . ucfirst($prioritas) . '</span>';
    }

    /**
     * Get data for DataTables with search functionality (for RESKRIM access)
     */
    public function getDataTableData($search = '', $start = 0, $length = 10, $orderColumn = 'created_at', $orderDir = 'desc')
    {
        // Ensure parameters are of correct type
        $start = (int) $start;
        $length = (int) $length;
        $search = (string) $search;
        $orderColumn = (string) $orderColumn;
        $orderDir = (string) $orderDir;

        $builder = $this->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.telepon as pelapor_telepon')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('kasus.nomor_kasus', $search)
                ->orLike('kasus.judul_kasus', $search)
                ->orLike('jenis_kasus.nama_jenis', $search)
                ->orLike('kasus.pelapor_nama', $search)
                ->orLike('pelapor.nama', $search)
                ->orLike('kasus.status', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $builder->orderBy($orderColumn, $orderDir)
            ->limit($length, $start);

        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'total' => $total
        ];
    }

    /**
     * Get kasus with pelapor data (for RESKRIM detail view)
     */
    public function getWithPelapor($id)
    {
        return $this->select('kasus.*, jenis_kasus.nama_jenis as jenis_kasus_nama, pelapor.nama as pelapor_nama, pelapor.nik as pelapor_nik, pelapor.telepon as pelapor_telepon, pelapor.email as pelapor_email, pelapor.alamat as pelapor_alamat')
            ->join('jenis_kasus', 'jenis_kasus.id = kasus.jenis_kasus_id', 'left')
            ->join('pelapor', 'pelapor.id = kasus.pelapor_id', 'left')
            ->where('kasus.id', $id)
            ->first();
    }
}
