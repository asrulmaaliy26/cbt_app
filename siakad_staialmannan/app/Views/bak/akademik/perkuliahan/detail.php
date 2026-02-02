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
                    <div class="col-sm-7">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:25%">Mata Kuliah</th>
                                <td>: <?=$perkuliahan['Mata_Kuliah']?></td>
                              </tr>
                              <tr>
                                <th >Nama Dosen</th>
                                <td>: <?=getDataRow('data_dosen', ['Kode'=>$perkuliahan['Kd_Dosen']])['Nama_Dosen']?></td>
                              </tr>
                              
                              <tr>
                                <th>Jadwal</th>
                                <td>: <?=$perkuliahan['H_Jadwal']?> Jam <?=$perkuliahan['Jam_Jadwal']?> Ruang <?=$perkuliahan['R_Jadwal']?></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-5">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:45%">Kode Kelas Perkuliahan</th>
                                <td>: <?=$perkuliahan['kd_kelas_perkuliahan']?></td>
                              </tr>
                              <tr>
                                <th >Pelaksanaan</th>
                                <td>: <?=(!empty($perkuliahan['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $perkuliahan['Pelaksanaan']])['opt_val']:'-'?></td>
                              </tr>
                              
                              <tr>
                                <th>Prodi - Kelas</th>
                                <td>: <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null,null,'Prodi');
                                            $prod =[]; 
                                            foreach ($prodi as $key ) {
                                               $prod[] = $key->Prodi;
                                            }
                                            $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null,null,'Kelas');
                                            $kls =[]; 
                                            foreach ($kelas as $key ) {
                                               $kls[] = $key->Kelas;
                                            }
                                            echo implode(" - ", $prod)." (".implode(" - ", $kls).")";
                                        ?>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#absensi" data-toggle="tab">Absensi</a></li>
              <li class="nav-item"><a class="nav-link" href="#jurnal_pengajaran" onclick="getJurnalKuliah('<?=$perkuliahan['kd_kelas_perkuliahan']?>')" data-toggle="tab">Jurnal Pengajaran</a></li>
              </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="absensi">
                <div class="mailbox-controls">
                    <div class="card">
                        <div class="card-body">
                                <form action="" method="get">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Program Studi</label>
                                                    <select name="prodi" id="prodi" class="form-control select2" style="width: 100%;">
                                                        <option></option>
                                                        
                                                        <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null, null, 'Prodi'); 
                                                            
                                                            foreach ($prodi as $key ) {
                                                        ?>
                                                        <option value="<?=$key->Prodi?>" ><?=$key->Prodi?></option>
                                                        <?php    }    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        	<div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select name="kelas" id="kelas" class="form-control select2"  style="width: 100%;">
                                                        <option></option>
                                                        
                                                        <?php $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null, null, 'Kelas'); 
                                                            
                                                            foreach ($kelas as $key ) {
                                                        ?>
                                                        <option value="<?=$key->Kelas?>" ><?=$key->Kelas?></option>
                                                        <?php    }    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </form>
                            
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mahasiswa" onclick="getDataMhs()">
                                Rekap Absen
                            </button>
                            
                            <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mahasiswa" onclick="cetakAbsensiKosong()">
                                Cetak Absensi Kosong
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Pilih Kosma" onclick="pilihKosma('<?=$perkuliahan['kd_kelas_perkuliahan']?>')">
                                Pilih Kosma
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table id="data_mhs" class="table table-bordered table-hover table-sm">
    	                <thead>
    		                <?php if(session()->get('akun_username') == "Administrator"){ ?>
    		                <tr>
    		                    <th class="text-center">No</th>
    		                    <th>id_his_pdk</th>
    		                    <th>id_mhs_his_pdk</th>
    		                    <th>id_data_diri</th>
    		                    
    		                </tr>
    		                <?php } else { ?>
    		                <tr>
    		                    <th rowspan="2" class="text-center align-middle"></th>
    		                    <th rowspan="2" class="text-center align-middle">No</th>
    		                    <th rowspan="2" class="text-center align-middle">Nama</th>
    		                    <th rowspan="2" class="text-center align-middle">NIM</th>
    		                    <th rowspan="2" class="text-center align-middle">Tahun Angkatan</th>
    		                    <th colspan="4" class="text-center">Absensi</th>
    		                </tr> 
    		                <tr>
    		                    <th class="text-center">H</th>
    		                    <th class="text-center">S</th>
    		                    <th class="text-center">I</th>
    		                    <th class="text-center">A</th>
    		                </tr>
    		                <?php } ?>
    	                </thead>
    	                <tbody>
    	                  
    	                </tbody>
                    </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="jurnal_pengajaran">
                    <div class="mailbox-controls">
                        <!--
                        <a role="button" class="btn btn-success btn-sm show_modal" href="<?=base_url("akademik/$controller/tambahJurnal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']?>" tabel="jurnal" judul_modal="Tambah Jurnal Perkuliahan" >
                            Tambah Jurnal Perkuliahan
                        </a>
                        -->
                    </div>
                    <div class="table-responsive">
                        <table id="data_jurnal" class="table table-bordered table-hover">
        	                <thead>
        		                <tr>
        		                    <th class="text-center">No</th>
        		                    <th class="text-center">Tanggal</th>
        		                    <th class="text-center">Topik</th>
        		                    <th class="text-center">Metode</th>
        		                    <th class="text-center">Sudah Direkap?</th>
        		                </tr>
        	                </thead>
        	                <tbody>
        	                  
        	                </tbody>
                        </table>
                    </div>
                    
                    <div class="callout callout-info mt-3">
                        <h5>Note!</h5>
                        <ol>
                            <li>Jurnal perkuliahan hanya bisa diinput sekali dalam sehari.</li>
                            <li>Jurnal perkuliahan hanya bisa diinput sesuai dengan jadwal perkuliahan.</li>
                        </ol>
                    </div>
                        
              </div>
              <!-- /.tab-pane -->
              
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
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
    $('[data-mask]').inputmask();
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
        $(this).find('#username').attr('readonly', false);
    });
})

