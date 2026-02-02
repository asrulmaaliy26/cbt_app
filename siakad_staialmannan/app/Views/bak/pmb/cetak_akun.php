
<style>
	
	.kotak_kartu{
        width:5.398cm;
        height:8.56cm;
        background:#d7d6d3;
        text-align:center;
        border-radius: 10px;
        padding: 3mm;
        font-family: 'Tahoma', sans-serif;
        font-size:11pt;
        line-height: 1.2;
        margin-left:1mm;
        float:left;
        position:relative;
    }
    
    .text_area{
      text-align:justify;
      margin-left:-5mm;
      white-space: nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
      font-size:14vmin;
    }
    .foto{
      	width: 2cm;
      	height: 3cm;
      	margin-left:auto;
      	margin-right:auto;
	}
	.textbox{
	    background:#fff;
        text-align:center;
        padding:2px;
        border-radius: 3px;
        font-size:11pt;
        position:fixed;
        overflow: visible;
       
	}
	.header{
	    font-size:11pt;
	}
	img{
	    width:2cm;
	    height:3cm;
	}
	.jarak{
        padding:5px;
        font-size:11pt;
	}

</style>

<div class="kotak_kartu">
    <div ><strong>KARTU AKUN</strong><br><strong>SIAKAD IAIBAFA</strong></div>
    <?
        if(getDataRow('users', ['username'=>$data['username']])['foto_profil']==NULL || getDataRow('users', ['username'=>$data['username']])['foto_profil']==''){
            $foto = base_url('assets/dist/img/no-pict.jpg');
        }else{
            $foto = base_url()."/".$data['akun']['foto_profil'];
        }
        
    ?>
    <div class="jarak"></div>
    <div class="foto" ><img src="<?php echo $foto;?>"></div>
    <div class="jarak"></div>
    NAMA
    <div class="textbox"><?=ucwords(getDataRow('users', ['username'=>$data['username']])['nama_lengkap']);?></div>
    USER ID
    <div class="textbox"><?=$data['username'];?></div>
    EMAIL
    <div class="textbox"><?=getDataRow('users', ['username'=>$data['username']])['email'];?></div>
    PASSWORD
    <div class="textbox"><?=getDataRow('users', ['username'=>$data['username']])['password_plain'];?></div>
</div>
<div class="kotak_kartu">
    <div class="header"><strong>INFORMASI</strong></div>
    <div class="text_area" id="outer">
        <div>
            <ul>
                
                <li>Siakad IAIBAFA dapat diakses melalui laman <strong><?=base_url()?></strong></li>
                <li>User ID dan Password hanya bisa digunakan di Siakad IAIBAFA.</li>
                <li>Siakad IAIBAFA digunakan untuk menangani proses pengelolaan data akademik seperti KRS, KHS, Ujian dan data terkait lainnya.</li>
                <li>Kartu ini hanya berisi informasi akun mahasiswa dan tidak berlaku sebagai Kartu Tanda Mahasiswa (KTM).</li>
            </ul>
        </div>
    </div>
    
</div>



