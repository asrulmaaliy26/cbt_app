<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\KelulusanModel;
use Config\Services;

class Kelulusan extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->kelulusan = new KelulusanModel($request);
        $this->halaman_controller = "kelulusan";
        $this->halaman_label = "Kelulusan / DO";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->mahasiswa->find($this->request->getVar('id'));
                if($dt['id_dosen']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->mahasiswa->delete($this->request->getVar('id'));
                    if($aksi == true){
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
            $lists = $this->kelulusan->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            //$taAktif = intval(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']);
            foreach ($lists as $list) {
                $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $list->id_data_diri]);
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;
                $link_detail = site_url("profil/mahasiswa")."?id=".$list->id_data_diri;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_his_pdk.'" />';
                $row[] = $no;
                $row[] = $list->NIM;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi." - ".$list->Program;
                $row[] = $list->th_angkatan;
                $row[] = (!empty($list->jns_keluar))?getDataRow('ref_option', ['opt_group' => 'jns_keluar', 'opt_id' => $list->jns_keluar])['opt_val']:'';
                $row[] = $list->tgl_keluar;
                $row[] = (!empty($list->keluar_smt))?getDataRow('tahun_akademik', ['kode' => $list->keluar_smt])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $list->keluar_smt])['semester']=='1'?"Gasal":"Genap"):'';
                //$row[] = (!empty($list->status))?getDataRow('ref_option', ['opt_group' => 'status_mhs', 'opt_id' => $list->status])['opt_val']:"-";
                $row[] = $list->ket;
                $row[] = '
                <a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Profil"><i class="fa fa-eye"></i></a>
                    <a onclick="edit_his_pdk('."'".$list->id_his_pdk."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->kelulusan->countAll(),
                'recordsFiltered' => $this->kelulusan->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    /*
    public function getData()
    {
        
        $data = $this->mahasiswa->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    */
    public function getDataHisPdk()
    {
        $HistoriModel = new \App\Models\HistoriPddkModel($this->request);
		$data = $HistoriModel->find($this->request->getVar('id_his_pdk'));
		
        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function formulir()
    {
        $data = [];
        
        
        $data['templateJudul'] = "Formulir Kelulusan / DO";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'formulir';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function simpanKelulusan()
    {
        
        if($this->request->getMethod()=="post"){
            
            $aturan = [
                'keluar_smt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun keluar!!'
                    ]
                ],
                'jns_keluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih Jenis Keluar!!'
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih status mahasiswa!!'
                    ]
                ],
                'tgl_keluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Tgl Keluar wajib diisi!!'
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            }else{
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                
                
                foreach ($this->request->getVar('id_his_pdk') as $key ) {                
                    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk'=>$key])['id_data_diri'];
                    $record = [
                        'id_his_pdk' => $key,
                        'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                        'sk_yudisium' => $this->request->getVar('no_sk_yudisium'),
                        'tgl_sk_yudisium' => $this->request->getVar('tgl_yudisium'),
                        'jns_keluar' => $this->request->getVar('jns_keluar'),
                        'keluar_smt' => $this->request->getVar('keluar_smt'),
                        'status' => $this->request->getVar('status'),
                        'ket' => $this->request->getVar('ket')
                    ];
                    if($this->kelulusan->save($record)){
                        if($this->request->getVar('status') == 'D' || $this->request->getVar('status') == 'K' || $this->request->getVar('status') == 'L'){
                            updateDataDinamis('db_data_diri_mahasiswa', ['stat_mhs' => $this->request->getVar('status')], ['id' => $id_data_diri]);
                        }   
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id'=>$id_data_diri])['Nama_Lengkap']." gagal disimpan."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Mahasiswa berhasil diluluskan, ".$jmlError." gagal diluluskan.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Mahasiswa berhasil diluluskan."));
                } 
                
            }
        }
        
    }
    
    function simpan_histori_pddk()
    {
        //$ModelHisPdk = new \App\Models\HistoriPddkModel($this->request);
        if($this->request->getMethod()=="post"){
            $aturan = [
                'keluar_smt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih tahun keluar!!'
                    ]
                ],
                'jns_keluar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih Jenis Keluar!!'
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih status mahasiswa!!'
                    ]
                ]
                
            ];
            
            
            if(!$this->validate($aturan)){
                
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan dimasukkan!!"));
                
                
            }else{
                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk'=>$this->request->getVar('id_his_pdk')])['id_data_diri'];
                $record = [
                    'id_his_pdk' => $this->request->getVar('id_his_pdk'),
                    'status' => $this->request->getVar('status'),
                    'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                    'sk_yudisium' => $this->request->getVar('sk_yudisium'),
                    'tgl_sk_yudisium' => $this->request->getVar('tgl_sk_yudisium'),
                    'jns_keluar' => $this->request->getVar('jns_keluar'),
                    'keluar_smt' => $this->request->getVar('keluar_smt'),
                    'ket' => $this->request->getVar('ket'),
                ];
                
                if($this->kelulusan->save($record)){
                    if($this->request->getVar('status') == 'D' || $this->request->getVar('status') == 'K' || $this->request->getVar('status') == 'L'){
                        updateDataDinamis('db_data_diri_mahasiswa', ['stat_mhs' => $this->request->getVar('status')], ['id' => $id_data_diri]);
                    } 
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                    
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));

                }

            }
            
            
        }
    }
    
    private function set_key_data($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->id_his_pdk] = $detail;
        }

        return $return;
    }
    
    function listMahasiswa()
    {
        
        //$mhsModel = new \App\Models\MahasiswaModel($this->request);
        //$pesertaKelasLalu = dataDinamis('akademik_krs', ['kode_kelas' => $this->request->getVar('kelas_lalu')]);
        
        if ($this->request->getMethod(true) === 'POST') {
            
            $dtMhs = dataDinamis('histori_pddk', 
                                ['histori_pddk.Prodi' => $this->request->getVar('prodi'), 'histori_pddk.Kelas' => $this->request->getVar('kelas'), 'db_data_diri_mahasiswa.th_angkatan' => $this->request->getVar('th_angkatan')],
                                null, null, null, null, null,
                                "histori_pddk.id_his_pdk, db_data_diri_mahasiswa.id", null, null, "db_data_diri_mahasiswa", "histori_pddk.id_data_diri=db_data_diri_mahasiswa.id");
            $dtMhslulus = dataDinamis('histori_pddk', 
                                ['Prodi' => $this->request->getVar('prodi'), 'Kelas' => $this->request->getVar('kelas'), 'status !=' => "A"],
                                null, null, null, null, null,
                                "histori_pddk.id_his_pdk");
            if(empty($this->request->getVar('kelas'))){
                $dtMhs = dataDinamis('histori_pddk', 
                                ['histori_pddk.Prodi' => $this->request->getVar('prodi'), 'db_data_diri_mahasiswa.th_angkatan' => $this->request->getVar('th_angkatan')],
                                null, null, null, null, null,
                                "histori_pddk.id_his_pdk, db_data_diri_mahasiswa.id", null, null, "db_data_diri_mahasiswa", "histori_pddk.id_data_diri=db_data_diri_mahasiswa.id");
                $dtMhslulus = dataDinamis('histori_pddk', 
                                ['Prodi' => $this->request->getVar('prodi'), 'status !=' => "A"],
                                null, null, null, null, null,
                                "histori_pddk.id_his_pdk"); 
            }

            $result_dtMhs = $this->set_key_data($dtMhs);
            $result_dtMhslulus = $this->set_key_data($dtMhslulus);

            foreach ($result_dtMhs as $index => $item) {
                if (isset($result_dtMhslulus[$index]))
                    unset($result_dtMhs[$index]);
            }

            $lists = array_values($result_dtMhs);

            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_matkul_kurikulum;
                $dtHisPdk = getDataRow('histori_pddk',['id_his_pdk' => $list->id_his_pdk]);
                $dtDiri = getDataRow('db_data_diri_mahasiswa',['id' => $list->id]);
                
                
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_his_pdk.'" />';
                $row[] = $no;
                $row[] = strtoupper($dtDiri['Nama_Lengkap']);
                $row[] = $dtHisPdk['NIM'];
                $row[] = $dtHisPdk['Prodi'];
                $row[] = $dtHisPdk['Program'];
                $row[] = $dtHisPdk['Kelas'];
                $row[] = $dtDiri['th_angkatan'];
                $row[] = '';
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $matkulKurikulumModel->countAll(),
                //'recordsFiltered' => $matkulKurikulumModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
}
