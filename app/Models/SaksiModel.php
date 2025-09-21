<?php

namespace App\Models;

use CodeIgniter\Model;

class SaksiModel extends Model
{
    protected $table            = 'saksi';
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
        'jenis_saksi',
        'hubungan_dengan_korban',
        'hubungan_dengan_tersangka',
        'keterangan_kesaksian',
        'dapat_dihubungi',
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
        'jenis_saksi' => 'required|in_list[korban,ahli,fakta,de_auditu]',
        'hubungan_dengan_korban' => 'permit_empty|max_length[100]',
        'hubungan_dengan_tersangka' => 'permit_empty|max_length[100]',
        'keterangan_kesaksian' => 'permit_empty',
        'dapat_dihubungi' => 'required|in_list[ya,tidak]',
        'keterangan' => 'permit_empty'
    ];
    protected $validationMessages   = [
        'kasus_id' => [
            'required' => 'Kasus harus dipilih',
            'integer' => 'Kasus tidak valid'
        ],
        'nama' => [
            'required' => 'Nama saksi harus diisi',
            'max_length' => 'Nama terlalu panjang (maksimal 255 karakter)'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin tidak valid'
        ],
        'jenis_saksi' => [
            'required' => 'Jenis saksi harus dipilih',
            'in_list' => 'Jenis saksi tidak valid'
        ],
        'dapat_dihubungi' => [
            'required' => 'Status dapat dihubungi harus dipilih',
            'in_list' => 'Status dapat dihubungi tidak valid'
        ]
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
     * Get data for DataTables with search functionality
     */
    public function getDataTableData($search = '', $start = 0, $length = 10, $orderColumn = 'created_at', $orderDir = 'desc')
    {
        $builder = $this->select('saksi.*, kasus.nomor_kasus, kasus.judul_kasus')
            ->join('kasus', 'kasus.id = saksi.kasus_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('saksi.nama', $search)
                ->orLike('saksi.nik', $search)
                ->orLike('saksi.alamat', $search)
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
     * Get saksi by kasus ID
     */
    public function getByKasusId($kasusId)
    {
        return $this->where('kasus_id', $kasusId)->findAll();
    }

    /**
     * Get saksi with kasus details
     */
    public function getWithKasus($id)
    {
        return $this->select('saksi.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.tanggal_kejadian, kasus.lokasi_kejadian')
            ->join('kasus', 'kasus.id = saksi.kasus_id', 'left')
            ->find($id);
    }
}
