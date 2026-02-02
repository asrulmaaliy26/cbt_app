<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CariModel;

class GlobalController extends BaseController
{
    function __construct()
    {
        
        $this->model = new CariModel();
        helper('global_helper');
        
    }

    function getWilayah()
    {
        $where_val = $this->request->getVar('where_val');
        $where_field = $this->request->getVar('where_field');
        $groupBy = $this->request->getVar('groupBy');
        $table = $this->request->getVar('table');
        $data = $this->model->getData($table, $where_field, $where_val, $groupBy);
        echo json_encode($data);
    }

    function getWilayahAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field');
        $groupBy = $this->request->getVar('groupBy');
        //$table = $this->request->getVar('table');
        $data = $this->model->getDataAutoComplete('tbl_kodepos', $field, $val, $groupBy);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->provinsi, 'text'=>$row->provinsi];
        }
        echo json_encode($json);
    }

    function getKabAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field');
        $groupBy = $this->request->getVar('groupBy');
        $where = ['provinsi' => $this->request->getVar('whereProp')];
        $data = $this->model->getDataAutoComplete('tbl_kodepos', $field, $val, $groupBy, $where);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->kabupaten, 'text'=>$row->kabupaten];
        }
        echo json_encode($json);
    }
    function getKecAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field');
        $groupBy = $this->request->getVar('groupBy');
        $where = ['provinsi' => $this->request->getVar('whereProp'), 
                    'kabupaten' =>  $this->request->getVar('whereKab')];
        $data = $this->model->getDataAutoComplete('tbl_kodepos', $field, $val, $groupBy, $where);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->kecamatan, 'text'=>$row->kecamatan];
        }
        echo json_encode($json);
    }
    function getDesaAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field');
        $groupBy = $this->request->getVar('groupBy');
        $where = ['provinsi' => $this->request->getVar('whereProp'), 
                    'kabupaten' =>  $this->request->getVar('whereKab'),
                    'kecamatan' =>  $this->request->getVar('whereKec')
                ];
        $data = $this->model->getDataAutoComplete('tbl_kodepos', $field, $val, $groupBy, $where);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->kelurahan, 'text'=>$row->kelurahan, 'kodepos'=>$row->kodepos];
        }
        echo json_encode($json);
    }

    function getMahasiswaAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field2 = $this->request->getVar('field2');        
        $field1 = $this->request->getVar('field1');
        $select = "m.Nama_Lengkap, h.NIM, h.Prodi, h.Program, m.kelas, h.id_his_pdk, h.Kelas";
        //$join = "'histori_pddk as h','h.id_data_diri=m.id','inner'";
        $where = ['h.jns_keluar' => NULL];
        //$table = $this->request->getVar('table');
        $data = $this->model->getDataMahasiswaAutoComplete('db_data_diri_mahasiswa as m', $field1, $field2, $val, $select, $where);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->id_his_pdk, 'text'=>$row->Nama_Lengkap." - ".$row->NIM." - ".$row->Program." - ".$row->Prodi. " - ".$row->Kelas];
        }
        echo json_encode($json);
    }

    function getNamaAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field'); 
        $table = $this->request->getVar('tabel');
        $select = $this->request->getVar('select');
        $data = $this->model->getDataAutoComplete($table, $field, $val, null, null, $select);
        /*
        if($table == 'tb_siswa'){
            foreach ($data as $row) {
                
                $json[] = ['id'=>$row->nama_siswa, 'text'=>$row->nama_siswa." - ".$row->nisn, 'id_guru_siswa' => $row->id_siswa];
            }
        }
        if($table == 'tb_guru'){
            foreach ($data as $row) {
                
                $json[] = ['id'=>$row->nama_lengkap, 'text'=>$row->nama_lengkap, 'id_guru_siswa' => $row->id_guru];
            }
        }
        */
        foreach ($data as $row) {
                
            $json[] = ['id'=>$row->id, 'text'=>$row->text." - ".$row->atribut1, 'atribut1' => $row->atribut1];
        }
        echo json_encode($json);
    }

    function getKelas()
    {
         echo "<option ></option>";
        $where_val = $this->request->getVar('kd_tingkatan');
        $data = $this->model->getData('tb_kelas', 'kd_tingkatan', $where_val, null);
        foreach ($data as $row){
            echo "<option value='$row->kd_kelas'>$row->nm_kelas</option>";
        }
    }
    
    function getNamaCalonUserAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('tabel')=='data_dosen'?'Nama_Dosen':'Nama_Lengkap'; 
        $table = $this->request->getVar('tabel');
        $data = $this->model->getDataAutoComplete($table, $field, $val);
        if($table == 'data_dosen'){
            foreach ($data as $row) {
                
                $json[] = ['id'=>$row->Nama_Dosen, 'text'=>$row->Nama_Dosen, 'id_dosen_mhs' => $row->id_dosen];
            }
        }
        if($table == 'db_data_diri_mahasiswa'){
            foreach ($data as $row) {
                
                $json[] = ['id'=>$row->Nama_Lengkap, 'text'=>$row->Nama_Lengkap." - ".$row->th_angkatan, 'id_dosen_mhs' => $row->id];
            }
        }
        echo json_encode($json);
    }
    
    function getMatakuliahAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('field');
        $table = $this->request->getVar('tabel');
        $where = ['Prodi' => $this->request->getVar('prodi'), 
                    'Kelas' =>  $this->request->getVar('kelas'),
                    'Kd_Tahun' => $this->request->getVar('kd_tahun')
                ];
        $data = $this->model->getDataAutoComplete($table, $field, $val, null, $where);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->id, 'text'=>$row->Mata_Kuliah." - ".$row->Kelas." (".$row->Kode_MK_Feeder.")"];
        }
        echo json_encode($json);
    }
    
    function grade_nilai()
    {
		
		$nilai = $this->request->getVar('nilai');
		
		$grade_nilai = dataDinamis('grade_nilai');
		foreach ($grade_nilai as $s)
        {
            if($nilai >=$s->batas_bawah_puluhan and $nilai <= $s->batas_atas_puluhan)
            {
                $predikat= $s->grade;
            }
        }
		
		return json_encode(array('predikat' => $predikat));
    }

}
