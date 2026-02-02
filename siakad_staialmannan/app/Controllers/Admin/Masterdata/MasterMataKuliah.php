<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\MasterMataKuliahModel;
use Config\Services;

class MasterMataKuliah extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->master_mk = new MasterMataKuliahModel($request);
        $this->halaman_controller = "mastermatakuliah";
        $this->halaman_label = "Master Mata Kuliah";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->master_mk->find($this->request->getVar('id'));
                if($dt['id_mastermk']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->master_mk->delete($this->request->getVar('id'));
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
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->master_mk->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_kurikulum;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_mastermk.'" />';
                $row[] = $no;
                $row[] = $list->kode_mk;
                $row[] = $list->nama_mk;
                $row[] = $list->ps_pengampu;
                $row[] = $list->bobot_mk;
                $row[] = getDataRow('ref_option', ['opt_group' => 'jenis_mk', 'opt_id' => $list->jenis_mk])['opt_val'];
                $row[] = '<a onclick="hapus('."'".$list->id_mastermk."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit('."'".$list->id_mastermk."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->master_mk->countAll(),
                'recordsFiltered' => $this->master_mk->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->master_mk->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id_mastermk'))){
                $aturan = [
                    'kode_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Kode Matakuliah Wajib Diisi!!'
                        ]
                    ],
                    'nama_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama Matakuliah wajib diisi!!'
                        ]
                    ],
                    'ps_pengampu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih Prodi pengampu MK!!'
                        ]
                    ],
                    'bobot_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'SKS wajib diisi!!'
                        ]
                    ],
                    'jenis_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih Jenis Matakuliah!!'
                        ]
                    ]
                ];
                
                if(!$this->validate($aturan)){
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                }else{
                    
                    $record = [
                        'kode_mk' => $this->request->getVar('kode_mk'),
                        'nama_mk' => $this->request->getVar('nama_mk'),
                        'ps_pengampu' => $this->request->getVar('ps_pengampu'),
                        'bobot_mk' => $this->request->getVar('bobot_mk'),
                        'jenis_mk' => $this->request->getVar('jenis_mk')
                    ];
                    
                    //$aksi = $model->simpanData($record);
                    if($this->master_mk->save($record)){
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));
    
                    }
    
                }
            }else{
                $dataMK = $this->master_mk->find($this->request->getVar('id_mastermk'));// ambil data
                
                $aturan = [
                    'kode_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Kode Matakuliah Wajib Diisi!!'
                        ]
                    ],
                    'nama_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama Matakuliah wajib diisi!!'
                        ]
                    ],
                    'ps_pengampu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih Prodi pengampu MK!!'
                        ]
                    ],
                    'bobot_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'SKS wajib diisi!!'
                        ]
                    ],
                    'jenis_mk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih Jenis Matakuliah!!'
                        ]
                    ]
                ];

                if(!$this->validate($aturan)){
                    
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                    
                }else{
                    
                    $record = [
                        'id_mastermk' => $dataMK['id_mastermk'],
                        'kode_mk' => $this->request->getVar('kode_mk'),
                        'nama_mk' => $this->request->getVar('nama_mk'),
                        'ps_pengampu' => $this->request->getVar('ps_pengampu'),
                        'bobot_mk' => $this->request->getVar('bobot_mk'),
                        'jenis_mk' => $this->request->getVar('jenis_mk')
                    ];
                    //dd($record);
                    //$aksi = $model->simpanData($record);
                    if($this->master_mk->save($record)){
                        
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));
    
                    }
    
                }
            }
            
            
        }
        
    }
}
