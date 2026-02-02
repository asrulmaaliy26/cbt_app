<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>FORMULIR PENDAFTARAN</title>
<style type="text/css">
	@page {
      size: 8.268in 11.693in; /* <length>{1,2} | auto | portrait | landscape */
            /* 'em' 'ex' and % are not allowed; length values are width height */
      margin-top: 0.2cm; /* <any of the usual CSS values for margins> */
                   /*(% of page-box width for LR, of height for TB) */
      margin-left: 0.1in;
      margin-right: 0.1in;

    }
    .text_area{
      
      padding-left: 15mm;
      padding-right: 10mm;
      font-family: 'Tahoma', sans-serif;
      font-size: 11pt;
      line-height: 1.3;
    }
	.kolom1{
		width: 25%; 
		float: left;
		margin-bottom: 6pt; 
	}
	.kolom2{
		width: 70%; 
		float: left;
		margin-bottom: 6pt;
	}
	.foto{
		
      	width: 3cm;
      	height: 4cm;
      	float: right;
      	text-align: center;
      	
	}
	.ttd{
		float: right;
		width: 6cm;
		height: 4cm;
		padding-left: 5mm;
	}
	.berkas{
		border:0.2mm solid #000000;
		float: left;
		width: 7cm;
		height: 4cm;
		padding-left: 3mm;
		padding-right: 3mm;
	}
</style>
</head>

<body style="font-family: 'Arial', sans-serif; font-size: 10pt;">
<div>
	<img src="<?php echo base_url(); ?>/assets/header_formulir.jpg" alt=""/>
