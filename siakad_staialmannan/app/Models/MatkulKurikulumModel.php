<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MatkulKurikulumModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'matkul_kurikulum';
    protected $primaryKey       = 'id_matkul_kurikulum';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kurikulum', 'id_mk', 'smt', 'sks','wajib'];

    
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['matkul_kurikulum.id_matkul_kurikulum'];
    protected $column_search = ['mmk.nama_mk', 'mmk.kode_mk'];
    protected $order = ['matkul_kurikulum.smt' => 'asc'];
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
        if($this->request->getVar('id_kurikulum'))
        {
            $this->dt->where('matkul_kurikulum.id_kurikulum', $this->request->getVar('id_kurikulum'));
        }
        if($this->request->getVar('semester'))
        {
            $this->dt->where('matkul_kurikulum.smt', $this->request->getVar('semester'));
        }
        
        
        $this->dt->select('matkul_kurikulum.id_matkul_kurikulum, matkul_kurikulum.smt, matkul_kurikulum.id_mk as id_mastermk, mmk.kode_mk, mmk.nama_mk, mmk.bobot_mk');
        $this->dt->join('master_matakuliah as mmk','mmk.id_mastermk = matkul_kurikulum.id_mk','left');

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
