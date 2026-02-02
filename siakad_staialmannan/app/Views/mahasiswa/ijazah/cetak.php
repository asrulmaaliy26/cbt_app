<style>
ol, ul { text-align: justify;}

</style>

<div style="text-align: center; font-family: Tahoma; font-size: 12pt; font-weight: bold;">
    SURAT PENGANTAR PENGAMBILAN IJAZAH
</div>
<br>
<div style="padding-left: 13mm; padding-right: 13mm; font-family: Tahoma; font-size: 12pt;">
    
    <table style="width:100%; font-family: Tahoma; font-size: 12pt;" >
       
        <tbody>
            <tr>
                <td style="width: 25%;">Nama Mahasiswa</td>
                <td style="width: 5%;">:</td>
                <td><?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap']);?></td>
            </tr>
            <tr>
                <td style="width: 25%;">NIM</td>
                <td style="width: 5%;">:</td>
                <td><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['ijazah']['id_his_pdk']])['NIM'];?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Prodi</td>
                <td style="width: 5%;">:</td>
                <td><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['ijazah']['id_his_pdk']])['Prodi']])['nm_prodi'];?></td>
            </tr>
            
        </tbody>
    </table>
</div>
<div style="padding-left: 13mm; font-family: Tahoma; font-size: 12pt;">
   
</div>
<div style="padding-left: 13mm; padding-right: 13mm; font-family: Tahoma; font-size: 12pt;">
    <table style="width:100%;  font-family: Tahoma; font-size: 12pt;" border="1">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Persyaratan</th>
                <th style="text-align: center;">Petugas</th>
                <th style="text-align: center;">Tanda Sah</th>
            </tr>
        </thead>
        <tbody>
            <tr >
                <td style="text-align: center; height: 75px;">1</td>
                <td>Melunasi biaya perkuliahan</td>
                <td style="text-align: center;">BAK</td>
                <td style="text-align: center;"><?=$data['ijazah']['biaya_kuliah']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            <tr >
                <td style="text-align: center; height: 75px;">2</td>
                <td>Melunasi biaya wisuda</td>
                <td style="text-align: center;">BAK</td>
                <td style="text-align: center;"><?=$data['ijazah']['biaya_wisuda']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            <tr>
                <td style="text-align: center; height: 75px;">3</td>
                <td>Melunasi biaya pengurusan Ijazah</td>
                <td style="text-align: center;">BAK</td>
                <td style="text-align: center;"><?=$data['ijazah']['biaya_pengurusan_ijazah']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            <tr>
                <td style="text-align: center; height: 75px;">4</td>
                <td>Wakaf Buku</td>
                <td style="text-align: center;">BAK</td>
                <td style="text-align: center;"><?=$data['ijazah']['waqaf_buku']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            <tr>
                <td style="text-align: center; height: 75px;">5</td>
                <td>Menyerahkan revisi skripsi</td>
                <td style="text-align: center;">Kaprodi</td>
                <td style="text-align: center;"><?=$data['ijazah']['revisi_skripsi']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            
            <tr>
                <td style="text-align: center; height: 75px;">6</td>
                <td>Bebas tanggungan peminjaman buku</td>
                <td style="text-align: center;">Perpustakaan</td>
                <td style="text-align: center;"><?=$data['ijazah']['peminjaman_buku']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
            <tr>
                <td style="text-align: center; height: 75px;">7</td>
                <td>Submit artikel di jurnal online</td>
                <td style="text-align: center;">LPJI</td>
                <td style="text-align: center;"><?=$data['ijazah']['artikel']==1?'<img src="'.$data['qrcode'].'" width="75" height="75">':'';?></td>
            </tr>
        </tbody>
    </table>
</div>
<br>
