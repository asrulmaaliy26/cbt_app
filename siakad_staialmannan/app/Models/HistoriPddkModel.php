<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class HistoriPddkModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'histori_pddk';
    protected $primaryKey       = 'id_his_pdk';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_his_pdk', 'id_mhs', 'id_data_diri', 'NIM', 'NIMKO', 'program_sekolah', 'Program', 'Prodi', 'Kelas', 'tgl_masuk', 'tgl_keluar', 'no_seri_ijazah', 'mulai_smt', 'sks_diakui', 'jalur_skripsi', 
                                    'judul_skripsi', 'bln_awal_bimbingan', 'bln_akhir_bimbingan', 'sk_yudisium', 'tgl_sk_yudisium', 'ipk', 'nm_pt_asal', 'nm_prodi_asal', 'jns_daftar', 'jns_keluar', 'keluar_smt', 
                                    'status', 'ket', 'jalur_masuk', 'pembiayaan', 'soft_del', 'last_modified'];

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
    protected $column_order = ['mulai_smt'];
    protected $column_search = ['NIM', 'Prodi'];
    protected $order = ['mulai_smt' => 'ASC'];
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
        if($this->request->getVar('id_data_diri'))
        {
            $this->dt->where('id_data_diri', $this->request->getVar('id_data_diri'));
        }
        
        /*
        if($this->request->getVar('tahun_nim'))
        {
            $this->dt->like('SUBSTRING(REPLACE(NIM,".",""),-14,2)', $this->request->getVar('tahun_nim'),'both');
        }
        
        if($this->request->getVar('prodi'))
        {
            $this->dt->where('Prodi', $this->request->getVar('prodi'));
        }
        
        if($this->request->getVar('program_kuliah'))
        {
            $this->dt->where('Program', $this->request->getVar('program_kuliah'));
        }
        */
        
        //$this->dt->where('jns_keluar', NULL);
        
        /*$this->dt->select('db_data_diri_mahasiswa.id, db_data_diri_mahasiswa.th_angkatan, db_data_diri_mahasiswa.th_masuk, db_data_diri_mahasiswa.stat_mhs, 
                            db_data_diri_mahasiswa.kelas, db_data_diri_mahasiswa.smt_aktif, db_data_diri_mahasiswa.Nama_Lengkap, db_data_diri_mahasiswa.No_Pendaftaran,
                            h.NIM, h.NIMKO, h.Prodi, h.Program, h.id_his_pdk');*/
        //$this->dt->join('histori_pddk as h','h.id_data_diri = db_data_diri_mahasiswa.id','inner');
        
        //$this->dt->groupBy('db_data_diri_mahasiswa.id');

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
        
        if (isset($record['id_his_pdk'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id_his_pdk', 'UUID()', FALSE);
            if($builder->save($record)){
                return true;
            }else{
                return false;
            }
            //return $id;
        }
        
    }
}
