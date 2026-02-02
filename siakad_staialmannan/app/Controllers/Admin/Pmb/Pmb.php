<?php

namespace App\Controllers\Admin\Pmb;

use App\Controllers\BaseController;
use App\Models\PmbModel;
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

class Pmb extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->pmb = new PmbModel($request);
        $this->halaman_controller = "pmb";
        $this->halaman_label = "PMB";
    }
    /*
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->krs->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    $NilaiModel = new \App\Models\NilaiModel($this->request);
                    $cekDataNilai = $NilaiModel->where('id_krs', $this->request->getVar('id'))->findAll();
                    if(!empty($cekDataNilai)){
                        $NilaiModel->where('id_krs', $this->request->getVar('id'))->delete();
                        $aksi = $this->krs->delete($this->request->getVar('id'));
                        if($aksi == true){
                            return json_encode(array("status" => TRUE));
                        }else{
                            return json_encode(array("status" => false));
                        }
                    }else{
                        $aksi = $this->krs->delete($this->request->getVar('id'));
                        if($aksi == true){
                            return json_encode(array("status" => TRUE));
                        }else{
                            return json_encode(array("status" => false));
                        }
                    }
                    
                }
            }
        }
        
        if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){

                $dataKrs = $this->krs->find($this->request->getVar('id'));
                if($dataKrs['id']){ #memastikan ada data
                    $record = [
                        'id' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '1'
                    ];
                    
                    if($this->krs->save($record)){
                        //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }

        if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
            $dataKrs = $this->krs->find($this->request->getVar('id'));
            if($dataKrs['id']){ #memastikan ada data
                $record = [
                    'id' => $this->request->getVar('id'),
                    $this->request->getVar('field') => '0'
                ];
                
                if($this->krs->save($record)){
                    return json_encode(array("status" => TRUE));
                }else{
                    return json_encode(array("status" => false));
                }
            }
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    */
    
    public function calon_mhs()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            $mahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $mahasiswaModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data
                    deleteDataDinamis('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
                    deleteDataDinamis('db_pmb', ['id' => $this->request->getVar('id')]);
                    deleteDataDinamis('db_ortu_mhs', ['id' => $this->request->getVar('id')]);
                    deleteDataDinamis('users', ['username' => $dt['username']]);
                    @unlink('berkas_mahasiswa/'.$dt['Nama_Lengkap'].'/*');
                    
                    return json_encode(array("status" => TRUE));
                    
                }
            }
        }
        
        if($this->request->getVar('aksi')=='validasi' && $this->request->getVar('id')){

            $dataPMB = $this->pmb->find($this->request->getVar('id'));
            if($dataPMB['id']){ #memastikan ada data
                $noPendaftaran = $this->pmb->generateNo($dataPMB['Tahun_Masuk'], $dataPMB['program_sekolah']);
                $record = [
                    'id' => $this->request->getVar('id'),
                    'No_Pendaftaran' => $noPendaftaran,
                    $this->request->getVar('field') => '1'
                ];
                
                if($this->pmb->save($record)){
                    //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                    return json_encode(array("status" => TRUE, "pesan" => "Pembayaran ".getDataRow('db_data_diri_mahasiswa', ['id' => $dataPMB['id']])['Nama_Lengkap']." berhasil divalidasi"));
                }else{
                    return json_encode(array("status" => false));
                }
            }
        }
        
        if($this->request->getVar('aksi')=='unvalidate' && $this->request->getVar('id')){

            $dataPMB = $this->pmb->find($this->request->getVar('id'));
            if($dataPMB['id']){ #memastikan ada data
                $record = [
                    'id' => $this->request->getVar('id'),
                    'No_Pendaftaran' => NULL,
                    $this->request->getVar('field') => '0'
                ];
                
                if($this->pmb->save($record)){

                    return json_encode(array("status" => TRUE, "pesan" => "Validasi pembayaran ".getDataRow('db_data_diri_mahasiswa', ['id' => $dataPMB['id']])['Nama_Lengkap']." telah dibatalkan."));
                }else{
                    return json_encode(array("status" => false));
                }
            }
        }
        
        if($this->request->getVar('aksi')=='aktifkan' && $this->request->getVar('id')){

            $dataPMB = $this->pmb->find($this->request->getVar('id'));
            if($dataPMB['id']){ #memastikan ada data
                $userModel = new \App\Models\UserModel;
                if($dataPMB['Status_Pendaftaran']=="Mahasiswa Baru"){
                    $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $dataPMB['id']]);
                    //$userMaba = getDataRow('app_user_maba', ['id_user' => $dataPMB['id']]);
                    
                    //$username = $userModel->set_username($data_diri['Nama_Lengkap']);
                    if($dataPMB['Kelas_Program_Kuliah']=="Reguler"){
                      $kelas = 'Kelas Siang';
                  }else{
                      $kelas = "Kelas Siang";
                  }

                  if($dataPMB['program_sekolah']=="S2"){
                    $kelas = "S2-Reg";
                }

                $data_his = array(
    								//'id_mhs' => $idmhs,
                    'id_data_diri' => $data_diri['id'],
                    'Program' => $dataPMB['Kelas_Program_Kuliah'] == "Kelas Pegawai" ? "Kelas Karyawan" : $dataPMB['Kelas_Program_Kuliah'],
                    'program_sekolah' => $dataPMB['program_sekolah'],
                    'Prodi' => ($dataPMB['program_sekolah'] == 'S1') ? $dataPMB['Prodi_Pilihan_1'] : $dataPMB['program_sekolah']."-".$dataPMB['Prodi_Pilihan_1'],
                    "Kelas"=> $kelas,
                    'mulai_smt' => $dataPMB['Tahun_Masuk'].'1',
                    'jns_daftar' => '1',
                    'last_modified'=> date('d-m-Y H:i:s')
                );
                $update_data_diri = [
                 'id' => $data_diri['id'],
                                //'username' => $username,//strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap']))),
                 'th_masuk' => $dataPMB['Tahun_Masuk'],
                 'th_angkatan' => $dataPMB['Tahun_Masuk']."/".(intval($dataPMB['Tahun_Masuk'])+1),
                 'kelas' => $kelas,
                 'stat_mhs' => 'A'
             ];
                    /*
    			    $data_users = [
    			                'username' => $username,//strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap']))),
                                'nama_lengkap' => $data_diri['Nama_Lengkap'],
                                'email' => (!empty($userMaba['username']) && $userMaba['username'] != null) ? $userMaba['username']:strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap'])))."@mhs.iaibafa.ac.id",
                                'password_hash' => $userMaba['text_pass'] != null?password_hash($userMaba['text_pass'], PASSWORD_DEFAULT):password_hash('1234567', PASSWORD_DEFAULT),
                                'password_plain' => $userMaba['text_pass'] != null ?$userMaba['text_pass']:'1234567',
                                'foto_profil' => ''
    			        ];
                    */
                 }else{
                     $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $dataPMB['id']]);
                    //$userMaba = getDataRow('app_user_maba', ['id_user' => $dataPMB['id']]);
                    //$username = $userModel->set_username($data_diri['Nama_Lengkap']);
                     if($dataPMB['Kelas_Program_Kuliah']=="Reguler"){
                      $kelas = $data_diri['Jenis_Kelamin']=='L'?'PA':'PI';
                  }else{
                      $kelas = "Kelas Siang";
                  }

                  if($dataPMB['program_sekolah']=="S2"){
                    $kelas = "S2-Reg";
                }

                $data_his = array(
                 'id_data_diri' => $data_diri['id'],
                 'Program' => $dataPMB['Kelas_Program_Kuliah'] == "Kelas Pegawai" ? "Kelas Karyawan" : $dataPMB['Kelas_Program_Kuliah'],
                 'program_sekolah' => $dataPMB['program_sekolah'],
                 'Prodi' => ($dataPMB['program_sekolah'] == 'S1') ? $dataPMB['Prodi_Pilihan_1'] : $dataPMB['program_sekolah']."-".$dataPMB['Prodi_Pilihan_1'],
                 "Kelas"=> $kelas,
                 'mulai_smt' => $dataPMB['Tahun_Masuk'].'1',
                 'jns_daftar' => '2',
                 'last_modified'=> date('d-m-Y H:i:s'),
                 'sks_diakui' => $dataPMB['Jml_SKS_Asal'],
                 'nm_pt_asal' => $dataPMB['PT_Asal'],
                 'nm_prodi_asal' => $dataPMB['Prodi_Asal']
             );
                $update_data_diri = [
                 'id' => $data_diri['id'],
                                //'username' => $username,//strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap']))),
                 'th_masuk' => $dataPMB['Tahun_Masuk'],
                 'th_angkatan' => $dataPMB['Tahun_Masuk']."/".(intval($dataPMB['Tahun_Masuk'])+1),
                 'kelas' => $kelas,
                 'stat_mhs' => 'A'
             ];
                    /*
    			    $data_users = [
    			                'username' => $username,//strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap']))),
                                'nama_lengkap' => $data_diri['Nama_Lengkap'],
                                'email' => (!empty($userMaba['username']) && $userMaba['username'] != null) ? $userMaba['username']:strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $data_diri['Nama_Lengkap'])))."@mhs.iaibafa.ac.id",
                                'password_hash' => (!empty($userMaba['text_pass']) && $userMaba['text_pass'] != null)?password_hash($userMaba['text_pass'], PASSWORD_DEFAULT):password_hash('1234567', PASSWORD_DEFAULT),
                                'password_plain' => (!empty($userMaba['text_pass']) && $userMaba['text_pass'] != null) ?$userMaba['text_pass']:'1234567',
                                'foto_profil' => ''
    			        ];
                    */
                 }

                /*
                $userModel = new \App\Models\UserModel;
                if($userModel->save($data_users)){
                    $userGroup = [
                        'group_id' => 3,
                        'user_id' => $userModel->getInsertID()
                    ];
                    setUserGroup($userGroup);
                */    
                    $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
                    if($MahasiswaModel->save($update_data_diri)){
                        $HistoriPddkModel = new \App\Models\HistoriPddkModel($this->request);
                        if($HistoriPddkModel->simpanData($data_his)){
                            $userGroup = [
                                'group_id' => 3,
                                'user_id' => getDataRow('users', ['username' => $data_diri['username']])['id']//$userModel->getInsertID()
                            ];
                            setUserGroup($userGroup);
                            deleteDataDinamis('auth_groups_users', ['group_id' => '99', 'user_id' => getDataRow('users', ['username' => $data_diri['username']])['id']]);
                            return json_encode(array("status"=>true, "msg" => "success", "pesan" => $data_diri['Nama_Lengkap']." berhasil diaktifkan."));
                        }else{
                            return json_encode(array("status"=>false, "msg" => "info", "pesan" => "Data diri ".$data_diri['Nama_Lengkap']." terupdate, tetapi belum masuk ke data histori pendidikan."));
                        }
                        
                    }else{
                       return json_encode(array("status"=>false, "msg" => "error", "pesan" => $data_diri['Nama_Lengkap']." gagal diaktifkan."));
                   }
                /*
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => $data_diri['Nama_Lengkap']." gagal diaktifkan."));
                }
                */
            }
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'calon_mhs';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->pmb->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {


                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->No_Pendaftaran;
                $row[] = $list->Status_Pendaftaran;
                $row[] = $list->tgl_daftar;
                $row[] = $list->program_sekolah;
                $row[] = $list->Kelas_Program_Kuliah;
                $row[] = $list->Prodi_Pilihan_1;
                //$row[] = $list->tgl_tes==''?'<span class="badge badge-danger">Belum Tes</span>':'<span  class="badge badge-success">'.$list->tgl_tes.'</span>';;
                $row[] = $list->Bukti_Biaya_Daftar==''?'<span class="badge badge-danger">'.number_format($list->Biaya_Pendaftaran,0,',','.').'</span>':'<a href=javascript:void(0)" onclick="showModal('."'"."http://akademik.iaibafa.ac.id/pendaftaran/bukti_bayar/".$list->Bukti_Biaya_Daftar."'".')" role="button" class="btn btn-sm btn-success">'.number_format($list->Biaya_Pendaftaran,0,',','.').'</a>';
                $row[] = $list->status_valid=='1'?'<a href="javascript:void(0)" title="Klik Untuk Membatalkan Verifikasi" data-placement="bottom" role="button" class="btn btn-xs btn-success" onclick="actionChange('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."','status_valid','unvalidate'".')"> Sudah Bayar </a>':'<a href="javascript:void(0)" title="Klik Untuk Verifikasi" data-placement="bottom" role="button" class="btn btn-xs btn-danger" onclick="actionChange('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."','status_valid','validasi'".')"> Belum Bayar </a>';
                $row[] = (!empty($list->Foto_Diri)) ? '<img src="'.base_url($list->Foto_Diri).'"  class="profile-user-img img-fluid img-circle">':'<img src="'.base_url().'/assets/no-pict.jpg'.'"  class="profile-user-img img-fluid img-circle">';
                $row[] = (!empty($list->reff))?getDataRow('pmb_affiliate', ['kode_referrer' => $list->reff])['nama_referrer']:'';
                $row[] = (!empty($list->stat_mhs))?'<span class="badge badge-success">Sudah Diaktivasi</span>':'<span class="badge badge-danger">Belum Diaktivasi</span>';
                if(session()->get('akun_level') == 'Admin' || session()->get('akun_level') == 'Panitia PMB'){
                    $row[] = '<!--<a onclick="hapus('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></a>
                    <a onclick="detail('."'".$list->id."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                    <a onclick="aktifkan('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Aktifkan sebagai mahasiswa aktif"><i class="fa fa-check"></i></a> 
                    -->
                    <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="'.base_url("pmb/detail?id=$list->id").'" target="_blank">Detail</a>
                    <!--<a class="dropdown-item" onclick="detail('."'".$list->id."'".'); return false;">Detail</a>-->
                    <a class="dropdown-item" onclick="cetak_formulir('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;">Cetak Formulir</a>
                    <a class="dropdown-item" onclick="aktifkan('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;">Aktifkan</a>
                    <a class="dropdown-item" onclick="cetak_akun('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;">Cetak Kartu Akun</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" onclick="hapus('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;">Hapus</a>
                    </div>

                    ';
                }
                if(session()->get('akun_level') == 'BAK'){
                    $row[] = '<!--<a onclick="hapus('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></a>
                    <a onclick="detail('."'".$list->id."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                    <a onclick="aktifkan('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Aktifkan sebagai mahasiswa aktif"><i class="fa fa-check"></i></a> 
                    -->
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" onclick="cetak_formulir('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;">Cetak Formulir</a>
                    </div>

                    ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->pmb->countAll(),
                'recordsFiltered' => $this->pmb->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    private function _get_datatables_query()
    {
        $this->builder = $this->db->table($this->table);
    
        // filter & join kalau ada
        // $this->builder->join(...);
    
        // ✅ ORDERING
        if (isset($_POST['order'])) {
            $col_index = $_POST['order'][0]['column'];
            $dir = $_POST['order'][0]['dir'];
            if (isset($this->column_order[$col_index]) && $this->column_order[$col_index] != null) {
                $this->builder->orderBy($this->column_order[$col_index], $dir);
            }
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }
    
    public function getDatatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        return $this->builder->get()->getResult();
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
    
    public function cetak_akun()
    {

        $username = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')])['username'];
        
        //
        $data['username'] = $username;
        $data['templateJudul'] = "Cetak Akun ".getDataRow('users', ['username'=>$username])['nama_lengkap'];
        $data['metode']    = 'cetak_akun';
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 10,]);
        
        $html = view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $output ="Kartu_Akun_".getDataRow('users', ['username'=>$username])['nama_lengkap'].".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div class='center'>".base_url("$this->halaman_controller/cetak_akun?id=").$this->request->getVar('id')."</div>");
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');

        //return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
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
    
    public function cetak_formulir()
    {

        $data['diri'] = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
        $data['ortu'] = getDataRow('db_ortu_mhs', ['id' => $this->request->getVar('id')]);
        $data['pmb'] = getDataRow('db_pmb', ['id' => $this->request->getVar('id')]);
        
        //
        
        $data['templateJudul'] = "Cetak Formulir ".$data['diri']['Nama_Lengkap'];
        if($data['pmb']['program_sekolah'] == 'S1'){
            $data['metode']    = 'cetak_formulir';
        }
        if($data['pmb']['program_sekolah'] == 'S2'){
            $data['metode']    = 'cetak_formulir_s2';
        }
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 10,]);
        //return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'],["data" => $data]);
        
        $html = view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $output ="Formulir_".$data['diri']['Nama_Lengkap'].".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div class='center'>".base_url("$this->halaman_controller/cetak_formulir?id=").$this->request->getVar('id')."</div>");
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        try{
            $mpdf->WriteHTML($html);
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($output,'I');
        }catch(\Mpdf\MpdfException $e){
            echo "MPDF Error : ".$e->getMessage();
        }
        
        //return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function rekap_maba()
    {
        $data = [];

		//dd($data['verifikasi']);
        $data['templateJudul'] = "Rekap Calon Mahasiswa Baru";
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'rekap_maba';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }

    function getRekap()
    {
        $db      = \Config\Database::connect();
        
        $data = [];
        $th_pendaftaran = $this->request->getVar('tahun');
        //$tahun_pendaftaran = getDataRow('setting_gelombang', ['Aktif' => '1'], null, 'LEFT(Tahun_Akademik,4) as ta');
        $data['ta'] = $th_pendaftaran;
        $data['jenjPddk'] = dataDinamis('db_pmb', ['Tahun_Masuk' => $th_pendaftaran], 'program_sekolah ASC', 'program_sekolah', null, null, null, 'program_sekolah');
        $data['statusValid'] = dataDinamis('db_pmb', ['Tahun_Masuk' => $th_pendaftaran], 'status_valid ASC', 'status_valid', null, null, null, 'status_valid');
        $data['progKelas'] = dataDinamis('ref_option', ['opt_group' =>'program_kuliah'], 'opt_id ASC');
        $data['prodi'] = dataDinamis('prodi', null, 'urutan ASC');
        $data['verifikasi'] = $db->query("SELECT
           IFNULL(status_valid,'TOTAL') AS valid,
           Count(db_pmb.status_valid) AS JML
           FROM
           db_pmb
           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.status_valid
           WITH ROLLUP");
        $data['program'] = $db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS prog,
           Count(db_pmb.Kelas_Program_Kuliah) AS jml,
           Count(IF(db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) AS valid,
           Count(IF(db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) AS tidak_valid
           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP
           ");
        $data['hki']            =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='HKI',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='HKI' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='HKI' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['es']         =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='ES',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='ES' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='ES' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['pba']            =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='PBA',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='PBA' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='PBA' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['mpi']            =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='MPI',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='MPI' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='MPI' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['pgmi']           =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='PGMI',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='PGMI' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='PGMI' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['iat']            =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='IAT',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='IAT' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='IAT' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['ilha']           =$db->query("SELECT
           IFNULL(Kelas_Program_Kuliah,'TOTAL') AS kls,
           Count(IF(Prodi_Pilihan_1='ILHA',Kelas_Program_Kuliah,null)) AS jml,
           COUNT(IF(Prodi_Pilihan_1='ILHA' AND db_pmb.status_valid='1',Kelas_Program_Kuliah,null)) as v,
           COUNT(IF(Prodi_Pilihan_1='ILHA' AND db_pmb.status_valid='0',Kelas_Program_Kuliah,null)) as n

           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S1'
           GROUP BY
           db_pmb.Kelas_Program_Kuliah
           WITH ROLLUP");
        $data['verifikasi_s2'] = $db->query("SELECT
           IFNULL(status_valid,'TOTAL') AS valid,
           Count(db_pmb.status_valid) AS JML
           FROM
           db_pmb
           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S2'
           GROUP BY
           db_pmb.status_valid
           WITH ROLLUP");
        $data['prodi_s2'] = $db->query("SELECT
           IFNULL(Prodi_Pilihan_1,'TOTAL') AS prodi,
           Count(db_pmb.Prodi_Pilihan_1) AS jml,
           Count(IF(db_pmb.status_valid='1',Prodi_Pilihan_1,null)) AS valid,
           Count(IF(db_pmb.status_valid='0',Prodi_Pilihan_1,null)) AS tidak_valid
           FROM
           db_pmb

           where
           db_pmb.Tahun_Masuk =".$th_pendaftaran." AND db_pmb.program_sekolah = 'S2'
           GROUP BY
           db_pmb.Prodi_Pilihan_1
           WITH ROLLUP
           ");

        return view(session()->get('akun_group_folder')."/$this->halaman_controller/konten_rekap", $data);
    }
    
    public function ekspor()
    {

        $list_id = $this->request->getVar('id');
        $data 				= [];
        foreach ($list_id as $id ) {
          $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $id]);
          $data_pmb = getDataRow('db_pmb', ['id' => $id]);
          array_push($data, array(
            'Nama' => $data_diri['Nama_Lengkap'],
            'Jns_Kelamin' => $data_diri['Jenis_Kelamin'],
            'No_Daftar' => $data_pmb['No_Pendaftaran'],
            'Program' => $data_pmb['Kelas_Program_Kuliah'],
            'Prodi' => $data_pmb['Prodi_Pilihan_1'],
            'Domisili' => $data_diri['Tempat_Domisili'],
            'Asal_Sekolah' => $data_diri['Nama_Lengkap_SLTA_Asal'],
            'No_HP' => $data_diri['No_HP'],
            'Biaya' => $data_pmb['Biaya_Pendaftaran'],
            'status_bayar' => $data_pmb['status_valid'],
            'reff' => $data_pmb['reff'],
            'alamat' => "RT. ".$data_diri['RT']." RW. ".$data_diri['RW']." Dsn. ".ucwords(strtolower($data_diri['Dusun']))." Ds. ".ucwords(strtolower($data_diri['Desa']))." Kec. ".ucwords(strtolower($data_diri['Kec']))." Kab. ".ucwords(strtolower($data_diri['Kab']))." Prop. ".ucwords(strtolower($data_diri['Prov']))." Kodepos ".$data_diri['Kode_Pos']
        ));

      }


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

        $sheet->setCellValue('A1', "Data Calon Mahasiswa Baru Tahun ". $this->request->getVar('th_masuk') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'Nama ');
        $sheet->setCellValue('C3', 'Jns Kelamin');
        $sheet->setCellValue('D3', 'Program');
        $sheet->setCellValue('E3', 'Prodi');
        $sheet->setCellValue('F3', 'Pondok');
        $sheet->setCellValue('G3', 'Sekolah Asal');
        $sheet->setCellValue('H3', 'No HP');
        $sheet->setCellValue('I3', 'Biaya Pendaftaran');
        $sheet->setCellValue('J3', 'Status Pembayaran');
        $sheet->setCellValue('K3', 'Referal');
        $sheet->setCellValue('L3', 'Alamat');
        $sheet->setCellValue('M3', 'No. Pendaftaran');

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
        
        $sheet->getStyle('A3:M3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa


          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $val['Nama']);
          $sheet->setCellValue('C'.$numrow, $val['Jns_Kelamin']);
          $sheet->setCellValue('D'.$numrow, $val['Program']);
          $sheet->setCellValue('E'.$numrow, $val['Prodi']);
          $sheet->setCellValue('F'.$numrow, $val['Domisili']);
          $sheet->setCellValue('G'.$numrow, $val['Asal_Sekolah']);
          $sheet->setCellValue('H'.$numrow, $val['No_HP']);
          $sheet->setCellValue('I'.$numrow, $val['Biaya']);
          $sheet->setCellValue('J'.$numrow, ($val['status_bayar'] == '1')?'Sudah Bayar':'Belum Bayar');
          $sheet->setCellValue('K'.$numrow, (!empty($val['reff']))?getDataRow('pmb_affiliate', ['kode_referrer' => $val['reff']])['nama_referrer']:'');
          $sheet->setCellValue('L'.$numrow, $val['alamat']);
          $sheet->setCellValue('M'.$numrow, $val['No_Daftar']);
          
          
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
    $sheet->setTitle("Calon Mahasiswa Baru ");
    $sheet->getStyle('A:AU')->getNumberFormat()->setFormatCode('@');
    $writer = new Xlsx($spreadsheet);
    $filename = date('Y-m-d-His'). '-Data-Calon-Mahasiswa-Tahun-'.$this->request->getVar('th_masuk');
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
    /*
    function detail()
    {
        $data = [];
        
        if($this->request->getVar('id'))
        {
            $data['pmb'] = $this->pmb->find($this->request->getVar('id'));
            $data['diri'] = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
            $data['ortu'] = getDataRow('db_ortu_mhs', ['id' => $this->request->getVar('id')]);
        }
        $data['templateJudul'] = "Detail Calon Mahasiswa";
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    */
    
    function detail()
    {
        $data = [];
        
        if($this->request->getVar('id'))
        {

            $data['data_diri'] = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
            $data['ortu'] = getDataRow('db_ortu_mhs', ['id' => $this->request->getVar('id')]);
            $data['pmb'] = getDataRow('db_pmb', ['id' => $this->request->getVar('id')]);
        }
        $data['templateJudul'] = "Detail Calon Mahasiswa";
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        $data['aktif_menu'] = $this->halaman_controller."/calon_mhs";
        if($data['pmb']['program_sekolah'] == 'S1'){
            return view('pendaftaran/dashboard_camaba', $data);
        }
        if($data['pmb']['program_sekolah'] == 'S2'){
            return view('pendaftaran/dashboard_camaba_s2', $data);
        }
    }
    
    function setting_pmb()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            $settingModel = new \App\Models\SettingPmbModel($this->request);
            
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $settingModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data

                    $aksi = $settingModel->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){

                $dt = $settingModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data
                    $record = [
                        'id_gel' => $dt['id_gel'],
                        'Aktif' => '1'
                    ];
                    if($settingModel->save($record)){

                        return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Periode pendaftaran berhasil diaktifkan."));

                    }else{
                        return json_encode(array("status"=>false, "msg" => "error", "pesan" => "eriode pendaftaran gagal diaktifkan."));
                    }
                    
                }
            }
            
            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){

                $dt = $settingModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data
                    $record = [
                        'id_gel' => $dt['id_gel'],
                        'Aktif' => '0'
                    ];
                    if($settingModel->save($record)){

                        return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Periode pendaftaran berhasil dinon-aktifkan."));

                    }else{
                        return json_encode(array("status"=>false, "msg" => "error", "pesan" => "eriode pendaftaran gagal dinon-aktifkan."));
                    }
                    
                }
            }
        }
        


        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'setting_pmb';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxListSetting()
    {
        $settingModel = new \App\Models\SettingPmbModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $settingModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {


                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_gel.'" />';
                $row[] = $no;
                $row[] = $list->Tahun_Akademik;
                $row[] = $list->jenjang;
                $row[] = $list->Nama_Gelombang;
                $row[] = $list->Tgl_Mulai;
                $row[] = $list->Tgl_Akhir;
                $row[] = $list->biaya;
                $row[] = $list->Aktif == 1 ? '<a onclick="deactivate('."'".$list->id_gel."'".'); return false;" role="button" data-placement="top" title="Klik untuk menonaktifkan"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id_gel."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengaktifkan"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '<a onclick="hapus('."'".$list->id_gel."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                <a onclick="edit('."'".$list->id_gel."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> 
                ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $settingModel->countAll(),
                'recordsFiltered' => $settingModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function tambahPeriodePendaftaran()
    {
        $data = [];
        
        $settingModel = new \App\Models\SettingPmbModel($this->request);
        
        if($this->request->getVar('id_gel')){
            $data = $settingModel->find($this->request->getVar('id_gel'));
        }


        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'tambahPeriodePendaftaran';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function simpanSettingPmb()
    {
        $settingModel = new \App\Models\SettingPmbModel($this->request);
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id_gel'))){
                $aturan = [
                    'Tahun_Akademik' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib Diisi!!'
                        ]
                    ],
                    'jenjang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Nama_Periode' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Nama_Gelombang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Tgl_Mulai' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Tgl_Akhir' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ]
                ];
                
                if(!$this->validate($aturan)){
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
                }else{

                    $record = [
                        'Tahun_Akademik' => $this->request->getVar('Tahun_Akademik'),
                        'tahun'     => substr($this->request->getVar('Tahun_Akademik'), 0, 4),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'Nama_Periode' => $this->request->getVar('Nama_Periode'),
                        'Nama_Gelombang' => $this->request->getVar('Nama_Gelombang'),
                        'Tgl_Mulai' => $this->request->getVar('Tgl_Mulai'),
                        'Tgl_Akhir' => $this->request->getVar('Tgl_Akhir'),
                        'biaya' => $this->request->getVar('biaya'),
                        'Aktif' => $this->request->getVar('Aktif'),
                        'info_pendaftaran' => $this->request->getVar('info_pendaftaran'),
                        'info_biaya_kuliah' => $this->request->getVar('info_biaya_kuliah'),
                        'persyaratan' => $this->request->getVar('persyaratan'),
                        'contact_person' => $this->request->getVar('contact_person'),
                    ];
                    
                    //$aksi = $model->simpanData($record);
                    if($settingModel->simpanData($record)){
                        return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));

                    }

                }
            }else{
                $dataSetting = $settingModel->find($this->request->getVar('id_gel'));// ambil data
                
                $aturan = [
                    'Tahun_Akademik' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib Diisi!!'
                        ]
                    ],
                    'jenjang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Nama_Periode' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Nama_Gelombang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Tgl_Mulai' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'Tgl_Akhir' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ]
                ];

                if(!$this->validate($aturan)){

                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
                    
                }else{

                    $record = [
                        'id_gel' => $dataSetting['id_gel'],
                        'Tahun_Akademik' => $this->request->getVar('Tahun_Akademik'),
                        'tahun'     => substr($this->request->getVar('Tahun_Akademik'), 0, 4),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'Nama_Periode' => $this->request->getVar('Nama_Periode'),
                        'Nama_Gelombang' => $this->request->getVar('Nama_Gelombang'),
                        'Tgl_Mulai' => $this->request->getVar('Tgl_Mulai'),
                        'Tgl_Akhir' => $this->request->getVar('Tgl_Akhir'),
                        'biaya' => $this->request->getVar('biaya'),
                        'Aktif' => $this->request->getVar('Aktif'),
                        'info_pendaftaran' => $this->request->getVar('info_pendaftaran'),
                        'info_biaya_kuliah' => $this->request->getVar('info_biaya_kuliah'),
                        'persyaratan' => $this->request->getVar('persyaratan'),
                        'contact_person' => $this->request->getVar('contact_person'),
                    ];
                    //dd($record);
                    //$aksi = $model->simpanData($record);
                    if($settingModel->save($record)){

                        return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));

                    }

                }
            }
            
            
        }
        
    }
    
    public function getDataSetting()
    {
        $settingModel = new \App\Models\SettingPmbModel($this->request);
        $data = $settingModel->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    function affiliate()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            $affiliateModel = new \App\Models\AffiliateModel($this->request);
            
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $affiliateModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data

                    $aksi = $affiliateModel->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
            
        }
        


        $data['templateJudul'] = "Referral ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'affiliate';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxListReferral()
    {
        $affiliateModel = new \App\Models\AffiliateModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $affiliateModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {


                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = $list->kode_referrer;
                $row[] = ($list->tipe_affiliasi == 1) ? 'Dosen' : (($list->tipe_affiliasi == 2)? 'Mahasiswa': (($list->tipe_affiliasi == 3) ? 'Calon Mahasiswa' : 'Eksternal'));
                $row[] = $list->nama_referrer;
                $row[] = $list->link_referral;
                $row[] = '';
                $row[] = '<a onclick="hapus('."'".$list->id."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>

                ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $affiliateModel->countAll(),
                'recordsFiltered' => $affiliateModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function simpanAffiliator()
    {
        $affiliateModel = new \App\Models\AffiliateModel($this->request);
        if($this->request->getMethod()=="post"){

            $aturan = [
                'nama_referrer' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib Diisi!!'
                    ]
                ]
            ];

            if(!$this->validate($aturan)){
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
            }else{
                $kode_referral = random_string('alnum',5);
                $record = [
                    'nama_referrer' => $this->request->getVar('nama_referrer'),
                    'tipe_affiliasi' => '4',
                    'kode_referrer' => $kode_referral,
                    'link_referral' => base_url()."/pendaftaran?kode_referral=".$kode_referral
                ];

                    //$aksi = $model->simpanData($record);
                if($affiliateModel->save($record)){
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));

                }

            }
            
        }
        
    }
    
    function generateReferal()
    {
        $affiliateModel = new \App\Models\AffiliateModel($this->request);
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('tipe_affiliasi')=='1'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('id_referrer') as $key ) {  

                    $kode_referral = random_string('alnum',5);
                    $record = [
                        'tipe_affiliasi' => '1',
                        'kode_referrer' => $kode_referral,
                        'id_referrer' => $key,
                        'nama_referrer' => getDataRow('data_dosen', ['id_dosen' => $key])['Nama_Dosen'],
                        'link_referral' => base_url()."/pendaftaran?kode_referral=".$kode_referral
                    ];
                    //$aksi = setDataDinamis('absensi_uts', $record);
                    if($affiliateModel->save($record)){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('data_dosen', ['id_dosen' => $key])['Nama_Dosen']." gagal."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " berhasil, ".$jmlError." gagal.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " berhasil."));
                }  
            }
            
            if($this->request->getVar('tipe_affiliasi')=='2'){
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                foreach ($this->request->getVar('id_referrer') as $key ) {  
                    $historiPdkAktif = getDataRow('histori_pddk', ['id_data_diri' => $key, 'jns_keluar' => NULL, 'status' => 'A']);
                    $kode_referral = random_string('alnum',5);
                    $record = [
                        'tipe_affiliasi' => '2',
                        'kode_referrer' => $kode_referral,
                        'id_referrer' => $key,
                        'nama_referrer' => getDataRow('db_data_diri_mahasiswa', ['id' => $key])['Nama_Lengkap'],
                        'prodi' => (!empty($historiPdkAktif))?$historiPdkAktif['Prodi']:'',
                        'link_referral' => base_url()."/pendaftaran?kode_referral=".$kode_referral
                    ];
                    //$aksi = setDataDinamis('absensi_uts', $record);
                    if($affiliateModel->save($record)){
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => $key])['Nama_Lengkap']." gagal."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " berhasil, ".$jmlError." gagal.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " berhasil."));
                }  
            }
        }
    }
    
    public function infografis()
    {


        $data = [];
        
        $data['templateJudul'] = "Infografis / Brosur".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'infografis';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }

    function ajaxListInfografis()
    {

        $datatable = new \App\Models\InfografisModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->slider_title;
                $row[] = $list->slider_subtitle;
                $row[] = '
                <div class="position-relative">
                <img src="'.base_url().'/'.$list->slider_img.'" class="profile-user-img img-fluid img-circle" />
                </div>
                ';
                $row[] = $list->is_aktif=='Y'?'<span class="badge badge-success">Aktif</span>':'<span class="badge badge-error">Tidak Aktif</span>';
                $row[] = '<a onclick="hapus('."'".$list->id."'".')" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                <a role="button" href="javascript:void(0)" onclick="edit('."'".$list->id."'".')" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function tambahInfografis()
    {

        $model = new \App\Models\InfografisModel($this->request);
        
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id'))){
                $aturan = [
                    'slider_title' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Title slider harus diisi'
                        ]
                    ],
                    'slider_subtitle' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Subtitle slider harus diisi'
                        ]
                    ],
                    'slider_img' => [
                        'rules' => 'uploaded[slider_img]|is_image[slider_img]|mime_in[slider_img,image/jpg,image/jpeg,image/png]',
                        'errors' => [
                            'uploaded' => 'Pilih gambar yang akan diupload',
                            'is_image' => 'Yang Anda upload bukan gambar',
                            'mime_in' => 'Ekstensi file yang anda upload tidak diijinkan. Upload gambar dengan ekstensi jpg | jpeg | png'
                        ]
                    ],
                    'is_aktif' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih aktif atau tidak'
                        ]
                    ]
                ];
                
                $file = $this->request->getFile('slider_img');

                if(!$this->validate($aturan)){

                    echo json_encode(array("msg" => "invalid", "validation" => $this->validation->getErrors()));
                    
                }else{
                    if($file->getName()){
                        $nm_foto = $file->getRandomName();
                        $path = 'upload/'.$this->halaman_controller.'/infografis';
                        $foto = $path.'/'.$nm_foto;
                        $file->move($path, $nm_foto);
                    }
                    
                    
                    $record = [
                        'jenjang' => $this->request->getVar('jenjang'),
                        'slider_title' => $this->request->getVar('slider_title'),
                        'slider_subtitle' => $this->request->getVar('slider_subtitle'),
                        'slider_description' => $this->request->getVar('slider_description'),
                        'slider_btntext' => $this->request->getVar('slider_btntext'),
                        'slider_link' => $this->request->getVar('slider_link'),
                        'is_aktif' => $this->request->getVar('is_aktif'),
                        'slider_img' => $foto
                    ];
                    //dd($record);
                    $aksi = $model->simpanData($record);
                    if($aksi){

                        echo json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
                        
                    }else{
                        echo json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));

                    }

                }
            }else{
                $dataSlider = $model->getData($this->request->getVar('id'));// ambil data
                
                $aturan = [
                    'slider_title' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Title slider harus diisi'
                        ]
                    ],
                    'slider_subtitle' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Subtitle slider harus diisi'
                        ]
                    ],
                    'is_aktif' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih aktif atau tidak'
                        ]
                    ]
                ];

                $file = $this->request->getFile('slider_img');

                if(!$this->validate($aturan)){

                    echo json_encode(array("msg" => "invalid", "validation" => $this->validation->getErrors()));
                    
                }else{
                    $foto = $dataSlider['slider_img'];
                    if($file->getName()){
                        $nm_foto = $file->getRandomName();
                        $path = 'upload/'.$this->halaman_controller;
                        $foto = $path.'/'.$nm_foto;
                        $file->move($path, $nm_foto);
                        @unlink($dataSlider['slider_img']);
                    }
                    
                    
                    $record = [
                        'id' => $dataSlider['id'],
                        'jenjang' => $this->request->getVar('jenjang'),
                        'slider_title' => $this->request->getVar('slider_title'),
                        'slider_subtitle' => $this->request->getVar('slider_subtitle'),
                        'slider_description' => $this->request->getVar('slider_description'),
                        'slider_btntext' => $this->request->getVar('slider_btntext'),
                        'slider_link' => $this->request->getVar('slider_link'),
                        'is_aktif' => $this->request->getVar('is_aktif'),
                        'slider_img' => $foto
                    ];
                    //dd($record);
                    $aksi = $model->simpanData($record);
                    if($aksi){

                        echo json_encode(array("msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        echo json_encode(array("msg" => "error", "pesan" => "Data gagal diupdate."));

                    }

                }
            }
            
            
        }
        
    }

    public function getDataInfografis()
    {

        $model = new \App\Models\InfografisModel($this->request);
        
        $dataSlider = $model->getData($this->request->getVar('id'));

        if(empty($dataSlider)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $dataSlider));
        }
        
    }

    function hapusInfografis()
    {

        $model = new \App\Models\InfografisModel($this->request);
        if ($this->request->getMethod(true)=='POST') {
            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dataSlider = $model->getData($this->request->getVar('id'));
                //dd($dataKelas);
                if ($dataSlider['id']) { #memastikan ada data

                    $aksi = $model->hapus($this->request->getVar('id'));
                    //dd($aksi);
                    if ($aksi == true) {
                        //session()->setFlashdata('success', 'Data telah dihapus');
                        return json_encode(array("status" => TRUE));
                    } else {
                        //session()->setFlashdata('warning', 'Data gagal dihapus');
                        return json_encode(array("status" => false));
                    }
                }
                //return redirect()->to("admin/" . $this->halaman_controller);
            }
        }
    }
    
    public function grafik()
    {

        $data = [];
        
        $data['grafikS1'] = $this->pmb->grafikS1();
        //$data['grafikS2'] = $this->pmb->grafikS2();
        $data['grafikVerifiedS1'] = $this->pmb->grafikVerifiedS1();
        //$data['grafikVerifiedS2'] = $this->pmb->grafikVerifiedS2();
        $data['grafikProdiS1'] = $this->pmb->grafikProdiS1();

        //dd($data['grafikS1']);
        $data['templateJudul'] = "Grafik ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'grafik';
        $data['aktif_menu'] = $this->halaman_controller."/".$data['metode'];
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
}