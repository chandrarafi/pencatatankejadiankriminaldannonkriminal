<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisKasusModel extends Model
{
    protected $table            = 'jenis_kasus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_jenis',
        'nama_jenis',
        'deskripsi',
        'is_active'
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
        'kode_jenis' => 'required|max_length[20]|is_unique[jenis_kasus.kode_jenis,id,{id}]',
        'nama_jenis' => 'required|max_length[255]',
        'deskripsi'  => 'permit_empty',
        'is_active'  => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'kode_jenis' => [
            'required'   => 'Kode jenis kasus harus diisi',
            'max_length' => 'Kode jenis kasus maksimal 20 karakter',
            'is_unique'  => 'Kode jenis kasus sudah digunakan'
        ],
        'nama_jenis' => [
            'required'   => 'Nama jenis kasus harus diisi',
            'max_length' => 'Nama jenis kasus maksimal 255 karakter'
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
     * Get active jenis kasus for dropdown
     */
    public function getActiveJenisKasus()
    {
        return $this->where('is_active', true)
            ->orderBy('nama_jenis', 'ASC')
            ->findAll();
    }

    /**
     * Get jenis kasus with pagination for DataTables
     */
    public function getJenisKasusForDataTable($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        $columns = ['kode_jenis', 'nama_jenis', 'deskripsi', 'is_active', 'created_at'];

        $builder = $this->builder();

        // Search functionality
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kode_jenis', $search)
                ->orLike('nama_jenis', $search)
                ->orLike('deskripsi', $search)
                ->groupEnd();
        }

        // Order
        if (isset($columns[$orderColumn])) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $builder->orderBy('created_at', 'desc');
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
        return [
            'total' => $this->countAll(),
            'aktif' => $this->where('is_active', true)->countAllResults(),
            'non_aktif' => $this->where('is_active', false)->countAllResults()
        ];
    }
}
