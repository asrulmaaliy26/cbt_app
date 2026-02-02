<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CariModel;

class Cari extends BaseController
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

    function getSiswaAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field2 = $this->request->getVar('field2');        
        $field1 = $this->request->getVar('field1');
        //$table = $this->request->getVar('table');
        $data = $this->model->getDataSiswaAutoComplete('tb_siswa', $field1, $field2, $val);
        
        foreach ($data as $row) {
            
            $json[] = ['id'=>$row->id_siswa, 'text'=>$row->nama_siswa." - ".$row->nisn];
        }
        echo json_encode($json);
    }

    function getNamaAutoComplete()
    {
        $json =[];
        $val = $this->request->getVar('search');
        $field = $this->request->getVar('tabel')=='Guru'?'nama_lengkap':'nama_siswa'; 
        $table = $this->request->getVar('tabel')=='Guru'?'tb_guru':'tb_siswa';
        $data = $this->model->getDataAutoComplete($table, $field, $val);
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

}
