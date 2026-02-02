<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nilai extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->nilai = new NilaiModel($request);
        $this->halaman_controller = "nilai";
        $this->halaman_label = "Nilai";
    }
    
    public function index()
    {
        $data = [];
        
        if($this->request->getVar('id_mk')){
            $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
            $data = $DistribusiMkModel->find($this->request->getVar('id_mk'));
        }
        
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $DistribusiMkModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                $link_input_nilai = site_url("akademik/$this->halaman_controller/input_nilai?id_mk=").$list->id;
                $link_detail = site_url("akademik/$this->halaman_controller?id_mk=").$list->id;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->Prodi;
                $row[] = $list->Kelas;
                $row[] = $list->SMT;
                $row[] = $list->Nama_Dosen;
                
                $row[] = '<a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Lihat Nilai"><i class="fa fa-eye"></i></a>
                            <a href="'.$link_input_nilai.'" class="btn btn-xs btn-success" data-placement="top" title="Input Nilai"><i class="fa fa-edit"></i></a>
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $DistribusiMkModel->countAll(),
                'recordsFiltered' => $DistribusiMkModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function ajaxListDetailNilai()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->nilai->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['id_data_diri'];
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ljk.'" />';
                $row[] = $no;
                $row[] = (!empty(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])))?getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']:'';
                $row[] = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['NIM'];
                $row[] = number_format($list->Nilai_UTS, 2) < 3.1 ? '<span class="badge badge-danger">'.number_format($list->Nilai_UTS, 2).'</span>': number_format($list->Nilai_UTS, 2);
                $row[] = number_format($list->Nilai_TGS, 2) < 3.1 ? '<span class="badge badge-danger">'.number_format($list->Nilai_TGS, 2).'</span>': number_format($list->Nilai_TGS, 2);
                $row[] = number_format($list->Nilai_UAS, 2) < 3.1 ? '<span class="badge badge-danger">'.number_format($list->Nilai_UAS, 2).'</span>': number_format($list->Nilai_UAS, 2);
                $row[] = number_format($list->Nilai_Performance, 2) < 3.1 ? '<span class="badge badge-danger">'.number_format($list->Nilai_Performance, 2).'</span>': number_format($list->Nilai_Performance, 2);
                $row[] = number_format($list->Nilai_Akhir, 2) < 3.1 ? '<span class="badge badge-danger">'.number_format($list->Nilai_Akhir, 2).'</span>': number_format($list->Nilai_Akhir, 2);
                $row[] = number_format($list->Nilai_Akhir, 2) < 3.1 ? '<span class="badge badge-danger">'.$list->Nilai_Huruf.'</span>':$list->Nilai_Huruf;
                if(session()->get('akun_level') != "Kaprodi"){
                $row[] = (empty(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'])) ? '':((number_format(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'], 2) < 3.1)?'<span class="badge badge-danger">'.number_format(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'], 2).'</span>': number_format(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'], 2));
                $row[] = (empty(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk]))) ? '':((number_format(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'], 2) < 3.1)?'<span class="badge badge-danger">'.getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['h_kaprodi'].'</span>': getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['h_kaprodi']);
                }
                if(session()->get('akun_level') == "Kaprodi"){
                $row[] = (empty(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk]))) ? '<input type="number" step=".01" min="3.10" max="4.00" name="nilai_akhir[]" id="na'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_nilai('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']))."'".')" value=""/>':'<input type="number" step=".01" min="3.10" max="4.00" name="nilai_akhir[]" id="na'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_nilai('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']))."'".')" value="'.getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'].'"/>';
                $row[] = (empty(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk]))) ? '':((number_format(getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['am_kaprodi'], 2) < 3.1)?'<span class="badge badge-danger">'.getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['h_kaprodi'].'</span>': getDataRow('konversi_nilai', ['id_ljk_konv' => $list->id_ljk])['h_kaprodi']);
                }
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $DistribusiMkModel->countAll(),
                //'recordsFiltered' => $DistribusiMkModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function simpan_nilai_kaprodi()
	{
	    if($this->request->getMethod(true) === 'POST'){
	        $KonversiNilaiModel = new \App\Models\KonversiNilaiModel;
	        $nama = $this->request->getVar('nama');
	        $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]',
                    'errors' => [
                        'required'=>'Nilai '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai '.$nama.' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai '.$nama.' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai '.$nama.' tidak boleh kurang dari 3.1'
                    ]
                ]
            ];
             if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai ".$nama." !!"));
            }else{
    	        $grade_nilai=  dataDinamis('grade_nilai');
    	        foreach ($grade_nilai as $s)
                {
                    if($this->request->getVar('nilai') >=$s->batas_bawah and $this->request->getVar('nilai') <= $s->batas_atas)
                    {
                        $h_kaprodi= $s->grade;
                    }
                }
    	        $record = [
    	           'id_ljk_konv' => $this->request->getVar('id'),
    	           'am_kaprodi' => $this->request->getVar('nilai'),
    	           'h_kaprodi' => $h_kaprodi
    	       ];
    	       
        	   if($KonversiNilaiModel->save($record)){
                   return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Nilai ".$nama." berhasil disimpan"));
               }else{
                   return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Nilai ".$nama." gagal disimpan"));
               }
            }
	    }
    	
	}
    
    function input_nilai()
    {
        $data = [];
        
        if($this->request->getVar('id_mk')){
            $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
            $data = $DistribusiMkModel->find($this->request->getVar('id_mk'));
        }
        
        $data['templateJudul'] = "Input ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'input_nilai';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listInputNilai()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->nilai->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['id_data_diri'];
                $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri]);
                $nama_lengkap = (!empty($data_diri))?$data_diri['Nama_Lengkap']:'';
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ljk.'" />';
                $row[] = $no;
                $row[] = (!empty($data_diri))?$data_diri['Nama_Lengkap']:'';
                $row[] = getDataRow('histori_pddk', ['id_his_pdk' => $list->id_his_pdk])['NIM'];
                $row[] = (!empty($list->ljk_uts))?'<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk('."'uts','".$list->id_ljk."'".')">Lihat</a>':'';
                $row[] = (!empty($list->ljk) || !empty($list->artikel))?'<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk('."'uas','".$list->id_ljk."'".')">Lihat</a>':'';
                $row[] = (!empty($list->tugas))?'<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk('."'tugas','".$list->id_ljk."'".')">Lihat</a>':'';
                $row[] = '<input type="number"  step=".01" min="3.50" max="4.00" name="nilai_uts[]" id="uts'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_uts('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper((string)$nama_lengkap))."'".')" value="'.number_format($list->Nilai_UTS,2).'"/>';
                $row[] ='<input type="number" step=".01" min="3.50" max="4.00" name="nilai_tugas[]" id="tugas'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_tugas('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper((string)$nama_lengkap))."'".')" value="'.number_format($list->Nilai_TGS,2).'"/>';
                $row[] ='<input type="number"  step=".01" min="3.50" max="4.00" name="nilai_uas[]" id="uas'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_uas('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper((string)$nama_lengkap))."'".')" value="'.number_format($list->Nilai_UAS,2).'"/>';
                $row[] ='<input type="number" step=".01" min="3.50" max="4.00" name="nilai_p[]" id="p'.$list->id_ljk.'" class="form-control form-control-sm" onfocusout="simpan_p('."'".$list->id_ljk."','".str_replace("'", "`",strtoupper((string)$nama_lengkap))."'".')" value="'.number_format($list->Nilai_Performance,2).'"/>';
                $row[] =number_format($list->Nilai_Akhir,2);
                $row[] =$list->Nilai_Huruf;
                $row[] =$list->Status_Nilai;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $DistribusiMkModel->countAll(),
                //'recordsFiltered' => $DistribusiMkModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function simpan_uts()
	{
	    $NilaiModel = new \App\Models\NilaiModel($this->request);
	    if($this->request->getMethod()=="post"){
	        $id = $this->request->getVar('id');
    		$nama = $this->request->getVar('nama');
    		$Nilai_UTS = $this->request->getVar('nilai_uts');
    		$Tgs = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_TGS'];
    		$Uas = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UAS'];
    		$perf = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_Performance'];
	        $aturan = [
                'nilai_uts' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.5]',
                    'errors' => [
                        'required'=>'Nilai UTS '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai UTS '.$nama.' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UTS '.$nama.' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UTS '.$nama.' tidak boleh kurang dari 3.50'
                    ]
                ]
            ];
            if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UTS ".$nama." !!"));
            }else{
                
        		//$datanilai         = $NilaiModel->find($id);
    			//foreach ($datanilai as $r)
    	        //{
    	           $Nilai_Akhir= number_format((($Nilai_UTS*20)+($Tgs*30)+($Uas*30)+($perf*20))/100,2);
    	           $grade_nilai=  dataDinamis('grade_nilai');
    		        if ($Nilai_UTS==0 or $Tgs==0 or $Uas==0 or $perf==0) {
    	           		
    	           		foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_UTS' =>$Nilai_UTS,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => 'TL',
    			                        'Rekom_Nilai'=>'Kuliah Ulang',
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    			                
    			            }
    			        }
    	           }else{
    	           		
    			        foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_UTS' =>$Nilai_UTS,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => $s->keterangan,
    			                        'Rekom_Nilai'=>$s->anjuran,
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    
    			            }
    			        }
    	           }
    	           if($NilaiModel->save($record)){
    	               return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Nilai UTS ".$nama." berhasil disimpan"));
    	           }else{
    	               return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Nilai UTS ".$nama." gagal disimpan"));
    	           }
    		    //}
            }
    	        
	    }
    	
	}
	
	function simpan_tugas()
	{
	    $NilaiModel = new \App\Models\NilaiModel($this->request);
	    if($this->request->getMethod()=="post"){
	        $id = $this->request->getVar('id');
    		$nama = $this->request->getVar('nama');
    		$Nilai_Tugas = $this->request->getVar('nilai');
    		$Uts = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UTS'];
    		$Uas = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UAS'];
    		$perf = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_Performance'];
	        $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.5]',
                    'errors' => [
                        'required'=>'Nilai Tugas '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai Tugas '.$nama.' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Tugas '.$nama.' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Tugas '.$nama.' tidak boleh kurang dari 3.50'
                    ]
                ]
            ];
            if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Tugas ".$nama." !!"));
            }else{
                
        		//$datanilai         = $NilaiModel->find($id);
    			//foreach ($datanilai as $r)
    	        //{
    	           $Nilai_Akhir= number_format((($Uts*20)+($Nilai_Tugas*30)+($Uas*30)+($perf*20))/100,2);
    	           $grade_nilai=  dataDinamis('grade_nilai');
    		        if ($Uts==0 or $Nilai_Tugas==0 or $Uas==0 or $perf==0) {
    	           		
    	           		foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_TGS' =>$Nilai_Tugas,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => 'TL',
    			                        'Rekom_Nilai'=>'Kuliah Ulang',
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    			                
    			            }
    			        }
    	           }else{
    	           		
    			        foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_TGS' =>$Nilai_Tugas,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => $s->keterangan,
    			                        'Rekom_Nilai'=>$s->anjuran,
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    
    			            }
    			        }
    	           }
    	           if($NilaiModel->save($record)){
    	               return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Nilai Tugas ".$nama." berhasil disimpan"));
    	           }else{
    	               return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Nilai Tugas ".$nama." gagal disimpan"));
    	           }
    		    //}
            }
    	        
	    }
    	
	}
	
	function simpan_uas()
	{
	    $NilaiModel = new \App\Models\NilaiModel($this->request);
	    if($this->request->getMethod()=="post"){
	        $id = $this->request->getVar('id');
    		$nama = $this->request->getVar('nama');
    		$Uas = $this->request->getVar('nilai');
    		$Uts = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UTS'];
    		$Tgs = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_TGS'];
    		$perf = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_Performance'];
	        $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.5]',
                    'errors' => [
                        'required'=>'Nilai UAS '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai UAS '.$nama.' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UAS '.$nama.' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UAS '.$nama.' tidak boleh kurang dari 3.50'
                    ]
                ]
            ];
            if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UAS ".$nama." !!"));
            }else{
                
        		//$datanilai         = $NilaiModel->find($id);
    			//foreach ($datanilai as $r)
    	        //{
    	           $Nilai_Akhir= number_format((($Uts*20)+($Tgs*30)+($Uas*30)+($perf*20))/100,2);
    	           $grade_nilai=  dataDinamis('grade_nilai');
    		        if ($Uts==0 or $Tgs==0 or $Uas==0 or $perf==0) {
    	           		
    	           		foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_UAS' =>$Uas,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => 'TL',
    			                        'Rekom_Nilai'=>'Kuliah Ulang',
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    			                
    			            }
    			        }
    	           }else{
    	           		
    			        foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_UAS' =>$Uas,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => $s->keterangan,
    			                        'Rekom_Nilai'=>$s->anjuran,
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    
    			            }
    			        }
    	           }
    	           if($NilaiModel->save($record)){
    	               return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Nilai UAS ".$nama." berhasil disimpan"));
    	           }else{
    	               return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Nilai UAS ".$nama." gagal disimpan"));
    	           }
    		    //}
            }
    	        
	    }
    	
	}
	
	function simpan_p()
	{
	    $NilaiModel = new \App\Models\NilaiModel($this->request);
	    if($this->request->getMethod()=="post"){
	        $id = $this->request->getVar('id');
    		$nama = $this->request->getVar('nama');
    		$perf = $this->request->getVar('nilai');
    		$Uts = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UTS'];
    		$Tgs = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_TGS'];
    		$Uas = getDataRow('data_ljk', ['id_ljk'=>$id])['Nilai_UAS'];
	        $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.5]',
                    'errors' => [
                        'required'=>'Nilai Performance '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai Performance '.$nama.' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Performance '.$nama.' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Performance '.$nama.' tidak boleh kurang dari 3.50'
                    ]
                ]
            ];
            if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Performance ".$nama." !!"));
            }else{
                
        		//$datanilai         = $NilaiModel->find($id);
    			//foreach ($datanilai as $r)
    	        //{
    	           $Nilai_Akhir= number_format((($Uts*20)+($Tgs*30)+($Uas*30)+($perf*20))/100,2);
    	           $grade_nilai=  dataDinamis('grade_nilai');
    		        if ($Uts==0 or $Tgs==0 or $Uas==0 or $perf==0) {
    	           		
    	           		foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_Performance' =>$perf,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => 'TL',
    			                        'Rekom_Nilai'=>'Kuliah Ulang',
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    			                
    			            }
    			        }
    	           }else{
    	           	
    			        foreach ($grade_nilai as $s)
    			        {
    			            if($Nilai_Akhir >=$s->batas_bawah and $Nilai_Akhir <= $s->batas_atas)
    			            {
    			                $record =[
    			                        'id_ljk' => $id,
    			                        'Nilai_Performance' =>$perf,
    			                        'Nilai_Akhir'=> $Nilai_Akhir,
    			                        'Status_Nilai' => $s->keterangan,
    			                        'Rekom_Nilai'=>$s->anjuran,
    			                        'Nilai_Huruf' => $s->grade
    			                    ];    
    			            }
    			        }
    	           }
    	           if($NilaiModel->save($record)){
    	               return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Nilai Performance ".$nama." berhasil disimpan"));
    	           }else{
    	               return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Nilai Performance ".$nama." gagal disimpan"));
    	           }
    		    //}
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
    
    //fungsi tambahan untuk memperbaiki tabel data_ljk field t_akad, kd_kelas_perkuliahan, kd_kelas, id_matkul_kurikulum
    function perbaikiLjk()
    {
         $db      = \Config\Database::connect('default');
        $builder = $db->table('data_ljk');
        //$builder->where(['id' => $this->request->getVar('id_data_diri')])->update($record_data_ortu);
        if($this->request->getMethod()=="post"){
            $jmlSukses          = 0;
            $jmlError           = 0;
            $listError          = [];
            
            foreach ($this->request->getVar('id_mk') as $key ) {                
                $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                $record = [
                        't_akad' => $dtMk['Kd_Tahun'],
                        'kd_kelas' => $dtMk['kode_kelas'],
                        'kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan'],
                        'id_matkul_kurikulum' => $dtMk['id_matkul_kurikulum']
                    ];
                
                if($builder->where('id_mk', $key)->update($record)){
                            
                    $jmlSukses++;
                }else{
                    $jmlError++;
                    $listError [] = [
                        'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal diupdate."
                    ];
                };
            }
            if($jmlError > 0){
                return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil , ".$jmlError." gagal .", 'listError' => $listError));
            }else{
                return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil dibuatkan kode perkuliahan."));
            }  
            
        }
    }
}
