<!doctype html>
<html lang="en">
  <head>
  	<title>SIM STAI AL-MANNAN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Manajemen STAI Al-Mannan Tulungagung">
    <meta name="keyword" content="STAI Al-Mannan, SIAKAD, Siakad STAI Al-Mannan">
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="SIM STAI AL-MANNAN" />
    <meta property="og:title" content="SIM STAI AL-MANNAN" />
    <meta property="og:description" content="Sistem Informasi Manajemen STAI Al-Mannan Tulungagung" />
    <meta property="og:url" content="<?=base_url()?>" />
    <meta property="og:image" content="<?=base_url('assets/logo.png');?>" />
    
    <meta itemprop="name" content="SIM STAI AL-MANNAN">
    <meta itemprop="description" content="Sistem Informasi Manajemen STAI Al-Mannan Tulungagung">
    <meta itemprop="image" content="<?=base_url('assets/logo.png');?>">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="manifest" href="<?=base_url('manifest.json');?>">

	<link rel="stylesheet" href="<?=base_url('front');?>/css/style.css">
	<link rel="shortcut icon" href="<?=base_url('assets/favicon.png');?>" type="image/x-icon">
	
	<style>
	    .install-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: bold;
            display: none;
            z-index: 1000;
        }
	</style>

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
		    <!--
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Login #04</h2>
				</div>
			</div>
			-->
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img " style="background-image: url(<?=base_url()?>/assets/logo.png); background-position: center center; background-size: contain; margin: 50px auto; position: relative;"></div>
						<div class="login-wrap p-4 p-md-5">
						    <!--
			      	        <div class="d-flex">
        			      		<div class="w-100">
        			      			<h3 class="mb-4">Sign In</h3>
        			      		</div>
			      	        </div>
			      	        -->
        			      	<?php
                    			$session = \Config\Services::session();
                    			if($session->getFlashdata('warning')){
                                    //dd($session->getFlashdata('warning'));
                    		?>
                    		<div class="alert alert-danger">
                    			<ul>
                    				<?php
                    					foreach($session->getFlashdata('warning') as $val){
                    				?>
                    					<li><?=$val;?></li>
                    				<?php	} ?>
                    			</ul>
                    		</div>
                    		<?php	} ?>
                    		
				            <form method="post" action="login" class="signin-form">
        			      		<div class="form-group mb-3">
        			      			<label class="label" for="name">Username / Email</label>
        			      			<input type="text" class="form-control" placeholder="Username / Email" required value="<?php if($session->getFlashdata('username')) echo $session->getFlashdata('username')?>" name="username">
        			      		</div>
            		            <div class="form-group mb-3">
            		            	<label class="label" for="password">Password</label>
            		                <input type="password" class="form-control" placeholder="Password" id="password_hash" name="password_hash">
            		            </div>
            		            <div class="form-group d-md-flex">
            		            	<div class="w-50 text-left">
            			            	<label class="checkbox-wrap checkbox-primary mb-0">Show Password
            									  <input type="checkbox" onclick="showPassword()">
            									  <span class="checkmark"></span>
            							</label>
									</div>
            		            </div>
            		            <div class="form-group">
            		            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
            		            </div>
            		            <div class="form-group d-md-flex">
            		            	<div class="w-50 text-left">
            			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
            									  <input type="checkbox" id="remember" value="1" name="remember_me">
            									  <span class="checkmark"></span>
            							</label>
									</div>
									<!--
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
									-->
            		            </div>
		                    </form>
            		          <!--<p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>-->
		                </div>
		            </div>
				</div>
			</div>
			<button id="installBtn" class="install-button">
              <i class="fa fa-download"></i> Install App
            </button>
		</div>
	</section>

	<script src="<?=base_url('front');?>/js/jquery.min.js"></script>
  <script src="<?=base_url('front');?>/js/popper.js"></script>
  <script src="<?=base_url('front');?>/js/bootstrap.min.js"></script>
  <script src="<?=base_url('front');?>/js/main.js"></script>
  <script>
      function showPassword() {
          var x = document.getElementById("password_hash");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
  </script>
  
  <script>
      document.addEventListener('DOMContentLoaded', () => {
        
        if ('serviceWorker' in navigator) {
          navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('ServiceWorker registered:', reg.scope))
            .catch(err => console.error('ServiceWorker failed:', err));
        }

        let deferredPrompt = null;
        const installBtn = document.getElementById('installBtn');

        window.addEventListener('beforeinstallprompt', (e) => {
          e.preventDefault();
          deferredPrompt = e;
          installBtn.style.display = 'inline-flex';
        });

        installBtn.addEventListener('click', async () => {
          if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log('User choice:', outcome);
            deferredPrompt = null;
            installBtn.style.display = 'none';
          }
        });
      });
    </script>

	</body>
</html>

