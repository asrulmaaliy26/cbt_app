<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <?php if(isset($id)){?>
            <div class="card card-primary card-outline">
                <div class="card-body">
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:25%">Mata Kuliah</th>
                                    <td>: <?=$Mata_Kuliah?></td>
                                  </tr>
                                  <tr>
                                    <th >Nama Dosen</th>
                                    <td>: <?=(!empty($Kd_Dosen))?getDataRow('data_dosen', ['Kode'=>$Kd_Dosen])['Nama_Dosen']:''?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th >Kode Kelas</th>
                                    <td>: <?=$kode_kelas?></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:25%">Th. Akademik</th>
                                    <td>: <?=getDataRow('tahun_akademik',['kode' => $Kd_Tahun])['tahunAkademik']?> <?=getDataRow('tahun_akademik',['kode' => $Kd_Tahun])['semester'] == '1'?'Gasal':'Genap'?></td>
                                  </tr>
                                  <tr>
                                    <th >Prodi</th>
                                    <td>: <?=$Prodi?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Kelas - SMT</th>
                                    <td>: <?=($Kelas == 'PA')?'Putera':(($Kelas == 'PI')?'Puteri':$Kelas) ?> - <?=$SMT?>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card card-primary card-outline">
                <div class="card-body table-responsive p-0">
                    <table id="data" class="table table-striped table-bordered table-hover">
                		<thead>
                			<tr>
                				<th class="text-center align-middle" rowspan="2"><input type="checkbox" ></th>
                				<th class="text-center align-middle" rowspan="2">No.</th>
                				<th class="text-center align-middle" rowspan="2">Nama MHS</th>
                				<th class="text-center align-middle" rowspan="2">NIM</th>
                				<th class="text-center align-middle" colspan="2">Nilai Dosen</th>
                				<th class="text-center align-middle" colspan="2">Nilai Kaprodi</th>
                				
                			</tr>
                			<tr>
                			    <th class="text-center align-middle">N. Akhir</th>
                				<th class="text-center align-middle">H</th>
                				<th class="text-center align-middle">AM</th>
                				<th class="text-center align-middle">H</th>
                			</tr>
                		</thead>
                		<tbody>
                			
                			
                		</tbody>
                
                	</table>
                </div>
            </div>
        <?php }else{ ?>
            <div class="card card-primary card-outline">
                <div class="card-body">
                        <form action="" method="get">
                            <!--<div class="col-md-10 offset-md-1">-->
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <select name="tahun_akademik" id="tahun_akademik" class="form-control select2" onchange="reload_table()" style="width: 100%;">
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
                                            <label>Prodi</label>
                                            <?php
                                                if(session()->get('akun_level') == 'Fakultas'){
                                                    $fakultas = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                                                    echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" style="width: 100%;" onchange="reload_table()"', null, null, ['sing_fak' => $fakultas]);
                                                }
                                                
                                                if(session()->get('akun_level') == 'Kaprodi'){
                                                    $prodi = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                                                    echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', $prodi, null, 'id="prodi" style="width: 100%;" onchange="reload_table()"', null, null, ['singkatan' => $prodi]);
                                                }
                                                
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <?php
                                                echo cmb_dinamis('kelas', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="kelas"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'program_kelas', 'is_aktif !=' => 'N']);
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                    	<div class="form-group">
                                            <label>Semester</label>
        		                            <select name="semester" id="semester" class="form-control select2"  onchange="reload_table()" style="width: 100%;">
                                                    <option></option>
                                                    <option value="1"> 1 </option>
                        							<option value="2"> 2 </option>
                        							<option value="3"> 3 </option>
                        							<option value="4"> 4 </option>
                        							<option value="5"> 5 </option>
                        							<option value="6"> 6 </option>
                        							<option value="7"> 7 </option>
                        							<option value="8"> 8 </option>
                        							<option value="9"> 9 </option>
                        							<option value="10"> 10 </option>
                        							<option value="11"> 11 </option>
                        							<option value="12"> 12 </option>
                        							<option value="13"> 13 </option>
                        							<option value="14"> 14 </option>
                        					</select>
        		                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                            <!--</div>-->
                        </form>
                    
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
                        <table id="data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" ></th>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode Feeder</th>
                                    <th class="text-center">Mata Kuliah</th>
                                    <th class="text-center">Prodi</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">SMT</th>
                                    <th class="text-center">Dosen</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
        
                            </tbody>
        
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
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
var table;
$(function() {
    ganti_semester();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#tahun_akademik').on('select2:select', function (e) {
        ganti_semester();
    });
    
})

