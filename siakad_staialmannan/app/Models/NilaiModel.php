<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class NilaiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'data_ljk';
    protected $primaryKey       = 'id_ljk';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_ljk', 'id_krs', 't_akad', 'kd_kelas', 'kd_kelas_perkuliahan', 'id_mk', 'id_matkul_kurikulum', 'kode_mk_feeder', 'sks', 'id_mhs', 'id_his_pdk', 'nim', 'smt_mhs', 'prodi_mhs', 'kelas_mhs', 'ljk', 'tgl_upload_ljk_uas', 
                                    'ljk_uts', 'tgl_upload_ljk_uts', 'artikel', 'tgl_upload_artikel', 'tugas', 'tgl_upload_tugas', 'Nilai_UTS', 'Nilai_TGS', 'Nilai_UAS', 'Nilai_Performance', 'Nilai_Akhir', 
                                    'Nilai_Huruf', 'Status_Nilai', 'Rekom_Nilai', 'ket', 'transfer', 'id_ku', 'id_mk_asal', 'id_mk_pengganti', 'cekal_kuliah', 'ctt_uts', 'ctt_uas'];
    
    //Konfigurasi Datatable Serverside
    protected $column_order = ['smt_mhs'];
    protected $column_search = ['kode_mk_feeder'];
    protected $order = ['smt_mhs' => 'ASC'];
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
        if($this->request->getVar('id_his_pdk'))
        {
            $this->dt->where('id_his_pdk', $this->request->getVar('id_his_pdk'));
        }
        if($this->request->getVar('smt'))
        {
            $this->dt->where('smt_mhs', $this->request->getVar('smt'));
        }
        if($this->request->getVar('id_krs'))
        {
            $this->dt->where('id_krs', $this->request->getVar('id_krs'));
        }
        
        if($this->request->getVar('id_mk'))
        {
            $this->dt->where('id_mk', $this->request->getVar('id_mk'));
        }
        
        /*
        $this->dt->select('h.NIM, h.Prodi, m.Nama_Lengkap, m.kelas, m.th_angkatan, akademik_krs.id, akademik_krs.kode_ta, akademik_krs.tgl_krs, akademik_krs.stat_mhs, akademik_krs.id_his_pdk, akademik_krs.semester, 
                            akademik_krs.status_bayar, akademik_krs.sarat_uts, akademik_krs.syarat_krs, akademik_krs.publikasi_pmb, akademik_krs.kwitansi_krs, akademik_krs.berkas_publikasi');
        $this->dt->join('histori_pddk as h','h.id_his_pdk = akademik_krs.id_his_pdk','left');
        $this->dt->join('db_data_diri_mahasiswa as m','m.id = h.id_data_diri','left');
        */
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
        
        if (isset($record['id_ljk'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id_ljk', 'UUID()', FALSE);
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
