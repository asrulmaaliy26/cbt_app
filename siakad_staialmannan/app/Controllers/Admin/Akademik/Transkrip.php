<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use Config\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Transkrip extends BaseController
{

	function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->transkrip = new NilaiModel($request);
        $this->halaman_controller = "transkrip";
        $this->halaman_label = "Transkrip Nilai";
    }
    
    public function index()
    {
        $data = [];
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data ['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
        }
        

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function getMhs()
    {
        $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
        echo "<option ></option>";
        $th_angkatan = $this->request->getVar('selectedTa');
        $prodi = $this->request->getVar('selectedProdi');
        $data = $MahasiswaModel->where(['db_data_diri_mahasiswa.th_angkatan' => $th_angkatan, 'h.Prodi' => $prodi, 'h.Status' => "A"])->join('histori_pddk as h','h.id_data_diri=db_data_diri_mahasiswa.id', 'inner')->findAll();
        
        foreach ($data as $row => $val){
            echo "<option value='".$val['id_his_pdk']."'>".$val['Nama_Lengkap']."</option>";
        }
    }

    function getTranskrip()
    {
        $data = [];
    
        $data     = $this->request->getVar();
        $data['his_pdk'] = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')]);
        $data['nilai'] = $this->transkrip->select('mata_kuliah.Kode_MK_Feeder,
                                    mata_kuliah.Mata_Kuliah,
                                    mata_kuliah.SKS,
                                    master_matakuliah.nama_mk,
                                    data_ljk.Nilai_Akhir as am,
                                    data_ljk.Nilai_Huruf as hm,
                                    data_ljk.Status_Nilai,
                                    data_ljk.Rekom_Nilai')
                            ->where(array('data_ljk.id_his_pdk'=> $this->request->getVar('id_his_pdk')))
                            ->join('mata_kuliah','data_ljk.id_mk = mata_kuliah.id','left')
                            ->join('master_matakuliah','data_ljk.kode_mk_feeder=master_matakuliah.kode_mk','left')
                            ->orderBy('mata_kuliah.SMT, mata_kuliah.Mata_Kuliah','ASC')
                            ->groupBy('mata_kuliah.Kode_MK_Feeder')
                            ->get()->getResult();
        $data['controller'] = $this->halaman_controller;
        $data['metode']     = 'getTranskrip';
        
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/getTranskrip", $data);
    }

    public function cetakTranskrip()
    {
        $data = [];
        $data     = $this->request->getVar();
        $data['his_pdk'] = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')]);
        $data['nilai'] = $this->transkrip->select('mata_kuliah.Kode_MK_Feeder,
                                    mata_kuliah.Mata_Kuliah,
                                    mata_kuliah.SKS,
                                    master_matakuliah.nama_mk,
                                    data_ljk.Nilai_Akhir as am,
                                    data_ljk.Nilai_Huruf as hm,
                                    data_ljk.Status_Nilai,
                                    data_ljk.Rekom_Nilai')
                            ->where(array('data_ljk.id_his_pdk'=> $this->request->getVar('id_his_pdk')))
                            ->join('mata_kuliah','data_ljk.id_mk = mata_kuliah.id','left')
                            ->join('master_matakuliah','data_ljk.kode_mk_feeder=master_matakuliah.kode_mk','left')
                            ->orderBy('mata_kuliah.SMT, mata_kuliah.Mata_Kuliah','ASC')
                            ->groupBy('mata_kuliah.Kode_MK_Feeder')
                            ->get()->getResult();
        $writer = new PngWriter();

        // Create QR code
        $dataQr = getDataRow('prodi', ['singkatan'=>$data['his_pdk']['Prodi']])['kaprodi'].";".getDataRow('prodi', ['singkatan'=>$data['his_pdk']['Prodi']])['niy'].";".$this->request->getVar('id_his_pdk');
        $qrCode = QrCode::create($dataQr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        
        // Create generic logo
        /*
        $logo = Logo::create(FCPATH .'assets/logo_iaibafa.png')
            ->setResizeToWidth(70)
            ->setPunchoutBackground(true)
        ;*/
        
        // Create generic label
        //$label = Label::create('Label')->setTextColor(new Color(255, 0, 0));
        
        //$result = $writer->write($qrCode, $logo, $label);
        $result = $writer->write($qrCode);
       
        $data['qrcode'] = $result->getDataUri();
        return view(session()->get('akun_group_folder')."/akademik/".$this->halaman_controller."/cetakTranskrip", $data);
    }
    
}