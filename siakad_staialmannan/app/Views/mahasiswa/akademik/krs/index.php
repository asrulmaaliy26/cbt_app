<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        
        <div class="card card-primary card-outline">
            
            <div class="card-body">
            	<div class="row">
                    <div class="col-6">
                        <div class="table-responsive">
		                    <table class="table table-sm">
		                    	<tr>
			                        <th style="width:40%">Nama</th>
			                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];?></td>
								</tr>
								<tr>
									<th >NIM</th>
									<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['NIM'];?></td>
								</tr>
								<tr>
									<th>Prodi</th>
									<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'];?></td>
								</tr>
								
		                      
		                    </table>
		                </div>
                    </div>
                    <div class="col-6">
                    	<div class="table-responsive">
		                    <table class="table table-sm">
		                    	<tr>
			                        <th style="width:40%">Tahun Angkatan</th>
			                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan']?>
			                        </td>
								</tr>
								<tr>
									<th >Kelas</th>
									<td><?=(getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PA") ? "Putera" : ((getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PI") ? "Puteri" : getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas']);?></td>
								</tr>
								<tr>
									<th>Program</th>
									<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Program'];?></td>
								</tr>
								
		                      
		                    </table>
		                </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    <?=$templateJudul?>
                </h3>
                <div class="card-tools">
                    <!--
                        <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                            <i class="fa fa-plus"></i> Tambah MK
                        </a>
                    -->
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_krs" class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">No.</th>
                                <th rowspan="2">Tahun</th>
                                <th rowspan="2">Program</th>
                                <th rowspan="2">Prodi</th>
                                <!--<th rowspan="2">SMT</th>-->
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Validasi BAK</th>
                                <th rowspan="2">Validasi Publikasi</th>
                                <th class="text-center" colspan="2">Berkas</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center">File</th>
                                <th class="text-center">Upload</th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
    
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>


<div class="modal fade" id="modal_upload_syarat_krs" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_upload_krs" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Syarat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row" hidden>
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_krs" name="id_krs" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Berkas</label>
                        <div class="col-sm-9">
                            <select name="jns_berkas" id="jns_berkas" class="form-control select2">
                                <<option value="">  </option>
									<option value="pembayaran" >Pembayaran KRS</option>
									<option value="publikasi" >Publikasi</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                            
                        </div>
                        
                    </div>
                    
                            
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" class="custom-file-input" id="file_syarat" name="file_syarat"
                                        oninput="pic_syarat.src=window.URL.createObjectURL(this.files[0])"> >
                                    
                                    <label class="custom-file-label" for="file_syarat">Choose file</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                            </div>
                            
                            <div class="col-sm-4 pt-2">
                                <div class="position-relative">
                                    <img id="pic_syarat" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="upload_krs()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
var table;
$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#modal_upload_syarat_krs').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic_syarat').removeAttr('src');
    });
    
    table = $('#data_krs').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    		},
            "destroy": true,
            "paging": false,
            "lengthChange": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/loadDataKrs") ?>",
                "type": "POST",
                "data": function(data) {
                    data.id_data_diri = "<?=$id_data_diri?>";
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

    $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                        
    var active_class = 'active';
    $('#data > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
        });
    });
})

function getDataKrs(id_krs){
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/getDataKrs");?>",
        data: "id_krs=" + id_krs,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                
                $('#modal_upload_syarat_krs').modal('show');
                
                $.each(response.data, function(key, value) {
                    
                    if(key == 'id' ){
                        $('#id_krs').val(value);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopsss',
                    text: 'blablabla'
                })
            }
        }
    })
}

function upload_krs() {

    var data = new FormData($("#form_upload_krs")[0]);
    $('#form_upload_krs').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller");?>"+"/upload_krs",
                type: "post",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
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
                    	$('#modal_upload_syarat_krs').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            reload_table();
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            if( key == 'file_syarat'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.custom-file').find('.invalid-feedback').text(value);
                            }else{
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }
                            
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

function lihat(link){
    //var link = link;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Bukti',
      message: iframe,
      ///link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //printButton:true,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}
function reload_table(){
    table.ajax.reload(null, false);
}

function formulir(id_krs) {
    var link = "<?=base_url("akademik/$controller/formulir_krs?id_krs=")?>"+id_krs;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Formulir Pemrograman KRS',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      table_reload:true,
      //tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}
</script>
<?=$this->endSection();?>