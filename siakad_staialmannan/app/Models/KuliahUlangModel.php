<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class KuliahUlangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kuliah_ulang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_his_pdk', 'kd_ta', 'smt', 'jml_mk', 'is_processed'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'last_update';
    protected $deletedField  = 'soft_del';

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
    protected $column_order = ['kuliah_ulang.kd_ta'];
    protected $column_search = ['kuliah_ulang.kd_ta', 'm.Nama_Lengkap'];
    protected $order = ['kuliah_ulang.kd_ta, kuliah_ulang.created_at' => 'desc'];
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
        if($this->request->getVar('tahun_akademik'))
        {
            $this->dt->where('kuliah_ulang.kd_ta', $this->request->getVar('tahun_akademik'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('kuliah_ulang.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        
        $this->dt->select('kuliah_ulang.id_his_pdk, kuliah_ulang.id, kuliah_ulang.kd_ta, kuliah_ulang.jml_mk, kuliah_ulang.is_processed');
        
        $this->dt->join('histori_pddk as h','h.id_his_pdk = kuliah_ulang.id_his_pdk','left');
        $this->dt->join('db_data_diri_mahasiswa as m','m.id = h.id_data_diri','left');
        
        
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
    
    // untuk update / simpan data
    public function simpanData($record)
    {
        
        $builder = $this->table($this->table);
        
        if (isset($record['id'])) {
            $builder->save($record);
            return true;
        } else {
            $builder->set('id', 'UUID()', FALSE);
            if($builder->save($record)){
                return true;
            }else{
                return false;
            }
            //return $id;
        }
        /*
        if($aksi){
            return $id;
        }else{
            return false;
        }*/
    }
}
