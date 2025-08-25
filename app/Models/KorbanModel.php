<?php

namespace App\Models;

use CodeIgniter\Model;

class KorbanModel extends Model
{
    protected $table            = 'korban';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kasus_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'umur',
        'alamat',
        'pekerjaan',
        'telepon',
        'email',
        'status_korban',
        'keterangan_luka',
        'hubungan_pelaku',
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
    protected $validationRules      = [
        'kasus_id' => 'required|integer',
        'nama' => 'required|max_length[255]',
        'nik' => 'permit_empty|max_length[20]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'umur' => 'permit_empty|integer|greater_than[0]|less_than[150]',
        'alamat' => 'required',
        'pekerjaan' => 'permit_empty|max_length[100]',
        'telepon' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'status_korban' => 'required|in_list[hidup,meninggal,hilang,luka]',
        'keterangan_luka' => 'permit_empty',
        'hubungan_pelaku' => 'permit_empty|max_length[100]',
        'keterangan' => 'permit_empty'
    ];
    protected $validationMessages   = [
        'kasus_id' => [
            'required' => 'Kasus harus dipilih',
            'integer' => 'Kasus tidak valid'
        ],
        'nama' => [
            'required' => 'Nama korban harus diisi',
            'max_length' => 'Nama terlalu panjang (maksimal 255 karakter)'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin tidak valid'
        ],
        'status_korban' => [
            'required' => 'Status korban harus dipilih',
            'in_list' => 'Status korban tidak valid'
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
     * Get data for DataTables with search functionality
     */
    public function getDataTableData($search = '', $start = 0, $length = 10, $orderColumn = 'created_at', $orderDir = 'desc')
    {
        // Ensure parameters are of correct type
        $start = (int) $start;
        $length = (int) $length;
        $search = (string) $search;
        $orderColumn = (string) $orderColumn;
        $orderDir = (string) $orderDir;

        $builder = $this->select('korban.*, kasus.nomor_kasus, kasus.judul_kasus')
            ->join('kasus', 'kasus.id = korban.kasus_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('korban.nama', $search)
                ->orLike('korban.nik', $search)
                ->orLike('korban.alamat', $search)
                ->orLike('kasus.nomor_kasus', $search)
                ->orLike('kasus.judul_kasus', $search)
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
     * Get korban by kasus ID
     */
    public function getByKasusId($kasusId)
    {
        return $this->where('kasus_id', $kasusId)->findAll();
    }

    /**
     * Get korban with kasus details
     */
    public function getWithKasus($id)
    {
        return $this->select('korban.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.tanggal_kejadian, kasus.lokasi_kejadian')
            ->join('kasus', 'kasus.id = korban.kasus_id', 'left')
            ->find($id);
    }
}
