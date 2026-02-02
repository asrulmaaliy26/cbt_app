<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class IjazahModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_ijazah';
    protected $primaryKey       = 'id_ijz';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_ijz', 'tahun', 'id_his_pdk', 'status', 'revisi_skripsi', 'waqaf_buku', 'peminjaman_buku', 'biaya_kuliah', 'biaya_wisuda', 'biaya_pengurusan_ijazah', 'artikel', 'ket'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';
    protected $deletedField  = 'deleted_at';
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['tb_ijazah.created_at'];
    protected $column_search = ['m.Nama_Lengkap'];
    protected $order = ['tb_ijazah.created_at' => 'DESC'];
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
        if($this->request->getVar('tahun_pengajuan'))
        {
            $this->dt->where('tb_ijazah.tahun', $this->request->getVar('tahun_pengajuan'));
        }
        
        if($this->request->getVar('tahun_nim'))
        {
            $this->dt->like('SUBSTRING(REPLACE(h.NIM,".",""),-14,2)', $this->request->getVar('tahun_nim'),'both');
        }
        
        if($this->request->getVar('stat'))
        {
            $this->dt->where('tb_ijazah.status', $this->request->getVar('stat'));
        }
        
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('tb_ijazah.id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        
        if($this->request->getVar('id_data_diri'))
        {
            $id_his_pdk = [];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $this->request->getVar('id_data_diri')]);
            foreach($his_pdk as $r){
                $id_his_pdk[] = $r->id_his_pdk;
            }
            $this->dt->whereIn('tb_ijazah.id_his_pdk', array_values($id_his_pdk));
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
        
        
        $this->dt->select('h.id_his_pdk, h.NIM, h.Prodi, m.Nama_Lengkap, tb_ijazah.id_ijz, tb_ijazah.tahun, tb_ijazah.id_his_pdk, tb_ijazah.status, tb_ijazah.revisi_skripsi, tb_ijazah.waqaf_buku, tb_ijazah.peminjaman_buku, tb_ijazah.biaya_kuliah, tb_ijazah.biaya_wisuda, tb_ijazah.biaya_pengurusan_ijazah, tb_ijazah.artikel, tb_ijazah.ket, tb_ijazah.created_at, tb_ijazah.update_at');
        
        //$this->dt->join('histori_pddk as h','h.id_his_pdk = disposisi_skripsi.id_his_pdk','left');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = tb_ijazah.id_his_pdk','left');
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
        
        if (isset($record['id_ijz'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id_ijz', 'UUID()', FALSE);
            if($builder->save($record)){
                return true;
            }else{
                return false;
            }
            //return $id;
        }
       
    }
}
