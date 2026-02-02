<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class SettingPmbModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'setting_gelombang';
    protected $primaryKey       = 'id_gel';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_gel', 'Tahun_Akademik', 'tahun', 'jenjang', 'Nama_Gelombang', 'Tgl_Mulai', 'Tgl_Akhir', 'Tgl_Tes_Tulis', 'Tgl_Tes_Lisan', 'biaya', 'biaya_s2', 'Aktif', 'info_pendaftaran', 'info_biaya_kuliah', 'persyaratan', 'contact_person', 'Nama_Periode'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    //Konfigurasi Datatable Serverside
    protected $column_order = [];
    protected $column_search = ['Tahun_Akademik'];
    protected $order = ['created_at, tahun' => 'desc'];
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
    
    public function simpanData($data)
    {
        
        $builder = $this->table($this->table);
        /*
        foreach ($data as $key => $value) {
            $data[$key] = bersihkan_html($value);
        }
        */

        if (isset($data['id_gel'])) {
            $builder->save($data);
            return true;
        } else {
            $builder->set('id_gel', 'UUID()', FALSE);
            $builder->insert($data);
            return true;
        }
        
    }
}
