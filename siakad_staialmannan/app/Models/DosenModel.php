<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DosenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'data_dosen';
    protected $primaryKey       = 'id_dosen';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // protected $allowedFields    = ['Kode', 'username', 'gelar_depan', 'gelar_belakang', 'Nama_Dosen', 'NIY', 'TTL', 'NIDN_NUPN', 'Pangkat_Gol_Ruang', 'Jabatan', 'Status', 'tahun_tugas', 'Program_Studi', 'Alamat', 'profil_sinta', 'email', 'scholar', 'foto'];
    protected $allowedFields = [
        'Kode',
        'gelar_depan',
        'kewarganegaraan',
        'gelar_belakang',
        'Nama_Dosen',
        'NIY',
        'TTL',
        'NIDN_NUPN',
        'Alamat',
        'Alamat_Email',
        'jenis_kelamin',
        'ibu_kandung',
        'status_kawin',
        'Agama',
        'Pangkat_Gol_Ruang',
        'Jabatan',
        'Status',
        'tahun_tugas',
        'Program_Studi',
        'email',
        'profil_sinta',
        'scholar',
        'foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['Kode'];
    protected $column_search = ['Nama_Dosen', 'NIY'];
    protected $order = ['Kode' => 'ASC'];
    protected $request;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        //$this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->table($this->table);

    }

    private function getDatatablesQuery()
    {
        if($this->request->getVar('prodi'))
        {
            $this->dt->where('Program_Studi', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('status_dosen'))
        {
            $this->dt->where('Status', $this->request->getVar('status_dosen'));
        }
        if($this->request->getVar('jabatan_fungsional'))
        {
            $this->dt->where('Jabatan', $this->request->getVar('jabatan_fungsional'));
        }
        if($this->request->getVar('pangkat'))
        {
            $this->dt->where('Pangkat_Gol_Ruang', $this->request->getVar('pangkat'));
        }
        //$this->dt->select('id_dosen', 'Kode', 'username', 'gelar_depan', 'gelar_belakang', 'Nama_Dosen', 'NIY', 'RIGHT(NIY,4) as no_urut', 'TTL', 'NIDN_NUPN', 'Pangkat_Gol_Ruang', 'Jabatan', 'Status', 'Program_Studi', 'Alamat', 'profil_sinta', 'scholar', 'tahun_tugas', 'email', 'foto');
        //$this->dt->join('tb_mapel','tb_mapel.id_mapel = tb_kurikulum_detail.id_mapel','left');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->dt->table($this->table);
        return $tbl_storage->countAllResults();
    }
}