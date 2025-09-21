<?php

namespace App\Models;

use CodeIgniter\Model;

class TersangkaModel extends Model
{
    protected $table            = 'tersangka';
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
        'status_tersangka',
        'tempat_penahanan',
        'tanggal_penahanan',
        'pasal_yang_disangkakan',
        'barang_bukti',
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
        'status_tersangka' => 'required|in_list[ditetapkan,ditahan,dibebaskan,buron]',
        'tempat_penahanan' => 'permit_empty|max_length[255]',
        'tanggal_penahanan' => 'permit_empty|valid_date',
        'pasal_yang_disangkakan' => 'permit_empty',
        'barang_bukti' => 'permit_empty',
        'keterangan' => 'permit_empty'
    ];
    protected $validationMessages   = [
        'kasus_id' => [
            'required' => 'Kasus harus dipilih',
            'integer' => 'Kasus tidak valid'
        ],
        'nama' => [
            'required' => 'Nama tersangka harus diisi',
            'max_length' => 'Nama terlalu panjang (maksimal 255 karakter)'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin tidak valid'
        ],
        'status_tersangka' => [
            'required' => 'Status tersangka harus dipilih',
            'in_list' => 'Status tersangka tidak valid'
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

        $start = (int) $start;
        $length = (int) $length;
        $search = (string) $search;
        $orderColumn = (string) $orderColumn;
        $orderDir = (string) $orderDir;

        $builder = $this->select('tersangka.*, kasus.nomor_kasus, kasus.judul_kasus')
            ->join('kasus', 'kasus.id = tersangka.kasus_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('tersangka.nama', $search)
                ->orLike('tersangka.nik', $search)
                ->orLike('tersangka.alamat', $search)
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
     * Get tersangka by kasus ID
     */
    public function getByKasusId($kasusId)
    {
        return $this->where('kasus_id', $kasusId)->findAll();
    }

    /**
     * Get tersangka with kasus details
     */
    public function getWithKasus($id)
    {
        return $this->select('tersangka.*, kasus.nomor_kasus, kasus.judul_kasus, kasus.tanggal_kejadian, kasus.lokasi_kejadian')
            ->join('kasus', 'kasus.id = tersangka.kasus_id', 'left')
            ->find($id);
    }
}
