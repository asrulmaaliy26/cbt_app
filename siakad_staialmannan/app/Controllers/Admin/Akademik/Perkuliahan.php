<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\PerkuliahanModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Mpdf\HTMLParserMode;

class Perkuliahan extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->perkuliahan = new PerkuliahanModel($request);
        $this->halaman_controller = "perkuliahan";
        $this->halaman_label = "Perkuliahan";
    }

    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dt = $this->perkuliahan->find($this->request->getVar('id'));
                if ($dt['id']) { #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $this->perkuliahan->delete($this->request->getVar('id'));
                    if ($aksi == true) {
                        return json_encode(array("status" => TRUE));
                    } else {
                        return json_encode(array("status" => false));
                    }
                }
            }
        }

        if (session()->get('akun_level') == "Mahasiswa") {
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri'] = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'index';
        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function ajaxList()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->perkuliahan->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $link_detail = site_url("akademik/$this->halaman_controller/detail?kd_kelas_perkuliahan") . $list->kd_kelas_perkuliahan;
                $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Prodi');
                $prod = [];
                foreach ($prodi as $key) {
                    $prod[] = $key->Prodi;
                }
                $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list->kd_kelas_perkuliahan], null, 'Kelas');
                $kls = [];
                foreach ($kelas as $key) {
                    $kls[] = $key->Kelas;
                }
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="' . $list->kd_kelas_perkuliahan . '" />';
                $row[] = $no;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Nama_Dosen;
                $row[] = (!empty($list->Pelaksanaan)) ? getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $list->Pelaksanaan])['opt_val'] : '-';
                $row[] = implode(" - ", $prod);
                $row[] = implode(" - ", $kls);
                $row[] = $list->SMT;
                $row[] = $list->H_Jadwal;
                $row[] = $list->Jam_Jadwal;
                $row[] = $list->R_Jadwal;
                $row[] = '<!--<a onclick="hapus(' . "'" . $list->kd_kelas_perkuliahan . "','" . $list->Mata_Kuliah . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a onclick="edit(' . "'" . $list->kd_kelas_perkuliahan . "'" . '); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> -->
                            <a href="' . $link_detail . '" class="btn btn-xs btn-primary" data-placement="top" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                        ';
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

    function ajaxListPerkuliahanMahasiswa()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        $KuliahUlangModel = new \App\Models\KuliahUlangModel($this->request);

        //dd($jadwalMk);
        if ($this->request->getMethod(true) === 'POST') {
            $id_his_pdk = [];
            $his_pdk = dataDinamis('histori_pddk', ['id_data_diri' => $this->request->getVar('id_data_diri')]);
            foreach ($his_pdk as $r) {
                $id_his_pdk[] = $r->id_his_pdk;
            }

            $kdKelasMhs = $krsModel->where(['kode_ta' => $this->request->getVar('tahun_akademik')])->whereIn('id_his_pdk', $id_his_pdk)->findColumn('kode_kelas');
            if (!empty($kdKelasMhs)) {
                $mataKuliahKelas = $DistribusiMkModel->select('id as id_mk')->where('kode_kelas', $kdKelasMhs)->findAll();
                $idKuliahUlang = $KuliahUlangModel->where(['kd_ta' => $this->request->getVar('tahun_akademik')])->whereIn('id_his_pdk', $id_his_pdk)->findColumn('id');
                if (empty($idKuliahUlang)) {
                    $listMk = $mataKuliahKelas;
                } else {
                    $mataKuliahUlang = $NilaiModel->select('id_mk')->where('id_ku', $idKuliahUlang)->findAll();
                    $listMk = array_merge($mataKuliahKelas, $mataKuliahUlang);
                }
                $data = [];
                $no = $this->request->getPost('start');

                foreach ($listMk as $list) {
                    $dtMk = getDataRow('mata_kuliah', ['id' => $list]);
                    $link_detail = site_url("akademik/$this->halaman_controller/detail?kd_kelas_perkuliahan") . $dtMk['kd_kelas_perkuliahan'];
                    $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan']], null, 'Prodi');
                    $prod = [];
                    foreach ($prodi as $key) {
                        $prod[] = $key->Prodi;
                    }
                    $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $dtMk['kd_kelas_perkuliahan']], null, 'Kelas');
                    $kls = [];
                    foreach ($kelas as $key) {
                        $kls[] = $key->Kelas;
                    }
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $dtMk['Mata_Kuliah'];
                    $row[] = $dtMk['SKS'];
                    $row[] = (!empty($dtMk['Kd_Dosen'])) ? getDataRow('data_dosen', ['Kode' => $dtMk['Kd_Dosen']])['Nama_Dosen'] : '';
                    $row[] = (!empty($dtMk['Pelaksanaan'])) ? (!empty(getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $dtMk['Pelaksanaan']])) ? getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $dtMk['Pelaksanaan']])['opt_val'] : $dtMk['Pelaksanaan']) : '-';
                    $row[] = implode(" - ", $prod);
                    $row[] = implode(" - ", $kls);
                    $row[] = $dtMk['SMT'];
                    $row[] = $dtMk['H_Jadwal'];
                    $row[] = $dtMk['Jam_Jadwal'];
                    $row[] = $dtMk['R_Jadwal'];
                    $row[] = '
                                <a href="' . $link_detail . '" class="btn btn-xs btn-primary" data-placement="top" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                            ';
                    $data[] = $row;
                }

                $output = [
                    'draw' => $this->request->getPost('draw'),
                    //'recordsTotal' => $this->perkuliahan->countAll(),
                    //'recordsFiltered' => $this->perkuliahan->countFiltered(),
                    'data' => $data
                ];

                echo json_encode($output);
            } else {
                $data = [];
                $row = [];
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $data[] = $row;
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    //'recordsTotal' => $this->perkuliahan->countAll(),
                    //'recordsFiltered' => $this->perkuliahan->countFiltered(),
                    'data' => $data
                ];

                echo json_encode($output);
            }
        }
    }

    private function set_key_data_mk_mhs($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail['id_his_pdk']] = $detail;
        }

        return $return;
    }

    public function getData()
    {

        $data = $this->perkuliahan->find($this->request->getVar('id'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    public function simpanJadwal()
    {

        if ($this->request->getMethod() == "post") {

            $aturan = [
                'dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dosen wajib diisi!!'
                    ]
                ],
                'H_Jadwal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari wajib diisi!!'
                    ]
                ],
                'jam' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jam wajib diisi!!'
                    ]
                ],
                'ruang_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Ruang wajib diisi!!'
                    ]
                ],
                'pelaksanaan_kuliah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pelaksanaan wajib diisi!!'
                    ]
                ]
            ];


            if (!$this->validate($aturan)) {
                echo json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {
                $jmlSukses = 0;
                $jmlError = 0;
                $listError = [];
                $Kd_Dosen = $this->request->getVar('dosen');
                $Kd_hari = getDataRow('ref_option', ['opt_group' => 'hari', 'opt_val' => $this->request->getVar('H_Jadwal'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_jam = getDataRow('ref_option', ['opt_group' => 'jam_kuliah', 'opt_val' => $this->request->getVar('jam'), 'is_aktif' => 'Y'])['opt_id'];
                $Kd_ruang = $this->request->getVar('ruang_kuliah');
                foreach ($this->request->getVar('id_distribusi_mk') as $key) {
                    $dtMk = getDataRow('mata_kuliah', ['id' => $key]);
                    $record = [
                        'id' => $key,
                        'kd_kelas_perkuliahan' => $dtMk['Kd_Tahun'] . $Kd_Dosen . $Kd_hari . $Kd_jam . $Kd_ruang,
                        'Kd_Dosen' => $Kd_Dosen,
                        'H_Jadwal' => $this->request->getVar('H_Jadwal'),
                        'Jam_Jadwal' => $this->request->getVar('jam'),
                        'R_Jadwal' => $Kd_ruang,
                        'Pelaksanaan' => $this->request->getVar('pelaksanaan_kuliah')
                    ];
                    if ($this->perkuliahan->save($record)) {

                        $jmlSukses++;
                    } else {
                        $jmlError++;
                        $listError[] = [
                            'pesan' => $dtMk['Mata_Kuliah'] . " " . $dtMk['Prodi'] . " " . $dtMk['Kelas'] . " gagal diupdate."
                        ];
                    }
                    ;
                }
                if ($jmlError > 0) {
                    return json_encode(array("msg" => "info", "pesan" => $jmlSukses . " Matakuliah berhasil diupdate, " . $jmlError . " gagal diupdate.", 'listError' => $listError));
                } else {
                    return json_encode(array("msg" => "success", "pesan" => $jmlSukses . " Matakuliah berhasil diupdate."));
                }
            }
        }
    }

    public function ekspor()
    {

        $list_id = $this->request->getVar('id');
        $data = [];
        //$index 				= 0;
        foreach ($list_id as $id) {
            $mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $id]);
            $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $id], null, 'Prodi');
            $prod = [];
            foreach ($prodi as $key) {
                $prod[] = $key->Prodi;
            }
            $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $id], null, 'Kelas');
            $kls = [];
            foreach ($kelas as $key) {
                $kls[] = $key->Kelas;
            }
            array_push($data, array(
                'id' => $mk['id'],
                'Kode' => $mk['Kode_MK_Feeder'],
                'mata_kuliah' => $mk['Mata_Kuliah'],
                'kelas' => implode(" - ", $kls),
                'prodi' => implode(" - ", $prod),
                'SKS' => $mk['SKS'],
                'SMT' => $mk['SMT'],
                'Kd_Dosen' => $mk['Kd_Dosen'],
                'dosen' => (!empty($mk['Kd_Dosen'])) ? getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['Nama_Dosen'] : '',
                'H_Jadwal' => $mk['H_Jadwal'],
                'Jam_Jadwal' => $mk['Jam_Jadwal'],
                'R_Jadwal' => $mk['R_Jadwal'],
                'Pelaksanaan' => (!empty($mk['Pelaksanaan'])) ? getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $mk['Pelaksanaan']])['opt_val'] : '',
                'kd_kelas_perkuliahan' => $mk['kd_kelas_perkuliahan']
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
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "REKAP DISTRIBUSI MATAKULIAH " . getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester'] == '1' ? 'GASAL' : 'GENAP')); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1



        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'KODE KELAS PERKULIAHAN');
        $sheet->setCellValue('C3', 'MATAKULIAH');
        $sheet->setCellValue('D3', 'SKS');
        $sheet->setCellValue('E3', 'KODE DOSEN');
        $sheet->setCellValue('F3', 'NAMA DOSEN');
        $sheet->setCellValue('G3', 'PELAKSANAAN');
        $sheet->setCellValue('H3', 'PRODI');
        $sheet->setCellValue('I3', 'SMT');
        $sheet->setCellValue('J3', 'KELAS');
        $sheet->setCellValue('K3', 'HARI');
        $sheet->setCellValue('L3', 'JAM');
        $sheet->setCellValue('M3', 'RUANG');

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

        $sheet->getStyle('A3:M3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FFFF');

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data as $r => $val) { // Lakukan looping pada variabel siswa


            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $val['kd_kelas_perkuliahan']);
            $sheet->setCellValue('C' . $numrow, $val['mata_kuliah']);
            $sheet->setCellValue('D' . $numrow, $val['SKS']);
            $sheet->setCellValue('E' . $numrow, $val['Kd_Dosen']);
            $sheet->setCellValue('F' . $numrow, $val['dosen']);
            $sheet->setCellValue('G' . $numrow, $val['Pelaksanaan']);
            $sheet->setCellValue('H' . $numrow, $val['prodi']);
            $sheet->setCellValue('I' . $numrow, $val['SMT']);
            $sheet->setCellValue('J' . $numrow, $val['kelas']);
            $sheet->setCellValue('K' . $numrow, $val['H_Jadwal']);
            $sheet->setCellValue('L' . $numrow, $val['Jam_Jadwal']);
            $sheet->setCellValue('M' . $numrow, $val['R_Jadwal']);


            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }


        for ($i = 'A'; $i != $sheet->getHighestColumn(); $i++) {
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
        $filename = date('Y-m-d-His') . '-Rekap-Distribusi-Matakuliah-' . getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $this->request->getVar('kd_tahun')])['semester'] == '1' ? 'Gasal' : 'Genap');
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
        header('Content-Disposition: attachment; filename=' . $filename . '.xlsx');
        //$writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');

        $xlsData = ob_get_contents();
        ob_end_clean();

        $response = array(
            'nama_file' => $filename . '.xlsx',
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        die(json_encode($response));
    }

    public function detail()
    {
        $data = [];

        if (session()->get('akun_level') == "Mahasiswa") {
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri'] = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'detail';

        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    private function set_key_data($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail['id_his_pdk']] = $detail;
        }

        return $return;
    }

    // function ajaxListMhsKelas()
    // {
    //     $krsModel = new \App\Models\KrsModel($this->request);
    //     $NilaiModel = new \App\Models\NilaiModel($this->request);
    //     $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);

    //     if ($this->request->getMethod(true) === 'POST') {
    //         $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
    //         if($this->request->getVar('prodi')){
    //             $DistribusiMkModel->where('Prodi', $this->request->getVar('prodi'));
    //         }
    //         if($this->request->getVar('kelas')){
    //             $DistribusiMkModel->where('Kelas', $this->request->getVar('kelas'));
    //         }
    //         $dataMk = $DistribusiMkModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->findAll();
    //         $kode_kelas = [];
    //         foreach ($dataMk as $row => $val){
    //             $kode_kelas[] = $val['kode_kelas'];
    //         }

    //         $id_mk = [];
    //         foreach ($dataMk as $row => $val){
    //             $id_mk[] = $val['id'];
    //         }

    //         //$kd_tahun_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi'=>$prodi, 'Kelas' =>$kelas])['Kd_Tahun'];

    //         $listsMhsKrs = $krsModel->select('id_his_pdk')->whereIn('kode_kelas', $kode_kelas)->findAll();
    //         $listsMhsLjk = $NilaiModel->select('id_his_pdk')->whereIn('id_mk', $id_mk)->findAll();

    //         $result_listsMhsKrs = $this->set_key_data($listsMhsKrs);
    //         $result_listsMhsLjk = $this->set_key_data($listsMhsLjk);

    //         foreach ($result_listsMhsLjk as $index => $item) {
    //             if (isset($result_listsMhsKrs[$index]))
    //                 unset($result_listsMhsLjk[$index]);
    //         }
    //         $list_baru = array_merge(array_values($result_listsMhsLjk),array_values($result_listsMhsKrs));
    //         //dd($list_baru);
    //         $data = [];
    //         $no = $this->request->getPost('start');

    //         foreach ($list_baru as $list) {
    //             $id_data_diri = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['id_data_diri'];
    //             // $histori = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']]) ?? [];
    //             // $id_data_diri = $histori['id_data_diri'] ?? null;
    //             $th_angkatan = getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['th_angkatan'];

    //             $no++;
    //             $row = [];
    //             if(session()->get('akun_level') != "Mahasiswa"){
    //             $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list['id_his_pdk'].'" />';
    //             }
    //             $row[] = $no;
    //             if(session()->get('akun_username') == "Administrator"){
    //                 $row[] = $list['id_his_pdk'];
    //                 $row[] = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['id_mhs'];
    //                 $row[] = $id_data_diri;
    //             }else{
    //                 if(session()->get('akun_level') != "Mahasiswa"){
    //                 $row[] = /*$id_data_diri;*/strtoupper(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['Nama_Lengkap'])." ".
    //                         ((!empty(getDataRow('tb_kosma_kelas_perkuliahan', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'id_his_pdk'=> $list['id_his_pdk']])))?'<a href="javascript:void(0)" class="btn btn-xs btn-primary" onclick="hapusKosma('."'".getDataRow('tb_kosma_kelas_perkuliahan', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'id_his_pdk'=> $list['id_his_pdk']])['id']."'".')" data-placement="top" title="Click untuk menghapus kosma">Kosma</a>':'')
    //                         ;
    //                 }
    //                 if(session()->get('akun_level') == "Mahasiswa"){
    //                 $row[] = /*$id_data_diri;*/strtoupper(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['Nama_Lengkap'])." ".
    //                         ((!empty(getDataRow('tb_kosma_kelas_perkuliahan', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'id_his_pdk'=> $list['id_his_pdk']])))?'<span class="badge badge-primary">Kosma</span>':'')
    //                         ;
    //                 }
    //                 $row[] = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['NIM'];
    //                 $row[] = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['Prodi'];
    //                 $row[] = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['Kelas'];
    //                 $row[] = $th_angkatan;
    //                 $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'status_absen' => 'H'], null, 'status_absen')['status_absen'];
    //                 $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'status_absen' => 'S'], null, 'status_absen')['status_absen'];
    //                 $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'status_absen' => 'I'], null, 'status_absen')['status_absen'];
    //                 $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'status_absen' => 'A'], null, 'status_absen')['status_absen'];

    //             }
    //             $data[] = $row;
    //         }

    //         $output = [
    //             'draw' => $this->request->getPost('draw'),
    //             //'recordsTotal' => $this->perkuliahan->countAll(),
    //             //'recordsFiltered' => $this->perkuliahan->countFiltered(),
    //             'data' => $data
    //         ];

    //         echo json_encode($output);
    //     }
    // }
    function ajaxListMhsKelas()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');

            if ($this->request->getVar('prodi')) {
                $DistribusiMkModel->where('Prodi', $this->request->getVar('prodi'));
            }
            if ($this->request->getVar('kelas')) {
                $DistribusiMkModel->where('Kelas', $this->request->getVar('kelas'));
            }

            $dataMk = $DistribusiMkModel
                ->where(['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan])
                ->findAll();

            $kode_kelas = array_column($dataMk, 'kode_kelas');
            $id_mk = array_column($dataMk, 'id');

            $listsMhsKrs = $krsModel->select('id_his_pdk')->whereIn('kode_kelas', $kode_kelas)->findAll();
            $listsMhsLjk = $NilaiModel->select('id_his_pdk')->whereIn('id_mk', $id_mk)->findAll();

            $result_listsMhsKrs = $this->set_key_data($listsMhsKrs);
            $result_listsMhsLjk = $this->set_key_data($listsMhsLjk);

            foreach ($result_listsMhsLjk as $index => $item) {
                if (isset($result_listsMhsKrs[$index])) {
                    unset($result_listsMhsLjk[$index]);
                }
            }

            $list_baru = array_merge(array_values($result_listsMhsLjk), array_values($result_listsMhsKrs));

            // setelah $list_baru = array_merge(...);
            $list_baru = array_values($list_baru); // reindex dulu

            // Filter cepat: hapus histori_pddk yang statusnya bukan 'aktif'
            $list_baru = array_filter($list_baru, function ($item) {
                $histori = getDataRow('histori_pddk', ['id_his_pdk' => $item['id_his_pdk']]);
                $status = isset($histori['status']) ? strtoupper(trim($histori['status'])) : '';
                return $status !== 'D'; // hanya yang statusnya BUKAN D
            });

            // reindex kembali setelah array_filter
            $list_baru = array_values($list_baru);

            $data = [];
            $no = $this->request->getPost('start');

            foreach ($list_baru as $list) {
                $histori = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']]);

                if (empty($histori)) {
                    log_message('warning', 'Data histori_pddk tidak ditemukan untuk id_his_pdk: ' . $list['id_his_pdk']);
                    $histori = [];
                }

                $id_data_diri = $histori['id_data_diri'] ?? null;

                if (!$id_data_diri) {
                    log_message('warning', 'id_data_diri kosong untuk id_his_pdk: ' . $list['id_his_pdk']);
                }

                $mahasiswa = $id_data_diri
                    ? getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])
                    : [];

                if (empty($mahasiswa)) {
                    log_message('warning', 'Data db_data_diri_mahasiswa tidak ditemukan untuk id: ' . $id_data_diri);
                }

                $th_angkatan = $mahasiswa['th_angkatan'] ?? '-';
                $namaLengkap = strtoupper($mahasiswa['Nama_Lengkap'] ?? '-');

                $no++;
                $row = [];

                if (session()->get('akun_level') != "Mahasiswa") {
                    $row[] = '<input type="checkbox" class="data-check" name="check" value="' . $list['id_his_pdk'] . '" />';
                }

                $row[] = $no;

                if (session()->get('akun_username') == "Administrator") {
                    $row[] = $list['id_his_pdk'];
                    $row[] = $histori['id_mhs'] ?? '-';
                    $row[] = $id_data_diri ?? '-';
                } else {
                    $kosmaRow = getDataRow('tb_kosma_kelas_perkuliahan', [
                        'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                        'id_his_pdk' => $list['id_his_pdk']
                    ]);

                    if (empty($kosmaRow)) {
                        log_message('debug', 'Kosma tidak ditemukan untuk id_his_pdk: ' . $list['id_his_pdk']);
                    }

                    if (session()->get('akun_level') != "Mahasiswa") {
                        $btnKosma = (!empty($kosmaRow))
                            ? '<a href="javascript:void(0)" class="btn btn-xs btn-primary" onclick="hapusKosma(' . "'" . $kosmaRow['id'] . "'" . ')" data-placement="top" title="Click untuk menghapus kosma">Kosma</a>'
                            : '';
                        $row[] = $namaLengkap . " " . $btnKosma;
                    } else {
                        $badgeKosma = (!empty($kosmaRow)) ? '<span class="badge badge-primary">Kosma</span>' : '';
                        $row[] = $namaLengkap . " " . $badgeKosma;
                    }

                    $row[] = $histori['NIM'] ?? '-';
                    $row[] = $histori['Prodi'] ?? '-';
                    $row[] = $histori['Kelas'] ?? '-';
                    $row[] = $th_angkatan;

                    // gunakan null coalescing operator supaya tidak error jika getCount return null
                    foreach (['H', 'S', 'I', 'A'] as $status) {
                        $count = getCount('tb_abs_mhs', [
                            'id_his_pdk' => $list['id_his_pdk'],
                            'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                            'status_absen' => $status
                        ], null, 'status_absen');

                        if (empty($count)) {
                            log_message('debug', "Absensi kosong untuk id_his_pdk: {$list['id_his_pdk']} status: {$status}");
                        }

                        $row[] = $count['status_absen'] ?? 0;
                    }
                }

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }


    function pilihKosma()
    {
        if ($this->request->getMethod() == "post") {

            $kosmaModel = new \App\Models\KosmaModel();
            foreach ($this->request->getVar('id_his_pdk') as $key) {
                $record = [
                    'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                    'id_his_pdk' => $key,
                    'prodi' => $this->request->getVar('prodi'),
                    'kelas' => $this->request->getVar('kelas')
                ];
                if ($kosmaModel->save($record)) {
                    return json_encode(array("msg" => "success", "pesan" => "Berhasil memilih kosma"));
                } else {
                    return json_encode(array("msg" => "error", "pesan" => "Gagal memilih kosma"));
                }
                ;
            }
        }
    }

    function hapusKosma()
    {
        if ($this->request->getMethod() == "post") {

            $kosmaModel = new \App\Models\KosmaModel();
            if ($this->request->getVar('id')) {
                $dt = $kosmaModel->find($this->request->getVar('id'));
                if ($dt['id']) { #memastikan ada data
                    //@unlink($dataPost['post_thumbnail']);
                    $aksi = $kosmaModel->delete($this->request->getVar('id'));
                    if ($aksi == true) {
                        return json_encode(array("msg" => "success", "pesan" => "Berhasil menghapus kosma"));
                    } else {
                        return json_encode(array("msg" => "error", "pesan" => "Gagal menghapus kosma"));
                    }
                }
            }
        }
    }

    function cekMahasiswaKelas()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
        $prodi = $this->request->getVar('prodi');
        $kelas = $this->request->getVar('kelas');
        $kode_kelas = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['kode_kelas'];
        $id_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['id'];
        $kd_tahun_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['Kd_Tahun'];

        if ($this->request->getMethod(true) === 'POST') {
            $listsMhsKrs = $krsModel->select('id_his_pdk')->where(['kode_kelas' => $kode_kelas])->findAll();
            $listsMhsLjk = $NilaiModel->select('id_his_pdk')->where(['id_mk' => $id_mk])->findAll();

            $result_listsMhsKrs = $this->set_key_data($listsMhsKrs);
            $result_listsMhsLjk = $this->set_key_data($listsMhsLjk);

            foreach ($result_listsMhsLjk as $index => $item) {
                if (isset($result_listsMhsKrs[$index]))
                    unset($result_listsMhsLjk[$index]);
            }
            $list_baru = array_merge(array_values($result_listsMhsLjk), array_values($result_listsMhsKrs));
            //dd($list_baru);
            if (empty($list_baru)) {
                echo json_encode(array("status" => false));
            } else {
                echo json_encode(array("status" => true));
            }
        }
    }

    function cetakAbsensiKosong()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
        $prodi = $this->request->getVar('prodi');
        $kelas = $this->request->getVar('kelas');
        $kode_kelas = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['kode_kelas'];
        $id_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['id'];
        $kd_tahun_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['Kd_Tahun'];


        $listsMhsKrs = $krsModel->select('id_his_pdk')->where(['kode_kelas' => $kode_kelas])->findAll();
        $listsMhsLjk = $NilaiModel->select('id_his_pdk')->where(['id_mk' => $id_mk])->findAll();

        $result_listsMhsKrs = $this->set_key_data($listsMhsKrs);
        $result_listsMhsLjk = $this->set_key_data($listsMhsLjk);

        foreach ($result_listsMhsLjk as $index => $item) {
            if (isset($result_listsMhsKrs[$index]))
                unset($result_listsMhsLjk[$index]);
        }
        $data['list_mhs'] = array_merge(array_values($result_listsMhsLjk), array_values($result_listsMhsKrs));
        $data['id_mk'] = $id_mk;

        $data['templateJudul'] = "Cetak Absensi " . $this->halaman_label;
        $data['metode'] = 'cetakAbsensiKosong';

        $writer = new PngWriter();

        // Create QR code
        $dataQr = $id_mk . ";" . getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['Mata_Kuliah'] . ";" . getDataRow('data_dosen', ['Kode' => getDataRow('mata_kuliah', ['id' => $id_mk])['Kd_Dosen']])['Nama_Dosen'] . ";" . $prodi . "-" . getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['SMT'] . "-" . $kelas;
        $qrCode = QrCode::create($dataQr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create generic logo
        $logo = Logo::create(FCPATH . 'assets/logo_iaibafa.png')
            ->setResizeToWidth(70)
            ->setPunchoutBackground(true);

        // Create generic label
        //$label = Label::create('Label')->setTextColor(new Color(255, 0, 0));

        //$result = $writer->write($qrCode, $logo, $label);
        $result = $writer->write($qrCode, $logo);

        $data['qrcode'] = $result->getDataUri();


        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 30,
            'margin_right' => 30,
            'margin_top' => 25,
            'margin_bottom' => 20,
        ]);

        //$html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
        $html_cover = view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'] . "/cover", ["data" => $data]);
        $html_absen = view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'] . "/absen", ["data" => $data]);
        $html_jurnal = view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'] . "/jurnal", ["data" => $data]);
        $output = "Absensi_" . $prodi . "_" . $kelas . ".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div style='color: #6495ED;font-size: 6pt;'>" . base_url("akademik/$this->halaman_controller/cetakAbsensiKosong?prodi=") . $prodi . "&kelas=" . $kelas . "&kd_kelas_perkuliahan=" . $kd_kelas_perkuliahan . "</div>");
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($html_cover);
        $mpdf->WriteHTML('<pagebreak margin-left="10mm" margin-right="10mm" margin-top="15mm" margin-bottom="10mm" />');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($html_absen);
        $mpdf->WriteHTML('<pagebreak orientation="portrait" margin-left="20mm" margin-right="20mm" margin-top="15mm" margin-bottom="30mm" />');
        $mpdf->WriteHTML($html_jurnal);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output, 'I');
    }

    function absensiMhs()
    {
        $AbsensMhsModel = new \App\Models\AbsensMhsModel();
        $data = [];

        if ($this->request->getMethod() == "post") {
            $H_Jadwal = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $this->request->getVar('kode_kelas_perkuliahan')], 'kd_kelas_perkuliahan', 'H_Jadwal')['H_Jadwal'];
            $tanggal = $this->request->getVar('tanggal');
            $kd_kelas_perkuliahan = $this->request->getVar('kode_kelas_perkuliahan');
            $id_his_pdk = $this->request->getVar('id_his_pdk');
            $id_mk = $this->request->getVar('id_mk');
            $kd_kelas = $this->request->getVar('kode_kelas');
            //dd($kd_kelas);
            // if($this->request->getVar('hari') != $H_Jadwal){
            //     return json_encode(array("status"=>true, "msg" => "error", "pesan" => "Maaf, Absensi perkuliahan hanya bisa diinput pada hari ".$H_Jadwal.", sesuai dengan jadwal perkuliahan."));
            // }else{
            $index = 0;
            $jmlAbsenTersimpan = 0;
            foreach ($id_his_pdk as $r) {
                $cekAbsen = $AbsensMhsModel->where(['id_his_pdk' => $r, 'tanggal' => $tanggal, 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan])->first(); //Cek data absen
                if (empty($cekAbsen)) {
                    $record = [
                        'id_his_pdk' => $r,
                        'kd_kelas' => $kd_kelas[$index],
                        'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                        'id_mk' => $id_mk[$index],
                        'tanggal' => $tanggal,
                        'status_absen' => $this->request->getVar('abs' . $r)
                    ];
                } else {
                    $record = [
                        'id' => $cekAbsen['id'],
                        'id_his_pdk' => $r,
                        'kd_kelas' => $kd_kelas[$index],
                        'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                        'id_mk' => $id_mk[$index],
                        'tanggal' => $tanggal,
                        'status_absen' => $this->request->getVar('abs' . $r)
                    ];
                }
                if (!empty($record['status_absen'])) {
                    $AbsensMhsModel->save($record);
                    $jmlAbsenTersimpan++;
                }
                $index++;
            }
            return json_encode(array("status" => true, "msg" => "success", "pesan" => $jmlAbsenTersimpan . " absensi mahasiswa berhasil disimpan"));
            // }

        }

        if (session()->get('akun_level') == "Mahasiswa") {
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri'] = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        //dd($data);
        $data['templateJudul'] = 'Absensi Kehadiran ' . $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'absensiMhs';


        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function ListMhsKelasAbsensi()
    {
        $krsModel = new \App\Models\KrsModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {

            $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
            $tanggal = $this->request->getVar('tanggal');
            if ($this->request->getVar('prodi')) {
                $DistribusiMkModel->where('Prodi', $this->request->getVar('prodi'));
            }
            if ($this->request->getVar('kelas')) {
                $DistribusiMkModel->where('Kelas', $this->request->getVar('kelas'));
            }
            $id_mk = [];
            $kode_kelas = [];
            $dataMk = $DistribusiMkModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->findAll();
            foreach ($dataMk as $row => $val) {
                $id_mk[] = $val['id'];
                $kode_kelas[] = $val['kode_kelas'];
            }
            $listsMhsKrs = $krsModel->select('id_his_pdk')->whereIn('kode_kelas', $kode_kelas)->findAll();
            $listsMhsLjk = $NilaiModel->select('id_his_pdk')->whereIn('id_mk', $id_mk)->findAll();
            $result_listsMhsKrs = $this->set_key_data($listsMhsKrs);
            $result_listsMhsLjk = $this->set_key_data($listsMhsLjk);

            foreach ($result_listsMhsLjk as $index => $item) {
                if (isset($result_listsMhsKrs[$index]))
                    unset($result_listsMhsLjk[$index]);
            }
            // $list_mhs_kelas = array_merge(array_values($result_listsMhsLjk),array_values($result_listsMhsKrs));
            //dd($list_mhs_kelas);
            $list_mhs_kelas = array_merge(array_values($result_listsMhsLjk), array_values($result_listsMhsKrs));

            // Filter agar hanya mahasiswa dengan status ≠ 'D' di histori_pddk yang ditampilkan
            $list_mhs_kelas = array_filter($list_mhs_kelas, function ($item) {
                $histori = getDataRow('histori_pddk', ['id_his_pdk' => $item['id_his_pdk']]);
                $status = isset($histori['status']) ? strtoupper(trim($histori['status'])) : '';
                return $status !== 'D'; // hanya yang statusnya BUKAN D
            });
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($list_mhs_kelas as $list) {
                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk'],])['id_data_diri'];
                $prodi = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']])['Prodi'];
                //$kelas = getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['kelas'];
                $kelas = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']])['Kelas'];
                $th_angkatan = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan'];
                $idmk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas]);
                $kdkelas = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas]);

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);
                //$row[] = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['NIM'];
                $row[] = $prodi . " (" . $kelas . ")";
                $row[] = $th_angkatan;
                $row[] = '
                            <input type="text" name="id_his_pdk[]" class="form-control form-control-sm id_his_pdk" value="' . $list['id_his_pdk'] . '" hidden/>
                            <input type="text" name="id_mk[]" class="form-control form-control-sm id_mk" value="' . ((!empty($idmk)) ? $idmk['id'] : '') . '" hidden/>
                            <input type="text" name="kode_kelas[]" class="form-control form-control-sm kode_kelas" value="' . ((!empty($kdkelas)) ? $kdkelas['kode_kelas'] : '') . '" hidden/>
                            <div class="icheck-success d-inline">
                                <input type="radio" id="H' . $list['id_his_pdk'] . '" name="abs' . $list['id_his_pdk'] . '" ' . ((!empty(getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])) && getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])['status_absen'] == 'H') ? 'checked' : '') . '  value="H" class="abs_h">
                                <label for="H' . $list['id_his_pdk'] . '">H
                                </label>
                            </div>
                        ';
                $row[] = '
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="S' . $list['id_his_pdk'] . '" name="abs' . $list['id_his_pdk'] . '" ' . ((!empty(getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])) && getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])['status_absen'] == 'S') ? 'checked' : '') . ' value="S" class="abs_s">
                                <label for="S' . $list['id_his_pdk'] . '">S
                                </label>
                              </div>
                        ';
                $row[] = '
                            <div class="icheck-warning d-inline">
                                <input type="radio" id="I' . $list['id_his_pdk'] . '" name="abs' . $list['id_his_pdk'] . '" ' . ((!empty(getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])) && getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])['status_absen'] == 'I') ? 'checked' : '') . '  value="I" class="abs_i">
                                <label for="I' . $list['id_his_pdk'] . '">I
                                </label>
                            </div>
                        ';
                $row[] = '
                            
                              <div class="icheck-danger d-inline">
                                <input type="radio" id="A' . $list['id_his_pdk'] . '" name="abs' . $list['id_his_pdk'] . '" ' . ((!empty(getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])) && getDataRow('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'tanggal' => $tanggal])['status_absen'] == 'A') ? 'checked' : '') . '  value="A" class="abs_a">
                                <label for="A' . $list['id_his_pdk'] . '">A
                                </label>
                              </div>
                            
                        ';

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
                $row[] = $list->catatan_perkuliahan;
                if (session()->get('akun_level') == "Admin" || session()->get('akun_level') == "BAK") {
                    $row[] = $list->is_rekap == 'Y' ? '<a onclick="changeRekapJurnal(' . "'" . $list->id_jurnal_kuliah . "'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="changeRekapJurnal(' . "'" . $list->id_jurnal_kuliah . "'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
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

    function tambahJurnal()
    {
        $JurnalkuliahModel = new \App\Models\JurnalkuliahModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            $dataJurnal = $JurnalkuliahModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('kode_kelas_perkuliahan'), 'tanggal' => $this->request->getVar('tanggal')])->first(); //Cek data jurnal
            $H_Jadwal = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $this->request->getVar('kode_kelas_perkuliahan')], 'kd_kelas_perkuliahan', 'H_Jadwal')['H_Jadwal'];
            $jmlJurnal = getCount('tb_jurnal_kuliah', ['kd_kelas_perkuliahan' => $this->request->getVar('kode_kelas_perkuliahan')], null, 'kd_kelas_perkuliahan')['kd_kelas_perkuliahan']; //Cek Jumlah Jurnal
            if ($jmlJurnal < 12) {
                // if($this->request->getVar('hari') != $H_Jadwal){
                //     return json_encode(array("status"=>true, "msg" => "error", "pesan" => "Maaf, Jurnal perkuliahan Anda hanya bisa diinput pada hari ".$H_Jadwal.", sesuai dengan jadwal perkuliahan."));
                // }else{    
                if (!empty($dataJurnal)) {
                    return json_encode(array("status" => true, "msg" => "error", "pesan" => "Maaf, Jurnal perkuliahan hanya bisa diinput satu kali dalam sehari."));
                } else {
                    $aturan = [
                        'topik' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'Topik tidak boleh kosong!!'
                            ]
                        ],
                        'metode_kuliah' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'Metode perkuliahan tidak boleh kosong!!'
                            ]
                        ]
                    ];

                    if (!$this->validate($aturan)) {
                        return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
                    } else {
                        $record = [
                            'kd_kelas_perkuliahan' => $this->request->getVar('kode_kelas_perkuliahan'),
                            'topik' => $this->request->getVar('topik'),
                            'metode_kuliah' => $this->request->getVar('metode_kuliah'),
                            'tanggal' => $this->request->getVar('tanggal'),
                            'catatan_perkuliahan' => $this->request->getVar('catatan_perkuliahan'),
                        ];
                        if ($JurnalkuliahModel->save($record)) {
                            return json_encode(array("status" => true, "msg" => "success", "pesan" => "Jurnal perkuliahan berhasil disimpan"));
                        } else {
                            return json_encode(array("status" => true, "msg" => "error", "pesan" => "Jurnal perkuliahan tidak tersimpan"));
                        }
                    }
                }
                // }
            } else {
                return json_encode(array("status" => true, "msg" => "error", "pesan" => "Maaf, jurnal tidak dapat disimpan. Maksimal jumlah pertemuan adalah 10 kali pertemuan"));
            }
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        //dd($data);
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'tambahJurnal';


        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function changeRekapJurnal()
    {
        $JurnalkuliahModel = new \App\Models\JurnalkuliahModel($this->request);
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('aksi') == 'changeRekapJurnal' && $this->request->getVar('id_jurnal_kuliah')) {

                $dataJurnal = $JurnalkuliahModel->find($this->request->getVar('id_jurnal_kuliah'));
                if ($dataJurnal['id_jurnal_kuliah']) { #memastikan ada data
                    if ($dataJurnal['is_rekap'] == 'N') {
                        $record = [
                            'id_jurnal_kuliah' => $this->request->getVar('id_jurnal_kuliah'),
                            'is_rekap' => 'Y'
                        ];

                        if ($JurnalkuliahModel->save($record)) {
                            //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                            return json_encode(array("status" => TRUE, "msg" => "success", "pesan" => "Jurnal berhasil direkap"));
                        } else {
                            return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal gagal direkap"));
                        }
                    } else {
                        $record = [
                            'id_jurnal_kuliah' => $this->request->getVar('id_jurnal_kuliah'),
                            'is_rekap' => 'N'
                        ];

                        if ($JurnalkuliahModel->save($record)) {
                            //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                            return json_encode(array("status" => TRUE, "msg" => "success", "pesan" => "Jurnal tidak direkap"));
                        } else {
                            return json_encode(array("status" => false, "msg" => "error", "pesan" => "Jurnal tetap direkap"));
                        }
                    }
                }
            }
        }
    }

    function listNilai()
    {
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $id_mk = [];
            $dataMk = $DistribusiMkModel->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->findAll();
            foreach ($dataMk as $row => $val) {
                $id_mk[] = $val['id'];
            }

            if ($this->request->getVar('prodi')) {
                $NilaiModel->where('prodi_mhs', $this->request->getVar('prodi'));
            }
            if ($this->request->getVar('kelas')) {
                $NilaiModel->where('kelas_mhs', $this->request->getVar('kelas'));
            }


            $lists = $NilaiModel->whereIn('id_mk', $id_mk)->orderBy('id_mk')->findAll();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']])['id_data_diri'];
                $nama = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = (empty($list['id_ku'])) ? $nama : $nama . " <span class='badge badge-info'>Kuliah Ulang</span>";
                $row[] = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']])['Prodi'];
                $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'), 'status_absen' => 'H'], null, 'status_absen')['status_absen'];
                $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'), 'status_absen' => 'S'], null, 'status_absen')['status_absen'];
                $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'), 'status_absen' => 'I'], null, 'status_absen')['status_absen'];
                $row[] = getCount('tb_abs_mhs', ['id_his_pdk' => $list['id_his_pdk'], 'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'), 'status_absen' => 'A'], null, 'status_absen')['status_absen'];
                $row[] = $list['cekal_kuliah'] == 0 ? '<a onclick="cekal(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", $nama) . "','cekal_kuliah'" . '); return false;" role="button" data-placement="top" class="btn btn-xs btn-success" title="Klik untuk mencekal">Lolos</a>' : '<a onclick="lolos(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", $nama) . "','cekal_kuliah'" . '); return false;" role="button" data-placement="top" class="btn btn-xs btn-danger" title="Klik untuk meloloskan">Cekal</a>';
                ;
                $row[] = (!empty($list['ljk_uts']) || !empty($list['artikel_uts'])) ? '<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk(' . "'uts','" . $list['id_ljk'] . "'" . ')">Lihat</a>' : '';
                $row[] = (!empty($list['ljk']) || !empty($list['artikel'])) ? '<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk(' . "'uas','" . $list['id_ljk'] . "'" . ')">Lihat</a>' : '';
                $row[] = (!empty($list['tugas'])) ? '<a href="javascript:void(0)" role="button" class="btn btn-xs btn-success" onclick="showLjk(' . "'tugas','" . $list['id_ljk'] . "'" . ')">Lihat</a>' : '';
                $row[] = '<input type="number"  step=".01" min="3.50" max="4.00" name="nilai_uts[]" id="uts' . $list['id_ljk'] . '" class="form-control form-control-sm" onfocusout="simpan_uts(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", strtoupper($nama)) . "'" . ')" value="' . number_format($list['Nilai_UTS'], 2) . '"/>';
                $row[] = '<input type="number" step=".01" min="3.50" max="4.00" name="nilai_tugas[]" id="tugas' . $list['id_ljk'] . '" class="form-control form-control-sm" onfocusout="simpan_tugas(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", strtoupper($nama)) . "'" . ')" value="' . number_format($list['Nilai_TGS'], 2) . '"/>';
                $row[] = '<input type="number"  step=".01" min="3.50" max="4.00" name="nilai_uas[]" id="uas' . $list['id_ljk'] . '" class="form-control form-control-sm" onfocusout="simpan_uas(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", strtoupper($nama)) . "'" . ')" value="' . number_format($list['Nilai_UAS'], 2) . '"/>';
                $row[] = '<input type="number" step=".01" min="3.50" max="4.00" name="nilai_p[]" id="p' . $list['id_ljk'] . '" class="form-control form-control-sm" onfocusout="simpan_p(' . "'" . $list['id_ljk'] . "','" . str_replace("'", "`", strtoupper($nama)) . "'" . ')" value="' . number_format($list['Nilai_Performance'], 2) . '"/>';
                $row[] = number_format($list['Nilai_Akhir'], 2);
                $row[] = $list['Nilai_Huruf'];
                $row[] = $list['Status_Nilai'];
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

    function simpan_uts()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $Nilai_UTS = (!empty($this->request->getVar('nilai_uts'))) ? $this->request->getVar('nilai_uts') : '0';
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai_uts' => [
                    'rules' => 'permit_empty|decimal|less_than_equal_to[4]|greater_than_equal_to[3.3]',
                    'errors' => [
                        //'required'=>'Nilai UTS '.$nama.' tidak boleh kosong!!',
                        'decimal' => 'Nilai UTS ' . $nama . ' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UTS ' . $nama . ' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UTS ' . $nama . ' tidak boleh kurang dari 3.30'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UTS " . $nama . " !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Nilai_UTS * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai = dataDinamis('grade_nilai');
                if ($Nilai_UTS == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UTS' => $Nilai_UTS,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UTS' => $Nilai_UTS,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai UTS " . $nama . " berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai UTS " . $nama . " gagal disimpan"));
                }
                //}
            }
        }
    }

    function simpan_tugas()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $Nilai_Tugas = (!empty($this->request->getVar('nilai'))) ? $this->request->getVar('nilai') : '0';
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai' => [
                    'rules' => 'permit_empty|decimal|less_than_equal_to[4]|greater_than_equal_to[3.3]',
                    'errors' => [
                        'required' => 'Nilai Tugas ' . $nama . ' tidak boleh kosong!!',
                        'decimal' => 'Nilai Tugas ' . $nama . ' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Tugas ' . $nama . ' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Tugas ' . $nama . ' tidak boleh kurang dari 3.30'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Tugas " . $nama . " !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Uts * 20) + ($Nilai_Tugas * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai = dataDinamis('grade_nilai');
                if ($Uts == 0 or $Nilai_Tugas == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_TGS' => $Nilai_Tugas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_TGS' => $Nilai_Tugas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai Tugas " . $nama . " berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai Tugas " . $nama . " gagal disimpan"));
                }
                //}
            }
        }
    }

    function simpan_uas()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $Uas = (!empty($this->request->getVar('nilai'))) ? $this->request->getVar('nilai') : '0';
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $perf = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_Performance'];
            $aturan = [
                'nilai' => [
                    'rules' => 'permit_empty|decimal|less_than_equal_to[4]|greater_than_equal_to[3.3]',
                    'errors' => [
                        'required' => 'Nilai UAS ' . $nama . ' tidak boleh kosong!!',
                        'decimal' => 'Nilai UAS ' . $nama . ' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai UAS ' . $nama . ' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai UAS ' . $nama . ' tidak boleh kurang dari 3.30'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai UAS " . $nama . " !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Uts * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai = dataDinamis('grade_nilai');
                if ($Uts == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UAS' => $Uas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_UAS' => $Uas,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai UAS " . $nama . " berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai UAS " . $nama . " gagal disimpan"));
                }
                //}
            }
        }
    }

    function simpan_p()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod() == "post") {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $perf = (!empty($this->request->getVar('nilai'))) ? $this->request->getVar('nilai') : '0';
            $Uts = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UTS'];
            $Tgs = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_TGS'];
            $Uas = getDataRow('data_ljk', ['id_ljk' => $id])['Nilai_UAS'];
            $aturan = [
                'nilai' => [
                    'rules' => 'permit_empty|decimal|less_than_equal_to[4]|greater_than_equal_to[3.3]',
                    'errors' => [
                        'required' => 'Nilai Performance ' . $nama . ' tidak boleh kosong!!',
                        'decimal' => 'Nilai Performance ' . $nama . ' harus berupa angka!!',
                        'less_than_equal_to' => 'Nilai Performance ' . $nama . ' tidak boleh lebih dari 4.00',
                        'greater_than_equal_to' => 'Nilai Performance ' . $nama . ' tidak boleh kurang dari 3.30'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                return json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai Performance " . $nama . " !!"));
            } else {

                //$datanilai         = $NilaiModel->find($id);
                //foreach ($datanilai as $r)
                //{
                $Nilai_Akhir = number_format((($Uts * 20) + ($Tgs * 30) + ($Uas * 30) + ($perf * 20)) / 100, 2);
                $grade_nilai = dataDinamis('grade_nilai');
                if ($Uts == 0 or $Tgs == 0 or $Uas == 0 or $perf == 0) {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_Performance' => $perf,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => 'TL',
                                'Rekom_Nilai' => 'Kuliah Ulang',
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                } else {

                    foreach ($grade_nilai as $s) {
                        if ($Nilai_Akhir >= $s->batas_bawah and $Nilai_Akhir <= $s->batas_atas) {
                            $record = [
                                'id_ljk' => $id,
                                'Nilai_Performance' => $perf,
                                'Nilai_Akhir' => $Nilai_Akhir,
                                'Status_Nilai' => $s->keterangan,
                                'Rekom_Nilai' => $s->anjuran,
                                'Nilai_Huruf' => $s->grade
                            ];
                        }
                    }
                }
                if ($NilaiModel->save($record)) {
                    return json_encode(array("status" => true, "msg" => "success", "pesan" => "Nilai Performance " . $nama . " berhasil disimpan"));
                } else {
                    return json_encode(array("status" => false, "msg" => "error", "pesan" => "Nilai Performance " . $nama . " gagal disimpan"));
                }
                //}
            }
        }
    }

    function ubahCekalan()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('aksi') == 'lolos' && $this->request->getVar('id')) {

                $dataLjk = $NilaiModel->find($this->request->getVar('id'));
                if ($dataLjk) { #memastikan ada data
                    $record = [
                        'id_ljk' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '0'
                    ];

                    if ($NilaiModel->save($record)) {
                        //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                        return json_encode(array("status" => TRUE));
                    } else {
                        return json_encode(array("status" => false));
                    }
                }
            }

            if ($this->request->getVar('aksi') == 'cekal' && $this->request->getVar('id')) {
                $dataLjk = $NilaiModel->find($this->request->getVar('id'));
                if ($dataLjk) { #memastikan ada data
                    $record = [
                        'id_ljk' => $this->request->getVar('id'),
                        $this->request->getVar('field') => '1'
                    ];

                    if ($NilaiModel->save($record)) {
                        return json_encode(array("status" => TRUE));
                    } else {
                        return json_encode(array("status" => false));
                    }
                }
            }
        }
    }

    function showLjk()
    {
        $data = [];
        $NilaiModel = new \App\Models\NilaiModel($this->request);

        if ($this->request->getVar('id_ljk')) {
            $data = $NilaiModel->find($this->request->getVar('id_ljk'));
            $data['ujian'] = $this->request->getVar('jns_ujian');
        }

        $data['templateJudul'] = "Lembar Jawaban";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'showLjk';
        if ($data['ujian'] == 'tugas') {
            return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/showTugas", $data);
        } else {
            $data['jns_soal'] = $data['ujian'] == 'uas' ? getDataRow('mata_kuliah', ['id' => $data['id_mk']])['jns_uas'] : getDataRow('mata_kuliah', ['id' => $data['id_mk']])['jns_uts'];
            //if($data['jns_soal']  == '2'){
            return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/showLjk", $data);
            //}else{
            //    return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/showLjkArtikel", $data);
            //}
        }
    }

    function cekNilaiKelas()
    {
        $DistribusiMkModel = new \App\Models\DistribusiMkModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
        $prodi = $this->request->getVar('prodi');
        $kelas = $this->request->getVar('kelas');

        $id_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['id'];
        $kd_tahun_mk = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $kd_kelas_perkuliahan, 'Prodi' => $prodi, 'Kelas' => $kelas])['Kd_Tahun'];

        if ($this->request->getMethod(true) === 'POST') {

            $listsMhsLjk = $NilaiModel->select('id_his_pdk')->where(['id_mk' => $id_mk])->findAll();

            if (empty($listsMhsLjk)) {
                echo json_encode(array("status" => false));
            } else {
                echo json_encode(array("status" => true));
            }
        }
    }

    public function cetakNilai()
    {
        try {

            // ================== DATA ==================
            $NilaiModel = new \App\Models\NilaiModel($this->request);

            $kd_kelas_perkuliahan = $this->request->getVar('kd_kelas_perkuliahan');
            $prodi = $this->request->getVar('prodi');
            $kelas = $this->request->getVar('kelas');
            $ujian = $this->request->getVar('ujian');

            $mk = getDataRow('mata_kuliah', [
                'kd_kelas_perkuliahan' => $kd_kelas_perkuliahan,
                'Prodi' => $prodi,
                'Kelas' => $kelas
            ]);

            $listsNilai = $NilaiModel->where(['id_mk' => $mk['id']])->findAll();

            // ================== MPDF ==================
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 18,
                'margin_right' => 18,
                'margin_top' => 20,
                'margin_bottom' => 20,
                'tempDir' => WRITEPATH . 'mpdf_temp'
            ]);

            // ================== CSS ==================
            $css = '
        <style>
            body { font-family: Arial; font-size: 12pt; }
            table { border-collapse: collapse; }
            td { padding: 4px; }
            .kolom1 { float:left; width:7cm; font-size:11pt; }
            .kolom2 { float:right; width:10cm; font-size:8pt; }
        </style>
        ';
            $mpdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);

            // ================== HTML ==================
            $html = '';

            $html .= '<div style="text-align:center">
            ABSENSI PESERTA<br>
            UJIAN TENGAH SEMESTER (UTS)<br>
            STAI AL-MANNAN TULUNGAGUNG<br>
            TAHUN AKADEMIK ' . getDataRow('tahun_akademik', ['kode' => $mk['Kd_Tahun']])['tahunAkademik'] . '
        </div><br>';

            $fakultas = ucwords(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['fakultas']);
            $dosen = getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']]);
            $tanggal = date_indo($mk['Tgl_UTS'] . '-' . $mk['Bln_UTS'] . '-' . $mk['Thn_UTS']);

            $html .= '
