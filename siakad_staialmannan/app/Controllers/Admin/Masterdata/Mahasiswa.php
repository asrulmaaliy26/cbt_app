<?php

namespace App\Controllers\Admin\Masterdata;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mahasiswa extends BaseController
{

    protected $validation;
    protected MahasiswaModel $mahasiswa;
    protected string $halaman_controller;
    protected string $halaman_label;
    
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->mahasiswa = new MahasiswaModel($request);
        $this->halaman_controller = "mahasiswa";
        $this->halaman_label = "Mahasiswa";
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
        return view(session()->get('akun_group_folder')."/masterdata/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->mahasiswa->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            //$taAktif = intval(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']);
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id;
                $historiPdkAktif = getDataRow('histori_pddk', ['id_data_diri' => $list->id, 'jns_keluar' => NULL, 'status' => 'A']);
                /*
                if ($taAktif %2 != 0){
                	$a = (($taAktif + 10)-1)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = ($b*2)-1;
                	
                }else{
                	$a = (($taAktif + 10)-2)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = $b * 2;
                }*/
                if($list->stat_mhs=='A'){
    			    $stat_mhs= '<span class="badge badge-success">Aktif</span>';
    			}elseif($list->stat_mhs=='C'){
    			    $stat_mhs= '<span class="badge badge-warning">Cuti</span>';
    			}elseif($list->stat_mhs=='D'){
    			    $stat_mhs= '<span class="badge badge-danger">Drop-Out/Putus Studi</span>';
    			}elseif($list->stat_mhs=='G'){
    			    $stat_mhs= '<span class="badge badge-grey">Sedang Double Degree</span>';   
    			}elseif($list->stat_mhs=='K'){
    			    $stat_mhs= '<span class="badge badge-danger">Keluar</span>';
    			}elseif($list->stat_mhs=='L'){
    			    $stat_mhs= '<span class="badge badge-danger">Lulus</span>';
    			}elseif($list->stat_mhs=='M'){
    			    $stat_mhs= '<span class="badge badge-primary">Kampus Merdeka</span>';
    			}elseif($list->stat_mhs=='N'){
    			    $stat_mhs= '<span class="badge badge-danger">Non-Aktif</span>';
    			}elseif($list->stat_mhs=='U'){
    			    $stat_mhs= '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
    			}else{
    			    $stat_mhs= "-";
    			}
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $list->th_angkatan;
                $row[] = $list->Nama_Lengkap;
                $row[] = (!empty($historiPdkAktif))?$historiPdkAktif['NIM'] : $list->NIM;
                $row[] = (!empty($historiPdkAktif))?$historiPdkAktif['Program']:$list->Program;
                $row[] = (!empty($historiPdkAktif))?$historiPdkAktif['Prodi']:$list->Prodi;
                $row[] = (!empty($historiPdkAktif))?$historiPdkAktif['Kelas']:$list->kls;
                //$row[] = $list->smt_aktif." / ".$c;
                $row[] = $stat_mhs;//(!empty($list->stat_mhs))?getDataRow('ref_option', ['opt_group' => 'status_mhs', 'opt_id' => $list->stat_mhs])['opt_val']:"-";
                if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "Fakultas" || session()->get('akun_level') == "Kaprodi"){
                $row[] = '<a href="'.$link_detail.'" class="btn btn-xs btn-primary" data-placement="top" title="Edit"><i class="fa fa-eye"></i></a>
                            <a onclick="cetak_akun('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Akun"><i class="fa fa-id-card"></i></a>
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->mahasiswa->countAll(),
                'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->mahasiswa->find($this->request->getVar('id'));

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
                        
                        if($this->mahasiswa->save($record)){
                            echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil disimpan."));
                        }else{
                            echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "User berhasil disimpan, data dosen gagal disimpan."));
                        }
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal disimpan."));
                    }
    
                }
            }else{
                $dt = $this->mahasiswa->find($this->request->getVar('id_dosen'));// ambil data
                
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
                    if($this->mahasiswa->save($record)){
                        
                        echo json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                        
                    }else{
                        echo json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));
    
                    }
    
                }
            }
            
            
        }
        
    }

    public function ekspor()
    {
        
        $list_id = $this->request->getVar('id');
		$data 				= [];
		foreach ($list_id as $id ) {
		    $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $id]);
		    $data_pmb = getDataRow('db_pmb', ['id' => $id]);
		    $data_ortu = getDataRow('db_ortu_mhs', ['id' => $id]);
		    $data_his = getDataRow('histori_pddk', ['id_data_diri' => $id, 'jns_keluar' => NULL, 'status' => 'A']);
		    $data_user = getDataRow('users', ['username' => $data_diri['username']]);
			array_push($data, array(
				'NIM' => $data_his['NIM'],
				'Nama' => $data_diri['Nama_Lengkap'],
				'Tmp_Lahir' => $data_diri['Kota_Lhr'],
				'Tgl_Lahir' => date_YMD($data_diri['Tgl_Lhr']),
                'Jns_Kelamin' => $data_diri['Jenis_Kelamin'],
                'NIK' => $data_diri['No_KTP'],
                'Agama' => $data_diri['Agama'],
                'NISN' => $data_diri['NISN'],
                'mulai_smt' => $data_his['mulai_smt'],
                'tgl_masuk' => $data_his['tgl_masuk'],
                'jalan' => $data_diri['Alamat']." ".$data_diri['No_Rmh'],
                'Dusun' => $data_diri['Dusun'],
                'RT' => $data_diri['RT'],
                'RW' => $data_diri['RW'],
                'Desa' => $data_diri['Desa'],
                'Kec' => $data_diri['Kec'],
                'Kab' => $data_diri['Kab'],
                'Prov' => $data_diri['Prov'],
                'Kode_Pos' => $data_diri['Kode_Pos'],
                'Jenis_Domisili' => $data_diri['Jenis_Domisili'],
                'Transportasi' => $data_diri['Transportasi'],
                'No_HP' => $data_diri['No_HP'],
                'email' => $data_user['email'],
                'Penerima_KPS' => $data_diri['Penerima_KPS'],
                'No_KPS' => $data_diri['No_KPS'],
                'Nomor_KTP_Ayah' => $data_ortu['Nomor_KTP_Ayah'],
                'Nama_Ayah' => $data_ortu['Nama_Ayah'],
                'Tgl_Lhr_Ayah' => date_YMD($data_ortu['Tgl_Lhr_Ayah']),
                'Pendidikan_Terakhir_Ayah' => $data_ortu['Pendidikan_Terakhir_Ayah'],
                'Pekerjaan_Ayah' => $data_ortu['Pekerjaan_Ayah'],
                'Penghasilan_Ayah' => $data_ortu['Penghasilan_Ayah'],
                'Nomor_KTP_Ibu' => $data_ortu['Nomor_KTP_Ibu'],
                'Nama_Ibu' => $data_ortu['Nama_Ibu'],
                'Tgl_Lhr_Ibu' => date_YMD($data_ortu['Tgl_Lhr_Ibu']),
                'Pendidikan_Terakhir_Ibu' => $data_ortu['Pendidikan_Terakhir_Ibu'],
                'Pekerjaan_Ibu' => $data_ortu['Pekerjaan_Ibu'],
                'Penghasilan_Ibu' => $data_ortu['Penghasilan_Ibu'],
				'Prodi' => $data_his['Prodi'],
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
        
        $sheet->setCellValue('A1', "Data Mahasiswa Baru Tahun ". $this->request->getVar('th_masuk') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:BB1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NIM');
        $sheet->setCellValue('B3', 'Nama');
        $sheet->setCellValue('C3', 'Tempat Lahir');
        $sheet->setCellValue('D3', 'Tanggal Lahir');
        $sheet->setCellValue('E3', 'Jenis Kelamin');
        $sheet->setCellValue('F3', 'NIK');
        $sheet->setCellValue('G3', 'Agama');
        $sheet->setCellValue('H3', 'NIS');
        $sheet->setCellValue('I3', 'Jalur Pendaftaran');
        $sheet->setCellValue('J3', 'NPWP');
        $sheet->setCellValue('K3', 'Kewarganegaraan');
        $sheet->setCellValue('L3', 'Jenis Pendaftaran');
        $sheet->setCellValue('M3', 'Tanggal Masuk Kuliah');
        $sheet->setCellValue('N3', 'Mulai Semester');
        $sheet->setCellValue('O3', 'Jalan');
        $sheet->setCellValue('P3', 'RT');
        $sheet->setCellValue('Q3', 'RW');
        $sheet->setCellValue('R3', 'Dusun');
        $sheet->setCellValue('S3', 'Kelurahan');
        $sheet->setCellValue('T3', 'Kecamatan');
        $sheet->setCellValue('U3', 'Kode Pos');
        $sheet->setCellValue('V3', 'Jenis Tinggal');
        $sheet->setCellValue('W3', 'Alat Transportasi');
        $sheet->setCellValue('X3', 'Telp. Rumah');
        $sheet->setCellValue('Y3', 'No HP');
        $sheet->setCellValue('Z3', 'Email');
        $sheet->setCellValue('AA3', 'Terima KPS');
        $sheet->setCellValue('AB3', 'No KPS');
        $sheet->setCellValue('AC3', 'NIK Ayah');
        $sheet->setCellValue('AD3', 'Nama Ayah');
        $sheet->setCellValue('AE3', 'Tanggal Lahir Ayah');
        $sheet->setCellValue('AF3', 'Pendidikan Ayah');
        $sheet->setCellValue('AG3', 'Pekerjaan Ayah');
        $sheet->setCellValue('AH3', 'Penghasilan Ayah');
        $sheet->setCellValue('AI3', 'NIK Ibu');
        $sheet->setCellValue('AJ3', 'Nama Ibu');
        $sheet->setCellValue('AK3', 'Tanggal Lahir Ibu');
        $sheet->setCellValue('AL3', 'Pendidikan Ibu');
        $sheet->setCellValue('AM3', 'Pekerjaan Ibu');
        $sheet->setCellValue('AN3', 'Penghasilan Ibu');
        $sheet->setCellValue('AO3', 'Nama Wali');
        $sheet->setCellValue('AP3', 'Tanggal Lahir Wali');
        $sheet->setCellValue('AQ3', 'Pendidikan Wali');
        $sheet->setCellValue('AR3', 'Pekerjaan Wali');
        $sheet->setCellValue('AS3', 'Penghasilan Wali');
        $sheet->setCellValue('AT3', 'Kode Prodi');
        $sheet->setCellValue('AU3', 'Nama Prodi');
        $sheet->setCellValue('AV3', 'SKS Diakui');
        $sheet->setCellValue('AW3', 'Kode PT Asal');
        $sheet->setCellValue('AX3', 'Nama PT Asal');
        $sheet->setCellValue('AY3', 'Kode Prodi Asal');
        $sheet->setCellValue('AZ3', 'Nama Prodi Asal');
        $sheet->setCellValue('BA3', 'Jenis Pembiayaan');
        $sheet->setCellValue('BB3', 'Jumlah Biaya Masuk');
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
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);
        $sheet->getStyle('R3')->applyFromArray($style_col);
        $sheet->getStyle('S3')->applyFromArray($style_col);
        $sheet->getStyle('T3')->applyFromArray($style_col);
        $sheet->getStyle('U3')->applyFromArray($style_col);
        $sheet->getStyle('V3')->applyFromArray($style_col);
        $sheet->getStyle('W3')->applyFromArray($style_col);
        $sheet->getStyle('X3')->applyFromArray($style_col);
        $sheet->getStyle('Y3')->applyFromArray($style_col);
        $sheet->getStyle('Z3')->applyFromArray($style_col);
        $sheet->getStyle('AA3')->applyFromArray($style_col);
        $sheet->getStyle('AB3')->applyFromArray($style_col);
        $sheet->getStyle('AC3')->applyFromArray($style_col);
        $sheet->getStyle('AD3')->applyFromArray($style_col);
        $sheet->getStyle('AE3')->applyFromArray($style_col);
        $sheet->getStyle('AF3')->applyFromArray($style_col);
        $sheet->getStyle('AG3')->applyFromArray($style_col);
        $sheet->getStyle('AH3')->applyFromArray($style_col);
        $sheet->getStyle('AI3')->applyFromArray($style_col);
        $sheet->getStyle('AJ3')->applyFromArray($style_col);
        $sheet->getStyle('AK3')->applyFromArray($style_col);
        $sheet->getStyle('AL3')->applyFromArray($style_col);
        $sheet->getStyle('AM3')->applyFromArray($style_col);
        $sheet->getStyle('AN3')->applyFromArray($style_col);
        $sheet->getStyle('AO3')->applyFromArray($style_col);
        $sheet->getStyle('AP3')->applyFromArray($style_col);
        $sheet->getStyle('AQ3')->applyFromArray($style_col);
        $sheet->getStyle('AR3')->applyFromArray($style_col);
        $sheet->getStyle('AS3')->applyFromArray($style_col);
        $sheet->getStyle('AT3')->applyFromArray($style_col);
        $sheet->getStyle('AU3')->applyFromArray($style_col);
        $sheet->getStyle('AV3')->applyFromArray($style_col);
        $sheet->getStyle('AW3')->applyFromArray($style_col);
        $sheet->getStyle('AX3')->applyFromArray($style_col);
        $sheet->getStyle('AY3')->applyFromArray($style_col);
        $sheet->getStyle('AZ3')->applyFromArray($style_col);
        $sheet->getStyle('BA3')->applyFromArray($style_col);
        $sheet->getStyle('BB3')->applyFromArray($style_col);
        
        $sheet->getStyle('A3:BB3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa
            
          $sheet->setCellValue('A'.$numrow, $val['NIM']);
          $sheet->setCellValue('B'.$numrow, strtoupper(strtolower($val['Nama'])));
          $sheet->setCellValue('C'.$numrow, strtoupper(strtolower($val['Tmp_Lahir'])));
          $sheet->setCellValue('D'.$numrow, $val['Tgl_Lahir']);
          $sheet->setCellValue('E'.$numrow, $val['Jns_Kelamin']);
          $sheet->setCellValueExplicit('F'.$numrow, $val['NIK'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValue('G'.$numrow, $val['Agama']);
          $sheet->setCellValueExplicit('H'.$numrow, $val['NISN'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValue('I'.$numrow, "");
          $sheet->setCellValue('J'.$numrow, "");
          $sheet->setCellValue('K'.$numrow, "ID");
          $sheet->setCellValue('L'.$numrow, "");
          $sheet->setCellValue('M'.$numrow, $val['tgl_masuk']);
          $sheet->setCellValue('N'.$numrow, $val['mulai_smt']);
          $sheet->setCellValue('O'.$numrow, strtoupper(strtolower($val['jalan'])));
          $sheet->setCellValue('P'.$numrow, $val['RT']);
          $sheet->setCellValue('Q'.$numrow, $val['RW']);
          $sheet->setCellValue('R'.$numrow, strtoupper(strtolower($val['Dusun'])));
          $sheet->setCellValue('S'.$numrow, strtoupper(strtolower($val['Desa'])));
          $sheet->setCellValue('T'.$numrow, strtoupper(strtolower($val['Kec'])));
          $sheet->setCellValue('U'.$numrow, $val['Kode_Pos']);
          $sheet->setCellValue('V'.$numrow, $val['Jenis_Domisili']);
          $sheet->setCellValue('W'.$numrow, $val['Transportasi']);
          $sheet->setCellValue('X'.$numrow, "");
          $sheet->setCellValueExplicit('Y'.$numrow, $val['No_HP'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValue('Z'.$numrow, $val['email']);
          $sheet->setCellValue('AA'.$numrow, $val['Penerima_KPS']);
          $sheet->setCellValueExplicit('AB'.$numrow, $val['No_KPS'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValueExplicit('AC'.$numrow, $val['Nomor_KTP_Ayah'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValue('AD'.$numrow, strtoupper(strtolower($val['Nama_Ayah'])));
          $sheet->setCellValue('AE'.$numrow, $val['Tgl_Lhr_Ayah']);
          $sheet->setCellValue('AF'.$numrow, $val['Pendidikan_Terakhir_Ayah']);
          $sheet->setCellValue('AG'.$numrow, $val['Pekerjaan_Ayah']);
          $sheet->setCellValue('AH'.$numrow, $val['Penghasilan_Ayah']);
          $sheet->setCellValueExplicit('AI'.$numrow, $val['Nomor_KTP_Ibu'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $sheet->setCellValue('AJ'.$numrow, strtoupper(strtolower($val['Nama_Ibu'])));
          $sheet->setCellValue('AK'.$numrow, $val['Tgl_Lhr_Ibu']);
          $sheet->setCellValue('AL'.$numrow, $val['Pendidikan_Terakhir_Ibu']);
          $sheet->setCellValue('AM'.$numrow, $val['Pekerjaan_Ibu']);
          $sheet->setCellValue('AN'.$numrow, $val['Penghasilan_Ibu']);
          $sheet->setCellValue('AO'.$numrow, "");
          $sheet->setCellValue('AP'.$numrow, "");
          $sheet->setCellValue('AQ'.$numrow, "");
          $sheet->setCellValue('AR'.$numrow, "");
          $sheet->setCellValue('AS'.$numrow, "");
          $sheet->setCellValue('AT'.$numrow, getDataRow('prodi', ['singkatan' => $val['Prodi']])['kode_prodi_pddikti']);
          $sheet->setCellValue('AU'.$numrow, getDataRow('prodi', ['singkatan' => $val['Prodi']])['nm_prodi']);
          $sheet->setCellValue('AV'.$numrow, "");
          $sheet->setCellValue('AW'.$numrow, "");
          $sheet->setCellValue('AX'.$numrow, "");
          $sheet->setCellValue('AY'.$numrow, "");
          $sheet->setCellValue('AZ'.$numrow, "");
          $sheet->setCellValue('BA'.$numrow, "");
          $sheet->setCellValue('BB'.$numrow, "");
          
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
        $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('O'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('P'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('Q'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('R'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('S'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('T'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('U'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('V'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('W'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('X'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('Y'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('Z'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AA'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AB'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AC'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AD'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AE'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AF'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AG'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AH'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AI'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AJ'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AK'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AL'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AM'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AN'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AO'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AP'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AQ'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AR'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AS'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AT'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AU'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AV'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AW'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AX'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AY'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('AZ'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('BA'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('BB'.$numrow)->applyFromArray($style_row);
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
        $sheet->setTitle("Data Mahasiswa");
        $sheet->getStyle('A:BB')->getNumberFormat()->setFormatCode('@');
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-Mahasiswa-Tahun-'.$this->request->getVar('th_masuk');
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
}
