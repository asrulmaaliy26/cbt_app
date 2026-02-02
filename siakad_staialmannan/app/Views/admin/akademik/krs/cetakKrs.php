<style type="text/css">
  .boxkartu{
    border:0.2mm dashed #220044;
    padding: 2mm;
  }
  .logo{
    width: 2cm;
    height: 2cm;
    float: left;
  }
  .kop-header{
    float: left;
    padding-left: 1mm;
    vertical-align: middle;
  }
  .kolom1{
    width: 25%; 
    float: left;
    margin-bottom: 6pt;
    font-family: 'Arial', sans-serif; 
  }
  .kolom2{
    width: 75%; 
    float: left;
    margin-bottom: 6pt;
    font-family: 'Arial', sans-serif; 
  }
  .colttd1{
    width: 50%; 
    float: left;
    font-family: Tahoma, Helvetica, sans-serif;
  }
  .colttd2{
    width: 50%; 
    float: left;
    font-family: Tahoma, Helvetica, sans-serif;
  }
  body{
    font-family: 'Arial', sans-serif;
  }
</style>

<div class="boxkartu">
  <div class="header">
    <div class="logo">
      <img src="<?= base_url('assets/logo.png'); ?>" alt="">
    </div>
    <div style="font-size:17pt; font-family:'Arial', sans-serif;"><strong>KARTU RENCANA STUDI</strong></div>
    <div style="font-size:14pt; font-family:'Arial', sans-serif;"><strong>INSTITUT AGAMA ISLAM BANI FATTAH (IAIBAFA) JOMBANG</strong></div>
    <div style="font-size:14pt; font-family:'Arial', sans-serif;">
      <strong>Tahun Akademik <?= $tahunAkademik . ' ' . $semesterTA; ?></strong>
    </div>
  </div>

  <hr>

  <div style="width:50%; float:left;">
    <div class="kolom1">Nama</div>
    <div class="kolom2">: <?= $mahasiswa['Nama_Lengkap']; ?></div>

    <div class="kolom1">NIM</div>
    <div class="kolom2">: <?= $histori['NIM']; ?></div>

    <div class="kolom1">Prodi</div>
    <div class="kolom2">: <?= $histori['Prodi']; ?></div>
  </div>

  <div style="width:50%; float:left;">
    <div class="kolom1">Semester</div>
    <div class="kolom2">: <?= $semester; ?></div>

    <div class="kolom1">Program</div>
    <div class="kolom2">: <?= $histori['Program']; ?></div>

    <div class="kolom1">Kelas</div>
    <div class="kolom2">: <?= $histori['Kelas'] ?? '-'; ?></div>
  </div>

  <!-- ================== TABEL MK ================== -->
  <div style="width:100%; float:left;">
    <table width="100%" border="1" style="border-collapse: collapse;">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode MK</th>
          <th>Mata Kuliah</th>
          <th>SKS</th>
          <th>Dosen</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; $totalSksTmp = 0; foreach ($mataKuliah as $mk): 
            $totalSksTmp += $mk['sks'];
        ?>
        <tr>
          <td align="center"><?= $no++; ?></td>
          <td><?= $mk['kode']; ?></td>
          <td><?= $mk['nama']; ?></td>
          <td align="center"><?= $mk['sks']; ?></td>
          <td><?= $mk['dosen']; ?></td>
        </tr>
        <?php endforeach; ?>

        <tr>
          <td colspan="3" align="center"><b>Total SKS</b></td>
          <td align="center"><b><?= $totalSksTmp; ?></b></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- ================== MK TIDAK LULUS ================== -->
  <?php if (!empty($mkTidakLulus)): ?>
    <div style="font-size:14pt; font-family:'Arial', sans-serif;"><strong>MATA KULIAH SEMESTER LALU YANG BELUM LULUS</strong></div>
    <div style="width:100%; float:left;">
      <table width="100%" border="1" style="border-collapse: collapse;">
        <thead>
          <tr>
            <th>No</th>
            <th>Mata Kuliah</th>
            <th>SMT</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($mkTidakLulus as $mk): ?>
          <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $mk['nama']; ?></td>
            <td align="center"><?= $mk['smt']; ?></td>
            <td align="center"><?= $mk['status']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <br>

  <div class="colttd2">
    Ketua Prodi <?= $histori['Prodi']; ?><br><br><br><br><br><br>
    <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
  </div>
</div>
