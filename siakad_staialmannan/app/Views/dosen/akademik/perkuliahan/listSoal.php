<div class="row">   
    <!--
    <?php if(!empty($perkuliahan['uts_soal'])){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Soal UTS</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=uts"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
    -->
    <?php if(($perkuliahan['jns_uts'] == '2') && !empty($perkuliahan['uts_soal'])){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Soal / Penugasan UTS</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=uts"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if($perkuliahan['jns_uts'] == '1'){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Soal UTS Artikel</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=uts"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('uts_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if(($perkuliahan['jns_uas'] == '2') && !empty($perkuliahan['uas_soal'])){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Soal / Penugasan UAS</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=uas"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('uas_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('uas_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if($perkuliahan['jns_uas'] == '1'){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Soal UAS Artikel</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=uas"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('uas_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('uas_soal','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if(!empty($perkuliahan['tugas'])){ ?>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h5 class="card-title">Tugas Akhir Matakuliah</h5>
                    <p class="card-text">
                    
                    </p>
                    <a href="<?=base_url("akademik/$controller/lihatSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']."&jns_ujian=tugas"?>" target="_blank" class="btn btn-success btn-sm">Lihat</a>
                    <a onclick="editSoal('tugas','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-primary btn-sm ">Edit</a>
                    <a onclick="hapusSoal('tugas','<?=$perkuliahan['kd_kelas_perkuliahan']?>')" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
function hapusSoal(field, kd_kelas_perkuliahan) {
    //var link = "<?=site_url("dashboard/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/tambahSoal");?>",
                type: "post",
                data: "aksi=hapus&field=" + field + "&kd_kelas_perkuliahan="+kd_kelas_perkuliahan,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            getSoal(data.kd_kelas_perkuliahan);
                        });

                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    //$(".overlay").css("display","none");
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
}

function editSoal(jns_ujian, kd_kelas_perkuliahan)
{
    var link = "<?=base_url("akademik/$controller/tambahSoal?jns_ujian=")?>"+jns_ujian+"&kd_kelas_perkuliahan="+kd_kelas_perkuliahan;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.buatModal({
      title:'Edit Soal',
      message: iframe,
      closeButton:true,
      reload_table:true,
      tabel:'soal',
      scrollable:false
    });
    return false;
}
</script>