<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Services;
use App\Libraries\Elfinder_lib;

class File_manager extends BaseController
{
    function __construct()
    {
        
        $this->validation = \Config\Services::validation();
        $this->halaman_controller = "file_manager";
        $this->halaman_label = "File Manager";
    }
    
    public function index()
    {
        $data = [];
        //$path = FCPATH.'berkas_mahasiswa';
        //dd(base_url('berkas_mahasiswa'));
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function elfinderInit(){
        if(session()->get('akun_level') == 'Teknisi'){
            $folder_sistem = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
            if($folder_sistem == 'jurnal'){
                $path = FCPATH .'../jurnal';
                $url = 'https://jurnal.iaibafa.ac.id';
            }
            if($folder_sistem == 'new_akademik'){
                $path = FCPATH .'../../new_akademik';
                $url = base_url();
            }
        }
        if(session()->get('akun_level') == 'Admin'){
            
            $path = FCPATH;
            $url = base_url();
            
        }
        $opts = array(
         // 'debug' => true, 
         'roots' => array(
           array( 
                'driver' => 'LocalFileSystem',
                'path'          => $path,
                'URL'          => $url,
                
             // more elFinder options here
           )
         )
        );
       $connector = new Elfinder_lib();
       $connector->run($opts);
    }

    
}
