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
                                        <label>Tahun Pengajuan</label>
                                        <select name="tahun_pengajuan" id="tahun_pengajuan" class="form-control select2" onchange="reload_table()" style="width: 100%;">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tahun NIM</label>
                                        <select name="tahun_nim" id="tahun_nim" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                            <option></option>
                                            
                                            <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC', 'tahunAkademik'); 
                                                
                                                foreach ($tahunAkademik as $key ) {
                                            ?>
                                            <option value="<?=substr($key->kode,2,2)?>" ><?=$key->tahunAkademik?></option>
                                            <?php    }    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Prodi</label>
                                        <?php
                                            echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" onchange="reload_table()" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php
                                            echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'status_ijazah', 'is_aktif !=' => 'N']);
                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                            
                        <!--</div>-->
                    </form>
                
            
            </div>
            <!--<div class="card-footer">
                
                <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Data" onclick="frmtmbmhs()">
                    <i class="fa fa-plus"></i> Tambah
                </button>
                <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Update Status" onclick="show_modal_update()">
                    <i class="fa fa-sync"></i> Update Status
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Hapus Data" onclick="hapus()">
                    <i class="fa fa-trash"></i> Hapus Data
                </button>
                
            </div>-->
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
                    <table id="data" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" ></th>
                                <th class="text-center">No</th>
                                <th class="text-center">Tahun Pengajuan</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Biaya Perkuliahan</th>
                                <th class="text-center">Biaya Wisuda</th>
                                <th class="text-center">Biaya Ijazah</th>
                                <th class="text-center">Wakaf Buku</th>
                                <th class="text-center">Aksi</th>
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


<div class="modal fade" id="errorModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_import" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        
                    <div class="card card-primary">
                       
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 id="judulError" hidden>Data Error</h4>
                                    <table id="table1" class="table table-bordered table-hover">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_import" onclick="prosesImport()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="statusModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_update" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('status_update', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status_update"  style="width: 100%;"', null, null, ['opt_group' => 'status_ijazah', 'is_aktif !=' => 'N']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_status()">Simpan </button>
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
    table = $('#data').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    			$('td', row).eq(9).addClass('text-center');
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
            "url": "<?php echo site_url("$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_pengajuan = $('#tahun_pengajuan option:selected').val();
                data.tahun_nim = $('#tahun_nim option:selected').val();
                data.prodi = $('#prodi option:selected').val();
                data.stat = $('#status option:selected').val();
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


function detail(link){
    //var link = link;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Detail',
      message: iframe,
      ///link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      table_reload:true,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}

function activate(id, nama, field) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status "+nama+"!",
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
                url: "<?php echo site_url("$controller");?>",
                type: "post",
                data: "aksi=activate&id=" + id+"&field="+field,
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
                            title: 'Data '+nama+' berhasil diubah',
                            allowOutsideClick: false,
                        }).then(() => {
                            reload_table();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal diaktivasi',
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
    });
}

function deactivate(id, nama, field) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah data "+ nama +" ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>",
                type: "post",
                data: "aksi=deactivate&id=" + id +"&field="+field,
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
                            title: 'Data '+nama+ ' telah diubah',
                            allowOutsideClick: false,
                        }).then(() => {
                            reload_table();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal diupdate',
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
    });
}

</script>
<?=$this->endSection();?>