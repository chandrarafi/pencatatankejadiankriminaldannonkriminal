<?php

namespace App\Models;

use CodeIgniter\Model;

class PiketDetailModel extends Model
{
    protected $table            = 'piket_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'piket_id',
        'anggota_id',
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
        'piket_id'   => 'required|integer|is_not_unique[piket.id]',
        'anggota_id' => 'required|integer|is_not_unique[anggota.id]'
    ];

    protected $validationMessages = [
        'piket_id' => [
            'required' => 'Piket ID harus diisi',
            'integer'  => 'Piket ID tidak valid',
            'is_not_unique' => 'Piket tidak ditemukan',
        ],
        'anggota_id' => [
            'required' => 'Anggota harus dipilih',
            'integer'  => 'ID Anggota tidak valid',
            'is_not_unique' => 'Anggota tidak ditemukan',
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
     * Get detail piket dengan data anggota
     */
    public function getPiketDetailWithAnggota($piketId)
    {
        return $this->select('piket_detail.*, anggota.nama, anggota.nrp, anggota.pangkat, anggota.unit_kerja, anggota.jabatan, anggota.email, anggota.telepon')
            ->join('anggota', 'anggota.id = piket_detail.anggota_id', 'left')
            ->where('piket_detail.piket_id', $piketId)
            ->findAll();
    }

    /**
     * Get anggota yang sudah terdaftar dalam piket
     */
    public function getAnggotaInPiket($piketId)
    {
        return $this->select('anggota_id')
            ->where('piket_id', $piketId)
            ->findColumn('anggota_id');
    }

    /**
     * Hapus semua detail anggota dari piket
     */
    public function deleteByPiketId($piketId)
    {
        return $this->where('piket_id', $piketId)->delete();
    }

    /**
     * Bulk insert anggota ke piket
     */
    public function insertAnggotaToPiket($piketId, $anggotaIds, $keterangan = null)
    {
        $data = [];
        foreach ($anggotaIds as $anggotaId) {
            $data[] = [
                'piket_id' => $piketId,
                'anggota_id' => $anggotaId,
                'keterangan' => $keterangan,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        return $this->insertBatch($data);
    }

    /**
     * Cek apakah anggota sudah ada dalam piket
     */
    public function isAnggotaInPiket($piketId, $anggotaId)
    {
        return $this->where('piket_id', $piketId)
            ->where('anggota_id', $anggotaId)
            ->first() !== null;
    }
}
