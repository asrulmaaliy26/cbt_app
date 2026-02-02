
<style>
	
	.kotak_kartu_depan{
        width:8.56cm;
        height:5.4cm;
        
        border-radius: 10px;
        font-family: 'Tahoma', sans-serif;
        margin-left:0.5mm;
        float:left;
        position:relative;
        background-image: url(<?php echo base_url('assets/bg_ktm_depan.gif'); ?>);
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    
    .kotak_kartu_belakang{
        width:8.56cm;
        height:5.4cm;
        
        border-radius: 10px;
        font-family: 'Tahoma', sans-serif;
        margin-left:0.5mm;
        float:left;
        position:relative;
        background-image: url(<?php echo base_url('assets/bg_ktm_belakang.gif'); ?>);
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    
    .text_area{
      text-align:justify;
      margin-left:-5mm;
    }
    .foto{
      	width:17mm;
	    height:22mm;
      	float: right;
      	margin-right: 2mm;
      	text-align: center;
      	position: absolute;
        
	}
	.label{
	    text-align:right;
	    margin-right: 1mm;
        font-size:5pt;
	}
	.textbox{
        text-align:right;
        margin-right: 1mm;
        font-size:6pt;
	}
	
	img{
	    width:17mm;
	    height:22mm;
	}
	.qrcode{
        background-image: url(<?=$data['qrcode']; ?>);
      background-repeat: no-repeat;
      background-size: 200px 200px;
        float: right;
        width: 2cm;
        height: 2cm;
  }

</style>
<?
    if($data['diri']['Foto_Diri']==NULL || $data['diri']['Foto_Diri']==''){
        $foto = base_url('assets/no-pict.jpg');
    }else{
        $foto = base_url()."/".$data['diri']['Foto_Diri'];
    }
    
?>
<div class="kotak_kartu_depan">
    <div style="padding-top:19mm">
        <div class="foto">
            <img src="<?php echo $foto;?>">
        </div>
        <div style="float:right;width:4cm;">
            <div class="label"><em>Nama</em></div>
            <div class="textbox"><strong><em><?=ucwords($data['diri']['Nama_Lengkap']);?></em></strong></div>
            <div class="label"><em>Program Studi</em></div>
            <div class="textbox"><strong><em><?=ucwords(getDataRow('prodi', ['singkatan' => $data['his_pdk']['Prodi']])['nm_prodi']);?> (<?=$data['his_pdk']['Prodi'];?>)</em></strong></div>
            <div class="label"><em>Tempat Tanggal Lahir</em></div>
            <div class="textbox"><strong><em><?=ucwords($data['diri']['Kota_Lhr']);?>, <?=date_indo($data['diri']['Tgl_Lhr']);?></em></strong></div>
            <div class="label"><em>Alamat</em></div>
            <div class="textbox"><strong><em><?=ucwords($data['diri']['Desa']);?> <?=ucwords($data['diri']['Kec']);?> <?=ucwords($data['diri']['Kab']);?> <?=ucwords($data['diri']['Prov']);?></em></strong></div>
        </div>
        <!--<div class="qrcode" style="margin-top:5mm; margin-left:3mm;"></div>-->
    </div>
    
</div>
<div class="kotak_kartu_belakang">
    <div style="padding-top:19mm">
        
        <div class="qrcode" style=" margin-right:2mm;"></div>
        
    </div>
    <div>
        <div style="text-align:right; margin-right: 4mm; font-size:5pt;"><em>Nomor Induk Mahasiswa</em></div>
        <div style="text-align:right; margin-right: 4mm; font-size:8pt;"><strong><em><?=ucwords($data['his_pdk']['NIM']);?></em></strong></div>
    </div>
    
</div>

