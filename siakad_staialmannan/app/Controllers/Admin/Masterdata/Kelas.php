<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use Config\Services;

class Kelas extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->kelas = new KelasModel($request);
        $this->halaman_controller = "kelas";
        $this->halaman_label = "Kelas";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->kelas->find($this->request->getVar('id'));
                if($dt['kd_kelas']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->kelas->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->kelas->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("masterdata/$this->halaman_controller/detail/").$list->kd_kelas;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->kd_kelas.'" />';
                $row[] = $list->kd_kelas;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kdta])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $list->kdta])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->jenjang." - ".$list->prodi;
                $row[] = $list->kelas;
                $row[] = $list->smt;
                $row[] = (!empty(getCount('akademik_krs', ['kode_kelas' => $list->kd_kelas, 'stat_mhs' => 'A'], 'kode_kelas', 'kode_kelas')))?getCount('akademik_krs', ['kode_kelas' => $list->kd_kelas, 'stat_mhs' => 'A'], 'kode_kelas', 'kode_kelas')['kode_kelas']:'0';
                $row[] = (!empty(getCount('akademik_krs', ['kode_kelas' => $list->kd_kelas, 'stat_mhs !=' => 'A'], 'kode_kelas', 'kode_kelas')))?getCount('akademik_krs', ['kode_kelas' => $list->kd_kelas, 'stat_mhs !=' => 'A'], 'kode_kelas', 'kode_kelas')['kode_kelas']:'0';
                $row[] = '<a onclick="hapus('."'".$list->kd_kelas."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-bars"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->kelas->countAll(),
                'recordsFiltered' => $this->kelas->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->master_mk->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            
            $aturan = [
                'kdta' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun akademik!!'
                    ]
                ],
                'prodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih prodi!!'
                    ]
                ],
                'kelas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih Kelas!!'
                    ]
                ],
                'smt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih semester!!'
                    ]
                ],
                'jenjang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih jenjang!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
            }else{
                // Ambil semua kelas aktif dari ref_option
                $db      = \Config\Database::connect();
                $kelasList = $db->table('ref_option')
                                ->select('opt_id')
                                ->where('opt_group', 'program_kelas')
                                ->where('is_aktif', 'Y')
                                ->get()
                                ->getResultArray();
    
                // Buat mapping kelas -> kode integer (PA=0, PI=1, A=2, B=3, dst)
                $kelasMapping = [];
                $kodeCounter = 0;
                foreach ($kelasList as $row) {
                    $kelasMapping[$row['opt_id']] = $kodeCounter;
                    $kodeCounter++;
                }
                
                $record = [];
                foreach ($this->request->getVar('prodi') as $prodi) {
                    $p = getDataRow('prodi', ['singkatan' => $prodi])['kode_prodi_kop'];
                    foreach ($this->request->getVar('kelas') as $kelas) {
                        $k = isset($kelasMapping[$kelas]) ? $kelasMapping[$kelas] : 99;
                        
                        for($i = 0;$i < count($this->request->getVar('smt'));$i++){
                           array_push($record, [
                                'kd_kelas' => $this->request->getVar('kdta').$p.$k.$this->request->getVar('smt')[$i],
                                'kdta' => $this->request->getVar('kdta'),
                                'jenjang' => $this->request->getVar('jenjang'),
                                'prodi' => $prodi,
                                'kelas' => $kelas,
                                'smt' => $this->request->getVar('smt')[$i]
                            ]);
                        }
                        
                    }
                }
                
                //$aksi = $model->simpanData($record);
                
                $db      = \Config\Database::connect();
                $builder = $db->table('kelas_kuliah');
                if($builder->insertBatch($record)){
                    echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                }else{
                    echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));

                }
                /*
                if($this->kelas->save($record)){
                    echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                }else{
                    echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));

                }*/

            }
            
        }
        
    }
    
    public function detail($kd_kelas=null){
        
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id') && $this->request->getVar('tabel') == 'distribusi_mk'){
                $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
                $dt = $distribusiMK->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $distribusiMK->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
            
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id') && $this->request->getVar('tabel') == 'krs'){
                $krsModel = new \App\Models\KrsModel($this->request);
                $dt = $krsModel->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    
                    $record_smt = [
                        'id' => getDataRow('histori_pddk',['id_his_pdk' => $dt['id_his_pdk']])['id_data_diri'],
                        'smt_aktif' => intval($dt['semester'])-1
                    ];
                    
                    $aksi = $krsModel->delete($this->request->getVar('id'));
                    if($aksi == true){
                        $mhsModel = new \App\Models\MahasiswaModel($this->request);
                        $mhsModel->save($record_smt);
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
        
        $data = $this->kelas->find($kd_kelas);
        $data['templateJudul'] = "Detail ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listMkKelas()
    {
        $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $distribusiMK->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("masterdata/$this->halaman_controller/detail/").$list->id;
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Nama_Dosen;
                $row[] = '<a onclick="hapus('."'distribusi_mk','".$list->id."','".str_replace("'", "`",$list->Mata_Kuliah)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <!--<a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a> -->
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $distribusiMK->countAll(),
                'recordsFiltered' => $distribusiMK->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function listMhsKelas()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
    
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $krsModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            $skipped = []; // untuk menampung data yang gagal diproses
    
            foreach ($lists as $list) {
                try {
                    // --- Status Mahasiswa ---
                    if ($list->stat_mhs == 'A') {
                        $stat_mhs = '<span class="badge badge-success">Aktif</span>';
                    } elseif ($list->stat_mhs == 'N') {
                        $stat_mhs = '<span class="badge badge-danger">Non-Aktif</span>';
                    } elseif ($list->stat_mhs == 'C') {
                        $stat_mhs = '<span class="badge badge-warning">Cuti</span>';
                    } elseif ($list->stat_mhs == 'U') {
                        $stat_mhs = '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
                    } elseif ($list->stat_mhs == 'M') {
                        $stat_mhs = '<span class="badge badge-primary">Kampus Merdeka</span>';
                    } elseif ($list->stat_mhs == 'G') {
                        $stat_mhs = '<span class="badge badge-grey">Sedang Double Degree</span>';
                    } else {
                        $stat_mhs = '<span class="badge badge-secondary">Tidak Diketahui</span>';
                    }
    
                    // --- Ambil ID data diri ---
                    $histori = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk]);
                    if (!$histori) {
                        $skipped[] = [
                            'NIM' => $list->NIM,
                            'Nama' => $list->Nama_Lengkap,
                            'Alasan' => 'Histori pendidikan tidak ditemukan'
                        ];
                        continue; // skip data ini
                    }
    
                    $id_data_diri = $histori['id_data_diri'];
    
                    $dataDiri = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri]);
                    if (!$dataDiri) {
                        $skipped[] = [
                            'NIM' => $list->NIM,
                            'Nama' => $list->Nama_Lengkap,
                            'Alasan' => 'Data diri mahasiswa tidak ditemukan'
                        ];
                        continue;
                    }
    
                    $th_angkatan = intval(substr($dataDiri['th_angkatan'], 0, 4));
    
                    // --- Hitung Semester Keberapa ---
                    $kode_kelas = $this->request->getVar('kode_kelas');
                    $prefix = intval(substr($kode_kelas, 0, 5));
                    if ($prefix % 2 != 0) {
                        $a = (($prefix + 10) - 1) / 10;
                        $b = $a - $th_angkatan;
                        $c = ($b * 2) - 1;
                    } else {
                        $a = (($prefix + 10) - 2) / 10;
                        $b = $a - $th_angkatan;
                        $c = $b * 2;
                    }
    
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->NIM;
                    $row[] = $list->Nama_Lengkap;
                    $row[] = $dataDiri['th_angkatan'];
                    $row[] = $list->semester . " / " . $c;
                    $row[] = $stat_mhs;
                    $row[] = '<a onclick="hapus(' . "'krs','" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>';
                    $data[] = $row;
                } catch (\Throwable $e) {
                    // Jika ada error, simpan data mahasiswa yang gagal diproses
                    $skipped[] = [
                        'NIM' => $list->NIM,
                        'Nama' => $list->Nama_Lengkap,
                        'Alasan' => $e->getMessage()
                    ];
                }
            }
    
            // Untuk debugging: tampilkan skipped data di console log
            if (!empty($skipped)) {
                file_put_contents(WRITEPATH . 'logs/skipped_mhs.log', json_encode($skipped, JSON_PRETTY_PRINT), FILE_APPEND);
            }
    
            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $krsModel->countAll(),
                'recordsFiltered' => $krsModel->countFiltered(),
                'data' => $data,
                'skipped' => $skipped // opsional: bisa dikirim ke frontend untuk dicek
            ];
    
            echo json_encode($output);
        }
}


    
    function tambah_mk(){
        $data = [];
        
        if($this->request->getVar('kd_kelas')){
			$data = $this->kelas->find($this->request->getVar('kd_kelas'));
		}
        
        $data['templateJudul'] = "Tambah Matakuliah ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tambah_mk';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listMatkulKurikulum()
    {
        $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
        $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            
            $listMatkulKurikulum = $matkulKurikulumModel->getDatatables();
            $listdistribusiMK = $distribusiMK->getDatatables();

            $result_MatkulKurikulum = $this->set_key_data($listMatkulKurikulum);
            $result_distribusiMK = $this->set_key_data($listdistribusiMK);

            foreach ($result_MatkulKurikulum as $index => $item) {
                if (isset($result_distribusiMK[$index]))
                    unset($result_MatkulKurikulum[$index]);
            }

            $lists = array_values($result_MatkulKurikulum);

            $data = [];
            
            //$lists = $matkulKurikulumModel->getDatatables();
            //$data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_matkul_kurikulum;
                $no++;
                $row = [];
                $row[] = '<a onclick="simpanMkKelas('."'".$list->id_matkul_kurikulum."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>';
                $row[] = $no;
                $row[] = $list->kode_mk;
                $row[] = $list->nama_mk;
                $row[] = $list->bobot_mk;
                $row[] = $list->smt;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $matkulKurikulumModel->countAll(),
                'recordsFiltered' => $matkulKurikulumModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    private function set_key_data($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->id_matkul_kurikulum] = $detail;
        }

        return $return;
    }
    
    function simpanMkKelas()
    {
        
        $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
        
        if($this->request->getMethod()=="post"){
            $id_mastermk = getDataRow('matkul_kurikulum',['id_matkul_kurikulum' => $this->request->getVar('id_matkul_kurikulum')])['id_mk'];
            $record = [
				'id_matkul_kurikulum'=> $this->request->getVar('id_matkul_kurikulum'),
				'kode_kelas'=> $this->request->getVar('kd_kelas'),
				'Kd_Tahun'=> getDataRow('kelas_kuliah',['kd_kelas' => $this->request->getVar('kd_kelas')])['kdta'],
				'Kode_MK_Feeder'=> getDataRow('master_matakuliah',['id_mastermk' => $id_mastermk])['kode_mk'],
				'Mata_Kuliah'=> getDataRow('master_matakuliah',['id_mastermk' => $id_mastermk])['nama_mk'],
				'SKS'=> getDataRow('master_matakuliah',['id_mastermk' => $id_mastermk])['bobot_mk'],
				'Prodi'=> getDataRow('kelas_kuliah',['kd_kelas' => $this->request->getVar('kd_kelas')])['prodi'],
				'SMT'=> getDataRow('matkul_kurikulum',['id_matkul_kurikulum' => $this->request->getVar('id_matkul_kurikulum')])['smt'],
				'Kelas'=> getDataRow('kelas_kuliah',['kd_kelas' => $this->request->getVar('kd_kelas')])['kelas']
            ];
            $aksi = $distribusiMK->simpanData($record);
            if($aksi != false){
                return json_encode(array("msg" => "success", "pesan" => "Matakuliah berhasil ditambahkan."));
            }else{
                return json_encode(array("msg" => "error", "pesan" => "Matakuliah gagal ditambahkan."));
            };
        }
    }
    
    function tambah_mhs1(){
        $data = [];
        
        if($this->request->getVar('kd_kelas')){
			$data = $this->kelas->find($this->request->getVar('kd_kelas'));
		}
        
        $data['templateJudul'] = "Tambah Mahasiswa Dari Kelas Sebelumnya";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tambah_mhs1';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function tambah_mhs2(){
        $data = [];
        
        if($this->request->getVar('kd_kelas')){
			$data = $this->kelas->find($this->request->getVar('kd_kelas'));
		}
        
        $data['templateJudul'] = "Tambah Mahasiswa Baru";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tambah_mhs2';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function simpanMhsKelas()
    {
        
        $krsModel = new \App\Models\KrsModel($this->request);
        $mhsModel = new \App\Models\MahasiswaModel($this->request);

        // dd($this->request->getVar());
        
        if($this->request->getMethod()=="post"){
            $id_data_diri = getDataRow('histori_pddk',['id_his_pdk' => $this->request->getVar('id_his_pdk')])['id_data_diri'];
            $record = [
				//'id_mhs'=> $get_data['id_mhs'],// Mulai Tahun 2023/2024 Genap tidak Dipakai
    			'id_his_pdk'=> $this->request->getVar('id_his_pdk'),
    			'kode_kelas'=> $this->request->getVar('kode_kelas'),
    			'NIM'=> getDataRow('histori_pddk',['id_his_pdk'=>$this->request->getVar('id_his_pdk')])['NIM'],
    			'semester'=> intval(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['smt_aktif'])+1,
    			'kode_ta'=> getDataRow('kelas_kuliah',['kd_kelas'=>$this->request->getVar('kode_kelas')])['kdta'],
    			'status_bayar'=> 0
            ];
            $record_smt =[
                'id' => $id_data_diri,
                'smt_aktif'=> intval(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['smt_aktif'])+1,
            ];
            // dd( $record_smt);

            $aksi = $krsModel->simpanData($record);
            if($aksi != false){
                $mhsModel->save($record_smt);
                return json_encode(array("msg" => "success", "pesan" => "Mahasiswa berhasil ditambahkan."));
            }else{
                return json_encode(array("msg" => "error", "pesan" => "Mahasiswa gagal ditambahkan."));
            };
        }
    }
    
    private function set_key_data_peserta($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->id_his_pdk] = $detail;
        }

        return $return;
    }
    function listPesertaKelasSebelumnya()
    {
       
        $krsModel = new \App\Models\KrsModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            
            $dtKelasLama = dataDinamis('akademik_krs', ['kode_kelas' => $this->request->getVar('kode_kelas_lama')]);
            $dtKelasBaru = $krsModel->getDatatables();

            $result_KelasLama = $this->set_key_data_peserta($dtKelasLama);
            $result_KelasBaru = $this->set_key_data_peserta($dtKelasBaru);

            foreach ($result_KelasLama as $index => $item) {
                if (isset($result_KelasBaru[$index]))
                    unset($result_KelasLama[$index]);
            }

            $lists = array_values($result_KelasLama);

            $data = [];
            
            
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_matkul_kurikulum;
                $dtHisPdk = getDataRow('histori_pddk',['id_his_pdk' => $list->id_his_pdk]);
                //menghitung semester
                if ($this->request->getVar('kode_th_lalu') %2 != 0){
                	$a = (($this->request->getVar('kode_th_lalu') + 10)-1)/10;
                	$b = $a - intval(substr(getDataRow('db_data_diri_mahasiswa',['id' => $dtHisPdk['id_data_diri']])['th_angkatan'], 0, 4));
                	$c = ($b*2)-1;
                	
                }else{
                	$a = (($this->request->getVar('kode_th_lalu') + 10)-2)/10;
                	$b = $a - intval(substr(getDataRow('db_data_diri_mahasiswa',['id' => $dtHisPdk['id_data_diri']])['th_angkatan'], 0, 4));
                	$c = $b * 2;
                }
                //Akhir Menghitung semester
                if($list->stat_mhs=='A'){
    			    $stat_mhs= '<span class="badge badge-success">Aktif</span>';
    			}elseif($list->stat_mhs=='N'){
    			    $stat_mhs= '<span class="badge badge-danger">Non-Aktif</span>';
    			}elseif($list->stat_mhs=='C'){
    			    $stat_mhs= '<span class="badge badge-warning">Cuti</span>';
    			}elseif($list->stat_mhs=='U'){
    			    $stat_mhs= '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
    			}elseif($list->stat_mhs=='M'){
    			    $stat_mhs= '<span class="badge badge-primary">Kampus Merdeka</span>';
    			}elseif($list->stat_mhs=='G'){
    			    $stat_mhs= '<span class="badge badge-grey">Sedang Double Degree</span>';
    			}elseif($list->stat_mhs==null){
    			    $stat_mhs= '<span class="badge badge-success">MHS Baru</span>';
    			}
                $no++;
                $row = [];
                $row[] = '<a onclick="simpanMhsKelas('."'".$list->id_his_pdk."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>';
                $row[] = $no;
                $row[] = $dtHisPdk['NIM'];
                $row[] = getDataRow('db_data_diri_mahasiswa',['id' => $dtHisPdk['id_data_diri']])['Nama_Lengkap'];
                $row[] = $dtHisPdk['Prodi'];
                $row[] = $dtHisPdk['Program'];
                $row[] = getDataRow('db_data_diri_mahasiswa',['id' => $dtHisPdk['id_data_diri']])['kelas'];
                $row[] = getDataRow('db_data_diri_mahasiswa',['id' => $dtHisPdk['id_data_diri']])['th_angkatan'];
                $row[] = $c;
                $row[] = $stat_mhs;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $matkulKurikulumModel->countAll(),
                //'recordsFiltered' => $matkulKurikulumModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function listPesertaKelasBaru()
    {
        
        $mhsModel = new \App\Models\MahasiswaModel($this->request);
        //$pesertaKelasLalu = dataDinamis('akademik_krs', ['kode_kelas' => $this->request->getVar('kelas_lalu')]);
        
        if ($this->request->getMethod(true) === 'POST') {
            
            $dtMhsKelas = dataDinamis('akademik_krs', ['kode_kelas' => $this->request->getVar('kode_kelas')]);
            $dtMhsBaru = $mhsModel->getDatatables();

            $result_MhsBaru = $this->set_key_data_peserta($dtMhsBaru);
            $result_MhsKelas = $this->set_key_data_peserta($dtMhsKelas);

            foreach ($result_MhsBaru as $index => $item) {
                if (isset($result_MhsKelas[$index]))
                    unset($result_MhsBaru[$index]);
            }

            $lists = array_values($result_MhsBaru);

            $data = [];
            
            
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_matkul_kurikulum;
                $dtHisPdk = getDataRow('histori_pddk',['id_his_pdk' => $list->id_his_pdk]);
                
                if($list->stat_mhs=='A'){
    			    $stat_mhs= '<span class="badge badge-success">Aktif</span>';
    			}elseif($list->stat_mhs=='N'){
    			    $stat_mhs= '<span class="badge badge-danger">Non-Aktif</span>';
    			}elseif($list->stat_mhs=='C'){
    			    $stat_mhs= '<span class="badge badge-warning">Cuti</span>';
    			}elseif($list->stat_mhs=='U'){
    			    $stat_mhs= '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
    			}elseif($list->stat_mhs=='M'){
    			    $stat_mhs= '<span class="badge badge-primary">Kampus Merdeka</span>';
    			}elseif($list->stat_mhs=='G'){
    			    $stat_mhs= '<span class="badge badge-grey">Sedang Double Degree</span>';
    			}elseif($list->stat_mhs==null){
    			    $stat_mhs= '<span class="badge badge-success">MHS Baru</span>';
    			}
                $no++;
                $row = [];
                $row[] = '<a onclick="simpanMhsKelas('."'".$list->id_his_pdk."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>';
                $row[] = $no;
                $row[] = getDataRow('ref_option',['opt_group'=>'jns_pendaftaran', 'opt_id'=>$list->jns_daftar])['opt_val'];
                $row[] = $list->No_Pendaftaran;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = $list->Program;
                $row[] = $list->kelas;
                $row[] = $list->th_angkatan;
                $row[] = $stat_mhs;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $matkulKurikulumModel->countAll(),
                //'recordsFiltered' => $matkulKurikulumModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
}
