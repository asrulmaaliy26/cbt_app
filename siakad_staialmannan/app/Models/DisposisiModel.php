<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DisposisiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'disposisi_skripsi';
    protected $primaryKey       = 'id_disposisi';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_disposisi', 'tahun_akademik', 'id_mhs', 'id_his_pdk', 'prodi', 'SMT_mhs', 'judul_disposisi', 'problem_disposisi', 'rumusan_disposisi', 'reviewer', 'tgl_kualifikasi', 'dosen_pembimbing', 'catatan_kaprodi', 
                                    'status', 'file_disposisi', 'kata_kunci', 'tgl_dibuat', 'created_at', 'updated_at', 'deleted_at'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['h.NIM'];
    protected $column_search = ['m.Nama_Lengkap', 'disposisi_skripsi.judul_disposisi'];
    protected $order = ['disposisi_skripsi.created_at' => 'DESC'];
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
            $this->dt->where('disposisi_skripsi.tahun_akademik', $this->request->getVar('tahun_akademik'));
        }
        
        if($this->request->getVar('stat'))
        {
            $this->dt->where('disposisi_skripsi.status', $this->request->getVar('stat'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('disposisi_skripsi.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        
        if($this->request->getVar('id_data_diri'))
        {
            $id_his_pdk = [];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $this->request->getVar('id_data_diri')]);
            foreach($his_pdk as $r){
                $id_his_pdk[] = $r->id_his_pdk;
            }
            $this->dt->whereIn('disposisi_skripsi.id_his_pdk', array_values($id_his_pdk));
        }
        
        if(session()->get('akun_level') == 'Admin'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
            }
        }
        if(session()->get('akun_level') == 'Kaprodi'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
            }else{
                $this->dt->where('h.Prodi', getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian']);
            }
        }
        
        if(session()->get('akun_level') == 'Fakultas'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
            }else{
                $fakultas = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                $prodi = [];
                $dataProdi = dataDinamis('prodi', ['sing_fak' => $fakultas], null, null, null, null, null, 'singkatan');
                foreach ($dataProdi as $val){
                    $prodi[] = $val->singkatan;
                }
                $this->dt->whereIn('h.Prodi', $prodi);
            }
        }
        if(session()->get('akun_level') == 'Dosen'){
            if($this->request->getVar('kd_dosen'))
            {
                $this->dt->where('disposisi_skripsi.reviewer', $this->request->getVar('kd_dosen'));
            }
        }
        
        $this->dt->select('h.id_his_pdk, h.NIM, h.Prodi, m.Nama_Lengkap, disposisi_skripsi.id_disposisi, disposisi_skripsi.tahun_akademik, disposisi_skripsi.id_mhs, disposisi_skripsi.id_his_pdk, disposisi_skripsi.prodi, 
                        disposisi_skripsi.SMT_mhs, disposisi_skripsi.judul_disposisi, disposisi_skripsi.problem_disposisi, disposisi_skripsi.rumusan_disposisi, disposisi_skripsi.dosen_pembimbing, disposisi_skripsi.catatan_kaprodi, disposisi_skripsi.reviewer, disposisi_skripsi.tgl_kualifikasi, 
                        disposisi_skripsi.status, disposisi_skripsi.file_disposisi, disposisi_skripsi.tgl_dibuat, disposisi_skripsi.created_at');
        
        //$this->dt->join('histori_pddk as h','h.id_his_pdk = disposisi_skripsi.id_his_pdk','left');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = disposisi_skripsi.id_his_pdk','left');
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
        
        if (isset($record['id_disposisi'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id_disposisi', 'UUID()', FALSE);
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
