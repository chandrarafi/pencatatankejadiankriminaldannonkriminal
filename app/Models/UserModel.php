<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'fullname',
        'nrp',
        'role',
        'is_active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'is_active' => 'boolean',
    ];
    protected array $castHandlers = [];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'fullname' => 'required|min_length[3]|max_length[255]',
        'role'     => 'required|in_list[spkt,kasium,reskrim,kapolsek]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi',
            'min_length'  => 'Username minimal 3 karakter',
            'max_length'  => 'Username maksimal 100 karakter',
            'is_unique'   => 'Username sudah digunakan',
        ],
        'email' => [
            'required'     => 'Email harus diisi',
            'valid_email'  => 'Format email tidak valid',
            'is_unique'    => 'Email sudah digunakan',
        ],
        'password' => [
            'required'    => 'Password harus diisi',
            'min_length'  => 'Password minimal 6 karakter',
        ],
        'fullname' => [
            'required'    => 'Nama lengkap harus diisi',
            'min_length'  => 'Nama lengkap minimal 3 karakter',
            'max_length'  => 'Nama lengkap maksimal 255 karakter',
        ],
        'role' => [
            'required' => 'Role harus dipilih',
            'in_list'  => 'Role tidak valid',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Hash password sebelum insert/update
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Autentikasi user berdasarkan username/email dan password
     */
    public function authenticate($login, $password)
    {
        $user = $this->where('username', $login)
            ->orWhere('email', $login)
            ->where('is_active', 1)
            ->first();

        if ($user && password_verify($password, $user['password'])) {

            unset($user['password']);
            return $user;
        }

        return false;
    }

    /**
     * Get user berdasarkan role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
            ->where('is_active', 1)
            ->findAll();
    }

    /**
     * Cek apakah user memiliki akses untuk fitur tertentu
     */
    public function hasAccess($userId, $feature)
    {
        $user = $this->find($userId);
        if (!$user) return false;

        $permissions = [
            'spkt' => [
                'kelola_pelapor',
                'kelola_jenis_kasus',
                'kelola_kasus',
                'lihat_piket'
            ],
            'kasium' => [
                'kelola_anggota',
                'kelola_piket'
            ],
            'reskrim' => [
                'lihat_kasus',
                'kelola_korban',
                'kelola_tersangka',
                'kelola_saksi',
                'lihat_pelapor',
                'lihat_piket',
                'lihat_semua_laporan'
            ],
            'kapolsek' => [
                'lihat_semua_laporan'
            ]
        ];

        return in_array($feature, $permissions[$user['role']] ?? []);
    }
}
