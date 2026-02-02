<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\KurikulumModel;
use Config\Services;

class Kurikulum extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->kurikulum = new kurikulumModel($request);
        $this->halaman_controller = "kurikulum";
        $this->halaman_label = "Kurikulum";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->kurikulum->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->kurikulum->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
        
        if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){

                $dataKurikulum = $this->kurikulum->find($this->request->getVar('id'));
                if($dataKurikulum['id']){ #memastikan ada data
                    $record = [
                        'id' => $this->request->getVar('id'),
                        'set_aktif' => '1'
                    ];
                    
                    if($this->kurikulum->save($record)){
                        //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }

        if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
            $dataKurikulum = $this->kurikulum->find($this->request->getVar('id'));
            if($dataKurikulum['id']){ #memastikan ada data
                $record = [
                    'id' => $this->request->getVar('id'),
                    'set_aktif' => '0'
                ];
                
                if($this->kurikulum->save($record)){
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
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->kurikulum->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = '<a href="javascript:void(0)" onclick=showDetail('."'".$list->id."'".') >'.$list->nama_kurikulum.'</a>';
                $row[] = $list->jenjang." - ".$list->prodi;
                $row[] = $list->tahunAkademik." ".($list->semester == 1 ? 'Gasal' : 'Genap');
                $row[] = $list->set_aktif == 1 ? '<a onclick="deactivate('."'".$list->id."','".$list->nama_kurikulum."'".'); return false;" role="button" data-placement="top" title="Klik untuk menonaktifkan"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$list->id."','".$list->nama_kurikulum."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengaktifkan"><i class="fas fa-times fa-lg text-red" ></i></a>';
                $row[] = '<a onclick="hapus('."'".$list->id."','".$list->nama_kurikulum."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit('."'".$list->id."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->kurikulum->countAll(),
                'recordsFiltered' => $this->kurikulum->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->kurikulum->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id'))){
                $aturan = [
                    'nama_kurikulum' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama kurikulum Wajib Diisi!!'
                        ]
                    ],
                    'prodi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'mulai_berlaku' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'set_aktif' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'jenjang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ]
                ];
                
                if(!$this->validate($aturan)){
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                }else{
                    
                    $record = [
                        'nama_kurikulum' => $this->request->getVar('nama_kurikulum'),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'prodi' => $this->request->getVar('prodi'),
                        'mulai_berlaku' => $this->request->getVar('mulai_berlaku'),
                        'set_aktif' => $this->request->getVar('set_aktif')
                    ];
                    
                    //$aksi = $model->simpanData($record);
                    if($this->kurikulum->save($record)){
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));
    
                    }
    
                }
            }else{
                $dataKurikulum = $this->kurikulum->find($this->request->getVar('id'));// ambil data
                
                $aturan = [
                    'nama_kurikulum' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama kurikulum Wajib Diisi!!'
                        ]
                    ],
                    'prodi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'mulai_berlaku' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'set_aktif' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ],
                    'jenjang' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Wajib diisi!!'
                        ]
                    ]
                ];

                if(!$this->validate($aturan)){
                    
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                    
                }else{
                    
                    $record = [
                        'id' => $dataKurikulum['id'],
                        'nama_kurikulum' => $this->request->getVar('nama_kurikulum'),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'prodi' => $this->request->getVar('prodi'),
                        'mulai_berlaku' => $this->request->getVar('mulai_berlaku'),
                        'set_aktif' => $this->request->getVar('set_aktif')
                    ];
                    //dd($record);
                    //$aksi = $model->simpanData($record);
                    if($this->kurikulum->save($record)){
                        
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));
    
                    }
    
                }
            }
            
            
        }
        
    }
    
    function detail($id=null)
    {
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id_matkul_kurikulum')){
                $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
                $dt = $matkulKurikulumModel->find($this->request->getVar('id_matkul_kurikulum'));
                if($dt['id_matkul_kurikulum']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $matkulKurikulumModel->delete($this->request->getVar('id_matkul_kurikulum'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
        
        $data = $this->kurikulum->find($id);
        $data['templateJudul'] = 'Detail '.$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listMatkulKurikulum()
    {
        $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $matkulKurikulumModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_matkul_kurikulum;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_matkul_kurikulum.'" />';
                $row[] = $no;
                $row[] = $list->kode_mk;
                $row[] = $list->nama_mk. " - ". $list->id_matkul_kurikulum;
                $row[] = $list->bobot_mk;
                $row[] = '<input name="smt[]" id="smt'.$list->id_matkul_kurikulum.'" class="form-control form-control-sm" onfocusout="simpan_smt('."'smt','".$list->id_matkul_kurikulum."'".')" value="'.$list->smt.'"/>';
                $row[] = '<a onclick="hapus('."'".$list->id_matkul_kurikulum."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Matakuliah"><i class="fa fa-trash"></i></a>
                        '; 
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $matkulKurikulumModel->countAll(),
                'recordsFiltered' => $matkulKurikulumModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function listMatkulMaster()
    {
        $MasterMataKuliahModel = new \App\Models\MasterMataKuliahModel($this->request);
        $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $listMatkulMaster = $MasterMataKuliahModel->getDatatables();
            $listMatkulKurikulum = $matkulKurikulumModel->getDatatables();

            $result_MatkulMaster = $this->set_key_data($listMatkulMaster);
            $result_MatkulKurikulum = $this->set_key_data($listMatkulKurikulum);

            foreach ($result_MatkulMaster as $index => $item) {
                if (isset($result_MatkulKurikulum[$index]))
                    unset($result_MatkulMaster[$index]);
            }

            $lists = array_values($result_MatkulMaster);

            $data = [];
            
            
            //$lists = $MasterMataKuliahModel->getDatatables();
            //$data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = '<a onclick="simpan('."'".$list->id_mastermk."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Tambahkan"><i class="fa fa-plus"></i></a>';
                $row[] = $list->kode_mk;
                $row[] = $list->nama_mk;
                $row[] = $list->bobot_mk;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $MasterMataKuliahModel->countAll(),
                'recordsFiltered' => $MasterMataKuliahModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    private function set_key_data($data) 
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->id_mastermk] = $detail;
        }

        return $return;
    }
    
    public function simpanMatkulKurikulum()
    {
        $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
        
        if($this->request->getMethod()=="post"){
            
            $record = [
                'id_kurikulum' => $this->request->getVar('id_kurikulum'),
                'id_mk' => $this->request->getVar('id_mastermk')
            ];
            if($matkulKurikulumModel->save($record)){
                return json_encode(array("msg" => "success", "pesan" => "Matakuliah berhasil ditambahkan."));
            }else{
                return json_encode(array("msg" => "error", "pesan" => "Matakuliah gagal ditambahkan."));
            };
        }
    }
    
    function updateMk()
    {
        $matkulKurikulumModel = new \App\Models\MatkulKurikulumModel($this->request);
        
        if ($this->request->getMethod(true)=='POST') {
            $record = [
                'id_matkul_kurikulum' => $this->request->getVar('id_matkul_kurikulum'),
                $this->request->getVar('field') => $this->request->getVar('val')
            ];
            
            if($matkulKurikulumModel->save($record)){
                echo json_encode(array("status" => true));
            }else{
                echo json_encode(array("status" => false));
            }
        }
    }
}
