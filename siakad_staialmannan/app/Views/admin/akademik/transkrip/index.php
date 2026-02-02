<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                    <form action="" method="get">
                        <!--<div class="col-md-10 offset-md-1">-->
                            <div class="row ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select name="tahun_angkatan" id="tahun_angkatan" class="form-control select2" style="width: 100%;">
                                            <option></option>
                                            
                                            <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC', 'tahunAkademik'); 
                                                foreach ($tahunAkademik as $key ) {
                                            ?>
                                            <option value="<?=$key->tahunAkademik?>" ><?=$key->tahunAkademik?> </option>
                                            <?php    }    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Prodi</label>
                                        <?php
                                            echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi"  style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mahasiswa</label>
                                        <select name="m" id="m" class="form-control  select2" style="width:100%">
    						                	
    						            </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group ">
                                        <label for="tanggal" >Tanggal Cetak</label>
                                        <div class="input-group date " id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" id="tanggal" data-toggle="datetimepicker" name="tanggal" data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=date('Y-m-d')?>"/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                            </div>
                            
                        <!--</div>-->
                    </form>
                
            
            </div>
            <!--<div class="card-footer">
                
                <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" onclick="show_modal_jadwal()">
                    <i class="fa fa-sync"></i> Update Jadwal
                </a>
                
                <a role="button" class="btn btn-danger btn-sm" title="Hapus KRS" data-palcement="top"  href="javascript:void(0)" onclick="ekspor()">
                    <i class="fa fa-trash"></i> Hapus Data
                </a>
            </div>-->
        </div>
        <div class="card card-primary card-outline" id="card_khs" hidden>
            
            
        </div>
        
    </div>
</section>


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


<script>

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#reservationdate').datetimepicker({
        defaultDate:'now',
        format: 'YYYY-MM-DD',

    });

    $('#prodi').on('select2:select', function(e) {
        var selectedProdi = $(this).find(':selected').val();
        var selectedTa = $("#tahun_angkatan").find(':selected').val();
        $.ajax({
            url: "<?php echo site_url("akademik/$controller/getMhs");?>",
            method: "POST",
            data: {
                selectedProdi: selectedProdi,
                selectedTa: selectedTa
            },
            success: function(html) {
                $("#m").html(html);
                //loadPelajaran();
            }
        })

    })
    
    $('#m').on('select2:select', function(e) {
        var tgl = $('#tanggal').val();
        var mhs = $(this).find(':selected').val();
        $.ajax({
			url:"<?php echo site_url("akademik/$controller/getTranskrip");?>",
			data:{id_his_pdk:mhs, tgl:tgl},
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
			success: function(html)
			{
		            $('#card_khs').attr('hidden',false);
		            Swal.close();
		            $("#card_khs").html(html);
			}
		});

    })
    
    $('#tahun_angkatan').on("change", function (e) { 
        
        $('#prodi').val('').trigger('change');
        $('#m').children('option').remove();
    });
    $('#prodi').on("change", function (e) { 
        $('#m').children('option').remove();
    });
    
})

function cetakKHS() {
    var id_his_pdk = $('#m option:selected').val();
    var smt = $('#s option:selected').val();
    //var link = "<?=site_url("dashboard/ppdb/cetakForm/?id_siswa=")?>" + id_siswa;
    var link = "<?=site_url("akademik/$controller/cetakKHS?id_his_pdk=")?>"+id_his_pdk+"&smt="+smt
    Swal.fire({
        title: 'Anda yakin akan mencetak KHS ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/cekKHS");?>",
                type: "post",
                data: {
                    id_his_pdk: id_his_pdk,
                    smt:smt
                },
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
                    if (data.status) {
                        halaman = window.open(link, "",
                            "width=800,height=600,status=1,scrollbar=yes");
                        return false;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data KHS tidak ditemukan'
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
<?=$this->endSection();?>