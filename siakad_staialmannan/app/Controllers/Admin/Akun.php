<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
//use App\Models\AdminModel;
class Akun extends BaseController
{
	function __construct()
    {
    	
    	$this->validation = \Config\Services::validation();
    	$this->m_user = new UserModel();
    	//$this->m_admin = new AdminModel();
    	helper('global_helper');
    	//untuk konfigurasi internal
    	$this->halaman_controller = "akun";
    	$this->halaman_label = "Akun";
    }

	public function index()
	{
		$data = [];
		if($this->request->getMethod() == 'post'){
			$data = $this->request->getVar();
			$email = $this->request->getVar('email');
			$password_lama = $this->request->getVar('password_lama');
			$password_baru = $this->request->getVar('password_baru');
			$password_baru_konfirmasi = $this->request->getVar('password_baru_konfirmasi');
			if($email != session()->get('akun_email')){
				$ruleEmail = 'required|is_unique[users.email]|valid_email';
			}else{
				$ruleEmail = 'required|valid_email';
			}
			$aturan = [
                'email' => [
                    'rules' => $ruleEmail,
                    'errors' => [
                        'required'=>'Email harus diisi',
                        'is_unique' => 'Email '.$this->request->getVar('email').' sudah ada. Silahkan gunakan email yang lain.',
                        'valid_email' => 'Email anda tidak valid'
                    ]
                ]
            ];
			if($password_baru != ''){
				$aturan = [
					'password_lama' => [
						'rules' => 'required|check_password_lama_user[password_lama]',
						'errors' => [
							'required' => 'Password lama harus diisi',
							'check_password_lama_user' => 'Password lama salah'
						]
					],
					'password_baru' => [
						'rules' => 'min_length[6]|alpha_numeric',
						'errors' => [
							'min_length' => 'Panjang paswword minimal 6 karakter',
							'alpha_numeric' => 'Hanya huruf, angka dan beberapa simbol saja yang diperbolehkan'
						]
					],
					'password_baru_konfirmasi' => [
						'rules' => 'matches[password_baru]',
						'errors' => [
							'matches' => 'Konfirmasi password tidak sama dengan password baru'
						]
					]
				];
			}

			if(!$this->validate($aturan)){
				session()->setFlashdata('warning', $this->validation->getErrors());
			}else{
				if($email != session()->get('akun_email')){
					$dataUpdate = [
						'id' => session()->get('akun_id'),
						'email' => $email
					];
					$this->m_user->save($dataUpdate);
					$sesi = [
						'akun_email' => $email
					];
					session()->set($sesi);
				}
				if($password_baru != ''){
				    $password_baru_tanpa_hash = $password_baru;
					$password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
					$dataUpdate = [
						'id' => session()->get('akun_id'),
						'password_hash' => $password_baru,
						'password_plain' => $password_baru_tanpa_hash
					];

					$this->m_user->save($dataUpdate);

					helper('cookie');
					if(get_cookie('cookie_password')){
						set_cookie('cookie_username', session()->get('akun_username'), 3600 * 24 * 30);
						set_cookie('cookie_password', $password_baru, 3600 * 24 * 30);

					}
				}
				session()->setFlashdata('success', 'Data berhasil diupdate');

			}
			
			//return redirect()->to('admin/'.$this->halaman_controller)->withCookies;
			
			return redirect()->back()->withCookies();
		}

		//$username = session()->get('akun_username');
		$idUser = session()->get('akun_id');
		$data = $this->m_user->find($idUser);

		$data['templateJudul'] = $this->halaman_label;
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
		//echo view('admin/v_templateheader', $data);
		return view('v_akun', $data);
		//echo view('admin/v_templatefooter', $data);
	}

}
?>