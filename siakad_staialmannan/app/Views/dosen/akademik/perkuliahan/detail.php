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
              <li class="nav-item"><a class="nav-link active" href="#absensi" onclick="getDataMhs()" data-toggle="tab">Absensi</a></li>
              <li class="nav-item"><a class="nav-link" href="#jurnal_pengajaran" onclick="getJurnalKuliah('<?=$perkuliahan['kd_kelas_perkuliahan']?>')" data-toggle="tab">Jurnal Pengajaran</a></li>
              <li class="nav-item"><a class="nav-link" href="#dokumen_pengajaran" onclick="getDokumen('<?=$perkuliahan['kd_kelas_perkuliahan']?>')" data-toggle="tab">Dokumen Perkuliahan</a></li>
              <li class="nav-item"><a class="nav-link" href="#ujian" onclick="getSoal('<?=$perkuliahan['kd_kelas_perkuliahan']?>')" data-toggle="tab">Ujian</a></li>
              <li class="nav-item"><a class="nav-link" href="#penilaian" onclick="getDataNilai('<?=$perkuliahan['kd_kelas_perkuliahan']?>')" data-toggle="tab">Penilaian</a></li>
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
                                                    <select name="prodi" id="prodi" class="form-control select2" onchange="getDataMhs()" style="width: 100%;">
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
                                                    <select name="kelas" id="kelas" class="form-control select2" onchange="getDataMhs()" style="width: 100%;">
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
                            
                            <a role="button" class="btn btn-success btn-sm show_modal" href="<?=base_url("akademik/$controller/absensiMhs?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']?>" tabel="absensi_mahasiswa" judul_modal="Absensi Perkuliahan Mahasiswa" >
                                Absensi
                            </a>
                            
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
    		                    <th rowspan="2" class="text-center align-middle">Prodi</th>
    		                    <th rowspan="2" class="text-center align-middle">Kelas</th>
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
                        <a role="button" class="btn btn-success btn-sm show_modal" href="<?=base_url("akademik/$controller/tambahJurnal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']?>" tabel="jurnal" judul_modal="Tambah Jurnal Perkuliahan" >
                            Tambah Jurnal Perkuliahan
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="data_jurnal" class="table table-bordered table-hover">
        	                <thead>
        		                <tr>
        		                    <th class="text-center">No</th>
        		                    <th class="text-center">Tanggal</th>
        		                    <th class="text-center">Topik</th>
        		                    <th class="text-center">Metode</th>
                                    <th class="text-center">Catatan</th>
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
              
              <div class="tab-pane" id="dokumen_pengajaran">
                    <div class="mailbox-controls">
                        <a role="button" class="btn btn-success btn-sm show_modal" href="<?=base_url("akademik/$controller/tambahDokumen?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']?>" tabel="dokumen" judul_modal="Upload Dokumen Perkuliahan" >
                            Upload File
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="data_dokumen" class="table table-bordered table-hover">
        	                <thead>
        		                <tr>
        		                    <th class="text-center">No</th>
        		                    <th class="text-center">Nama File</th>
        		                    <th class="text-center">Deskripsi</th>
        		                    <th class="text-center"></th>
        		                </tr>
        	                </thead>
        	                <tbody>
        	                  
        	                </tbody>
                        </table>
                    </div>
                    
                    <div class="callout callout-info mt-3">
                        <h5>Note!</h5>
                        <p>Upload RPS, Modul/Materi Perkuliahan, Artikel/Makalah Mahasiswa disini.</p>
                    </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="ujian">
                    <div class="mailbox-controls">
                        <a role="button" class="btn btn-success btn-sm show_modal" href="<?=base_url("akademik/$controller/tambahSoal?kd_kelas_perkuliahan=").$perkuliahan['kd_kelas_perkuliahan']?>" tabel="soal" judul_modal="Upload Soal Ujian" >
                            Buat Soal / Tugas Akhir Mata Kuliah
                        </a>
                    </div>
                    
                        <div id="body_card_soal">
                            
                        </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="penilaian">
                    <div class="mailbox-controls">
                        <div class="card">
                            <div class="card-body">
                                    <form action="" method="get">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Program Studi</label>
                                                        <select name="prodi_nilai" id="prodi_nilai" class="form-control select2" onchange="getDataNilai()" style="width: 100%;">
                                                            <option></option>
                                                            
                                                            <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null, null, 'Prodi'); 
                                                                
                                                                foreach ($prodi as $key ) {
                                                            ?>
                                                            <option value="<?=$key->Prodi?>" ><?=$key->Prodi?></option>
                                                            <?php    }    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            	<div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Kelas</label>
                                                        <select name="kelas_nilai" id="kelas_nilai" class="form-control select2" onchange="getDataNilai()" style="width: 100%;">
                                                            <option></option>
                                                            
                                                            <?php $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null, null, 'Kelas'); 
                                                                
                                                                foreach ($kelas as $key ) {
                                                            ?>
                                                            <option value="<?=$key->Kelas?>" ><?=$key->Kelas?></option>
                                                            <?php    }    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Nilai Ujian</label>
                                                        <select name="ujian_nilai" id="ujian_nilai" class="form-control select2"  style="width: 100%;">
                                                            <option></option>
                                                            <option value="UTS">UTS</option>
                                                            <option value="UAS">UAS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                
                            </div>
                            <div class="card-footer">
                                
                                <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Download nilai prodi" onclick="cetakNilaiProdi()">
                                    Download Nilai Prodi
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-placement="top" title="Sinkronkan Nilai" onclick="getDataNilai()">
                                    Sinkronkan Nilai
                                </button>
                                
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="data_nilai" class="table table-bordered table-hover table-sm">
        	                <thead>
        		                <tr>
        		                    <th class="text-center align-middle" rowspan="2">No</th>
        		                    <th class="text-center align-middle" rowspan="2">Nama</th>
        		                    <th class="text-center align-middle" rowspan="2">Prodi</th>
        		                    <th class="text-center" colspan="4">Rekap Absen</th>
        		                    <th class="text-center align-middle" rowspan="2">Cekal UAS?</th>
        		                    <th class="text-center" colspan="3">Lembar Kerja</th>
        		                    <th class="text-center" colspan="7">Penilaian</th>
        		                </tr>
        		                <tr>
        		                    <th class="text-center">H</th>
        		                    <th class="text-center">S</th>
        		                    <th class="text-center">I</th>
        		                    <th class="text-center">A</th>
        		                    <th class=text-center>UTS</th>
        		                    <th class=text-center>UAS</th>
        		                    <th class=text-center>Tugas</th>
        		                    <th class=text-center>UTS</th>
        		                    <th class=text-center>TGS</th>
        		                    <th class=text-center>UAS</th>
        		                    <th class=text-center>P</th>
        		                    <th class=text-center>N. Akhir</th>
        		                    <th class=text-center>Huruf</th>
        		                    <th class=text-center>Status</th>
        		                </tr>
        	                </thead>
        	                <tbody>
        	                  
        	                </tbody>
                        </table>
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
    getDataMhs();
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
    /*
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
    if(prodi == '' || kelas == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih prodi dan kelas!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{*/
        $('#data_mhs').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    			$('td', row).eq(9).addClass('text-center');
    			$('td', row).eq(10).addClass('text-center');
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
    //}
        
}

