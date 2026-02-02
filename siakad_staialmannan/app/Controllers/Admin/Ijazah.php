<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IjazahModel;
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


class Ijazah extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->ijazah = new IjazahModel($request);
        $this->halaman_controller = "ijazah";
        $this->halaman_label = "Ijazah";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                foreach ($this->request->getVar('id') as $key ) {                
                    $dt = getDataRow('tb_ijazah', ['id_ijz'=>$key]);
                    $aksi = $this->ijazah->delete($key);
                    if($aksi){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dt['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." gagal dihapus."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " berhasil dihapus, ".$jmlError." gagal dihapus.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " berhasil dihapus."));
                }  
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){
    
                    $dataIjz = $this->ijazah->find($this->request->getVar('id'));
                    if($dataIjz['id_ijz']){ #memastikan ada data
                        $record = [
                            'id_ijz' => $this->request->getVar('id'),
                            $this->request->getVar('field') => '1'
                        ];
                        
                        if($this->ijazah->save($record)){
                            
                            return json_encode(array("status" => TRUE));
                        }else{
                            return json_encode(array("status" => false));
                        }
                    }
                }
    
            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $dataIjz = $this->ijazah->find($this->request->getVar('id'));
                if($dataIjz['id_ijz']){ #memastikan ada data
                    $record = [
                        'id_ijz' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '0'
                    ];
                    
                    if($this->ijazah->save($record)){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            //$MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data ['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data ['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
            $data['ijazah'] = $this->ijazah->where('id_his_pdk', $data['id_his_pdk'])->first();
            
        }    

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->ijazah->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $link_detail= site_url("$this->halaman_controller/detail?id=").$list->id_ijz;
                if($list->status=='1'){
    			    $status= '<span class="badge badge-info">Permohonan Baru</span>';
    			}elseif($list->status=='2'){
    			    $status= '<span class="badge badge-primary">Reservasi PIN</span>';
    			}elseif($list->status=='3'){
    			    $status= '<span class="badge badge-primary">Proses Penerbitan</span>';
    			}elseif($list->status=='4'){
    			    $status= '<span class="badge badge-success">Tercetak</span>';
    			}elseif($list->status=='5'){
    			    $status= '<span class="badge badge-success">Telah Diambil</span>';
    			}elseif($list->status=='9'){
    			    $status= '<span class="badge badge-danger">Ditunda</span>';
    			}
                
                $no++;
                $row = [];
                if(session()->get('akun_level') == 'Admin'){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ijz.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $status;
                $row[] = tgl_indonesia_short($list->created_at);
                $row[] = tgl_indonesia_short($list->update_at);
                
                
                $row[] = '
                            <a onclick="detail('."'".$link_detail."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                
                if(session()->get('akun_level') == 'Kaprodi' || session()->get('akun_level') == 'Fakultas'){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ijz.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $status;
                $row[] = $list->revisi_skripsi == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','revisi_skripsi'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','revisi_skripsi'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                
                $row[] = '
                            <a onclick="detail('."'".$link_detail."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                
                if(session()->get('akun_level') == 'BAK'){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ijz.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $status;
                $row[] = $list->biaya_kuliah == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_kuliah'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_kuliah'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = $list->biaya_wisuda == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_wisuda'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_wisuda'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = $list->biaya_pengurusan_ijazah == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_pengurusan_ijazah'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','biaya_pengurusan_ijazah'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = $list->waqaf_buku == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','waqaf_buku'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','waqaf_buku'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '
                            <a onclick="detail('."'".$link_detail."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                
                if(session()->get('akun_level') == 'LPJI'){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ijz.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $status;
                $row[] = $list->artikel == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','artikel'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','artikel'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '
                            <a onclick="detail('."'".$link_detail."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                
                if(session()->get('akun_level') == 'Perpustakaan'){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_ijz.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $status;
                $row[] = $list->peminjaman_buku == 1 ? '<a onclick="deactivate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','peminjaman_buku'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_ijz."','".str_replace("'", "`",$list->Nama_Lengkap)."','peminjaman_buku'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '
                            <a onclick="detail('."'".$link_detail."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->ijazah->countAll(),
                'recordsFiltered' => $this->ijazah->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function cekAkun()
    {
        
        $userModel = new \App\Models\UserModel;
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('id')){
                $username = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')])['username'];
                $dt = $userModel->where(['username' => $username])->find();
                if((!empty($dt))){ #memastikan ada data
                    return json_encode(array("status" => true));
                }else{
                    return json_encode(array("status" => false));
                }
            }
        }
    }
    
    
    function cekData()
    {
        
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('id')){
                
                $dt = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
                if((!empty($dt))){ #memastikan ada data
                    return json_encode(array("status" => true));
                }else{
                    return json_encode(array("status" => false));
                }
            }
        }
    }
    
    public function cetak()
    {
        $data['templateJudul'] = "Cetak Persyaratan Pengambilan Ijazah";
        $data['metode']    = 'cetak';
        $id_ijz = $this->request->getvar('id');
        $data['ijazah']         = $this->ijazah->find($id_ijz);
		$data['id_data_diri']      = getDataRow('histori_pddk', ['id_his_pdk' => $data['ijazah']['id_his_pdk']])['id_data_diri'];
		
		$writer = new PngWriter();

        // Create QR code
        $dataQr = base_url('ijazah/cetak?id=').$id_ijz;
        $qrCode = QrCode::create($dataQr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        
        // Create generic logo
        $logo = Logo::create(FCPATH .'assets/logo_iaibafa.png')
            ->setResizeToWidth(70)
            ->setPunchoutBackground(true)
        ;
        
        // Create generic label
        //$label = Label::create('Label')->setTextColor(new Color(255, 0, 0));
        
        //$result = $writer->write($qrCode, $logo, $label);
        $result = $writer->write($qrCode);
       
        $data['qrcode'] = $result->getDataUri();
		
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 2,
                                'margin_right' => 2,
                                'margin_top' => 40,
                                'margin_bottom' => 20,]);
        
        $html = view(session()->get('akun_group_folder')."/$this->halaman_controller/cetak",["data" => $data]);
        $output ="Persyaratan_Pengambilan_Ijazah_".getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap'].".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
        $mpdf->SetFooter('Printed @ {DATE j-m-Y}|{PAGENO}/{nb}|<a href="'.base_url('ijazah/cetak?id=').$id_ijz.'">IAIBAFA</a>');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        $mpdf->WriteHTML($html);
        
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');
        
    }
    
    function tambah_mhs(){
        $data = [];
        
        if($this->request->getVar('kd_kelas')){
			$data = $this->kelas->find($this->request->getVar('kd_kelas'));
		}
        
        $data['templateJudul'] = "Tambah Mahasiswa";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tambah_mhs';
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    private function set_key_data($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->id_his_pdk] = $detail;
        }

        return $return;
    }
    
    function list_data_mhs()
    {
        $historiPddkModel = new \App\Models\HistoriPddkModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            
            $aturan = [
                'tahun_nim' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun NIM!!'
                    ]
                ],
                'prodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih prodi!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data filter!!"));
            }else{
            
                //$lists = dataDinamis('histori_pddk', ['Prodi' => $this->request->getVar('prodi'), 'SUBSTRING(REPLACE(NIM,".",""),-14,2)' => $this->request->getVar('tahun_nim'), 'status' => 'A'], null, null, null, null, null, 'id_his_pdk, id_data_diri, NIM, Prodi, Program, Kelas, status');
                
                $dt_ijz = dataDinamis('tb_ijazah', null, null, null, null, null, null, 'id_his_pdk');
                $dt_his = dataDinamis('histori_pddk', ['Prodi' => $this->request->getVar('prodi'), 'SUBSTRING(REPLACE(NIM,".",""),-14,2)' => $this->request->getVar('tahun_nim'), 'status' => 'A'], null, null, null, null, null, 'id_his_pdk, id_data_diri, NIM, Prodi, Program, Kelas, status');
                if($this->request->getVar('program_kuliah'))
                {
                    $dt_his = dataDinamis('histori_pddk', ['Prodi' => $this->request->getVar('prodi'), 'Program' => $this->request->getVar('program_kuliah'), 'SUBSTRING(REPLACE(NIM,".",""),-14,2)' => $this->request->getVar('tahun_nim'), 'status' => 'A'], null, null, null, null, null, 'id_his_pdk, id_data_diri, NIM, Prodi, Program, Kelas, status');
                }
                $result_dt_ijz = $this->set_key_data($dt_ijz);
                $result_dt_his = $this->set_key_data($dt_his);
    
                foreach ($result_dt_his as $index => $item) {
                    if (isset($result_dt_ijz[$index]))
                        unset($result_dt_his[$index]);
                }
    
                $lists = array_values($result_dt_his);
                
                
                $data = [];
                $no = $this->request->getPost('start');
    
                foreach ($lists as $list) {
                    
                    $no++;
                    $row = [];
                    $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_his_pdk.'" />';
                    $row[] = $no;
                    $row[] = $list->NIM;
                    $row[] = getDataRow('db_data_diri_mahasiswa', ['id' => $list->id_data_diri])['Nama_Lengkap'];
                    $row[] = $list->Prodi;
                    $row[] = $list->Program;
                    $row[] = $list->Kelas;
                    $row[] = getDataRow('db_data_diri_mahasiswa', ['id' => $list->id_data_diri])['th_angkatan'];
                    $row[] = $list->status;
                    $row[] = '
                                <a onclick="simpanMhs('."'".$list->id_his_pdk."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>
                            ';
                    
                    $data[] = $row;
                }
    
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    //'recordsTotal' => $this->ijazah->countAll(),
                    //'recordsFiltered' => $this->ijazah->countFiltered(),
                    'data' => $data
                ];
    
                echo json_encode($output);
            }
        }
    }
    
    function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            $aturan = [
                'tahun_pengajuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun pengajuan!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data filter!!"));
            }else{
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                foreach ($this->request->getVar('id') as $key ) {                
                    
                    $record = [
                            'id_his_pdk' => $key,
                            'tahun' => $this->request->getVar('tahun_pengajuan')
                        ];
                    
                    if($this->ijazah->simpanData($record)){
                                
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $record['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." gagal ditambahkan."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " mahasiswa berhasi ditambahkan, ".$jmlError." gagal ditambahkan.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " mahasiswa berhasil ditambahkan."));
                }  
            }
        }
    }
    
    function simpanMhs()
    {
        if($this->request->getMethod()=="post"){
            $aturan = [
                'tahun_pengajuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun pengajuan!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data filter!!"));
            }else{
                
                $record = [
    				//'id_mhs'=> $get_data['id_mhs'],// Mulai Tahun 2023/2024 Genap tidak Dipakai
        			'id_his_pdk'=> $this->request->getVar('id_his_pdk'),
        			'tahun' => $this->request->getVar('tahun_pengajuan')
                ];
                
                $aksi = $this->ijazah->simpanData($record);
                if($aksi != false){
                    return json_encode(array("msg" => "success", "pesan" => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $record['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." berhasil ditambahkan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $record['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." gagal ditambahkan."));
                };
            }
        }
    }
    
    public function simpanStatus()
    {
        
        if($this->request->getMethod()=="post"){
            
            $aturan = [
                'status_update' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Status wajib diisi!!'
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
            }else{
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('id_ijz') as $key ) {
                    $dt = getDataRow('tb_ijazah', ['id_ijz'=>$key]);
                    $record = [
                        'id_ijz' => $key,
                        'status' => $this->request->getVar('status_update')
                    ];
                    if($this->ijazah->save($record)){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dt['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." gagal diupdate."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " berhasil diupdate, ".$jmlError." gagal diupdate.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " berhasil diupdate."));
                } 
            }
        }
        
    }
    
    function detail()
    {
        $data = [];
        
        if($this->request->getVar('id'))
        {
            $data = $this->ijazah->find($this->request->getVar('id'));
            $data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
        }
        
        if($this->request->getMethod()=="post"){
            
            $record = [
                'id_ijz' => $this->request->getVar('id_ijz'),
                'status' => $this->request->getVar('status'),
                'ket' => $this->request->getVar('ket')
            ];
            $aksi = $this->ijazah->simpanData($record);
            if($aksi){
                return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
            }else{
                return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
            }
        }
        
        $data['templateJudul'] = "Detail";
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
}
