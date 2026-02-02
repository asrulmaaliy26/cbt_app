<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MahasiswaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'db_data_diri_mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_mhs', 'username', 'th_masuk', 'th_angkatan', 'smt_aktif', 'kelas', 'Nama_Lengkap', 'Jenis_Kelamin', 'Gol_Darah', 'Kota_Lhr', 'Tgl_Lhr', 'Alamat', 'No_Rmh', 'Dusun', 'RT', 'RW', 'Desa', 'Kec', 'Kab', 'Kode_Pos', 'Prov', 
                                    'Tempat_Domisili', 'Jenis_Domisili', 'No_Telp_Hp', 'no_wa', 'No_KTP', 'No_KK', 'Agama', 'Kewarganegaraan', 'Kode_Negara', 'Status_Perkawinan', 'Pekerjaan', 'Biaya_ditanggung', 'Transportasi', 'Status_Asal_Sekolah', 'Nama_Lengkap_SLTA_Asal', 'Jenis_SLTA', 'Kejuruan_SLTA', 
                                    'Alamat_Lengkap_Sekolah_Asal', 'Th_Lulus_SLTA', 'No_Seri_Ijazah_SLTA', 'NISN', 'Anak_Ke', 'Jml_Saudara', 'No_HP', 'Email', 'Penerima_KPS', 'No_KPS', 'Kebutuhan_Khusus', 
                                    'Foto_Diri', 'stat_mhs', 'dosen_wali'];

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
    
    //Konfigurasi Datatable Serverside
    // protected $column_order = ['db_data_diri_mahasiswa.th_masuk'];
    protected $column_order = [
        null,
        // 'db_data_diri_mahasiswa.id',
        'db_data_diri_mahasiswa.th_masuk',
        'db_data_diri_mahasiswa.Nama_Lengkap',
        'h.NIM',
        'h.Program',
        'h.Prodi',
        'h.Kelas'
    
    ];
    protected $column_search = ['db_data_diri_mahasiswa.Nama_Lengkap', 'h.NIM'];
    protected $order = ['db_data_diri_mahasiswa.th_masuk' => 'DESC'];
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
        if($this->request->getVar('program'))
        {
            $this->dt->where('h.Program', $this->request->getVar('program'));
        }
        if($this->request->getVar('th_angkatan'))
        {
            $this->dt->where('db_data_diri_mahasiswa.th_angkatan', $this->request->getVar('th_angkatan'));
        }
        if($this->request->getVar('kelas'))
        {
            $this->dt->where('h.Kelas', $this->request->getVar('kelas'));
        }
        if($this->request->getVar('status_mhs'))
        {
            $this->dt->where('db_data_diri_mahasiswa.stat_mhs', $this->request->getVar('status_mhs'));
        }
        if($this->request->getVar('jenjang'))
        {
            $this->dt->where('h.program_sekolah', $this->request->getVar('jenjang'));
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
        //$this->dt->where('h.jns_keluar', NULL);
        $this->dt->where('h.status', 'A');
        $this->dt->select('db_data_diri_mahasiswa.id, db_data_diri_mahasiswa.th_angkatan, db_data_diri_mahasiswa.th_masuk, db_data_diri_mahasiswa.stat_mhs, db_data_diri_mahasiswa.kelas, db_data_diri_mahasiswa.smt_aktif, db_data_diri_mahasiswa.Nama_Lengkap, db_data_diri_mahasiswa.No_Pendaftaran, h.NIM, h.NIMKO, h.Prodi, h.Program, h.Kelas as kls, h.id_his_pdk, h.jns_daftar');
        $this->dt->join('histori_pddk as h','h.id_data_diri = db_data_diri_mahasiswa.id','inner');
        $this->dt->groupBy('db_data_diri_mahasiswa.id');

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