<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Pendaftaran extends BaseController
{
    function __construct()
    {
        $this->validation = \Config\Services::validation();
    	$this->halaman_controller = "pendaftaran";
    	$this->halaman_label = "Pendaftaran";
    }

	public function index()
	{

		$data = [];
    	if($this->request->getVar('kode_referral')){
    	    $data = $this->request->getVar();
    	}


		$data['templateJudul'] = $this->halaman_label." STAI Al-Mannan Tulungagung";
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
		return view($this->halaman_controller.'/index', $data);
		
	}
	
	public function S1()
	{

		$data = [];
		
		if($this->request->getMethod()=="post"){
		    if($this->request->getVar('status_pendaftaran') == 'Mahasiswa Baru'){
		        $rulePindahan = "permit_empty";
		    }else{
		        $rulePindahan = "required";
		    }
		    $aturan = [
                'kelas_program' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'prodi1' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'status_pendaftaran' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'nimko_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'prodi_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'pt_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'smt_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'sks_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'ipk_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KTP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KK' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Tgl_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kota_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Anak_Ke' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jml_Saudara' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Status_Perkawinan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Biaya_ditanggung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_wa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_HP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kewarganegaraan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RT' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RW' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Prov' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kab' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kec' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kode_Pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Transportasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Penerima_KPS' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Status_Asal_Sekolah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Jenis_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kejuruan_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Lengkap_SLTA_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Alamat_Lengkap_Sekolah_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Th_Lulus_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 
                'username' => [
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        'required'=>'Username harus diisi',
                        'is_unique' => 'Username '.$this->request->getVar('username').' sudah ada. Silahkan buat username lain.'
                    ]
                ],
                'Email' => [
                    'rules' => 'required|is_unique[users.email]|valid_email',
                    'errors' => [
                        'required'=>'Wajib diisi!!',
                        'is_unique' => 'Email '.$this->request->getVar('email').' sudah ada. Silahkan gunakan email yang lain.',
                        'valid_email' => 'Email anda tidak valid'
                    ]
                ],
                'password' => [
                    'rules' => 'min_length[6]|alpha_numeric',
                    'errors' => [
                        'min_length' => 'Panjang paswword minimal 6 karakter',
                        'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                    ]
                ],
                'konfirmasi_password' => [
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak sama dengan password'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                $id = md5(time() . mt_rand(1,1000000));
                $periode = getDataRow('setting_gelombang', ['jenjang' => 'S1', 'Aktif' => '1']);
                $record_akademik = [
                    'id' => $id,
                    'Tahun_Masuk' => $periode['tahun'],
                    'Tgl_Daftar' => date('d-m-Y'),
                    'program_sekolah' => 'S1',
                    'Kelas_Program_Kuliah' => $this->request->getVar('kelas_program'),
                    'Prodi_Pilihan_1' => $this->request->getVar('prodi1'),
                    'Status_Pendaftaran' => $this->request->getVar('status_pendaftaran'),
                    'NIMKO_Asal' => $this->request->getVar('nimko_asal'),
                    'Prodi_Asal' => $this->request->getVar('prodi_asal'),
                    'PT_Asal' => $this->request->getVar('pt_asal'),
                    'Jml_SKS_Asal' => $this->request->getVar('sks_asal'),
                    'IPK_Asal' => $this->request->getVar('ipk_asal'),
                    'Semester_Asal' => $this->request->getVar('smt_asal'),
                    'Biaya_Pendaftaran' => $periode['biaya'],
                    'reff' => $this->request->getVar('kode_referral')
                ];
                
                $record_data_diri = [
                    'id' => $id,
                    'username' => $this->request->getVar('username'),
                    'Nama_Lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'Jenis_Kelamin' => $this->request->getVar('Jenis_Kelamin'),
                    'Gol_Darah' => $this->request->getVar('Gol_Darah'),
                    'Kota_Lhr' => $this->request->getVar('Kota_Lhr'),
                    'Tgl_Lhr' => $this->request->getVar('Tgl_Lhr'),
                    'Alamat' => $this->request->getVar('Alamat'),
                    'No_Rmh' => $this->request->getVar('No_Rmh'),
                    'RT' => $this->request->getVar('RT'),
                    'RW' => $this->request->getVar('RW'),
                    'Dusun' => $this->request->getVar('Dusun'),
                    'Desa' => $this->request->getVar('Desa'),
                    'Kec' => $this->request->getVar('Kec'),
                    'Kab' => $this->request->getVar('Kab'),
                    'Kode_Pos' => $this->request->getVar('Kode_Pos'),
                    'Prov' => $this->request->getVar('Prov'),
                    'Jenis_Domisili' => $this->request->getVar('Jenis_Domisili'),
                    'Tempat_Domisili' => $this->request->getVar('Tempat_Domisili'),
                    'No_Telp_Hp' => $this->request->getVar('No_Telp_Hp'),
                    'no_wa' => $this->request->getVar('no_wa'),
                    'No_KTP' => $this->request->getVar('No_KTP'),
                    'No_KK' => $this->request->getVar('No_KK'),
                    'Agama' => $this->request->getVar('Agama'),
                    'Kewarganegaraan' => $this->request->getVar('Kewarganegaraan'),
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
                    'Penerima_KPS' => $this->request->getVar('Penerima_KPS'),
                    'No_KPS' => $this->request->getVar('No_KPS')
                    
                ];
                
                $record_ortu = [
                    'id' => $id,
                    'Nama_Ayah' => $this->request->getVar('Nama_Ayah'), 
                    'Tempat_Lhr_Ayah' => $this->request->getVar('Tempat_Lhr_Ayah'), 
                    'Tgl_Lhr_Ayah' => $this->request->getVar('Tgl_Lhr_Ayah'), 
                    'Agama_Ayah' => $this->request->getVar('Agama_Ayah'), 
                    'Gol_Darah_Ayah' => $this->request->getVar('Gol_Darah_Ayah'), 
                    'Pendidikan_Terakhir_Ayah' => $this->request->getVar('Pendidikan_Terakhir_Ayah'), 
                    'Pekerjaan_Ayah' => $this->request->getVar('Pekerjaan_Ayah'), 
                    'Penghasilan_Ayah' => $this->request->getVar('Penghasilan_Ayah'), 
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
                    'Kewarganegaraan_Ibu' => $this->request->getVar('Kewarganegaraan_Ibu'),
                    'No_HP_ayah' => $this->request->getVar('No_HP_ayah'),
                    'No_HP_ibu' => $this->request->getVar('No_HP_ibu'),
                ];
                
                $record_user = [
                    'username' => $this->request->getVar('username'),
                    'nama_lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'email' => $this->request->getVar('Email'),
                    'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'password_plain' => $this->request->getVar('password')
                ];
                
                $userModel = new \App\Models\UserModel;
                if($userModel->save($record_user)){
                    $userGroup = [
                        'group_id' => 99,
                        'user_id' => $userModel->getInsertID()
                    ];
                    setUserGroup($userGroup);
                    setDataDinamis('db_pmb', $record_akademik);
                    setDataDinamis('db_data_diri_mahasiswa', $record_data_diri);
                    setDataDinamis('db_ortu_mhs', $record_ortu);
                    
                    $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
                    
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Formulir pendaftaran berhasil disimpan. Silahkan login untuk upload persyaratan."));
                        
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Formulir Pendaftaran tidak dapat disimpan."));
                }
                
            }
		}
		
    	if($this->request->getVar('kode_referral')){
    	    $data = $this->request->getVar();
    	    $data['prodi'] = getDataRow('pmb_affiliate', ['kode_referrer' => $this->request->getVar('kode_referral')])['prodi'];
    	}
    	
		$data['templateJudul'] = $this->halaman_label." STAI Al-Mannan Tulungagung";
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'S1';
		return view($this->halaman_controller.'/S1', $data);
		
	}
	
	function updateS1()
	{
	    if($this->request->getMethod()=="post"){
	        $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
		    if($this->request->getVar('status_pendaftaran') == 'Mahasiswa Baru'){
		        $rulePindahan = "permit_empty";
		    }else{
		        $rulePindahan = "required";
		    }
		    $aturan = [
                
                'Nama_Lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KTP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KK' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Tgl_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kota_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Anak_Ke' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jml_Saudara' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Status_Perkawinan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Biaya_ditanggung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_wa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_HP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kewarganegaraan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RT' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RW' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Prov' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kab' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kec' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kode_Pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Transportasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Penerima_KPS' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Status_Asal_Sekolah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Jenis_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kejuruan_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Lengkap_SLTA_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Alamat_Lengkap_Sekolah_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Th_Lulus_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                
                
                $record_data_diri = [
                    'id' => $this->request->getVar('id'),
                    'Nama_Lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'Jenis_Kelamin' => $this->request->getVar('Jenis_Kelamin'),
                    'Gol_Darah' => $this->request->getVar('Gol_Darah'),
                    'Kota_Lhr' => $this->request->getVar('Kota_Lhr'),
                    'Tgl_Lhr' => $this->request->getVar('Tgl_Lhr'),
                    'Alamat' => $this->request->getVar('Alamat'),
                    'No_Rmh' => $this->request->getVar('No_Rmh'),
                    'RT' => $this->request->getVar('RT'),
                    'RW' => $this->request->getVar('RW'),
                    'Dusun' => $this->request->getVar('Dusun'),
                    'Desa' => $this->request->getVar('Desa'),
                    'Kec' => $this->request->getVar('Kec'),
                    'Kab' => $this->request->getVar('Kab'),
                    'Kode_Pos' => $this->request->getVar('Kode_Pos'),
                    'Prov' => $this->request->getVar('Prov'),
                    'Jenis_Domisili' => $this->request->getVar('Jenis_Domisili'),
                    'Tempat_Domisili' => $this->request->getVar('Tempat_Domisili'),
                    'No_Telp_Hp' => $this->request->getVar('No_Telp_Hp'),
                    'no_wa' => $this->request->getVar('no_wa'),
                    'No_KTP' => $this->request->getVar('No_KTP'),
                    'No_KK' => $this->request->getVar('No_KK'),
                    'Agama' => $this->request->getVar('Agama'),
                    'Kewarganegaraan' => $this->request->getVar('Kewarganegaraan'),
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
                    'Penerima_KPS' => $this->request->getVar('Penerima_KPS'),
                    'No_KPS' => $this->request->getVar('No_KPS')
                    
                ];
                
                $record_ortu = [
                    
                    'Nama_Ayah' => $this->request->getVar('Nama_Ayah'), 
                    'Tempat_Lhr_Ayah' => $this->request->getVar('Tempat_Lhr_Ayah'), 
                    'Tgl_Lhr_Ayah' => $this->request->getVar('Tgl_Lhr_Ayah'), 
                    'Agama_Ayah' => $this->request->getVar('Agama_Ayah'), 
                    'Gol_Darah_Ayah' => $this->request->getVar('Gol_Darah_Ayah'), 
                    'Pendidikan_Terakhir_Ayah' => $this->request->getVar('Pendidikan_Terakhir_Ayah'), 
                    'Pekerjaan_Ayah' => $this->request->getVar('Pekerjaan_Ayah'), 
                    'Penghasilan_Ayah' => $this->request->getVar('Penghasilan_Ayah'), 
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
                    'Kewarganegaraan_Ibu' => $this->request->getVar('Kewarganegaraan_Ibu'),
                    'No_HP_ayah' => $this->request->getVar('No_HP_ayah'),
                    'No_HP_ibu' => $this->request->getVar('No_HP_ibu'),
                ];
                
                
                $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
                if($MahasiswaModel->save($record_data_diri)){
                    
                    
                    updateDataDinamis('db_ortu_mhs', $record_ortu, ['id' => $data_diri['id']]);
                    if($this->request->getVar('Nama_Lengkap') != $data_diri['Nama_Lengkap']){
                        updateDataDinamis('users', ['nama_lengkap' => $this->request->getVar('Nama_Lengkap')], ['username' => $data_diri['username']]);
                    }
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Formulir pendaftaran berhasil diupdate."));
                        
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Formulir Pendaftaran tidak dapat diupdate."));
                }
                
            }
		}
	}
	
	function update_foto_mhs()
    {
        $mahasiswaModel = new \App\Models\MahasiswaModel($this->request);
        if($this->request->getMethod(true)=='POST'){
			
            $dt = getDataRow('db_data_diri_mahasiswa', ['username' => $this->request->getVar('username')]);// ambil data
            
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
            if(!$this->validate($aturan)){
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            }else{
                $foto = $dt['Foto_Diri'];
                if($file->getName()){
                    $nm_foto = $file->getRandomName();
                    $nmFolder    = str_replace( "'", "", $dt['Nama_Lengkap']);
                    $path = 'berkas_mahasiswa/'.$nmFolder;
                    $foto = $path.'/'.$nm_foto;
                    $file->move($path, $nm_foto);
                    if($dt['Foto_Diri'] != 'assets/dist/img/no-pict.jpg' || $dt['Foto_Diri'] != null){
                        @unlink($dt['Foto_Diri']);
                    }
                }
                $record = [
                    'id' => $dt['id'],
                    'Foto_Diri' => $foto,
                ];
                
                if($foto != $dt['Foto_Diri']){
                    $userModel = new \App\Models\UserModel;
                    $update_user = [
                        'id' => getDataRow('users',['username'=>$dt['username']])['id'],
                        'foto_profil' => $foto
                    ];
                    $userModel->save($update_user);
                }
                
                if($mahasiswaModel->save($record)){
                    
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Data berhasil diupdate."));
                    
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Data gagal diupdate."));

                }

            }
			
		}
    }
    
    function upload_berkas()
    {
        $mahasiswaModel = new \App\Models\MahasiswaModel($this->request);
        $persyaratanModel = new \App\Models\SyaratPmbModel;
        if($this->request->getMethod(true)=='POST'){
			
            $dt = getDataRow('db_data_diri_mahasiswa', ['username' => $this->request->getVar('username')]);// ambil data
            
            $aturan = [
                'nama_berkas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama berkas tidak boleh kosong'
                    ]
                ],
                'file_persyaratan' => [
                    'rules' => 'uploaded[file_persyaratan]|mime_in[file_persyaratan,image/jpg,image/jpeg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih file yang akan diupload',
                        'mime_in' => 'Ekstensi file yang anda upload tidak diijinkan. Upload file dengan ekstensi jpg | jpeg | png | pdf'
                    ]
                ]
            ];
            
            
            $file = $this->request->getFile('file_persyaratan');
            if(!$this->validate($aturan)){
                echo json_encode(array("status"=>false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali form!!"));
            }else{
                
                if($file->getName()){
                    $nm_file = $file->getRandomName();
                    $nmFolder    = str_replace( "'", "", $dt['Nama_Lengkap']);
                    $path = 'berkas_mahasiswa/'.$nmFolder;
                    $berkas = $path.'/'.$nm_file;
                    $file->move($path, $nm_file);
                    
                }
                $record = [
                    'nama_berkas' => $this->request->getVar('nama_berkas'),
                    'lokasi' => $berkas,
                    'username' => $this->request->getVar('username')
                ];
                
                
                if($persyaratanModel->save($record)){
                    
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "File berhasil diupload."));
                    
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "File gagal diupload."));

                }

            }
			
		}
    }
    
    function hapus_berkas()
    {
        $persyaratanModel = new \App\Models\SyaratPmbModel;
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $persyaratanModel->find($this->request->getVar('id'));
                if($dt){ #memastikan ada data
                    
                    $aksi = $persyaratanModel->delete($this->request->getVar('id'));
                    if($aksi == true){
                        @unlink($dt['lokasi']);
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                    
                }
            }
        }
    }
    
    public function S2()
	{

		$data = [];
		
		if($this->request->getMethod()=="post"){
		    if($this->request->getVar('status_pendaftaran') == 'Mahasiswa Baru'){
		        $rulePindahan = "permit_empty";
		    }else{
		        $rulePindahan = "required";
		    }
		    $aturan = [
                
                'prodi1' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'status_pendaftaran' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'nimko_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'prodi_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'pt_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'smt_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'sks_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'ipk_asal' => [
                    'rules' => $rulePindahan,
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KTP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KK' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Tgl_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kota_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Anak_Ke' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jml_Saudara' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Status_Perkawinan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Biaya_ditanggung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_wa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_HP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kewarganegaraan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RT' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RW' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Prov' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kab' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kec' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kode_Pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Transportasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Penerima_KPS' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Status_Asal_Sekolah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kejuruan_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Lengkap_SLTA_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Th_Lulus_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 
                'username' => [
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        'required'=>'Username harus diisi',
                        'is_unique' => 'Username '.$this->request->getVar('username').' sudah ada. Silahkan buat username lain.'
                    ]
                ],
                'Email' => [
                    'rules' => 'required|is_unique[users.email]|valid_email',
                    'errors' => [
                        'required'=>'Wajib diisi!!',
                        'is_unique' => 'Email '.$this->request->getVar('email').' sudah ada. Silahkan gunakan email yang lain.',
                        'valid_email' => 'Email anda tidak valid'
                    ]
                ],
                'password' => [
                    'rules' => 'min_length[6]|alpha_numeric',
                    'errors' => [
                        'min_length' => 'Panjang paswword minimal 6 karakter',
                        'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
                    ]
                ],
                'konfirmasi_password' => [
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak sama dengan password'
                    ]
                ],
                 'No_HP_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                $id = md5(time() . mt_rand(1,1000000));
                $periode = getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1']);
                $record_akademik = [
                    'id' => $id,
                    'Tahun_Masuk' => $periode['tahun'],
                    'Tgl_Daftar' => date('d-m-Y'),
                    'program_sekolah' => 'S2',
                    'Kelas_Program_Kuliah' => "Reguler",
                    'Prodi_Pilihan_1' => $this->request->getVar('prodi1'),
                    'Status_Pendaftaran' => $this->request->getVar('status_pendaftaran'),
                    'NIMKO_Asal' => $this->request->getVar('nimko_asal'),
                    'Prodi_Asal' => $this->request->getVar('prodi_asal'),
                    'PT_Asal' => $this->request->getVar('pt_asal'),
                    'Jml_SKS_Asal' => $this->request->getVar('sks_asal'),
                    'IPK_Asal' => $this->request->getVar('ipk_asal'),
                    'Semester_Asal' => $this->request->getVar('smt_asal'),
                    'Biaya_Pendaftaran' => $periode['biaya'],
                    'reff' => $this->request->getVar('kode_referral')
                ];
                
                $record_data_diri = [
                    'id' => $id,
                    'username' => $this->request->getVar('username'),
                    'Nama_Lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'Jenis_Kelamin' => $this->request->getVar('Jenis_Kelamin'),
                    'Gol_Darah' => $this->request->getVar('Gol_Darah'),
                    'Kota_Lhr' => $this->request->getVar('Kota_Lhr'),
                    'Tgl_Lhr' => $this->request->getVar('Tgl_Lhr'),
                    'Alamat' => $this->request->getVar('Alamat'),
                    'No_Rmh' => $this->request->getVar('No_Rmh'),
                    'RT' => $this->request->getVar('RT'),
                    'RW' => $this->request->getVar('RW'),
                    'Dusun' => $this->request->getVar('Dusun'),
                    'Desa' => $this->request->getVar('Desa'),
                    'Kec' => $this->request->getVar('Kec'),
                    'Kab' => $this->request->getVar('Kab'),
                    'Kode_Pos' => $this->request->getVar('Kode_Pos'),
                    'Prov' => $this->request->getVar('Prov'),
                    'Jenis_Domisili' => $this->request->getVar('Jenis_Domisili'),
                    'Tempat_Domisili' => $this->request->getVar('Tempat_Domisili'),
                    'No_Telp_Hp' => $this->request->getVar('No_Telp_Hp'),
                    'no_wa' => $this->request->getVar('no_wa'),
                    'No_KTP' => $this->request->getVar('No_KTP'),
                    'No_KK' => $this->request->getVar('No_KK'),
                    'Agama' => $this->request->getVar('Agama'),
                    'Kewarganegaraan' => $this->request->getVar('Kewarganegaraan'),
                    'Status_Perkawinan' => $this->request->getVar('Status_Perkawinan'),
                    'Pekerjaan' => $this->request->getVar('Pekerjaan'),
                    'Biaya_ditanggung' => $this->request->getVar('Biaya_ditanggung'),
                    'Transportasi' => $this->request->getVar('Transportasi'),
                    'Status_Asal_Sekolah' => $this->request->getVar('Status_Asal_Sekolah'),
                    'Nama_Lengkap_SLTA_Asal' => $this->request->getVar('Nama_Lengkap_SLTA_Asal'),
                    'Kejuruan_SLTA' => $this->request->getVar('Kejuruan_SLTA'),
                    'Th_Lulus_SLTA' => $this->request->getVar('Th_Lulus_SLTA'),
                    'NISN' => $this->request->getVar('NISN'),
                    'Anak_Ke' => $this->request->getVar('Anak_Ke'),
                    'Jml_Saudara' => $this->request->getVar('Jml_Saudara'),
                    'No_HP' => $this->request->getVar('No_HP'),
                    'Penerima_KPS' => $this->request->getVar('Penerima_KPS'),
                    'No_KPS' => $this->request->getVar('No_KPS')
                    
                ];
                
                $record_ortu = [
                    'id' => $id,
                    'Nama_Ayah' => $this->request->getVar('Nama_Ayah'), 
                    'Tempat_Lhr_Ayah' => $this->request->getVar('Tempat_Lhr_Ayah'), 
                    'Tgl_Lhr_Ayah' => $this->request->getVar('Tgl_Lhr_Ayah'), 
                    'Agama_Ayah' => $this->request->getVar('Agama_Ayah'), 
                    'Gol_Darah_Ayah' => $this->request->getVar('Gol_Darah_Ayah'), 
                    'Pendidikan_Terakhir_Ayah' => $this->request->getVar('Pendidikan_Terakhir_Ayah'), 
                    'Pekerjaan_Ayah' => $this->request->getVar('Pekerjaan_Ayah'), 
                    'Penghasilan_Ayah' => $this->request->getVar('Penghasilan_Ayah'), 
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
                    'Kewarganegaraan_Ibu' => $this->request->getVar('Kewarganegaraan_Ibu'),
                    'No_HP_ayah' => $this->request->getVar('No_HP_ayah'),
                    'No_HP_ibu' => $this->request->getVar('No_HP_ibu'),
                ];
                
                $record_user = [
                    'username' => $this->request->getVar('username'),
                    'nama_lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'email' => $this->request->getVar('Email'),
                    'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'password_plain' => $this->request->getVar('password')
                ];
                
                $userModel = new \App\Models\UserModel;
                if($userModel->save($record_user)){
                    $userGroup = [
                        'group_id' => 99,
                        'user_id' => $userModel->getInsertID()
                    ];
                    setUserGroup($userGroup);
                    setDataDinamis('db_pmb', $record_akademik);
                    setDataDinamis('db_data_diri_mahasiswa', $record_data_diri);
                    setDataDinamis('db_ortu_mhs', $record_ortu);
                    
                    $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
                    
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Formulir pendaftaran berhasil disimpan. Silahkan login untuk upload persyaratan."));
                        
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Formulir Pendaftaran tidak dapat disimpan."));
                }
                
            }
		}
		
    	if($this->request->getVar('kode_referral')){
    	    $data = $this->request->getVar();
    	}
    	
		$data['templateJudul'] = $this->halaman_label." IAIBAFA Jombang";
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'S2';
		return view($this->halaman_controller.'/S2', $data);
		
	}
	
	function updateS2()
	{
	    if($this->request->getMethod()=="post"){
	        $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $this->request->getVar('id')]);
		    if($this->request->getVar('status_pendaftaran') == 'Mahasiswa Baru'){
		        $rulePindahan = "permit_empty";
		    }else{
		        $rulePindahan = "required";
		    }
		    $aturan = [
                
                'Nama_Lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KTP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_KK' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Tgl_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kota_Lhr' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Anak_Ke' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jml_Saudara' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Status_Perkawinan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Biaya_ditanggung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_wa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'No_HP' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kewarganegaraan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RT' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'RW' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Dusun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Prov' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kab' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kec' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Desa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Kode_Pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Jenis_Domisili' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Transportasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Penerima_KPS' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Status_Asal_Sekolah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kejuruan_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Lengkap_SLTA_Asal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Th_Lulus_SLTA' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Nama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Nomor_KTP_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Tempat_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Tgl_Lhr_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'Agama_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ], 
                'Kewarganegaraan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RT_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'RW_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Dusun_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Prov_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kab_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kec_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Desa_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Kode_Pos_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pekerjaan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Pendidikan_Terakhir_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'Penghasilan_Ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ayah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                 'No_HP_ibu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                
                
                $record_data_diri = [
                    'id' => $this->request->getVar('id'),
                    'Nama_Lengkap' => $this->request->getVar('Nama_Lengkap'),
                    'Jenis_Kelamin' => $this->request->getVar('Jenis_Kelamin'),
                    'Gol_Darah' => $this->request->getVar('Gol_Darah'),
                    'Kota_Lhr' => $this->request->getVar('Kota_Lhr'),
                    'Tgl_Lhr' => $this->request->getVar('Tgl_Lhr'),
                    'Alamat' => $this->request->getVar('Alamat'),
                    'No_Rmh' => $this->request->getVar('No_Rmh'),
                    'RT' => $this->request->getVar('RT'),
                    'RW' => $this->request->getVar('RW'),
                    'Dusun' => $this->request->getVar('Dusun'),
                    'Desa' => $this->request->getVar('Desa'),
                    'Kec' => $this->request->getVar('Kec'),
                    'Kab' => $this->request->getVar('Kab'),
                    'Kode_Pos' => $this->request->getVar('Kode_Pos'),
                    'Prov' => $this->request->getVar('Prov'),
                    'Jenis_Domisili' => $this->request->getVar('Jenis_Domisili'),
                    'Tempat_Domisili' => $this->request->getVar('Tempat_Domisili'),
                    'No_Telp_Hp' => $this->request->getVar('No_Telp_Hp'),
                    'no_wa' => $this->request->getVar('no_wa'),
                    'No_KTP' => $this->request->getVar('No_KTP'),
                    'No_KK' => $this->request->getVar('No_KK'),
                    'Agama' => $this->request->getVar('Agama'),
                    'Kewarganegaraan' => $this->request->getVar('Kewarganegaraan'),
                    'Status_Perkawinan' => $this->request->getVar('Status_Perkawinan'),
                    'Pekerjaan' => $this->request->getVar('Pekerjaan'),
                    'Biaya_ditanggung' => $this->request->getVar('Biaya_ditanggung'),
                    'Transportasi' => $this->request->getVar('Transportasi'),
                    'Status_Asal_Sekolah' => $this->request->getVar('Status_Asal_Sekolah'),
                    'Nama_Lengkap_SLTA_Asal' => $this->request->getVar('Nama_Lengkap_SLTA_Asal'),
                    'Kejuruan_SLTA' => $this->request->getVar('Kejuruan_SLTA'),
                    'Th_Lulus_SLTA' => $this->request->getVar('Th_Lulus_SLTA'),
                    'Anak_Ke' => $this->request->getVar('Anak_Ke'),
                    'Jml_Saudara' => $this->request->getVar('Jml_Saudara'),
                    'No_HP' => $this->request->getVar('No_HP'),
                    'Penerima_KPS' => $this->request->getVar('Penerima_KPS'),
                    'No_KPS' => $this->request->getVar('No_KPS')
                    
                ];
                
                $record_ortu = [
                    
                    'Nama_Ayah' => $this->request->getVar('Nama_Ayah'), 
                    'Tempat_Lhr_Ayah' => $this->request->getVar('Tempat_Lhr_Ayah'), 
                    'Tgl_Lhr_Ayah' => $this->request->getVar('Tgl_Lhr_Ayah'), 
                    'Agama_Ayah' => $this->request->getVar('Agama_Ayah'), 
                    'Gol_Darah_Ayah' => $this->request->getVar('Gol_Darah_Ayah'), 
                    'Pendidikan_Terakhir_Ayah' => $this->request->getVar('Pendidikan_Terakhir_Ayah'), 
                    'Pekerjaan_Ayah' => $this->request->getVar('Pekerjaan_Ayah'), 
                    'Penghasilan_Ayah' => $this->request->getVar('Penghasilan_Ayah'), 
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
                    'Kewarganegaraan_Ibu' => $this->request->getVar('Kewarganegaraan_Ibu'),
                    'No_HP_ayah' => $this->request->getVar('No_HP_ayah'),
                    'No_HP_ibu' => $this->request->getVar('No_HP_ibu'),
                ];
                
                
                $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
                if($MahasiswaModel->save($record_data_diri)){
                    
                    updateDataDinamis('db_ortu_mhs', $record_ortu, ['id' => $data_diri['id']]);
                    if($this->request->getVar('Nama_Lengkap') != $data_diri['Nama_Lengkap']){
                        updateDataDinamis('users', ['nama_lengkap' => $this->request->getVar('Nama_Lengkap')], ['username' => $data_diri['username']]);
                    }
                    return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Formulir pendaftaran berhasil diupdate."));
                        
                }else{
                    return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Formulir Pendaftaran tidak dapat diupdate."));
                }
                
            }
		}
	}
}
