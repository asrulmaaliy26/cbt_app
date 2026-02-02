<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class SkripsiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'munaqasyah_skripsi';
    protected $primaryKey       = 'id_munaqasyah';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_munaqasyah', 'tahun_akademik', 'gel', 'id_mhs', 'id_his_pdk', 'prodi', 'SMT_mhs', 'dosen_pembimbing', 'judul_skripsi', 'abstrak', 'rumusan', 
                                    'kesimpulan', 'kwitansi_pendaftaran', 'v_kwitansi', 'bebas_bak', 'v_bebas_bak', 'sertifikat_kkn', 'v_sertifikat_kkn', 'posmaru', 'v_posmaru', 
                                    'ppl', 'v_ppl', 'khs', 'v_khs', 'kartu_bimbingan', 'v_kartu_bimbingan', 'sertifikat_seminar', 'v_sertifikat_seminar', 'ktm', 'v_ktm', 
                                    'kuesioner', 'v_kuesioner', 'skripsi', 'v_skripsi', 'persetujuan_munaqasyah', 'v_persetujuan_munaqasyah', 'powerpoint', 'v_powerpoint', 
                                    'plagiasi', 'v_plagiasi', 'toefl_toafl', 'v_toefl_toafl', 'bab1', 'v_bab1', 'bab2', 'v_bab2', 'bab3', 'v_bab3', 'bab4', 'v_bab4', 'bab5', 
                                    'v_bab5', 'bab6', 'v_bab6', 'bag_depan', 'v_bag_depan', 'pustaka', 'v_pustaka', 'lampiran', 'v_lampiran', 'penguji_1', 'penguji_2', 'penguji_3', 
                                    'tgl_sidang', 'jam', 'catatan_verifikator', 'status', 'revisi', 'pengesahan_revisi', 'tgl_dibuat', 'link_jurnal'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_dibuat';
    protected $updatedField  = 'tgl_update';
    //protected $deletedField  = 'deleted_at';
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['h.NIM'];
    protected $column_search = ['m.Nama_Lengkap', 'munaqasyah_skripsi.judul_skripsi'];
    protected $order = ['munaqasyah_skripsi.tahun_akademik, munaqasyah_skripsi.tgl_update' => 'DESC'];
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
            $this->dt->where('munaqasyah_skripsi.tahun_akademik', $this->request->getVar('tahun_akademik'));
        }
        if($this->request->getVar('prodi'))
        {
            $this->dt->where('h.Prodi', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('stat'))
        {
            $this->dt->where('munaqasyah_skripsi.status', $this->request->getVar('stat'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('munaqasyah_skripsi.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        
        if(session()->get('akun_level') == 'Dosen'){
            if($this->request->getVar('kd_dosen'))
            {
                $this->dt->where('p.kd_dosen', $this->request->getVar('kd_dosen'));
                $this->dt->where('munaqasyah_skripsi.status >', 3);
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
        
        
        $this->dt->select('munaqasyah_skripsi.id_his_pdk, h.NIM, h.Prodi, m.Nama_Lengkap, munaqasyah_skripsi.id_munaqasyah, munaqasyah_skripsi.tahun_akademik, munaqasyah_skripsi.dosen_pembimbing, munaqasyah_skripsi.judul_skripsi, munaqasyah_skripsi.tgl_dibuat, munaqasyah_skripsi.status');
        
        //$this->dt->join('histori_pddk as h','h.id_his_pdk = sempro.id_his_pdk','left');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = munaqasyah_skripsi.id_his_pdk','left');
        $this->dt->join('db_data_diri_mahasiswa as m','m.id = h.id_data_diri','left');
        
        if(session()->get('akun_level') == 'Dosen'){
            $this->dt->join('penguji_skripsi as p','p.id_munaqasyah = munaqasyah_skripsi.id_munaqasyah','left');
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
        
        if (isset($record['id_munaqasyah'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id_munaqasyah', 'UUID()', FALSE);
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
