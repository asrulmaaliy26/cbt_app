<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\KuliahUlangModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kuliahulang extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->kuliahulang = new KuliahUlangModel($request);
        $this->halaman_controller = "kuliahulang";
        $this->halaman_label = "Kuliah Ulang";
    }
    
    public function index()
    {
        $data = [];
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A']);
        }
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->kuliahulang->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    $NilaiModel = new \App\Models\NilaiModel($this->request);
                    $cekDataNilai = $NilaiModel->where('id_ku', $this->request->getVar('id'))->findAll();
                    if(!empty($cekDataNilai)){
                        return json_encode(array("status"=>false, "msg" => "warning", "pesan" => "Data ini tidak dapat dihapus karena terhubung dengan data nilai. silahkan periksa terlebih dahulu."));
                        
                    }else{
                        $aksi = $this->kuliahulang->delete($this->request->getVar('id'));
                        if($aksi == true){
                            return json_encode(array("status" => TRUE, "msg" => "success", "pesan" => "Data kuliah ulang telah dihapus."));
                        }else{
                            return json_encode(array("status" => false, "msg" => "warning", "pesan" => "Data kuliah ulang gagal dihapus."));
                        }
                    }
                    
                }
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){

                $dt = $this->kuliahulang->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    $record = [
                        'id' => $this->request->getVar('id'),
                        'is_processed' => '1'
                    ];
                    
                    if($this->kuliahulang->save($record)){
                        //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }

            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $dt = $this->kuliahulang->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    $record = [
                        'id' => $this->request->getVar('id'),
                        'is_processed' => '0'
                    ];
                    
                    if($this->kuliahulang->save($record)){
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
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->kuliahulang->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['id_data_diri'];
                
                $no++;
                $row = [];
                if(session()->get('akun_level') == "Admin"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['semester'] == '1'?'Gasal':'Genap');
                $row[] = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];
                $row[] = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['NIM'];
                $row[] = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['Prodi'];
                $row[] = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan'];
                $row[] = $list->jml_mk;
                $row[] = $list->is_processed == '1' ? '<a onclick="deactivate('."'".$list->id."','".str_replace("'", "`",getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'])."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id."','".str_replace("'", "`",getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'])."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '
                        <a onclick="prosesMkUlang('."'".$list->id."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Proses Kuliah Ulang"><i class="fa fa-list"></i></a>
                        <a onclick="hapus('."'".$list->id."','".str_replace("'", "`",getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'])."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Kuliah Ulang"><i class="fa fa-trash"></i></a>
                        <!--<a onclick="updateLjk('."'".$list->id."','".str_replace("'", "`",getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'])."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Hapus Kuliah Ulang"><i class="fa fa-sync"></i></a>  -->  
                        ';
                }
                
                if(session()->get('akun_level') == "Mahasiswa"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['semester'] == '1'?'Gasal':'Genap');
                
                $row[] = $list->jml_mk;
                
                }
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->kuliahulang->countAll(),
                'recordsFiltered' => $this->kuliahulang->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function formulir_kuliah_ulang()
    {
        $data = [];
        
        if($this->request->getVar('t')){
			
			$data['ta'] = getDataRow('tahun_akademik', ['kode' => $this->request->getVar('t')]);
			
		}
		
		if($this->request->getVar('m')){
			
			$data['m'] = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('m')]);
			
		}
		
		if($this->request->getMethod()=="post" && $this->request->getVar('aksi')=='tambah'){
		    $krsModel = new \App\Models\KrsModel($this->request);
		    $NilaiModel = new \App\Models\NilaiModel($this->request);
		    $data['nilai'] = getDataRow('data_ljk', ['id_ljk' => $this->request->getVar('id_ljk')]);
		    $dtKrs = $krsModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => $this->request->getVar('kd_ta')])->first();
		    
		    if(!empty($dtKrs) && $dtKrs['stat_mhs'] == 'A'){
		        $cekMk = getDataRow('mata_kuliah', ['Kode_MK_Feeder' => $data['nilai']['kode_mk_feeder'], 'Kd_Tahun' => $this->request->getVar('kd_ta')]);
		        if(!empty($cekMk)){
        		    $dtKu = $this->kuliahulang->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])->first();
        		    if(empty($dtKu)){
        		        $record = [
        		            'id_his_pdk' => $this->request->getVar('id_his_pdk'),
        		            'kd_ta' => $this->request->getVar('kd_ta'),
        		            'smt' => $dtKrs['semester'],
        		            'jml_mk' => '1'
        		        ];
        		        if($this->kuliahulang->simpanData($record)){
        		            $record_nilai = [
        		                'id_ljk' => $this->request->getVar('id_ljk'),
        		                'id_ku' => getDataRow('kuliah_ulang', ['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])['id']
        		            ];
        		            if($NilaiModel->save($record_nilai)){
        		                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil ditambahkan."));
        		            }else{
        		                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal ditambahkan."));
        		            }
        		        }
        		    }else{
        		        $record = [
        		            'id' => $dtKu['id'],
        		            'jml_mk' => intval($dtKu['jml_mk'])+1
        		        ];
        		        if($this->kuliahulang->simpanData($record)){
        		            $record_nilai = [
        		                'id_ljk' => $this->request->getVar('id_ljk'),
        		                'id_ku' => $dtKu['id']
        		            ];
        		            if($NilaiModel->save($record_nilai)){
        		                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil ditambahkan."));
        		            }else{
        		                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal ditambahkan."));
        		            }
        		        }
        		    }
		        }else{
		            if(session()->get('akun_level') == 'Mahasiswa'){
		                return json_encode(array("msg" => "error", "pesan" => "Matakuliah yang akan ditempuh ulang tidak diajarkan di periode sekarang. Silahkan ke kantor BAAK untuk informasi lebih lanjut!!!"));
		            }
		            if(session()->get('akun_level') == 'Admin'){
		                return json_encode(array("msg" => "info", "pesan" => "Matakuliah yang akan ditempuh ulang tidak diajarkan di periode sekarang!!!"));
		            }
		        }
		    }else{
		        return json_encode(array("msg" => "error", "pesan" => "Anda belum melakukan pemrograman KRS pada semester ini!!!"));
		    }
		}
		
		if($this->request->getMethod()=="post" && $this->request->getVar('aksi')=='tambah_ulang'){
		    $krsModel = new \App\Models\KrsModel($this->request);
		    $NilaiModel = new \App\Models\NilaiModel($this->request);
		    $data['nilai'] = getDataRow('data_ljk', ['id_ljk' => $this->request->getVar('id_ljk')]);
		    $dtKrs = $krsModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => $this->request->getVar('kd_ta')])->first();
		    
		    if(!empty($dtKrs) && $dtKrs['stat_mhs'] == 'A'){
		        
    		    $dtKu = $this->kuliahulang->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])->first();
    		    if(empty($dtKu)){
    		        $record = [
    		            'id_his_pdk' => $this->request->getVar('id_his_pdk'),
    		            'kd_ta' => $this->request->getVar('kd_ta'),
    		            'smt' => $dtKrs['semester'],
    		            'jml_mk' => '1'
    		        ];
    		        if($this->kuliahulang->simpanData($record)){
    		            $record_nilai = [
    		                'id_ljk' => $this->request->getVar('id_ljk'),
    		                'id_ku' => getDataRow('kuliah_ulang', ['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])['id']
    		            ];
    		            if($NilaiModel->save($record_nilai)){
    		                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil ditambahkan."));
    		            }else{
    		                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal ditambahkan."));
    		            }
    		        }
    		    }else{
    		        $record = [
    		            'id' => $dtKu['id'],
    		            'jml_mk' => intval($dtKu['jml_mk'])+1
    		        ];
    		        if($this->kuliahulang->simpanData($record)){
    		            $record_nilai = [
    		                'id_ljk' => $this->request->getVar('id_ljk'),
    		                'id_ku' => $dtKu['id']
    		            ];
    		            if($NilaiModel->save($record_nilai)){
    		                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil ditambahkan."));
    		            }else{
    		                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal ditambahkan."));
    		            }
    		        }
    		    }
		        
		    }else{
		        return json_encode(array("msg" => "error", "pesan" => "Anda belum melakukan pemrograman KRS pada semester ini!!!"));
		    }
		}
		
		if($this->request->getMethod()=="post" && $this->request->getVar('aksi')=='hapus'){
		    $NilaiModel = new \App\Models\NilaiModel($this->request);
		    
		    $dtKu = $this->kuliahulang->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])->first();
		    
	        $record = [
	            'id' => $dtKu['id'],
	            'jml_mk' => intval($dtKu['jml_mk'])-1
	        ];
	        if($this->kuliahulang->simpanData($record)){
	            $record_nilai = [
	                'id_ljk' => $this->request->getVar('id_ljk'),
	                'id_ku' => NULL
	            ];
	            if($NilaiModel->save($record_nilai)){
	                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil dihapus."));
	            }else{
	                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal dihapus."));
	            }
	        }
		}
         
        $data['templateJudul'] = "Formulir ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'formulir_kuliah_ulang';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    private function set_key_data_ljk($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail['id_ljk']] = $detail;
        }

        return $return;
    }
    
    function listMkTl()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $id_ku = (!empty(getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])))?getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])['id']:'';
            $tl = $NilaiModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'Status_Nilai !=' => 'L', 't_akad <' => $this->request->getVar('kd_ta')])->orderBy('smt_mhs asc')->findAll();
            $ku = $NilaiModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'id_ku' => $id_ku])->findAll();
            
            $result_tl = $this->set_key_data_ljk($tl);
            $result_ku = $this->set_key_data_ljk($ku);

            foreach ($result_tl as $index => $item) {
                if (isset($result_ku[$index]))
                    unset($result_tl[$index]);
            }
            
            $lists = array_values($result_tl);
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = '<a onclick="tambahMkUlang('."'".$list['id_ljk']."','".$list['id_his_pdk']."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>';
                $row[] = $no;
                $row[] = $list['kode_mk_feeder'];
                $row[] = getDataRow('master_matakuliah', ['kode_mk' => $list['kode_mk_feeder']])['nama_mk'];
                $row[] = $list['sks'];
                $row[] = getDataRow('tahun_akademik',['kode'=>$list['t_akad']])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list['t_akad']])['semester'] == '1'?'Gasal':'Genap');
                
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->kuliahulang->countAll(),
                //'recordsFiltered' => $this->kuliahulang->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function listMkKu()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $id_ku = (!empty(getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])))?getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])['id']:'';
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $NilaiModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'id_ku' => $id_ku])->findAll();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = '<a onclick="hapusMkUlang('."'".$list['id_ljk']."','".$list['id_his_pdk']."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-minus"></i></a>';
                $row[] = $no;
                $row[] = $list['kode_mk_feeder'];
                $row[] = getDataRow('master_matakuliah', ['kode_mk' => $list['kode_mk_feeder']])['nama_mk'];
                $row[] = $list['sks'];
                
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->kuliahulang->countAll(),
                //'recordsFiltered' => $this->kuliahulang->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function prosesMkUlang()
    {
        $data = [];
        
        if($this->request->getVar('id_ku')){
			
			$data['ku'] = $this->kuliahulang->find($this->request->getVar('id_ku'));
			$data['mk_ku'] = dataDinamis('data_ljk', ['id_ku' => $this->request->getVar('id_ku')]);
		}
		
		if($this->request->getMethod()=="post" && $this->request->getVar('aksi')=='hapus'){
		    $NilaiModel = new \App\Models\NilaiModel($this->request);
		    
		    $dtKu = $this->kuliahulang->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])->first();
		    
	        $record = [
	            'id' => $dtKu['id'],
	            'jml_mk' => intval($dtKu['jml_mk'])-1
	        ];
	        if($this->kuliahulang->simpanData($record)){
	            $cekNilai = $NilaiModel->find($this->request->getVar('id_ljk'));
	            if(empty($cekNilai['id_mk_asal']) || $cekNilai['id_mk_asal'] == NULL){
	                $record_nilai = [
    	                'id_ljk' => $this->request->getVar('id_ljk'),
    	                'id_ku' => NULL
    	            ];
	            }else{
	                $record_nilai = [
    	                'id_ljk' => $this->request->getVar('id_ljk'),
    	                'id_ku' => NULL,
    	                'id_mk' => $cekNilai['id_mk_asal'],
    	                'id_mk_pengganti' => NULL,
    	                'id_mk_asal' => NULL
    	            ];
	            }
    	            
	            if($NilaiModel->save($record_nilai)){
	                return json_encode(array("msg" => "success", "pesan" => "Matakuliah Ulang berhasil dihapus.", "id_ku"=> $dtKu['id']));
	            }else{
	                return json_encode(array("msg" => "error", "pesan" => "Matakuliah Ulang gagal dihapus.", "id_ku"=> $dtKu['id']));
	            }
	        }
		}
		
		$data['templateJudul'] = "Proses Pendaftaran ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'prosesMkUlang';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listProsesMkKu()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        //$id_ku = (!empty(getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])))?getDataRow('kuliah_ulang',['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kd_ta' => $this->request->getVar('kd_ta')])['id']:'';
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $NilaiModel->where(['id_ku' => $this->request->getVar('id_ku')])->findAll();
            $kd_ta_ku = getDataRow('kuliah_ulang', ['id' => $this->request->getVar('id_ku')])['kd_ta'];
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = '<a onclick="hapusMkUlang('."'".$list['id_ljk']."','".$list['id_his_pdk']."','".$kd_ta_ku."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-minus"></i></a>
                            <a onclick="pilihMkUlang('."'".$list['id_ljk']."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Proses"><i class="fa fa-cog"></i></a>
                        ';
                $row[] = $no;
                $row[] = $list['kode_mk_feeder'];
                $row[] = getDataRow('master_matakuliah', ['kode_mk' => $list['kode_mk_feeder']])['nama_mk'];
                $row[] = $list['sks'];
                $row[] = (!empty($list['id_mk_pengganti']))?getDataRow('mata_kuliah', ['id' => $list['id_mk_pengganti']])['Kode_MK_Feeder']:'';
                $row[] = (!empty($list['id_mk_pengganti']))?getDataRow('mata_kuliah', ['id' => $list['id_mk_pengganti']])['Mata_Kuliah']:'';
                $row[] = (!empty($list['id_mk_pengganti']))?((!empty(getDataRow('mata_kuliah', ['id' => $list['id_mk_pengganti']])['Kd_Dosen']))?getDataRow('data_dosen', ['Kode'=>getDataRow('mata_kuliah', ['id' => $list['id_mk_pengganti']])['Kd_Dosen']])['Nama_Dosen']:'Jadwal Belum Disetting'):'';
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->kuliahulang->countAll(),
                //'recordsFiltered' => $this->kuliahulang->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getDataMkUlang()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $data = [];
        $data = $NilaiModel->find($this->request->getVar('id_ljk'));
        $data['nama_mk'] = getDataRow('master_matakuliah', ['kode_mk' => $data['kode_mk_feeder']])['nama_mk']." (".$data['kode_mk_feeder'].")";
        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    function simpanMkKu()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if($this->request->getMethod()=="post"){
            $jadwalMkUlang = getDataRow('mata_kuliah', ['id' => $this->request->getVar('mk_pengganti')]);
            $kodeKelasMhs = getDataRow('akademik_krs', ['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => $this->request->getVar('periode')])['kode_kelas'];
            $cekJadwal = getDataRow('mata_kuliah', ['kode_kelas' => $kodeKelasMhs, 'H_Jadwal' => $jadwalMkUlang['H_Jadwal'], 'Jam_Jadwal' => $jadwalMkUlang['Jam_Jadwal']]);
            if(!empty($cekJadwal)){
                echo json_encode(array("msg" => "warning", "pesan" => "Jadwal MK yang akan diulang berbenturan dengan MK di semester aktif!!"));
            }else{
                
                $record = [
                    'id_ljk' => $this->request->getVar('id_ljk'),
                    'id_mk' => $this->request->getVar('mk_pengganti'),
                    'id_mk_pengganti' => $this->request->getVar('mk_pengganti'),
                    'id_mk_asal' => $this->request->getVar('id_mk')
                ];
                
                //$aksi = $model->simpanData($record);
                if($NilaiModel->save($record)){
                    echo json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan.", "id_ku" => $this->request->getVar('id_ku')));
                }else{
                    echo json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan.", "id_ku" => $this->request->getVar('id_ku')));

                }

            }
            
        }
    }
    
    function tetapsimpanMkKu()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if($this->request->getMethod()=="post"){
            $record = [
                'id_ljk' => $this->request->getVar('id_ljk'),
                'id_mk' => $this->request->getVar('mk_pengganti'),
                'id_mk_pengganti' => $this->request->getVar('mk_pengganti'),
                'id_mk_asal' => $this->request->getVar('id_mk')
            ];
            
            //$aksi = $model->simpanData($record);
            if($NilaiModel->save($record)){
                echo json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan.", "id_ku" => $this->request->getVar('id_ku')));
            }else{
                echo json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan.", "id_ku" => $this->request->getVar('id_ku')));

            }
        }
    }
    
    function cetak()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $id_ku = $this->request->getVar('id_ku');
        $data['ku']         = $this->kuliahulang->find($this->request->getVar('id_ku'));
		$data['mk_ku']      = $NilaiModel->where(['id_ku' => $id_ku])->findAll();
		
		$data['templateJudul'] = "Cetak Formulir ".$this->halaman_label;
        $data['metode']    = 'cetak';

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
                            	'margin_right' => 10,
                            	'margin_top' => 40,
                            	'margin_bottom' => 10,]);
		
		$html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
		$output ="Form_KU_".getDataRow('db_data_diri_mahasiswa',['id' => getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['id_data_diri']])['Nama_Lengkap'].".pdf";
		$stylesheet = file_get_contents('./assets/mpdfstyletables.css');
		$mpdf->defaultheaderline = 0;
		$mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
		$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
		
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($output,'I');
    }
    
    function getMhs()
    {
        $CariModel = new \App\Models\CariModel();
        $json =[];
        $val = $this->request->getVar('search');
        $data = $CariModel->getDataAutoComplete('db_data_diri_mahasiswa', 'Nama_Lengkap', $val, null, null, 'id, Nama_Lengkap, th_angkatan, kelas');
        
        foreach ($data as $row) {
            //$his_pdk = getDataRow('histori_pddk', ['id_data_diri' => $row->id]);
            //$json[] = ['id'=>(!empty($his_pdk)?$his_pdk['id_his_pdk']:''), 'text'=>$row->Nama_Lengkap, 'Prodi'=>(!empty($his_pdk)?$his_pdk['Prodi']:''), 'Program' => (!empty($his_pdk)?$his_pdk['Program']:''), 'nim' => (!empty($his_pdk)?$his_pdk['NIM']:''), 'th_angkatan'=>$row->th_angkatan, 'kelas'=>$row->kelas];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $row->id, 'status' => 'A']);
            foreach($his_pdk as $h){
                $json[] = ['id'=>(!empty($h)?$h->id_his_pdk:''), 'text'=>$row->Nama_Lengkap, 'Prodi'=>(!empty($h)?$h->Prodi:''), 'Program' => (!empty($h)?$h->Program:''), 'nim' => (!empty($h)?$h->NIM:''), 'th_angkatan'=>$row->th_angkatan, 'kelas'=>$row->kelas];
            
            }
        }
        echo json_encode($json);
    }
    
    function getSMT()
    {
        
        echo "<option ></option>";
        
        $id_his_pdk = $this->request->getVar('mhs');
        $data = $this->khs->where(['id_his_pdk' => $id_his_pdk])->groupBy('smt_mhs')->orderBy('smt_mhs ASC')->findAll();
        //$data = dataDinamis('data_ljk', ['id_his_pdk' => $id_his_pdk], 'smt_mhs ASC', 'smt_mhs');
        //dd($data);
        foreach ($data as $row => $val ){
            echo "<option value='".$val['smt_mhs']."'>SMT ".$val['smt_mhs']."</option>";
        }
    }
    
    // Fungsi tambahan
    function updateLjk()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $id_ku = $this->request->getVar('id_ku');
        $data_ljk = dataDinamis('data_ljk', ['id_ku' => $id_ku]);
        $jmlSukses          = 0;
        $jmlError           = 0;
        foreach($data_ljk as $r){
            $record = [
                'id_ljk' => $r->id_ljk,
                'id_mk_asal' => $r->id_mk
            ];
            if($NilaiModel->save($record)){
                $jmlSukses++;
            }else{
                $jmlError++;
            };
        }
        
        if($jmlError > 0){
            return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate, ".$jmlError." gagal diupdate."));
        }else{
            return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate."));
        } 
    }
}
