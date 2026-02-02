<?php

namespace App\Controllers\Admin\Tugasakhir;

use App\Controllers\BaseController;
use App\Models\DisposisiModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Disposisi extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->disposisi = new DisposisiModel($request);
        $this->halaman_controller = "disposisi";
        $this->halaman_label = "Disposisi Judul Tugas Akhir";
    }
    
    public function index()
    {
        $data = [];
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data ['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data ['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }

        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->disposisi->find($this->request->getVar('id'));
                if($dt['id_disposisi']){ #memastikan ada data
                    
                    $aksi = $this->disposisi->delete($this->request->getVar('id'));
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
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->disposisi->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                
                if($list->status=='1'){
    			    $status= '<span class="badge badge-primary">Menunggu Koreksi</span>';
    			}elseif($list->status=='2'){
    			    $status= '<span class="badge badge-success">Diterima</span>';
    			}elseif($list->status=='3'){
    			    $status= '<span class="badge badge-danger">Ditolak</span>';
    			}
                
                $no++;
                $row = [];
                if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "Kaprodi" || session()->get('akun_level') == "Fakultas"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_disposisi.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags($list->judul_disposisi);
                $row[] = getDataRow('ref_option', ['opt_id' => $list->status, 'opt_group' => 'status_disposisi'])['opt_val'];
                //$row[] = strip_tags($list->catatan_kaprodi);
                $row[] = (!empty($list->reviewer))?getDataRow('data_dosen', ['Kode' => $list->reviewer])['Nama_Dosen']:'';
                $row[] = (!empty($list->tgl_kualifikasi) && $list->tgl_kualifikasi != '0000-00-00')?short_tgl_indonesia_date($list->tgl_kualifikasi):'';
                $row[] = (!empty($list->dosen_pembimbing))?getDataRow('data_dosen', ['Kode' => $list->dosen_pembimbing])['Nama_Dosen']:'';
                $row[] = tgl_indonesia_short($list->created_at);
                $row[] = '<a onclick="detail('."'".$list->id_disposisi."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail Disposisi"><i class="fa fa-eye"></i></a>
                        <a onclick="cetak('."'".$list->id_disposisi."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Disposisi"><i class="fa fa-print"></i></a>    
                        <a onclick="hapus('."'".$list->id_disposisi."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Disposisi"><i class="fa fa-trash"></i></a>
                        ';
                }
                if(session()->get('akun_level') == "Dosen"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_disposisi.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags(bersihkan_html($list->judul_disposisi));
               
                $row[] = '<a onclick="detail('."'".$list->id_disposisi."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail Disposisi"><i class="fa fa-eye"></i></a>
                        
                        ';
                }
                if(session()->get('akun_level') == "Mahasiswa"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_disposisi.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = strip_tags($list->judul_disposisi);
                $row[] = getDataRow('ref_option', ['opt_id' => $list->status, 'opt_group' => 'status_disposisi'])['opt_val'];
                $row[] = (!empty($list->dosen_pembimbing))?getDataRow('data_dosen', ['Kode' => $list->dosen_pembimbing])['Nama_Dosen']:'';
                $row[] = /*$list->tgl_dibuat*/tgl_indonesia_short($list->created_at);
                $row[] = '<a onclick="detail('."'".$list->id_disposisi."'".'); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail Disposisi"><i class="fa fa-eye"></i></a>
                        <a onclick="cetak('."'".$list->id_disposisi."'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Disposisi"><i class="fa fa-print"></i></a>        
                            ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->disposisi->countAll(),
                'recordsFiltered' => $this->disposisi->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {
        
        $data = $this->disposisi->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("status" => false));
        }else{
            echo json_encode(array("status" => true));
        }
        
    }
    
    
    function detail()
    {
        $data = [];
        
        if($this->request->getVar('id_disposisi')){
			$data = $this->disposisi->find($this->request->getVar('id_disposisi'));
			$data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
		}
		
		if($this->request->getMethod()=="post"){
            if(session()->get('akun_level') == 'Kaprodi' || session()->get('akun_level') == 'Fakultas'){
                $record = [
                    'id_disposisi' => $this->request->getVar('id_disposisi'),
                    'status' => $this->request->getVar('status'),
                    'reviewer' => $this->request->getVar('reviewer'),
                    'tgl_kualifikasi' => $this->request->getVar('tgl_kualifikasi'),
                    'dosen_pembimbing' => $this->request->getVar('dosen_pembimbing')
                ];
            }

            if(session()->get('akun_level') == 'Dosen'){
                $record = [
                    'id_disposisi' => $this->request->getVar('id_disposisi'),
                    'status' => $this->request->getVar('status'),
                    'catatan_kaprodi' => $this->request->getVar('catatan_kaprodi')
                ];
            }

            $aksi = $this->disposisi->simpanData($record);
            if($aksi){
                return json_encode(array("msg" => "success", "pesan" => "Hasil ujian kualifikasi berhasil disimpan."));
            }else{
                return json_encode(array("msg" => "error", "pesan" => "Hasil ujian kualifikasi gagal disimpan."));
            }
        }
         
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function formulir()
    {
        $data = [];
        
        if($this->request->getVar('id_his_pdk')){
            $krsModel = new \App\Models\KrsModel($this->request);
			$MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data ['id_data_diri']= getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')])['id_data_diri'];
            $data ['id_his_pdk'] = $this->request->getVar('id_his_pdk');
            $dtKrs = $krsModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']])->first();
            if(session()->get('akun_username') !== 'rosian42'){
                if(empty($dtKrs) || $dtKrs['stat_mhs'] != 'A'){
    		        session()->setFlashdata("info", "warning");
    		    }
            }
		}
		
		if($this->request->getMethod()=="post"){
		    
		    $aturan = [
                'judul-part-inp' => [
                    'rules' => 'required|cek_jumlah_kata[5,15]',
                    'errors' => [
                        'required'=>'Rencana judul skripsi tidak boleh kosong!!',
                        'cek_jumlah_kata' => 'Judul penelitian minimal 5 s.d 15 kata.'
                    ]
                ],
                'problem-part-inp' => [
                    'rules' => 'required|cek_jumlah_kata[100,250]',
                    'errors' => [
                        'required'=>'Problematika / permasalahan penelitian tidak boleh kosong!!',
                        'cek_jumlah_kata' => 'Problematika / permasalahan penelitian minimal 100 s.d 250 kata.'
                    ]
                ],
                'rumusan-part-inp' => [
                    'rules' => 'required|cek_jumlah_kata[20,40]',
                    'errors' => [
                        'required'=>'Rumusan masalah / fokus penelitian tidak boleh kosong!!',
                        'cek_jumlah_kata' => 'Rumusan masalah / fokus penelitian minimal 20 s.d 40 kata.'
                    ]
                ],
                'file_disposisi' => [
                    'rules' => 'uploaded[file_disposisi]|mime_in[file_disposisi,application/pdf]|ext_in[file_disposisi,pdf]|max_size[file_disposisi,1028]',
                    'errors' => [
                        'uploaded' => 'File disposisi harus diupload!!',
                        'mime_in' => 'File disposisi harus berformat PDF',
                        'ext_in' => 'File disposisi Anda bukan PDF',
                        'max_size' => 'File disposisi maksimal 1 MB'
                    ]
                ],
                'kata_kunci' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Kata kunci tidak boleh kosong!!'
                    ]
                ]
            ];
            
            $file = $this->request->getFile('file_disposisi');
            
            if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
			}else{
                if($file->getName()){
					$nm_file = $file->getRandomName();
                    $path = 'upload/file_disposisi/';
                    //$post_thumbnail = $path.'/'.$nm_file;
                    $file->move($path, $nm_file);
				}
                $record = [
                    'tahun_akademik' => getDataRow('tahun_akademik', ['aktif' => 'y'])['kode'],
                    'id_his_pdk' => $this->request->getVar('id_his_pdk'),
                    'judul_disposisi' => $this->request->getVar('judul-part-inp'),
                    'problem_disposisi' => $this->request->getVar('problem-part-inp'),
                    'rumusan_disposisi' => $this->request->getVar('rumusan-part-inp'),
                    'kata_kunci' => $this->request->getVar('kata_kunci'),
                    'file_disposisi' => $nm_file
                ];
                $aksi = $this->disposisi->simpanData($record);
                if($aksi){
                    return json_encode(array("msg" => "success", "pesan" => "Formulir disposisi judul skripsi berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Formulir disposisi judul skripsi gagal disimpan."));
                }
			}
        }
         
        $data['templateJudul'] = "Formulir ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'formulir';
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function cetak()
    {
        
        $data['templateJudul'] = "Cetak Disposisi";
        $data['metode']    = 'cetak';
        $id_disposisi = $this->request->getvar('id_disposisi');
        $data['disposisi']         = $this->disposisi->find($this->request->getVar('id_disposisi'));
		$data['id_data_diri']      = getDataRow('histori_pddk', ['id_his_pdk' => $data['disposisi']['id_his_pdk']])['id_data_diri'];
		$data['id_his_pdk']         = $data['disposisi']['id_his_pdk'];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
                                'margin_right' => 10,
                                'margin_top' => 40,
                                'margin_bottom' => 10,]);
        
        $html = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $output ="Disposisi_".getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap'].".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');

        //return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }

    public function ekspor()
    {
        
        $list_id = $this->request->getVar('id');
        $data               = [];
        //$index                = 0;
        foreach ($list_id as $id ) {
            $disposisi = getDataRow('disposisi_skripsi',['id_disposisi' => $id]);
            $his_pdk = getDataRow('histori_pddk', ['id_his_pdk' => $disposisi['id_his_pdk']]);
            array_push($data, array(
                'nama' => getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['Nama_Lengkap'],
                'prodi' => $his_pdk['Prodi'],
                'program' => $his_pdk['Program'],
                'nim' => $his_pdk['NIM'],
                'judul' => strip_tags(bersihkan_html($disposisi['judul_disposisi'])),
                'reviewer' => (!empty($disposisi['reviewer']))?getDataRow('data_dosen', ['Kode' => $disposisi['reviewer']])['Nama_Dosen']:'',
                'tgl_ujian' => (!empty($disposisi['tgl_kualifikasi']))?tgl_indonesia_short($disposisi['tgl_kualifikasi']):'',
                'pembimbing' => (!empty($disposisi['dosen_pembimbing']))?getDataRow('data_dosen', ['Kode' => $disposisi['dosen_pembimbing']])['Nama_Dosen']:'',
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
        
        $sheet->setCellValue('A1', "DATA DISPOSISI JUDUL SKRIPSI ". getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'GASAL':'GENAP') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA MAHASISWA');
        $sheet->setCellValue('C3', 'NIM');
        $sheet->setCellValue('D3', 'PRODI');
        $sheet->setCellValue('E3', 'PROGRAM');
        $sheet->setCellValue('F3', 'JUDUL');
        $sheet->setCellValue('G3', 'REVIEWER');
        $sheet->setCellValue('H3', 'TGL. UJIAN');
        $sheet->setCellValue('I3', 'PEMBIMBING');
        
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
        
        $sheet->getStyle('A3:I3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa
            
            
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $val['nama']);
            $sheet->setCellValueExplicit('C'.$numrow, $val['nim'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D'.$numrow, $val['prodi']);
            $sheet->setCellValue('E'.$numrow, $val['program']);
            $sheet->setCellValue('F'.$numrow, $val['judul']);
            $sheet->setCellValue('G'.$numrow, $val['reviewer']);
            $sheet->setCellValue('H'.$numrow, $val['tgl_ujian']);          
            $sheet->setCellValue('I'.$numrow, $val['pembimbing']);          
          
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
        $sheet->setTitle("DISPOSISI JUDUL");
        //$sheet->getStyle('A:AU')->getNumberFormat()->setFormatCode('@');
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-Disposisi-Judul-Skripsi-'.getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'Gasal':'Genap');
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
    
    
    // Fungsi Tambahan Perbaiki data
    function perbaikiData()
    {
        
        if($this->request->getMethod()=="post"){
            $jmlSukses          = 0;
            $jmlError           = 0;
            $listError          = [];
            
            foreach ($this->request->getVar('id') as $key ) {                
                $dt = getDataRow('disposisi_skripsi', ['id_disposisi'=>$key]);
                $record = [
                        'id_disposisi' => $key,
                        'id_his_pdk' => getDataRow('histori_pddk', ['id_mhs'=>$dt['id_mhs'], 'Prodi' => $dt['prodi']])['id_his_pdk'],
                        'created_at' => ubah_ke_datetime($dt['tgl_dibuat'])
                    ];
                
                if($this->disposisi->save($record)){
                            
                    $jmlSukses++;
                }else{
                    $jmlError++;
                    $listError [] = [
                        'pesan'     => getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $record['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']." gagal diupdate."
                    ];
                };
            }
            if($jmlError > 0){
                return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Disposisi berhasi diupdate, ".$jmlError." gagal diupdate.", 'listError' => $listError));
            }else{
                return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Disposisi berhasil diupdate."));
            }  
            
        }
    }
    
    
}
