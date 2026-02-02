<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class CutiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_cuti';
    protected $primaryKey       = 'id_cuti';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_ta', 'id_krs', 'id_his_pdk', 'no_hp', 'alasan', 'bukti', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';

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
    protected $column_order = ['tb_cuti.created_at'];
    protected $column_search = ['m.Nama_Lengkap'];
    protected $order = ['tb_cuti.created_at' => 'desc'];
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
            $this->dt->where('tb_cuti.kd_ta', $this->request->getVar('tahun_akademik'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('tb_cuti.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
       
        
        $this->dt->select('tb_cuti.id_cuti, tb_cuti.kd_ta, tb_cuti.id_krs, tb_cuti.id_his_pdk, tb_cuti.status, h.Prodi, h.Program, m.Nama_Lengkap, m.th_angkatan');
        $this->dt->join('histori_pddk as h','tb_cuti.id_his_pdk = h.id_his_pdk','left');
        $this->dt->join('db_data_diri_mahasiswa as m','h.id_data_diri = m.id','left');

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
