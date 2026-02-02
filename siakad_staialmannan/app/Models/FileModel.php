<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class FileModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_file';
    protected $primaryKey       = 'id_file';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_group', 'name_file', 'file_deskripsi', 'lokasi_file', 'kd_kelas_perkuliahan', 'id_mk','mime', 'status'];

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
    protected $column_order = ['id_file'];
    protected $column_search = ['name_file', 'file_description'];
    protected $order = ['id_file' => 'ASC'];
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
        if($this->request->getVar('kd_kelas_perkuliahan'))
        {
            $this->dt->where('kd_kelas_perkuliahan', $this->request->getVar('kd_kelas_perkuliahan'));
        }
        
        //$this->dt->select('tb_kurikulum_detail.id_kurikulum_detail, tb_kurikulum_detail.id_tingkat, tb_mapel.kd_mapel, tb_mapel.nm_mapel');
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

    // public function getDatatables()
    // {
    //     $this->getDatatablesQuery();
    //     if ($this->request->getPost('length') != -1)
    //         $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    //     $query = $this->dt->get();
    //     return $query->getResult();
    // }
    public function getDatatables($filter = [])
    {
        $this->getDatatablesQuery();
    
        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                $this->dt->where($key, $val);
            }
        }
    
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
