<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class KurikulumModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kurikulum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kurikulum', 'prodi', 'mulai_berlaku', 'set_aktif', 'jenjang'];

    
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['kurikulum.id'];
    protected $column_search = ['kurikulum.nama_kurikulum', 'kurikulum.prodi'];
    protected $order = ['kurikulum.id' => 'desc'];
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
            $this->dt->where('kurikulum.prodi', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('jenjang'))
        {
            $this->dt->where('kurikulum.jenjang', $this->request->getVar('jenjang'));
        }
        
        $this->dt->select('kurikulum.id, kurikulum.nama_kurikulum, kurikulum.prodi, kurikulum.set_aktif, kurikulum.jenjang, t.tahunAkademik, t.semester');
        $this->dt->join('tahun_akademik as t','t.kode = kurikulum.mulai_berlaku','left');

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