function ganti_semester()
{
    let periode = $('#tahun_akademik option:selected').val();
    if(periode %2 != 0){
	    
        $("#semester option[value='']").prop('disabled',false);
        $("#semester option[value='1']").prop('disabled',false);
        $("#semester option[value='2']").prop('disabled',true);
        $("#semester option[value='3']").prop('disabled',false);
        $("#semester option[value='4']").prop('disabled',true);
        $("#semester option[value='5']").prop('disabled',false);
        $("#semester option[value='6']").prop('disabled',true);
        $("#semester option[value='7']").prop('disabled',false);
        $("#semester option[value='8']").prop('disabled',true);
        $("#semester option[value='9']").prop('disabled',false);
        $("#semester option[value='10']").prop('disabled',true);
        $("#semester option[value='11']").prop('disabled',false);
        $("#semester option[value='12']").prop('disabled',true);
        $("#semester option[value='13']").prop('disabled',false);
        $("#semester option[value='14']").prop('disabled',true);
	}else{
	    $("#semester option[value='']").prop('disabled',false);
        $("#semester option[value='1']").prop('disabled',true);
        $("#semester option[value='2']").prop('disabled',false);
        $("#semester option[value='3']").prop('disabled',true);
        $("#semester option[value='4']").prop('disabled',false);
        $("#semester option[value='5']").prop('disabled',true);
        $("#semester option[value='6']").prop('disabled',false);
        $("#semester option[value='7']").prop('disabled',true);
        $("#semester option[value='8']").prop('disabled',false);
        $("#semester option[value='9']").prop('disabled',true);
        $("#semester option[value='10']").prop('disabled',false);
        $("#semester option[value='11']").prop('disabled',true);
        $("#semester option[value='12']").prop('disabled',false);
        $("#semester option[value='13']").prop('disabled',true);
        $("#semester option[value='14']").prop('disabled',false);
	}
}

function reload_table(){
    table.ajax.reload(null, false);
}

function simpan_nilai(id,nama) {
	var nilai = $("#na"+id).val();
	$.ajax({
		url: "<?php echo site_url("akademik/$controller/simpan_nilai_kaprodi")?>",
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
                Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
                    html : 'Gagal menyimpan nilai : <pre><code>' +
							          JSON.stringify(data.validation)+
							        '</code></pre>',
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
    error: function (jqXHR, textStatus, errorThrown)
    {
        //reload_table();
        Swal.fire({
				title: "Ooopsss....!",
				text: "Maaf..., Nilai "+nama+" Tidak tersimpan karena data LJK tidak ada.",
				icon: "error",
			});
    }
	})

}
</script>

<?php if(isset($id)){?>
    <script>
        $(function() {
            table = $('#data').DataTable({
                "createdRow": function (row, data, index) {
        			$('td', row).eq(0).addClass('text-center');
        			$('td', row).eq(1).addClass('text-center');
        			$('td', row).eq(4).addClass('text-center');
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
                    "url": "<?php echo site_url("akademik/$controller/ajaxListDetailNilai") ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.id_mk = "<?=$id?>";
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
    </script>
<?php }else{ ?>
    <script>
        $(function() {
            table = $('#data').DataTable({
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
                        data.tahun_akademik = $('#tahun_akademik').val();
                        data.prodi = $('#prodi').val();
                        data.semester = $('#semester').val();
                        data.kelas = $('#kelas').val();
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
    </script>
<?php } ?>

<?=$this->endSection();?>