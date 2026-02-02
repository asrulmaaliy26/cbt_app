<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\UjianModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ujian extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->ujian = new UjianModel();
        $this->halaman_controller = "ujian";
        $this->halaman_label = "Ujian";
    }
    
    public function index()
    {
        $data = [];
        
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->ujian->find($this->request->getVar('id'));
                if($dt['id_ujian']){ #memastikan ada data
                    
                    $aksi = $this->ujian->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Data berhasil dihapus'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Data gagal dihapus'));
                    }
                   
                }
            }
            
            if($this->request->getVar('aksi')=='simpan'){
                $aturan = [
                    'kd_tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'jenis_ujian' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ]
                ];
    		    if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
                }else{
                    if(empty($this->request->getVar('id_ujian'))){
                        $record = [
                            'id' => $this->request->getVar('jenis_ujian').$this->request->getVar('kd_tahun'),
                            'jenis_ujian' => $this->request->getVar('jenis_ujian'),
                            'semester' => getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester'],
                            'tahun' => getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik'],
                            'kd_tahun' => $this->request->getVar('kd_tahun'),
                            'status' => $this->request->getVar('status'),
                            'stts_ujian' => $this->request->getVar('stts_ujian'),
                            'cek_spp' => $this->request->getVar('cek_spp'),
                            'informasi' => $this->request->getVar('informasi'),
                        ];
                    }else{
                        $record = [
                            'id_ujian' => $this->request->getVar('id_ujian'),
                            'id' => $this->request->getVar('jenis_ujian').$this->request->getVar('kd_tahun'),
                            'jenis_ujian' => $this->request->getVar('jenis_ujian'),
                            'semester' => getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester'],
                            'tahun' => getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik'],
                            'kd_tahun' => $this->request->getVar('kd_tahun'),
                            'status' => $this->request->getVar('status'),
                            'stts_ujian' => $this->request->getVar('stts_ujian'),
                            'cek_spp' => $this->request->getVar('cek_spp'),
                            'informasi' => $this->request->getVar('informasi'),
                        ];
                    }
                    
                    if($this->ujian->save($record)){
                        return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan!!"));
                    }else{
                        return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan!!"));
        
                    }
                    
                }
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){
                $dt = $this->ujian->find($this->request->getVar('id'));
                if($dt['id_ujian']){ #memastikan ada data
                    $record = [
                        'id_ujian' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '1'
                    ];
                    
                    if($this->ujian->save($record)){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Data telah diubah'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Data gagal diubah'));
                    }
                }
            }

            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $dt = $this->ujian->find($this->request->getVar('id'));
                if($dt['id_ujian']){ #memastikan ada data
                    $record = [
                        'id_ujian' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '0'
                    ];
                    
                    if($this->ujian->save($record)){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Data telah diubah'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Data gagal diubah'));
                    }
                }
            }
        }
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A']);
        }
        

        $jumlah_baris = $this->request->getVar('jml_baris');
        if(empty($this->request->getVar('jml_baris'))){
            $jumlah_baris = 10;
        }
        $kata_kunci =$this->request->getVar('kata_kunci');
        
        $group_dataset = 'dt';
        $hasil = $this->ujian->list($jumlah_baris, $kata_kunci, $group_dataset);
        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];
        $data['kata_kunci'] = $kata_kunci;
        $data['jml_baris'] = $jumlah_baris;
        $currentPage = $this->request->getVar('page_dt');
        $data['nomor'] = nomor($currentPage, $jumlah_baris);
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function getData()
    {
        
        $dataUjian = $this->ujian->find($this->request->getVar('id'));

        if(empty($dataUjian)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $dataUjian));
        }
        
    }
    
    
    function detail()
    {
        
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {
            $DetailUjianModel = new \App\Models\DetailUjianModel($this->request);
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){
                $dt = $DetailUjianModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('id')])->find();
                if($dt){ #memastikan ada data
                    $record = [
                        $this->request->getVar('field') => '1'
                    ];
                    $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $this->request->getVar('id')]);
                    
                    if($aksi){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Data telah diaktifkan'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Data gagal diaktifkan'));
                    }
                }
            }
            
            if($this->request->getVar('aksi')=='activateAll'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('kd_kelas_perkuliahan') as $key ) {  
                    $dt = $DetailUjianModel->where(['kd_kelas_perkuliahan' => $key])->first();
                    if($this->request->getVar('jns_ujian') == 'UTS'){
                        $record = [
                                'status_uts' => '1'
                            ];
                        $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $key]);
                        if($aksi){
                            $jmlSukses++;
                        }else{
                            $jmlError++;
                            $listError [] = [
                                'pesan'     => $dt['Mata_Kuliah']." gagal diaktifkan."
                            ];
                        };
                    }
                    
                    if($this->request->getVar('jns_ujian') == 'UAS'){
                        $record = [
                                'status_uas' => '1'
                            ];
                        $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $key]);
                        if($aksi){
                            $jmlSukses++;
                        }else{
                            $jmlError++;
                            $listError [] = [
                                'pesan'     => $dt['Mata_Kuliah']." gagal diaktifkan."
                            ];
                        };
                    }
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil diaktifkan, ".$jmlError." gagal diaktifkan.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil diaktifkan."));
                }  
            }

            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $dt = $DetailUjianModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('id')])->find();
                if($dt){ #memastikan ada data
                    $record = [
                        $this->request->getVar('field') => '0'
                    ];
                    $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $this->request->getVar('id')]);
                    
                    if($aksi){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Data telah dinon-aktifkan'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Data gagal dinon-aktifkan'));
                    }
                }
            }
            
            if($this->request->getVar('aksi')=='deactivateAll'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('kd_kelas_perkuliahan') as $key ) {  
                    $dt = $DetailUjianModel->where(['kd_kelas_perkuliahan' => $key])->first();
                    if($this->request->getVar('jns_ujian') == 'UTS'){
                        $record = [
                                'status_uts' => '0'
                            ];
                        $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $key]);
                        if($aksi){
                            $jmlSukses++;
                        }else{
                            $jmlError++;
                            $listError [] = [
                                'pesan'     => $dt['Mata_Kuliah']." gagal dinon-aktifkan."
                            ];
                        };
                    }
                    
                    if($this->request->getVar('jns_ujian') == 'UAS'){
                        $record = [
                                'status_uas' => '0'
                            ];
                        $aksi = updateDataDinamis('mata_kuliah', $record, ['kd_kelas_perkuliahan' => $key]);
                        if($aksi){
                            $jmlSukses++;
                        }else{
                            $jmlError++;
                            $listError [] = [
                                'pesan'     => $dt['Mata_Kuliah']." gagal dinon-aktifkan."
                            ];
                        };
                    }
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil dinon-aktifkan, ".$jmlError." gagal dinon-aktifkan.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil dinon-aktifkan."));
                }  
            }
        }
        if($this->request->getVar('id')){
          //if(session()->get('akun_level') == 'Mahasiswa'){
              $data = $this->ujian->find(base64_decode(urldecode($this->request->getVar('id'))));
          //}else{
			    //$data = $this->ujian->find($this->request->getVar('id'));
          //}
		}
		
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A']);
            
            
        }
         
        $data['templateJudul'] = (($data['jenis_ujian'] == 'UTS') ? 'Ujian Tengah Semester' : (($data['jenis_ujian'] == 'UAS')?'Ujian Akhir Semester':$data['jenis_ujian']))." ".$data['tahun']." ".($data['semester']=='1'?'Gasal':'Genap');
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxListPerkuliahan()
    {
        $DetailUjianModel = new \App\Models\DetailUjianModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $DetailUjianModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $link_detail = site_url("akademik/perkuliahan/detail?kd_kelas_perkuliahan").$list->kd_kelas_perkuliahan;
                $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Prodi');
                $prod =[]; 
                foreach ($prodi as $key ) {
                   $prod[] = $key->Prodi;
                }
                $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Kelas');
                $kls =[]; 
                foreach ($kelas as $key ) {
                   $kls[] = $key->Kelas;
                }
                $no++;
                $row = [];
                if($this->request->getVar('jns_ujian') == 'UTS'){
                    $soal_uts = '';
                    if(($list->jns_uts == '2') && !empty($list->uts_soal)){
                        $soal_uts = '<a href="'.base_url("akademik/ujian/lihatSoal?k=").$list->kd_kelas_perkuliahan."&u=uts".'" target="_blank" class="btn btn-success btn-xs">Esai / Penugasan</a>';
                    }
                    if($list->jns_uts == '1'){
                        $soal_uts = '<a href="'.base_url("akademik/ujian/lihatSoal?k=").$list->kd_kelas_perkuliahan."&u=uts".'" target="_blank" class="btn btn-success btn-xs">Artikel</a>';
                    }
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->kd_kelas_perkuliahan.'" />';
                $row[] = $no;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->Nama_Dosen;
                $row[] = (!empty($list->Pelaksanaan))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $list->Pelaksanaan])['opt_val']:'-';
                $row[] = implode(" - ",$prod);
                $row[] = implode(" - ",$kls);
                $row[] = $list->SMT;
                $row[] = $list->Hari_UTS;
                $row[] = (!empty($list->Thn_UTS) && !empty($list->Bln_UTS) && !empty($list->Tgl_UTS))?short_tgl_indonesia_date($list->Thn_UTS."-".$list->Bln_UTS."-".$list->Tgl_UTS):'';
                $row[] = $list->Jam_UTS;
                $row[] = $soal_uts;
                $row[] = $list->status_uts == 0 ? '<a onclick="activate('."'".$list->kd_kelas_perkuliahan."','status_uts'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-danger" title="Klik untuk mengaktifkan">Tidak Aktif</a>':'<a onclick="deactivate('."'".$list->kd_kelas_perkuliahan."','status_uts'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-success" title="Klik untuk menonaktifkan">Aktif</a>';
                $row[] = '<!--<a onclick="hapus('."'".$list->kd_kelas_perkuliahan."','".$list->Mata_Kuliah."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit('."'".$list->kd_kelas_perkuliahan."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> -->
                            <a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" target="_blank" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                if($this->request->getVar('jns_ujian') == 'UAS'){
                    $soal_uas = '';
                    if(($list->jns_uas == '2') && !empty($list->uas_soal)){
                        $soal_uas = '<a href="'.base_url("akademik/ujian/lihatSoal?k=").$list->kd_kelas_perkuliahan."&u=uas".'" target="_blank" class="btn btn-success btn-xs">Esai / Penugasan</a>';
                    }
                    if($list->jns_uas == '1'){
                        $soal_uas = '<a href="'.base_url("akademik/ujian/lihatSoal?k=").$list->kd_kelas_perkuliahan."&u=uas".'" target="_blank" class="btn btn-success btn-xs">Artikel</a>';
                    }
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->kd_kelas_perkuliahan.'" />';
                $row[] = $no;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->Nama_Dosen;
                $row[] = (!empty($list->Pelaksanaan))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $list->Pelaksanaan])['opt_val']:'-';
                $row[] = implode(" - ",$prod);
                $row[] = implode(" - ",$kls);
                $row[] = $list->SMT;
                $row[] = $list->Hari;
                $row[] = (!empty($list->Thn) && !empty($list->Bln) && !empty($list->Tgl))?short_tgl_indonesia_date($list->Thn."-".$list->Bln."-".$list->Tgl):'';
                $row[] = $list->Jam;
                $row[] = $soal_uas;
                $row[] = $list->status_uas == 0 ? '<a onclick="activate('."'".$list->kd_kelas_perkuliahan."','status_uas'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-danger" title="Klik untuk mengaktifkan">Tidak Aktif</a>':'<a onclick="deactivate('."'".$list->kd_kelas_perkuliahan."','status_uas'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-success" title="Klik untuk menonaktifkan">Aktif</a>';
                $row[] = '<!--<a onclick="hapus('."'".$list->kd_kelas_perkuliahan."','".$list->Mata_Kuliah."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit('."'".$list->kd_kelas_perkuliahan."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> -->
                            <a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" target="_blank" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $DetailUjianModel->countAll(),
                'recordsFiltered' => $DetailUjianModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function lihatSoal()
    {
        $DetailUjianModel = new \App\Models\DetailUjianModel($this->request);
        $data = [];
        
        if($this->request->getMethod()=="post"){
            
        }
		
		$data['perkuliahan'] = $DetailUjianModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('k')])->first();
        $data['jns_ujian'] = $this->request->getVar('u');
		$data['templateJudul'] = $this->halaman_label;
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'lihatSoal';
    
        
		return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function ekspor()
    {
        
        $list_id = $this->request->getVar('id');
		$data 				= [];
		//$index 				= 0;
		foreach ($list_id as $id ) {
		    $mk = getDataRow('mata_kuliah',['kd_kelas_perkuliahan' => $id]);
		    $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $id], null, 'Prodi');
            $prod =[]; 
            foreach ($prodi as $key ) {
               $prod[] = $key->Prodi;
            }
            $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $id], null, 'Kelas');
            $kls =[]; 
            foreach ($kelas as $key ) {
               $kls[] = $key->Kelas;
            }
            if($this->request->getVar('jns_ujian') == 'UTS'){
    			array_push($data, array(
    				'mata_kuliah' => $mk['Mata_Kuliah'],
    				'kelas' => implode(" - ", $kls),
    				'prodi' => implode(" - ", $prod),
    				'SMT' => $mk['SMT'],
    				'dosen' => (!empty($mk['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$mk['Kd_Dosen']])['Nama_Dosen']:'',
    				'Hari' => $mk['Hari_UTS'],
    				'Tgl' => $mk['Tgl_UTS'],
    				'Bln' => $mk['Bln_UTS'],
    				'Thn' => $mk['Thn_UTS'],
    				'Jam' => $mk['Jam_UTS'],
    				'Ruang' => $mk['Ruang_UTS'],
    				'Pelaksanaan' => (!empty($mk['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $mk['Pelaksanaan']])['opt_val']:'',
    				'kd_kelas_perkuliahan' => $mk['kd_kelas_perkuliahan']
    			));
            }
            
            if($this->request->getVar('jns_ujian') == 'UAS'){
    			array_push($data, array(
    				'mata_kuliah' => $mk['Mata_Kuliah'],
    				'kelas' => implode(" - ", $kls),
    				'prodi' => implode(" - ", $prod),
    				'SMT' => $mk['SMT'],
    				'dosen' => (!empty($mk['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$mk['Kd_Dosen']])['Nama_Dosen']:'',
    				'Hari' => $mk['Hari'],
    				'Tgl' => $mk['Tgl'],
    				'Bln' => $mk['Bln'],
    				'Thn' => $mk['Thn'],
    				'Jam' => $mk['Jam'],
    				'Ruang' => $mk['Ruang'],
    				'Pelaksanaan' => (!empty($mk['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $mk['Pelaksanaan']])['opt_val']:'',
    				'kd_kelas_perkuliahan' => $mk['kd_kelas_perkuliahan']
    			));
            }
			
		}
	//dd($data);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $style_col = [
          'font' => ['bold' => true], // Set font nya jadi bold
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ],
          'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
          ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
          'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ],
          'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
          ]
        ];
        
        if($this->request->getVar('jns_ujian') == 'UTS'){
            $sheet->setCellValue('A1', "DATA UJIAN TENGAH SEMESTER (UTS) ". getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'GASAL':'GENAP') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        }
        if($this->request->getVar('jns_ujian') == 'UAS'){
            $sheet->setCellValue('A1', "DATA UJIAN AKHIR SEMESTER (UAS) ". getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'GASAL':'GENAP') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        }
        $sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'KODE KELAS PERKULIAHAN');
        $sheet->setCellValue('C3', 'MATAKULIAH');
        $sheet->setCellValue('D3', 'NAMA DOSEN');
        $sheet->setCellValue('E3', 'PELAKSANAAN');
        $sheet->setCellValue('F3', 'PRODI');
        $sheet->setCellValue('G3', 'SMT');
        $sheet->setCellValue('H3', 'KELAS');
        $sheet->setCellValue('I3', 'HARI');
        $sheet->setCellValue('J3', 'TGL');
        $sheet->setCellValue('K3', 'BLN');
        $sheet->setCellValue('L3', 'THN');
        $sheet->setCellValue('M3', 'JAM');
        $sheet->setCellValue('N3', 'RUANG');
        
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        
        $sheet->getStyle('A3:N3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa
            
            
          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $val['kd_kelas_perkuliahan']);
          $sheet->setCellValue('C'.$numrow, $val['mata_kuliah']);
          $sheet->setCellValue('D'.$numrow, $val['dosen']);
          $sheet->setCellValue('E'.$numrow, $val['Pelaksanaan']);
          $sheet->setCellValue('F'.$numrow, $val['prodi']);
          $sheet->setCellValue('G'.$numrow, $val['SMT']);
          $sheet->setCellValue('H'.$numrow, $val['kelas']);
          $sheet->setCellValue('I'.$numrow, $val['Hari']);
          $sheet->setCellValue('J'.$numrow, $val['Tgl']);
          $sheet->setCellValue('K'.$numrow, $val['Bln']);
          $sheet->setCellValue('L'.$numrow, $val['Thn']);
          $sheet->setCellValue('M'.$numrow, $val['Jam']);
          $sheet->setCellValue('N'.$numrow, $val['Ruang']);
          
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
          $no++; // Tambah 1 setiap kali looping
          $numrow++; // Tambah 1 setiap kali looping
        }
        
        
        for($i='A'; $i != $sheet->getHighestColumn(); $i++){
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya Maksimum 31 karakter
        $sheet->setTitle("Distribusi Matakuliah ");
        $sheet->getStyle('A:AU')->getNumberFormat()->setFormatCode('@');
        $writer = new Xlsx($spreadsheet);
        if($this->request->getVar('jns_ujian') == 'UTS'){
        $filename = date('Y-m-d-His'). '-Data-UTS-'.getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'Gasal':'Genap');
        }
        if($this->request->getVar('jns_ujian') == 'UAS'){
        $filename = date('Y-m-d-His'). '-Data-UAS-'.getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'Gasal':'Genap');
        }
        /*
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        */
        header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition: attachment; filename='.$filename.'.xlsx');
		//$writer = new Xlsx($spreadsheet);
		ob_start();
		$writer->save('php://output');
		
		$xlsData = ob_get_contents();
        ob_end_clean();
        
        $response =  array(
                'nama_file' => $filename.'.xlsx',
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
        
        die(json_encode($response));
    }
    
    function updateJadwal()
    {
        $DetailUjianModel = new \App\Models\DetailUjianModel($this->request);
        if($this->request->getMethod()=="post"){
            
            $file_excel = $this->request->getFile('file_xlsUpdate');
            $ext = $file_excel->getClientExtension();
            if($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_excel);
            $data = $spreadsheet->getActiveSheet()->toArray();
            
            $listError = [];
            $jmlSukses = 0;
            $jmlError = 0;
            foreach($data as $x => $row) {
                $kd_kelas_perkuliahan = $row[1];
                $mk = $row[2];
                $hari = $row[8];
                $tgl = $row[9];
                $bln = $row[10];
                $thn = $row[11];
                $jam = $row[12];
                $ruang = $row[13];

                if ($x < 3) {
                    continue;
                }
                if($kd_kelas_perkuliahan == '') {
                    $jmlError++;
                    $listError [] = [
                        'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                        'matakuliah'      => $mk,
                        'error'          => "Kolom KODE KELAS PERKULIAHAN tidak boleh kosong",
                    ];
                    continue;
                }
                
                
                if($this->request->getVar('jns_ujian') == 'UTS'){
                    $record_update = [
                        'Hari_UTS'      => $hari,
                        'Tgl_UTS'          => $tgl,
                        'Bln_UTS'          => $bln,
                        'Thn_UTS'          => $thn,
                        'Jam_UTS'          => $jam,
                        'Ruang_UTS'          => $ruang,
                    ];
                    $aksi = updateDataDinamis('mata_kuliah', $record_update, ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan]);
                    if($aksi){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                            'matakuliah'      => $mk,
                            'error'          => "Gagal diupdate",
                        ];
                    }
                    
                }
                
                if($this->request->getVar('jns_ujian') == 'UAS'){
                    $record_update = [
                        'Hari'      => $hari,
                        'Tgl'          => $tgl,
                        'Bln'          => $bln,
                        'Thn'          => $thn,
                        'Jam'          => $jam,
                        'Ruang'          => $ruang,
                    ];
                    $aksi = updateDataDinamis('mata_kuliah', $record_update, ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan]);
                    if($aksi){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                            'matakuliah'      => $mk,
                            'error'          => "Gagal diupdate",
                        ];
                    }
                    
                }
            } // end foreach
            return json_encode(array("msg" => "info", "pesan" => "Sukses update ".$jmlSukses. ", Gagal update ".$jmlError, 'listError' => $listError));

        } // end if
    }
    
    //Fungsi untuk akses ujian mahasiswa
    public function cekData()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $data = [];
        $data = $this->ujian->find($this->request->getVar('id_ujian'));
        
        $dtKrs = $krsModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => $data['kd_tahun']])->first();
        
        if(empty($dtKrs) || $dtKrs['stat_mhs'] != 'A'){
	        return json_encode(array("msg" => "error", "title_pesan" => "Anda Belum Melakukan Pemrograman KRS!!", "text_pesan" => "Maaf Anda tidak dapat mengkases ujian karena belum melakukan pemrograman KRS!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
	    }else{
	        if($data['cek_spp'] == '0' || empty($data['cek_spp'])){
	            if($data['stts_ujian'] == '0' || empty($data['stts_ujian'])){
                    return json_encode(array("msg" => "info", "title_pesan" => "Ujian Belum Dimulai Atau Telah Berakhir", "text_pesan" => "Maaf ujian tidak dapat diakses!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
                }else{
                    
                        //return json_encode(array("msg" => "success", "title_pesan" => "Lolos Persyaratan UTS", "text_pesan" => "UTS Tanpa cek SPP"));
                        
                        return json_encode(array("msg" => "success", "link" => site_url("akademik/$this->halaman_controller/detail?id=").urlencode(base64_encode($data['id_ujian']))));
                    
                }
	        }else{
	            if($data['jenis_ujian'] == 'UTS'){
    	            if($dtKrs['sarat_uts'] == '0' || empty($dtKrs['sarat_uts'])){
    	                return json_encode(array("msg" => "error", "title_pesan" => "Anda Belum Melunasi Pembayaran UTS!!", "text_pesan" => "Maaf Anda tidak dapat mengkases ujian!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
    	            }else{
    	                if($data['stts_ujian'] == '0' || empty($data['stts_ujian'])){
                            return json_encode(array("msg" => "info", "title_pesan" => "Ujian Belum Dimulai Atau Telah Berakhir", "text_pesan" => "Maaf ujian tidak dapat diakses!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
                        }else{
                             return json_encode(array("msg" => "success", "link" => site_url("akademik/$this->halaman_controller/detail?id=").urlencode(base64_encode($data['id_ujian']))));
                        }
    	            }
	            }
	            
	            if($data['jenis_ujian'] == 'UAS'){
    	            if($dtKrs['status_bayar'] == '0' || empty($dtKrs['status_bayar'])){
    	                return json_encode(array("msg" => "error", "title_pesan" => "Anda Belum Melunasi Pembayaran UAS!!", "text_pesan" => "Maaf Anda tidak dapat mengkases ujian!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
    	            }else{
    	                if($data['stts_ujian'] == '0' || empty($data['stts_ujian'])){
                            return json_encode(array("msg" => "info", "title_pesan" => "Ujian Belum Dimulai Atau Telah Berakhir", "text_pesan" => "Maaf ujian tidak dapat diakses!!!<br> Demi kelancaran ujian, pastikan Anda telah melakukan pemrograman KRS dan melunasi biaya ujian."));
                        }else{
                             return json_encode(array("msg" => "success", "link" => site_url("akademik/$this->halaman_controller/detail?id=").urlencode(base64_encode($data['id_ujian']))));
                        }
    	            }
	            }
	        }
	    }

        
        
    }
    
    function ajaxListPerkuliahanMahasiswa()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        //$DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        $KuliahUlangModel = new \App\Models\KuliahUlangModel($this->request);
        
        //dd($jadwalMk);
        if ($this->request->getMethod(true) === 'POST') {
            $id_his_pdk = [];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $this->request->getVar('id_data_diri')]);
            foreach($his_pdk as $r){
                $id_his_pdk[] = $r->id_his_pdk;
            }
            
            $idKrsMhs = $krsModel->where(['kode_ta' => $this->request->getVar('tahun_akademik')])->whereIn('id_his_pdk', $id_his_pdk)->findColumn('id');
            if(!empty($idKrsMhs)){
                $mataKuliahKrs = $NilaiModel->select('id_ljk, id_mk, ljk, artikel, ljk_uts, artikel_uts, tugas')->where('id_krs', $idKrsMhs)->findAll();
                $idKuliahUlang = $KuliahUlangModel->where(['kd_ta' => $this->request->getVar('tahun_akademik')])->whereIn('id_his_pdk', $id_his_pdk)->findColumn('id');
                if(empty($idKuliahUlang)){
                    $listMk = $mataKuliahKrs;
                }else{
                    $mataKuliahUlang = $NilaiModel->select('id_ljk, id_mk, ljk, artikel, ljk_uts, artikel_uts, tugas')->where('id_ku', $idKuliahUlang)->findAll();
                    $listMk = array_merge($mataKuliahKrs, $mataKuliahUlang);
                }
                $data = [];
                $no = $this->request->getPost('start');
    
                foreach ($listMk as $list) {
                    $dtMk = getDataRow('mata_kuliah', ['id' => $list['id_mk']]);
                    //dd($dtMk['status_uts']);
                    $no++;
                    $row = [];
                    if($this->request->getVar('jns_ujian') == 'UTS'){
                        $soal_uts = '';
                        //dd($dtMk['status_uts']);
                        if($dtMk['status_uts'] == '0'){
                            $soal_uts = '<span class="badge badge-danger">Soal Belum Aktif</span>';
                        }else{
                            
                            if(($dtMk['jns_uts'] == '2') && !empty($dtMk['uts_soal'])){
                                $soal_uts = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="showSoal('."'uts','".$list['id_mk']."','".$list['id_ljk']."'".')">Esai / Penugasan</a>';
                            }
                            if(($dtMk['jns_uts'] == '2') && empty($dtMk['uts_soal'])){
                                $soal_uts = '<span class="badge badge-danger">Soal Belum Diinput</span>';
                            }
                            if($dtMk['jns_uts'] == '1'){
                                $soal_uts = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="showSoal('."'uts','".$list['id_mk']."','".$list['id_ljk']."'".')">Artikel</a>';
                            }
                        }
                        
                        
                    $row[] = $no;
                    $row[] = $dtMk['Mata_Kuliah'];
                    $row[] = (!empty($dtMk['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$dtMk['Kd_Dosen']])['Nama_Dosen']:'';
                    $row[] = $dtMk['Hari_UTS'];
                    $row[] = (!empty($dtMk['Thn_UTS']) && !empty($dtMk['Bln_UTS']) && !empty($dtMk['Tgl_UTS']))?short_tgl_indonesia_date($dtMk['Thn_UTS']."-".$dtMk['Bln_UTS']."-".$dtMk['Tgl_UTS']):'';
                    $row[] = $dtMk['Jam_UTS'];
                    $row[] = (isset($soal_uts))?$soal_uts:'';
                    $row[] = (!empty($list['ljk_uts']) || !empty($list['artikel_uts']))?'<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk('."'uts','".$list['id_ljk']."'".')">Lihat</a>':''; 
                    }
                    
                    if($this->request->getVar('jns_ujian') == 'UAS'){
                        $soal_uas = '';
                        if($dtMk['status_uas'] == '0'){
                            $soal_uas = '<span class="badge badge-danger">Soal Belum Aktif</span>';
                        }else{
                            if(($dtMk['jns_uas'] == '2') && !empty($dtMk['uas_soal'])){
                                $soal_uas = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="showSoal('."'uas','".$list['id_mk']."','".$list['id_ljk']."'".')">Esai / Penugasan</a>';
                            }
                            if(($dtMk['jns_uas'] == '2') && empty($dtMk['uas_soal'])){
                                $soal_uas = '<span class="badge badge-danger">Soal Belum Diinput</span>';
                            }
                            if($dtMk['jns_uas'] == '1'){
                                $soal_uas = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="showSoal('."'uas','".$list['id_mk']."','".$list['id_ljk']."'".')">Artikel</a>';
                            }
                        }
                    $row[] = $no;
                    $row[] = $dtMk['Mata_Kuliah'];
                    $row[] = (!empty($dtMk['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$dtMk['Kd_Dosen']])['Nama_Dosen']:'';
                    $row[] = $dtMk['Hari'];
                    $row[] = (!empty($dtMk['Thn']) && !empty($dtMk['Bln']) && !empty($dtMk['Tgl']))?short_tgl_indonesia_date($dtMk['Thn']."-".$dtMk['Bln']."-".$dtMk['Tgl']):'';
                    $row[] = $dtMk['Jam'];
                    $row[] = (isset($soal_uas))?$soal_uas:'';
                    $row[] = (!empty($dtMk['tugas']))?'<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="showSoal('."'tugas','".$list['id_mk']."','".$list['id_ljk']."'".')">Tugas Akhir</a>':'';
                    $row[] = (!empty($list['ljk']) || !empty($list['artikel']))?'<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk('."'uas','".$list['id_ljk']."'".')">Lihat</a>':'';
                    }
                    $data[] = $row;
                }
    
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    //'recordsTotal' => $this->perkuliahan->countAll(),
                    //'recordsFiltered' => $this->perkuliahan->countFiltered(),
                    'data' => $data
                ];
    
                echo json_encode($output);
            }else{
                $data = [];
                $row = [];
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $data[] = $row;
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    //'recordsTotal' => $this->perkuliahan->countAll(),
                    //'recordsFiltered' => $this->perkuliahan->countFiltered(),
                    'data' => $data
                ];
    
                echo json_encode($output);
            }
        }
        
    }
    
    
    function showLjk(){
        $data = [];
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        
        if($this->request->getVar('id_ljk')){
			$data = $NilaiModel->find($this->request->getVar('id_ljk'));
			$data['ujian'] = $this->request->getVar('jns_ujian');
			
		}
        
        $data['templateJudul'] = "Lembar Jawaban";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'showLjk';
        if($data['ujian'] == 'tugas'){
            return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/showTugas", $data);
        }else{
            $data['jns_soal'] = $data['ujian'] == 'uas' ?getDataRow('mata_kuliah', ['id' => $data['id_mk']])['jns_uas']:getDataRow('mata_kuliah', ['id' => $data['id_mk']])['jns_uts'];
            //if($data['jns_soal']  == '2'){
                return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/showLjk", $data);
            //}else{
            //    return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/showLjkArtikel", $data);
            //}
        }
            
    }
    
    function showSoal(){
        $data = [];
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        
        if($this->request->getMethod(true)=='POST'){
            
            $dtMk = $DistribusiMkModel->find($this->request->getVar('id_mk'));
            $aturan = [
                'ljk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            
            if($this->request->getVar('jns_ujian') == 'uts' && $dtMk['jns_uts'] == '1'){
                if(empty($this->request->getVar('id_artikel'))){
                    $aturan = [
                        'judul-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Judul artikel tidak boleh kosong!!'
                            ]
                        ],
                        'abstrak-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Abstrak tidak boleh kosong!!'
                            ]
                        ],
                        'fokus-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Fokus artikel tidak boleh kosong!!'
                            ]
                        ],
                        'review-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Review penelitian terdahulu tidak boleh kosong!!'
                            ]
                        ],
                        'posisi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Posisi artikel tidak boleh kosong!!'
                            ]
                        ],
                        'novelty-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sisi kebaharuan (novelty) tidak boleh kosong!!'
                            ]
                        ],
                        'metode-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Metode penelitian tidak boleh kosong!!'
                            ]
                        ],
                        'kesimpulan-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Kesimpulan pembahasan tidak boleh kosong!!'
                            ]
                        ],
                        'referensi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Daftar pustaka / referensi tidak boleh kosong!!'
                            ]
                        ],
                        'sistematika-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sistematika pembahasan artikel tidak boleh kosong!!'
                            ]
                        ],
                        'exampleInputFile' => [
                            'rules' => 'uploaded[exampleInputFile]|mime_in[exampleInputFile,application/pdf]|ext_in[exampleInputFile,pdf]|max_size[exampleInputFile,2048]',
                            'errors' => [
                                'uploaded' => 'File artikel harus diupload!!',
                                'mime_in' => 'File artikel harus berformat PDF',
                                'ext_in' => 'File artikel Anda bukan PDF',
                                'max_size' => 'Ukuran file terlalu besar, Maksimal 2 Mb'
                            ]
                        ]
                    ];
                }else{
                    $aturan = [
                        'judul-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Judul artikel tidak boleh kosong!!'
                            ]
                        ],
                        'abstrak-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Abstrak tidak boleh kosong!!'
                            ]
                        ],
                        'fokus-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Fokus artikel tidak boleh kosong!!'
                            ]
                        ],
                        'review-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Review penelitian terdahulu tidak boleh kosong!!'
                            ]
                        ],
                        'posisi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Posisi artikel tidak boleh kosong!!'
                            ]
                        ],
                        'novelty-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sisi kebaharuan (novelty) tidak boleh kosong!!'
                            ]
                        ],
                        'metode-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Metode penelitian tidak boleh kosong!!'
                            ]
                        ],
                        'kesimpulan-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Kesimpulan pembahasan tidak boleh kosong!!'
                            ]
                        ],
                        'referensi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Daftar pustaka / referensi tidak boleh kosong!!'
                            ]
                        ],
                        'sistematika-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sistematika pembahasan artikel tidak boleh kosong!!'
                            ]
                        ],
                        'exampleInputFile' => [
                            'rules' => 'mime_in[exampleInputFile,application/pdf]|ext_in[exampleInputFile,pdf]|max_size[exampleInputFile,2048]',
                            'errors' => [
                                'mime_in' => 'File artikel harus berformat PDF',
                                'ext_in' => 'File artikel Anda bukan PDF',
                                'max_size' => 'Ukuran file terlalu besar, Maksimal 2 Mb'
                            ]
                        ]
                    ];
                }
            }
            
            if($this->request->getVar('jns_ujian') == 'uas' && $dtMk['jns_uas'] == '1'){
                if(empty($this->request->getVar('id_artikel'))){
                    $aturan = [
                        'judul-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Judul artikel tidak boleh kosong!!'
                            ]
                        ],
                        'abstrak-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Abstrak tidak boleh kosong!!'
                            ]
                        ],
                        'fokus-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Fokus artikel tidak boleh kosong!!'
                            ]
                        ],
                        'review-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Review penelitian terdahulu tidak boleh kosong!!'
                            ]
                        ],
                        'posisi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Posisi artikel tidak boleh kosong!!'
                            ]
                        ],
                        'novelty-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sisi kebaharuan (novelty) tidak boleh kosong!!'
                            ]
                        ],
                        'metode-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Metode penelitian tidak boleh kosong!!'
                            ]
                        ],
                        'kesimpulan-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Kesimpulan pembahasan tidak boleh kosong!!'
                            ]
                        ],
                        'referensi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Daftar pustaka / referensi tidak boleh kosong!!'
                            ]
                        ],
                        'sistematika-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sistematika pembahasan artikel tidak boleh kosong!!'
                            ]
                        ],
                        'exampleInputFile' => [
                            'rules' => 'uploaded[exampleInputFile]|mime_in[exampleInputFile,application/pdf]|ext_in[exampleInputFile,pdf]|max_size[exampleInputFile,2048]',
                            'errors' => [
                                'uploaded' => 'File artikel harus diupload!!',
                                'mime_in' => 'File artikel harus berformat PDF',
                                'ext_in' => 'File artikel Anda bukan PDF',
                                'max_size' => 'Ukuran file terlalu besar, Maksimal 2 Mb'
                            ]
                        ]
                    ];
                }else{
                    $aturan = [
                        'judul-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Judul artikel tidak boleh kosong!!'
                            ]
                        ],
                        'abstrak-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Abstrak tidak boleh kosong!!'
                            ]
                        ],
                        'fokus-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Fokus artikel tidak boleh kosong!!'
                            ]
                        ],
                        'review-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Review penelitian terdahulu tidak boleh kosong!!'
                            ]
                        ],
                        'posisi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Posisi artikel tidak boleh kosong!!'
                            ]
                        ],
                        'novelty-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sisi kebaharuan (novelty) tidak boleh kosong!!'
                            ]
                        ],
                        'metode-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Metode penelitian tidak boleh kosong!!'
                            ]
                        ],
                        'kesimpulan-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Kesimpulan pembahasan tidak boleh kosong!!'
                            ]
                        ],
                        'referensi-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Daftar pustaka / referensi tidak boleh kosong!!'
                            ]
                        ],
                        'sistematika-part-inp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Sistematika pembahasan artikel tidak boleh kosong!!'
                            ]
                        ],
                        'exampleInputFile' => [
                            'rules' => 'mime_in[exampleInputFile,application/pdf]|ext_in[exampleInputFile,pdf]|max_size[exampleInputFile,2048]',
                            'errors' => [
                                
                                'mime_in' => 'File artikel harus berformat PDF',
                                'ext_in' => 'File artikel Anda bukan PDF',
                                'max_size' => 'Ukuran file terlalu besar, Maksimal 2 Mb'
                            ]
                        ]
                    ];
                }
            }

            
            if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali lembar jawaban Anda!"));
            }else{
                if($this->request->getVar('jns_ujian') == 'uts' && ($dtMk['jns_uts'] == '2')){
                    $record = [
                        
                        'ljk_uts' => $this->request->getVar('ljk'),
                        'tgl_upload_ljk_uts' => date("Y-m-d H:i:s")
                    ];
                }
                
                if($this->request->getVar('jns_ujian') == 'uas' && ($dtMk['jns_uas'] == '2')){
                    $record = [
                        
                        'ljk' => $this->request->getVar('ljk'),
                        'tgl_upload_ljk_uas' => date("Y-m-d H:i:s")
                    ];
                }
                
                if($this->request->getVar('jns_ujian') == 'tugas'){
                    $record = [
                        
                        'tugas' => $this->request->getVar('ljk'),
                        'tgl_upload_tugas' => date("Y-m-d H:i:s")
                    ];
                }
                
                if($this->request->getVar('jns_ujian') == 'uts' && ($dtMk['jns_uts'] == '1')){
                    $TugasArtikelModel = new \App\Models\TugasArtikelModel();
                    if(empty($this->request->getVar('id_artikel'))){
                        $file = $this->request->getFile('exampleInputFile');
                        
                        if($file->getName()){
        					$nm_file = $file->getRandomName();
                            $path = 'upload/file_artikel/';
                            $file_artikel = base_url().'/'.$path.'/'.$nm_file;
                            $file->move($path, $nm_file);
        				}
                        
                        $record_artikel = [
                            'judul' => $this->request->getVar('judul-part-inp'), 
                            'abstrak' => $this->request->getVar('abstrak-part-inp'), 
                            'fokus' => $this->request->getVar('fokus-part-inp'), 
                            'review' => $this->request->getVar('review-part-inp'), 
                            'posisi' => $this->request->getVar('posisi-part-inp'), 
                            'novelty' => $this->request->getVar('novelty-part-inp'), 
                            'metode' => $this->request->getVar('metode-part-inp'), 
                            'kesimpulan' => $this->request->getVar('kesimpulan-part-inp'), 
                            'referensi' => $this->request->getVar('referensi-part-inp'), 
                            'sistematika' => $this->request->getVar('sistematika-part-inp'), 
                            'file_artikel' => $file_artikel   
                        ];
                        if($TugasArtikelModel->simpanData($record_artikel)){
                            $record = [
                                'artikel_uts' => $TugasArtikelModel->getInsertID(),
                                'tgl_upload_ljk_uts' => date("Y-m-d H:i:s")
                            ];
                        }else{
                            return json_encode(array("msg" => "error", "pesan" => "Lembar jawaban gagal disimpan."));
                        }
                    }else{
                        $dt_artikel = $TugasArtikelModel->find($this->request->getVar('id_artikel'));
                        
                        $file_artikel = $dt_artikel['file_artikel'];
                        $file = $this->request->getFile('exampleInputFile');
                        if($file->getName()){
        					$nm_file = $file->getRandomName();
                            $path = 'upload/file_artikel/';
                            $file_artikel = base_url().'/'.$path.'/'.$nm_file;
                            $file->move($path, $nm_file);
                            @unlink(substr($dt_artikel['file_artikel'],34));
        				}
                        
                        $record_artikel = [
                            'id_artikel' => $dt_artikel['id_artikel'],
                            'judul' => $this->request->getVar('judul-part-inp'), 
                            'abstrak' => $this->request->getVar('abstrak-part-inp'), 
                            'fokus' => $this->request->getVar('fokus-part-inp'), 
                            'review' => $this->request->getVar('review-part-inp'), 
                            'posisi' => $this->request->getVar('posisi-part-inp'), 
                            'novelty' => $this->request->getVar('novelty-part-inp'), 
                            'metode' => $this->request->getVar('metode-part-inp'), 
                            'kesimpulan' => $this->request->getVar('kesimpulan-part-inp'), 
                            'referensi' => $this->request->getVar('referensi-part-inp'), 
                            'sistematika' => $this->request->getVar('sistematika-part-inp'), 
                            'file_artikel' => $file_artikel   
                        ];
                        
                        if($TugasArtikelModel->simpanData($record_artikel)){
                            $record = [
                                'artikel_uts' => $dt_artikel['id_artikel'],
                                'tgl_upload_ljk_uts' => date("Y-m-d H:i:s")
                            ];
                        }else{
                            return json_encode(array("msg" => "error", "pesan" => "Lembar jawaban gagal disimpan."));
                        }
                    }
                }
                
                if($this->request->getVar('jns_ujian') == 'uas' && ($dtMk['jns_uas'] == '1')){
                    $TugasArtikelModel = new \App\Models\TugasArtikelModel();
                    if(empty($this->request->getVar('id_artikel'))){
                        $file = $this->request->getFile('exampleInputFile');
                        
                        if($file->getName()){
        					$nm_file = $file->getRandomName();
                            $path = 'upload/file_artikel/';
                            $file_artikel = base_url().'/'.$path.'/'.$nm_file;
                            $file->move($path, $nm_file);
        				}
                        
                        $record_artikel = [
                            'judul' => $this->request->getVar('judul-part-inp'), 
                            'abstrak' => $this->request->getVar('abstrak-part-inp'), 
                            'fokus' => $this->request->getVar('fokus-part-inp'), 
                            'review' => $this->request->getVar('review-part-inp'), 
                            'posisi' => $this->request->getVar('posisi-part-inp'), 
                            'novelty' => $this->request->getVar('novelty-part-inp'), 
                            'metode' => $this->request->getVar('metode-part-inp'), 
                            'kesimpulan' => $this->request->getVar('kesimpulan-part-inp'), 
                            'referensi' => $this->request->getVar('referensi-part-inp'), 
                            'sistematika' => $this->request->getVar('sistematika-part-inp'), 
                            'file_artikel' => $file_artikel   
                        ];
                        if($TugasArtikelModel->simpanData($record_artikel)){
                            $record = [
                                'artikel' => $TugasArtikelModel->getInsertID(),
                                'tgl_upload_ljk_uas' => date("Y-m-d H:i:s")
                            ];
                        }else{
                            return json_encode(array("msg" => "error", "pesan" => "Lembar jawaban gagal disimpan."));
                        }
                    }else{
                        $dt_artikel = $TugasArtikelModel->find($this->request->getVar('id_artikel'));
                        
                        $file_artikel = $dt_artikel['file_artikel'];
                        $file = $this->request->getFile('exampleInputFile');
                        if($file->getName()){
        					$nm_file = $file->getRandomName();
                            $path = 'upload/file_artikel/';
                            $file_artikel = base_url().'/'.$path.'/'.$nm_file;
                            $file->move($path, $nm_file);
                            @unlink(substr($dt_artikel['file_artikel'],34));
        				}
                        
                        $record_artikel = [
                            'id_artikel' => $dt_artikel['id_artikel'],
                            'judul' => $this->request->getVar('judul-part-inp'), 
                            'abstrak' => $this->request->getVar('abstrak-part-inp'), 
                            'fokus' => $this->request->getVar('fokus-part-inp'), 
                            'review' => $this->request->getVar('review-part-inp'), 
                            'posisi' => $this->request->getVar('posisi-part-inp'), 
                            'novelty' => $this->request->getVar('novelty-part-inp'), 
                            'metode' => $this->request->getVar('metode-part-inp'), 
                            'kesimpulan' => $this->request->getVar('kesimpulan-part-inp'), 
                            'referensi' => $this->request->getVar('referensi-part-inp'), 
                            'sistematika' => $this->request->getVar('sistematika-part-inp'), 
                            'file_artikel' => $file_artikel   
                        ];
                        if($TugasArtikelModel->simpanData($record_artikel)){
                            $record = [
                                'artikel' => $dt_artikel['id_artikel'],
                                'tgl_upload_ljk_uas' => date("Y-m-d H:i:s")
                            ];
                        }else{
                            return json_encode(array("msg" => "error", "pesan" => "Lembar jawaban gagal disimpan."));
                        }
                    }
                        
                }
                
                $aksi = updateDataDinamis('data_ljk', $record, ['id_ljk' => $this->request->getVar('id_ljk')]);
                
                if($aksi){
                    return json_encode(array("msg" => "success", "pesan" => "Lembar jawaban berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Lembar jawaban gagal disimpan."));
                }
            }
        }
        
        if($this->request->getVar('id_mk')){
            $data['perkuliahan'] = $DistribusiMkModel->find($this->request->getVar('id_mk'));
			$data['jns_ujian'] = $this->request->getVar('jns_ujian');
			$data['id_ljk'] = $this->request->getVar('id_ljk');
			
            // if($this->request->getVar('jns_ujian') == 'uas'){
            //     $cekCekalan = getDataRow('data_ljk', ['id_ljk' => $this->request->getVar('id_ljk')])['cekal_kuliah'];
            //     if($cekCekalan == '1'){
            //         session()->setFlashdata("info", "cekal");
            //     }
                
            //     $tgl_ujian = short_tgl($data['perkuliahan']['Tgl'])."-".short_bulan($data['perkuliahan']['Bln'])."-".$data['perkuliahan']['Thn'];
            //     $absenUjian = getDataRow('absensi_uts', ['id_his_pdk' => getDataRow('data_ljk', ['id_ljk' => $this->request->getVar('id_ljk')])['id_his_pdk'], 'tgl_ujian' => $tgl_ujian]);
            //     //dd($absenUjian);
            //     // if(empty($absenUjian) || $absenUjian['hadir'] == '0'){
            //     //     session()->setFlashdata("info", "tidak-hadir");
            //     // }
            // }
            
			
		}
        
        $data['templateJudul'] = "Soal Ujian / Tugas";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'showSoal';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
            
    }
    
    
    // Absensi Ujian
    function absensi()
    {
        
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {
            
            if($this->request->getVar('aksi')=='hadir' && $this->request->getVar('id_his_pdk') && $this->request->getVar('tanggal')){
                
                $record = [
                    'id_his_pdk' => $this->request->getVar('id_his_pdk'),
                    'tgl_ujian' => $this->request->getVar('tanggal'),
                    'hadir' => '1'
                ];
                $aksi = setDataDinamis('absensi_uts', $record);
                
                if($aksi){
                    return json_encode(array("msg" => 'success', 'pesan' => 'Status kehadiran telah diubah'));
                }else{
                    return json_encode(array("msg" => 'error', 'pesan' => 'Status kehadiran gagal diubah'));
                }
            }
            
            if($this->request->getVar('aksi')=='hadirAll'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('id_his_pdk') as $key ) {  
                    
                    
                    $record = [
                            'id_his_pdk' => $key,
                            'tgl_ujian' => $this->request->getVar('tanggal'),
                            'hadir' => '1'
                        ];
                    $aksi = setDataDinamis('absensi_uts', $record);
                    if($aksi){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $key])['id_data_diri']])['Nama_Lengkap']." kehadiran gagal diubah."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Mahasiswa berhasil diubah, ".$jmlError." gagal diubah.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Mahasiswa berhasil diubah."));
                }  
            }

            if($this->request->getVar('aksi')=='tidak_hadir' && $this->request->getVar('id_his_pdk') && $this->request->getVar('tanggal')){
                
                    $aksi = deleteDataDinamis('absensi_uts', ['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'tgl_ujian' => $this->request->getVar('tanggal')]);
                    
                    if($aksi){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Status kehadiran telah diubah'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Status kehadiran gagal diubah'));
                    }
            }
            
            if($this->request->getVar('aksi')=='tidakHadirAll'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('id_his_pdk') as $key ) {  
                    

                    $aksi = deleteDataDinamis('absensi_uts', ['id_his_pdk' => $key, 'tgl_ujian' => $this->request->getVar('tanggal')]);
                    if($aksi){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $key])['id_data_diri']])['Nama_Lengkap']." gagal diubah."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Mahasiswa berhasil diubah, ".$jmlError." gagal diubah.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Mahasiswa berhasil diubah."));
                }  
            }
        }
        if($this->request->getVar('id')){
          
              $data = $this->ujian->find(base64_decode(urldecode($this->request->getVar('id'))));
          
		}
		
        
        $data['templateJudul'] = "Absensi ". (($data['jenis_ujian'] == 'UTS') ? 'Ujian Tengah Semester' : (($data['jenis_ujian'] == 'UAS')?'Ujian Akhir Semester':$data['jenis_ujian']))." ".$data['tahun']." ".($data['semester']=='1'?'Gasal':'Genap');
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'absensi';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function loadDataMahasiswa()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $KrsModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
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
    			}
                $absen = getDataRow('absensi_uts', ['id_his_pdk' => $list->id_his_pdk, 'tgl_ujian' => $this->request->getVar('tanggal')]);
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_his_pdk.'" />';
                $row[] = $no;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $stat_mhs;
                $row[] = $list->status_bayar == 1 ? '<span class="badge badge-success">Lunas</span>':'<span class="badge badge-danger">Belum Lunas</span>';
                $row[] = (!empty($absen) && $absen['hadir'] == 1) ? '<a onclick="tidak_hadir('."'".$list->id_his_pdk."','".str_replace("'", "`",$list->Nama_Lengkap)."','".$this->request->getVar('tanggal')."'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-success" title="Klik untuk mengubah">Hadir</a>':'<a onclick="hadir('."'".$list->id_his_pdk."','".str_replace("'", "`",$list->Nama_Lengkap)."','".$this->request->getVar('tanggal')."'".'); return false;" role="button" data-placement="top" class="btn btn-xs btn-danger" title="Klik untuk mengubah">Tidak Hadir</a>';
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->krs->countAll(),
                //'recordsFiltered' => $this->krs->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
}