<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\KrsModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Krs extends BaseController
{
    protected string $halaman_controller;
    protected string $halaman_label;
    protected KrsModel $krs;
    protected $validation;
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->krs = new KrsModel($request);
        $this->halaman_controller = "krs";
        $this->halaman_label = "KRS";
    }

    public function index()
    {
        $data = [];
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('id')) {
                $dt = $this->krs->find($this->request->getVar('id'));
                if ($dt['id']) { #memastikan ada data
                    $NilaiModel = new \App\Models\NilaiModel($this->request);
                    $cekDataNilai = $NilaiModel->where('id_krs', $this->request->getVar('id'))->findAll();
                    if (!empty($cekDataNilai)) {
                        $NilaiModel->where('id_krs', $this->request->getVar('id'))->delete();
                        $aksi = $this->krs->delete($this->request->getVar('id'));
                        if ($aksi == true) {
                            return json_encode(array("status" => TRUE));
                        } else {
                            return json_encode(array("status" => false));
                        }
                    } else {
                        $aksi = $this->krs->delete($this->request->getVar('id'));
                        if ($aksi == true) {
                            return json_encode(array("status" => TRUE));
                        } else {
                            return json_encode(array("status" => false));
                        }
                    }
                }
            }
        }

        if ($this->request->getVar('aksi') == 'activate' && $this->request->getVar('id')) {

            $dataKrs = $this->krs->find($this->request->getVar('id'));
            if ($dataKrs['id']) { #memastikan ada data
                $record = [
                    'id' => $this->request->getVar('id'),
                    $this->request->getVar('field') => '1'
                ];

                if ($this->krs->save($record)) {
                    //$this->kurikulum->where('id !=', $this->request->getVar('id'))->set(['aktif' => 'n'])->update();
                    return json_encode(array("status" => TRUE));
                } else {
                    return json_encode(array("status" => false));
                }
            }
        }

        if ($this->request->getVar('aksi') == 'deactivate' && $this->request->getVar('id')) {
            $dataKrs = $this->krs->find($this->request->getVar('id'));
            if ($dataKrs['id']) { #memastikan ada data
                $record = [
                    'id' => $this->request->getVar('id'),
                    $this->request->getVar('field') => '0'
                ];

                if ($this->krs->save($record)) {
                    return json_encode(array("status" => TRUE));
                } else {
                    return json_encode(array("status" => false));
                }
            }
        }

        if (session()->get('akun_level') == 'Mahasiswa') {
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data['id_data_diri'] = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function ajaxList()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->krs->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                if ($list->kode_ta % 2 != 0) {
                    $a = (($list->kode_ta + 10) - 1) / 10;
                    $b = $a - intval(substr($list->th_angkatan, 0, 4));
                    $c = ($b * 2) - 1;
                } else {
                    $a = (($list->kode_ta + 10) - 2) / 10;
                    $b = $a - intval(substr($list->th_angkatan, 0, 4));
                    $c = $b * 2;
                }

                if ($list->stat_mhs == 'A') {
                    $stat_mhs = '<span class="badge badge-success">Aktif</span>';
                } elseif ($list->stat_mhs == 'N') {
                    $stat_mhs = '<span class="badge badge-danger">Non-Aktif</span>';
                } elseif ($list->stat_mhs == 'C') {
                    $stat_mhs = '<span class="badge badge-warning">Cuti</span>';
                } elseif ($list->stat_mhs == 'U') {
                    $stat_mhs = '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
                } elseif ($list->stat_mhs == 'M') {
                    $stat_mhs = '<span class="badge badge-primary">Kampus Merdeka</span>';
                } elseif ($list->stat_mhs == 'G') {
                    $stat_mhs = '<span class="badge badge-grey">Sedang Double Degree</span>';
                }

                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="' . $list->id . '" />';
                $row[] = $no;
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = $c;
                $row[] = $list->Kelas;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap');
                if (session()->get('akun_level') == "Admin" || session()->get('akun_level') == "BAK") {
                    $row[] = $list->syarat_krs == 1 ? '<a onclick="deactivate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','syarat_krs'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="activate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','syarat_krs'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                    $row[] = $list->publikasi_pmb == 1 ? '<a onclick="deactivate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','publikasi_pmb'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="activate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','publikasi_pmb'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                    $row[] = $list->sarat_uts == 1 ? '<a onclick="deactivate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','sarat_uts'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="activate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','sarat_uts'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                    $row[] = $list->status_bayar == 1 ? '<a onclick="deactivate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','status_bayar'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="activate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','status_bayar'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                }
                if (session()->get('akun_level') == "Fakultas" || session()->get('akun_level') == "Kaprodi") {
                    $row[] = $list->syarat_krs == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                    $row[] = $list->publikasi_pmb == 1 ? '<a onclick="deactivate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','publikasi_pmb'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>' : '<a onclick="activate(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "','publikasi_pmb'" . '); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';
                    $row[] = $list->sarat_uts == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                    $row[] = $list->status_bayar == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                }
                $row[] = '<ol>' . ((!empty($list->kwitansi_krs)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->kwitansi_krs . "'" . ')">Pembayaran</a></li>' : '') . " " . ((!empty($list->berkas_publikasi)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->berkas_publikasi . "'" . ')" >Publikasi</a></li>' : '') . '</ol>';
                $row[] = $stat_mhs;
                if (session()->get('akun_level') == "Admin") {
                    $row[] = '<a onclick="hapus(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "'" . '); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus KRS"><i class="fa fa-trash"></i></a>
                            <a onclick="reset(' . "'" . $list->id . "','" . str_replace("'", "`", $list->Nama_Lengkap) . "'" . '); return false;" class="btn btn-xs btn-warning" data-placement="top" title="Reset KRS"><i class="fa fa-sync"></i></a>
                            <a onclick="formulir(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Formulir KRS"><i class="fa fa-list"></i></a> 
                        ';
                }
                if (session()->get('akun_level') == "BAK" || session()->get('akun_level') == "Fakultas" || session()->get('akun_level') == "Kaprodi") {
                    $row[] = '
                            <a onclick="formulir(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Formulir KRS"><i class="fa fa-list"></i></a> 
                        ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->krs->countAll(),
                'recordsFiltered' => $this->krs->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function getData()
    {

        $data = $this->krs->find($this->request->getVar('id'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    function reset()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod(true) == 'POST') {
            if ($this->request->getVar('id')) {
                $dt = $NilaiModel->where('id_krs', $this->request->getVar('id'))->findAll();
                if ((!empty($dt))) { #memastikan ada data

                    $aksi = $NilaiModel->where('id_krs', $this->request->getVar('id'))->delete();
                    if ($aksi == true) {
                        $record = [
                            'id' => $this->request->getVar('id'),
                            'tgl_krs' => '',
                            'stat_mhs' => 'N',
                            'jml_sks' => '0'
                        ];
                        $this->krs->save($record);
                        return json_encode(array("msg" => "success", "pesan" => "KRS berhasil direset"));
                    } else {

                        return json_encode(array("msg" => "warning", "pesan" => "KRS Gagal direset"));
                    }
                } else {
                    $record = [
                        'id' => $this->request->getVar('id'),
                        'tgl_krs' => '',
                        'stat_mhs' => 'N',
                        'jml_sks' => '0'
                    ];
                    $this->krs->save($record);
                    return json_encode(array("msg" => "error", "pesan" => "Data nilai tidak ditemukan"));
                }
            }
        }
    }

    // function formulir_krs()
    // {
    //     $data = [];

    //     if ($this->request->getVar('id_krs')) {
    //         $data = $this->krs->find($this->request->getVar('id_krs'));
    //         $data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
    //         if ($data['syarat_krs'] != '1' || $data['publikasi_pmb'] != '1') {
    //             session()->setFlashdata("info", "warning");
    //         }
    //         if (session()->get('akun_level') == 'Mahasiswa' && $data['kode_ta'] != getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']) {
    //             session()->setFlashdata("krs_tidak_aktif", "KRS Tahun Akademik " . getDataRow('tahun_akademik', ['kode' => $data['kode_ta']])['tahunAkademik'] . " Semester " . ((getDataRow('tahun_akademik', ['kode' => $data['kode_ta']])['semester'] == '1') ? 'Gasal' : 'Genap') . " belum / tidak aktif!!");
    //         }
    //     }

    //     $data['templateJudul'] = "Formulir " . $this->halaman_label;
    //     $data['controller'] = $this->halaman_controller;
    //     $data['metode']    = 'formulir_krs';
    //     return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    // }

    function formulir_krs()
    {
        $data = [];

        if ($this->request->getVar('id_krs')) {
            $data = $this->krs->find($this->request->getVar('id_krs'));

            if (!$data) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Data KRS tidak ditemukan');
            }

            // ambil histori
            $histori = getDataRow('histori_pddk', [
                'id_his_pdk' => $data['id_his_pdk'] ?? null
            ]);

            $data['id_data_diri'] = $histori['id_data_diri'] ?? null;

            if (($data['syarat_krs'] ?? null) != '1' || ($data['publikasi_pmb'] ?? null) != '1') {
                session()->setFlashdata("info", "warning");
            }

            // if (
            //     session()->get('akun_level') == 'Mahasiswa'
            //     && ($data['kode_ta'] ?? null) != getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']
            // ) {
            //     $ta = getDataRow('tahun_akademik', ['kode' => $data['kode_ta']]);

            //     session()->setFlashdata(
            //         "krs_tidak_aktif",
            //         "KRS Tahun Akademik {$ta['tahunAkademik']} Semester " .
            //             (($ta['semester'] == '1') ? 'Gasal' : 'Genap') .
            //             " belum / tidak aktif!!"
            //     );
            // }
            $taAktif = getDataRow('tahun_akademik', ['aktif' => 'y']);

            if (
                session()->get('akun_level') === 'Mahasiswa'
                && $taAktif
                && isset($data['kode_ta'])
                && $data['kode_ta'] !== $taAktif['kode']
            ) {
                session()->setFlashdata(
                    'krs_tidak_aktif',
                    'KRS Tahun Akademik ' .
                        $taAktif['tahunAkademik'] .
                        ' Semester ' .
                        (($taAktif['semester'] == '1') ? 'Gasal' : 'Genap') .
                        ' belum / tidak aktif!!'
                );
            }
        }

        $data['templateJudul'] = "Formulir " . $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'formulir_krs';

        return view(
            session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'],
            $data
        );
    }


    private function set_key_data($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail->Kode_MK_Feeder] = $detail;
        }

        return $return;
    }

    /* Awal Sebelum ada Permintaan menghilangkan MK yang pernah ditempuh
    function listMkKelas()
    {
        $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists= $distribusiMK->getDatatables();
            
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("masterdata/$this->halaman_controller/detail/").$list->id;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" checked/>';
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Nama_Dosen;
                
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $distribusiMK->countAll(),
                //'recordsFiltered' => $distribusiMK->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    
    public function simpanKrs()
    {
        
        if($this->request->getMethod()=="post"){
            
            if(empty($this->request->getVar('id_mk'))){
                echo json_encode(array("msg" => "warning", "pesan" => "Beri tanda ceklis pada semua mata kuliah yang akan di ikuti!!"));
            }else{
                
                $NilaiModel = new \App\Models\NilaiModel($this->request);
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                $id_krs           = $this->request->getVar('id_krs');
                $sks=0;
                foreach ($this->request->getVar('id_mk') as $key ) {                
                    $dtMk = getDataRow('mata_kuliah', ['id'=>$key]);
                    $q_data_krs = getDataRow('akademik_krs', ['id'=>$id_krs]);
                    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk'=>$q_data_krs['id_his_pdk']]);
                    
                    $record_mk = [
                        'id_mk' => $key,
						'id_krs' => $id_krs,
						't_akad' => $q_data_krs['kode_ta'],
						"id_mhs"=>$q_data_krs['id_mhs'],
						"id_his_pdk"=>$q_data_krs['id_his_pdk'],
						"nim"=>getDataRow('histori_pddk', ['id_his_pdk'=>$q_data_krs['id_his_pdk']])['NIM'],
						"smt_mhs"=>$dtMk['SMT'],
						"prodi_mhs"=>getDataRow('histori_pddk', ['id_his_pdk'=>$q_data_krs['id_his_pdk']])['Prodi'],
						"kelas_mhs"=>getDataRow('db_data_diri_mahasiswa', ['id'=>$id_data_diri])['kelas'],
						"kode_mk_feeder"=>$dtMk['Kode_MK_Feeder'],
						"sks"=>$dtMk['SKS'],
						"kd_kelas" => $q_data_krs['kode_kelas'],
						"kd_kelas_perkuliahan" => $dtMk['kd_kelas_perkuliahan']
                    ];
                    if($NilaiModel->save($record_mk)){
                        $sks += $dtMk['SKS'];
                        $jmlSukses++;
                    }else{
                        $jmlError++;
                        $listError [] = [
                            'pesan'     => $dtMk['Mata_Kuliah']." gagal disimpan."
                        ];
                    };
                }
                $record_krs = [
                    'id' => $id_krs,
                    'tgl_krs' => date('d-m-Y H:i:s'),
            		'stat_mhs' => 'A',
            		'jml_sks' => $sks
                ];
                if($this->krs->save($record_krs)){
                    if($jmlError > 0){
                        return json_encode(array("msg" => "info", "pesan" => $jmlSukses. " Matakuliah berhasil disimpan, ".$jmlError." gagal disimpan.", 'listError' => $listError));
                    }else{
                        return json_encode(array("msg" => "success", "pesan" => $jmlSukses. " Matakuliah berhasil disimpan."));
                    }  
                }
                
            }
        }
        
    }
    */

    private function set_key_data_ljk($data)
    {
        $return = array();

        foreach ($data as $detail) {
            $return[$detail['kode_mk_feeder']] = $detail;
        }

        return $return;
    }

    function listMkKelas()
    {
        $distribusiMK = new \App\Models\DistribusiMkModel($this->request);
        $NilaiModel = new \App\Models\NilaiModel($this->request);

        if ($this->request->getMethod(true) === 'POST') {
            $list_mk_kelas = $distribusiMK->getDatatables();
            $mk_yg_pernah_ditempuh = $NilaiModel->select('kode_mk_feeder')->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'Status_Nilai' => 'L'])->findAll();;

            $result_list_mk_kelas = $this->set_key_data($list_mk_kelas);
            $result_mk_yg_pernah_ditempuh = $this->set_key_data_ljk($mk_yg_pernah_ditempuh);

            foreach ($result_list_mk_kelas as $index => $item) {
                if (isset($result_mk_yg_pernah_ditempuh[$index]))
                    unset($result_list_mk_kelas[$index]);
            }

            $lists = array_values($result_list_mk_kelas);

            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                //$link_delete = site_url("admin/$this->halaman_controller/?aksi=hapus&id=").$list->id_tahun_akademik;
                //$link_edit = site_url("dashboard/$this->halaman_controller/edit/").$list->id_kurikulum;
                $link_detail = site_url("masterdata/$this->halaman_controller/detail/") . $list->id;
                $no++;
                $row = [];
                $row[] = '<input type="checkbox" class="data-check" name="check" value="' . $list->id . '" checked/>';
                $row[] = $no;
                $row[] = $list->Kode_MK_Feeder;
                $row[] = $list->Mata_Kuliah;
                $row[] = $list->SKS;
                $row[] = $list->Nama_Dosen;

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $distribusiMK->countAll(),
                //'recordsFiltered' => $distribusiMK->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function simpanKrs()
    {

        if ($this->request->getMethod() == "post") {

            if (empty($this->request->getVar('id_mk'))) {
                echo json_encode(array("msg" => "warning", "pesan" => "Beri tanda ceklis pada semua mata kuliah yang akan di ikuti!!"));
            } else {

                $NilaiModel = new \App\Models\NilaiModel($this->request);
                $jmlSukses          = 0;
                $jmlError           = 0;
                $listError          = [];
                $id_krs           = $this->request->getVar('id_krs');
                $sks = 0;
                foreach ($this->request->getVar('id_mk') as $key) {
                    $dtMk = getDataRow('mata_kuliah', ['id' => $key]);
                    $q_data_krs = getDataRow('akademik_krs', ['id' => $id_krs]);
                    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $q_data_krs['id_his_pdk']])['id_data_diri'];
                    //$cekNilai = $NilaiModel->where(['kode_mk_feeder'=> $dtMk['Kode_MK_Feeder'], 'id_his_pdk' => $q_data_krs['id_his_pdk'] ])->find();
                    $cekNilai = getDataRow('data_ljk', ['kode_mk_feeder' => $dtMk['Kode_MK_Feeder'], 'id_his_pdk' => $q_data_krs['id_his_pdk']]);

                    if (empty($cekNilai)) {
                        $record_mk = [
                            'id_mk' => $key,
                            'id_krs' => $id_krs,
                            't_akad' => $q_data_krs['kode_ta'],
                            "id_mhs" => $q_data_krs['id_mhs'],
                            "id_his_pdk" => $q_data_krs['id_his_pdk'],
                            "nim" => getDataRow('histori_pddk', ['id_his_pdk' => $q_data_krs['id_his_pdk']])['NIM'],
                            "smt_mhs" => $dtMk['SMT'],
                            "prodi_mhs" => getDataRow('histori_pddk', ['id_his_pdk' => $q_data_krs['id_his_pdk']])['Prodi'],
                            "kelas_mhs" => $dtMk['Kelas'],
                            "kode_mk_feeder" => $dtMk['Kode_MK_Feeder'],
                            "sks" => $dtMk['SKS'],
                            "kd_kelas" => $q_data_krs['kode_kelas'],
                            "kd_kelas_perkuliahan" => $dtMk['kd_kelas_perkuliahan'],
                            "id_matkul_kurikulum" => $dtMk['id_matkul_kurikulum']
                        ];
                    } else {

                        $record_mk = [
                            'id_ljk' => $cekNilai['id_ljk'],
                            'id_mk' => $key,
                            'id_krs' => $id_krs,
                            't_akad' => $q_data_krs['kode_ta'],
                            "kd_kelas" => $q_data_krs['kode_kelas'],
                            "kd_kelas_perkuliahan" => $dtMk['kd_kelas_perkuliahan'],
                            "id_matkul_kurikulum" => $dtMk['id_matkul_kurikulum']
                        ];
                    }
                    if ($NilaiModel->simpanData($record_mk)) {
                        $sks += $dtMk['SKS'];
                        $jmlSukses++;
                    } else {
                        $jmlError++;
                        $listError[] = [
                            'pesan'     => $dtMk['Mata_Kuliah'] . " gagal disimpan."
                        ];
                    };
                }
                $record_krs = [
                    'id' => $id_krs,
                    'tgl_krs' => date('d-m-Y H:i:s'),
                    'stat_mhs' => 'A',
                    'jml_sks' => $sks
                ];
                if ($this->krs->save($record_krs)) {
                    if ($jmlError > 0) {
                        return json_encode(array("msg" => "info", "pesan" => $jmlSukses . " Matakuliah berhasil disimpan, " . $jmlError . " gagal disimpan.", 'listError' => $listError));
                    } else {
                        return json_encode(array("msg" => "success", "pesan" => $jmlSukses . " Matakuliah berhasil disimpan."));
                    }
                }
            }
        }
    }

    // public function cetakKrs()
    // {
    //     $NilaiModel = new \App\Models\NilaiModel($this->request);
    //     $id_krs = $this->request->getVar('id_krs');
    //     //
    //     $data['krs'] = $this->krs->find($id_krs);
    //     $data['mata_kuliah'] = $NilaiModel->where(['id_krs' => $id_krs])->findAll();
    //     $data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['id_data_diri'];
    //     //dd($data['krs']);
    //     $data['templateJudul'] = "Cetak Formulir " . $this->halaman_label;
    //     $data['metode']    = 'cetakKrs';

    //     // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10,
    //     //                         'margin_right' => 10,
    //     //                         'margin_top' => 15,
    //     //                         'margin_bottom' => 10,]);

    //     // $html = view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'],["data" => $data]);
    //     // $output ="Formulir_KRS_".getDataRow('db_data_diri_mahasiswa',['id'=>$data['id_data_diri']])['Nama_Lengkap'].".pdf";
    //     // $stylesheet = file_get_contents('./assets/mpdfstyletables.css');  
    //     // $mpdf->defaultheaderline = 0;
    //     // $mpdf->SetHeader("<div class='center'>".base_url("akademik/$this->halaman_controller/cetakKrs?id_krs=").$id_krs."</div>");
    //     // $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
    //     // //$mpdf->SetHTMLHeader($htmlHeader);

    //     // $mpdf->WriteHTML($html);
    //     // $this->response->setHeader('Content-Type', 'application/pdf');
    //     // $mpdf->Output($output,'I');

    //     return view(
    //         session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'],
    //         ["data" => $data]
    //     );
    // }

    public function cetakKrs()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        $id_krs = $this->request->getVar('id_krs');

        // ==================== Ambil data seperti biasa ====================
        $krs = $this->krs->find($id_krs);

        $histori = getDataRow('histori_pddk', [
            'id_his_pdk' => $krs['id_his_pdk']
        ]);

        $mahasiswa = getDataRow('db_data_diri_mahasiswa', [
            'id' => $histori['id_data_diri']
        ]);

        $ta = getDataRow('tahun_akademik', [
            'kode' => $krs['kode_ta']
        ]);

        $tahunAkademik = $ta['tahunAkademik'];
        $semesterTA = $ta['semester'] == '1' ? 'Gasal' : 'Genap';

        // Hitung semester
        $tahunAngkatan = intval(substr($mahasiswa['th_angkatan'], 0, 4));
        if ($krs['kode_ta'] % 2 != 0) {
            $a = (($krs['kode_ta'] + 10) - 1) / 10;
            $b = $a - $tahunAngkatan;
            $semester = ($b * 2) - 1;
        } else {
            $a = (($krs['kode_ta'] + 10) - 2) / 10;
            $b = $a - $tahunAngkatan;
            $semester = $b * 2;
        }

        // Mata kuliah
        $mkKrs = $NilaiModel->where('id_krs', $id_krs)->findAll();
        $mataKuliah = [];
        $totalSks = 0;
        foreach ($mkKrs as $row) {
            $mk = getDataRow('mata_kuliah', ['id' => $row['id_mk']]);
            $dosen = getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']]);

            $mataKuliah[] = [
                'kode' => $mk['Kode_MK_Feeder'],
                'nama' => $mk['Mata_Kuliah'],
                'sks' => $mk['SKS'],
                'dosen' => $dosen['Nama_Dosen'] ?? '-',
            ];
            $totalSks += $mk['SKS'];
        }

        // MK tidak lulus
        $mkTL = dataDinamis(
            'data_ljk',
            [
                'Status_Nilai !=' => 'L',
                'id_his_pdk' => $krs['id_his_pdk'],
                'smt_mhs <' => $semester
            ],
            'smt_mhs ASC'
        );

        $mkTidakLulus = [];
        foreach ($mkTL as $r) {
            $mk = getDataRow('master_matakuliah', [
                'kode_mk' => $r->kode_mk_feeder
            ]);
            $mkTidakLulus[] = [
                'nama' => $mk['nama_mk'],
                'smt' => $r->smt_mhs,
                'status' => $r->Status_Nilai
            ];
        }

        // ==================== Buat payload ====================
        $payload = [
            'mahasiswa' => $mahasiswa,
            'histori' => $histori,
            'tahunAkademik' => $tahunAkademik,
            'semesterTA' => $semesterTA,
            'semester' => $semester,
            'mataKuliah' => $mataKuliah,
            'totalSks' => $totalSks,
            'mkTidakLulus' => $mkTidakLulus
        ];

        $jsonData = base64_encode(json_encode($payload));

        // ==================== Token HMAC ====================
        $token = hash_hmac('sha256', $jsonData, key: env('PDF_SHARED_SECRET'));


        // dd($jsonData);
        // ==================== Redirect ke Laravel ====================
        return redirect()->to(
            "http://service.staialmannan.ac.id/cetak-krs?data={$jsonData}&token={$token}"
        );
    }

    //Untuk Akun LEvel Mahasiswa
    function loadDataKrs()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $KrsModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                /*
                if ($list->kode_ta %2 != 0){
                	$a = (($list->kode_ta + 10)-1)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = ($b*2)-1;
                	
                }else{
                	$a = (($list->kode_ta + 10)-2)/10;
                	$b = $a - intval(substr($list->th_angkatan, 0, 4));
                	$c = $b * 2;
                }
                */
                if ($list->stat_mhs == 'A') {
                    $stat_mhs = '<span class="badge badge-success">Aktif</span>';
                } elseif ($list->stat_mhs == 'N') {
                    $stat_mhs = '<span class="badge badge-danger">Non-Aktif</span>';
                } elseif ($list->stat_mhs == 'C') {
                    $stat_mhs = '<span class="badge badge-warning">Cuti</span>';
                } elseif ($list->stat_mhs == 'U') {
                    $stat_mhs = '<span class="badge badge-purple">Menunggu Uji Kompetensi</span>';
                } elseif ($list->stat_mhs == 'M') {
                    $stat_mhs = '<span class="badge badge-primary">Kampus Merdeka</span>';
                } elseif ($list->stat_mhs == 'G') {
                    $stat_mhs = '<span class="badge badge-grey">Sedang Double Degree</span>';
                }

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap');
                $row[] = $list->Program;
                $row[] = $list->Prodi;
                //$row[] = $list->semester." / ".$c;
                $row[] = $stat_mhs;
                $row[] = $list->syarat_krs == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                $row[] = $list->publikasi_pmb == 1 ? '<i class="fas fa-check fa-lg text-green" ></i>' : '<i class="fas fa-times fa-lg text-red" ></i>';
                $row[] = '<ol>' . ((!empty($list->kwitansi_krs)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->kwitansi_krs . "'" . ')">Pembayaran</a></li>' : '') . " " . ((!empty($list->berkas_publikasi)) ? '<li><a href="javascript:void(0)" onclick="lihat(' . "'" . base_url() . "/" . $list->berkas_publikasi . "'" . ')" >Publikasi</a></li>' : '') . '</ol>';
                $row[] = '<a  href="javascript:void(0)" class="btn btn-xs btn-success" onclick="getDataKrs(' . "'" . $list->id . "'" . ')" role="button" >
            							Upload
            						</a>';
                $row[] = '<a onclick="formulir(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Formulir KRS"><i class="fa fa-list"></i></a> 
                        ';
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                //'recordsTotal' => $this->krs->countAll(),
                //'recordsFiltered' => $this->krs->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function getDataKrs()
    {
        $KrsModel = new \App\Models\KrsModel($this->request);
        $data = $KrsModel->find($this->request->getVar('id_krs'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }

    function upload_krs()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $KrsModel = new \App\Models\KrsModel($this->request);
            $dt = $KrsModel->find($this->request->getVar('id_krs')); // ambil data
            $id_his_pdk = $dt['id_his_pdk'];
            $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri'];
            $aturan = [
                'file_syarat' => [
                    'rules' => 'uploaded[file_syarat]|is_image[file_syarat]|mime_in[file_syarat,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih foto yang akan diupload',
                        'is_image' => 'Yang Anda upload bukan gambar',
                        'mime_in' => 'Ekstensi file yang anda upload tidak diijinkan. Upload gambar dengan ekstensi jpg | jpeg | png'
                    ]
                ],
                'jns_berkas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih jenis berkas!!'
                    ]
                ]
            ];


            $file = $this->request->getFile('file_syarat');
            if (!$this->validate($aturan)) {
                echo json_encode(array("status" => false, "msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Data periksa kembali form!!"));
            } else {
                if ($this->request->getVar('jns_berkas') == 'pembayaran') {
                    $foto = $dt['kwitansi_krs'];
                    if ($file->getName()) {
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace("'", "", getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);
                        $path = 'berkas_mahasiswa/' . $nmFolder;
                        $foto = $path . '/' . $nm_foto;
                        $file->move($path, $nm_foto, true);
                        @unlink($dt['kwitansi_krs']);
                    }
                    $record = [
                        'id' => $dt['id'],
                        'kwitansi_krs' => $foto,
                    ];
                    if ($KrsModel->save($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " berhasil diupload"));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " gagal diupload"));
                    }
                } else {
                    $foto = $dt['berkas_publikasi'];
                    if ($file->getName()) {
                        $nm_foto = $file->getRandomName();
                        $nmFolder    = str_replace("'", "", getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);
                        $path = 'berkas_mahasiswa/' . $nmFolder;
                        $foto = $path . '/' . $nm_foto;
                        $file->move($path, $nm_foto, true);
                        @unlink($dt['berkas_publikasi']);
                    }
                    $record = [
                        'id' => $dt['id'],
                        'berkas_publikasi' => $foto,
                    ];


                    if ($KrsModel->save($record)) {

                        return json_encode(array("status" => true, "msg" => "success", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " berhasil diupload", "id_data_diri" => $id_data_diri));
                    } else {
                        return json_encode(array("status" => false, "msg" => "error", "pesan" => "Bukti " . $this->request->getVar('jns_berkas') . " gagal diupload"));
                    }
                }
            }
        }
    }
}
