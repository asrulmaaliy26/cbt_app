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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tahun Keluar</label>
                                        <select name="tahun_keluar" id="tahun_keluar" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                            <option></option>
                                            
                                            <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                                $tAktif = (!empty(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']))?getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']:'';
                                                foreach ($tahunAkademik as $key ) {
                                            ?>
                                            <option value="<?=$key->kode?>" <?=(!empty($tAktif) && $tAktif==$key->kode)?'selected':''?>><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                            <?php    }    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Prodi</label>
                                        <?php
                                            echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" onchange="reload_table()" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            	
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Jenis Keluar</label>
                                        <?php
                                            echo cmb_dinamis('jenis_keluar', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="jenis_keluar"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'jns_keluar', 'is_aktif !=' => 'N']);
                                        ?>
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                        <!--</div>-->
                    </form>
                
            </div>
                    
            <div class="card-footer">
                <a role="button" class="btn btn-primary btn-sm show-modal" title="Form Kelulusan" data-palcement="top"  href="<?=base_url("akademik/$controller/formulir")?>" judul-modal="Formulir Kelulusan / DO">
                    <i class="fa fa-sync"></i> Form Kelulusan / DO
                </a>
                
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
                    <table id="data" class="table table-bordered table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" ></th>
                                <th class="text-center">No</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Angkatan</th>
                                <th class="text-center">Jenis Keluar</th>
                                <th class="text-center">Tgl Keluar</th>
                                <th class="text-center">Periode</th>
                                <th class="text-center">Ket</th>
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

<div class="modal fade" id="HisPdkModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_his_pdk" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelHis">Tambah Histori Pendidikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label" >Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_his_pdk" name="id_his_pdk" />
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                       
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Keluar</label>
                        <div class="col-sm-9">
                            
                            <select name="keluar_smt" id="keluar_smt" class="form-control select2" style="width: 100%;">
                                <option></option>
                                
                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                    
                                    foreach ($tahunAkademik as $key ) {
                                ?>
                                <option value="<?=$key->kode?>" ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                <?php    }    ?>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Keluar</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('jns_keluar', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="jns_keluar" style="width:100%"', null, null, ['opt_group' => 'jns_keluar', 'is_aktif' => 'Y']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status"  style="width:100%;"',null,null, ['opt_group'=>'status_mhs']);
                            ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tgl. Keluar / Lulus</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_keluar_date"
                                data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    id="tgl_keluar" data-toggle="datetimepicker" name="tgl_keluar"
                                    data-target="#tgl_keluar_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#tgl_keluar_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tgl. SK Yudisium / Keluar</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_yudisium_date"
                                data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    id="tgl_sk_yudisium" data-toggle="datetimepicker" name="tgl_sk_yudisium"
                                    data-target="#tgl_yudisium_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#tgl_yudisium_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">No. SK Yudisium / Keluar</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sk_yudisium" name="sk_yudisium" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ket" name="ket" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>  
                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_histori_pddk()">Simpan </button>
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
    
    $('#HisPdkModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    $('#tgl_keluar_date, #tgl_yudisium_date').datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years'
    });
    // Autocomplete Select2
    $('#dosen').select2({
        placeholder: '--- Ketikan Nama Dosen ---',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getNamaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: 'data_dosen',
                    field: 'Nama_Dosen',
                    select: 'Kode as id, Nama_Dosen as text, NIY as atribut1',
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    
    $('#jadwalModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    
    table = $('#data').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
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
        "info": true,
        "autoWidth": true,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("akademik/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.keluar_smt = $('#tahun_keluar').val();
                data.prodi = $('#prodi').val();
                data.jns_keluar = $('#jenis_keluar').val();
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

function edit_his_pdk(id_his_pdk) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/getDataHisPdk");?>",
        data: "id_his_pdk=" + id_his_pdk,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#HisPdkModal').modal('show');
                $('#exampleModalLabelHis').text('Edit Histori Pendidikan');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        
                            $('#' + key).val(value).trigger('change');
                        
                    }else{
                        $('#' + key).val(value);
                    }
                });
                changeStatus();
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

function simpan_histori_pddk() {

    var data = new FormData($("#form_his_pdk")[0]);
    Swal.fire({
        title: 'Anda yakin akan menyimpan Data Kelulusan / Keluar ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller");?>"+"/simpan_histori_pddk",
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
                    	$('#HisPdkModal').modal('hide');
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
                            if(key != 'Foto_Diri'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
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
                        }).then(() => {
                            reload_table();
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function reload_table(){
    table.ajax.reload(null, false);
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
        if(b.reload_table===true){
            reload_table();
        }
        
        
        
      })}})(jQuery);
        
$(function(){    
  $('.show-modal').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    var titel =  $(this).attr('judul-modal');
    $.buatModal({
      title:titel,
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_transaksi,
      //status_transaksi: status_transaksi,
      closeButton:false,
      reload_table:true,
      scrollable:false
    });
    return false;        
  });    
});

