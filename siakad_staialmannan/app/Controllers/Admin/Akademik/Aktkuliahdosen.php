<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\PerkuliahanModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Aktkuliahdosen extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->perkuliahan = new PerkuliahanModel($request);
        $this->halaman_controller = "aktkuliahdosen";
        $this->halaman_label = "Aktifitas Kuliah Dosen";
    }
    
    public function index()
    {
        $data = [];
        
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function cekData()
    {
        $aturan = [
                'tahun_akademik' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'tgl_awal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'tgl_akhir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors()));
            }else{
                return json_encode(array("msg" => "success"));
            }
    }
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            
            $lists = $this->perkuliahan->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Prodi');
                $prod =[]; 
                foreach ($prodi as $key ) {
                   $prod[] = $key->Prodi;
                }
                $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Kelas');
                $kls =[]; 
                foreach ($kelas as $key ) {
                   $kls[] = $key->Kelas;
                }
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->Nama_Dosen;
                $row[] = $list->Mata_Kuliah;
                $row[] = (!empty($list->Pelaksanaan))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $list->Pelaksanaan])['opt_val']:'-';
                $row[] = implode(" - ",$prod);
                $row[] = implode(" - ",$kls);
                $row[] = $list->SMT;
                $row[] = getCount('tb_jurnal_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan, 'tanggal >=' => $this->request->getVar('tgl_awal'), 'tanggal <=' => $this->request->getVar('tgl_akhir')], null, 'tanggal')['tanggal'];
                $row[] = '<a onclick="detail('."'".$list->kd_kelas_perkuliahan."','".$this->request->getVar('tgl_awal')."','".$this->request->getVar('tgl_akhir')."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->perkuliahan->countAll(),
                'recordsFiltered' => $this->perkuliahan->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function detail()
    {
        $data = [];
        
        if ($this->request->getMethod(true)=='POST') {    
            if($this->request->getVar('aksi')=='changeRekapJurnal' && $this->request->getVar('id_jurnal_kuliah')){
                $JurnalkuliahModel = new \App\Models\JurnalkuliahModel($this->request);
                $dataJurnal = $JurnalkuliahModel->find($this->request->getVar('id_jurnal_kuliah'));
                if($dataJurnal['id_jurnal_kuliah']){ #memastikan ada data
                    if($dataJurnal['is_rekap'] == 'N'){
                        $record = [
                            'id_jurnal_kuliah' => $this->request->getVar('id_jurnal_kuliah'),
                            'is_rekap' => 'Y'
                        ];
                        
                        if($JurnalkuliahModel->save($record)){
                            //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                            return json_encode(array("status" => TRUE, "msg" => "success", "pesan" => "Jurnal berhasil direkap"));
                        }else{
                            return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal gagal direkap"));
                        }
                    }else{
                        $record = [
                            'id_jurnal_kuliah' => $this->request->getVar('id_jurnal_kuliah'),
                            'is_rekap' => 'N'
                        ];
                        
                        if($JurnalkuliahModel->save($record)){
                            //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                            return json_encode(array("status" => TRUE, "msg" => "success", "pesan" => "Jurnal tidak direkap"));
                        }else{
                            return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal tetap direkap"));
                        }
                    }
                }
            }
        }
        
        
		$data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
		$data['tgl_awal']    = $this->request->getVar('tgl_awal');
		$data['tgl_akhir']    = $this->request->getVar('tgl_akhir');
		$data['templateJudul'] = "Rekap Perkuliahan Periode ".short_tgl_indonesia_date($this->request->getVar('tgl_awal'))." s/d ".short_tgl_indonesia_date($this->request->getVar('tgl_akhir'));
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        
		return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function listJurnalPerkuliahan()
    {
        $JurnalkuliahModel = new \App\Models\JurnalkuliahModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $JurnalkuliahModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = tgl_indonesia_date($list->tanggal);
                $row[] = $list->topik;
                $row[] = $list->metode_kuliah;
                if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "BAK"){
                $row[] = $list->is_rekap == 'Y' ? '<a onclick="changeRekapJurnal('."'".$list->id_jurnal_kuliah."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="changeRekapJurnal('."'".$list->id_jurnal_kuliah."'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->perkuliahan->countAll(),
                //'recordsFiltered' => $this->perkuliahan->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    function cetakRekap()
    {
        if($this->request->getVar('fakultas'))
        {
            $prodi = [];
            $dataProdi = dataDinamis('prodi', ['sing_fak' => $this->request->getVar('fakultas')], null, null, null, null, null, 'singkatan');
            foreach ($dataProdi as $val){
                $prodi[] = $val->singkatan;
            }
           $this->perkuliahan->whereIn('Prodi', $prodi);
        }
        if($this->request->getVar('prodi'))
        {
            $this->perkuliahan->where('mata_kuliah.Prodi', $this->request->getVar('prodi'));
        }
        $data['mk'] = $this->perkuliahan->where(['Kd_Tahun' => $this->request->getVar('tahun_akademik'), 'kd_kelas_perkuliahan !=' => NULL])->orderBy('Kd_Dosen ASC, SMT ASC, Mata_Kuliah ASC')->groupBy('kd_kelas_perkuliahan')->findAll();
        $data['tgl_awal']    = $this->request->getVar('tgl_awal');
		$data['tgl_akhir']    = $this->request->getVar('tgl_akhir');
        $data['templateJudul'] = "Rekap Perkuliahan <br>".short_tgl_indonesia_date($this->request->getVar('tgl_awal'))." s/d ".short_tgl_indonesia_date($this->request->getVar('tgl_akhir'));
        $data['metode']    = 'cetakRekap';
        
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'margin_left' => 18,
                            	'margin_right' => 18,
                            	'margin_top' => 20,
                            	'margin_bottom' => 20,]);
    
        //$html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $output ="Rekap_Perkuliahan".$this->request->getVar('tgl_awal')."_".$this->request->getVar('tgl_akhir').".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        //$mpdf->SetHeader("<div style='color: #6495ED;font-size: 6pt;'>".base_url("akademik/$this->halaman_controller/cetakNilai?prodi=").$prodi."&kelas=".$kelas."&kd_kelas_perkuliahan=".$kd_kelas_perkuliahan."</div>");
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($html);
        
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');
            
    }
    
    function cekJurnal()
    {
        $db      = \Config\Database::connect('default');
	    $builder = $db->table('tb_jurnal_kuliah');
	    $data = $builder->groupBy('tb_jurnal_kuliah.kd_kelas_perkuliahan')->get()->getResultArray();
	    dd($data);
    }
    
}
