<?php

namespace App\Controllers\Admin\Akademik;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Khs extends BaseController
{
  function __construct()
  {
    $request = Services::request();
    $this->validation = \Config\Services::validation();
    $this->khs = new NilaiModel($request);
    $this->halaman_controller = "khs";
    $this->halaman_label = "KHS";
  }

  public function index()
  {
    $data = [];

    if (session()->get('akun_level') == 'Mahasiswa') {
      $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
      $data['id_data_diri'] = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
    }


    $data['templateJudul'] = $this->halaman_label;
    $data['controller'] = $this->halaman_controller;
    $data['aktif_menu'] = $this->halaman_controller;
    $data['metode']    = 'index';
    return view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], $data);
  }

  function getMhs()
  {
    $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
    echo "<option ></option>";
    $th_angkatan = $this->request->getVar('selectedTa');
    $prodi = $this->request->getVar('selectedProdi');
    $data = $MahasiswaModel->where(['db_data_diri_mahasiswa.th_angkatan' => $th_angkatan, 'h.Prodi' => $prodi, 'h.Status' => "A"])->join('histori_pddk as h', 'h.id_data_diri=db_data_diri_mahasiswa.id', 'inner')->findAll();

    foreach ($data as $row => $val) {
      echo "<option value='" . $val['id_his_pdk'] . "'>" . $val['Nama_Lengkap'] . "</option>";
    }
  }
  function getSMT()
  {

    echo "<option ></option>";

    $id_his_pdk = $this->request->getVar('mhs');
    $data = $this->khs->where(['id_his_pdk' => $id_his_pdk])->groupBy('smt_mhs')->orderBy('smt_mhs ASC')->findAll();
    //$data = dataDinamis('data_ljk', ['id_his_pdk' => $id_his_pdk], 'smt_mhs ASC', 'smt_mhs');
    //dd($data);
    foreach ($data as $row => $val) {
      echo "<option value='" . $val['smt_mhs'] . "'>SMT " . $val['smt_mhs'] . "</option>";
    }
  }

  function getKHS()
  {
    $id_his_pdk = $this->request->getVar('id_his_pdk');
    $smt        = $this->request->getVar('smt');

    // ================== AMBIL DATA DASAR ==================
    $histori = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk]);
    if (!$histori) {
      echo 'Data mahasiswa tidak ditemukan';
      return;
    }

    $id_data_diri = $histori['id_data_diri'];

    $mhs   = getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri]);
    $prodi = getDataRow('prodi', ['singkatan' => $histori['Prodi']]);

    // ================== HEADER ==================
    echo '
    <div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <td width="15%">NIM</td><td width="35%">' . $histori['NIM'] . '</td>
            <td width="15%">FAKULTAS</td><td width="35%">' . strtoupper($prodi['fakultas']) . '</td>
        </tr>
        <tr>
            <td>NIMKO</td><td>' . $histori['NIMKO'] . '</td>
            <td>JURUSAN</td><td>' . strtoupper($prodi['fakultas']) . '</td>
        </tr>
        <tr>
            <td>NAMA</td><td>' . strtoupper($mhs['Nama_Lengkap']) . '</td>
            <td>PROGRAM STUDI</td><td>' . strtoupper($prodi['nm_prodi']) . '</td>
        </tr>
        <tr>
            <td>DOSEN WALI</td><td>' . $mhs['dosen_wali'] . '</td>
            <td>SEMESTER</td><td>SMT ' . $smt . '</td>
        </tr>
        <tr>
            <td>TH. MASUK</td><td>' . $mhs['th_angkatan'] . '</td>
        </tr>
    </table>
    </div>';

    // ================== HITUNG TOTAL SKS & MUTU ==================
    $skstot = 0;
    $mtot   = 0;

    $qtot = $this->khs->select('mata_kuliah.SKS, data_ljk.Nilai_Akhir as am')
      ->where('data_ljk.id_his_pdk', $id_his_pdk)
      ->where('data_ljk.smt_mhs <=', $smt)
      ->join('mata_kuliah', 'data_ljk.id_mk = mata_kuliah.id', 'left')
      ->get()->getResult();

    foreach ($qtot as $q) {
      $skstot += $q->SKS;
      $mtot   += ($q->am * $q->SKS);
    }

    // ================== AMBIL DATA KHS ==================
    $khs = $this->khs->select('
        mata_kuliah.Kode_MK_Feeder,
        mata_kuliah.SKS,
        master_matakuliah.nama_mk,
        data_ljk.Nilai_UTS,
        data_ljk.Nilai_TGS,
        data_ljk.Nilai_UAS,
        data_ljk.Nilai_Performance,
        data_ljk.Nilai_Akhir as am,
        data_ljk.Nilai_Huruf as hm,
        data_ljk.Status_Nilai,
        data_ljk.Rekom_Nilai
    ')
      ->where([
        'data_ljk.id_his_pdk' => $id_his_pdk,
        'data_ljk.smt_mhs'    => $smt
      ])
      ->join('mata_kuliah', 'data_ljk.id_mk = mata_kuliah.id', 'left')
      ->join('master_matakuliah', 'data_ljk.kode_mk_feeder=master_matakuliah.kode_mk', 'left')
      ->orderBy('mata_kuliah.Mata_Kuliah', 'ASC')
      ->get()->getResult();

    // ================== TABEL NILAI ==================
    echo '
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">KODE</th>
                <th rowspan="2">MATA KULIAH</th>
                <th colspan="8">PRESTASI</th>
                <th rowspan="2">Predikat</th>
                <th rowspan="2">Rekomendasi</th>
            </tr>
            <tr>
                <th>SKS</th><th>UTS</th><th>TGS</th><th>UAS</th>
                <th>P</th><th>AM</th><th>HM</th><th>M</th>
            </tr>
        </thead><tbody>';

    if (!$khs) {
      echo '<tr><td colspan="13">TIDAK DITEMUKAN KHS</td></tr>';
    }

    $no = 1;
    $msmt = 0;
    $sks  = 0;

    foreach ($khs as $r) {

      $m = $r->am * $r->SKS;
      $msmt += $m;
      $sks  += $r->SKS;

      $keterangan = $r->Status_Nilai == 'L' ? 'LULUS' : 'TIDAK LULUS';

      echo '
        <tr>
            <td align="center">' . $no++ . '</td>
            <td>' . $r->Kode_MK_Feeder . '</td>
            <td>' . $r->nama_mk . '</td>
            <td align="center">' . $r->SKS . '</td>
            <td align="center">' . number_format($r->Nilai_UTS, 2) . '</td>
            <td align="center">' . number_format($r->Nilai_TGS, 2) . '</td>
            <td align="center">' . number_format($r->Nilai_UAS, 2) . '</td>
            <td align="center">' . number_format($r->Nilai_Performance, 2) . '</td>
            <td align="center">' . number_format($r->am, 2) . '</td>
            <td align="center">' . $r->hm . '</td>
            <td align="center">' . number_format($m, 2) . '</td>
            <td>' . $keterangan . '</td>
            <td>' . $r->Rekom_Nilai . '</td>
        </tr>';
    }

    echo '</tbody></table></div>';

    // ================== RINGKASAN ==================
    $ip_smt = $sks > 0 ? $msmt / $sks : 0;
    $ipk    = $skstot > 0 ? $mtot / $skstot : 0;

    echo '
    <div class="table-responsive">
    <table class="table">
        <tr><th>SKS Semester Ini</th><td>: ' . $sks . ' SKS</td></tr>
        <tr><th>SKS Diselesaikan</th><td>: ' . $skstot . ' SKS</td></tr>
        <tr><th>Total Nilai Semester</th><td>: ' . number_format($msmt, 2) . '</td></tr>
        <tr><th>IP Semester</th><td>: ' . number_format($ip_smt, 2) . '</td></tr>
        <tr><th>IPK</th><td>: ' . number_format($ipk, 2) . '</td></tr>
    </table>
    </div>

    <button onclick="cetakKHS()" class="btn btn-primary float-right">
        <i class="fas fa-download"></i> Generate PDF
    </button>
    ';
  }


  function cekKHS()
  {
    $id_his_pdk = $this->request->getVar('id_his_pdk');
    $smt = $this->request->getVar('smt');

    $data = $this->khs->where(array('data_ljk.id_his_pdk' => $id_his_pdk, 'data_ljk.smt_mhs' => $smt))->findAll();

    if (empty($data)) {
      echo json_encode(array("status" => false));
    } else {
      echo json_encode(array("status" => true));
    }
  }

  public function cetakKHS()
  {
    error_reporting(0);
    ini_set('display_errors', 0);

    $id_his_pdk = $this->request->getVar('id_his_pdk');
    $smt        = $this->request->getVar('smt');

    $data = [];
    $data['id_his_pdk'] = $id_his_pdk;
    $data['smt']        = $smt;

    // =========================
    // Data KHS semester aktif
    // =========================
    $data['khs'] = $this->khs
      ->where([
        'data_ljk.id_his_pdk' => $id_his_pdk,
        'data_ljk.smt_mhs'    => $smt
      ])
      ->findAll();

    // =========================
    // Total KHS (semua semester)
    // =========================
    $data['total_khs'] = $this->khs
      ->where([
        'data_ljk.id_his_pdk' => $id_his_pdk
      ])
      ->findAll();

    // =========================
    // Histori PDDK
    // =========================
    $histori = getDataRow('histori_pddk', [
      'id_his_pdk' => $id_his_pdk
    ]);

    $data['nim']        = $histori['NIM'];
    $data['prodi_kode'] = $histori['Prodi'];
    $data['id_data_diri'] = $histori['id_data_diri'];

    // =========================
    // Data Mahasiswa
    // =========================
    $mhs = getDataRow('db_data_diri_mahasiswa', [
      'id' => $data['id_data_diri']
    ]);

    $data['nama']        = strtoupper($mhs['Nama_Lengkap']);
    $data['th_angkatan'] = $mhs['th_angkatan'];

    $data['dosen_wali'] = $mhs['dosen_wali'];

    // dd($data['dosen_wali']);
    // =========================
    // Data Prodi
    // =========================
    $prodi = getDataRow('prodi', [
      'singkatan' => $data['prodi_kode']
    ]);

    $data['fakultas'] = strtoupper($prodi['fakultas']);
    $data['jurusan']  = strtoupper($prodi['fakultas']); // sesuai view lama
    $data['nm_prodi'] = strtoupper($prodi['nm_prodi']);

    // =========================
    // Olah KHS untuk View
    // =========================
    $data['khs_detail'] = [];
    $data['msmt'] = 0;
    $data['sks']  = 0;
    $no = 1;

    foreach ($data['khs'] as $r) {

      // Ambil matakuliah
      $mk = getDataRow('master_matakuliah', [
        'kode_mk' => $r['kode_mk_feeder']
      ]);

      $bobot = $mk['bobot_mk'];

      // Nilai x SKS
      $m = $r['Nilai_Akhir'] * $bobot;

      // Akumulasi
      $data['msmt'] += $m;
      $data['sks']  += $bobot;

      $data['khs_detail'][] = [
        'no'        => $no++,
        'kode_mk'   => $r['kode_mk_feeder'],
        'nama_mk'   => $mk['nama_mk'],
        'bobot'     => $bobot,
        'uts'       => number_format($r['Nilai_UTS'], 2),
        'tugas'     => number_format($r['Nilai_TGS'], 2),
        'uas'       => number_format($r['Nilai_UAS'], 2),
        'perf'      => number_format($r['Nilai_Performance'], 2),
        'akhir'     => number_format($r['Nilai_Akhir'], 2),
        'huruf'     => $r['Nilai_Huruf'],
        'nilai_x'   => number_format($m, 2),
        'ket'       => $r['Status_Nilai'] == 'L' ? 'LULUS' : 'TIDAK LULUS',
        'rekom'     => $r['Rekom_Nilai'],
      ];
    }

    // =========================
    // Rekap SKS & IP
    // =========================

    // SKS semester ini (sudah dihitung sebelumnya)
    $data['sks_semester'] = $data['sks'];      // dari perhitungan KHS
    $data['msmt_semester'] = $data['msmt'];    // total nilai semester

    // =========================
    // SKS & Mutu yang sudah diselesaikan
    // =========================
    $qtot = dataDinamis(
      'data_ljk',
      [
        'id_his_pdk' => $data['id_his_pdk'],
        'smt_mhs <=' => $data['smt']
      ],
      null,
      null,
      null,
      null,
      null,
      ['sks', 'Nilai_Akhir']
    );

    $skstot = 0;
    $mtot   = 0;

    foreach ($qtot as $r) {
      $skstot += $r->sks;
      $mtot   += ($r->Nilai_Akhir * $r->sks);
    }

    $data['sks_total'] = $skstot;
    $data['mutu_total'] = $mtot;

    // =========================
    // IPS & IPK
    // =========================
    $data['ips'] = ($data['sks_semester'] > 0)
      ? $data['msmt_semester'] / $data['sks_semester']
      : 0;

    $data['ipk'] = ($data['sks_total'] > 0)
      ? $data['mutu_total'] / $data['sks_total']
      : 0;

    // =========================
    // Kaprodi
    // =========================
    $prodi = getDataRow('prodi', [
      'singkatan' => $data['prodi_kode']
    ]);

    $data['kaprodi'] = $prodi['kaprodi'];
    $data['niy']     = $prodi['niy'];

    // =========================
    // Batas SKS
    // =========================
    $data['sks_maks'] = 24;

    // =========================
    // Meta View
    // =========================
    $data['templateJudul'] = "Cetak " . $this->halaman_label;
    $data['metode']        = 'cetakKHS';

    // return view(
    //   session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'],
    //   ['data' => $data]
    // );

    // ================= VIEW =================
    $html = view(
      session()->get('akun_group_folder') . "/akademik/khs/cetakKHS",
      ['data' => $data]
    );

    // ================= MPDF =================
    $mpdf = new \Mpdf\Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A4',
      'margin_left'   => 10,
      'margin_right'  => 10,
      'margin_top'    => 15,
      'margin_bottom' => 10,
    ]);

    $mpdf->SetTitle('KHS Mahasiswa');

    // ================= CSS (KODE LAMA TETAP DIPAKAI) =================
    $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // CSS ONLY

    // ================= FOOTER (KODE LAMA TETAP DIPAKAI) =================
    $mpdf->defaultheaderline = 0;
    $mpdf->SetFooter(
      "<div style='font-family: Arial; font-size: 9pt;'>"
        . base_url("akademik/khs/cetakKHS?id_his_pdk=")
        . $data['id_his_pdk']
        . "&smt=" . $data['smt']
        . "</div>"
    );

    // ================= BODY =================
    $mpdf->WriteHTML($html);

    // ================= OUTPUT =================
    $mpdf->Output("KHS_{$data['nim']}.pdf", 'I');
    exit;



    // $mpdf = new \Mpdf\Mpdf([
    //   'mode' => 'utf-8',
    //   'format' => 'A4',
    //   'margin_left' => 10,
    //   'margin_right' => 10,
    //   'margin_top' => 15,
    //   'margin_bottom' => 10,
    // ]);

    // $html = view(session()->get('akun_group_folder') . "/akademik/$this->halaman_controller/" . $data['metode'], ["data" => $data]);
    // $output = "KHS_" . getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['Nama_Lengkap'] . ".pdf";
    // $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
    // $mpdf->defaultheaderline = 0;
    // $mpdf->SetFooter("<div style='font-family: Arial; font-size: 9pt;'>" . base_url("akademik/$this->halaman_controller/cetakKHS?id_his_pdk=") . $data['id_his_pdk'] . "&smt=" . $data['smt'] . "</div>");
    // $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
    // //$mpdf->SetHTMLHeader($htmlHeader);

    // $mpdf->WriteHTML($html);
    // $this->response->setHeader('Content-Type', 'application/pdf');
    // $mpdf->Output($output, 'I');
  }
}
