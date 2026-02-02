<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
<section class="content">
    <div class="container-fluid">
        
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        <?=$templateJudul?>
                    </h3>
                    <div class="card-tools">
                        
                        <a role="button" title="Tambah" data-palcement="top"  class="btn btn-success btn-sm show_modal" href="<?=base_url("$controller/tambahPeriodePendaftaran")?>" tabel="periode" judul_modal="Tambah Periode Pendaftaran">
                            <i class="fa fa-plus"></i> Tambah Periode Pendaftaran
                        </a>
                        
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" ></th>
                                <th class="text-center">No</th>
                                <th class="text-center">Tahun Akademik</th>
                                <th class="text-center">Jenjang</th>
                                <th class="text-center">Gelombang</th>
                                <th class="text-center">Mulai</th>
                                <th class="text-center">Akhir</th>
                                <th class="text-center">Biaya S1</th>
                                <th class="text-center">Aktif?</th>
                                <th class="text-center"></th>
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


<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content" >
            <form class="form-horizontal" id="form_tambah" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Periode Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_gel" name="id_gel" hidden />
                            <input type="text" class="form-control" id="Tahun_Akademik" name="Tahun_Akademik"  placeholder="2023/2024"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenjang</label>
                        <div class="col-sm-9">
                            <select name="jenjang" id="jenjang" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="S1"> Sarjana (S1) </option>
                                <option value="S2"> Pascasarjana (S2) </option>
                                
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Pendaftaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Nama_Periode" name="Nama_Periode"  placeholder="Pendaftaran Mahasiswa S1 Gel. 1"/>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Gelombang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Nama_Gelombang" name="Nama_Gelombang"  placeholder="Gelombang I Tahun 2023/2024"/>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <div class="input-group date" id="reservationdate_tgl_mulai" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="Tgl_Mulai"
                                    data-toggle="datetimepicker" name="Tgl_Mulai" data-target="#reservationdate_tgl_mulai"
                                    placeholder="DD-MM-YYYY" />
                                <div class="input-group-append" data-target="#reservationdate_tgl_mulai"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>
                        </div>
                        <label class="col-sm-1 col-form-label text-center">s/d</label>
                        <div class="col-sm-4">
                            <div class="input-group date" id="reservationdate_tgl_selesai" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="Tgl_Akhir"
                                    data-toggle="datetimepicker" name="Tgl_Akhir" data-target="#reservationdate_tgl_selesai"
                                    placeholder="DD-MM-YYYY" />
                                <div class="input-group-append" data-target="#reservationdate_tgl_selesai"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Biaya Pendaftaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="biaya" name="biaya"  placeholder="250000"/>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Informasi Pendaftaran</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="info_pendaftaran" name="info_pendaftaran"></textarea>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Informasi Biaya Perkuliahan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="info_biaya_kuliah" name="info_biaya_kuliah"></textarea>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Syarat Pendaftaran</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="persyaratan" name="persyaratan"></textarea>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Kontak Person</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="contact_person" name="contact_person"></textarea>
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Set Aktif?</label>
                        <div class="col-sm-9">
                            <select name="Aktif" id="Aktif" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="0"> Tidak </option>
                                <option value="1"> Ya </option>
                                
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
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

