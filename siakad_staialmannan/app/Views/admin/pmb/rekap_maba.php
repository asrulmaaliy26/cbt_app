<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
  <div class="container-fluid">
  	<div class="card card-primary card-outline">
      <div class="card-body">
        <div class="col-md-3">
        	<div class="form-group">
                <label>Tahun Pendaftaran</label>
                <?php
                    $tahunPmbAktif = substr(getDataRow('setting_gelombang', ['Aktif' => '1'])['Tahun_Akademik'],0,4);
                    echo cmb_dinamis('th_masuk', 'db_pmb', 'Tahun_Masuk', 'Tahun_Masuk', $tahunPmbAktif, null, 'id="th_masuk" onchange="loadRekap()" style="width: 100%;"', 'Tahun_Masuk', 'Tahun_Masuk DESC');
                ?>
            </div>
        </div>
      </div>
    </div>
    <div id="konten">
    	
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
  	loadRekap();
    $('.select2').select2({
      placeholder: "---- Semua ----",
      allowClear: true
    });
    $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
    });
    $('[data-mask]').inputmask();

  })

  function loadRekap(){
  	var tahun = $("#th_masuk option:selected").val();
  	$.ajax({
		url:"<?php echo site_url("pmb/getRekap");?>",
		data:{tahun:tahun},
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
	            $('#konten').attr('hidden',false);
	            Swal.close();
	            $("#konten").html(html);
		}
	});
  }

</script>
<?=$this->endSection();?>