function pilihKosma(kd_kelas_perkuliahan) {
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Menjadikan Kosma??",
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
    				data: {id_his_pdk:list, kd_kelas_perkuliahan:kd_kelas_perkuliahan, prodi:prodi, kelas:kelas},
    			    url:"<?php echo site_url("akademik/$controller/pilihKosma")?>",
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
                            getDataMhs();
                        });
    				    
    				},
    				
    				error: function (xhr, ajaxOptions, thrownError) {
    					Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: "Ooppss!! Something Wrong",
                            text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
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
			text: "Pilih mahasiswa yang akan dijadikan kosma!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function hapusKosma(id) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Menghapus Kosma??",
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
                url: "<?php echo site_url("akademik/$controller/hapusKosma");?>",
                type: "post",
                data: "id=" + id,
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
                        getDataMhs();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: "Ooppss!! Something Wrong",
                        text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
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
                        Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: "Ooppss!! Something Wrong",
                            text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                });
            }
        })   
    }
        
}

function cetakNilaiProdi(){
    var prodi = $('#prodi_nilai option:selected').val();
    var kelas = $('#kelas_nilai option:selected').val();
    var ujian = $('#ujian_nilai option:selected').val();
    var kd_kelas_perkuliahan = "<?=$perkuliahan['kd_kelas_perkuliahan']?>";
    var link_cetak_nilai = "<?=site_url("akademik/$controller/cetakNilai?prodi=")?>"+prodi+"&kelas="+kelas+"&kd_kelas_perkuliahan="+kd_kelas_perkuliahan+"&ujian="+ujian
    if(prodi == '' || kelas == '' || ujian == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih prodi, kelas dan ujian!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{
        Swal.fire({
            title: 'Anda yakin akan mencetak Nilai Prodi '+prodi+' Kelas '+kelas+'??',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/cekNilaiKelas");?>",
                    type: "post",
                    data: {
                        prodi: prodi,
                        kelas:kelas,
                        ujian:ujian,
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
                            halaman = window.open(link_cetak_nilai, "",
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
                        Swal.close();
                    	Swal.fire({
                            icon: 'error',
                            title: "Ooppss!! Something Wrong",
                            text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
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

function getDataNilai(){
    $('#data_nilai').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    			$('td', row).eq(9).addClass('text-center');
    			$('td', row).eq(10).addClass('text-center');
    			$('td', row).eq(15).addClass('text-center');
    			$('td', row).eq(16).addClass('text-center');
    			$('td', row).eq(17).addClass('text-center');
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
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/listNilai") ?>",
                "type": "POST",
                "data": function(data) {
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                    data.prodi = $('#prodi_nilai option:selected').val();
                    data.kelas = $('#kelas_nilai option:selected').val();
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
                }, 
            ],
        });
}

function simpan_uts(id,nama) {
	var uts = $("#uts"+id).val();
	$.ajax({
		url: "<?php echo site_url("akademik/$controller/simpan_uts")?>",
        data: "id="+id+"&nilai_uts="+uts+"&nama="+nama,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
                    icon: data.msg,
                    title: data.pesan
                })
            }else{
                if(data.msg == 'warning'){
                    const myObj = JSON.parse(JSON.stringify(data.validation));
                    let pesan = "";
                    for (const x in myObj) {
                      pesan += myObj[x] ;
                    }
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai UTS: <br>' +
								          pesan,
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError)
        {
            
        	Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something Wrong",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
	})

}

function simpan_tugas(id,nama) {
		var nilai = $("#tugas"+id).val();
		$.ajax({
			url: "<?php echo site_url("akademik/$controller/simpan_tugas")?>",
            data: "id="+id+"&nilai="+nilai+"&nama="+nama,
            type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
                    icon: data.msg,
                    title: data.pesan
                })
            }else{
                if(data.msg == 'warning'){
                    const myObj = JSON.parse(JSON.stringify(data.validation));
                    let pesan = "";
                    for (const x in myObj) {
                      pesan += myObj[x] ;
                    }
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <br>' +
								          pesan,
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError)
        {
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something Wrong",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
		})

	}
	
function simpan_uas(id,nama) {
		var nilai = $("#uas"+id).val();
		$.ajax({
			url: "<?php echo site_url("akademik/$controller/simpan_uas")?>",
            data: "id="+id+"&nilai="+nilai+"&nama="+nama,
            type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
                    icon: data.msg,
                    title: data.pesan
                })
            }else{
                if(data.msg == 'warning'){
                    const myObj = JSON.parse(JSON.stringify(data.validation));
                    let pesan = "";
                    for (const x in myObj) {
                      pesan += myObj[x] ;
                    }
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <br>' +pesan,
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError)
        {
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something Wrong",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
		})

	}

function simpan_p(id,nama) {
		var nilai = $("#p"+id).val();
		$.ajax({
			url: "<?php echo site_url("akademik/$controller/simpan_p")?>",
            data: "id="+id+"&nilai="+nilai+"&nama="+nama,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                if(data.status){
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
                        icon: data.msg,
                        title: data.pesan
                    })
                }else{
                    if(data.msg == 'warning'){
                        const myObj = JSON.parse(JSON.stringify(data.validation));
                        let pesan = "";
                        for (const x in myObj) {
                          pesan += myObj[x] ;
                        }
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            html : 'Gagal menyimpan nilai Tugas: <br>' +pesan,
                            allowOutsideClick: false,
                        })
                    }else{
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        })
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                Swal.fire({
                    icon: 'error',
                    title: "Ooppss!! Something Wrong",
                    text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                })
            }
		})

	}
	
