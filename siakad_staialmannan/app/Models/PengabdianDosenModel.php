<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PengabdianDosenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_pengabdian';
    protected $primaryKey       = 'id_pengabdian';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul_pengabdian', 'tahun_pengabdian', 'dana_pengabdian', 'tingkat_pengabdian', 'id_staff', 'lokasi_file'];

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
    protected $column_order = ['tahun_pengabdian'];
    protected $column_search = ['judul_pengabdian'];
    protected $order = ['tahun_pengabdian' => 'DESC'];
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
        
        if($this->request->getVar('kd_dosen'))
        {
            $this->dt->where('id_staff', $this->request->getVar('kd_dosen'));
        }
        

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
        
        if (isset($record['id_pengabdian'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 

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