</div>
<div class="text_area">
	<div align="center"><strong>FORMULIR PENDAFTARAN MAHASISWA BARU</strong></div>

	<div style="border:0.2mm dashed #220044; padding: 0.2cm;">
		<div style="width: 25%; float: left; ">
			No. Pendaftaran <br>Jalur PMB <br>Status Pendaftaran
		</div>
		<div style="width: 25%; float: left; ">
			 : <?=$data['pmb']['No_Pendaftaran'];?> <br>: <?=$data['pmb']['Jalur_PMB'];?> <br>: <?=$data['pmb']['Status_Pendaftaran'];?>
		</div>
		<div style="width: 25%; float: left; ">
			Jenjang <br> Program <br>Pilihan Prodi
		</div>
		<div style="width: 20%; float: left; ">
			 : <?=$data['pmb']['program_sekolah'];?> <br>: <?=$data['pmb']['Kelas_Program_Kuliah'];?> <br>: <?=$data['pmb']['Prodi_Pilihan_1'];?>
		</div>
	</div>

	<div style="width: 100%; float: left; ">
	<table width="100%" border="0" style="vertical-align: text-top;" >
	  <tbody>
	  	<tr>
	      <td colspan="7"><strong>Identitas Diri :</strong></td>
	     </tr>
	    <tr>
	      <td width="16%">Nama</td>
	      <td colspan="2">: <?=$data['diri']['Nama_Lengkap'];?></td>
	      <td width="1%">&nbsp;</td>
	      
	    </tr>
	    <tr>
	      <td>NIK</td>
	      <td colspan="2">: <?=$data['diri']['No_KTP'];?></td>
	      <td>&nbsp;</td>
	      <td>No. KK</td>
	      <td colspan="2">: <?=$data['diri']['No_KK'];?></td>
	    </tr>
	    <tr>
	      <td>TTL</td>
	      <td colspan="2">: <?=$data['diri']['Kota_Lhr'];?>, <?=$data['diri']['Tgl_Lhr'];?></td>
	      <td>&nbsp;</td>
	      <td>Jenis Kelamin</td>
	      <td width="16%">: <?=($data['diri']['Jenis_Kelamin'] == 'L')?'Laki-laki':(($data['diri']['Jenis_Kelamin'] == 'P')?'Perempuan':'');?></td>
	      <td width="17%">Gol. Darah : <?=$data['diri']['Gol_Darah'];?></td>
	    </tr>
	    <tr>
	      <td>Agama</td>
	      <td colspan="2">: <?=(!empty($data['diri']['Agama']))?getDataRow('ref_option', ['opt_group'=>'agama','opt_id'=>$data['diri']['Agama']])['opt_val']:'';?></td>
	      <td>&nbsp;</td>
	      <td>Warga Negara</td>
	      <td colspan="2">: <?=$data['diri']['Kewarganegaraan'];?> (<?=$data['diri']['Kode_Negara'];?>)</td>
	    </tr>
	    <tr>
	      <td>Alamat</td>
	      <td colspan="6">: <?=$data['diri']['Alamat'];?> <?=$data['diri']['No_Rmh'];?> <?=$data['diri']['Dusun'];?> <?=$data['diri']['RT'];?> <?=$data['diri']['RW'];?> <?=$data['diri']['Desa'];?> <?=$data['diri']['Kec'];?> <?=$data['diri']['Kab'];?> <?=$data['diri']['Prov'];?> <?=$data['diri']['Kode_Pos'];?></td>
	      </tr>
	    <tr>
	      <td>Domisili</td>
	      <td colspan="2">: <?=(!empty($data['diri']['Jenis_Domisili']))?getDataRow('ref_option', ['opt_group'=>'jns_tinggal','opt_id'=>$data['diri']['Jenis_Domisili']])['opt_val']:'';?></td>
	      <td>&nbsp;</td>
	      <td>No. Telp Domisili</td>
	      <td colspan="2">: <?=$data['diri']['No_Telp_Hp'];?></td>
	    </tr>
	    <tr>
	      <td>Alamat Domisili</td>
	      <td colspan="6">: <?=$data['diri']['Tempat_Domisili'];?></td>
	      </tr>
	    <tr>
	      <td>Stts. Perkawinan</td>
	      <td colspan="2">: <?=$data['diri']['Status_Perkawinan'];?></td>
	      <td>&nbsp;</td>
	      <td>Pekerjaan</td>
	      <td colspan="2">: <?=(!empty($data['diri']['Pekerjaan']))?getDataRow('ref_option', ['opt_group'=>'pekerjaan','opt_id'=>$data['diri']['Pekerjaan']])['opt_val']:'';?></td>
	    </tr>
	    <tr>
	      <td>Biaya Ditangung</td>
	      <td colspan="2">: <?=$data['diri']['Biaya_ditanggung'];?></td>
	      <td>&nbsp;</td>
	      <td>Transportasi</td>
	      <td colspan="2">: <?=(!empty($data['diri']['Transportasi']))?getDataRow('ref_option', ['opt_group'=>'alat_transport','opt_id'=>$data['diri']['Transportasi']])['opt_val']:'';?></td>
	    </tr>
	    <tr>
	      <td>Penerima KPS</td>
	      <td colspan="2">: <?php if($data['diri']['Penerima_KPS']==1){$kps = "Ya";}else{ $kps="tidak";}; echo $kps;?>&nbsp;&nbsp;No. KPS : <?=$data['diri']['No_KPS'];?></td>
	      <td>&nbsp;</td>
	      <td>Anak Ke- </td>
	      <td>: <?=$data['diri']['Anak_Ke'];?></td>
	      <td>Jml. Saudara : <?=$data['diri']['Jml_Saudara'];?></td>
	    </tr>
	    <tr>
	      <td>No. HP</td>
	      <td colspan="2">: <?=$data['diri']['No_HP'];?></td>
	      <td>&nbsp;</td>
	      <td>Email</td>
	      <td colspan="2">: <?=$data['diri']['Email'];?></td>
	    </tr>
	    <tr>
	      <td colspan="7"><strong>Riwayat Pendidikan S1 :</strong></td>
	      </tr>
	    <tr>
	      <td>Status PT S1</td>
	      <td colspan="2">: <?=$data['diri']['Status_Asal_Sekolah'];?></td>
	      <td>&nbsp;</td>
	      <td>Nama PT S1</td>
	      <td colspan="2">: <?=$data['diri']['Nama_Lengkap_SLTA_Asal'];?></td>
	    </tr>
	    <tr>
	      <td>Jurusan / Program Studi</td>
	      <td colspan="2">: <?=$data['diri']['Kejuruan_SLTA'];?></td>
	      <td>&nbsp;</td>
	      <td>Tahun Lulus</td>
	      <td colspan="2">: <?=$data['diri']['Th_Lulus_SLTA'];?></td>
	    </tr>
	    
	    <tr>
	      <td colspan="3"><strong>Identitas Ayah</strong></td>
	      <td>&nbsp;</td>
	      <td colspan="3"><strong>Identitas Ibu</strong></td>
	      </tr>
	    <tr>
	      <td width="16%">Nama</td>
	      <td colspan="2">: <?=$data['ortu']['Nama_Ayah'];?></td>
	      <td>&nbsp;</td>
	      <td width="16%">Nama </td>
	      <td colspan="2">: <?=$data['ortu']['Nama_Ibu'];?></td>
	    </tr>
	    <tr>
	      <td>NIK</td>
	      <td colspan="2">: <?=$data['ortu']['Nomor_KTP_Ayah'];?></td>
	      <td>&nbsp;</td>
	      <td>NIK</td>
	      <td colspan="2">: <?=$data['ortu']['Nomor_KTP_Ibu'];?></td>
	    </tr>
	    <tr>
	      <td>TTL</td>
	      <td colspan="2">: <?=$data['ortu']['Tempat_Lhr_Ayah'];?>, <?=$data['ortu']['Tgl_Lhr_Ayah'];?></td>
	      <td>&nbsp;</td>
	      <td>TTL</td>
	      <td colspan="2">: <?=$data['ortu']['Tempat_Lhr_Ibu'];?>, <?=$data['ortu']['Tgl_Lhr_Ibu'];?></td>
	    </tr>
	    <tr>
	      <td>Agama</td>
	      <td width="16%">: <?=(!empty($data['ortu']['Agama_Ayah']))?getDataRow('ref_option', ['opt_group'=>'agama','opt_id'=>$data['ortu']['Agama_Ayah']])['opt_val']:'';?></td>
	      <td width="18%">Gol. Darah : <?=$data['ortu']['Gol_Darah_Ayah'];?></td>
	      <td>&nbsp;</td>
	      <td>Agama</td>
	      <td>: <?=(!empty($data['ortu']['Agama_Ibu']))?getDataRow('ref_option', ['opt_group'=>'agama','opt_id'=>$data['ortu']['Agama_Ibu']])['opt_val']:'';?></td>
	      <td>Gol. Darah: <?=$data['ortu']['Gol_Darah_Ibu'];?></td>
	    </tr>
	    <tr>
	      <td>Warga Negara</td>
	      <td colspan="2">: <?=$data['ortu']['Kewarganegaraan_Ayah'];?></td>
	      <td>&nbsp;</td>
	      <td>Warga Negara</td>
	      <td colspan="2">: <?=$data['ortu']['Kewarganegaraan_Ibu'] ;?></td>
	    </tr>
	    <tr>
	      <td>Pendidikan </td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Pendidikan_Terakhir_Ayah']))?getDataRow('ref_option', ['opt_group'=>'jenj_pendidikan','opt_id'=>$data['ortu']['Pendidikan_Terakhir_Ayah']])['opt_val']:'';?></td>
	      <td>&nbsp;</td>
	      <td>Pendidikan </td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Pendidikan_Terakhir_Ibu']))?getDataRow('ref_option', ['opt_group'=>'jenj_pendidikan','opt_id'=>$data['ortu']['Pendidikan_Terakhir_Ibu']])['opt_val']:'';?></td>
	    </tr>
	    <tr>
	      <td>Pekerjaan</td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Pekerjaan_Ayah']))?getDataRow('ref_option', ['opt_group'=>'pekerjaan','opt_id'=>$data['ortu']['Pekerjaan_Ayah']])['opt_val']:'';?></td>
	      <td>&nbsp;</td>
	      <td>Pekerjaan</td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Pekerjaan_Ibu']))?getDataRow('ref_option', ['opt_group'=>'pekerjaan','opt_id'=>$data['ortu']['Pekerjaan_Ibu']])['opt_val']:'';?></td>
	    </tr>
	    <tr>
	      <td>Penghasilan</td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Penghasilan_Ayah']))?getDataRow('ref_option', ['opt_group'=>'penghasilan','opt_id'=>$data['ortu']['Penghasilan_Ayah']])['opt_val']:'';?></td>
	      <td>&nbsp;</td>
	      <td>Penghasilan</td>
	      <td colspan="2">: <?=(!empty($data['ortu']['Penghasilan_Ibu']))?getDataRow('ref_option', ['opt_group'=>'penghasilan','opt_id'=>$data['ortu']['Penghasilan_Ibu']])['opt_val']:'';?></td>
	    </tr>
	    <tr>
	      <td>No. HP</td>
	      <td colspan="2">: <?=$data['ortu']['No_HP_ayah'];?></td>
	      <td>&nbsp;</td>
	      <td>No. HP</td>
	      <td colspan="2">: <?=$data['ortu']['No_HP_ibu'] ;?></td>
	    </tr>
	    <tr>
	      <td>Alamat Ortu</td>
	      <td colspan="6">: <?=$data['ortu']['Alamat_Ayah'];?> <?=$data['ortu']['No_Rmh_Ayah'];?> <?=$data['ortu']['Dusun_Ayah'];?> <?=$data['ortu']['RT_Ayah'];?> <?=$data['ortu']['RW_Ayah'];?> <?=$data['ortu']['Desa_Ayah'];?> <?=$data['ortu']['Kec_Ayah'];?> <?=$data['ortu']['Kab_Ayah'];?> <?=$data['ortu']['Prov_Ayah'];?> <?=$data['ortu']['Kode_Pos_Ayah'];?></td>
	      </tr>
	  </tbody>
	</table>
	</div>
	<div style="margin-top: 0.5cm;"></div>
	<div class="ttd">
		Tambakberas, <?=date_indo($data['pmb']['Tgl_Daftar']);?><br>Calon Mahasiswa,<br><br><br><br><br><br><u><strong><?=$data['diri']['Nama_Lengkap'];?></strong></u><br>Nama Terang dan Tanda Tangan
	</div>
	<div class="foto">
		<img src="<?=(!empty($data['diri']['Foto_Diri']))?base_url($data['diri']['Foto_Diri']):base_url('assets/no-pict.jpg');?>"  alt="">
	</div>
	<div class="berkas">
		<div align="center" style="margin-bottom: 5pt;">Persyaratan </div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Copy Ijazah Legalisir (5 lb)
		</div>
		<div style="float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Copy SKHU Legalisir (5 lb)
		</div>
		<div style="float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Copy KTP / KK (5 lb)
		</div>
		<div style="float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Hitam Putih 3x3 (10 lb)
		</div>
		<div style="float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Hitam Putih 3x4 (10 lb)
		</div>
		<div style="float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
		<div style="float: left; width: 80%; text-align: left; margin-bottom: 5pt;">Foto Berwarna 5x6 (2 lb)
		</div>
		<div style=" float: left; width: 10%; text-align: center; border: 0.2mm solid #000000; float: right; ">&nbsp;</div>
	</div>
</div>




</body>
</html>
