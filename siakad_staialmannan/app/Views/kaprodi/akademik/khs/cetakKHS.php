<style type="text/css">
  /*
    @page {
      size: 8.268in 11.693in;  <length>{1,2} | auto | portrait | landscape 
             'em' 'ex' and % are not allowed; length values are width height 
      margin-top: 0.2cm;  <any of the usual CSS values for margins> 
                   (% of page-box width for LR, of height for TB) 
      margin-left: 0.1in;
      margin-right: 0.1in;

    }
    */
  .logo {
    width: 2cm;
    height: 2cm;
    float: left;
  }

  .header {
    float: left;
    padding-left: 1mm;
    vertical-align: middle;
  }
</style>

<div class="header">
  <div class="logo">
    <!-- <?= file_exists(FCPATH.'assets/logo.png') ? 'ADA' : 'TIDAK ADA'; ?> -->
    <img src="<?= FCPATH . 'assets/logo.png'; ?>">
  </div>

  <div style="font-size: 14pt; font-family: 'Arial', sans-serif; padding-top: 3mm;">
    <strong>STAI AL-MANNAN TULUNGAGUNG</strong>
  </div>
  <div style="font-size: 14pt; font-family: 'Arial', sans-serif;"><strong>BIRO ADMINISTRASI AKADEMIK & KEMAHASISWAAN (BAAK)</strong></div>
  <div style="font-size: 14pt; font-family: 'Arial', sans-serif;"><strong>KARTU HASIL STUDI (KHS)</strong></div>
</div>
<div>
  <hr />
</div>

<table width="100%" style="font-family: Arial; font-size: 10pt; ">
  <tr>
    <td width="15%">NIM</td>
    <td width="35%">: <?= $data['nim']; ?></td>
    <td width="20%">FAKULTAS</td>
    <td width="30%">: <?= $data['fakultas']; ?></td>
  </tr>
  <tr>
    <td width="15%">NAMA</td>
    <td width="35%">: <?= $data['nama']; ?></td>
    <td width="20%">JURUSAN</td>
    <td width="30%">: <?= $data['jurusan']; ?></td>
  </tr>
  <tr>
    <td width="15%">DOSEN WALI</td>
    <td width="35%">: </td>
    <td width="20%">PROGRAM STUDI</td>
    <td width="30%">: <?= $data['nm_prodi']; ?></td>
  </tr>
  <tr>
    <td width="15%">TH. MASUK</td>
    <td width="35%">: <?= $data['th_angkatan']; ?></td>
    <td width="20%">SEMESTER</td>
    <td width="30%">: SMT <?= $data['smt']; ?></td>
  </tr>

</table>
<table width="100%" style="border-top: 1px dotted #000000; border-left: 1px dotted #000000; border-right: 1px dotted #000000;  font-family: Arial; font-size: 9pt; autosize:2.4;">

  <tr>
    <th style="text-align: center; border-right: 1px dotted #000000;  border-bottom: 1px dotted #000000;" rowspan="2">NO.</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;" rowspan="2">KODE</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;" rowspan="2">MATA KULIAH</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;" colspan="8">PRESTASI</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;" rowspan="2">Predikat</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;" rowspan="2">Rekomendasi</th>
  </tr>
  <tr>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000; ">K/SKS</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">UTS</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">TGS</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">UAS</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">P</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">AM</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">HM</th>
    <th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">M</th>
  </tr>
  <?php //dd($data['khs'])
  ?>
  <?php foreach ($data['khs_detail'] as $r) { ?>
    <tr style="border-right:1px solid #000;border-bottom:1px solid #000;">
      <td align="center" style="border-right:1px dotted #000;"><?= $r['no']; ?></td>
      <td style="border-right:1px dotted #000;"><?= $r['kode_mk']; ?></td>
      <td style="border-right:1px dotted #000;"><?= $r['nama_mk']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['bobot']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['uts']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['tugas']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['uas']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['perf']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['akhir']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['huruf']; ?></td>
      <td align="center" style="border-right:1px dotted #000;"><?= $r['nilai_x']; ?></td>
      <td style="border-right:1px dotted #000;"><?= $r['ket']; ?></td>
      <td><?= $r['rekom']; ?></td>
    </tr>
  <?php } ?>
</table>

<br>
<div style="width: 50%; float: left; padding-right: 5mm; font-family: Arial; font-size: 9pt;">
  <div>Ket.</div>
  <div>Nilai kurang dari 2.00 / C- dan lebih kecil dinyatakan Tidak Lulus.</div>
  <div>Salah satu komponen nilai kosong dinyatakan tidak lulus</div>
  <div style="width: 15%; float: left; ">K/SKS</div>
  <div style="width: 85%; float: left; ">: Sistem Kredit Semester</div>
  <div style="width: 15%; float: left; ">UTS</div>
  <div style="width: 85%; float: left; ">: Ujian Tengah Semester</div>
  <div style="width: 15%; float: left; ">TGS</div>
  <div style="width: 85%; float: left; ">: Tugas</div>
  <div style="width: 15%; float: left; ">UAS</div>
  <div style="width: 85%; float: left;">: Ujian Akhir Semester</div>
  <div style="width: 15%; float: left; ">P</div>
  <div style="width: 85%; float: left; ">: Performance</div>
  <div style="width: 15%; float: left; ">HM</div>
  <div style="width: 85%; float: left; ">: Huruf Mutu</div>
  <div style="width: 15%; float: left; ">AM</div>
  <div style="width: 85%; float: left; ">: Angka Mutu</div>
  <div style="width: 15%; float: left; ">M</div>
  <div style="width: 85%; float: left; ">: Mutu (sks x Angka Mutu)</div>
</div>
<div style="width: 40%; float: left; padding-left: 5mm; font-family: Arial; font-size: 9pt;">
  <br><br>
  <div style="width: 65%; float: left;">SKS Semester Ini</div>
  <div style="width: 25%; float: left;">: <?= $data['sks_semester']; ?></div>

  <div style="width: 65%; float: left;">SKS yang telah diselesaikan</div>
  <div style="width: 25%; float: left;">: <?= $data['sks_total']; ?></div>

  <div style="width: 65%; float: left;">SKS maks. yang dapat diambil</div>
  <div style="width: 25%; float: left;">: <?= $data['sks_maks']; ?></div>

  <div style="width: 65%; float: left;">Total Nilai Semester Ini</div>
  <div style="width: 25%; float: left;">: <?= number_format($data['msmt_semester'], 2); ?></div>

  <div style="width: 65%; float: left;">IPK Semester Ini</div>
  <div style="width: 25%; float: left;">: <?= number_format($data['ips'], 2); ?></div>

  <div style="width: 65%; float: left;">IPK Terakhir</div>
  <div style="width: 25%; float: left;">: <?= number_format($data['ipk'], 2); ?></div>

  <div style="border:0.2mm solid #000; float:left; width:8.5cm; height:3.5cm; padding:3mm;">
    <div align="center"><strong>Kaprodi</strong></div><br><br><br><br><br><br>
    <div align="center"><strong><u><?= $data['kaprodi']; ?></u></strong></div>
    <div align="center"><?= $data['niy']; ?></div>
  </div>

</div>