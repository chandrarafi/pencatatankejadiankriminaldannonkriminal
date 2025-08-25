<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaporModel extends Model
{
    protected $table            = 'pelapor';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'nik',
        'telepon',
        'email',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_kabupaten',
        'provinsi',
        'kode_pos',
        'jenis_kelamin',
        'tanggal_lahir',
        'pekerjaan',
        'keterangan',
        'is_active',
        'created_by'
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
        'nama'            => 'required|max_length[255]',
        'nik'             => 'permit_empty|max_length[20]',
        'telepon'         => 'permit_empty|max_length[20]',
        'email'           => 'permit_empty|valid_email|max_length[255]',
        'alamat'          => 'permit_empty',
        'kelurahan'       => 'permit_empty|max_length[100]',
        'kecamatan'       => 'permit_empty|max_length[100]',
        'kota_kabupaten'  => 'permit_empty|max_length[100]',
        'provinsi'        => 'permit_empty|max_length[100]',
        'kode_pos'        => 'permit_empty|max_length[10]',
        'jenis_kelamin'   => 'permit_empty|in_list[L,P]',
        'tanggal_lahir'   => 'permit_empty|valid_date',
        'pekerjaan'       => 'permit_empty|max_length[100]',
        'keterangan'      => 'permit_empty',
        'is_active'       => 'permit_empty|in_list[0,1]',
        'created_by'      => 'required|integer|is_not_unique[users.id]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama pelapor harus diisi',
            'max_length' => 'Nama pelapor maksimal 255 karakter'
        ],
        'nik' => [
            'max_length' => 'NIK maksimal 20 karakter'
        ],
        'telepon' => [
            'max_length' => 'Nomor telepon maksimal 20 karakter'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'max_length'  => 'Email maksimal 255 karakter'
        ],
        'jenis_kelamin' => [
            'in_list' => 'Jenis kelamin harus L atau P'
        ],
        'tanggal_lahir' => [
            'valid_date' => 'Format tanggal lahir tidak valid'
        ],
        'created_by' => [
            'required'      => 'Created by harus diisi',
            'integer'       => 'Created by tidak valid',
            'is_not_unique' => 'User tidak ditemukan'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
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
     * Get active pelapor for dropdown
     */
    public function getActivePelapor()
    {
        return $this->where('is_active', true)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get pelapor with pagination for DataTables
     */
    public function getPelaporForDataTable($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        $columns = ['nama', 'nik', 'telepon', 'email', 'kota_kabupaten', 'is_active', 'created_at'];

        $builder = $this->builder();
        $builder->select('pelapor.*, users.fullname as created_by_name')
            ->join('users', 'users.id = pelapor.created_by', 'left');

        // Search functionality
        if (!empty($search)) {
            $builder->groupStart()
                ->like('pelapor.nama', $search)
                ->orLike('pelapor.nik', $search)
                ->orLike('pelapor.telepon', $search)
                ->orLike('pelapor.email', $search)
                ->orLike('pelapor.alamat', $search)
                ->orLike('pelapor.kota_kabupaten', $search)
                ->orLike('pelapor.pekerjaan', $search)
                ->groupEnd();
        }

        // Order
        if (isset($columns[$orderColumn])) {
            if ($orderColumn == 0) { // nama
                $builder->orderBy('pelapor.nama', $orderDir);
            } else {
                $builder->orderBy($columns[$orderColumn], $orderDir);
            }
        } else {
            $builder->orderBy('pelapor.created_at', 'desc');
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
            'aktif' => $this->where('is_active', true)->countAllResults(),
            'non_aktif' => $this->where('is_active', false)->countAllResults(),
            'hari_ini' => $this->where('DATE(created_at)', $today)->countAllResults(),
            'bulan_ini' => $this->where('DATE_FORMAT(created_at, "%Y-%m")', $thisMonth)->countAllResults(),
            'laki_laki' => $this->where('jenis_kelamin', 'L')->countAllResults(),
            'perempuan' => $this->where('jenis_kelamin', 'P')->countAllResults()
        ];
    }

    /**
     * Get pelapor terbaru
     */
    public function getPelaporTerbaru($limit = 5)
    {
        return $this->select('pelapor.*, users.fullname as created_by_name')
            ->join('users', 'users.id = pelapor.created_by', 'left')
            ->orderBy('pelapor.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Search pelapor by name or NIK
     */
    public function searchPelapor($keyword)
    {
        return $this->like('nama', $keyword)
            ->orLike('nik', $keyword)
            ->orLike('telepon', $keyword)
            ->where('is_active', true)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get full address
     */
    public function getFullAddress($pelapor)
    {
        $address = [];

        if (!empty($pelapor['alamat'])) {
            $address[] = $pelapor['alamat'];
        }

        if (!empty($pelapor['kelurahan'])) {
            $address[] = 'Kel. ' . $pelapor['kelurahan'];
        }

        if (!empty($pelapor['kecamatan'])) {
            $address[] = 'Kec. ' . $pelapor['kecamatan'];
        }

        if (!empty($pelapor['kota_kabupaten'])) {
            $address[] = $pelapor['kota_kabupaten'];
        }

        if (!empty($pelapor['provinsi'])) {
            $address[] = $pelapor['provinsi'];
        }

        if (!empty($pelapor['kode_pos'])) {
            $address[] = $pelapor['kode_pos'];
        }

        return implode(', ', $address);
    }

    /**
     * Get data for DataTables with search functionality (for RESKRIM read-only access)
     */
    public function getDataTableData($search = '', $start = 0, $length = 10, $orderColumn = 'created_at', $orderDir = 'desc')
    {
        // Ensure parameters are of correct type
        $start = (int) $start;
        $length = (int) $length;
        $search = (string) $search;
        $orderColumn = (string) $orderColumn;
        $orderDir = (string) $orderDir;

        $builder = $this->select('pelapor.*');

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('nik', $search)
                ->orLike('telepon', $search)
                ->orLike('alamat', $search)
                ->orLike('pekerjaan', $search)
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
}
