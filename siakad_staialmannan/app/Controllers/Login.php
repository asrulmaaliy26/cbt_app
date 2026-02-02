<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    protected $login;
    protected $validation;
    
    function __construct()
    {
    	$this->login = new LoginModel();
    	$this->validation = \Config\Services::validation();
    	
    }
    public function index()
    {
        helper(['cookie']);
    
        /** ----------------------------------------------------
         * 1. CEK REMEMBER ME COOKIE
         * ---------------------------------------------------- */
        if (get_cookie("remember_token")) {
            $token = get_cookie("remember_token");
    
            $dataAkun = $this->login->getByToken($token); // Anda harus buat fungsi ini pada model
    
            if ($dataAkun) {
    
                // Set session
                session()->set([
                    'akun_id'          => $dataAkun['id'],
                    'akun_username'    => $dataAkun['username'],
                    'akun_nama_lengkap'=> $dataAkun['nama_lengkap'],
                    'akun_email'       => $dataAkun['email'],
                ]);
    
                return redirect()->to('sukses');
            } else {
                delete_cookie("remember_token");
            }
        }
    
        /** ----------------------------------------------------
         * 2. KETIKA FORM LOGIN DIPOST
         * ---------------------------------------------------- */
        if ($this->request->getMethod() == 'post') {
    
            $rules = [
                'username' => 'required',
                'password_hash' => 'required'
            ];
    
            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validator->getErrors());
                session()->setFlashdata("username", $this->request->getVar('username'));
                return redirect()->to("/");
            }
    
            $username     = $this->request->getVar('username');
            $password     = $this->request->getVar('password_hash');
            $remember_me  = $this->request->getVar('remember_me');
    
            /** Ambil detail user */
            $dataAkun = $this->login->getData($username);
    
            if (empty($dataAkun)) {
    
                // Catat log login gagal (Fail2ban bisa membaca ini)
                log_message('error', 'Login failed: user not found | user: ' . $username . ' | IP: ' . $this->request->getIPAddress());
    
                session()->setFlashdata("warning", ["Akun tidak ditemukan"]);
                session()->setFlashdata("username", $username);
                return redirect()->to("/");
            }
    
            /** Password salah */
            if (!password_verify($password, $dataAkun['password_hash'])) {
    
                log_message('error', 'Login failed: wrong password | user: ' . $username . ' | IP: ' . $this->request->getIPAddress());
    
                session()->setFlashdata("warning", ["Password salah atau username tidak ditemukan"]);
                session()->setFlashdata("username", $username);
                return redirect()->to("/");
            }
    
            /** ----------------------------------------------------
             * 3. LOGIN BERHASIL → BUAT SESSION
             * ---------------------------------------------------- */
            session()->set([
                'akun_id'          => $dataAkun['id'],
                'akun_username'    => $dataAkun['username'],
                'akun_nama_lengkap'=> $dataAkun['nama_lengkap'],
                'akun_email'       => $dataAkun['email'],
            ]);
    
            /** ----------------------------------------------------
             * 4. REMEMBER ME – menggunakan token aman
             * ---------------------------------------------------- */
            if ($remember_me == 1) {
    
                // buat token random
                $token = bin2hex(random_bytes(32));
    
                // simpan token ke database
                $this->login->updateToken($dataAkun['id'], $token);
    
                // simpan ke cookie (30 hari)
                set_cookie("remember_token", $token, 3600*24*30);
            }
    
            return redirect()->to('sukses')->withCookies();
        }
    
        /** ----------------------------------------------------
         * 5. TAMPILKAN FORM LOGIN
         * ---------------------------------------------------- */
        return view('v_login2');
    }
    
    public function updateToken($id, $token)
    {
        return $this->db->table('user')
            ->where('id', $id)
            ->update(['remember_token' => $token]);
    }
    
    public function getByToken($token)
    {
        return $this->db->table('user')
            ->where('remember_token', $token)
            ->get()
            ->getRowArray();
    }

    // public function index()
    // {
    //     if(get_cookie("cookie_username") && get_cookie("cookie_password")){
    // 		$username = get_cookie("cookie_username");
    // 		$password = get_cookie("cookie_password");

    // 		$dataAkun = $this->login->getData($username);
    // 		if($password != $dataAkun['password_hash']){
    // 			$err[] = "Password salah atau username tidak ditemukan";
    // 			session()->setFlashdata("username", $username);
    // 			session()->setFlashdata("warning", $err);

    // 			delete_cookie('cookie_username');
    // 			delete_cookie('cookie_password');
    // 			//return redirect()->to("admin/login");
    //             return redirect()->to("/");
    // 		}

    // 		$akun =[
    // 			'akun_username' => $dataAkun['username'],
    // 			'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
    // 			'akun_email' => $dataAkun['email'],
    // 			//'akun_level' => getUserGroup($dataAkun['id']),
    //             'akun_id' => $dataAkun['id']
    // 		];
    // 		session()->set($akun);
    // 		//return redirect()->to('admin/sukses');
    //         return redirect()->to('sukses');
    // 	}
    // 	if($this->request->getMethod() == 'post'){
    // 		$rules = [
    // 			'username' => [
    // 				'rules' => 'required',
    // 				'errors' =>[
    // 					'required' => 'Username harus diisi'
    // 				]
    // 			],
    // 			'password_hash' => [
    // 				'rules' => 'required',
    // 				'errors' =>[
    // 					'required' => 'Password harus diisi'
    // 				]	
    // 			]
    // 		];
    // 		if (!$this->validate($rules)) {
    // 		    session()->setFlashdata("username", $this->request->getVar('username'));
    // 			session()->setFlashdata("warning", $this->validation->getErrors());
    // 			//return redirect()->to("admin/login");
    //             return redirect()->to("/");
    // 		}

    // 		$username = $this->request->getVar('username');
    // 		$password = $this->request->getVar('password_hash');
    // 		$remember_me = $this->request->getVar('remember_me');
    		

    // 		$dataAkun = $this->login->getData($username);
    //         if(empty($dataAkun)){
    //             $err[] = 'Akun tidak ditemukan';
    //             session()->setFlashdata("username", $username);
    //             session()->setFlashdata("warning", $err);
    //             //return redirect()->to("admin/login");
    //             return redirect()->to("/");
    //         }
    // 		if(!password_verify($password, $dataAkun['password_hash'])){
    // 			$err[] = 'Password salah atau username tidak ditemukan';
    // 			session()->setFlashdata("username", $username);
    // 			session()->setFlashdata("warning", $err);
    // 			//return redirect()->to("admin/login");
    //             return redirect()->to("/");
    // 		}

    // 		if($remember_me == 1){
    // 			set_cookie("cookie_username", $username, 3600*24*30);
    // 			set_cookie("cookie_password", $dataAkun['password_hash'], 3600*24*30);
    // 		}

    // 		$akun = [
    // 			'akun_username' => $dataAkun['username'],
    // 			'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
    // 			'akun_email' => $dataAkun['email'],
    // 			//'akun_level' => getUserGroup($dataAkun['id']),
    //             'akun_id' => $dataAkun['id']
    // 		];
    // 		session()->set($akun);
    // 		//return redirect()->to('admin/sukses')->withCookies();
    //         return redirect()->to('sukses')->withCookies();
    // 	}
    //     //echo view('admin/v_login');
    //     return view('v_login2');
    // }
    
    public function sukses()
    {
    	$groupUser = getUserGroup(session()->get('akun_id'));
        //dd($level->getResultArray());
        if($groupUser->getNumRows() > 1){
            return redirect()->to('dashboard');
        }else{
            $level = $groupUser->getRowArray();
            if($level['name'] == 'Mahasiswa'){
				$dt = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')]);
				if(!empty($dt) && $dt['stat_mhs'] !== "A"){
					session()->destroy();
					$err[] = 'Anda sudah tidak diijinkan mengakses siakad IAIBAFA';
					session()->setFlashdata("warning", $err);
					return redirect()->to('/');
				}
            };
            $sesi = [
               'akun_level_id' => $level['group_id'],
               'akun_level' => $level['name'],
               'akun_group_folder' => $level['folder_name'],
            ];
            session()->set($sesi);
            return redirect()->to('dashboard');
        }
    	//print_r(session()->get());
    	//echo "isian cookie username".get_cookie('cookie_username')." dan password ".get_cookie('cookie_password');
    }

    public function logout()
    {
    	delete_cookie('cookie_username');
    	delete_cookie('cookie_password');
    	session()->destroy();
    	if(session()->get('akun_username') != ''){
    		session()->setFlashdata('success', 'Anda telah keluar');
    	}
    	//echo view('admin/v_login');
    	return redirect()->to(base_url())->withCookies();
    }

    public function lupapassword()
    {
    	$err = [];
    	if($this->request->getMethod() == 'post'){
    		$username = $this->request->getVar('username');
    		if($username == ''){
    			$err[]= 'Silahkan masukkan Username atau Email Anda';
    		}
    		if(empty($err)){
    			$data = $this->login->getData($username);
    			if(empty($data)){
    				$err[] = "Akun anda tidak ditemukan";
    			}
    		}
    		if(empty($err)){
    			$email = $data['email'];
    			$token= md5(date('ymdhis'));
    			$link = site_url('resetpassword/?email=').$email."&token=".$token;
    			$attachment ='';
    			$to = $email;
    			$tittle = "Reset Password";
    			$message = "Berikut ini adalah link untuk reset password Anda.";
    			$message .="Silahkan klik link berikut ini ".$link;
    			kirim_email($attachment, $to, $tittle, $message);

    			$dataUpdate = [
    				'email' => $email,
    				'reset_hash' => $token
    			];
    			$this->login->updateData($dataUpdate);
    			session()->setFlashdata("success", "Email untuk reset password terkirim ke email anda");
    		}
    		if($err){
    			session()->setFlashdata("username",$username);
    			session()->setFlashdata("warning",$err);
    		}
    		return redirect()->to('lupapassword');
    	}
    	echo view('admin/v_lupapassword');
    }

    public function resetpassword()
    {
    	$err = [];
    	$email = $this->request->getVar('email');
    	$token = $this->request->getVar('token');
    	if($email != '' && $token != ''){
    		$dataAkun	= $this->login->getData($email);
    		if($dataAkun['reset_hash'] != $token){
    			$err[] = "Token tidak valid";
    		}
    	}else{
    		$err[] = "Parameter yang dikirim tidak valid";
    	}

    	if($err){
    		session()->setFlashdata('warning',$err);
    	}

    	if($this->request->getMethod() == 'post'){
    		$aturan = [
    			'password_hash' => [
    				'rules' => 'required|min_length[8]',
    			    'errors' => [
    			    	'required' => 'Password harus diisi',
    			    	'min_length' => 'Password kurang dari 8 karakter'
    			    ]
    			],
    			'konfirmasi_password' => [
    				'rules' => 'required|min_length[8]|matches[password_hash]',
    			    'errors' => [
    			    	'required' => 'Konfirmasi Password harus diisi',
    			    	'min_length' => 'KonfirmasiPassword kurang dari 8 karakter',
    			    	'matches' => 'Konfirmasi password tidak sesuai dengan password yang diisikan'
    			    ]
    			]
    		];
    		if(!$this->validate($aturan)){
    			session()->setFlashdata('warning',$this->validation->getErrors());
    		}else{
    			$dataUpdate = [
    				'email' => $email,
    				'password_hash' => password_hash($this->request->getVar('password_hash'), PASSWORD_DEFAULT),
    				'reset_hash' => null
    			];
    			$this->login->updateData($dataUpdate);
    			delete_cookie('cookie_username');
    			delete_cookie('cookie_password');
    			session()->setFlashdata('success', 'Password berhasil diupdate silahkan login kembali');
    			return redirect()->to('login')->withCookies();
    		}
    	}
    	echo view('v_resetpassword');
    }
}