<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\TahunakademikModel;
use Config\Services;

class Tahunakademik extends BaseController
{
    function __construct()
    {
        
        $this->validation = \Config\Services::validation();
        $this->tahun = new TahunakademikModel();
        $this->halaman_controller = "tahunakademik";
        $this->halaman_label = "Tahun Akademik";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $ta = $this->tahun->find($this->request->getVar('id'));
                if($ta['id_ta']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->tahun->delete($this->request->getVar('id'));
                    if($aksi == true){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
            
            if($this->request->getVar('aksi')=='activate' && $this->request->getVar('id')){

                $dataTa = $this->tahun->find($this->request->getVar('id'));
                if($dataTa['id_ta']){ #memastikan ada data
                    $record = [
                        'id_ta' => $this->request->getVar('id'),
                        'aktif' => 'y'
                    ];
                    
                    if($this->tahun->save($record)){
                        $this->tahun->where('id_ta !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }

            if($this->request->getVar('aksi')=='deactivate' && $this->request->getVar('id')){
                $dataTa = $this->tahun->find($this->request->getVar('id'));
                if($dataTa['id_ta']){ #memastikan ada data
                    $record = [
                        'id_ta' => $this->request->getVar('id'),
                        'aktif' => 'n'
                    ];
                    
                    if($this->tahun->save($record)){
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
        //$post_type = $this->halaman_controller;
        
        $jumlah_baris = $this->request->getVar('jml_baris');
        if(empty($this->request->getVar('jml_baris'))){
            $jumlah_baris = 10;
        }
        $kata_kunci =$this->request->getVar('kata_kunci');
        
        $group_dataset = 'dt';
        $hasil = $this->tahun->list($jumlah_baris, $kata_kunci, $group_dataset);
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
        return view("admin/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id_ta'))){
                $aturan = [
                    'tahunAkademik' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Tahun Akademik Wajib Diisi!!'
                        ]
                    ],
                    'semester' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih semester!!'
                        ]
                    ]
                ];
                
                if(!$this->validate($aturan)){
                    echo json_encode(array("msg" => "invalid", "validation" => $this->validation->getErrors()));
                }else{
                    
                    $record = [
                        'tahunAkademik' => $this->request->getVar('tahunAkademik'),
                        'semester' => $this->request->getVar('semester'),
                        'kode' => substr($this->request->getVar('tahunAkademik'),0,4).$this->request->getVar('semester')
                    ];
                    
                    //$aksi = $model->simpanData($record);
                    if($this->tahun->save($record)){
                        echo json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        echo json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
    
                    }
    
                }
            }else{
                $dataTa = $this->tahun->find($this->request->getVar('id_ta'));// ambil data
                
                $aturan = [
                    'tahunAkademik' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Tahun Akademik Wajib Diisi!!'
                        ]
                    ],
                    'semester' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih semester!!'
                        ]
                    ]
                ];

                if(!$this->validate($aturan)){
                    
                    echo json_encode(array("msg" => "invalid", "validation" => $this->validation->getErrors()));
                    
                }else{
                    
                    $record = [
                        'id_ta' => $dataTa['id_ta'],
                        'tahunAkademik' => $this->request->getVar('tahunAkademik'),
                        'semester' => $this->request->getVar('semester'),
                        'kode' => substr($this->request->getVar('tahunAkademik'),0,4).$this->request->getVar('semester')
                    ];
                    //dd($record);
                    //$aksi = $model->simpanData($record);
                    if($this->tahun->save($record)){
                        
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
        
        $data = $this->tahun->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
}
