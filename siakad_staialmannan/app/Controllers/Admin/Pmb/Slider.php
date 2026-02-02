<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

use Config\Services;

class Slider extends BaseController
{
    
    function __construct()
    {
        
        $this->validation = \Config\Services::validation();
        
        //helper('global_helper');
        //untuk konfigurasi internal
        $this->halaman_controller = "slider";
        $this->halaman_label = "Slider";
    }

    public function index()
    {
        $request = Services::request();
        $datatable = new SliderModel($request);
        
        $data = [];
        
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'index';

        return view("admin/".$this->halaman_controller."/view", $data);
    }

    function ajaxList()
    {
        $request = Services::request();
        $datatable = new SliderModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->slider_title;
                $row[] = $list->slider_subtitle;
                $row[] = '
                                    <div class="position-relative">
                                      <img src="'.base_url().'/'.$list->slider_img.'" class="img-fluid" />
                                    </div>
                                  ';
                $row[] = $list->is_aktif=='Y'?'<span class="badge badge-success">Aktif</span>':'<span class="badge badge-error">Tidak Aktif</span>';
                $row[] = '<a onclick="hapus('."'".$list->id."'".')" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                    <a role="button" href="javascript:void(0)" onclick="edit('."'".$list->id."'".')" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function tambah()
    {
        $request = Services::request();
        $model = new SliderModel($request);
        
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
                        $path = 'upload/'.$this->halaman_controller;
                        $foto = $path.'/'.$nm_foto;
                        $file->move($path, $nm_foto);
                    }
                    
                    
                    $record = [
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

    public function getData()
    {
        $request = Services::request();
        $model = new SliderModel($request);
        
        $dataSlider = $model->getData($this->request->getVar('id'));

        if(empty($dataSlider)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $dataSlider));
        }
        
    }

    function hapus()
    {
        $request = Services::request();
        $model = new SliderModel($request);
        if ($request->getMethod(true)=='POST') {
            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dataSlider = $model->getData($this->request->getVar('id'));
                //dd($dataKelas);
                if ($dataSlider['id']) { #memastikan ada data
                    
                    $aksi = $model->hapus($this->request->getVar('id'));
                    //dd($aksi);
                    if ($aksi == true) {
                        //session()->setFlashdata('success', 'Data telah dihapus');
                        echo json_encode(array("status" => TRUE));
                    } else {
                        //session()->setFlashdata('warning', 'Data gagal dihapus');
                        echo json_encode(array("status" => false));
                    }
                }
                //return redirect()->to("admin/" . $this->halaman_controller);
            }
        }
    }
}
