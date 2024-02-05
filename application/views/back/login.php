<!DOCTYPE html>
<html lang="it" dir="ltr">
 <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <title><?=$title?> - <?=$this->system->company_name?></title>
  <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico" type="image/x-icon" />
  <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/gestionale.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/dark.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/skins.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/animated.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/p-scrollbar.css" rel="stylesheet" />
 </head>
 <body class="h-100vh page-style1">
  
  <div id="global-loader"><img src="<?=base_url()?>assets/images/loader.svg" alt="loader" /></div>
  <div class="page">
   <div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9 d-block mx-auto">
                <div class="row">
                    <div class="col-md-5 p-md-0">
                        <?=form_open(site_url(config_item('admin_url').'/login/dologin'), 'id="login-form" name="login-form"'); ?>
                        <div class="card br-0 mb-0">
                            <div class="card-body page-single-content">
                                <div class="w-100">
                                    <div class="custom-logo">
                                        <a href="index.html"><img src="<?=base_url()?>assets/images/favicon.png" class="header-brand-img dark-logo" alt="logo" /></a>
                                    </div>
                                    <div class=""><h2>Admin Login</h2></div>
                                    <?php if($this->session->flashdata('success_notification')): ?>
                                       <div class="alert alert-success" role="alert">
                                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                         <?=$this->session->flashdata('success_notification')?>
                                       </div>
                                     <?php elseif($this->session->flashdata('error_notification')): ?>
                                       <div class="alert alert-danger" role="alert">
                                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                         <?=$this->session->flashdata('error_notification')?>
                                       </div>
                                     <?php endif; ?>
                                    <div class="input-group mb-4"><input type="text" class="form-control" placeholder="Username" id="user_name" name="user_name" required /></div>
                                    <div class="input-group mb-4"><input type="password" class="form-control" placeholder="Password" id="password" name="password" required /></div>
									<div class="row">
										<div class="col-12 mt-2"><button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary btn-block">Accedi</button></div>
									</div>
                                    <div class="text-center mt-7">
                                        <div class="font-weight-normal fs-16 text-muted">Copyright © <?php echo date("Y"); ?> - <a href="https://www.istitutoelveticodigaranzia.ch/" target="_blank">Isituto Elvetico di Garanzia S.A. -&nbsp;&nbsp;Software Gestionale</a>.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=form_close()?>
                    </div>
                    <div class="col-md-7 p-0">
                        <div class="card text-white custom-content page-content mt-0">
                            <div class="card-body text-center justify-content-center">
                                <div class="custom-body">
                                    <h2 class="mb-1">Area Amministrazione</h2>
                                </div>
                                <div class="custom-logo1">
                                    <a href="https://istitutoelveticodigaranzia.ch/"><img src="<?=base_url()?>assets/images/logo2.png" class="header-brand-img dark-logo" alt="logo" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  </div>
  <script src="<?=base_url()?>assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?=base_url()?>assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>assets/js/circle-progress.min.js"></script>
  <script src="<?=base_url()?>assets/js/loader.js"></script>
  <script type="text/javascript">
            var base_url = "<?=base_url()?>";
            
            setInterval(function(){ $(".alert").fadeOut(); }, 5000);
  </script>
 </body>
</html>