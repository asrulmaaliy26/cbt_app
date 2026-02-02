<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<section class="content">
    <div class="card">

		<div class="card-header">
		    <i class="fas fa-table me-1"></i>
		    <?=$templateJudul?>
		</div>
		<div class="card-body">
			<?php
				$session = \Config\Services::session();
				if($session->getFlashdata('warning')){
			?>
			<div class="alert alert-warning">
				<ul>
					<?php
						foreach($session->getFlashdata('warning') as $val)
						{
					?>
						<li><?=$val;?></li>
					<?php		
						} 
					?>
				</ul>
			</div>
			<?php		
				} 
				if ($session->getFlashdata('success')) {
			?>
			<div class="alert alert-success"><?php echo $session->getFlashdata('success')?></div>
			<?php
				}
			?>
			<form action="" method="post" enctype="multipart/form-data">
				<!--
			    <div class="mb-3">
				  <label for="input_nama_lengkap" class="form-label">Nama Lengkap</label>
				  <input type="text" class="form-control" id="input_nama_lengkap" placeholder="Nama Lengkap" name="nama_lengkap" value="<?php echo (isset($nama_lengkap))?$nama_lengkap:""?>"> 
				</div>
				-->
				<div class="mb-3">
				  <label for="input_username" class="form-label">Username</label>
				  <input type="text" class="form-control" id="input_username" placeholder="Username" name="username" disabled value="<?php echo (isset($username))?$username:""?>"> 
				</div>
				<div class="mb-3">
				  <label for="input_email" class="form-label">Email</label>
				  <input type="text" class="form-control" id="input_email" placeholder="Email aktif" name="email" value="<?php echo (isset($email))?$email:""?>"> 
				</div>
				
				<div class="mb-3 col-lg-6">
					<h4>Ganti Password</h4>
				</div>

				<div class="mb-3">
				  <label for="input_password_lama" class="form-label">Password Lama</label>
				  <input type="password" class="form-control" id="input_password_lama" placeholder="Password Lama" name="password_lama" > 
				</div>

				<div class="mb-3">
				  <label for="input_password_baru" class="form-label">Password Baru</label>
				  <input type="password" class="form-control" id="input_password_baru" placeholder="Password Baru" name="password_baru" > 
				</div>

				<div class="mb-3">
				  <label for="input_password_baru_konfirmasi" class="form-label">Konfirmasi Password Baru</label>
				  <input type="password" class="form-control" id="input_password_baru_konfirmasi" placeholder="Password Baru Konfirmasi" name="password_baru_konfirmasi" > 
				</div>

				<div>
					<input type="submit" class="btn btn-primary" name="submit" value="Simpan">
				</div>
				
			</form>
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



<?=$this->endSection();?>
