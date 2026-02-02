<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class TracerStudyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_tracer_study';
    protected $primaryKey       = 'id_tracer';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_mhs', 'id_his_pdk', 'tahun_lulus', 'no_hp', 'alamat', 'pekerjaan_pertama', 'pekerjaan_saat_ini', 'nama_instansi', 'mulai_mencari', 'waktu_tunggu', 'hubungan_ps_dengan_kerja', 'dibuat_pada'];

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
    protected $column_order = ['tb_tracer_study.created_at'];
    protected $column_search = ['d.Nama_Lengkap'];
    protected $order = ['tb_tracer_study.created_at' => 'DESC'];
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
            $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('tahun_lulus'))
        {
            $this->dt->where('tb_tracer_study.tahun_lulus', $this->request->getVar('tahun_lulus'));
        }
        
        //$this->dt->where('jns_keluar', NULL);
        $this->dt->select('h.Prodi, h.NIM, d.Nama_Lengkap, tb_tracer_study.id_tracer, tb_tracer_study.id_mhs, tb_tracer_study.id_his_pdk, tb_tracer_study.tahun_lulus, tb_tracer_study.no_hp, tb_tracer_study.alamat, tb_tracer_study.pekerjaan_pertama, tb_tracer_study.pekerjaan_saat_ini, tb_tracer_study.nama_instansi, tb_tracer_study.mulai_mencari, tb_tracer_study.waktu_tunggu, tb_tracer_study.hubungan_ps_dengan_kerja, tb_tracer_study.dibuat_pada');
        //$this->dt->join('db_pmb as p','d.id=p.id','left');
        $this->dt->join('db_data_diri_mahasiswa as d','tb_tracer_study.id_mhs=d.id','left');
        $this->dt->join('histori_pddk as h','tb_tracer_study.id_his_pdk=h.id_his_pdk','left');

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