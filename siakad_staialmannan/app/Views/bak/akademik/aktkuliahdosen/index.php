<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    	<div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Filter
                        </h3>
                    </div>
                    <div class="card-body">
                        <form id="form_filter">
	                        <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tahun Akdemik</label>
                                    <select name="tahun_akademik" id="tahun_akademik" class="form-control select2"  style="width: 100%;">
                                        <option></option>
                                        
                                        <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                            $tAktif = (!empty(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']))?getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']:'';
                                            foreach ($tahunAkademik as $key ) {
                                        ?>
                                        <option value="<?=$key->kode?>" <?=(!empty($tAktif) && $tAktif==$key->kode)?'selected':''?>><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                        <?php    }    ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
	                            <div class="form-group">
	                                <label for="tgl_awal">Tgl Awal </label>
	                                <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                        <input type="text" required class="form-control datetimepicker-input" id="tgl_awal"
                                            data-toggle="datetimepicker" name="tgl_awal" data-target="#reservationdate1"
                                            placeholder="YYYY-MM-DD" />
                                        <div class="input-group-append" data-target="#reservationdate1"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
	                            </div>
	                            <div class="form-group">
	                                <label for="jns_berkas">Tgl Akhir</label>
	                                <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                        <input type="text" required class="form-control datetimepicker-input" id="tgl_akhir"
                                            data-toggle="datetimepicker" name="tgl_akhir" data-target="#reservationdate2"
                                            placeholder="YYYY-MM-DD" />
                                        <div class="input-group-append" data-target="#reservationdate2"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
	                            </div>
	                        </div>
	                    </form>    
                    </div>
                    <div class="card-footer">
                    	<button type="button" onclick="cekData()" class="btn btn-sm btn-primary">Lihat Data</button>
                    	<button type="button" onclick="cetakPdf()" class="btn btn-sm btn-primary">PDF</button>
                    </div>
                </div>
                <!-- /.card -->
	            
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline" id="card-data" hidden>
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Data
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Dosen</th>
                                        <th class="text-center">Mata Kuliah</th>
                                        <th class="text-center">Pelaksanaan</th>
                                        <th class="text-center">Prodi</th>
                                        <th class="text-center">Kelas</th>
                                        <th class="text-center">SMT</th>
                                        <th class="text-center">Jml Pertemuan</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                    </div>
                    
                </div>
                <!-- /.card -->
            
            </div>
            
        </div>

    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

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
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>

$(function() {

    $('#reservationdate, #reservationdate1, #reservationdate2').datetimepicker({
        format: 'YYYY-MM-DD'

    });
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

})

function cekData()
{
    var data = $('#form_filter').serialize();
    $('#form_filter').find('input').removeClass('is-invalid');
    $('#form_filter').find('.invalid-feedback').text('');
    $.ajax({
        url: "<?php echo site_url("akademik/$controller/cekData");?>",
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
            if(data.msg == 'warning'){
        	    
                $.each(data.validation, function(key, value) {
                    
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parents('.form-group').find('.invalid-feedback')
                        .text(value);
                });
        	}else{
        	    $('#card-data').attr('hidden', false);
        	    listData();
        	}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function listData()
{
    $('#data').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("akademik/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_akademik = $('#tahun_akademik').val();
                data.tgl_awal = $('#tgl_awal').val();
                data.tgl_akhir = $('#tgl_akhir').val();
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function detail(kd_kelas_perkuliahan, tgl_awal, tgl_akhir)
{
    var link = "<?=base_url("akademik/$controller/detail?kd_kelas_perkuliahan=")?>"+kd_kelas_perkuliahan+"&tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;
    $.createModal({
      title:'Detail Pertemuan',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //reload_table:true,
      //tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}

function cetakPdf(){
    var data = $('#form_filter').serialize();
    $('#form_filter').find('input').removeClass('is-invalid');
    $('#form_filter').find('.invalid-feedback').text('');
    var tahun_akademik = $('#tahun_akademik option:selected').val();
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();
    var link_cetak = "<?=site_url("akademik/$controller/cetakRekap?tahun_akademik=")?>"+tahun_akademik+"&tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir
    Swal.fire({
        title: 'Anda yakin akan mencetak rekap aktivitas perkuliahan dosen ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/cekData");?>",
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
                    if (data.msg == 'warning') {
                        $.each(data.validation, function(key, value) {
                    
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });
                    } else {
                        halaman = window.open(link_cetak, "",
                            "width=800,height=600,status=1,scrollbar=yes");
                        return false;
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
