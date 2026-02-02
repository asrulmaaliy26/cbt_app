<?php

namespace App\Controllers\Admin\Proyek;

use App\Controllers\BaseController;
use App\Models\ProyekModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


class Perencanaan extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        //$this->perencanaan = new PerencanaanProyekModel();
        $this->proyek = new ProyekModel();
        $this->halaman_controller = "perencanaan";
        $this->halaman_label = "Perencanaan";
    }
    
    public function index()
    {
        $data = [];
        
        $jumlah_baris = $this->request->getVar('jml_baris');
        if(empty($this->request->getVar('jml_baris'))){
            $jumlah_baris = 10;
        }
        $kata_kunci =$this->request->getVar('kata_kunci');
        
        $group_dataset = 'dt';
        $hasil = $this->proyek->list($jumlah_baris, $kata_kunci, $group_dataset);
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
        return view(session()->get('akun_group_folder')."/proyek/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function getData()
    {
        
        $data = $this->proyek->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    function rincian()
    {
        $RincianProyekModel = new \App\Models\RincianProyekModel();
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {
            $aturan = [
                'uraian_pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                if(empty($this->request->getVar('id_pekerjaan'))){
                    $record = [
                        'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan'),
                        'id_proyek' => $this->request->getVar('id_proyek')
                    ];
                    if($this->request->getVar('parent_id')){
                        $record = [
                            'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan'),
                            'id_proyek' => $this->request->getVar('id_proyek'),
                            'parent_id' => $this->request->getVar('parent_id')
                        ];
                    }
                }else{
                    $record = [
                        'id_pekerjaan' => $this->request->getVar('id_pekerjaan'),
                        'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan'),
                        'id_proyek' => $this->request->getVar('id_proyek')
                    ];
                    if($this->request->getVar('parent_id')){
                        $record = [
                            'id_pekerjaan' => $this->request->getVar('id_pekerjaan'),
                            'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan'),
                            'id_proyek' => $this->request->getVar('id_proyek'),
                            'parent_id' => $this->request->getVar('parent_id')
                        ];
                    }
                }
                if($RincianProyekModel->save($record)){
                    return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan!!"));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan!!"));
    
                }
            }
        }
        if($this->request->getVar('id')){
          
            $data = $this->proyek->find(base64_decode(urldecode($this->request->getVar('id'))));
            $data['rincian'] = $RincianProyekModel->where(['id_proyek' => $data['id_proyek']])->findAll();
		}
		
        
        $data['templateJudul'] = "Perencanaan Proyek ".$data['nama_proyek'];
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'rincian';
        return view(session()->get('akun_group_folder')."/proyek/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function tambahSubPekerjaan()
    {
        $RincianProyekModel = new \App\Models\RincianProyekModel();
        $data = [];
        
        if($this->request->getMethod()=="post"){
            
            
            $aturan = [
                'uraian_pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];

            if(!$this->validate($aturan)){
                return json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            }else{
                $record = [
                    'id_proyek' => $this->request->getVar('id_proyek'),
                    'parent_id' => $this->request->getVar('parent_id'),
                    'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan')
                ];
                if($RincianProyekModel->save($record)){
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Pekerjaan berhasil disimpan"));
                }else{
                    return json_encode(array("status"=>true, "msg" => "error", "pesan" => "Pekerjaan tidak tersimpan"));
                }
            }
                
        }
		
		$data = $RincianProyekModel->find($this->request->getVar('id_pekerjaan'));
        //dd($data);
		$data['templateJudul'] = $this->halaman_label;
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tambahSubPekerjaan';
    
        
		return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
}
