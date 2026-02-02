<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DistribusiMkModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mata_kuliah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_matkul_kurikulum', 'kode_kelas', 'kd_kelas_perkuliahan', 'Kd_Tahun', 'Kd_Dosen', 'Kode_MK_Feeder', 'Mata_Kuliah', 'SKS', 'Prodi', 'SMT', 'Kelas', 'Hari', 
                                    'Tgl', 'Bln', 'Thn', 'Jam', 'Pengawas_1', 'Ruang', 'jns_uas', 'uas_soal', 'jns_tugas', 'tugas', 'jns_uts', 'Hari_UTS', 'Tgl_UTS', 'Bln_UTS', 
                                    'Thn_UTS', 'Jam_UTS', 'Pengawas_UTS', 'Ruang_UTS', 'uts_soal', 'H_Jadwal', 'Jam_Jadwal', 'R_Jadwal', 'status_uts', 'status_uas', 'Pelaksanaan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'last_update';
    protected $deletedField  = 'soft_del';

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
    protected $column_order = [
        null, // untuk checkbox (tidak diurutkan)
        'mata_kuliah.id',
        'mata_kuliah.Kode_MK_Feeder',
        'mata_kuliah.Mata_Kuliah',
        'mata_kuliah.SKS',
        'mata_kuliah.Prodi',
        'mata_kuliah.Kelas',
        'mata_kuliah.SMT',
        'data_dosen.Nama_Dosen',
        'mata_kuliah.H_Jadwal',
        'mata_kuliah.Jam_Jadwal',
        'mata_kuliah.R_Jadwal'
    ];
    protected $column_search = ['mata_kuliah.Mata_Kuliah', 'mata_kuliah.Kode_MK_Feeder', 'data_dosen.Nama_Dosen'];
    protected $order = ['mata_kuliah.Mata_Kuliah' => 'ASC'];
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
            $this->dt->where('mata_kuliah.Kd_Tahun', $this->request->getVar('tahun_akademik'));
        }
        if(session()->get('akun_level') == 'Admin'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('Prodi', $this->request->getVar('prodi'));
            }
        }
        if(session()->get('akun_level') == 'Kaprodi'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('Prodi', $this->request->getVar('prodi'));
            }else{
                $this->dt->where('Prodi', getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian']);
            }
        }
        
        if(session()->get('akun_level') == 'Fakultas'){
            if($this->request->getVar('prodi'))
            {
                $this->dt->where('Prodi', $this->request->getVar('prodi'));
            }else{
                $fakultas = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                $prodi = [];
                $dataProdi = dataDinamis('prodi', ['sing_fak' => $fakultas], null, null, null, null, null, 'singkatan');
                foreach ($dataProdi as $val){
                    $prodi[] = $val->singkatan;
                }
                $this->dt->whereIn('Prodi', $prodi);
            }
        }
        
        if($this->request->getVar('semester'))
        {
            $this->dt->where('mata_kuliah.SMT', $this->request->getVar('semester'));
        }
        if($this->request->getVar('kelas'))
        {
            $this->dt->where('mata_kuliah.Kelas', $this->request->getVar('kelas'));
        }
        if($this->request->getVar('hari'))
        {
            $this->dt->where('H_Jadwal', $this->request->getVar('hari'));
        }
        if($this->request->getVar('jam_kuliah'))
        {
            $this->dt->where('mata_kuliah.Jam_Jadwal', $this->request->getVar('jam_kuliah'));
        }
        if($this->request->getVar('kode_kelas'))
        {
            $this->dt->where('mata_kuliah.kode_kelas', $this->request->getVar('kode_kelas'));
        }
        
        if($this->request->getVar('fakultas'))
        {
            $prodi = [];
            $dataProdi = dataDinamis('prodi', ['sing_fak' => $this->request->getVar('fakultas')], null, null, null, null, null, 'singkatan');
            foreach ($dataProdi as $val){
                $prodi[] = $val->singkatan;
            }
            $this->dt->whereIn('Prodi', $prodi);
        }
        
        //$this->dt->select('tb_kurikulum_detail.id_kurikulum_detail, tb_kurikulum_detail.id_tingkat, tb_mapel.kd_mapel, tb_mapel.nm_mapel');
        $this->dt->join('data_dosen','data_dosen.Kode = mata_kuliah.Kd_Dosen','left');

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
