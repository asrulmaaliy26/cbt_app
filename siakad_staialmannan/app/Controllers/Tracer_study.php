<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TracerStudyModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Tracer_study extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->tracer = new TracerStudyModel($request);
    	$this->halaman_controller = "tracer_study";
    	$this->halaman_label = "Tracer Study";
    }

	public function index()
	{

		$data = [];
    	

		$data['templateJudul'] = $this->halaman_label." IAIBAFA Jombang";
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
		return view($this->halaman_controller.'/index', $data);
		
	}

    function getMhs()
    {
        $CariModel = new \App\Models\CariModel();
        $json =[];
        $val = $this->request->getVar('search');
        $where = ['Prodi' => $this->request->getVar('prodi')];
        $data = $CariModel->getHistoriAutoComplete($val, $where);
        
        foreach ($data as $row) {    
            $json[] = ['id'=>$row->id_his_pdk, 'text'=>$row->Nama_Lengkap." - ".$row->NIM, 'id_mhs'=>$row->id_data_diri];
                       
        }
        echo json_encode($json);
    }
	
	public function simpan()
	{

		$data = [];
		
		if($this->request->getMethod()=="post"){
		    
		    $aturan = [
                'prodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'm' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'tahun_lulus' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'pekerjaan_pertama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'pekerjaan_saat_ini' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'mulai_mencari' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'waktu_tunggu' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'hubungan_ps_dengan_kerja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'dibuat_pada' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Wajib diisi!!'
                    ]
                ],
                'nama_instansi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Nama Instansi Wajib diisi!!'
                    ]
                ]
            ];
            
            if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
            }else{
                //$cek = $this->tracer->where(['id_his_pdk' => $this->request->getVar('m')])->get();
                $cek = getDataRow('tb_tracer_study', ['id_his_pdk' => $this->request->getVar('m')]);
                if(empty($cek)){
                    $record= [
                        'id_mhs' => $this->request->getVar('id_mhs'), 
                        'id_his_pdk' => $this->request->getVar('m'), 
                        'tahun_lulus' => $this->request->getVar('tahun_lulus'), 
                        'no_hp' => $this->request->getVar('no_hp'), 
                        'pekerjaan_pertama' => $this->request->getVar('pekerjaan_pertama'), 
                        'pekerjaan_saat_ini' => $this->request->getVar('pekerjaan_saat_ini'), 
                        'nama_instansi' => $this->request->getVar('nama_instansi'), 
                        'mulai_mencari' => $this->request->getVar('mulai_mencari'), 
                        'waktu_tunggu' => $this->request->getVar('waktu_tunggu'), 
                        'hubungan_ps_dengan_kerja' => $this->request->getVar('hubungan_ps_dengan_kerja'), 
                        'dibuat_pada' => $this->request->getVar('dibuat_pada')
                    ];
                    
                    
                    if($this->tracer->save($record)){
                        
                        return json_encode(array("status"=>true, "msg" => "success", "pesan" => "Tracer study berhasil disimpan."));
                            
                    }else{
                        return json_encode(array("status"=>false, "msg" => "error", "pesan" => "Tracer study tidak dapat disimpan."));
                    }
                }else{
                        return json_encode(array("status"=>false, "msg" => "info", "pesan" => "Anda sudah pernah mengisi tracer study."));
                }
                
                
            }
		}
		
    	
		
	}

    public function laporan()
	{

		$data = [];
    	

		$data['templateJudul'] = $this->halaman_label." IAIBAFA Jombang";
		$data['controller'] = $this->halaman_controller;
		$data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'laporan';
		return view($this->halaman_controller.'/laporan', $data);
		
	}

    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->tracer->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_tracer.'" />';
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $list->tahun_lulus;
                $row[] = $list->pekerjaan_saat_ini;
                $row[] = $list->nama_instansi;
                $row[] = getDataRow('ref_option', ['opt_group' => 'mulai_mencari_kerja', 'opt_id' => $list->mulai_mencari])['opt_val'];
                $row[] = getDataRow('ref_option', ['opt_group' => 'waktu_tunggu', 'opt_id' => $list->waktu_tunggu])['opt_val'];
                $row[] = getDataRow('ref_option', ['opt_group' => 'hub_ps_kerja', 'opt_id' => $list->hubungan_ps_dengan_kerja])['opt_val'];
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->tracer->countAll(),
                'recordsFiltered' => $this->tracer->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
	
	public function ekspor()
    {
        
        $list_id = $this->request->getVar('id');
		$data 				= [];
		foreach ($list_id as $id ) {
		    $data_tracer = getDataRow('tb_tracer_study', ['id_tracer' => $id]);
            $data_diri = getDataRow('db_data_diri_mahasiswa', ['id' => $data_tracer['id_mhs']]);
            $data_histori_pddk = getDataRow('histori_pddk', ['id_his_pdk' => $data_tracer['id_his_pdk']]);
			array_push($data, array(
				'Nama' => $data_diri['Nama_Lengkap'],
				'Prodi' => $data_histori_pddk['Prodi'],
				'NIM' => $data_histori_pddk['NIM'],
				'tahun_lulus' => $data_tracer['tahun_lulus'],
				'no_hp' => $data_tracer['no_hp'],
				'pekerjaan_pertama' => $data_tracer['pekerjaan_pertama'],
				'pekerjaan_saat_ini' => $data_tracer['pekerjaan_saat_ini'],
				'nama_instansi' => $data_tracer['nama_instansi'],
				'mulai_mencari' => getDataRow('ref_option', ['opt_group' => 'mulai_mencari_kerja', 'opt_id' => $data_tracer['mulai_mencari']])['opt_val'],
				'waktu_tunggu' => getDataRow('ref_option', ['opt_group' => 'waktu_tunggu', 'opt_id' => $data_tracer['waktu_tunggu']])['opt_val'],
				'hub_ps_kerja' => getDataRow('ref_option', ['opt_group' => 'hub_ps_kerja', 'opt_id' => $data_tracer['hubungan_ps_dengan_kerja']])['opt_val'],
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
        
        $sheet->setCellValue('A1', "Data Tracer Study" ); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'Nama ');
        $sheet->setCellValue('C3', 'NIM');
        $sheet->setCellValue('D3', 'Prodi');
        $sheet->setCellValue('E3', 'Tahun Lulus');
        $sheet->setCellValue('F3', 'No HP');
        $sheet->setCellValue('G3', 'Pekerjaan Pertama');
        $sheet->setCellValue('H3', 'Pekerjaan Saat Ini');
        $sheet->setCellValue('I3', 'Nama Instansi');
        $sheet->setCellValue('J3', 'Waktu Memulai Mencari Pekerjaan');
        $sheet->setCellValue('K3', 'Waktu Tunggu Memperoleh Pekerjaan');
        $sheet->setCellValue('L3', 'Hub. PS dengan Pekerjaan');

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
        
        $sheet->getStyle('A3:L3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa
            
            
          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $val['Nama']);
          $sheet->setCellValue('C'.$numrow, $val['NIM']);
          $sheet->setCellValue('D'.$numrow, $val['Prodi']);
          $sheet->setCellValue('E'.$numrow, $val['tahun_lulus']);
          $sheet->setCellValue('F'.$numrow, "'".$val['no_hp']);
          $sheet->setCellValue('G'.$numrow, $val['pekerjaan_pertama']);
          $sheet->setCellValue('H'.$numrow, $val['pekerjaan_saat_ini']);
          $sheet->setCellValue('I'.$numrow, $val['nama_instansi']);
          $sheet->setCellValue('J'.$numrow, $val['mulai_mencari']);
          $sheet->setCellValue('K'.$numrow, $val['waktu_tunggu']);
          $sheet->setCellValue('L'.$numrow, $val['hub_ps_kerja']);
          
          
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
        $sheet->setTitle("Tracer Study");
        $sheet->getStyle('A:AU')->getNumberFormat()->setFormatCode('@');
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-Tracer-Study';
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
