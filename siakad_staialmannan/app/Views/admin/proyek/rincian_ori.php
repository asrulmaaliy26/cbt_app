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
                    <div class="col-md-10 offset-md-1">
                        <div class="table-responsive">
		                    <table class="table table-sm">
		                    	<tr>
			                        <th style="width:40%">NAMA PROYEK</th>
			                        <td><?=strtoupper($nama_proyek);?></td>
								</tr>
								<tr>
									<th >LOKAS</th>
									<td><?=strtoupper($lokasi_proyek);?></td>
								</tr>
								<tr>
									<th>TAHUN ANGGARAN</th>
									<td><?=$tahun_anggaran;?></td>
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
                    <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" onclick="tambah(<?=$id_proyek;?>)">
                        <i class="fa fa-plus"></i> Tambah Uraian Pekerjaan
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if(!empty($rincian)){?>
                        <table id="data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="col-1 text-center align-middle">NO.</th>
                                    <th class="col-9 text-center align-middle">URAIAN PEKERJAAN</th>
                                    <th class="col-2 text-center align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $penomoran = '';
                                    $nomorL1 = 1;
                                    $nomorL2 = 1;
                                    $nomorL3 = 1;
                                    $parents = array();
                                    foreach ($rincian as $key=>$item ) {
                                        
                                        if($item['parent_id'] == 0) {
                                            $parents[$key] = $item;
                                        } 
                                    }
                                    
                                    foreach ($parents as $parent) {
                                    //for($i = 0;$i < count($parents);$i++){
                                        $penomoran =$nomorL1;
                                        
                                ?>
                                <tr class="table-success" >
                                    <td class="align-middle"><strong><?=$penomoran;?></strong></td>
                                    <td class="align-middle"><strong><?=strtoupper($parent['uraian_pekerjaan']) ?></strong></td>
                                    <td class="text-center align-middle">
                                        <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$parent['id_pekerjaan'];?>)"><i class="fa fa-edit"></i></a>
                                        <a href="<?=base_url("$controller/tambahSubPekerjaan?id_pekerjaan=").$parent['id_pekerjaan']?>" role="button" class="btn btn-xs btn-primary show-modal" data-placement="top" title="Tambah" ><i class="fa fa-plus"></i></a>
                                        <a onclick="hapus(<?=$parent['id_pekerjaan'];?>)" role="button" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php 
                                        $parents2 = array();
                                        foreach ($rincian as $key2=>$item2 ) {
                                            if($item2['parent_id'] == $parent['id_pekerjaan']) {
                                                $parents2[$key2] = $item2;
                                            } 
                                        }
                                        
                                        foreach ($parents2 as $parent2) {
                                            $penomoran =$nomorL1.".".$nomorL2;
                                            
                                            if ($parent['id_pekerjaan'] == $parent2['parent_id'])  {
                                ?>
                                
                                    <tr class="table-primary"> 
                                        <td class="align-middle"><strong><?=$penomoran;?></strong></td>
                                        <td class="align-middle"><strong><?=strtoupper($parent2['uraian_pekerjaan']) ?></strong></td>
                                        <td class="text-center align-middle">
                                            <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$parent2['id_pekerjaan'];?>)"><i class="fa fa-edit"></i></a>
                                            <a href="<?=base_url("$controller/tambahSubPekerjaan?id_pekerjaan=").$parent2['id_pekerjaan']?>" role="button" class="btn btn-xs btn-primary show-modal" data-placement="top" title="Tambah" ><i class="fa fa-plus"></i></a>
                                            <a onclick="hapus(<?=$parent2['id_pekerjaan'];?>)" role="button" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr> 
                                <?php
                                    
                                    foreach ($rincian as $key)  { 
                                            $penomoran =$nomorL1.".".$nomorL2.".".$nomorL3;
                                            
                                            if ($parent2['id_pekerjaan'] == $key['parent_id'])  {
                                            
                                ?>
                                    <tr> 
                                        <td class="align-middle"><?=$penomoran;?></td>
                                        <td class="align-middle"><?=$key['uraian_pekerjaan'] ?></td>
                                        <td class="text-center align-middle">
                                            <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$key['id_pekerjaan'];?>)"><i class="fa fa-edit"></i></a>
                                            <a href="<?=base_url("$controller/tambahSubPekerjaan?id_pekerjaan=").$key['id_pekerjaan']?>" role="button" class="btn btn-xs btn-primary show-modal" data-placement="top" title="Tambah" ><i class="fa fa-plus"></i></a>
                                            <a onclick="hapus(<?=$key['id_pekerjaan'];?>)" role="button" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr> 
                                    
                                <?php
                                    
                                                $nomorL3++;
                                                } 
                                                
                                            } 
                                            
                                        } 
                                        $nomorL2++;    
                                        $nomorL3=1;
                                    } 
                                    $nomorL1++;
                                    $nomorL2=1;
                                    
                                }
                                   
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_group" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Uraian Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_pekerjaan" name="id_pekerjaan" />
                            <input type="text" class="form-control" hidden id="id_proyek" name="id_proyek" />
                            <input type="text" class="form-control"  id="uraian_pekerjaan" name="uraian_pekerjaan" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_simpan" onclick="simpan()">Simpan </button>
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
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
var table;
$(function() {
    bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('.summernote').summernote('reset');
    });
    
})

function tambah(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabelEdit').text('Tambah Uraian Pekerjaan');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        $('#' + key).val(value).trigger('change');
                    }else if ($('#' + key).is('.summernote')) {
                            $('#' + key).summernote('code', value);
                    }else{
                        $('#' + key).val(value);
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

function tambah_sub(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataPekerjaan");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabelEdit').text('Tambah Uraian Pekerjaan');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        $('#' + key).val(value).trigger('change');
                    }else if ($('#' + key).is('.summernote')) {
                            $('#' + key).summernote('code', value);
                    }else{
                        $('#' + key).val(value);
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


function simpan() {
    var data = new FormData($("#form_group")[0]);
    $('#form_group').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/$metode");?>",
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
                        $('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    }  else if (data.msg == 'warning') {

                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal disimpan',
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
        if(b.reload_page===true ){
            location.reload();
        }
        
        
        
      })}})(jQuery);
        
$(function(){    
  $('.show-modal').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:50vh;">No Support</object>';
    //var tabel = $(this).attr('tabel');
    //var titel =  $(this).attr('judul_modal');
    $.buatModal({
      title:"Tambah Uraian Pekerjaan",
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_transaksi,
      //status_transaksi: status_transaksi,
      closeButton:true,
      reload_page:true,
      scrollable:false
    });
    return false;        
  });    
});


</script>
<?=$this->endSection();?>