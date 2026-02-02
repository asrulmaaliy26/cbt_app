<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<!-- Main content -->
<section class="content">
<?php if(empty(session()->get('akun_level'))){ ?>
 	<div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            
            <div class="col-md-12 text-center d-flex align-items-center justify-content-center ">
	            <?php
		            $groupUser = getUserGroup(session()->get('akun_id'))->getResultArray();
		            foreach ($groupUser as $row) {
		        ?>
	            <div class="p-2">
	              	<div class="card bg-light d-flex flex-fill">
		                <div class="card-body pt-0">
		                  <div class="row">
		                    
		                    <div class="col-md-12 text-center">
		                      <img src="<?=base_url('assets');?>/dist/img/avatar4.png" alt="user-avatar" class="img-circle img-fluid">
		                    </div>
		                  </div>
		                </div>
		                <div class="card-footer">
		                  <div class="text-center">
		                    <a href="javascript:void(0)" onclick="selectRole('<?=$row['group_id'];?>')" class="btn btn-block btn-primary">
		                      <i class="fas fa-user"></i> <?=$row['name'];?>
		                    </a>
		                  </div>
		                </div>
		            </div>
	            </div>
          		<?php }?>
	        </div>
            
          </div>
        </div>
        <!-- /.card-body -->
    </div>
    <script type="text/javascript">
		function selectRole(groupId) {

		  var role = groupId;
		  $.ajax({
		      url: "<?php echo site_url("dashboard");?>",
		      type: "post",
		      data: "role="+role,
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
		              Swal.fire({
		                icon: 'success',
		                title: data.pesan,
		                allowOutsideClick: false,
		            }).then(() => {
		                location.reload();
		            })

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
		                  icon: data.msg,
		                  title: data.pesan
		              })
		          }
		      },
		      error: function(xhr, ajaxOptions, thrownError) {
		        Swal.close();
		          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		      }
		  });
		}
	</script>
<?php } ?>

</section>
<!-- /.content -->

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>




<?=$this->endSection();?>