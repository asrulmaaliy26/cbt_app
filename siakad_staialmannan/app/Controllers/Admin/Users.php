<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Users extends BaseController
{
    function __construct()
    {
        
        $this->validation = \Config\Services::validation();
        $this->users = new UserModel();
        $this->halaman_controller = "users";
        $this->halaman_label = "Users";
    }

    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dataUser = $this->users->find($this->request->getVar('id'));
                if($dataUser['id']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->users->delete($this->request->getVar('id'));
                    if($aksi == true){
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
        $hasil = $this->users->listUser($jumlah_baris, $kata_kunci, $group_dataset);
        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];
        $data['kata_kunci'] = $kata_kunci;
        $data['jml_baris'] = $jumlah_baris;
        $currentPage = $this->request->getVar('page_dt');
        $data['nomor'] = nomor($currentPage, $jumlah_baris);
        $data['templateJudul'] = 'Halaman '.$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view("admin/$this->halaman_controller/".$data['metode'], $data);
    }

    public function getData()
    {
        //$request = Services::request();
        //$model = new SliderModel($request);
        
        $dataUser = $this->users->find($this->request->getVar('id'));

        if(empty($dataUser)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $dataUser));
        }
        
    }

    function simpanUser()
    {
        if($this->request->getMethod() == 'post'){
            $dataUser = getDataRow('users', ['id' => $this->request->getVar('id')]);
            $email = $this->request->getVar('email');
            $username = $this->request->getVar('username');
            
            $password_baru = $this->request->getVar('password_baru');
            $password_baru_konfirmasi = $this->request->getVar('konfirmasi_password');
            if($email != $dataUser['email']){
                $ruleEmail = 'required|is_unique[users.email]|valid_email';
            }else{
                $ruleEmail = 'required|valid_email';
            }
            if($username != $dataUser['username']){
                $ruleUsername = 'required|is_unique[users.username]';
            }else{
                $ruleUsername = 'required';
            }

            $aturan = [
                'email' => [
                    'rules' => $ruleEmail,
                    'errors' => [
                        'required'=>'Email harus diisi',
                        'is_unique' => 'Email '.$this->request->getVar('email').' sudah ada. Silahkan gunakan email yang lain.',
                        'valid_email' => 'Email anda tidak valid'
                    ]
                ],
                'username' => [
                    'rules' => $ruleUsername,
                    'errors' => [
                        'required'=>'Email harus diisi',
                        'is_unique' => 'Username '.$this->request->getVar('username').' sudah ada. Silahkan gunakan username yang lain.'
                    ]
                ]
            ];
            if($password_baru != ''){
                $aturan = [
                    'email' => [
                        'rules' => $ruleEmail,
                        'errors' => [
                            'required'=>'Email harus diisi',
                            'is_unique' => 'Email '.$this->request->getVar('email').' sudah ada. Silahkan gunakan email yang lain.',
                            'valid_email' => 'Email anda tidak valid'
                        ]
                    ],
                    'username' => [
                        'rules' => $ruleUsername,
                        'errors' => [
                            'required'=>'Username harus diisi',
                            'is_unique' => 'Username '.$this->request->getVar('username').' sudah ada. Silahkan gunakan username yang lain.'
                        ]
                    ],
                    'password_baru' => [
                        'rules' => 'min_length[6]|alpha_numeric_punct',
                        'errors' => [
                            'min_length' => 'Panjang password minimal 6 karakter',
                            //'alpha_numeric_punct' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                        ]
                    ],
                    'konfirmasi_password' => [
                        'rules' => 'matches[password_baru]',
                        'errors' => [
                            'matches' => 'Konfirmasi password tidak sama dengan password'
                        ]
                    ]
                ];
            }
            $err = [];
            if(!$this->validate($aturan)){
                echo json_encode(array("status" => FALSE, "validation" => $this->validation->getErrors(), "error" => $err));
                
            }else{
                
                if($email != $dataUser['email']){
                    $dataUpdate = [
                        'id' => $this->request->getVar('id'),
                        'email' => $email
                    ];
                    $aksi = $this->users->save($dataUpdate);
                    if($aksi == false){
                        $err[] = 'Email gagal diupdate';
                    };                    
                }
                if($username != $dataUser['username']){
                    $dataUpdate = [
                        'id' => $this->request->getVar('id'),
                        'username' => $username
                    ];
                    $aksi = $this->users->save($dataUpdate);
                    if($aksi){
                        updateDataDinamis('db_data_diri_mahasiswa', ['username' => $username], ['username' => $dataUser['username']]);
                    }
                    if($aksi == false){
                        $err[] = 'Username gagal diupdate';
                    };
                    
                }
                if($password_baru != ''){
                    $password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                    $dataUpdate = [
                        'id' => $this->request->getVar('id'),
                        'password_hash' => $password_baru_hash,
                        'password_plain' => $password_baru
                    ];

                    $aksi = $this->users->save($dataUpdate);
                    if($aksi == false){
                        $err[] = 'Password gagal diupdate';
                    };

                }
                if(empty($err)){
                    echo json_encode(array("status" => true));
                }else{
                    echo json_encode(array("status" => FALSE, "error" => $err, "validation" => $this->validation->getErrors()));

                }
                
            }
        }
    }

    function tambahUser()
    {
        $request = Services::request();

        if($this->request->getMethod() == 'post'){
            
            $aturan = [
                'nama_lengkap_user' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih user'
                    ]
                ],
                'username_user' => [
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        'required'=>'Username harus diisi',
                        'is_unique' => 'Username '.$this->request->getVar('username_user').' sudah ada. Silahkan gunakan username yang lain.'
                    ]
                ],
                'email_user' => [
                    'rules' => 'required|is_unique[users.email]|valid_email',
                    'errors' => [
                        'required'=>'Email harus diisi',
                        'is_unique' => 'Email '.$this->request->getVar('email_user').' sudah ada. Silahkan gunakan email yang lain.',
                        'valid_email' => 'Email anda tidak valid'
                    ]
                ],
                'password_hash' => [
                    'rules' => 'min_length[6]|alpha_numeric',
                    'errors' => [
                        'min_length' => 'Panjang paswword minimal 6 karakter',
                        'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                    ]
                ],
                'confirm_password' => [
                    'rules' => 'matches[password_hash]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak sama dengan password'
                    ]
                ],
                'user_group_user' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih Group User'
                    ]
                ],
                'jns_user' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih Jenis User'
                    ]
                ]
            ];
            
            $err = [];
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => 'invalid', "validation" => $this->validation->getErrors(), "error" => $err));
                
            }else{
                $record_user = [
                    'nama_lengkap' => $this->request->getVar('nama_lengkap_user'),
                    'username' => $this->request->getVar('username_user'),
                    'email' => $this->request->getVar('email_user'),
                    'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT)
                ];

                if($this->users->save($record_user)){
                    $userGroup = [
                        'group_id' => $this->request->getVar('user_group_user'),
                        'user_id' => $this->users->getInsertID()
                    ];
                    setUserGroup($userGroup);
                    if($this->request->getVar('jns_user') == 'data_dosen'){
                        $record = [
                            'id_dosen' => $this->request->getVar('id_dosen_mhs'),
                            'username' => $this->request->getVar('username_user')
                        ];
                        $dosenModel = new \App\Models\DosenModel($request);
                        $dosenModel->save($record);
                    }
                    if($this->request->getVar('jns_user') == 'db_data_diri_mahasiswa'){
                        $record = [
                            'id' => $this->request->getVar('id_dosen_mhs'),
                            'username' => $this->request->getVar('username_user')
                        ];
                        $mhsModel = new \App\Models\MahasiswaModel($request);
                        $mhsModel->save($record);
                    }
                    echo json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));

                }
                
            }
        }
    }
    
    /*
    function simpanGroup()
    {
        if($this->request->getMethod()=="post"){
            $aturan = [
                'group_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih salah satu grup'
                    ]
                ]
            ];
            
            //dd($this->request->getVar('group_id'));

            if(!$this->validate($aturan)){
                echo json_encode(array("status" => FALSE, "validation" => $this->validation->getErrors()));
            }else{
                $record = [];
                foreach ($this->request->getVar('group_id') as $group) {
                    array_push($record, [
                        'group_id' => $group,
                        'user_id' => $this->request->getVar('id')
                    ]);
                     
                }
               
                $db      = \Config\Database::connect();
                $builder = $db->table('auth_groups_users');
                if($builder->insertBatch($record)){
                    echo json_encode(array("status" => true));
                }else{
                    echo json_encode(array("status" => false));

                }
            }
        }
    }
    */
    
    function simpanGroup()
    {
        if($this->request->getMethod()=="post"){
            $aturan = [
                'group_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pilih salah satu grup'
                    ]
                ]
            ];
            if($this->request->getVar('group_id') == 9){
                $aturan = [
                    'group_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih salah satu grup'
                        ]
                    ],
                    'fakultas' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih fakultas'
                        ]    
                    ]
                ];
            }
            
            if($this->request->getVar('group_id') == 4){
                $aturan = [
                    'group_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih salah satu grup'
                        ]
                    ],
                    'prodi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih prodi'
                        ]    
                    ]
                ];
            }
            
            if($this->request->getVar('group_id') == 104){
                $aturan = [
                    'group_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Pilih salah satu grup'
                        ]
                    ],
                    'folder_sistem' => [
                        'rules' => 'required',
                        'errors' => [
                            'required'=>'Folder sistem tidak boleh kosong'
                        ]    
                    ]
                ];
            }
            //dd($this->request->getVar('group_id'));

            if(!$this->validate($aturan)){
                echo json_encode(array("status" => FALSE, "validation" => $this->validation->getErrors()));
            }else{
                if($this->request->getVar('group_id') == '9'){
                    $record = [
                            'group_id' => $this->request->getVar('group_id'),
                            'user_id' => $this->request->getVar('id'),
                            'bagian' => $this->request->getVar('fakultas')
                        ];
                }elseif($this->request->getVar('group_id') == '4'){
                    $record = [
                            'group_id' => $this->request->getVar('group_id'),
                            'user_id' => $this->request->getVar('id'),
                            'bagian' => $this->request->getVar('prodi')
                        ];
                }elseif($this->request->getVar('group_id') == '104'){
                    $record = [
                            'group_id' => $this->request->getVar('group_id'),
                            'user_id' => $this->request->getVar('id'),
                            'bagian' => $this->request->getVar('folder_sistem')
                        ];
                }else{
                    $record = [
                            'group_id' => $this->request->getVar('group_id'),
                            'user_id' => $this->request->getVar('id'),
                        ];
                }
                
                $db      = \Config\Database::connect();
                $builder = $db->table('auth_groups_users');
                if($builder->insert($record)){
                    echo json_encode(array("status" => true));
                }else{
                    echo json_encode(array("status" => false));

                }
            }
        }
    }

    function hapusGroup()
    {
        if($this->request->getMethod()=="post"){
            $db      = \Config\Database::connect();
            $builder = $db->table('auth_groups_users');
            $builder->where(['group_id' => $this->request->getVar('group_id'),
                                'user_id' => $this->request->getVar('user_id')
                            ]);
            if($builder->delete()){
                echo json_encode(array("status" => true));
            }else{
                echo json_encode(array("status" => false));

            }
        }
    }
    
    function getUserLama(){
        //$dbLama = \Config\Database::connect('akademik_lama');
        $db      = \Config\Database::connect();
        $request = Services::request();
        
        if($this->request->getMethod() == 'post'){
            if($this->request->getVar('nm_table') === "Dosen"){
                $builder = $db->table('data_dosen');
                $query   = $builder->get()->getResult();
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                foreach($query as $row){
                    $recordUser = [
                        'username' => $row->NIY == null ?$row->Nama_Dosen:$row->NIY,
                        'nama_lengkap' => $row->Nama_Dosen,
                        'email' => $row->email,
                        'password_hash' => $row->password != null?password_hash($row->password, PASSWORD_DEFAULT):password_hash('1234567', PASSWORD_DEFAULT),
                        'password_plain' => $row->password != null ?$row->password:'1234567',
                        'foto_profil' => (!empty($row->foto) && $row->foto != "0")?substr($row->foto,30):''
                    ];
                    
                    $recordDosen = [
                        'id_dosen' => $row->id_dosen,
                        'username' => $row->NIY == null ?$row->Nama_Dosen:$row->NIY,
                        'foto' => (!empty($row->foto) && $row->foto != "0")?substr($row->foto,30):''
                    ];
                    
                    if($this->users->save($recordUser)){
                        $userGroup = [
                            'group_id' => 2,
                            'user_id' => $this->users->getInsertID()
                        ];
                        setUserGroup($userGroup);
                        $dosenModel = new \App\Models\DosenModel($request);
                        $dosenModel->save($recordDosen);
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'nama_dosen'    => $row->Nama_Dosen
                        ];
                    }
                }
                return json_encode(array("msg" => "info", "pesan" => "Sukses  ".$jmlSukses. ", Gagal  ".$jmlError, 'listError' => $listError));
            }
            if($this->request->getVar('nm_table') === "Mahasiswa"){
                $builder = $db->table('data_mhs as m');
                $query   = $builder->select('m.id, m.id_data_diri, m.tahun_angkatan, m.email, m.Password, m.Kelas, m.SMT, p.Tahun_Masuk, d.Nama_Lengkap')
                                    ->join('db_data_diri_mahasiswa as d', 'd.id=m.id_data_diri', 'left')
                                    ->join('db_pmb as p', 'p.id=m.id_data_diri', 'left')
                                    ->where('d.Nama_Lengkap !=', '')
                                    ->get()->getResult();
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                foreach($query as $row){
                    $username= $this->users->set_username($row->Nama_Lengkap);
                    $recordUser = [
                        'username' => $username /*strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $row->Nama_Lengkap)))*/,
                        'nama_lengkap' => $row->Nama_Lengkap,
                        'email' => (!empty($row->email) && $row->email != null) ? $row->email:strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $row->Nama_Lengkap)))."@mhs.iaibafa.ac.id",
                        'password_hash' => $row->Password != null?password_hash($row->Password, PASSWORD_DEFAULT):password_hash('1234567', PASSWORD_DEFAULT),
                        'password_plain' => $row->Password != null ?$row->Password:'1234567',
                        'foto_profil' => /*(!empty($row->Foto_Diri) && $row->Foto_Diri != "0")?substr($row->Foto_Diri,30):*/''
                    ];
                    
                    $recordMhs = [
                        'id' => $row->id_data_diri,
                        'id_mhs' => $row->id,
                        'username' => $username /*strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $row->Nama_Lengkap)))*/,
                        'th_masuk' => $row->Tahun_Masuk,
                        'th_angkatan' => $row->tahun_angkatan,
                        'kelas' => $row->Kelas,
                        'smt_aktif' => $row->SMT
                    ];
                    
                    if($this->users->save($recordUser)){
                        $userGroup = [
                            'group_id' => 3,
                            'user_id' => $this->users->getInsertID()
                        ];
                        setUserGroup($userGroup);
                        $mhsModel = new \App\Models\MahasiswaModel($request);
                        $mhsModel->save($recordMhs);
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'nama_mahasiswa'    => $row->Nama_Lengkap
                        ];
                    }
                }
                return json_encode(array("msg" => "info", "pesan" => "Sukses  ".$jmlSukses. ", Gagal  ".$jmlError, 'listError' => $listError));
            }
            
        }
        
    }
}