<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>


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
    $('#reservationdate_tgl_mulai, #reservationdate_tgl_selesai').datetimepicker({
        format: 'DD-MM-YYYY'

    });
    
    $('#info_pendaftaran').summernote({
        dialogsInBody: true,
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackinfo_pendaftaran(file[0]);
            }
        }
    });
    
    $('#info_biaya_kuliah').summernote({
        dialogsInBody: true,
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackinfo_biaya_kuliah(file[0]);
            }
        }
    });
    
    $('#persyaratan').summernote({
        dialogsInBody: true,
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackpersyaratan(file[0]);
            }
        }
    });
    
    $('#contact_person').summernote({
        dialogsInBody: true,
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackkontak(file[0]);
            }
        }
    });
    
    $('[data-mask]').inputmask();
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    
    table = $('#data').DataTable({
        "createdRow": function (row, data, index) {
			$('td', row).eq(1).addClass('text-center');
			$('td', row).eq(0).addClass('text-center');
			$('td', row).eq(3).addClass('text-center');
			$('td', row).eq(5).addClass('text-center');
			$('td', row).eq(6).addClass('text-center');
			$('td', row).eq(7).addClass('text-center');
			$('td', row).eq(8).addClass('text-center');
			$('td', row).eq(9).addClass('text-center');
			$('td', row).eq(10).addClass('text-center');
		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/ajaxListSetting") ?>",
            "type": "POST",
            "data": function(data) {
                
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

function reload_table(){
    table.ajax.reload(null, false);
}


function hapus(id) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Periode pendaftaran akan dihapus!",
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
                url: "<?php echo site_url("$controller/setting_pmb");?>",
                type: "post",
                data: "aksi=hapus&id=" + id,
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });

                    } else {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Data gagal dihapus'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function edit(id) {
    var link = "<?=base_url("$controller/tambahPeriodePendaftaran?id_gel=")?>"+id;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.buatModal({
      title:'Edit Periode Pendaftaran',
      message: iframe,
      closeButton:true,
      reload_table:true,
      scrollable:false
    });
    return false;
}

function simpan() {

    var data = $('#form_tambah').serialize();
    $('#form_tambah').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/simpanSettingPmb");?>",
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
                    	$('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
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
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function activate(id) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengaktifkan PMB!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/setting_pmb");?>",
                type: "post",
                data: "aksi=activate&id=" + id,
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

                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            reload_table();
                        });

                    } else {

                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function deactivate(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "PMB akan dinonaktifkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/setting_pmb");?>",
                type: "post",
                data: "aksi=deactivate&id=" + id,
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

                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            reload_table();
                        });

                    } else {

                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

(function(a){
    a.buatModal=function(b){
      defaults={
        title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
      };
      var b=a.extend({},defaults,b);
      var c=(b.scrollable===true)?'style=" overflow-y: auto;"':"";
      html='<div class="modal fade" id="myModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      html+='<div class="modal-dialog modal-xl" role="document">';
      html+='<div class="modal-content">';
      html+='<div class="modal-header">';
      if(b.title.length>0){
        html+='<h5 class="modal-title">'+b.title+"</h5>"
      }
      html+='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
      
      html+="</div>";
      html+='<div class="modal-body" '+c+">";
      html+=b.message;
      html+="</div>";
      html+='<div class="modal-footer">';
      if(b.status_transaksi && b.status_transaksi!=='Sukses'){
        html+='<a role="button" href="javascript:void(0)" onclick="confirmBayar('+b.id_transaksi+')" class="btn btn-sm btn-success" rel="noopener">Konfirmasi</a>'
      }
      if(b.status_transaksi && b.status_transaksi==='Sukses'){
        html+='<a role="button" href="'+b.link_cetak+'" class="btn btn-sm btn-primary" rel="noopener" target="_blank"><i class="fas fa-print"></i> Print</a>'
      }
      if(b.closeButton===true){
        html+='<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>'
      }
      
      html+="</div>";
      html+="</div>";
      html+="</div>";
      html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
        a(this).remove();
        if(b.reload_table===true ){
            reload_table()
        }
        
        
      })}})(jQuery);
        
$(function(){    
  $('.show_modal').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    var tabel = $(this).attr('tabel');
    var titel =  $(this).attr('judul_modal');
    $.buatModal({
      title:titel,
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_transaksi,
      //status_transaksi: status_transaksi,
      closeButton:false,
      reload_table:true,
      //tabel:tabel,
      scrollable:false
    });
    return false;        
  });    
});
</script>

<?=$this->endSection();?>