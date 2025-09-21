<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nrp',
        'nama',
        'pangkat',
        'jabatan',
        'unit_kerja',
        'alamat',
        'telepon',
        'email',
        'status',
        'tanggal_masuk',
        'foto',
        'keterangan'
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
        'nrp'     => 'required|min_length[3]|max_length[50]|is_unique[anggota.nrp,id,{id}]',
        'nama'    => 'required|min_length[3]|max_length[255]',
        'pangkat' => 'required|max_length[100]',
        'jabatan' => 'required|max_length[255]',
        'status'  => 'required|in_list[aktif,non_aktif,pensiun,mutasi]',
        'email'   => 'permit_empty|valid_email|max_length[255]',
        'telepon' => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'nrp' => [
            'required'   => 'NRP harus diisi',
            'min_length' => 'NRP minimal 3 karakter',
            'max_length' => 'NRP maksimal 50 karakter',
            'is_unique'  => 'NRP sudah digunakan',
        ],
        'nama' => [
            'required'   => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter',
        ],
        'pangkat' => [
            'required'   => 'Pangkat harus diisi',
            'max_length' => 'Pangkat maksimal 100 karakter',
        ],
        'jabatan' => [
            'required'   => 'Jabatan harus diisi',
            'max_length' => 'Jabatan maksimal 255 karakter',
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list'  => 'Status tidak valid',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'max_length'  => 'Email maksimal 255 karakter',
        ],
        'telepon' => [
            'max_length' => 'Telepon maksimal 20 karakter',
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

    public function getActiveAnggota()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    public function getByNrp($nrp)
    {
        return $this->where('nrp', $nrp)->first();
    }

    public function getAnggotaForDataTable($search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        $columns = ['nrp', 'nama', 'pangkat', 'jabatan', 'status'];

        $builder = $this->builder();


        if (!empty($search)) {
            $builder->groupStart()
                ->like('nrp', $search)
                ->orLike('nama', $search)
                ->orLike('pangkat', $search)
                ->orLike('jabatan', $search)
                ->groupEnd();
        }


        if (isset($columns[$orderColumn])) {
            $builder->orderBy($columns[$orderColumn], $orderDir);
        }


        $totalRecords = $this->countAllResults(false);


        $data = $builder->limit($length, $start)->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $this->countAll(),
            'recordsFiltered' => $totalRecords
        ];
    }

    public function getStatistics()
    {
        return [
            'total_anggota' => $this->countAll(),
            'anggota_aktif' => $this->where('status', 'aktif')->countAllResults(),
            'anggota_non_aktif' => $this->where('status', 'non_aktif')->countAllResults(),
            'anggota_pensiun' => $this->where('status', 'pensiun')->countAllResults(),
        ];
    }
}
