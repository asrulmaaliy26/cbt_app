<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\CutiModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cuti extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->cuti = new CutiModel($request);
        $this->halaman_controller = "cuti";
        $this->halaman_label = "Cuti";
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
                $dt = $this->cuti->find($this->request->getVar('id'));
                if($dt['id_cuti']){ #memastikan ada data
                    
                    $aksi = $this->cuti->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("msg" => 'success', 'pesan' => 'Permohonan cuti berhasil dihapus'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Permohonan cuti gagal dihapus'));
                    }
                   
                }
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){
                $KrsModel = new \App\Models\KrsModel($this->request);
                $dataCuti = $this->cuti->find($this->request->getVar('id'));
                if($dataCuti['id_cuti']){ #memastikan ada data
                    $record = [
                        'id_cuti' => $this->request->getVar('id'),
                        'status' => '2'
                    ];
                    
                    $update_krs = [
                        'id' => $dataCuti['id_krs'],
                        'stat_mhs' => 'C'
                    ];
                    
                    if($this->cuti->save($record)){
                        $KrsModel->save($update_krs);
                        return json_encode(array("msg" => 'success', 'pesan' => 'Permohonan cuti telah disetujui'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Permohonan cuti gagal disetujui'));
                    }
                }
            }

            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $KrsModel = new \App\Models\KrsModel($this->request);
                $dataCuti = $this->cuti->find($this->request->getVar('id'));
                if($dataCuti['id_cuti']){ #memastikan ada data
                    $record = [
                        'id_cuti' => $this->request->getVar('id'),
                        'status' => '1'
                    ];
                    $update_krs = [
                        'id' => $dataCuti['id_krs'],
                        'stat_mhs' => 'N'
                    ];
                    if($this->cuti->save($record)){
                        $KrsModel->save($update_krs);
                        return json_encode(array("msg" => 'success', 'pesan' => 'Persetujuan cuti telah dibatalkan'));
                    }else{
                        return json_encode(array("msg" => 'error', 'pesan' => 'Persetujuan cuti gagal dibatalkan'));
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
            $lists = $this->cuti->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                if(session()->get('akun_level') == "Admin"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_cuti.'" />';
                $row[] = $no;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = $list->Program;
                $row[] = $list->th_angkatan;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->status == '2' ? '<a onclick="deactivate('."'".$list->id_cuti."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah status"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_cuti."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah status"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '
                            <a onclick="hapus('."'".$list->id_cuti."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a href="javascript:void(0)" data-placement="bottom" title="Cetak" class="btn btn-xs btn-success" onclick="cetak('."'".$list->id_cuti."'".'); return false;"><i class="fas fa-print"></i></a>
                        ';
                }
                
                if(session()->get('akun_level') == "Mahasiswa"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_cuti.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->kd_ta])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->status == '2' ? '<i class="fas fa-check fa-lg text-green" ></i>':'<i class="fas fa-times fa-lg text-red" ></i>';
                $row[] = '
                            <a href="javascript:void(0)" data-placement="bottom" title="Cetak" class="btn btn-xs btn-success" onclick="cetak('."'".$list->id_cuti."'".'); return false;"><i class="fas fa-print"></i></a>
                        ';
                }
               $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->cuti->countAll(),
                'recordsFiltered' => $this->cuti->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function formulir()
    {
        $data = [];
        
        if($this->request->getVar('kd_ta')){
			
			$data['ta'] = getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_ta')]);
			
		}
		
		if($this->request->getVar('m')){
			
			$data['m'] = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('m')]);
			
		}
		
		if($this->request->getMethod()=="post" ){
		    $aturan = [
                'periode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'm' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'alasan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
		    if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                $record = [
                    'kd_ta' => $this->request->getVar('periode'),
                    'id_krs' => $this->request->getVar('id_krs'),
                    'id_his_pdk' => $this->request->getVar('m'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'alasan' => $this->request->getVar('alasan'),
                ];
                
                if($this->cuti->save($record)){
                    return json_encode(array("msg" => "success", "pesan" => "Permohonan cuti telah diajukan. Silahkan ke kantor BAAK untuk proses lebih lanjut!!."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Permohonan cuti gagal diajukan."));
    
                }
                
            }
		    
		    
		}
         
        $data['templateJudul'] = "Formulir ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'formulir';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
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
    
    function getidKrs()
    {
        $dataKrs = getDataRow('akademik_krs', ['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => $this->request->getVar('kd_ta')]);
        if(!empty($dataKrs)){
            return json_encode(array("msg" => "success", 'id_krs' => $dataKrs['id']));
        }else{
            return json_encode(array("msg" => "error", 'pesan' => "Mahasiswa tersebut tidak ditemukan di data KRS periode ini. Silahkan masukkan ke dalam kelas terlebih dahulu!!"));
        }
        
    }
    
    public function getData()
    {
        
        $data = $this->cuti->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true));
        }
        
    }
    
    function cetak()
    {
        
        $data['cuti']         = $this->cuti->find($this->request->getVar('id'));
		
		$data['templateJudul'] = "Cetak Formulir ".$this->halaman_label;
        $data['metode']    = 'cetak';

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
                            	'margin_right' => 10,
                            	'margin_top' => 40,
                            	'margin_bottom' => 10,]);
		
		$html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
		$output ="Form_KU_".getDataRow('db_data_diri_mahasiswa',['id' => getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['id_data_diri']])['Nama_Lengkap'].".pdf";
		$stylesheet = file_get_contents('./assets/mpdfstyletables.css');
		$mpdf->defaultheaderline = 0;
		$mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
		$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
		
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($output,'I');
    }
    
    
    function detail()
    {
        $data = [];
        
        if($this->request->getVar('id')){
			$data = $this->akm->find($this->request->getVar('id'));
			$data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
		}
         
        $data['templateJudul'] = "Detail ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    
}
