
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$templateJudul?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  	<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:25%">Mahasiswa</th>
                                    <td>: <?php 
                                                $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri'];
                                                echo getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];
                                            ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th >Prodi</th>
                                    <td>: <?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi']?> - <?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['kelas']?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Tgl. Upload</th>
                                    <td>: <?=($ujian == 'uas')?$tgl_upload_ljk_uas:$tgl_upload_ljk_uts?></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:25%">Jenis Ujian</th>
                                    <td>: <?=($ujian == 'uas')?'UJIAN AKHIR SEMESTER':'UJIAN TENGAH SEMESTER'?></td>
                                  </tr>
                                  <tr>
                                    <th >Mata Kuliah</th>
                                    <td>: <?=getDataRow('master_matakuliah', ['kode_mk'=>$kode_mk_feeder])['nama_mk']?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Jadwal Ujian</th>
                                    <td>: <?=($ujian == 'uas')?getDataRow('mata_kuliah',['id'=>$id_mk])['Hari'].", ".getDataRow('mata_kuliah',['id'=>$id_mk])['Thn']."-".getDataRow('mata_kuliah',['id'=>$id_mk])['Bln']."-".getDataRow('mata_kuliah',['id'=>$id_mk])['Tgl']." Jam ".getDataRow('mata_kuliah',['id'=>$id_mk])['Jam']." Ruang ".getDataRow('mata_kuliah',['id'=>$id_mk])['Ruang']:getDataRow('mata_kuliah',['id'=>$id_mk])['Hari_UTS'].", ".short_tgl_indonesia_date(getDataRow('mata_kuliah',['id'=>$id_mk])['Thn_UTS']."-".getDataRow('mata_kuliah',['id'=>$id_mk])['Bln_UTS']."-".getDataRow('mata_kuliah',['id'=>$id_mk])['Tgl_UTS'])." Jam ".getDataRow('mata_kuliah',['id'=>$id_mk])['Jam_UTS']." Ruang ".getDataRow('mata_kuliah',['id'=>$id_mk])['Ruang_UTS']?></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php if($jns_soal == '2'){?>
                <div class="card card-primary">
                    <div class="card-header">
                        Soal
                    </div>
                    <div class="card-body">
                        <?=($ujian == 'uas')?getDataRow('mata_kuliah',['id'=>$id_mk])['uas_soal']:getDataRow('mata_kuliah',['id'=>$id_mk])['uts_soal']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Lembar Jawaban
                    </div>
                    <div class="card-body">
                        <?=($ujian == 'uas')?str_replace( 'http://', 'https://',$ljk):str_replace( 'http://', 'https://',$ljk_uts)?>
                    </div>
                </div>
            <?php } ?>
            
            <?php if($jns_soal == '1'){?>
                
                <div class="card card-primary">
                    <div class="card-header">
                        Judul Artikel
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['judul']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Abstrak
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['abstrak']?>
                    </div>
                </div>
                
                <div class="card card-primary">
                    <div class="card-header">
                        Fokus Pembahasan
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['fokus']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Penelitian Terdahulu (Literatur Review)
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['review']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Posisi Artikel
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['posisi']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Sisi Kebaruan (Novelty)
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['novelty']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Metode
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['metode']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Kesimpulan
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['kesimpulan']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Referensi
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['referensi']?>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        Sistematika Artikel
                    </div>
                    <div class="card-body">
                        <?=getDataRow('tugas_artikel',['id'=>$artikel])['sistematika']?>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    
                    <div class="card-body">
                        <iframe src="<?=str_replace( 'http://', 'https://',getDataRow('tugas_artikel',['id'=>$artikel])['file_artikel'])?>" style="width: 100%; height: 400px;" frameborder="0"></iframe>
                    </div>
                </div>
                
            <?php } ?>
                    
                    
                
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- ./wrapper -->
<!-- Page specific script -->
<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets');?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
$(function() {
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

})

function simpan() {

    var data = $('#form_jurnal').serialize();
    $('#form_jurnal').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan jurnal perkuliahan ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: data,
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
                    if (data.msg == 'success') {
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });
                    }else{
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

</script>
</body>
</html>