<table width="100%" border="0" style="font-size:11pt">
    <tr>
        <td width="16%">Fakultas</td>
        <td width="35%">: ' . $fakultas . '</td>
        <td width="16%">Mata Kuliah</td>
        <td>: ' . $mk['Mata_Kuliah'] . '</td>
    </tr>
    <tr>
        <td>Prodi</td>
        <td>: ' . $mk['Prodi'] . '</td>
        <td>Dosen</td>
        <td>: ' . $dosen['Nama_Dosen'] . '</td>
    </tr>
    <tr>
        <td>Semester</td>
        <td>: ' . $mk['SMT'] . ' - ' . $mk['Kelas'] . '</td>
        <td>Hari / Tanggal</td>
        <td>: ' . $mk['Hari_UTS'] . ' / ' . $tanggal . '</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Pukul</td>
        <td>: ' . $mk['Jam_UTS'] . ' WIB</td>
    </tr>
</table>
<br>';


            // ================== TABLE NILAI ==================
            $html .= '<table width="100%" style="font-size:9pt" border="1">
            <tr>
                <td>No</td>
                <td>No Induk</td>
                <td>Nama</td>
                <td>UTS</td>
                <td>Tanda Tangan</td>
            </tr>';

            $no = 1;
            foreach ($listsNilai as $list) {
                $his = getDataRow('histori_pddk', ['id_his_pdk' => $list['id_his_pdk']]);
                $mhs = getDataRow('db_data_diri_mahasiswa', ['id' => $his['id_data_diri']]);

                $html .= '<tr>
                <td align="center">' . $no++ . '</td>
                <td>' . $his['NIM'] . '</td>
                <td>' . strtoupper($mhs['Nama_Lengkap']) . '</td>
                <td align="center">' . ($list['Nilai_UTS'] ? number_format($list['Nilai_UTS'], 2) : '') . '</td>
                <td align="center">' . ($list['Nilai_UTS'] ? 'Digital Signed Valid' : '') . '</td>
            </tr>';
            }

            $html .= '</table><br><br>';

            // ================== FOOTER ==================
            $html .= '<div>
            Dosen<br><br><br>
            ' . getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['Nama_Dosen'] . '<br>
            ' . getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['NIY'] . '
        </div>';

            // ================== OUTPUT ==================
            $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
            $mpdf->Output("Nilai_{$ujian}_{$prodi}_{$kelas}.pdf", 'I');
            exit;
        } catch (\Throwable $e) {

            echo "<pre>";
            echo "MPDF ERROR\n";
            echo $e->getMessage() . "\n";
            echo $e->getFile() . ":" . $e->getLine();
            echo "</pre>";
            exit;
        }
    }

    function tambahDokumen()
    {
        $FileModel = new \App\Models\FileModel($this->request);
        $data = [];

        if ($this->request->getMethod() == "post") {
            if ($this->request->getVar('aksi') == 'ubah_status' && $this->request->getVar('id')) {
                $dt = $FileModel->find($this->request->getVar('id'));
                if ($dt && isset($dt['status'])) {
                    $newStatus = ($dt['status'] == 'aktif') ? 'nonaktif' : 'aktif';
                    $FileModel->update($dt['id_file'], ['status' => $newStatus]);
                    return json_encode([
                        "msg" => "success",
                        "pesan" => "Status file diubah menjadi <b>$newStatus</b>.",
                        "status" => $newStatus
                    ]);
                } else {
                    return json_encode(["msg" => "error", "pesan" => "Data file tidak ditemukan."]);
                }
            }

            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dt = $FileModel->find($this->request->getVar('id'));
                if ($dt['id_file']) { #memastikan ada data
                    @unlink($dt['lokasi_file']);
                    $aksi = $FileModel->delete($this->request->getVar('id'));
                    if ($aksi == true) {
                        return json_encode(array("msg" => "success", "pesan" => "File berhasil dihapus!"));
                    } else {
                        return json_encode(array("msg" => "error", "pesan" => "File gagal dihapus!"));
                    }
                }
            }

            $aturan = [
                'name_file' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama berkas harus diisi.'
                    ]
                ],
                'file_deskripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Deskripsi file harus diisi.'
                    ]
                ],
                'file_perkuliahan' => [
                    'rules' => 'uploaded[file_perkuliahan]|max_size[file_perkuliahan,50240]|mime_in[file_perkuliahan,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation]|ext_in[file_perkuliahan,pdf,doc,docx,ppt,pptx]',
                    'errors' => [
                        'uploaded' => 'Pilih file yang akan diupload',
                        'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                        'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
                    ]
                ]
            ];

            $file = $this->request->getFile('file_perkuliahan');

            if (!$this->validate($aturan)) {
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali data Anda!"));
            } else {
                $kodeDosen = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')], null, 'Kd_Dosen', '1')['Kd_Dosen'];
                if ($file->getName()) {
                    $nm_file = $file->getRandomName();
                    $nmFolder = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $kodeDosen])['Nama_Dosen']);
                    $path = 'berkas_dosen/' . $nmFolder;
                    $berkas = $path . '/' . $nm_file;
                    $mime = $file->getClientMimeType();
                    $file->move($path, $nm_file);
                }

                $record = [
                    'file_group' => 'file_perkuliahan',
                    'name_file' => $this->request->getVar('name_file'),
                    'lokasi_file' => $berkas,
                    'file_deskripsi' => $this->request->getVar('file_deskripsi'),
                    'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                    'mime' => $mime,
                    'username' => $this->request->getVar('username')
                ];
                $aksi = $FileModel->save($record);


                if ($aksi != false) {
                    return json_encode(array("msg" => "success", "pesan" => "Data berhasil diupload."));
                } else {
                    return json_encode(array("msg" => "error", "pesan" => "Data gagal diupload."));
                }
            }
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        //dd($data);
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'tambahDokumen';


        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function listDokumenPerkuliahan()
    {
        $FileModel = new \App\Models\FileModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $FileModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name_file;
                $row[] = $list->file_deskripsi;
                $row[] =
                    '
                            <a onclick="hapus_file(' . "'" . $list->id_file . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            <a href="' . base_url() . "/$list->lokasi_file" . '" target="_blank" class="btn btn-xs btn-warning" data-placement="top" title="Download"><i class="fa fa-download"></i></a>
                            ';
                // <a onclick="ubah_status('."'".$list->id_file."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hubah"><i class="fa fa-trash"></i></a>
                // <a onclick="ubah_status(' . "'" . $list->id_file . "'" . '); return false;" 
                //     class="btn btn-xs ' . ($list->status == 'aktif' ? 'btn-success' : 'btn-secondary') . '" 
                //     data-placement="top" 
                //     title="Ubah status (sekarang: ' . $list->status . ')">
                //     <i class="fa fa-power-off"></i>
                // </a>
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

    function listDokumenPerkuliahanMahasiswa()
    {
        $FileModel = new \App\Models\FileModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            // $lists = $FileModel->getDatatables(['status' => 'aktif']);
            $lists = $FileModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name_file;
                $row[] = $list->file_deskripsi;
                $row[] =

                    // <a onclick="hapus_file('."'".$list->id_file."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>

                    '<a href="' . base_url() . "/$list->lokasi_file" . '" target="_blank" class="btn btn-xs btn-warning" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
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

    function listSoal()
    {
        $data = [];

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        $data['controller'] = $this->halaman_controller;
        $data['metode'] = 'listSoal';

        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function lihatSoal()
    {

        $data = [];

        if ($this->request->getMethod() == "post") {
            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dt = $FileModel->find($this->request->getVar('id'));
                if ($dt['id_file']) { #memastikan ada data
                    @unlink($dt['lokasi_file']);
                    $aksi = $FileModel->delete($this->request->getVar('id'));
                    if ($aksi == true) {
                        return json_encode(array("msg" => "success", "pesan" => "File berhasil dihapus!"));
                    } else {
                        return json_encode(array("msg" => "error", "pesan" => "File gagal dihapus!"));
                    }
                }
            }

            $aturan = [
                'name_file' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama berkas harus diisi.'
                    ]
                ],
                'file_deskripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Deskripsi file harus diisi.'
                    ]
                ],
                'file_perkuliahan' => [
                    'rules' => 'uploaded[file_perkuliahan]',
                    'errors' => [
                        'uploaded' => 'Pilih file yang akan diupload'
                    ]
                ]
            ];

            $file = $this->request->getFile('file_perkuliahan');

            if (!$this->validate($aturan)) {
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali data Anda!"));
            } else {
                $kodeDosen = getDataRow('mata_kuliah', ['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')], null, 'Kd_Dosen', '1')['Kd_Dosen'];
                if ($file->getName()) {
                    $nm_file = $file->getRandomName();
                    $nmFolder = str_replace("'", "", getDataRow('data_dosen', ['Kode' => $kodeDosen])['Nama_Dosen']);
                    $path = 'berkas_dosen/' . $nmFolder;
                    $berkas = $path . '/' . $nm_file;
                    $mime = $file->getClientMimeType();
                    $file->move($path, $nm_file);
                }

                $record = [
                    'file_group' => 'file_perkuliahan',
                    'name_file' => $this->request->getVar('name_file'),
                    'lokasi_file' => $berkas,
                    'file_deskripsi' => $this->request->getVar('file_deskripsi'),
                    'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                    'mime' => $mime,
                    'username' => $this->request->getVar('username')
                ];
                $aksi = $FileModel->save($record);


                if ($aksi != false) {
                    return json_encode(array("msg" => "success", "pesan" => "Data berhasil diupload."));
                } else {
                    return json_encode(array("msg" => "error", "pesan" => "Data gagal diupload."));
                }
            }
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        $data['jns_ujian'] = $this->request->getVar('jns_ujian');
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'lihatSoal';


        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function tambahSoal()
    {

        $data = [];

        if ($this->request->getMethod(true) == 'POST') {

            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('field') && $this->request->getVar('kd_kelas_perkuliahan')) {
                $dt = $this->perkuliahan->find($this->request->getVar('kd_kelas_perkuliahan'));
                if ($dt) { #memastikan ada data
                    if ($this->request->getVar('field') == 'uas_soal') {
                        $record = [
                            $this->request->getVar('field') => NULL,
                            'jns_uas' => '2'
                        ];
                    } else if ($this->request->getVar('field') == 'uts_soal') {
                        $record = [
                            $this->request->getVar('field') => NULL,
                            'jns_uts' => '2'
                        ];
                    } else {
                        $record = [
                            $this->request->getVar('field') => NULL
                        ];
                    }
                    $aksi = $this->perkuliahan->update($this->request->getVar('kd_kelas_perkuliahan'), $record);
                    if ($aksi == true) {
                        return json_encode(array("msg" => "success", "pesan" => "File berhasil dihapus!", "kd_kelas_perkuliahan" => $this->request->getVar('kd_kelas_perkuliahan')));
                    } else {
                        return json_encode(array("msg" => "error", "pesan" => "File gagal dihapus!", "kd_kelas_perkuliahan" => $this->request->getVar('kd_kelas_perkuliahan')));
                    }
                }
            }

            if ($this->request->getVar('jns_ujian') == 'uas_soal' || $this->request->getVar('jns_ujian') == 'uts_soal') {
                $ruleJnsSoal = 'required';
            } else {
                $ruleJnsSoal = 'permit_empty';
            }
            if ($this->request->getVar('jns_soal') == '1') {
                $ruleSoal = 'permit_empty';
            } else {
                $ruleSoal = 'required';
            }
            $aturan = [
                'jns_ujian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Wajib diisi!!'
                    ]
                ],
                'jns_soal' => [
                    'rules' => $ruleJnsSoal,
                    'errors' => [
                        'required' => 'Wajib diisi!!'
                    ]
                ],
                'soal' => [
                    'rules' => $ruleSoal,
                    'errors' => [
                        'required' => 'Wajib diisi!!'
                    ]
                ]
            ];


            if (!$this->validate($aturan)) {
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali data Anda!"));
            } else {
                if ($this->request->getVar('jns_ujian') == 'uts_soal' && ($this->request->getVar('jns_soal') == '2')) {
                    $record = [
                        //'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                        'jns_uts' => $this->request->getVar('jns_soal'),
                        'uts_soal' => $this->request->getVar('soal')
                    ];
                }

                if (($this->request->getVar('jns_ujian') == 'uts_soal') && ($this->request->getVar('jns_soal') == '1')) {
                    $record = [
                        //'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                        'jns_uts' => $this->request->getVar('jns_soal')
                    ];
                }

                if (($this->request->getVar('jns_ujian') == 'uas_soal') && ($this->request->getVar('jns_soal') == '2')) {
                    $record = [
                        //'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                        'jns_uas' => $this->request->getVar('jns_soal'),
                        'uas_soal' => $this->request->getVar('soal')
                    ];
                }

                if (($this->request->getVar('jns_ujian') == 'uas_soal') && ($this->request->getVar('jns_soal') == '1')) {
                    $record = [
                        //'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                        'jns_uas' => $this->request->getVar('jns_soal')
                    ];
                }

                if ($this->request->getVar('jns_ujian') == 'tugas') {
                    $record = [
                        //'kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan'),
                        'tugas' => $this->request->getVar('soal')
                    ];
                }


                if ($this->perkuliahan->update($this->request->getVar('kd_kelas_perkuliahan'), $record)) {
                    return json_encode(array("msg" => "success", "pesan" => "Soal berhasil disimpan."));
                } else {
                    return json_encode(array("msg" => "error", "pesan" => "Soal gagal disimpan."));
                }
            }
        }

        $data['perkuliahan'] = $this->perkuliahan->where(['kd_kelas_perkuliahan' => $this->request->getVar('kd_kelas_perkuliahan')])->first();
        if ($this->request->getVar('jns_ujian') !== null) {
            $data['jns_ujian'] = $this->request->getVar('jns_ujian');
            $data['templateJudul'] = 'Edit Soal';
        } else {
            $data['templateJudul'] = 'Tambah Soal';
        }

        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode'] = 'tambahSoal';


        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function getIdHari()
    {
        $hari = hari($this->request->getVar('tgl'));

        return json_encode(array("msg" => "success", "hari" => $hari));
    }
}
