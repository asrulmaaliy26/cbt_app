<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
class Dashboard extends BaseController
{
	protected string $halaman_controller;
    protected string $halaman_label;
	
    function __construct()
    {
        
    	$this->halaman_controller = "dashboard";
    	$this->halaman_label = "Dashboard";
    }

	public function index()
	{

		$data = [];
    	if($this->request->getMethod(true) == "POST"){
    	    $role = getDataRow('auth_groups', ['id'=>$this->request->getPost('role')])['name'];
    		$sesi = [
    		    'akun_level_id' => $this->request->getPost('role'),
    			'akun_level' => $role,
    			'akun_group_folder' => getDataRow('auth_groups', ['id'=>$this->request->getPost('role')])['folder_name'],
    		];
    		
    		session()->set($sesi);

    		if(!empty(session()->get('akun_level'))){
    			
    			return json_encode(array("msg" => "success", "pesan" => "Anda login sebagai <strong>".session()->get('akun_level')."</strong>"));
    		}else{
    			return json_encode(array("msg" => "error", "pesan" => "Sesi gagal disimpan"));
    		}

    	}

		
		if(!empty(session()->get('akun_level'))){
			//$role = getDataRow('auth_groups', ['id'=>session()->get('akun_level')])['name'];
			if(session()->get('akun_level') === "Mahasiswa Baru"){	
				$request = Services::request();
				$model = new \App\Models\MahasiswaModel($request);
				$username = session()->get('akun_username');
	            $data['data_diri'] = $model->where('username', $username)->first();
	            $data['ortu'] = getDataRow('db_ortu_mhs', ['id' => $data['data_diri']['id']]);
	            $data['pmb'] = getDataRow('db_pmb', ['id' => $data['data_diri']['id']]);
	            $data['templateJudul'] = $this->halaman_label." Calon Mahasiswa";
	            $data['controller'] = $this->halaman_controller;
	            $data['aktif_menu'] = $this->halaman_controller;
        		$data['metode']    = '';
        		if($data['pmb']['program_sekolah'] == 'S1'){
	                return view('pendaftaran/dashboard_camaba', $data);
        		}
        		if($data['pmb']['program_sekolah'] == 'S2'){
	                return view('pendaftaran/dashboard_camaba_s2', $data);
        		}
	        }else{
	        	$data['templateJudul'] = $this->halaman_label;
	        	$data['controller'] = $this->halaman_controller;
		        $data['aktif_menu'] = $this->halaman_controller;
        		$data['metode']    = '';
				return view('dashboard', $data);
	        }
		}
		$data['templateJudul'] = $this->halaman_label;
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = '';
		return view('dashboard', $data);
		
	}
}
