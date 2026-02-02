<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\KrsModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Akm extends BaseController
{
	protected string $halaman_controller;
    protected string $halaman_label;
    protected $validation;
    protected KrsModel $akm;
    function __construct()
    {
        $request = Services::request();
        $this->validation = Services::validation();
        $this->akm = new KrsModel($request);
        $this->halaman_controller = "akm";
        $this->halaman_label = "AKM";
    }

    public function index()
    {
        $data = [];


        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
    }

    function ajaxList()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->akm->getDatatables();
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
                $row[] = $list->NIM;
                $row[] = $list->Prodi;
                $row[] = $list->Program;
                $row[] = $list->th_angkatan;
                $row[] = getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $list->kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap');
                $row[] = $stat_mhs;
                $row[] = $list->jml_sks;
                $row[] = getSum('data_ljk', 'sks', ['id_his_pdk' => $list->id_his_pdk, 'smt_mhs <=' => $list->semester])['sks'];
                $row[] = getIpk('data_ljk', ['id_krs' => $list->id], null, 'Nilai_Akhir, sks');
                $row[] = getIpk('data_ljk', ['id_his_pdk' => $list->id_his_pdk, 'smt_mhs <=' => $list->semester], null, 'Nilai_Akhir, sks');
                $row[] = '<a onclick="detail_akm(' . "'" . $list->id . "'" . '); return false;" class="btn btn-xs btn-primary" data-placement="top" title="Detail AKM"><i class="fa fa-eye"></i></a>';
                $data[] = $row;
                // dd($data);
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

    public function getData()
    {

        $data = $this->krs->find($this->request->getVar('id'));

        if (empty($data)) {
            echo json_encode(array("msg" => false));
        } else {
            echo json_encode(array("msg" => true, "data" => $data));
        }
    }


    function detail()
    {
        $data = [];

        if ($this->request->getVar('id')) {

            // data utama
            $akm = $this->akm->find($this->request->getVar('id'));
            $data = $akm;

            // ===== ambil histori pddk =====
            $histori = getDataRow('histori_pddk', [
                'id_his_pdk' => $akm['id_his_pdk']
            ]);

            // ===== ambil data diri mahasiswa =====
            $dataDiri = getDataRow('db_data_diri_mahasiswa', [
                'id' => $histori['id_data_diri']
            ]);

            // ================== mapping ke $data ==================
            $data['id_data_diri'] = $histori['id_data_diri'];

            $data['nama_lengkap'] = $dataDiri['Nama_Lengkap'] ?? '-';
            $data['nim']          = $histori['NIM'] ?? '-';
            $data['prodi']        = $histori['Prodi'] ?? '-';
            $data['th_angkatan']  = $dataDiri['th_angkatan'] ?? '-';
            $data['program']     = $histori['Program'] ?? '-';

            // ===== format kelas =====
            if ($histori['Kelas'] == 'PA') {
                $data['kelas'] = 'Putera';
            } elseif ($histori['Kelas'] == 'PI') {
                $data['kelas'] = 'Puteri';
            } else {
                $data['kelas'] = $histori['Kelas'] ?? '-';
            }
        }

        $data['templateJudul'] = "Detail " . $this->halaman_label;
        $data['controller']   = $this->halaman_controller;
        $data['metode']       = 'detail';

        return view(
            session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'],
            $data
        );
    }


    function listDetailAkm()
    {
        $NilaiModel = new \App\Models\NilaiModel($this->request);
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $NilaiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->kode_mk_feeder;
                $row[] = getDataRow('master_matakuliah', ['kode_mk' => $list->kode_mk_feeder])['nama_mk'];
                $row[] = getDataRow('master_matakuliah', ['kode_mk' => $list->kode_mk_feeder])['bobot_mk'];
                $row[] = number_format($list->Nilai_UTS, 2);
                $row[] = number_format($list->Nilai_TGS, 2);
                $row[] = number_format($list->Nilai_UAS, 2);
                $row[] = number_format($list->Nilai_Performance, 2);
                $row[] = number_format($list->Nilai_Akhir, 2);
                $row[] = $list->Nilai_Huruf;
                $row[] = number_format((number_format($list->Nilai_Akhir, 2) * getDataRow('master_matakuliah', ['kode_mk' => $list->kode_mk_feeder])['bobot_mk']), 2);
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
}
