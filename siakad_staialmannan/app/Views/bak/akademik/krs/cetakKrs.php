

  
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
                <img src="<?php echo base_url(); ?>/assets/logo_iaibafa.png"  alt="">
            </div>
            <div style="font-size: 17pt; font-family: 'Arial', sans-serif;">
                <strong>KARTU RENCANA STUDI</strong>
            </div>
            <div style="font-size: 14pt; font-family: 'Arial', sans-serif;"><strong>INSTITUT AGAMA ISLAM BANI FATTAH (IAIBAFA) JOMBANG</strong></div>
            <div style="font-size: 14pt; font-family: 'Arial', sans-serif;"><strong><?="Tahun Akademik ".getDataRow('tahun_akademik', ['kode' => $data['krs']['kode_ta']])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode' => $data['krs']['kode_ta']])['semester'] == '1' ? 'Gasal':'Genap')?></strong></div>
        </div>
        <div><hr/></div>
        <div style="width: 50%; float: left;">
            <div class="kolom1">Nama</div>
            <div class="kolom2">: <?=getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['Nama_Lengkap'];?></div>
            <div class="kolom1">N I M</div>
            <div class="kolom2">: <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['NIM'];?></div>
            <div class="kolom1">Prodi</div>
            <div class="kolom2">: <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Prodi'];?></div>
        </div>
        <div style="width: 50%; float: left;">
            <div class="kolom1">Semester</div>
            <div class="kolom2">: <?php
                                if ($data['krs']['kode_ta'] %2 != 0){
                                	$a = (($data['krs']['kode_ta'] + 10)-1)/10;
                                	$b = $a - intval(substr(getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['th_angkatan'], 0, 4));
                                	$c = ($b*2)-1;
                                	echo $c;
                                }else{
                                	$a = (($data['krs']['kode_ta'] + 10)-2)/10;
                                	$b = $a - intval(substr(getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['th_angkatan'], 0, 4));
                                	$c = $b * 2;
                                	echo $c;
                                }
                        ?>
            </div>
            <div class="kolom1">Program</div>
            <div class="kolom2">: <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Program'];?></div>
            <div class="kolom1">Kelas</div>
            <div class="kolom2">: <?=(getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Kelas'] == "PA") ? "Putera" : ((getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Kelas'] == "PI") ? "Puteri" : getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Kelas']);?></div>
    </div>
    <div style="width: 100%; float: left;">
        <table width="100%" style=" topntail: 0.02cm solid #000000;" border="1" autosize="1.8">
            <thead >
                <tr style="background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;">
                    <th>No.</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Dosen</th>
                </tr>
            </thead>
        <tbody>
            <?php
				if (!empty($data['mata_kuliah'])) {
				    
					$i =1;
					$sks = 0;
					foreach ($data['mata_kuliah'] as $row): 
					    $dtMk = getDataRow('mata_kuliah', ['id'=>$row['id_mk']]);
					    $sks += $dtMk['SKS'];
						?>
						<tr>
							<td align="center"><?php echo $i; ?></td>
							<td><?php echo $dtMk['Kode_MK_Feeder']; ?></td>
							<td><?php echo $dtMk['Mata_Kuliah']; ?></td>
							<td align="center"><?php echo $dtMk['SKS']; ?></td>
							<td><?php echo getDataRow('data_dosen',['Kode' => $dtMk['Kd_Dosen']])['Nama_Dosen']; ?></td>
						</tr>

						<?php 
						$i++;
					endforeach; 
					?>
					<tr class="success">
						<td colspan="3" align="center"><b>Total SKS</b></td>
						<td align="center" ><b><?php echo $sks ?></b></td>
						
					</tr>
			<?php }  ?>
        </tbody>
      </table>
    </div>
    <?php $mk_tl = dataDinamis('data_ljk', ['Status_Nilai !=' => 'L', 'id_his_pdk' => $data['krs']['id_his_pdk'], 'smt_mhs <' => $c], 'smt_mhs ASC') ;
            if(!empty($mk_tl)){
    ?>
    <div style="font-size: 14pt; font-family: 'Arial', sans-serif;"><strong>MATA KULIAH SEMESTER LALU YANG BELUM LULUS</strong></div>
    <div style="width: 100%; float: left;">
      <table width="100%" style=" topntail: 0.02cm solid #000000;" border="1" autosize="1.8">
        <thead >
          <tr style="background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;">
            <th>No.</th>
            <th>Mata Kuliah</th>
            <th>SMT</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $nor=1; foreach ($mk_tl as $r) {  ?>
          <tr >
            <td align="center"><?=$nor++;?></td>
            <td><?=getDataRow('master_matakuliah', ['kode_mk' => $r->kode_mk_feeder])['nama_mk'];?></td>
            <td align="center"><?=$r->smt_mhs;?></td>
            
            <td align="center"><?=$r->Status_Nilai;?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>  
    <?php } ?>
    <br>

    
    <div class="colttd2">
        Ketua Prodi <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['krs']['id_his_pdk']])['Prodi'];?><br><br><br><br><br><br><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>


