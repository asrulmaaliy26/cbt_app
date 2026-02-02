<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use Config\Services;

class Dosen extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->model = new DosenModel($request);
        $this->halaman_controller = "dosen";
        $this->halaman_label = "Dosen";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->model->find($this->request->getVar('id'));
                if($dt['id_dosen']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->model->delete($this->request->getVar('id'));
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
        return view(session()->get('akun_group_folder')."/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->model->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("profil/dosen?id_dosen").$list->id_dosen;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_dosen.'" />';
                $row[] = $list->Kode;
                $row[] = $list->Nama_Dosen;
                $row[] = $list->TTL;
                $row[] = $list->NIY;
                $row[] = $list->NIDN_NUPN;
                $row[] = (!empty($list->Jabatan) && $list->Jabatan !="-")?getDataRow('ref_option', ['opt_group' => 'jabatan_fungsional', 'opt_id' => $list->Jabatan])['opt_val']:"-";
                $row[] = (!empty($list->Pangkat_Gol_Ruang) && $list->Pangkat_Gol_Ruang !="-")?getDataRow('ref_option', ['opt_group' => 'pangkat', 'opt_id' => $list->Pangkat_Gol_Ruang])['opt_val']:"-";
                $row[] = (!empty($list->Status) && $list->Status !="-")?getDataRow('ref_option', ['opt_group' => 'status_dosen', 'opt_id' => $list->Status])['opt_val']:"-";
                $row[] = (!empty($list->Program_Studi) && $list->Program_Studi !="-")?getDataRow('prodi', ['singkatan' => $list->Program_Studi])['nm_prodi']:"-";
                if(session()->get('akun_level') == 'Admin'){
                $row[] = '<a onclick="hapus('."'".$list->id_dosen."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit('."'".$list->id_dosen."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Edit"><i class="fa fa-eye"></i></a>
                        ';
                }
                if(session()->get('akun_level') == 'Fakultas' || session()->get('akun_level') == 'Kaprodi' || session()->get('akun_level') == 'LP2M'){
                $row[] = '<a onclick="edit('."'".$list->id_dosen."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Edit"><i class="fa fa-eye"></i></a>
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->model->countAll(),
                'recordsFiltered' => $this->model->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->model->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function simpan()
    {
        
        if($this->request->getMethod()=="post"){
            if(empty($this->request->getVar('id_dosen'))){
                $aturan = [
                    'Kode' => [
                        'rules' => 'required|is_unique[data_dosen.Kode]',
                        'errors' => [
                            'required'=>'Kode dosen wajib diisi!!',
                            'is_unique' => 'Kode '.$this->request->getVar('Kode').' Sudah ada. Gunakan kode yang lain!!!'
                        ]
                    ],
                    'Nama_Dosen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama dosen wajib diisi!!'
                        ]
                    ],
                    'NIY' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'NIY wajib diisi!!'
                        ]
                    ],
                    'Status' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih status dosen / kepegawaian!!'
                        ]
                    ],
                    'tahun_tugas' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Tahun mulai bertugas wajib diisi!!'
                        ]
                    ],
                    'username' => [
                        'rules' => 'required|is_unique[users.username]',
                        'errors' => [
                            'required'=>'Username harus diisi',
                            'is_unique' => 'Username '.$this->request->getVar('username').' sudah ada. Silahkan buat username lain.'
                        ]
                    ],
                    'password_hash' => [
                        'rules' => 'min_length[6]|alpha_numeric',
                        'errors' => [
                            'min_length' => 'Panjang paswword minimal 6 karakter',
                            'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                        ]
                    ],
                    'konfirmasi_password' => [
                        'rules' => 'matches[password_hash]',
                        'errors' => [
                            'matches' => 'Konfirmasi password tidak sama dengan password'
                        ]
                    ]
                ];
                
                $file = $this->request->getFile('foto');
                
                if(!$this->validate($aturan)){
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                }else{
                    
                    $foto = 'assets/dist/img/no-pict.jpg';
                    if($file->getName()){
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace( "'", "", $this->request->getVar('Nama_Dosen'));
                        $path = 'berkas_dosen/'.$nmFolder;
                        $foto = $path.'/'.$nm_foto;
                        $file->move($path, $nm_foto);
                    }
                    
                    $record = [
                        'Kode' => $this->request->getVar('Kode'),
                        'gelar_depan' => $this->request->getVar('gelar_depan'),
                        'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                        'Nama_Dosen' => $this->request->getVar('Nama_Dosen'),
                        'NIY' => $this->request->getVar('NIY'),
                        'TTL' => $this->request->getVar('TTL'),
                        'NIDN_NUPN' => $this->request->getVar('NIDN_NUPN'),
                        'Alamat' => $this->request->getVar('Alamat'),
                        'Pangkat_Gol_Ruang' => $this->request->getVar('Pangkat_Gol_Ruang'),
                        'Jabatan' => $this->request->getVar('Jabatan'),
                        'Status' => $this->request->getVar('Status'),
                        'Program_Studi' => $this->request->getVar('Program_Studi'),
                        'profil_sinta' => $this->request->getVar('profil_sinta'),
                        'email' => $this->request->getVar('email'),
                        'username' => $this->request->getVar('username'),
                        'tahun_tugas' => $this->request->getVar('tahun_tugas'),
                        'scholar' => $this->request->getVar('scholar'),
                        'foto' => $foto,
                    ];
                    $user = [
                        'nama_lengkap' => $this->request->getVar('Nama_Dosen'),
                        'username' => $this->request->getVar('username'),
                        'email' => $this->request->getVar('email'),
                        'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT),
                        'password_plain' => $this->request->getVar('password_hash'),
                        'foto_profil' => $foto,
                    ];
                    $userModel = new \App\Models\UserModel;
                    if($userModel->save($user)){
                        $userGroup = [
                            'group_id' => 2,
                            'user_id' => $userModel->getInsertID()
                        ];
                        setUserGroup($userGroup);
                        
                        if($this->model->save($record)){
                            echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                        }else{
                            echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "User berhasil disimpan, data dosen gagal disimpan."));
                        }
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));
                    }
    
                }
            }else{
                $dt = $this->model->find($this->request->getVar('id_dosen'));// ambil data
                
                $aturan = [
                    'Nama_Dosen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Nama dosen wajib diisi!!'
                        ]
                    ],
                    'NIY' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'NIY wajib diisi!!'
                        ]
                    ],
                    'Status' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih status dosen / kepegawaian!!'
                        ]
                    ],
                    'tahun_tugas' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Tahun mulai bertugas wajib diisi!!'
                        ]
                    ],
                ];
                
                if(!empty($this->request->getVar('password_hash'))){
                    $aturan = [
                        'Kode' => [
                            'rules' => 'required|is_unique[data_dosen.Kode]',
                            'errors' => [
                                'required'=>'Kode dosen wajib diisi!!',
                                'is_unique' => 'Kode '.$this->request->getVar('Kode').' Sudah ada. Gunakan kode yang lain!!!'
                            ]
                        ],
                        'Nama_Dosen' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Nama dosen wajib diisi!!'
                            ]
                        ],
                        'NIY' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'NIY wajib diisi!!'
                            ]
                        ],
                        'tahun_tugas' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Tahun mulai bertugas wajib diisi!!'
                            ]
                        ],
                        'Status' => [
                            'rules' => 'required',
                            'errors' => [
                                'required'=>'Pilih status dosen / kepegawaian!!'
                            ]
                        ],
                        'password_hash' => [
                            'rules' => 'min_length[6]|alpha_numeric',
                            'errors' => [
                                'min_length' => 'Panjang paswword minimal 6 karakter',
                                'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                            ]
                        ],
                        'konfirmasi_password' => [
                            'rules' => 'matches[password_hash]',
                            'errors' => [
                                'matches' => 'Konfirmasi password tidak sama dengan password'
                            ]
                        ]
                    ];
                }
                $file = $this->request->getFile('foto');
                if(!$this->validate($aturan)){
                    echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                }else{
                    $foto = $dt['foto'];
                    if($file->getName()){
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace( "'", "", $this->request->getVar('Nama_Dosen'));
                        $path = 'berkas_dosen/'.$nmFolder;
                        $foto = $path.'/'.$nm_foto;
                        $file->move($path, $nm_foto);
                        if($dt['foto'] != 'assets/dist/img/no-pict.jpg' || $dt['foto'] != null){
                            @unlink($dt['foto']);
                        }
                    }
                    $record = [
                        'id_dosen' => $dt['id_dosen'],
                        'gelar_depan' => $this->request->getVar('gelar_depan'),
                        'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                        'Nama_Dosen' => $this->request->getVar('Nama_Dosen'),
                        'NIY' => $this->request->getVar('NIY'),
                        'TTL' => $this->request->getVar('TTL'),
                        'NIDN_NUPN' => $this->request->getVar('NIDN_NUPN'),
                        'Alamat' => $this->request->getVar('Alamat'),
                        'Pangkat_Gol_Ruang' => $this->request->getVar('Pangkat_Gol_Ruang'),
                        'Jabatan' => $this->request->getVar('Jabatan'),
                        'Status' => $this->request->getVar('Status'),
                        'Program_Studi' => $this->request->getVar('Program_Studi'),
                        'profil_sinta' => $this->request->getVar('profil_sinta'),
                        'email' => $this->request->getVar('email'),
                        'tahun_tugas' => $this->request->getVar('tahun_tugas'),
                        'scholar' => $this->request->getVar('scholar'),
                        'foto' => $foto,
                    ];
                    if($this->request->getVar('Nama_Dosen') != $dt['Nama_Dosen']){
                        $userModel = new \App\Models\UserModel;
                        $update_user = [
                            'id' => getDataRow('users',['username'=>$this->request->getVar('username')])['id'],
                            'nama_lengkap' => $this->request->getVar('Nama_Dosen')
                        ];
                        $userModel->save($update_user);
                    }
                    if(!empty($this->request->getVar('password_hash'))){
                        $userModel = new \App\Models\UserModel;
                        $update_user = [
                            'id' => getDataRow('users',['username'=>$this->request->getVar('username')])['id'],
                            'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT)
                        ];
                        $userModel->save($update_user);
                    }
                    //dd($record);
                    //$aksi = $model->simpanData($record);
                    if($this->model->save($record)){
                        
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));
    
                    }
    
                }
            }
            
            
        }
        
    }
}
