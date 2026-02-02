
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cetak Transkrip Nilai</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
  	<style>
  	    @page {
            /*size: 210mm 297mm;*/
            margin: 5mm 5mm 5mm 5mm; /* change the margins as you want them to be. */
        }
        
        .ttd{
		
          	width: auto;
          	height: 4cm;
          	
    	}
    	
    	@media print{
            table.table-bordered{
                border:1px solid black !important;
              }
            table.table-bordered > thead > tr > th{
                border:1px solid black !important;
            }
            table.table-bordered > tbody > tr > td{
                border:1px solid black !important;
            }

            table.tb-transkrip > tbody > tr > td span{
                display: block;
                white-space: nowrap;
                width: 100px;
                overflow: hidden;
                font-size: 100%;
            }
        }
  	</style>
</head>
<body style="font-size: 11pt; font-family: 'Arial', sans-serif;">
<div class="wrapper">
  <!-- Main content -->
  

    <div class="row">
        
        <img src="<?=base_url('assets/kop.jpg');?>" style="width: 100%;" class="img-fluid" alt="...">
        
      <!-- /.col -->
    </div>
    <div class="row">
        
      <div class="col-12" align="center">
        
        <h3 class="page-header">
            <b>TRANSKRIP HASIL STUDI</b>
        </h3>
      </div>
      <!-- /.col -->
    </div>

    <?php 
        if(!empty($his_pdk)){
    ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="table-responsive table-responsive-sm">
                    <table class="table table-sm table-borderless" style="width:100%; line-height: 0.8;">
                        <tr>
                            <td width="30%">Nama Mahasiswa</td>
                            <td width="70%">
                                : <?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['Nama_Lengkap'])?>
                            </td>
                            
                        </tr>
                        <tr>
                            <td width="30%">NIM / NPM</td>
                            <td width="70%">: <?=$his_pdk['NIM']?></td>
                            
                        </tr>
                        <tr>
                            <td width="30%">Tahun Masuk</td>
                            <td width="70%">: <?=getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['th_angkatan']?></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive table-responsive-sm">
                    <table class="table table-sm table-borderless" style="width:100%; line-height: 0.8;">
                        <tr>
                            <td width="30%">Fakultas</td>
                            <td width="70%">
                                : <?=ucwords(getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['fakultas'])?>
                            </td>
                        </tr>
                        <tr>

                            <td width="30%">Program Studi</td>
                            <td width="70%">: <?=ucwords(getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['nm_prodi'])?></td>
                        </tr>
                        <tr>

                            <td width="30%">Kelas Perkuliahan</td>
                            <td width="70%">: <?=$his_pdk['Program']?></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
    <?php }
        if(!empty($nilai)){
           $arrays = array_chunk($nilai, ceil(count($nilai) / 2));
           //dd($arrays);
           $no = 1;
           $jmlSks = 0;
           $mutu = 0;
           $jmlMutu = 0;
           foreach($arrays as $chunk){

    ?>
        <div class="col-sm-6">
                <div class="table-responsive table-responsive-sm tb-transkrip">
                    <table class="table table-sm table-bordered" style="width: 100%; line-height: 1.5;">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="60%" class="text-center">Mata Kuliah</th>
                                <th width="10%" class="text-center">SKS</th>
                                <th width="10%" class="text-center">NA</th>
                                <th width="10%" class="text-center">NH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chunk as $subarray) { //dd($subarray)
                                    $jmlSks += $subarray->SKS;
                                    $mutu = number_format($subarray->am, 2) * $subarray->SKS;
                                    $jmlMutu += $mutu;
                            ?>
                                    
                            <tr>
                                <td class="text-center"><?=$no++?></td>
                                <td ><span><?=$subarray->nama_mk?></span></td>
                                <td class="text-center"><?=$subarray->SKS?></td>
                                <td class="text-center"><?=number_format($subarray->am, 2)?></td>
                                <td class="text-center"><?=$subarray->hm?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php } } $ipk = number_format(($jmlMutu/$jmlSks), 2);?>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="table-responsive table-responsive-sm">
                    <table class="table table-sm table-borderless" style="width:100%; line-height:0.8;">
                        <tr>
                            <td width="50%">TOTAL SKS</td>
                            <td width="50%">: <?=$jmlSks?></td>
                            
                        </tr>
                        <tr>
                            <td width="50%">INDEKS PRESTASI KUMULATIF</td>
                            <td width="50%">: <?=$ipk?></td>
                            
                        </tr>
                        <tr>
                            <td width="50%">PREDIKAT KELULUSAN</td>
                            <td width="50%">: 
                                <?php
                                    if($ipk > 3.75){
                                        echo "Cumlaude";
                                    }
                                    if($ipk > 3.50 && $ipk <= 3.75){
                                        echo "Sangat Memuaskan";
                                    }
                                    if($ipk > 3.00 && $ipk <= 3.50){
                                        echo "Memuaskan";
                                    }
                                    if($ipk <= 3.00){
                                        echo "-";
                                    }
                                ?>
                            </td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="col-sm-5 offset-sm-1">
                Jombang, <?=short_tgl_indonesia_date($tgl)?><br>Kaprodi
                <br>
                <img src="<?=$qrcode?>" alt="" style="width:2.65cm;height:2.65cm;"/>
                <br>
                <strong><?=getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['kaprodi']?></strong><br><?=getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['niy']?>
            </div>
        </div>

        <div class="row">
    
            
        </div>
  
  
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
    $(function() {
      $('td span').each(function() {
        var fontSize = 100;
        while (this.scrollWidth > $(this).width() && fontSize > 0) {
          // adjust the font-size 5% at a time
          fontSize -= 5;
          $(this).css('font-size', fontSize + '%');
        }
      });
    });
  window.addEventListener("load", window.print());
</script>
<script>
    var css = '@page { size: portrait; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
    
    style.type = 'text/css';
    style.media = 'print';
    
    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    
    head.appendChild(style);
	window.print();
	window.onfocus=function() {window.close();}
</script>
</body>
</html>