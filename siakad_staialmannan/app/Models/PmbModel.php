<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class PmbModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'db_pmb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'Nama_Lengkap', 'program_sekolah', 'No_Pendaftaran', 'Tahun_Masuk', 'Tgl_Daftar', 'Kelas_Program_Kuliah', 'Prodi_Pilihan_1', 'Prodi_Pilihan_2', 'Jalur_PMB', 'Bukti_Jalur_PMB', 
                                    'Jenis_Pembiayaan', 'Bukti_Jenis_Pembiayaan', 'Status_Pendaftaran', 'NIMKO_Asal', 'Prodi_Asal', 'PT_Asal', 'Jml_SKS_Asal', 'IPK_Asal', 'Semester_Asal', 'Pengantar_Mutasi', 
                                    'Transkip_Asal', 'Legalisir_Ijazah', 'Legalisir_SKHU', 'Copy_KTP', 'Foto_BW_3x3', 'Foto_BW_3x4', 'Foto_Warna_5x6', 'File_Foto_Berwarna', 'Nama_File_Foto', 'Tgl_Tes_Tulis', 
                                    'N_Agama', 'N_Umum', 'N_Psiko', 'N_Jumlah_Tes_Tulis', 'N_Rerata_Tes_Tulis', 'Tgl_Tes_Lisan', 'N_Potensi_Akademik', 'N_Baca_al_Quran', 'N_Baca_Kitab_Kuning', 
                                    'N_Jumlah_Tes_Lisan', 'N_Rearata_Tes_Lisan', 'Jumlah_Nilai', 'Rata_Rata', 'Status_Kelulusan', 'Rekomendasi_1', 'Rekomendasi_2', 'No_SK_Kelulusan', 'Tgl_SK_Kelulusan', 
                                    'Diterima_di_Prodi', 'Biaya_Pendaftaran', 'Bukti_Biaya_Daftar', 'status_valid', 'verifikator', 'reff'];

    // Dates
    //protected $useTimestamps = true;
    //protected $dateFormat    = 'datetime';
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

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
    
    protected $column_order = [
        null, // checkbox
        // null, // nomor urut (tidak bisa sort)
        'db_pmb.id',
        'd.Nama_Lengkap',
        'db_pmb.No_Pendaftaran',
        'db_pmb.Status_Pendaftaran',
        'db_pmb.Tgl_Daftar',
        'db_pmb.program_sekolah',
        'db_pmb.Kelas_Program_Kuliah',
        'db_pmb.Prodi_Pilihan_1',
        'db_pmb.Biaya_Pendaftaran',
        'db_pmb.status_valid',
        'db_pmb.Foto_Diri',
        'db_pmb.reff',
        'db_pmb.stat_mhs'
    ];


    protected $column_search = ['d.Nama_Lengkap'];
    // protected $column_search = [
    //     'db_pmb.Nama_Lengkap'
    // ];

    // protected $order = ['tgl_daftar' => 'ASC'];
    protected $order = ['db_pmb.Tgl_Daftar' => 'DESC'];

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
            $this->dt->where('db_pmb.Prodi_Pilihan_1', $this->request->getVar('prodi'));
        }
        if($this->request->getVar('th_masuk'))
        {
            $this->dt->where('db_pmb.Tahun_Masuk', $this->request->getVar('th_masuk'));
        }
        if($this->request->getVar('program'))
        {
            $this->dt->where('db_pmb.Kelas_Program_kuliah', $this->request->getVar('program'));
        }
        if($this->request->getVar('jenjang'))
        {
            $this->dt->where('db_pmb.program_sekolah', $this->request->getVar('jenjang'));
        }
        //$this->dt->where('jns_keluar', NULL);
        $this->dt->select('d.id, d.th_angkatan, d.th_masuk, d.stat_mhs, 
                            d.kelas, d.smt_aktif, d.Nama_Lengkap, d.Foto_Diri, db_pmb.No_Pendaftaran,
                            db_pmb.program_sekolah, db_pmb.Tahun_Masuk, db_pmb.Status_Pendaftaran, STR_TO_DATE(db_pmb.Tgl_Daftar,"%d-%m-%Y") AS tgl_daftar, db_pmb.Kelas_Program_Kuliah, db_pmb.Prodi_Pilihan_1, db_pmb.Biaya_Pendaftaran, db_pmb.Bukti_Biaya_Daftar, db_pmb.Nama_File_Foto, db_pmb.status_valid, t.tgl_tes, db_pmb.reff');
        //$this->dt->join('db_pmb as p','d.id=p.id','left');
        $this->dt->join('db_data_diri_mahasiswa as d','db_pmb.id=d.id','left');
        $this->dt->join('db_ortu_mhs as o','d.id=o.id','left');
        $this->dt->join('tes_maba as t','db_pmb.id=t.id_camaba','left');
        $this->dt->join('app_user_maba as u','db_pmb.id=u.id_user','left');

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
// ORDERING
        if ($this->request->getPost('order')) {
            $order = $this->request->getPost('order');
            $col_index = $order[0]['column'];
            $dir = $order[0]['dir'];
            if (isset($this->column_order[$col_index]) && $this->column_order[$col_index] != null) {
                $this->dt->orderBy($this->column_order[$col_index], $dir);
            }
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
        // if ($this->request->getPost('order')) {
        //     $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->dt->orderBy(key($order), $order[key($order)]);
        // }
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
    
    function generateNo($tahun_masuk, $program_sekolah)
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk' => $tahun_masuk, 'program_sekolah' => $program_sekolah]);
        $builder->selectMax('No_Pendaftaran', 'no_max');
        $query = $builder->get();
        if($query->getNumRows() > 0){
            foreach ($query->getResult() as $key ) {
                $kd = '';
                $ambilData = substr($key->no_max, -4);
                $increment = intval($ambilData)+1;
                $kd = sprintf('%04s', $increment);
            }
        }else{
            $kd = '0001';
        }

        return $program_sekolah.$tahun_masuk.$kd;
    }

    function grafikS1()
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk >=' => (date('Y') - 4), 'program_sekolah' => 'S1']);
        $builder->select("Tahun_Masuk, COUNT(*) as jumlah");
        $builder->groupBy('Tahun_Masuk');
        //$query = $this->db->query("SELECT Tahun_Masuk, COUNT(*) as jumlah FROM db_pmb WHERE Tahun_Masuk >= YEAR(CURDATE()) - 5 AND program_sekolah = 'S1' GROUP BY Tahun_Masuk");
        return $builder->get()->getResultArray();
    }
    function grafikS2()
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk >=' => (date('Y') - 4), 'program_sekolah' => 'S2']);
        $builder->select("Tahun_Masuk, COUNT(*) as jumlah");
        $builder->groupBy('Tahun_Masuk');
        //$query = $this->db->query("SELECT Tahun_Masuk, COUNT(*) as jumlah FROM db_pmb WHERE Tahun_Masuk >= YEAR(CURDATE()) - 5 AND program_sekolah = 'S1' GROUP BY Tahun_Masuk");
        return $builder->get()->getResultArray();
    }

    function grafikVerifiedS1()
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk >=' => (date('Y') - 4), 'program_sekolah' => 'S1']);
        $builder->select("Tahun_Masuk, COUNT(*) as jumlah, COUNT(CASE WHEN status_valid = '1' THEN status_valid END) as valid, COUNT(CASE WHEN status_valid = '0' THEN status_valid END) as invalid");
        $builder->groupBy('Tahun_Masuk');
        //$query = $this->db->query("SELECT Tahun_Masuk, COUNT(*) as jumlah FROM db_pmb WHERE Tahun_Masuk >= YEAR(CURDATE()) - 5 AND program_sekolah = 'S1' GROUP BY Tahun_Masuk");
        return $builder->get()->getResultArray();
    }

    function grafikVerifiedS2()
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk >=' => (date('Y') - 4), 'program_sekolah' => 'S2']);
        $builder->select("Tahun_Masuk, COUNT(*) as jumlah, COUNT(CASE WHEN status_valid = '1' THEN status_valid END) as valid, COUNT(CASE WHEN status_valid = '0' THEN status_valid END) as invalid");
        $builder->groupBy('Tahun_Masuk');
        //$query = $this->db->query("SELECT Tahun_Masuk, COUNT(*) as jumlah FROM db_pmb WHERE Tahun_Masuk >= YEAR(CURDATE()) - 5 AND program_sekolah = 'S1' GROUP BY Tahun_Masuk");
        return $builder->get()->getResultArray();
    }

    function grafikProdiS1()
    {
        $builder = $this->table($this->table);
        $builder->where(['Tahun_Masuk >=' => (date('Y') - 4), 'program_sekolah' => 'S1']);
        $builder->select("Tahun_Masuk, COUNT(*) as jumlah, COUNT(CASE WHEN Prodi_Pilihan_1 = 'SI' AND status_valid = '1' THEN Prodi_Pilihan_1 END) as si_valid, COUNT(CASE WHEN Prodi_Pilihan_1 = 'MPI' AND status_valid = '1' THEN Prodi_Pilihan_1 END) as mpi_valid, COUNT(CASE WHEN Prodi_Pilihan_1 = 'IAT' AND status_valid = '1' THEN Prodi_Pilihan_1 END) as iat_valid");
        $builder->groupBy('Tahun_Masuk');
        //$query = $this->db->query("SELECT Tahun_Masuk, COUNT(*) as jumlah FROM db_pmb WHERE Tahun_Masuk >= YEAR(CURDATE()) - 5 AND program_sekolah = 'S1' GROUP BY Tahun_Masuk");
        return $builder->get()->getResultArray();
    }
}