function show_modal_jadwal() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		$('#jadwalModal').modal();
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Silahkan Pilih Mata Kuliah!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function ekspor() {
    var kd_tahun = $('#tahun_akademik option:selected').val();
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Mengunduh data "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
    				type: "POST",
    				data: {id:list, kd_tahun:kd_tahun},
    			    url:"<?php echo site_url("akademik/$controller/ekspor")?>",
    				dataType: "JSON",
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
    				success: function (data) {
    					Swal.close();
    					var $a = $("<a>");
                        $a.attr("href",data.file);
                        $("body").append($a);
                        $a.attr("download",data.nama_file);
                        $a[0].click();
                        $a.remove();
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
    					alert('Gagal Membuat Data LJK');
    				}
    			});
    			return true;
            }
        })
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah yang akan diekspor!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function hapus(id, matakuliah) {
    //var link = "<?=site_url("akademik/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: matakuliah+" akan dihapus ??",
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
                url: "<?php echo site_url("akademik/$controller");?>",
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
                    //$(".overlay").css("display","none");
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: matakuliah+' berhasil dihapus',
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
                            title: matakuliah+' gagal dihapus'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function hapus_kolektif() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Menghapus data "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
    				type: "POST",
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/hapus_kolektif")?>",
    				dataType: "JSON",
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
    				success: function (data) {
    				    Swal.close();
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    				    /*
    					if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: list.length+' matakuliah berhasil dihapus',
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
                                title: list.length+' gagal dihapus'
                            })
                        }
                        */
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
    					Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
    				}
    			});
    			return true;
            }
        })
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah yang akan dihapus!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function reset_jadwal() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Mereset jadwal "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
    				type: "POST",
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/reset_jadwal")?>",
    				dataType: "JSON",
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
    				success: function (data) {
    				    Swal.close();
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    				    /*
    					if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: list.length+' matakuliah berhasil dihapus',
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
                                title: list.length+' gagal dihapus'
                            })
                        }
                        */
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
    					Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
    				}
    			});
    			return true;
            }
        })
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah yang akan direset!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function generate_kd_perkuliahan() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "generate kode "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
    				type: "POST",
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/generate_kd_perkuliahan")?>",
    				dataType: "JSON",
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
    				success: function (data) {
    				    Swal.close();
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    			
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
    					Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
    				}
    			});
    			return true;
            }
        })
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}


function simpan() {
    var dosen = $('#dosen option:selected').val();
    var H_Jadwal = $('#H_Jadwal option:selected').val();
    var jam = $('#jam option:selected').val();
    var ruang_kuliah = $('#ruang_kuliah option:selected').val();
    var pelaksanaan_kuliah = $('#pelaksanaan_kuliah option:selected').val();
    var kd_tahun = $('#tahun_akademik option:selected').val();
    
    var list = [];
    $('.data-check:checked').each(function(){
        list.push(this.value);
    })
    if(list.length >0){
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Memeperbarui data "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/simpanJadwal");?>",
                    type: "post",
                    data: {id_distribusi_mk:list, dosen:dosen, H_Jadwal:H_Jadwal, jam:jam, ruang_kuliah:ruang_kuliah, pelaksanaan_kuliah:pelaksanaan_kuliah, kd_tahun:kd_tahun},
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
                        	$('#jadwalModal').modal('hide');
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
                        }else if (data.msg == 'info'){
                            Swal.fire({
                                icon: data.msg,
                                title: data.pesan,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            })
                            if(data.listError.length > 0){
                                $('#errorModal').modal('show')
    
                                const thead = $('#tabel_error thead'); 
                                const tbody = $('#tabel_error tbody');
                                let tr = $("<tr />");
    
                                $.each(Object.keys(data.listError[0]), function(_, key){
                                    tr.append("<th>" + key + "</th>")
                                });
                                tr.appendTo(thead);
    
                                $.each(data.listError, function (_, value) {
                                    tr = $("<tr />");
                                    $.each(value, function(_, text){
                                        tr.append("<td>" + text + "</td>")
                                    });
                                    tr.appendTo(tbody);
                                })
    
                            }
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
                            title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                });
            }
        })
                
    }else{
        Swal.fire({
            icon: 'warning',
            title: 'Silahkan pilih Matakuliah terlebih dahulu!!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
    }
    
}

</script>
<?=$this->endSection();?>