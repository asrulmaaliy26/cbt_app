<?php

namespace App\Controllers\Admin\Akreditasi;

use App\Controllers\BaseController;
//use App\Models\ProposalModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Instrument_akreditasi extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        //$this->proposal = new ProposalModel($request);
        $this->halaman_controller = "instrument_akreditasi";
        $this->halaman_label = "Instrument Akreditasi";

        if (!session()->has('akun_username')) {
            // Jika sesi habis, kembalikan respons JSON
            return $this->response->setJSON(['session_expired' => true]);
        }
    }
    
    public function index()
    {
        $data = [];
        
        
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/akreditasi/$this->halaman_controller/".$data['metode'], $data);
    }
    
    

}