function reload_table(){
    table.ajax.reload(null, false);
}

function getDataMhs(){
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
    if(prodi == '' || kelas == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih prodi dan kelas!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{
        $('#data_mhs').DataTable({
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
                "url": "<?php echo site_url("akademik/$controller/ajaxListMhsKelas") ?>",
                "type": "POST",
                "data": function(data) {
                    data.prodi = $('#prodi').val();
                    data.kelas = $('#kelas').val();
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
    
        $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                            
        var active_class = 'active';
        $('#data_mhs > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            
            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
            });
        });
    }
        
}

function cetakAbsensiKosong(){
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
    var kd_kelas_perkuliahan = "<?=$perkuliahan['kd_kelas_perkuliahan']?>";
    var link_cetak_absen_kosong = "<?=site_url("akademik/$controller/cetakAbsensiKosong?prodi=")?>"+prodi+"&kelas="+kelas+"&kd_kelas_perkuliahan="+kd_kelas_perkuliahan
    if(prodi == '' || kelas == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih prodi dan kelas!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{
        Swal.fire({
            title: 'Anda yakin akan mencetak Absensi Kosong ??',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/cekMahasiswaKelas");?>",
                    type: "post",
                    data: {
                        prodi: prodi,
                        kelas:kelas,
                        kd_kelas_perkuliahan:kd_kelas_perkuliahan
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
                            halaman = window.open(link_cetak_absen_kosong, "",
                                "width=800,height=600,status=1,scrollbar=yes");
                            return false;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Data tidak ditemukan'
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
        
}

function getJurnalKuliah(){
    $('#data_jurnal').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
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
                "url": "<?php echo site_url("akademik/$controller/listJurnalPerkuliahan") ?>",
                "type": "POST",
                "data": function(data) {
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
}

function changeRekapJurnal(id_jurnal_kuliah) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status rekap jurnal?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/changeRekapJurnal");?>",
                type: "post",
                data: "aksi=changeRekapJurnal&id_jurnal_kuliah=" + id_jurnal_kuliah,
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
                        getJurnalKuliah();
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
        if(b.reload_table===true && b.tabel === 'jurnal'){
            getJurnalKuliah();
        }
        
        if(b.reload_table===true && b.tabel === 'dokumen'){
            getDokumen();
        }
        
        if(b.reload_table===true && b.tabel === 'soal'){
            getSoal("<?=$perkuliahan['kd_kelas_perkuliahan']?>");
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
      tabel:tabel,
      scrollable:false
    });
    return false;        
  });    
});

</script>
<?=$this->endSection();?>