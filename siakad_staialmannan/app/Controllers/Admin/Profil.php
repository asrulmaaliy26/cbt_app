<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use Config\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;

class Profil extends BaseController
{
    protected $validation;
    protected DosenModel $dosen;
    protected MahasiswaModel $mahasiswa;
    protected string $halaman_controller;
    protected string $halaman_label;

    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->dosen = new DosenModel($request);
        $this->mahasiswa = new MahasiswaModel($request);
        $this->halaman_controller = "profil";
        $this->halaman_label = "Profil";
    }

    //Menampilkan Profil sendiri
    public function index()
    {
        $data = [];



        if ($this->request->getMethod(true) == 'POST') {
            if (session()->get('akun_level') === "Mahasiswa" || session()->get('akun_level') === "Mahasiswa Baru") {
            } else {
                $dt = $this->dosen->find($this->request->getVar('id_dosen')); // ambil data

                $aturan = [
                    'Nama_Dosen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama dosen wajib diisi!!'
                        ]
                    ],
                    'NIY' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'NIY wajib diisi!!'
                        ]
                    ],
                    'Status' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilih status dosen / kepegawaian!!'
                        ]
                    ]
                ];


                $file = $this->request->getFile('foto');
                if (!$this->validate($aturan)) {
                    echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                } else {
                    $foto = $dt['foto'];
                    if ($file->getName()) {
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace("'", "", $this->request->getVar('Nama_Dosen'));
                        $path = 'berkas_dosen/' . $nmFolder;
                        $foto = $path . '/' . $nm_foto;
                        $file->move($path, $nm_foto);
                        if ($dt['foto'] != 'assets/dist/img/no-pict.jpg' || $dt['foto'] != null) {
                            @unlink($dt['foto']);
                        }
                    }
                    $record = [
                        'id_dosen' => $dt['id_dosen'],
                        'gelar_depan' => $this->request->getVar('gelar_depan'),
                        'kewarganegaraan' => $this->request->getVar('kewarganegaraan'),
                        'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                        'Nama_Dosen' => $this->request->getVar('Nama_Dosen'),
                        'NIY' => $this->request->getVar('NIY'),
                        'TTL' => $this->request->getVar('TTL'),
                        'NIDN_NUPN' => $this->request->getVar('NIDN_NUPN'),
                        'Alamat' => $this->request->getVar('Alamat'),

                        'Alamat_Email'      => $this->request->getVar('Alamat_Email'),
                        'jenis_kelamin'     => $this->request->getVar('jenis_kelamin'),
                        'ibu_kandung'       => $this->request->getVar('ibu_kandung'),
                        'status_kawin'      => $this->request->getVar('status_kawin'),
                        'Agama'             => $this->request->getVar('Agama'),

                        'Pangkat_Gol_Ruang' => $this->request->getVar('Pangkat_Gol_Ruang'),
                        'Jabatan' => $this->request->getVar('Jabatan'),
                        'Status' => $this->request->getVar('Status'),
                        'Program_Studi' => $this->request->getVar('Program_Studi'),
                        'profil_sinta' => $this->request->getVar('profil_sinta'),
                        'tahun_tugas' => $this->request->getVar('tahun_tugas'),
                        'scholar' => $this->request->getVar('scholar'),
                        'foto' => $foto,
                    ];
                    if ($this->request->getVar('Nama_Dosen') != $dt['Nama_Dosen']) {
                        $userModel = new \App\Models\UserModel;
                        $update_user = [
                            'id' => getDataRow('users', ['username' => $dt['username']])['id'],
                            'nama_lengkap' => $this->request->getVar('Nama_Dosen')
                        ];
                        $userModel->save($update_user);
                    }

                    if ($foto != $dt['foto']) {
                        $userModel = new \App\Models\UserModel;
                        $update_user = [
                            'id' => getDataRow('users', ['username' => $dt['username']])['id'],
                            'foto_profil' => $foto
                        ];
                        $userModel->save($update_user);
                    }

                    if ($this->dosen->save($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal diupdate."));
                    }
                }
            }
        }

        log_message('debug', json_encode($data));

        if (session()->get('akun_level') === "Mahasiswa" || session()->get('akun_level') === "Mahasiswa Baru") {
            //$data = $this->mahasiswa->where('username', session()->get('akun_username'))->first();
            $db      = \Config\Database::connect('default');
            $builder = $db->table('db_ortu_mhs');
            $data = [];

            $data['mhs'] = $this->mahasiswa->where('username', session()->get('akun_username'))->first();
            $data['ortu'] = $builder->where(['id' => $data['mhs']['id']])->get()->getRowArray();
        } else {
            $data = $this->dosen->where('username', session()->get('akun_username'))->first();
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller", $data);
    }

    public function getDataDosen()
    {
        /*
        if(session()->get('akun_level') === "Mahasiswa" || session()->get('akun_level') === "Mahasiswa Baru" ){
		    $data = $this->mahasiswa->find($this->request->getVar('id'));
		}else{*/
        $data = $this->dosen->find($this->request->getVar('id'));
        //}

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    public function getDataMhs()
    {

        //if(session()->get('akun_level') === "Mahasiswa" || session()->get('akun_level') === "Mahasiswa Baru" ){
        $data = $this->mahasiswa->join('db_ortu_mhs', 'db_data_diri_mahasiswa.id=db_ortu_mhs.id', 'left')->find($this->request->getVar('id'));
        /*}else{
		    $data = $this->dosen->find($this->request->getVar('id'));
		}*/
        // dd($data);

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    public function dosen()
    {
        $data = [];



        if ($this->request->getMethod(true) == 'POST') {

            $dt = $this->dosen->find($this->request->getVar('id_dosen')); // ambil data

            $aturan = [
                'Nama_Dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama dosen wajib diisi!!'
                    ]
                ],
                'NIY' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NIY wajib diisi!!'
                    ]
                ],
                'Status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih status dosen / kepegawaian!!'
                    ]
                ]
            ];


            $file = $this->request->getFile('foto');
            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {
                $foto = $dt['foto'];
                if ($file->getName()) {
                    $nm_foto = $file->getRandomName();
                    $nmFolder    = str_replace("'", "", $this->request->getVar('Nama_Dosen'));
                    $path = 'berkas_dosen/' . $nmFolder;
                    $foto = $path . '/' . $nm_foto;
                    $file->move($path, $nm_foto);
                    if ($dt['foto'] != 'assets/dist/img/no-pict.jpg' || $dt['foto'] != null) {
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
                    'tahun_tugas' => $this->request->getVar('tahun_tugas'),
                    'scholar' => $this->request->getVar('scholar'),
                    'foto' => $foto,
                ];
                if ($this->request->getVar('Nama_Dosen') != $dt['Nama_Dosen']) {
                    $userModel = new \App\Models\UserModel;
                    $update_user = [
                        'id' => getDataRow('users', ['username' => $dt['username']])['id'],
                        'nama_lengkap' => $this->request->getVar('Nama_Dosen')
                    ];
                    $userModel->save($update_user);
                }

                if ($this->dosen->save($record)) {

                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal diupdate."));
                }
            }
        }

        $data = $this->dosen->find($this->request->getVar('id_dosen'));

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = "dosen";
        $data['metode']    = 'dosen';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    public function mahasiswa()
    {
        $db      = \Config\Database::connect('default');
        $builder = $db->table('db_ortu_mhs');
        $data = [];

        $data['mhs'] = $this->mahasiswa->find($this->request->getVar('id'));
        $data['ortu'] = $builder->where(['id' => $this->request->getVar('id')])->get()->getRowArray();
        // ================================
        // CEK DOSEN WALI
        // ================================
        if (
            empty($data['mhs']['dosen_wali']) ||
            trim($data['mhs']['dosen_wali']) === ''
        ) {
            $data['mhs']['dosen_wali'] = 'isi dosen wali anda .... ';
            // atau ganti dengan:
            // $data['mhs']['dosen_wali'] = 'Belum ditentukan';
        }
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = "mahasiswa";
        $data['metode']    = 'mahasiswa';
        // dd($data);

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }
    function update_foto_mhs()
    {
        if ($this->request->getMethod(true) == 'POST') {

            $dt = $this->mahasiswa->find($this->request->getVar('id_foto_data_diri')); // ambil data

            $aturan = [
                'Foto_Diri' => [
                    'rules' => 'uploaded[Foto_Diri]|is_image[Foto_Diri]|mime_in[Foto_Diri,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih foto yang akan diupload',
                        'is_image' => 'Yang Anda upload bukan gambar',
                        'mime_in' => 'Ekstensi file yang anda upload tidak diijinkan. Upload gambar dengan ekstensi jpg | jpeg | png'
                    ]
                ]
            ];


            $file = $this->request->getFile('Foto_Diri');
            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {
                $foto = $dt['Foto_Diri'];
                if ($file->getName()) {
                    $nm_foto = $file->getRandomName();
                    $nmFolder    = str_replace("'", "", $dt['Nama_Lengkap']);
                    $path = 'berkas_mahasiswa/' . $nmFolder;
                    $foto = $path . '/' . $nm_foto;
                    $file->move($path, $nm_foto);
                    if ($dt['Foto_Diri'] != 'assets/dist/img/no-pict.jpg' || $dt['Foto_Diri'] != null) {
                        @unlink($dt['Foto_Diri']);
                    }
                }
                $record = [
                    'id' => $dt['id'],

                    'Foto_Diri' => $foto,
                ];

                if ($foto != $dt['Foto_Diri']) {
                    $userModel = new \App\Models\UserModel;
                    $update_user = [
                        'id' => getDataRow('users', ['username' => $dt['username']])['id'],
                        'foto_profil' => $foto
                    ];
                    $userModel->save($update_user);
                }

                if ($this->mahasiswa->save($record)) {

                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal diupdate."));
                }
            }
        }
    }

    function update_data_diri_mhs()
    {
        if ($this->request->getMethod(true) == 'POST') {

            $dt = $this->mahasiswa->find($this->request->getVar('id_data_diri')); // ambil data

            if ($this->request->getVar('Penerima_KPS') == "1") { // cek value punya KKS
                $ruleNoKKS = 'required';
            } else {
                $ruleNoKKS = 'permit_empty';
            }
            if ($this->request->getVar('jns_tinggal') == 4 || $this->request->getVar('jns_tinggal') == 5 || $this->request->getVar('jns_tinggal') == 3 || $this->request->getVar('jns_tinggal') == 2 || $this->request->getVar('jns_tinggal') == 99) { // cek Jns Tinggal
                $ruleNoTelpDomisili = 'required';
                $ruleAlamatPondok = 'required';
            } else {
                $ruleNoTelpDomisili = 'permit_empty';
                $ruleAlamatPondok = 'permit_empty';
            }

            $aturan = [
                'Nama_Lengkap' => [
                    'rules' => 'required',
                ],
                'Jenis_Kelamin' => [
                    'rules' => 'required',
                ],
                'Kota_Lhr' => [
                    'rules' => 'required',
                ],
                'Tgl_Lhr' => [
                    'rules' => 'required',
                ],
                'Dusun' => [
                    'rules' => 'required',
                ],
                'Desa' => [
                    'rules' => 'required',
                ],
                'Kec' => [
                    'rules' => 'required',
                ],
                'Kab' => [
                    'rules' => 'required',
                ],
                'Kode_Pos' => [
                    'rules' => 'required',
                ],
                'Prov' => [
                    'rules' => 'required',
                ],
                'Jenis_Domisili' => [
                    'rules' => 'required',
                ],
                'No_KTP' => [
                    'rules' => 'required',
                ],
                'No_KK' => [
                    'rules' => 'required',
                ],
                'Agama' => [
                    'rules' => 'required',
                ],
                'Kewarganegaraan' => [
                    'rules' => 'required',
                ],
                'Status_Perkawinan' => [
                    'rules' => 'required',
                ],
                'Pekerjaan' => [
                    'rules' => 'required',
                ],
                'Biaya_ditanggung' => [
                    'rules' => 'required',
                ],
                'Transportasi' => [
                    'rules' => 'required',
                ],
                'Status_Asal_Sekolah' => [
                    'rules' => 'required',
                ],
                'Nama_Lengkap_SLTA_Asal' => [
                    'rules' => 'required',
                ],
                'Jenis_SLTA' => [
                    'rules' => 'required',
                ],
                'Kejuruan_SLTA' => [
                    'rules' => 'required',
                ],
                'Alamat_Lengkap_Sekolah_Asal' => [
                    'rules' => 'required',
                ],
                'Th_Lulus_SLTA' => [
                    'rules' => 'required',
                ],
                // 'NISN' => [
                //     'rules' => 'required',
                // ],
                'No_HP' => [
                    'rules' => 'required',
                ],
                // 'Email' => [
                //     'rules' => 'required',
                // ],
                'Penerima_KPS' => [
                    'rules' => 'required',
                ],
                'No_KPS' => [
                    'rules' => $ruleNoKKS,
                ],
                'Tempat_Domisili' => [
                    'rules' => $ruleAlamatPondok,
                ],
                'No_Telp_Hp' => [
                    'rules' => $ruleNoTelpDomisili,
                ],
                'Nama_Ayah' => [
                    'rules' => 'required',
                ],
                'Tempat_Lhr_Ayah' => [
                    'rules' => 'required',
                ],
                'Tgl_Lhr_Ayah' => [
                    'rules' => 'required',
                ],
                'Agama_Ayah' => [
                    'rules' => 'required',
                ],
                'Pendidikan_Terakhir_Ayah' => [
                    'rules' => 'required',
                ],
                'Pekerjaan_Ayah' => [
                    'rules' => 'required',
                ],
                'Penghasilan_Ayah' => [
                    'rules' => 'required',
                ],
                'Nomor_KTP_Ayah' => [
                    'rules' => 'required',
                ],
                'Desa_Ayah' => [
                    'rules' => 'required',
                ],
                'Kec_Ayah' => [
                    'rules' => 'required',
                ],
                'Kab_Ayah' => [
                    'rules' => 'required',
                ],
                'Kode_Pos_Ayah' => [
                    'rules' => 'required',
                ],
                'Prov_Ayah' => [
                    'rules' => 'required',
                ],
                'Kewarganegaraan_Ayah' => [
                    'rules' => 'required',
                ],
                'Nama_Ibu' => [
                    'rules' => 'required',
                ],
                'Tempat_Lhr_Ibu' => [
                    'rules' => 'required',
                ],
                'Tgl_Lhr_Ibu' => [
                    'rules' => 'required',
                ],
                'Agama_Ibu' => [
                    'rules' => 'required',
                ],
                'Pendidikan_Terakhir_Ibu' => [
                    'rules' => 'required',
                ],
                'Pekerjaan_Ibu' => [
                    'rules' => 'required',
                ],
                'Penghasilan_Ibu' => [
                    'rules' => 'required',
                ],
                'Nomor_KTP_Ibu' => [
                    'rules' => 'required',
                ],
                'Desa_Ibu' => [
                    'rules' => 'required',
                ],
                'Kec_Ibu' => [
                    'rules' => 'required',
                ],
                'Kab_Ibu' => [
                    'rules' => 'required',
                ],
                'Kode_Pos_Ibu' => [
                    'rules' => 'required',
                ],
                'Prov_Ibu' => [
                    'rules' => 'required',
                ],
                'Kewarganegaraan_Ibu' => [
                    'rules' => 'required',
                ],
            ];


            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {

                $record_data_diri = [
                    'id' => $this->request->getVar('id_data_diri'),
                    'Nama_Lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'Jenis_Kelamin' => $this->request->getVar('Jenis_Kelamin'),
                    'Gol_Darah' => $this->request->getVar('Gol_Darah'),
                    'Kota_Lhr' => $this->request->getVar('Kota_Lhr'),
                    'Tgl_Lhr' => $this->request->getVar('Tgl_Lhr'),
                    'Alamat' => $this->request->getVar('Alamat'),
                    'No_Rmh' => $this->request->getVar('No_Rmh'),
                    'Dusun' => $this->request->getVar('Dusun'),
                    'RT' => $this->request->getVar('RT'),
                    'RW' => $this->request->getVar('RW'),
                    'Desa' => $this->request->getVar('Desa'),
                    'Kec' => $this->request->getVar('Kec'),
                    'Kab' => $this->request->getVar('Kab'),
                    'Kode_Pos' => $this->request->getVar('Kode_Pos'),
                    'Prov' => $this->request->getVar('Prov'),
                    'Tempat_Domisili' => $this->request->getVar('Tempat_Domisili'),
                    'Jenis_Domisili' => $this->request->getVar('Jenis_Domisili'),
                    'No_Telp_Hp' => $this->request->getVar('No_Telp_Hp'),
                    'no_wa' => $this->request->getVar('no_wa'),
                    'No_KTP' => $this->request->getVar('No_KTP'),
                    'No_KK' => $this->request->getVar('No_KK'),
                    'Agama' => $this->request->getVar('Agama'),
                    'Kewarganegaraan' => $this->request->getVar('Kewarganegaraan'),
                    'Kode_Negara' => $this->request->getVar('Kode_Negara'),
                    'Status_Perkawinan' => $this->request->getVar('Status_Perkawinan'),
                    'Pekerjaan' => $this->request->getVar('Pekerjaan'),
                    'Biaya_ditanggung' => $this->request->getVar('Biaya_ditanggung'),
                    'Transportasi' => $this->request->getVar('Transportasi'),
                    'Status_Asal_Sekolah' => $this->request->getVar('Status_Asal_Sekolah'),
                    'Nama_Lengkap_SLTA_Asal' => $this->request->getVar('Nama_Lengkap_SLTA_Asal'),
                    'Jenis_SLTA' => $this->request->getVar('Jenis_SLTA'),
                    'Kejuruan_SLTA' => $this->request->getVar('Kejuruan_SLTA'),
                    'Alamat_Lengkap_Sekolah_Asal' => $this->request->getVar('Alamat_Lengkap_Sekolah_Asal'),
                    'Th_Lulus_SLTA' => $this->request->getVar('Th_Lulus_SLTA'),
                    'No_Seri_Ijazah_SLTA' => $this->request->getVar('No_Seri_Ijazah_SLTA'),
                    'NISN' => $this->request->getVar('NISN'),
                    'Anak_Ke' => $this->request->getVar('Anak_Ke'),
                    'Jml_Saudara' => $this->request->getVar('Jml_Saudara'),
                    'No_HP' => $this->request->getVar('No_HP'),
                    'Email' => $this->request->getVar('Email'),
                    'Penerima_KPS' => $this->request->getVar('Penerima_KPS'),
                    'No_KPS' => $this->request->getVar('No_KPS'),
                    'dosen_wali' => $this->request->getVar('dosen_wali'),

                ];

                $record_data_ortu = [
                    'Nama_Ayah' => $this->request->getVar('Nama_Ayah'),
                    'Tempat_Lhr_Ayah' => $this->request->getVar('Tempat_Lhr_Ayah'),
                    'Tgl_Lhr_Ayah' => $this->request->getVar('Tgl_Lhr_Ayah'),
                    'Agama_Ayah' => $this->request->getVar('Agama_Ayah'),
                    'Gol_Darah_Ayah' => $this->request->getVar('Gol_Darah_Ayah'),
                    'Pendidikan_Terakhir_Ayah' => $this->request->getVar('Pendidikan_Terakhir_Ayah'),
                    'Pekerjaan_Ayah' => $this->request->getVar('Pekerjaan_Ayah'),
                    'Penghasilan_Ayah' => $this->request->getVar('Penghasilan_Ayah'),
                    'Kebutuhan_Khusus_Ayah' => $this->request->getVar('Kebutuhan_Khusus_Ayah'),
                    'Nomor_KTP_Ayah' => $this->request->getVar('Nomor_KTP_Ayah'),
                    'Alamat_Ayah' => $this->request->getVar('Alamat_Ayah'),
                    'No_Rmh_Ayah' => $this->request->getVar('No_Rmh_Ayah'),
                    'Dusun_Ayah' => $this->request->getVar('Dusun_Ayah'),
                    'RT_Ayah' => $this->request->getVar('RT_Ayah'),
                    'RW_Ayah' => $this->request->getVar('RW_Ayah'),
                    'Desa_Ayah' => $this->request->getVar('Desa_Ayah'),
                    'Kec_Ayah' => $this->request->getVar('Kec_Ayah'),
                    'Kab_Ayah' => $this->request->getVar('Kab_Ayah'),
                    'Kode_Pos_Ayah' => $this->request->getVar('Kode_Pos_Ayah'),
                    'Prov_Ayah' => $this->request->getVar('Prov_Ayah'),
                    'Kewarganegaraan_Ayah' => $this->request->getVar('Kewarganegaraan_Ayah'),
                    'Nama_Ibu' => $this->request->getVar('Nama_Ibu'),
                    'Tempat_Lhr_Ibu' => $this->request->getVar('Tempat_Lhr_Ibu'),
                    'Tgl_Lhr_Ibu' => $this->request->getVar('Tgl_Lhr_Ibu'),
                    'Agama_Ibu' => $this->request->getVar('Agama_Ibu'),
                    'Gol_Darah_Ibu' => $this->request->getVar('Gol_Darah_Ibu'),
                    'Pendidikan_Terakhir_Ibu' => $this->request->getVar('Pendidikan_Terakhir_Ibu'),
                    'Pekerjaan_Ibu' => $this->request->getVar('Pekerjaan_Ibu'),
                    'Penghasilan_Ibu' => $this->request->getVar('Penghasilan_Ibu'),
                    'Kebutuhan_Khusus_Ibu' => $this->request->getVar('Kebutuhan_Khusus_Ibu'),
                    'Nomor_KTP_Ibu' => $this->request->getVar('Nomor_KTP_Ibu'),
                    'Alamat_Ibu' => $this->request->getVar('Alamat_Ibu'),
                    'No_Rmh_Ibu' => $this->request->getVar('No_Rmh_Ibu'),
                    'Dusun_Ibu' => $this->request->getVar('Dusun_Ibu'),
                    'RT_Ibu' => $this->request->getVar('RT_Ibu'),
                    'RW_Ibu' => $this->request->getVar('RW_Ibu'),
                    'Desa_Ibu' => $this->request->getVar('Desa_Ibu'),
                    'Kec_Ibu' => $this->request->getVar('Kec_Ibu'),
                    'Kab_Ibu' => $this->request->getVar('Kab_Ibu'),
                    'Kode_Pos_Ibu' => $this->request->getVar('Kode_Pos_Ibu'),
                    'Prov_Ibu' => $this->request->getVar('Prov_Ibu'),
                    'Kewarganegaraan_Ibu' => $this->request->getVar('Kewarganegaraan_Ibu')

                ];

                if ($this->request->getVar('Nama_Lengkap') != $dt['Nama_Lengkap']) {
                    $userModel = new \App\Models\UserModel;
                    $update_user = [
                        'id' => getDataRow('users', ['username' => $dt['username']])['id'],
                        'nama_lengkap' => $this->request->getVar('Nama_Lengkap')
                    ];
                    $userModel->save($update_user);
                }

                if ($this->mahasiswa->save($record_data_diri)) {
                    $db      = \Config\Database::connect('default');
                    $builder = $db->table('db_ortu_mhs');
                    $builder->where(['id' => $this->request->getVar('id_data_diri')])->update($record_data_ortu);
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal diupdate."));
                }
            }
        }
    }

    public function getDataHisPdk()
    {
        $HistoriModel = new \App\Models\HistoriPddkModel($this->request);
        $data = $HistoriModel->find($this->request->getVar('id_his_pdk'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    public function loadHisPdk()
    {
        $ModelHisPdk = new \App\Models\HistoriPddkModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $ModelHisPdk->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            $taAktif = intval(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']);
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->NIM;
                $row[] = getDataRow('ref_option', ['opt_group' => 'jns_pendaftaran', 'opt_id' => $list->jns_daftar])['opt_val'];
                $row[] = (!empty(getDataRow('tahun_akademik', ['kode' => $list->mulai_smt]))) ? getDataRow('tahun_akademik', ['kode' => $list->mulai_smt])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->mulai_smt])['semester'] == '1' ? 'Gasal' : 'Genap') : '';
                $row[] = $list->tgl_masuk;
                $row[] = $list->Prodi;
                $row[] = $list->Program;
                $row[] = $list->Kelas;
                $row[] = getDataRow('ref_option', ['opt_group' => 'status_mhs', 'opt_id' => $list->status])['opt_val'];
                if (session()->get('akun_level') == 'Admin') {
                    $row[] = '
                            <a onclick="hapus_his_pdk(' . "'" . $list->id_his_pdk . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit_his_pdk(' . "'" . $list->id_his_pdk . "'" . '); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }


    public function generate_nim()
    {
        $ModelHisPdk = new \App\Models\HistoriPddkModel($this->request);
        if ($this->request->getMethod(true) == 'POST') {
            $aturan = [
                'mulai_smt' => [
                    'rules' => 'required',

                ],
                'Prodi' => [
                    'rules' => 'required',
                ]
            ];

            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Tahun masuk dan Prodi tidak boleh kosong!!"));
            } else {
                $prodi = $this->request->getVar('Prodi');
                $tahun = substr($this->request->getVar('mulai_smt'), 2, 2);
                $kodeProdi = getDataRow('prodi', ['singkatan' => $prodi])['kode_prodi_kop'];
                $kodeFak = getDataRow('prodi', ['singkatan' => $prodi])['kode_fak'];
                $NimTerakhir = $ModelHisPdk->select('MAX(RIGHT(NIM,5)) as no_max', FALSE)->where('Prodi', $prodi)->notLike('NIM', $prodi, 'after')->get();
                if ($NimTerakhir->getNumRows() > 0) {
                    foreach ($NimTerakhir->getResult() as $key) {
                        $no_urut = '';
                        //$ambilData = substr($key->no_max, -4);
                        $increment = intval($key->no_max) + 1;
                        $no_urut = sprintf('%05s', $increment);
                    }
                } else {
                    $no_urut = '00001';
                }
                $nim      = $tahun . "126" . $kodeFak . $kodeProdi . $no_urut;

                echo json_encode(array("status" => true, "msg" => "success", "pesan" => "NIM yang baru adalah " . $nim, "nim" => $nim));
            }
        }
    }

    function simpan_histori_pddk()
    {
        $ModelHisPdk = new \App\Models\HistoriPddkModel($this->request);
        if ($this->request->getMethod() == "post") {
            $aturan = [
                'mulai_smt' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Periode pendaftaran harus diisi'
                    ]
                ],
                'jns_daftar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis pendaftaran harus diisi'
                    ]
                ],
                'tgl_masuk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal masuk harus diisi'
                    ]
                ],
                'Program' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Program harus diisi'
                    ]
                ],
                'Prodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Prodi harus diisi'
                    ]
                ],
                'Kelas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kelas harus diisi'
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'status harus diisi'
                    ]
                ]

            ];
            if (empty($this->request->getVar('id_his_pdk'))) {

                if (!$this->validate($aturan)) {

                    echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan dimasukkan!!"));
                } else {

                    $record = [
                        'mulai_smt' => $this->request->getVar('mulai_smt'),
                        'jns_daftar' => $this->request->getVar('jns_daftar'),
                        'tgl_masuk' => $this->request->getVar('tgl_masuk'),
                        'Program' => $this->request->getVar('Program'),
                        'Prodi' => $this->request->getVar('Prodi'),
                        'Kelas' => $this->request->getVar('Kelas'),
                        'status' => $this->request->getVar('status'),
                        'id_data_diri' => $this->request->getVar('id_data_diri'),
                        'NIM' => $this->request->getVar('NIM'),
                        'nm_pt_asal' => $this->request->getVar('nm_pt_asal'),
                        'nm_prodi_asal' => $this->request->getVar('nm_prodi_asal'),
                        'sks_diakui' => $this->request->getVar('sks_diakui'),
                    ];
                    //dd($record);

                    if ($ModelHisPdk->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Histori pendidikan berhasil disimpan.", "id_data_diri" => $this->request->getVar('id_data_diri')));
                    } else {
                        echo json_encode(array("status" => false, "msg" => "error", "pesan" => "Histori pendidikan gagal disimpan.", "id_data_diri" => $this->request->getVar('id_data_diri')));
                    }
                }
            } else {
                $HisPdk = $ModelHisPdk->find($this->request->getVar('id_his_pdk')); // ambil data


                if (!$this->validate($aturan)) {

                    echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan dimasukkan!!"));
                } else {

                    $record = [
                        'id_his_pdk' => $HisPdk['id_his_pdk'],
                        'mulai_smt' => $this->request->getVar('mulai_smt'),
                        'jns_daftar' => $this->request->getVar('jns_daftar'),
                        'tgl_masuk' => $this->request->getVar('tgl_masuk'),
                        'Program' => $this->request->getVar('Program'),
                        'Prodi' => $this->request->getVar('Prodi'),
                        'Kelas' => $this->request->getVar('Kelas'),
                        'status' => $this->request->getVar('status'),
                        'id_data_diri' => $this->request->getVar('id_data_diri'),
                        'NIM' => $this->request->getVar('NIM'),
                        'nm_pt_asal' => $this->request->getVar('nm_pt_asal'),
                        'nm_prodi_asal' => $this->request->getVar('nm_prodi_asal'),
                        'sks_diakui' => $this->request->getVar('sks_diakui'),
                        'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                        'sk_yudisium' => $this->request->getVar('sk_yudisium'),
                        'tgl_sk_yudisium' => $this->request->getVar('tgl_sk_yudisium'),
                        'jns_keluar' => (!empty($this->request->getVar('jns_keluar'))) ? $this->request->getVar('jns_keluar') : NULL,
                        'keluar_smt' => $this->request->getVar('keluar_smt'),
                        'ket' => $this->request->getVar('ket'),
                    ];

                    if ($ModelHisPdk->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Histori pendidikan berhasil diupdate.", "id_data_diri" => $this->request->getVar('id_data_diri')));
                    } else {
                        echo json_encode(array("status" => false, "msg" => "error", "pesan" => "Histori pendidikan gagal diupdate.", "id_data_diri" => $this->request->getVar('id_data_diri')));
                    }
                }
            }
        }
    }

    function hapus_his_pdk()
    {
        $ModelHisPdk = new \App\Models\HistoriPddkModel($this->request);
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('id_his_pdk')) {
                $NilaiModel = new \App\Models\NilaiModel($this->request);
                $cekDataNilai = $NilaiModel->where('id_his_pdk', $this->request->getVar('id_his_pdk'))->findAll();
                $dt = $ModelHisPdk->find($this->request->getVar('id_his_pdk'));
                if (empty($cekDataNilai)) {
                    if ($dt['id_his_pdk']) { #memastikan ada data
                        $aksi = $ModelHisPdk->delete($this->request->getVar('id_his_pdk'));
                        if ($aksi == true) {
                            return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil dihapus.", "id_data_diri" => $dt['id_data_diri']));
                        } else {
                            return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal dihapus.", "id_data_diri" => $dt['id_data_diri']));
                        }
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data tidak ditemukan.", "id_data_diri" => $dt['id_data_diri']));
                    }
                } else {
                    return json_encode(array("status" => false, "msg" => "warning", "pesan" => "Data ini tidak dapat dihapus karena terhubung dengan data nilai. silahkan periksa terlebih dahulu.", "id_data_diri" => $dt['id_data_diri']));
                }
            }
        }
    }

    function loadProdiHisPdk()
    {
        $HistoriModel = new \App\Models\HistoriPddkModel($this->request);
        echo "<option ></option>";
        $id_data_diri = $this->request->getVar('id_data_diri');
        $data = $HistoriModel->where(['id_data_diri' => $id_data_diri])->findAll();

        foreach ($data as $row => $val) {
            echo "<option value='" . $val['id_his_pdk'] . "'>" . $val['Prodi'] . " - " . $val['Program'] . " - " . $val['Kelas'] . "</option>";
        }
    }

    function loadSMTNilai()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        echo "<option ></option>";
        $id_his_pdk = $this->request->getVar('id_his_pdk');
        $data = $NilaiModel->where(['id_his_pdk' => $id_his_pdk])->groupBy('smt_mhs')->orderBy('smt_mhs ASC')->findAll();

        foreach ($data as $row => $val) {
            echo "<option value='" . $val['smt_mhs'] . "'>SMT " . $val['smt_mhs'] . "</option>";
        }
    }

    public function loadNilai()
    {

        $NilaiModel = new \App\Models\NilaiModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $NilaiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;

                $row[] = $list->kode_mk_feeder;

                //$row[] = (!empty(getDataRow('mata_kuliah', ['Kode_MK_Feeder' => $list->kode_mk_feeder])))?getDataRow('mata_kuliah', ['Kode_MK_Feeder' => $list->kode_mk_feeder])['Mata_Kuliah']:$list->kode_mk_feeder;
                $row[] = (!empty(getDataRow('master_matakuliah', ['kode_mk' => $list->kode_mk_feeder]))) ? getDataRow('master_matakuliah', ['kode_mk' => $list->kode_mk_feeder])['nama_mk'] : $list->kode_mk_feeder;
                $row[] = $list->smt_mhs;
                if (session()->get('akun_level') != "Admin") {
                    $row[] = number_format(floatval($list->Nilai_UTS), 2);
                    $row[] = number_format(floatval($list->Nilai_TGS), 2);
                    $row[] = number_format(floatval($list->Nilai_UAS), 2);
                    $row[] = number_format(floatval($list->Nilai_Performance), 2);
                }
                if (session()->get('akun_level') == "Admin") {
                    $row[] = '<input type="number"  step=".01" min="3.10" max="4.00" name="nilai_uts[]" id="uts' . $list->id_ljk . '" class="form-control form-control-sm" onfocusout="simpan_uts(' . "'" . $list->id_ljk . "'" . ')" value="' . number_format($list->Nilai_UTS, 2) . '"/>';
                    $row[] = '<input type="number" step=".01" min="3.10" max="4.00" name="nilai_tugas[]" id="tugas' . $list->id_ljk . '" class="form-control form-control-sm" onfocusout="simpan_tugas(' . "'" . $list->id_ljk . "'" . ')" value="' . number_format($list->Nilai_TGS, 2) . '"/>';
                    $row[] = '<input type="number"  step=".01" min="3.10" max="4.00" name="nilai_uas[]" id="uas' . $list->id_ljk . '" class="form-control form-control-sm" onfocusout="simpan_uas(' . "'" . $list->id_ljk . "'" . ')" value="' . number_format($list->Nilai_UAS, 2) . '"/>';
                    $row[] = '<input type="number" step=".01" min="3.10" max="4.00" name="nilai_p[]" id="p' . $list->id_ljk . '" class="form-control form-control-sm" onfocusout="simpan_p(' . "'" . $list->id_ljk . "'" . ')" value="' . number_format($list->Nilai_Performance, 2) . '"/>';
                }
                $row[] = number_format(floatval($list->Nilai_Akhir), 2);
                $row[] = $list->Nilai_Huruf;
                $row[] = $list->Status_Nilai;
                if (session()->get('akun_level') == "Admin") {
                    $row[] = '<a onclick="transfer_nilai(' . "'" . $list->id_ljk . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Transfer nilai ke Histori Pendidikan baru"><i class="fa fa-sync"></i></a>
                            <a onclick="hapus_nilai(' . "'" . $list->id_ljk . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Nilai"><i class="fa fa-trash"></i></a>
                            <a onclick="reset_nilai(' . "'" . $list->id_ljk . "'" . '); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Reset Nilai"><i class="fa fa-undo"></i></a>
                        ';
                }

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    function simpan_uts()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $Nilai_UTS = $this->request->getVar('nilai_uts');
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai_uts' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]',
                    'errors' => [
                        'required' => 'Nilai UTS tidak boleh kosong!!',
                        'decimal' => 'Nilai UTS harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UTS tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UTS tidak boleh kurang dari 3.1'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UTS !!"));
            } else {

                $Nilai_Akhir = number_format((($Nilai_UTS * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai =  dataDinamis('grade_nilai');
                if ($Nilai_UTS == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UTS' => $Nilai_UTS,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UTS' => $Nilai_UTS,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai UTS berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai UTS gagal disimpan"));
                }
            }
        }
    }

    function simpan_tugas()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $Nilai_Tugas = $this->request->getVar('nilai');
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]',
                    'errors' => [
                        'required' => 'Nilai Tugas tidak boleh kosong!!',
                        'decimal' => 'Nilai Tugas harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Tugas tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Tugas tidak boleh kurang dari 3.1'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Tugas !!"));
            } else {

                $Nilai_Akhir = number_format((($Uts * 20) + ($Nilai_Tugas * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai =  dataDinamis('grade_nilai');
                if ($Uts == 0 or $Nilai_Tugas == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_TGS' => $Nilai_Tugas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_TGS' => $Nilai_Tugas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai Tugas berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai Tugas gagal disimpan"));
                }
            }
        }
    }

    function simpan_uas()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $Uas = $this->request->getVar('nilai');
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]',
                    'errors' => [
                        'required' => 'Nilai UAS tidak boleh kosong!!',
                        'decimal' => 'Nilai UAS harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UAS tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UAS tidak boleh kurang dari 3.1'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UAS !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Uts * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai =  dataDinamis('grade_nilai');
                if ($Uts == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UAS' => $Uas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UAS' => $Uas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai UAS berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai UAS gagal disimpan"));
                }
                //}
            }
        }
    }

    function simpan_p()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $perf = $this->request->getVar('nilai');
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $aturan = [
                'nilai' => [
                    'rules' => 'required|decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]',
                    'errors' => [
                        'required' => 'Nilai Performance tidak boleh kosong!!',
                        'decimal' => 'Nilai Performance harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Performance tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Performance tidak boleh kurang dari 3.1'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Performance !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Uts * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai =  dataDinamis('grade_nilai');
                if ($Uts == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_Performance' => $perf,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_Performance' => $perf,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai Performance berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai Performance gagal disimpan"));
                }
                //}
            }
        }
    }

    function transfer_nilai()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $ljk_lama = getDataRow('data_ljk', ['id_ljk' => $this->request->getVar('id_ljk_lama')]);
            $mk_transfer = getDataRow('mata_kuliah', ['id' => $this->request->getVar('m')]);
            $historiPddk = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('prodi')]);
            $record = [
                'id_mk' => $mk_transfer['id'],
                't_akad' => $mk_transfer['Kd_Tahun'],
                'kd_kelas' => $mk_transfer['kode_kelas'],
                'kd_kelas_perkuliahan' => $mk_transfer['kd_kelas_perkuliahan'],
                'id_matkul_kurikulum' => $mk_transfer['id_matkul_kurikulum'],
                "id_his_pdk" => $this->request->getVar('prodi'),
                "nim" => $historiPddk['NIM'],
                "smt_mhs" => $mk_transfer['SMT'],
                "prodi_mhs" => $historiPddk['Prodi'],
                "kelas_mhs" => $mk_transfer['Kelas'],
                "kode_mk_feeder" => $mk_transfer['Kode_MK_Feeder'],
                "sks" => $mk_transfer['SKS'],
                "Nilai_UTS" => $ljk_lama['Nilai_UTS'] == '' ? NULL : $ljk_lama['Nilai_UTS'],
                "Nilai_TGS" => $ljk_lama['Nilai_TGS'] == '' ? NULL : $ljk_lama['Nilai_TGS'],
                "Nilai_UAS" => $ljk_lama['Nilai_UAS'] == '' ? NULL : $ljk_lama['Nilai_UAS'],
                "Nilai_Performance" => $ljk_lama['Nilai_Performance'] == '' ? NULL : $ljk_lama['Nilai_Performance'],
                "Nilai_Akhir" => $ljk_lama['Nilai_Akhir'] == '' ? NULL : $ljk_lama['Nilai_Akhir']/*$Nilai_Akhir*/,
                "Nilai_Huruf" => $ljk_lama['Nilai_Huruf']/*$Nilai_Huruf*/,
                "Status_Nilai" => $ljk_lama['Status_Nilai']/*$Status_Nilai*/,
                "Rekom_Nilai" => $ljk_lama['Rekom_Nilai']/*$Rekom_Nilai*/,
                "transfer" => 1
            ];
            if ($NilaiModel->simpanData($record)) {
                return json_encode(array("msg" => 'success'));
            } else {
                return json_encode(array("msg" => 'error'));
            }
        }

        if ($this->request->getVar('id_ljk')) {
            $data = $NilaiModel->find($this->request->getVar('id_ljk'));
        }

        $data['templateJudul'] = "Transfer Nilai";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'transfer_nilai';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function form_tambah_nilai()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            if (empty($this->request->getVar('id_mk'))) {
                echo json_encode(array("msg" => "warning", "pesan" => "Pilih Matakuliah!!"));
            } else {
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                $id_his_pdk           = $this->request->getVar('id_his_pdk');
                foreach ($this->request->getVar('id_mk') as $key) {
                    $dtMk = getDataRow('mata_kuliah', ['id' => $key]);
                    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri'];

                    $record_mk = [
                        'id_mk' => $key,
                        't_akad' => $dtMk['Kd_Tahun'],
                        'kd_kelas' => $dtMk['kode_kelas'],
                        'kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan'],
                        'id_matkul_kurikulum' => $dtMk['id_matkul_kurikulum'],
                        "id_his_pdk" => $id_his_pdk,
                        "nim" => getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['NIM'],
                        "smt_mhs" => $dtMk['SMT'],
                        "prodi_mhs" => getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'],
                        "kelas_mhs" => getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['kelas'],
                        "kode_mk_feeder" => $dtMk['Kode_MK_Feeder'],
                        "sks" => $dtMk['SKS'],
                    ];

                    if ($NilaiModel->simpanData($record_mk)) {
                        $jmlSukses++;
                    } else {
                        $jmlError++;
                        $listError[] = [
                            'pesan'     => $dtMk['Mata_Kuliah'] . " gagal disimpan."
                        ];
                    };
                }


                if ($jmlError > 0) {
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses . " Histori nilai berhasil disimpan, " . $jmlError . " gagal disimpan.", 'listError' => $listError));
                } else {
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses . " Histori nilai berhasil disimpan."));
                }
            }
        }

        if ($this->request->getVar('id_his_pdk')) {
            $data = getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')]);
        }

        $data['templateJudul'] = "Formulir Tambah Nilai Yang Belum Ditempuh / Transfer Nilai";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'form_tambah_nilai';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    private function set_key_data($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->Kode_MK_Feeder] = $detail;
        }

        return $return;
    }

    private function set_key_data_ljk($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->kode_mk_feeder] = $detail;
        }

        return $return;
    }

    function listMatkul()
    {
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $mk_distribusi = $DistribusiMkModel->getDatatables();
            $mk_nilai = $NilaiModel->getDatatables();

            $result_mk_distribusi = $this->set_key_data($mk_distribusi);
            $result_mk_nilai = $this->set_key_data_ljk($mk_nilai);

            foreach ($result_mk_distribusi as $index => $item) {
                if (isset($result_mk_nilai[$index]))
                    unset($result_mk_distribusi[$index]);
            }

            $lists = array_values($result_mk_distribusi);

            //$lists = $DistribusiMkModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_kurikulum;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="' . $list->id . '" />';
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Prodi;
                $row[] = $list->Kelas;
                $row[] = $list->SMT;
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->distribusi->countAll(),
                //'recordsFiltered' => $this->distribusi->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    function hapus_nilai()
    {

        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('id_ljk')) {
                $NilaiModel = new \App\Models\NilaiModel($this->request);
                $cekDataNilai = $NilaiModel->find($this->request->getVar('id_ljk'));
                if ($cekDataNilai) {
                    $aksi = $NilaiModel->delete($this->request->getVar('id_ljk'));
                    if ($aksi == true) {
                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil dihapus."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal dihapus."));
                    }
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data tidak ditemukan."));
                }
            }
        }
    }
    function reset_nilai()
    {

        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('id_ljk')) {
                $NilaiModel = new \App\Models\NilaiModel($this->request);
                $cekDataNilai = $NilaiModel->find($this->request->getVar('id_ljk'));
                if ($cekDataNilai) {
                    $record = [
                        'id_ljk' => $this->request->getVar('id_ljk'),
                        'Nilai_UTS' => NULL,
                        'Nilai_TGS' => NULL,
                        'Nilai_UAS' => NULL,
                        'Nilai_Performance' => NULL,
                        'Nilai_Akhir' => NULL,
                        'Status_Nilai' => NULL,
                        'Rekom_Nilai' => NULL,
                        'Nilai_Huruf' => NULL
                    ];
                    //$aksi = $NilaiModel->delete($this->request->getVar('id_ljk'));
                    if ($NilaiModel->save($record)) {
                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil direset."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal direset."));
                    }
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data tidak ditemukan."));
                }
            }
        }
    }

    function loadDataKrs()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $KrsModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                /*
                if ($list->kode_ta %2 != 0){
                	$a = (($list->kode_ta + 10)-1)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = ($b*2)-1;
                	
                }else{
                	$a = (($list->kode_ta + 10)-2)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = $b * 2;
                }
                */
                if ($list->stat_mhs == 'A') {
                    $stat_mhs = '<span class="badge badge-success">Aktif</span>';
                } elseif ($list->stat_mhs == 'N') {
                    $stat_mhs = '<span class="badge badge-danger">Non-Aktif</span>';
                } elseif ($list->stat_mhs == 'C') {
                    $stat_mhs = '<span class="badge badge-warning">Cuti</span>';
                } elseif ($list->stat_mhs == 'U') {
                    $stat_mhs = '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
                } elseif ($list->stat_mhs == 'M') {
                    $stat_mhs = '<span class="badge badge-primary">Kampus Merdeka</span>';
                } elseif ($list->stat_mhs == 'G') {
                    $stat_mhs = '<span class="badge badge-grey">Sedang Double Degree</span>';
                }

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap');
                $row[] = $list->Program;
                $row[] = $list->Prodi;
                //$row[] = $list->semester." / ".$c;
                $row[] = $stat_mhs;
                $row[] = $list->syarat_krs == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                $row[] = $list->publikasi_pmb == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                $row[] = '<ol>' . ((!empty($list->kwitansi_krs)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->kwitansi_krs . "'" . ')">Pembayaran</a></li>' : '') . " " . ((!empty($list->berkas_publikasi)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->berkas_publikasi . "'" . ')" >Publikasi</a></li>' : '') . '</ol>';
                $row[] = '<a  href="javascript:void(0)" class="btn btn-xs btn-success" onclick="getDataKrs(' . "'" . $list->id . "'" . ')" role="button" >
            							Upload
            						</a>';
                $row[] = '<a onclick="formulir(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Formulir KRS"><i class="fa fa-list"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->krs->countAll(),
                //'recordsFiltered' => $this->krs->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function getDataKrs()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        $data = $KrsModel->find($this->request->getVar('id_krs'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    function upload_krs()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $KrsModel = new \App\Models\KrsModel($this->request);
            $dt = $KrsModel->find($this->request->getVar('id_krs')); // ambil data
            $id_his_pdk = $dt['id_his_pdk'];
            $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri'];
            $aturan = [
                'file_syarat' => [
                    'rules' => 'uploaded[file_syarat]|is_image[file_syarat]|mime_in[file_syarat,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih foto yang akan diupload',
                        'is_image' => 'Yang Anda upload bukan gambar',
                        'mime_in' => 'Ekstensi file yang anda upload tidak diijinkan. Upload gambar dengan ekstensi jpg | jpeg | png'
                    ]
                ],
                'jns_berkas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih jenis berkas!!'
                    ]
                ]
            ];


            $file = $this->request->getFile('file_syarat');
            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {
                if ($this->request->getVar('jns_berkas') == 'pembayaran') {
                    $foto = $dt['kwitansi_krs'];
                    if ($file->getName()) {
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace("'", "", getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);
                        $path = 'berkas_mahasiswa/' . $nmFolder;
                        $foto = $path . '/' . $nm_foto;
                        $file->move($path, $nm_foto);
                        @unlink($dt['kwitansi_krs']);
                    }
                    $record = [
                        'id' => $dt['id'],
                        'kwitansi_krs' => $foto,
                    ];
                    if ($KrsModel->save($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " berhasil diupload"));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " gagal diupload"));
                    }
                } else {
                    $foto = $dt['berkas_publikasi'];
                    if ($file->getName()) {
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace("'", "", getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);
                        $path = 'berkas_mahasiswa/' . $nmFolder;
                        $foto = $path . '/' . $nm_foto;
                        $file->move($path, $nm_foto);
                        @unlink($dt['berkas_publikasi']);
                    }
                    $record = [
                        'id' => $dt['id'],
                        'berkas_publikasi' => $foto,
                    ];


                    if ($KrsModel->save($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " berhasil diupload", "id_data_diri" => $id_data_diri));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " gagal diupload"));
                    }
                }
            }
        }
    }

    function loadDataAkm()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $KrsModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                if ($list->stat_mhs == 'A') {
                    $stat_mhs = '<span class="badge badge-success">Aktif</span>';
                } elseif ($list->stat_mhs == 'N') {
                    $stat_mhs = '<span class="badge badge-danger">Non-Aktif</span>';
                } elseif ($list->stat_mhs == 'C') {
                    $stat_mhs = '<span class="badge badge-warning">Cuti</span>';
                } elseif ($list->stat_mhs == 'U') {
                    $stat_mhs = '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
                } elseif ($list->stat_mhs == 'M') {
                    $stat_mhs = '<span class="badge badge-primary">Kampus Merdeka</span>';
                } elseif ($list->stat_mhs == 'G') {
                    $stat_mhs = '<span class="badge badge-grey">Sedang Double Degree</span>';
                }

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap');
                $row[] = $list->Prodi;
                $row[] = $list->Program;
                //$row[] = $list->semester." / ".$c;
                $row[] = $stat_mhs;
                $row[] = $list->jml_sks;
                $row[] = '<a onclick="detail_akm(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail AKM"><i class="fa fa-eye"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->krs->countAll(),
                //'recordsFiltered' => $this->krs->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function cekNim()
    {


        $data = getDataRow('histori_pddk', ['id_data_diri' => $this->request->getVar('id'), 'status' => 'A', 'jns_keluar' => NULL]);

        if (empty($data['NIM'])) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    public function cetakKtm()
    {
        $id = $this->request->getVar('id');

        $data['his_pdk'] = getDataRow('histori_pddk', [
            'id_data_diri' => $id,
            'status' => 'A',
            'jns_keluar' => NULL
        ]);

        $data['diri'] = getDataRow('db_data_diri_mahasiswa', ['id' => $id]);
        $data['templateJudul'] = "Cetak KTM " . $data['diri']['Nama_Lengkap'];
        $data['metode'] = 'cetakKtm';

        /* ================= FOTO ================= */
        if ($data['diri']['Foto_Diri'] == NULL || $data['diri']['Foto_Diri'] == '') {
            $foto = base_url('assets/no-pict.jpg');
        } else {
            $foto = base_url($data['diri']['Foto_Diri']);
        }

        /* ================= PRODI ================= */
        $prodi = getDataRow('prodi', [
            'singkatan' => $data['his_pdk']['Prodi']
        ])['nm_prodi'];

        /* ================= QR ================= */
        $writer = new PngWriter();

        $dataQr = $data['diri']['Nama_Lengkap'] . ";" .
            $data['his_pdk']['NIM'] . ";" .
            $data['his_pdk']['Prodi'] . ";" .
            $data['his_pdk']['Program'];

        $qrCode = QrCode::create($dataQr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10);

        $result = $writer->write($qrCode);
        $qrcode = $result->getDataUri();

        /* ================= HTML VIEW DI CONTROLLER ================= */

        $html = '
<style>
.kotak_kartu_depan{
    width:8.56cm;height:5.4cm;border-radius:10px;
    font-family:Tahoma;margin-left:.5mm;float:left;
    position:relative;
    background:url("' . base_url('assets/bg_ktm_depan.gif') . '") no-repeat;
    background-size:100% 100%;
}
.kotak_kartu_belakang{
    width:8.56cm;height:5.4cm;border-radius:10px;
    font-family:Tahoma;margin-left:.5mm;float:left;
    position:relative;
    background:url("' . base_url('assets/bg_ktm_belakang.gif') . '") no-repeat;
    background-size:100% 100%;
}
.foto{width:17mm;height:22mm;position:absolute;margin-left:25px;}
.label{text-align:right;margin-right:1mm;font-size:5pt;}
.textbox{text-align:right;margin-right:1mm;font-size:6pt;}
img{width:17mm;height:22mm;}
.qrcode{
    background:url("' . $qrcode . '") no-repeat;
    background-size:80px 80px;
    float:right;width:2.1cm;height:2.1cm;
}
</style>

<div class="kotak_kartu_depan">
  <div style="padding-top:19mm">
    <div class="foto">
      <img src="' . $foto . '">
    </div>

    <div style="float:right;width:4cm;">
      <div class="label"><em>Nama</em></div>
      <div class="textbox"><strong><em>' . ucwords($data['diri']['Nama_Lengkap']) . '</em></strong></div>

      <div class="label"><em>Program Studi</em></div>
      <div class="textbox">
        <strong><em>' . ucwords($prodi) . ' (' . $data['his_pdk']['Prodi'] . ')</em></strong>
      </div>

      <div class="label"><em>Tempat Tanggal Lahir</em></div>
      <div class="textbox">
        <strong><em>' . ucwords($data['diri']['Kota_Lhr']) . ', ' . date_indo($data['diri']['Tgl_Lhr']) . '</em></strong>
      </div>

      <div class="label"><em>Alamat</em></div>
      <div class="textbox">
        <strong><em>' .
            ucwords($data['diri']['Desa']) . ' ' .
            ucwords($data['diri']['Kec']) . ' ' .
            ucwords($data['diri']['Kab']) . ' ' .
            ucwords($data['diri']['Prov']) .
            '</em></strong>
      </div>
    </div>
  </div>
</div>

<div class="kotak_kartu_belakang">
  <div style="padding-top:19mm">
    <div class="qrcode" style="margin-right:3mm;"></div>
  </div>
  <div>
    <div style="text-align:right;margin-right:4mm;font-size:5pt;">
      <em>Nomor Induk Mahasiswa</em>
    </div>
    <div style="text-align:right;margin-right:4mm;font-size:8pt;">
      <strong><em>' . ucwords($data['his_pdk']['NIM']) . '</em></strong>
    </div>
  </div>
</div>
';

        /* ================= KIRIM KE VIEW ================= */
        return view(
            session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'],
            ['html' => $html]
        );
    }

    //Profil Dosen
    public function loadPendidikanDosen()
    {
        $RiwayatPddkDosenModel = new \App\Models\RiwayatPddkDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $RiwayatPddkDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->jenjang;
                $row[] = $list->nama_pendidikan;
                $row[] = $list->gelar_pendidikan;
                $row[] = $list->th_lulus;
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_riwayat_pendidikan','id_riwayat_pendidikan','" . $list->id_riwayat_pendidikan . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_riwayat_pddk?id_riwayat=") . $list->id_riwayat_pendidikan . "','" . $list->id_riwayat_pendidikan . "'" . '); return false;" id="id' . $list->id_riwayat_pendidikan . '" judul="Edit Riwayat Pendidikan" tabel="pendidikan" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadPenelitian()
    {
        $PenelitianDosenModel = new \App\Models\PenelitianDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $PenelitianDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->Judul_penelitian;
                $row[] = $list->th_penelitian;
                $row[] = $list->dana_penelitian;
                $row[] = $list->tingkat_penelitian;
                $row[] = (!empty($list->lokasi_file)) ?
                    '<button onclick="window.open(' . "'" . $list->lokasi_file . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Open File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_penelitian','id_penelitian','" . $list->id_penelitian . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_penelitian?id_penelitian=") . $list->id_penelitian . "','" . $list->id_penelitian . "'" . '); return false;" id="id' . $list->id_penelitian . '" judul="Edit Penelitian" tabel="penelitian" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadPengabdian()
    {
        $PengabdianDosenModel = new \App\Models\PengabdianDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $PengabdianDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->judul_pengabdian;
                $row[] = $list->tahun_pengabdian;
                $row[] = $list->dana_pengabdian;
                $row[] = $list->tingkat_pengabdian;
                $row[] = (!empty($list->lokasi_file)) ?
                    '<button onclick="window.open(' . "'" . $list->lokasi_file . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_pengabdian','id_pengabdian','" . $list->id_pengabdian . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_pengabdian?id_pengabdian=") . $list->id_pengabdian . "','" . $list->id_pengabdian . "'" . '); return false;" id="id' . $list->id_pengabdian . '" judul="Edit Pengabdian" tabel="pengabdian" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadDokumen()
    {
        $DokumenDosenModel = new \App\Models\DokumenDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $DokumenDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->judul_dokumen;
                $row[] = (!empty($list->lokasi_file)) ?
                    '<button onclick="window.open(' . "'" . $list->lokasi_file . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_dokumen','id_dokumen','" . $list->id_dokumen . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_dokumen?id_dokumen=") . $list->id_dokumen . "','" . $list->id_dokumen . "'" . '); return false;" id="id' . $list->id_dokumen . '" judul="Edit Dokumen" tabel="dokumen" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadPenghargaan()
    {
        $PenghargaanDosenModel = new \App\Models\PenghargaanDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $PenghargaanDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->judul_penghargaan;
                $row[] = $list->jenis_penghargaan;
                $row[] = $list->tahun_penghargaan;
                $row[] = $list->tingkat_penghargaan;
                $row[] = (!empty($list->lokasi_file)) ?
                    '<button onclick="window.open(' . "'" . $list->lokasi_file . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_penghargaan','id_penghargaan','" . $list->id_penghargaan . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_penghargaan?id_penghargaan=") . $list->id_penghargaan . "','" . $list->id_penghargaan . "'" . '); return false;" id="id' . $list->id_penghargaan . '" judul="Edit Penghargaan" tabel="penghargaan" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadJurnal()
    {
        $JurnalIlmiahModel = new \App\Models\JurnalIlmiahModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $JurnalIlmiahModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->judul_artikel;
                $row[] = $list->nama_jurnal;
                $row[] = $list->tahun_artikel;
                $row[] = $list->volume;
                $row[] = $list->issn;
                $row[] = (!empty($list->link)) ?
                    '<button onclick="window.open(' . "'" . $list->link . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_artikel','id_artikel','" . $list->id_artikel . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_jurnal?id_artikel=") . $list->id_artikel . "','" . $list->id_artikel . "'" . '); return false;" id="id' . $list->id_artikel . '" judul="Edit Jurnal" tabel="jurnal" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function loadBuku()
    {
        $BukuDosenModel = new \App\Models\BukuDosenModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $BukuDosenModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("profil/$this->halaman_controller")."?id=".$list->id_his_pdk;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->judul_buku;
                $row[] = $list->tahun_buku;
                $row[] = $list->penerbit;
                $row[] = $list->isbn;
                $row[] = (!empty($list->link_isbn)) ?
                    '<button onclick="window.open(' . "'" . $list->link_isbn . "', '', 'width=800, height=600, status=1,scrollbar=yes'" . '); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>'
                    :
                    '';
                $row[] = '
                            <a onclick="hapus_data_dosen(' . "'tb_buku','id_buku','" . $list->id_buku . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . base_url("$this->halaman_controller/tmb_buku?id_buku=") . $list->id_buku . "','" . $list->id_buku . "'" . '); return false;" id="id' . $list->id_buku . '" judul="Edit Buku" tabel="buku" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        ';

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->mahasiswa->countAll(),
                //'recordsFiltered' => $this->mahasiswa->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    function tmb_riwayat_pddk()
    {
        $RiwayatPddkDosenModel = new \App\Models\RiwayatPddkDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'jenjang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih jenjang pendidikan!!'
                    ]
                ],
                'nama_pendidikan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama pendidikan harus diisi'
                    ]
                ],
                'th_lulus' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun lulus harus diisi'
                    ]
                ]

            ];
            if (empty($this->request->getVar('id_riwayat_pendidikan'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'nama_pendidikan' => $this->request->getVar('nama_pendidikan'),
                        'gelar_pendidikan' => $this->request->getVar('gelar_pendidikan'),
                        'th_lulus' => $this->request->getVar('th_lulus')
                    ];
                    //dd($record);

                    if ($RiwayatPddkDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Riwayat pendidikan berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Riwayat pendidikan gagal disimpan."));
                    }
                }
            } else {
                //$riwayat = $RiwayatPddkDosenModel->find($this->request->getVar('id_riwayat'));// ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_riwayat_pendidikan' => $this->request->getVar('id_riwayat_pendidikan'),
                        'jenjang' => $this->request->getVar('jenjang'),
                        'nama_pendidikan' => $this->request->getVar('nama_pendidikan'),
                        'gelar_pendidikan' => $this->request->getVar('gelar_pendidikan'),
                        'th_lulus' => $this->request->getVar('th_lulus')
                    ];

                    if ($RiwayatPddkDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Riwayat pendidikan berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Riwayat pendidikan gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_riwayat')) {
            $data = $RiwayatPddkDosenModel->find($this->request->getVar('id_riwayat'));
        }

        $data['templateJudul'] = "Tambah Riwayat Pendidikan";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_riwayat_pddk';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_penelitian()
    {
        $PenelitianDosenModel = new \App\Models\PenelitianDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'Judul_penelitian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul penelitian tidak boleh kosong!!'
                    ]
                ],
                'dana_penelitian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih sumber dana penelitian'
                    ]
                ],
                'th_penelitian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun penelitian harus diisi'
                    ]
                ],
                'tingkat_penelitian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih tingkat penelitian'
                    ]
                ],
                'upload_file' => [
                    'rules' => 'ext_in[upload_file,pdf]|mime_in[upload_file,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                        'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
                    ]
                ]

            ];

            $berkas = $this->request->getFile('upload_file');

            if (empty($this->request->getVar('id_penelitian'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = "";
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $this->request->getVar('Kode')])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/penelitian";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                    }

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'Judul_penelitian' => $this->request->getVar('Judul_penelitian'),
                        'th_penelitian' => $this->request->getVar('th_penelitian'),
                        'dana_penelitian' => $this->request->getVar('dana_penelitian'),
                        'tingkat_penelitian' => $this->request->getVar('tingkat_penelitian'),
                        'lokasi_file' => $post_berkas
                    ];
                    //dd($record);

                    if ($PenelitianDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Penelitian berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Penelitian gagal disimpan."));
                    }
                }
            } else {
                $penelitian = $PenelitianDosenModel->find($this->request->getVar('id_penelitian')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = $penelitian['lokasi_file'];
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $penelitian['id_staff']])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/penelitian";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                        if ($penelitian['lokasi_file']) {
                            @unlink(substr($penelitian['lokasi_file'], 34));
                        }
                    }

                    $record = [
                        'id_penelitian' => $this->request->getVar('id_penelitian'),
                        'Judul_penelitian' => $this->request->getVar('Judul_penelitian'),
                        'th_penelitian' => $this->request->getVar('th_penelitian'),
                        'dana_penelitian' => $this->request->getVar('dana_penelitian'),
                        'tingkat_penelitian' => $this->request->getVar('tingkat_penelitian'),
                        'lokasi_file' => $post_berkas
                    ];

                    if ($PenelitianDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Penelitian berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Penelitian gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_penelitian')) {
            $data = $PenelitianDosenModel->find($this->request->getVar('id_penelitian'));
        }

        $data['templateJudul'] = "Tambah Penelitian";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_penelitian';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_pengabdian()
    {
        $PengabdianDosenModel = new \App\Models\PengabdianDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'judul_pengabdian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul pengabdian tidak boleh kosong!!'
                    ]
                ],
                'dana_pengabdian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih sumber dana pengabdian'
                    ]
                ],
                'tahun_pengabdian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun pengabdian harus diisi'
                    ]
                ],
                'tingkat_pengabdian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih tingkat pengabdian'
                    ]
                ],
                'upload_file' => [
                    'rules' => 'ext_in[upload_file,pdf]|mime_in[upload_file,application/pdf]',
                    'errors' => [
                        'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                        'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
                    ]
                ]

            ];

            $berkas = $this->request->getFile('upload_file');

            if (empty($this->request->getVar('id_pengabdian'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = "";
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $this->request->getVar('Kode')])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/pengabdian";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                    }

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'judul_pengabdian' => $this->request->getVar('judul_pengabdian'),
                        'tahun_pengabdian' => $this->request->getVar('tahun_pengabdian'),
                        'dana_pengabdian' => $this->request->getVar('dana_pengabdian'),
                        'tingkat_pengabdian' => $this->request->getVar('tingkat_pengabdian'),
                        'lokasi_file' => $post_berkas
                    ];
                    //dd($record);

                    if ($PengabdianDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Pengabdian berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Pengabdian gagal disimpan."));
                    }
                }
            } else {
                $pengabdian = $PengabdianDosenModel->find($this->request->getVar('id_pengabdian')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = $pengabdian['lokasi_file'];
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $pengabdian['id_staff']])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/pengabdian";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                        if ($pengabdian['lokasi_file']) {
                            @unlink(substr($pengabdian['lokasi_file'], 34));
                        }
                    }

                    $record = [
                        'id_pengabdian' => $this->request->getVar('id_pengabdian'),
                        'judul_pengabdian' => $this->request->getVar('judul_pengabdian'),
                        'tahun_pengabdian' => $this->request->getVar('tahun_pengabdian'),
                        'dana_pengabdian' => $this->request->getVar('dana_pengabdian'),
                        'tingkat_pengabdian' => $this->request->getVar('tingkat_pengabdian'),
                        'lokasi_file' => $post_berkas
                    ];

                    if ($PengabdianDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Pengabdian berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Pengabdian gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_pengabdian')) {
            $data = $PengabdianDosenModel->find($this->request->getVar('id_pengabdian'));
        }

        $data['templateJudul'] = "Tambah Pengabdian";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_pengabdian';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_dokumen()
    {
        $DokumenDosenModel = new \App\Models\DokumenDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'judul_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul dokumen tidak boleh kosong!!'
                    ]
                ],
                'upload_file' => [
                    'rules' => 'ext_in[upload_file,pdf,jpg,jpeg,png]|mime_in[upload_file,application/pdf,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                        'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
                    ]
                ]

            ];

            $berkas = $this->request->getFile('upload_file');

            if (empty($this->request->getVar('id_dokumen'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = "";
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $this->request->getVar('Kode')])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/dokumen";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                    }

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'judul_dokumen' => $this->request->getVar('judul_dokumen'),
                        'lokasi_file' => $post_berkas
                    ];
                    //dd($record);

                    if ($DokumenDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Dokumen berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Dokumen gagal disimpan."));
                    }
                }
            } else {
                $dokumen = $DokumenDosenModel->find($this->request->getVar('id_dokumen')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = $dokumen['lokasi_file'];
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $dokumen['id_staff']])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/dokumen";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                        if ($dokumen['lokasi_file']) {
                            @unlink(substr($dokumen['lokasi_file'], 34));
                        }
                    }

                    $record = [
                        'id_dokumen' => $this->request->getVar('id_dokumen'),
                        'judul_dookumen' => $this->request->getVar('judul_dokumen'),
                        'lokasi_file' => $post_berkas
                    ];

                    if ($DokumenDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Dokumen berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Dokumen gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_dokumen')) {
            $data = $DokumenDosenModel->find($this->request->getVar('id_dokumen'));
        }

        $data['templateJudul'] = "Tambah Dokumen";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_dokumen';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_penghargaan()
    {
        $PenghargaanDosenModel = new \App\Models\PenghargaanDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'judul_penghargaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul penghargaan tidak boleh kosong!!'
                    ]
                ],
                'jenis_penghargaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis penghargaan tidak boleh kosong!!'
                    ]
                ],
                'tahun_penghargaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun penghargaan harus diisi'
                    ]
                ],
                'tingkat_penghargaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih tingkat penghargaan'
                    ]
                ],
                'upload_file' => [
                    'rules' => 'ext_in[upload_file,pdf,jpg,jpeg,png]|mime_in[upload_file,application/pdf,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                        'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
                    ]
                ]

            ];

            $berkas = $this->request->getFile('upload_file');

            if (empty($this->request->getVar('id_penghargaan'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = "";
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $this->request->getVar('Kode')])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/penghargaan";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                    }

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'judul_penghargaan' => $this->request->getVar('judul_penghargaan'),
                        'tahun_penghargaan' => $this->request->getVar('tahun_penghargaan'),
                        'jenis_penghargaan' => $this->request->getVar('jenis_penghargaan'),
                        'tingkat_penghargaan' => $this->request->getVar('tingkat_penghargaan'),
                        'lokasi_file' => $post_berkas
                    ];
                    //dd($record);

                    if ($PenghargaanDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Penghargaan berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Penghargaan gagal disimpan."));
                    }
                }
            } else {
                $penghargaan = $PenghargaanDosenModel->find($this->request->getVar('id_penghargaan')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {
                    $post_berkas = $penghargaan['lokasi_file'];
                    $nmFolder    = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $penghargaan['id_staff']])['Nama_Dosen']);
                    if ($berkas->getName()) {
                        $nm_file = $berkas->getRandomName();
                        $path = "berkas_dosen/$nmFolder/penghargaan";
                        $post_berkas = base_url() . '/' . $path . '/' . $nm_file;
                        $berkas->move($path, $nm_file);
                        if ($penghargaan['lokasi_file']) {
                            @unlink(substr($penghargaan['lokasi_file'], 34));
                        }
                    }

                    $record = [
                        'id_penghargaan' => $this->request->getVar('id_penghargaan'),
                        'judul_penghargaan' => $this->request->getVar('judul_penghargaan'),
                        'tahun_penghargaan' => $this->request->getVar('tahun_penghargaan'),
                        'jenis_penghargaan' => $this->request->getVar('jenis_penghargaan'),
                        'tingkat_penghargaan' => $this->request->getVar('tingkat_penghargaan'),
                        'lokasi_file' => $post_berkas
                    ];

                    if ($PenghargaanDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Penghargaan berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Penghargaan gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_penghargaan')) {
            $data = $PenghargaanDosenModel->find($this->request->getVar('id_penghargaan'));
        }

        $data['templateJudul'] = "Tambah Penghargaan";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_penghargaan';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_jurnal()
    {
        $JurnalIlmiahModel = new \App\Models\JurnalIlmiahModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'judul_artikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul artikel tidak boleh kosong!!'
                    ]
                ],
                'nama_jurnal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama jurnal tidak boleh kosong!!'
                    ]
                ],
                'tahun_artikel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun terbit harus diisi'
                    ]
                ],
                'volume' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor / Volume harus diisi'
                    ]
                ],
                'issn' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'ISSN harus diisi'
                    ]
                ],
                'link' => [
                    'rules' => 'required|valid_url_strict[https,http]',
                    'errors' => [
                        'required' => 'Link artikel harus diisi',
                        'valid_url_strict' => 'Link yang anda masukkan tidak valid. Link harus didahului http:// atau https://'
                    ]
                ]

            ];


            if (empty($this->request->getVar('id_artikel'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'judul_artikel' => $this->request->getVar('judul_artikel'),
                        'nama_jurnal' => $this->request->getVar('nama_jurnal'),
                        'tahun_artikel' => $this->request->getVar('tahun_artikel'),
                        'volume' => $this->request->getVar('volume'),
                        'issn' => $this->request->getVar('issn'),
                        'link' => $this->request->getVar('link')
                    ];
                    //dd($record);

                    if ($JurnalIlmiahModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Jurnal berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal gagal disimpan."));
                    }
                }
            } else {
                $jurnal = $JurnalIlmiahModel->find($this->request->getVar('id_artikel')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_artikel' => $this->request->getVar('id_artikel'),
                        'judul_artikel' => $this->request->getVar('judul_artikel'),
                        'nama_jurnal' => $this->request->getVar('nama_jurnal'),
                        'tahun_artikel' => $this->request->getVar('tahun_artikel'),
                        'volume' => $this->request->getVar('volume'),
                        'issn' => $this->request->getVar('issn'),
                        'link' => $this->request->getVar('link')
                    ];

                    if ($JurnalIlmiahModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Jurnal berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_artikel')) {
            $data = $JurnalIlmiahModel->find($this->request->getVar('id_artikel'));
        }

        $data['templateJudul'] = "Tambah Jurnal";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_jurnal';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tmb_buku()
    {
        $BukuDosenModel = new \App\Models\BukuDosenModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $aturan = [
                'judul_buku' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul buku tidak boleh kosong!!'
                    ]
                ],
                'tahun_buku' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun buku harus diisi'
                    ]
                ],
                'penerbit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Penerbit harus diisi'
                    ]
                ],
                'isbn' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'ISBN harus diisi'
                    ]
                ],
                'link_isbn' => [
                    'rules' => 'permit_empty|valid_url_strict[https,http]',
                    'errors' => [

                        'valid_url_strict' => 'Link yang anda masukkan tidak valid. Link harus didahului http:// atau https://'
                    ]
                ]

            ];


            if (empty($this->request->getVar('id_buku'))) {

                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_staff' => $this->request->getVar('Kode'),
                        'judul_buku' => $this->request->getVar('judul_buku'),
                        'tahun_buku' => $this->request->getVar('tahun_buku'),
                        'penerbit' => $this->request->getVar('penerbit'),
                        'isbn' => $this->request->getVar('isbn'),
                        'link_isbn' => $this->request->getVar('link_isbn')
                    ];
                    //dd($record);

                    if ($BukuDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Buku berhasil disimpan."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Buku gagal disimpan."));
                    }
                }
            } else {
                $buku = $BukuDosenModel->find($this->request->getVar('id_buku')); // ambil data
                if (!$this->validate($aturan)) {

                    return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa data yang akan disimpan!!"));
                } else {

                    $record = [
                        'id_buku' => $this->request->getVar('id_buku'),
                        'judul_buku' => $this->request->getVar('judul_buku'),
                        'tahun_buku' => $this->request->getVar('tahun_buku'),
                        'penerbit' => $this->request->getVar('penerbit'),
                        'isbn' => $this->request->getVar('isbn'),
                        'link_isbn' => $this->request->getVar('link_isbn')
                    ];

                    if ($BukuDosenModel->simpanData($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Buku berhasil diupdate."));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Buku gagal diupdate."));
                    }
                }
            }
        }

        if ($this->request->getVar('kd_dosen')) {
            $data = getDataRow('data_dosen', ['Kode' => $this->request->getVar('kd_dosen')]);
        }

        if ($this->request->getVar('id_buku')) {
            $data = $BukuDosenModel->find($this->request->getVar('id_buku'));
        }

        $data['templateJudul'] = "Tambah Buku";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'tmb_buku';

        return view(session()->get('akun_group_folder') . "/$this->halaman_controller/" . $data['metode'], $data);
    }

    function hapus_data_dosen()
    {

        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('tabel') && $this->request->getVar('id')  && $this->request->getVar('pk')) {
                if ($this->request->getVar('tabel') == 'tb_penelitian' || $this->request->getVar('tabel') == 'tb_pengabdian' || $this->request->getVar('tabel') == 'tb_dokumen' || $this->request->getVar('tabel') == 'tb_penghargaan') {
                    $cekData = getDataRow($this->request->getVar('tabel'), [$this->request->getVar('pk') => $this->request->getVar('id')]);
                }

                $aksi = deleteDataDinamis($this->request->getVar('tabel'), [$this->request->getVar('pk') => $this->request->getVar('id')]);
                if ($aksi == true) {
                    if ($this->request->getVar('tabel') == 'tb_penelitian' || $this->request->getVar('tabel') == 'tb_pengabdian' || $this->request->getVar('tabel') == 'tb_dokumen' || $this->request->getVar('tabel') == 'tb_penghargaan') {
                        @unlink(substr($cekData['lokasi_file'], 34));
                    }

                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Data berhasil dihapus."));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Data gagal dihapus."));
                }
            }
        }
    }
}
