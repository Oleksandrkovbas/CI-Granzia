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
    <div class="page-single">
        <div class="container">
           <div class="row">
              <div class="col mx-auto">
                 <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-4">
                       <div class="error-logo">
                          <a href="index.php"><img src="<?=base_url()?>assets/images/logo2.png" class="header-brand-img dark-logo" alt="logo" /></a>
                      </div>
                      <?=form_open(site_url('login/dologin'), 'id="login-form" name="login-form"'); ?>
                      <div class="card mb-0">
                          <div class="card-body">
                             <div class="text-center mb-6"><h2 class="mb-2">Accesso Gestionale</h2></div>
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
                             <div class="input-group mb-4"><input type="text" id="user_name" name="user_name" required class="form-control" placeholder="Username" /></div>
                             <div class="input-group mb-4"><input type="password" id="password" name="password" required class="form-control" placeholder="Password" /></div>
                             <div class="row">
                                <div class="col-12 mt-5"><button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary btn-block">Accedi</button></div>
                            </div>
                        </div>
                    </div>
                    <?=form_close()?>
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