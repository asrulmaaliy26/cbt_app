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
            				<th class="text-center align-middle" colspan="3">Lembar Kerja</th>
            				<th class="text-center" colspan="7">Penilaian</th>
            				
            			</tr>
            			<tr>
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
                    "url": "<?php echo site_url("akademik/$controller/listInputNilai") ?>",
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


function reload_table(){
    table.ajax.reload(null, false);
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
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai UTS: <pre><code>' +
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
					text: "Maaf..., Nilai UTS "+nama+" Tidak tersimpan karena data LJK tidak ada.",
					icon: "error",
				});
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
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
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
					text: "Maaf..., Nilai Tugas "+nama+" Tidak tersimpan karena data LJK tidak ada.",
					icon: "error",
				});
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
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
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
					text: "Maaf..., Nilai Tugas "+nama+" Tidak tersimpan karena data LJK tidak ada.",
					icon: "error",
				});
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
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
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
					text: "Maaf..., Nilai Tugas "+nama+" Tidak tersimpan karena data LJK tidak ada.",
					icon: "error",
				});
        }
		})

	}
	
function showLjk(jns_ujian, id_ljk)
{
    var link = "<?=base_url("akademik/$controller/showLjk?jns_ujian=")?>"+jns_ujian+"&id_ljk="+id_ljk;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Lembar Jawaban',
      message: iframe,
      closeButton:true,
      scrollable:false
    });
    return false;
}

</script>


<?=$this->endSection();?>