function lolos(id, nama, field) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Meloloskan UAS "+nama+"!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/ubahCekalan");?>",
                type: "post",
                data: "aksi=lolos&id=" + id+"&field="+field,
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
                            title: nama+' diijinkan mengikuti UAS.',
                            allowOutsideClick: false,
                        }).then(() => {
                            getDataNilai();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: nama+' gagal diijinkan mengikuti UAS.',
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

function cekal(id, nama, field) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Mencekal "+ nama +" ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/ubahCekalan");?>",
                type: "post",
                data: "aksi=cekal&id=" + id +"&field="+field,
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
                            title: nama+ ' telah dicekal',
                            allowOutsideClick: false,
                        }).then(() => {
                            getDataNilai();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: nama+' gagal dicekal',
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

	
function showLjk(jns_ujian, id_ljk)
{
    var link = "<?=base_url("akademik/$controller/showLjk?jns_ujian=")?>"+jns_ujian+"&id_ljk="+id_ljk;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.buatModal({
      title:'Lembar Jawaban',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
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
      scrollable:false
    });
    return false;
}

function getDokumen(){
    $('#data_dokumen').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
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
                "url": "<?php echo site_url("akademik/$controller/listDokumenPerkuliahan") ?>",
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

function hapus_file(id_file) {
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
                url: "<?php echo site_url("akademik/$controller/tambahDokumen");?>",
                type: "post",
                data: "aksi=hapus&id=" + id_file,
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
                            getDokumen();
                        });

                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: "Ooppss!! Something Wrong",
                        text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function getSoal(kd_kelas_perkuliahan){
    $.ajax({
		url:"<?php echo site_url("akademik/$controller/listSoal");?>",
		data:{kd_kelas_perkuliahan:kd_kelas_perkuliahan},
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
	            
	            Swal.close();
	            $("#body_card_soal").html(html);
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
        
        if(b.reload_table===true && b.tabel === 'absensi_mahasiswa'){
            getDataMhs();
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