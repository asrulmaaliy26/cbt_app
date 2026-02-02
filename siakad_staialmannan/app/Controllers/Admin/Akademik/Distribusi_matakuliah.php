<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\DistribusiMkModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Distribusi_matakuliah extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->distribusi = new DistribusiMkModel($request);
        $this->halaman_controller = "distribusi_matakuliah";
        $this->halaman_label = "Distribusi Matakuliah";
    }
    
    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->distribusi->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->distribusi->delete($this->request->getVar('id'));
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
        return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->distribusi->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                //$link_detail = site_url("dashboard/$this->halaman_controller/detail/").$list->id_kurikulum;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Prodi;
                $row[] = $list->Kelas;
                $row[] = $list->SMT;
                $row[] = $list->Nama_Dosen;
                $row[] = $list->H_Jadwal;
                $row[] = $list->Jam_Jadwal;
                $row[] = $list->R_Jadwal;
                if(session()->get('akun_level') == "Admin"){
                    $row[] = '<a onclick="hapus('."'".$list->id."','".$list->Mata_Kuliah."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                    <!--<a onclick="edit('."'".$list->id."'".'); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> -->
                    ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->distribusi->countAll(),
                'recordsFiltered' => $this->distribusi->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function getData()
    {

        $data = $this->distribusi->find($this->request->getVar('id'));

        if(empty($data)){
            echo json_encode(array("msg" => false));
        }else{
            echo json_encode(array("msg" => true, "data" => $data));
        }
        
    }
    
    public function simpanJadwal()
    {

        if($this->request->getMethod()=="post"){

            $aturan = [
                'dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Dosen wajib diisi!!'
                    ]
                ],
                'H_Jadwal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Hari wajib diisi!!'
                    ]
                ],
                'jam' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Jam wajib diisi!!'
                    ]
                ],
                'ruang_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Ruang wajib diisi!!'
                    ]
                ],
                'pelaksanaan_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pelaksanaan wajib diisi!!'
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            }else{
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                $Kd_Dosen           = $this->request->getVar('dosen');
                $Kd_hari            = getDataRow('ref_option',['opt_group' => 'hari', 'opt_val' => $this->request->getVar('H_Jadwal'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_jam            = getDataRow('ref_option',['opt_group' => 'jam_kuliah', 'opt_val' => $this->request->getVar('jam'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_ruang            = $this->request->getVar('ruang_kuliah');
                $kd_tahun           = $this->request->getVar('kd_tahun');
                $cekJadwal = $this->distribusi->where(['Kd_Tahun' => $kd_tahun, 'H_Jadwal' => $this->request->getVar('H_Jadwal'), 'Jam_Jadwal' => $this->request->getVar('jam'), 'R_Jadwal' => $Kd_ruang])->first();
                if(!empty($cekJadwal)){
                    return json_encode(array("msg" => "error", "pesan" => "Hari ".$this->request->getVar('H_Jadwal')." Jam ".$this->request->getVar('jam')." Ruang ".$Kd_ruang." sudah digunakan matakuliah ".$cekJadwal['Mata_Kuliah']." Dosen ".getDataRow('data_dosen', ['Kode' =>$cekJadwal['Kd_Dosen']])['Nama_Dosen']));
                }else{
                    foreach ($this->request->getVar('id_distribusi_mk') as $key ) {                
                        $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                        $record = [
                            'id' => $key,
                            'kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang,
                            'Kd_Dosen' => $Kd_Dosen,
                            'H_Jadwal' => $this->request->getVar('H_Jadwal'),
                            'Jam_Jadwal' => $this->request->getVar('jam'),
                            'R_Jadwal' => $Kd_ruang,
                            'Pelaksanaan' => $this->request->getVar('pelaksanaan_kuliah')
                        ];
                        if($this->distribusi->save($record)){
                            $NilaiModel = new \App\Models\NilaiModel($this->request);
                            $JurnalModel = new \App\Models\JurnalkuliahModel($this->request);
                            $NilaiModel->where(['id_mk' => $key])->set(['kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang])->update();
                            $JurnalModel->where(['kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan']])->set(['kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang])->update();
                            $jmlSukses++;
                        }else{
                            $jmlError++;
                            $listError [] = [
                                'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal diupdate."
                            ];
                        };
                    }
                    if($jmlError > 0){
                        return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate, ".$jmlError." gagal diupdate.", 'listError' => $listError));
                    }else{
                        return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate."));
                    } 
                }
            }
        }
        
    }

    public function tetapsimpanJadwal()
    {

        if($this->request->getMethod()=="post"){

            $aturan = [
                'dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Dosen wajib diisi!!'
                    ]
                ],
                'H_Jadwal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Hari wajib diisi!!'
                    ]
                ],
                'jam' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Jam wajib diisi!!'
                    ]
                ],
                'ruang_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Ruang wajib diisi!!'
                    ]
                ],
                'pelaksanaan_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pelaksanaan wajib diisi!!'
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            }else{
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                $Kd_Dosen           = $this->request->getVar('dosen');
                $Kd_hari            = getDataRow('ref_option',['opt_group' => 'hari', 'opt_val' => $this->request->getVar('H_Jadwal'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_jam            = getDataRow('ref_option',['opt_group' => 'jam_kuliah', 'opt_val' => $this->request->getVar('jam'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_ruang            = $this->request->getVar('ruang_kuliah');
                $kd_tahun           = $this->request->getVar('kd_tahun');
                
                foreach ($this->request->getVar('id_distribusi_mk') as $key ) {                
                    $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                    $record = [
                        'id' => $key,
                        'kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang,
                        'Kd_Dosen' => $Kd_Dosen,
                        'H_Jadwal' => $this->request->getVar('H_Jadwal'),
                        'Jam_Jadwal' => $this->request->getVar('jam'),
                        'R_Jadwal' => $Kd_ruang,
                        'Pelaksanaan' => $this->request->getVar('pelaksanaan_kuliah')
                    ];
                    if($this->distribusi->save($record)){
                        $NilaiModel = new \App\Models\NilaiModel($this->request);
                        $JurnalModel = new \App\Models\JurnalkuliahModel($this->request);
                        $NilaiModel->where(['id_mk' => $key])->set(['kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang])->update();
                        $JurnalModel->where(['kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan']])->set(['kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'].$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang])->update();
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal diupdate."
                        ];
                    };
                }
                if($jmlError > 0){
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate, ".$jmlError." gagal diupdate.", 'listError' => $listError));
                }else{
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil diupdate."));
                } 
            }
        }
        
    }
    
    public function hapus_kolektif()
    {
        if($this->request->getMethod()=="post"){


            $jmlSukses          = 0;
            $jmlError           = 0;
            $listError          = [];
            
            foreach ($this->request->getVar('id') as $key ) {                
                $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                $aksi = $this->distribusi->delete($key);
                if($aksi){
                    $jmlSukses++;
                }else{
                    $jmlError++;
                    $listError [] = [
                        'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal dihapus."
                    ];
                };
            }
            if($jmlError > 0){
                return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil dihapus, ".$jmlError." gagal dihapus.", 'listError' => $listError));
            }else{
                return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil dihapus."));
            }  
            
        }
    }
    
    public function reset_jadwal()
    {
        if($this->request->getMethod()=="post"){


            $jmlSukses          = 0;
            $jmlError           = 0;
            $listError          = [];
            
            foreach ($this->request->getVar('id') as $key ) {                
                $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                $record = [
                    'id' => $key,
                        //'kd_kelas_perkuliahan' => NULL,
                    'Kd_Dosen' => NULL,
                    'H_Jadwal' => NULL,
                    'Jam_Jadwal' => NULL,
                    'R_Jadwal' => NULL
                ];
                
                if($this->distribusi->save($record)){

                    $jmlSukses++;
                }else{
                    $jmlError++;
                    $listError [] = [
                        'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal direset."
                    ];
                };
            }
            if($jmlError > 0){
                return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil direset, ".$jmlError." gagal direset.", 'listError' => $listError));
            }else{
                return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil direset."));
            }  
            
        }
    }
    
    public function generate_kd_perkuliahan()
    {
        if($this->request->getMethod()=="post"){


            $jmlSukses          = 0;
            $jmlError           = 0;
            $listError          = [];
            
            foreach ($this->request->getVar('id') as $key ) {                
                $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                $Kd_Dosen           = $dtMk['Kd_Dosen'];
                $Kd_hari            = getDataRow('ref_option',['opt_group' => 'hari', 'opt_val' => $dtMk['H_Jadwal'], 'is_aktif' => 'Y'])['opt_id'];
                $Kd_jam            = getDataRow('ref_option',['opt_group' => 'jam_kuliah', 'opt_val' => $dtMk['Jam_Jadwal'], 'is_aktif' => 'Y'])['opt_id'];
                $Kd_ruang            = $dtMk['R_Jadwal'];
                $kd_tahun           = $dtMk['Kd_Tahun'];
                $record = [
                    'id' => $key,
                    'kd_kelas_perkuliahan' => $kd_tahun.$Kd_Dosen.$Kd_hari.$Kd_jam.$Kd_ruang
                ];
                
                if($this->distribusi->save($record)){

                    $jmlSukses++;
                }else{
                    $jmlError++;
                    $listError [] = [
                        'pesan'     => $dtMk['Mata_Kuliah']." ".$dtMk['Prodi']." ".$dtMk['Kelas']." gagal dibuatkan kelas perkuliahan."
                    ];
                };
            }
            if($jmlError > 0){
                return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil , ".$jmlError." gagal .", 'listError' => $listError));
            }else{
                return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil dibuatkan kode perkuliahan."));
            }  
            
        }
    }
    
    public function ekspor()
    {

        $list_id = $this->request->getVar('id');
        $data 				= [];
		//$index 				= 0;
        foreach ($list_id as $id ) {
          $mk = getDataRow('mata_kuliah',['id' => $id]);
          array_push($data, array(
            'id' => $mk['id'],
            'Kd_Tahun' => $mk['Kd_Tahun'],
            'Kode' => $mk['Kode_MK_Feeder'],
            'mata_kuliah' => $mk['Mata_Kuliah'],
            'SKS' => $mk['SKS'],
            'Prodi' => $mk['Prodi'],
            'SMT' => $mk['SMT'],
            'Kelas' => $mk['Kelas'],
            'Kd_Dosen' => $mk['Kd_Dosen'],
            'dosen' => (!empty($mk['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$mk['Kd_Dosen']])['Nama_Dosen']:'',
            'H_Jadwal' => $mk['H_Jadwal'],
            'Jam_Jadwal' => $mk['Jam_Jadwal'],
            'R_Jadwal' => $mk['R_Jadwal'],
            'Pelaksanaan' => (!empty($mk['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $mk['Pelaksanaan']])['opt_val']:'',
            'Kd_Hari' => (!empty($mk['H_Jadwal']))?getDataRow('ref_option', ['opt_group' => 'hari', 'opt_val' => $mk['H_Jadwal']])['opt_id']:'',
            'Kd_Jam' => (!empty($mk['Jam_Jadwal']))?getDataRow('ref_option', ['opt_group' => 'jam_kuliah', 'opt_val' => $mk['Jam_Jadwal']])['opt_id']:'',
            'Kd_Pelaksanaan' => $mk['Pelaksanaan'],
            'kd_kelas_perkuliahan' => $mk['kd_kelas_perkuliahan'],
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

        $sheet->setCellValue('A1', "DISTRIBUSI MATAKULIAH ". getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'GASAL':'GENAP') ); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        
        
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'KODE MK');
        $sheet->setCellValue('C3', 'MATAKULIAH');
        $sheet->setCellValue('D3', 'KODE DOSEN');
        $sheet->setCellValue('E3', 'NAMA DOSEN');
        $sheet->setCellValue('F3', 'SKS');
        $sheet->setCellValue('G3', 'PRODI');
        $sheet->setCellValue('H3', 'SMT');
        $sheet->setCellValue('I3', 'KELAS');
        $sheet->setCellValue('J3', 'HARI');
        $sheet->setCellValue('K3', 'JAM');
        $sheet->setCellValue('L3', 'RUANG');
        $sheet->setCellValue('M3', 'PELAKSANAAN');
        $sheet->setCellValue('N3', 'KODE TAHUN');
        $sheet->setCellValue('O3', 'KODE HARI');
        $sheet->setCellValue('P3', 'KODE JAM');
        $sheet->setCellValue('Q3', 'KODE PELAKSANAAN');
        $sheet->setCellValue('R3', 'KODE KELAS PERKULIAHAN');
        $sheet->setCellValue('S3', 'ID DISTRIBUSI MK');
        
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
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);
        $sheet->getStyle('R3')->applyFromArray($style_col);
        $sheet->getStyle('S3')->applyFromArray($style_col);
        
        $sheet->getStyle('A3:M3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data as $r => $val){ // Lakukan looping pada variabel siswa

          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $val['Kode']);
          $sheet->setCellValue('C'.$numrow, $val['mata_kuliah']);
          $sheet->setCellValue('D'.$numrow, $val['Kd_Dosen']);
          $sheet->setCellValue('E'.$numrow, $val['dosen']);
          $sheet->setCellValue('F'.$numrow, $val['SKS']);
          $sheet->setCellValue('G'.$numrow, $val['Prodi']);
          $sheet->setCellValue('H'.$numrow, $val['SMT']);
          $sheet->setCellValue('I'.$numrow, $val['Kelas']);
          $sheet->setCellValue('J'.$numrow, $val['H_Jadwal']);
          $sheet->setCellValue('K'.$numrow, $val['Jam_Jadwal']);
          $sheet->setCellValue('L'.$numrow, $val['R_Jadwal']);
          $sheet->setCellValue('M'.$numrow, $val['Pelaksanaan']);
          $sheet->setCellValue('N'.$numrow, $val['Kd_Tahun']);
          $sheet->setCellValue('O'.$numrow, $val['Kd_Hari']);
          $sheet->setCellValue('P'.$numrow, $val['Kd_Jam']);
          $sheet->setCellValue('Q'.$numrow, $val['Kd_Pelaksanaan']);
          $sheet->setCellValue('R'.$numrow, $val['kd_kelas_perkuliahan']);
          $sheet->setCellValue('S'.$numrow, $val['id']);
          
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
          $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('O'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('P'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('Q'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('R'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('S'.$numrow)->applyFromArray($style_row);
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
    $sheet->setTitle("Distribusi Matakuliah ");
    $sheet->getStyle('A:AU')->getNumberFormat()->setFormatCode('@');
    $writer = new Xlsx($spreadsheet);
    $filename = date('Y-m-d-His'). '-Distribusi-Matakuliah-'.getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester']=='1'?'Gasal':'Genap');
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

    function updateJadwalExcel()
    {
        //$request = Services::request();
        //$model = new SiswaModel($request);
        if($this->request->getMethod()=="post"){
            //$path           = 'document/admin/';
            $file_excel = $this->request->getFile('file_xlsUpdate');
            //$file_excel = $this->uploadFile($path, $file_excel);
            $ext = $file_excel->getClientExtension();
            if($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_excel);
            $data = $spreadsheet->getActiveSheet()->toArray();
            //$listSiswa = [];
            //$listUser = [];
            $listError = [];
            $jmlSukses = 0;
            $jmlError = 0;
            foreach($data as $x => $row) {                
                $id = $row[18];
                $kd_kelas_perkuliahan = $row[17];
                $kd_dosen = $row[3];
                $h_jadwal = $row[9];
                $jam_jadwal = $row[10];
                $r_jadwal = $row[11];
                $pelaksanaan = $row[16];
                $nama_dosen = $row[4];
                $mata_kuliah = $row[2];

                if ($x < 3) {
                    continue;
                }
                if($id === '') {
                    $jmlError++;
                    $listError [] = [
                        'nama_dosen'    => $nama_dosen,
                        'mata_kuliah'    => $mata_kuliah,
                        'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                        'id'      => $id,
                        'error'          => "Kolom ID Distribusi tidak boleh kosong",
                    ];
                    continue;
                }
                $cekData = getDataRow('mata_kuliah', ['id'=>$id]);

                if(!empty($cekData)){
                    $record_update = [
                        'id'      => $id,
                        'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                        'Kd_Dosen' => $kd_dosen,
                        'H_Jadwal' => $h_jadwal,
                        'Jam_Jadwal' => $jam_jadwal,
                        'R_Jadwal' => $r_jadwal,
                        'Pelaksanaan' => $pelaksanaan
                    ];
                    
                    if($this->distribusi->save($record_update)){

                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'nama_dosen'    => $nama_dosen,
                            'mata_kuliah'    => $mata_kuliah,
                            'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                            'id'      => $id,
                            'error'          => "Tidak Terupdate",
                        ];
                    }
                    
                }else{
                    $jmlError++;
                    $listError [] = [
                        'nama_dosen'    => $nama_dosen,
                        'mata_kuliah'    => $mata_kuliah,
                        'kd_kelas_perkuliahan'    => $kd_kelas_perkuliahan,
                        'id'      => $id,
                        'error'          => "Data Distribusi MK tidak ditemukan",
                    ];
                } 
            } // end foreach
            return json_encode(array("msg" => "info", "pesan" => "Sukses update ".$jmlSukses. ", Gagal update ".$jmlError, 'listError' => $listError));

        } // end if
    }
}