<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class ProposalModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sempro';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'tahun', 'gel', 'id_his_pdk', 'nim', 'id_dosen', 'judul', 'rumusan', 'metode_penelitian', 'latar_konteks', 'tujuan', 'kajian_terdahulu', 
                                'konsep_teori', 'rencana_pembahasan', 'daftar_pustaka', 'kwitansi', 'rekom', 'proposal', 'plagiasi', 'v_plagiasi', 'v_kwitansi', 'v_rekom', 
                                'v_proposal', 'catatan_kwitansi', 'catatan_proposal', 'catatan_plagiasi', 'catatan_rekom', 'status', 'catatan_verifikator', 'tgl_seminar', 
                                'revisi', 'pengesahan_revisi', 'id_token_rekom'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'last_modified';
    protected $deletedField  = 'deleted_at';
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['h.NIM'];
    protected $column_search = ['m.Nama_Lengkap', 'sempro.judul'];
    protected $order = ['sempro.tahun, sempro.created_at' => 'DESC'];
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
            $this->dt->where('sempro.tahun', $this->request->getVar('tahun_akademik'));
        }
        
        if($this->request->getVar('stat'))
        {
            $this->dt->where('sempro.status', $this->request->getVar('stat'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('sempro.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        
        if(session()->get('akun_level') == 'Dosen'){
            if($this->request->getVar('kd_dosen'))
            {
                $this->dt->where('p.kd_dosen', $this->request->getVar('kd_dosen'));
                $this->dt->where('sempro.status >', 3);
            }
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
        
        
        $this->dt->select('sempro.id_his_pdk, h.NIM, h.Prodi, m.Nama_Lengkap, sempro.id, sempro.tahun, sempro.id_dosen, sempro.judul, sempro.created_at, sempro.status');
        
        //$this->dt->join('histori_pddk as h','h.id_his_pdk = sempro.id_his_pdk','left');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = sempro.id_his_pdk','left');
        $this->dt->join('db_data_diri_mahasiswa as m','m.id = h.id_data_diri','left');
        if(session()->get('akun_level') == 'Dosen'){
            $this->dt->join('penguji_sempro as p','p.id_sempro = sempro.id','left');
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
