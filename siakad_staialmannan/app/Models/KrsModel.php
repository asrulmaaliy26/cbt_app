<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class KrsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'akademik_krs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_mhs', 'id_his_pdk', 'kode_kelas', 'tgl_krs', 'semester', 'kode_ta', 'status_bayar', 'sarat_uts', 'syarat_krs', 'publikasi_pmb',  
                                    'kwitansi_krs', 'berkas_publikasi', 'tgl_reg', 'stat_mhs', 'jml_sks'];
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['h.NIM'];
    protected $column_search = ['m.Nama_Lengkap', 'h.NIM'];
    protected $order = ['akademik_krs.kode_ta, h.NIM ' => 'ASC'];
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
            $this->dt->where('akademik_krs.kode_ta', $this->request->getVar('tahun_akademik'));
        }
        if($this->request->getVar('prodi'))
        {
            $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('kelas'))
        {
            $this->dt->where('h.Kelas', $this->request->getVar('kelas'));
        }
        if($this->request->getVar('program'))
        {
            $this->dt->where('h.Program', $this->request->getVar('program'));
        }
        if($this->request->getVar('th_angkatan'))
        {
            $this->dt->where('m.th_angkatan', $this->request->getVar('th_angkatan'));
        }
        
        if($this->request->getVar('status_mhs'))
        {
            $this->dt->where('akademik_krs.stat_mhs', $this->request->getVar('status_mhs'));
        }
        
        if($this->request->getVar('kode_kelas'))
        {
            $this->dt->where('akademik_krs.kode_kelas', $this->request->getVar('kode_kelas'));
        }
        
        if($this->request->getVar('id_data_diri'))
        {
            $id_his_pdk = [];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $this->request->getVar('id_data_diri')]);
            foreach($his_pdk as $r){
                $id_his_pdk[] = $r->id_his_pdk;
            }
            $this->dt->whereIn('akademik_krs.id_his_pdk', array_values($id_his_pdk));
        }
        
        if($this->request->getVar('fakultas'))
        {
            $prodi = [];
            $dataProdi = dataDinamis('prodi', ['sing_fak' => $this->request->getVar('fakultas')], null, null, null, null, null, 'singkatan');
            foreach ($dataProdi as $val){
                $prodi[] = $val->singkatan;
            }
            $this->dt->whereIn('h.Prodi', $prodi);
        }
        
        
        $this->dt->select('h.NIM, h.Prodi, h.Program, h.Kelas, h.mulai_smt, m.Nama_Lengkap, m.kelas, m.th_angkatan, akademik_krs.id, akademik_krs.kode_ta, akademik_krs.tgl_krs, akademik_krs.stat_mhs, akademik_krs.id_his_pdk, akademik_krs.semester, 
                            akademik_krs.status_bayar, akademik_krs.sarat_uts, akademik_krs.syarat_krs, akademik_krs.publikasi_pmb, akademik_krs.kwitansi_krs, akademik_krs.berkas_publikasi, akademik_krs.jml_sks');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = akademik_krs.id_his_pdk','left');
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
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
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
