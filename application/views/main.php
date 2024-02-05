<!DOCTYPE html>
<html lang="it" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <title><?= $title ?> - <?= $this->system->company_name ?></title>
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon.ico" type="image/x-icon" />
  <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/gestionale.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/dark.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/skins.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/animated.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/responsive.bootstrap4.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/p-scrollbar.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/fileupload.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/fancy_fileupload.css" rel="stylesheet" />
  <!-- <link href="<?= base_url() ?>assets/plugins/trumbowyg/dist/ui/trumbowyg.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/plugins/trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.min.css" rel="stylesheet"> -->

  <link href="<?= base_url() ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div id="global-loader"><img src="<?= base_url() ?>assets/images/loader.svg" alt="loader"></div>
  <div class="page">
    <div class="page-main">
      <div class="hor-header header">
        <div class="container">
          <div class="d-flex">
            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
            <a class="header-brand" href="<?= base_url() ?>dashboard">
              <img src="<?= base_url() ?>assets/images/logo.png" class="header-brand-img desktop-lgo" alt="IEG Gestionale" />
              <img src="<?= base_url() ?>assets/images/logo2.png" class="header-brand-img dark-logo" alt="IEG Gestionale" />
              <img src="images/favicon.png" class="header-brand-img mobile-logo" alt="IEG Gestionale" />
            </a>
            <div class="d-flex order-lg-2 ml-auto">
              <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
                <svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                  <path d="M0 0h24v24H0V0z" fill="none"></path>
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </a>

              <?php $notifications = $this->practice->GetNotifications(); //print"<pre>"; print_r($notifications); 
              ?>

              <div class="dropdown header-notify">
                <a class="nav-link icon p-0" data-toggle="dropdown" aria-expanded="false">
                  <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                    <path opacity=".3" d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z"></path>
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-11c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2v-5zm-2 6H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zM7.58 4.08L6.15 2.65C3.75 4.48 2.17 7.3 2.03 10.5h2a8.445 8.445 0 013.55-6.42zm12.39 6.42h2c-.15-3.2-1.73-6.02-4.12-7.85l-1.42 1.43a8.495 8.495 0 013.54 6.42z"></path>
                  </svg>
                  <?php if (count($notifications) > 0) : ?>
                    <span class="pulse"></span>
                  <?php endif; ?>
                </a>
                <?php if (count($notifications) > 0) : ?>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated p-0" style="">
                    <div class="notifications-menu">
                      <?php foreach ($notifications as $n) : ?>
                        <a class="dropdown-item d-flex pb-4 border-bottom" href="<?= base_url() ?>practices/view/<?= $n['p_id'] ?>">
                          <span class="avatar avatar-md mr-3 align-self-center cover-image bg-gradient-danger brround"> <i class="fe fe-file-text"></i> </span>
                          <div>
                            <span class="font-weight-bold">Scadenza Pratica n° <?= $n['p_surety_no'] ?></span>
                            <div class="small text-muted d-flex"><?= $this->functions->EntryDate($n['p_to_date']) ?></div>
                          </div>
                        </a>
                      <?php endforeach; ?>
                    </div>
                    <a href="<?= base_url() ?>practices/expiring" class="dropdown-item text-center">Visualizza tutte le notifiche</a>
                  </div>
                <?php else : ?>
                  <!-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated p-0" style="">
                                            <div class="notifications-menu">
                                                
                                                <a class="dropdown-item d-flex pb-4 border-bottom" href="<?= base_url() ?>practices/edit/<?= $n['p_id'] ?>">
                                                    <span class="avatar avatar-md mr-3 align-self-center cover-image bg-gradient-danger brround"> <i class="fe fe-file-text"></i> </span>
                                                    <div>
                                                        <span class="font-weight-bold">Scadenza Pratica n° <?= $n['p_surety_no'] ?></span>
                                                        <div class="small text-muted d-flex"><?= $this->functions->EntryDate($n['p_to_date']) ?></div>
                                                    </div>
                                                </a>
                                                
                                            </div>
                                            <a href="scadenze.php" class="dropdown-item text-center">Visualizza tutte le notifiche</a>
                                        </div> -->
                <?php endif; ?>
              </div>
              <div class="dropdown header-fullscreen">
                <a class="nav-link icon full-screen-link p-0" id="fullscreen-button">
                  <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                    <path d="M7,14 L5,14 L5,19 L10,19 L10,17 L7,17 L7,14 Z M5,10 L7,10 L7,7 L10,7 L10,5 L5,5 L5,10 Z M17,17 L14,17 L14,19 L19,19 L19,14 L17,14 L17,17 Z M14,5 L14,7 L17,7 L17,10 L19,10 L19,5 L14,5 Z"></path>
                  </svg>
                </a>
              </div>
              <div class="dropdown profile-dropdown">
                <a href="#" class="nav-link pr-0 pl-2 leading-none" data-toggle="dropdown">
                  <span>
                    <?php
                    $user = $this->user->GetInfoById($this->session->userdata('id'));


                    if (($user['user_image'] != '' && file_exists(USERSPATH . $user['user_image']))) :
                    ?>
                      <img src="<?= base_url() ?>uploads/users/<?= $user['user_image'] ?>" alt="<?= $user['user_firstname'] ?>" class="avatar avatar-md brround" />
                    <?php else : ?>
                      <img src="<?= base_url() ?>images/admin.jpg" alt="<?= $user['user_firstname'] ?>" class="avatar avatar-md brround" />
                    <?php endif; ?>
                  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated p-0">
                  <div class="text-center border-bottom pb-4 pt-4">
                    <a href="#" class="text-center user pb-0 font-weight-bold"><?= $user['user_firstname'] . ' ' . $user['user_lastname'] ?></a>
                    <p class="text-center user-semi-title mb-0"><?= $user['user_work_title'] ?></p>
                  </div>
                  <a class="dropdown-item border-bottom" href="<?= base_url() ?>profile"> <i class="dropdown-icon mdi mdi-account-outline"></i> Profilo</a>
                  <a class="dropdown-item border-bottom" href="<?= base_url() ?>profile/edit"> <i class="dropdown-icon mdi mdi-account-edit"></i> Modifica profilo</a>
                  <a class="dropdown-item border-bottom" href="<?= base_url() ?>login/logout"> <i class="dropdown-icon mdi mdi-logout-variant"></i> Esci</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
      <div class="sticky" style="margin-bottom: -55.375px;">
        <div class="horizontal-main hor-menu clearfix">
          <div class="horizontal-mainwrapper container clearfix">
            <nav class="horizontalMenu clearfix">
              <div class="overlapblackbg active"></div>
              <ul class="horizontalMenu-list">
                <li aria-haspopup="true" class="<?php if ($this->router->class == 'dashboard') : ?>active<?php endif; ?>">
                  <a href="<?= base_url() ?>dashboard" <?php if ($this->router->class == 'dashboard') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span>
                    <span class="hor-shape2"></span>
                    <span class="hor-arrow"></span>
                    <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                      <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Dashboard
                  </a>
                </li>

                <li aria-haspopup="true" class="<?php if ($this->router->class == 'practices' && $this->router->method != 'search' && $this->router->method != 'expiring') : ?>active<?php endif; ?>">
                  <span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span>
                  <a href="#" <?php if ($this->router->class == 'practices' && $this->router->method != 'search' && $this->router->method != 'expiring') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span> <span class="hor-shape2"></span> <span class="hor-arrow"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hor-icon">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Pratiche <i class="fa fa-angle-down horizontal-icon"></i>
                  </a>
                  <ul class="sub-menu">
                    <li><a href="<?= base_url() ?>practices/insert"> Inserisci Pratica</a></li>
                    <li><a href="<?= base_url() ?>practices"> Lista Pratiche</a></li>
                    <!-- <li><a href="<?= base_url() ?>practices/expiring"> Scadenze Pratiche</a></li> -->
                  </ul>
                </li>

                <li aria-haspopup="true" class="<?php if ($this->router->class == 'practices' && $this->router->method == 'expiring')  : ?>active<?php endif; ?>">
                  <a href="<?= base_url() ?>practices/expiring" <?php if  ($this->router->class == 'practices' && $this->router->method == 'expiring') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span>
                    <span class="hor-shape2"></span>
                    <span class="hor-arrow"></span>
                    <svg xmlns="htp://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                      <path fill="currentColor" d="M334.5 0v128h128zm-21.3 0H78.5v512h384V149.3H313.2zm-21.4 448h-42.7v-42.7h42.7zm0-64h-42.7l-21.3-149.3h85.3z"></path>
                    </svg>
                    Scadenze Pratiche
                  </a>
                </li>
                
                <?php //if($user['user_group_id']==3){
                ?>
                <li aria-haspopup="true" class="<?php if ($this->router->class == 'appendix') : ?>active<?php endif; ?>">
                  <span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span>
                  <a href="#" <?php if ($this->router->class == 'appendix') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span> <span class="hor-shape2"></span> <span class="hor-arrow"></span>


                    <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                      <polyline points="13 2 13 9 20 9"></polyline>
                    </svg>
                    Appendice <i class="fa fa-angle-down horizontal-icon"></i>
                  </a>
                  <ul class="sub-menu">
                    <li><a href="<?= base_url() ?>appendix/insert"> Inserisci Appendice</a></li>
                    <li><a href="<?= base_url() ?>appendix"> Lista Appendice</a></li>
                  </ul>
                </li>
                <?php //}
                ?>
                <li aria-haspopup="true" class="<?php if ($this->router->class == 'solleciti') : ?>active<?php endif; ?>">
                  <span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span>
                  <a href="javascript: void(0);" onclick="showPinModal('<?= base_url() ?>solleciti')" <?php if ($this->router->class == 'solleciti') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span> <span class="hor-shape2"></span> <span class="hor-arrow"></span>


                    <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                      <polyline points="2 17 12 22 22 17"></polyline>
                      <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    Solleciti
                  </a>
                </li>
                <li aria-haspopup="true" class="<?php if ($this->router->class == 'practices' && $this->router->method == 'search') : ?>active<?php endif; ?>">
                  <span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span>
                  <a href="<?= base_url() ?>practices/search" <?php if ($this->router->class == 'practices' && $this->router->method == 'search') echo 'class="sub-icon active"'; ?>>
                    <span class="hor-shape1"></span> <span class="hor-shape2"></span> <span class="hor-arrow"></span>
                    <svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                      <path d="M0 0h24v24H0V0z" fill="none"></path>
                      <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                    Cerca pratica</i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div class="jumps-prevent" style="padding-top: 55.375px;"></div>
      <div class="main-content">
        <div class="container">
          <?php $this->load->view($view); ?>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
          <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">Copyright © <?php echo date("Y"); ?> - <a href="https://www.istitutoelveticodigaranzia.ch/" target="_blank">Isituto Elvetico di Garanzia S.A. -&nbsp;&nbsp;Software Gestionale</a>.</div>
        </div>
      </div>
    </footer>
  </div>

  <div class="modal fade" id="pinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body text-center p-4">
          <input type="hidden" name="pr_id" id="pr_id" />
          <h4 class="text-primary">Inserisci il tuo codice PIN</h4>
          <input type="text" name="pincode" id="pincode" class="form-control" onkeydown="enterKeyEvent(this, '<?= base_url() ?>solleciti', $(' #pincode').val())" />
          <br>
          <button class="btn btn-primary pd-x-25" type="button" onClick="javascript: allowRoute('<?= base_url() ?>solleciti', $(' #pincode').val());">OK</button>
          <button aria-label="Close" class="btn btn-danger pd-x-25" data-dismiss="modal" type="button">Annulla</button>
        </div>
      </div>
    </div>
  </div>

  <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
  <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/common.js"></script>
  <script src="<?= base_url() ?>assets/js/horizontal.js"></script>
  <script src="<?= base_url() ?>assets/js/loader.js"></script>
  <script src="<?= base_url() ?>assets/js/custom.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/js/dataTables.bootstrap4.js"></script>
  <script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>assets/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>assets/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/index1.js"></script>
  <script src="<?= base_url() ?>assets/js/importo.js"></script>
  <!-- <script src="<?= base_url() ?>assets/plugins/trumbowyg/dist/trumbowyg.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/trumbowyg/dist/plugins/fontfamily/trumbowyg.fontfamily.min.js"></script> -->
  <script src="<?= base_url() ?>assets/plugins/datepicker/jquery-ui.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datepicker/datepicker-it.js"></script>
  <script src="<?= base_url() ?>assets/plugins/sweetalert/sweetalert-dev.js"></script>
  <!-- <script src="<?= base_url() ?>assets/js/datatables.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script type="text/javascript">
    var base_url = "<?= base_url() ?>";

    setInterval(function() {
      $(".alert").fadeOut();
    }, 5000);

    $(".select2").select2();


    $('.fc-datepicker').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      option: $.datepicker.regional["fr"],
    });

    <?php if ($this->router->fetch_class() == "practices" && (($this->router->fetch_method() == 'insert' || $this->router->fetch_method() == 'edit'))) : ?>

      function addBeneficiary() {
        pid = parseInt($('#beneficiary_count').val()) + parseInt(1);

        if ($("#bcount").val() == '4') {
          swal("Hai raggiunto il limite di 4 per il beneficiario.", "", "error");
          return false;
        }

        $.ajax({
          url: "<?= base_url() . $this->router->fetch_class() ?>/addbeneficiary/" + pid,
          success: function(data) {
            $('#beneficiary_count').val(pid);
            $('#beneficiarydiv').append(data);
            $("#bcount").val(Number(Number($("#bcount").val()) + 1));
            AutoBeneficiary();
          }
        });
      }

      function removeBeneficiaryRow(pid) {
        $('#b_' + pid).remove();
        $("#bcount").val(Number(Number($("#bcount").val()) - 1));
      }

      function addContractor() {
        pid = parseInt($('#contractor_count').val()) + parseInt(1);

        if ($("#ccount").val() == '4') {
          swal("Hai raggiunto il limite di 4 per il contraente.", "", "error");
          return false;
        }

        $.ajax({
          url: "<?= base_url() . $this->router->fetch_class() ?>/addcontractor/" + pid,
          success: function(data) {
            $('#contractor_count').val(pid);
            $('#contractordiv').append(data);
            $("#ccount").val(Number(Number($("#ccount").val()) + 1));
            AutoContractor();
          }
        });
      }

      function removeContractorRow(pid) {
        $('#c_' + pid).remove();
        $("#ccount").val(Number(Number($("#ccount").val()) - 1));
      }


      $('#p_language').change(function() {
        $('#p_guaranteed_amount').trigger('blur');
        $('#p_receipt_amount').trigger('blur');
      });

      var res1 = '';
      var res2 = '';

      $('#p_guaranteed_amount').blur(function() {
        if ($("#p_language").val() == 'it') {
          res1 = conv_iac($("#p_guaranteed_amount").val());
          $("#p_guaranteed_amount_words_text").val(res1);
          $("#p_guaranteed_amount_words").val(res1);
        } else {
          res1 = toWords($("#p_guaranteed_amount").val());
          $("#p_guaranteed_amount_words_text").val(res1);
          $("#p_guaranteed_amount_words").val(res1);
        }
      });

      $('#p_receipt_amount').blur(function() {
        if ($("#p_language").val() == 'it') {
          res2 = conv_iac($("#p_receipt_amount").val());
          $("#p_receipt_amount_words_text").val(res2);
          $("#p_receipt_amount_words").val(res2);
        } else {
          res2 = toWords($("#p_receipt_amount").val());
          $("#p_receipt_amount_words_text").val(res2);
          $("#p_receipt_amount_words").val(res2);
        }
      });

      $(".auto_contractor").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: "<?= base_url() ?>practices/getcontractors",
            type: "POST",
            dataType: "json",
            data: {
              search: request.term,
              _token: $("input[name=_token]").val()
            },

            success: function(data) {
              response($.map(data, function(item) {
                return {
                  value: item.pc_contractor_name,
                  addr: item.pc_contractor_address,
                  vat: item.pc_contractor_vat_no
                };
              }))
            }
          })
        },
        // change: function (event, ui) {
        //   //Forces input to source values, otherwise, clears
        //   //NOTE : user could still submit right after typing => check server side
        //   if (!ui.item) {
        //     //http://api.jqueryui.com/autocomplete/#event-change -
        //     // The item selected from the menu, if any. Otherwise the property is null
        //     //so clear the item for force selection
        //     $(event.target).val("");
        //     $(event.target).addClass("is-invalid");
        //   }
        //   else {
        //     $(event.target).removeClass("is-invalid");
        //   }
        // },
        select: function(event, ui) {

          //Update Customer Name Field on Id selection
          event.preventDefault()
          //Note : the "value" object is created dynamically in the autocomplete' source Ajax' success function (see above)
          debugger;
          var cid = $(this).data("cid");
          $("#pc_contractor_name_" + cid).val(ui.item.value);
          $("#pc_contractor_address_" + cid).val(ui.item.addr);
          $("#pc_contractor_vat_no_" + cid).val(ui.item.vat);
        },
        messages: {
          noResults: "",
          results: function(resultsCount) {}
        },
        autoFocus: true,
        minLength: 3
      });

      function AutoContractor() {
        $(".auto_contractor").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "<?= base_url() ?>practices/getcontractors",
              type: "POST",
              dataType: "json",
              data: {
                search: request.term,
                _token: $("input[name=_token]").val()
              },

              success: function(data) {
                response($.map(data, function(item) {
                  return {
                    value: item.pc_contractor_name,
                    addr: item.pc_contractor_address,
                    vat: item.pc_contractor_vat_no
                  };
                }))
              }
            })
          },
          // change: function (event, ui) {
          //   //Forces input to source values, otherwise, clears
          //   //NOTE : user could still submit right after typing => check server side
          //   if (!ui.item) {
          //     //http://api.jqueryui.com/autocomplete/#event-change -
          //     // The item selected from the menu, if any. Otherwise the property is null
          //     //so clear the item for force selection
          //     $(event.target).val("");
          //     $(event.target).addClass("is-invalid");
          //   }
          //   else {
          //     $(event.target).removeClass("is-invalid");
          //   }
          // },
          select: function(event, ui) {

            //Update Customer Name Field on Id selection
            event.preventDefault()
            //Note : the "value" object is created dynamically in the autocomplete' source Ajax' success function (see above)
            //debugger;
            var cid = $(this).data("cid");
            $("#pc_contractor_name_" + cid).val(ui.item.value);
            $("#pc_contractor_address_" + cid).val(ui.item.addr);
            $("#pc_contractor_vat_no_" + cid).val(ui.item.vat);
          },
          messages: {
            noResults: "",
            results: function(resultsCount) {}
          },
          autoFocus: true,
          minLength: 3
        });
      }

      function AutoBeneficiary() {
        $(".auto_beneficiary").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "<?= base_url() ?>practices/getbeneficiaries",
              type: "POST",
              dataType: "json",
              data: {
                search: request.term,
                _token: $("input[name=_token]").val()
              },

              success: function(data) {
                response($.map(data, function(item) {
                  return {
                    value: item.pb_beneficiary_name,
                    addr: item.pb_beneficiary_address,
                    vat: item.pb_beneficiary_vat_no
                  };
                }))
              }
            })
          },
          // change: function (event, ui) {
          //   //Forces input to source values, otherwise, clears
          //   //NOTE : user could still submit right after typing => check server side
          //   if (!ui.item) {
          //     //http://api.jqueryui.com/autocomplete/#event-change -
          //     // The item selected from the menu, if any. Otherwise the property is null
          //     //so clear the item for force selection
          //     $(event.target).val("");
          //     $(event.target).addClass("is-invalid");
          //   }
          //   else {
          //     $(event.target).removeClass("is-invalid");
          //   }
          // },
          select: function(event, ui) {

            //Update Customer Name Field on Id selection
            event.preventDefault()
            //Note : the "value" object is created dynamically in the autocomplete' source Ajax' success function (see above)
            //debugger;
            var bid = $(this).data("bid");
            $("#pb_beneficiary_name_" + bid).val(ui.item.value);
            $("#pb_beneficiary_address_" + bid).val(ui.item.addr);
            $("#pb_beneficiary_vat_no_" + bid).val(ui.item.vat);
          },
          messages: {
            noResults: "",
            results: function(resultsCount) {}
          },
          autoFocus: true,
          minLength: 3
        });
      }

      $(".auto_beneficiary").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: "<?= base_url() ?>practices/getbeneficiaries",
            type: "POST",
            dataType: "json",
            data: {
              search: request.term,
              _token: $("input[name=_token]").val()
            },

            success: function(data) {
              response($.map(data, function(item) {
                return {
                  value: item.pb_beneficiary_name,
                  addr: item.pb_beneficiary_address,
                  vat: item.pb_beneficiary_vat_no
                };
              }))
            }
          })
        },
        // change: function (event, ui) {
        //   //Forces input to source values, otherwise, clears
        //   //NOTE : user could still submit right after typing => check server side
        //   if (!ui.item) {
        //     //http://api.jqueryui.com/autocomplete/#event-change -
        //     // The item selected from the menu, if any. Otherwise the property is null
        //     //so clear the item for force selection
        //     $(event.target).val("");
        //     $(event.target).addClass("is-invalid");
        //   }
        //   else {
        //     $(event.target).removeClass("is-invalid");
        //   }
        // },
        select: function(event, ui) {

          //Update Customer Name Field on Id selection
          event.preventDefault()
          //Note : the "value" object is created dynamically in the autocomplete' source Ajax' success function (see above)
          //debugger;
          var bid = $(this).data("bid");
          $("#pb_beneficiary_name_" + bid).val(ui.item.value);
          $("#pb_beneficiary_address_" + bid).val(ui.item.addr);
          $("#pb_beneficiary_vat_no_" + bid).val(ui.item.vat);
        },
        messages: {
          noResults: "",
          results: function(resultsCount) {}
        },
        autoFocus: true,
        minLength: 3
      });
    <?php endif; ?>

    /* TineMCE Editor plugin started */
    tinymce.init({
      selector: "#p_surety_object,#oda",
      language: 'it',
      plugins: "advlist advtable anchor autolink autosave casechange charmap checklist codesample directionality editimage emoticons export footnotes formatpainter help image insertdatetime link linkchecker lists media mediaembed mergetags nonbreaking pagebreak permanentpen powerpaste searchreplace table tableofcontents typography visualblocks visualchars wordcount code fullscreen print preview",
      toolbar: "undo redo spellcheckdialog  | blocks fontfamily fontsizeinput | bold italic underline forecolor backcolor | link image | align lineheight checklist bullist numlist | indent outdent | removeformat typography",
      height: "700px",

      //HTML custom font options
      font_size_formats: "8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",

      content_style: `
                            body {
                              background: #fff;
                            }
                    
                            @media (min-width: 840px) {
                              html {
                                background: #eceef4;
                                min-height: 100%;
                                padding: 0 .5rem;
                              }
                    
                              body {
                                background-color: #fff;
                                box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                                box-sizing: border-box;
                                margin: 1rem auto 0;
                                max-width: 820px;
                                min-height: calc(100vh - 1rem);
                                padding:4rem 6rem 6rem 6rem;
                              }
                            }
                          `
    });

    /* PDF Preview Code For Practices - by - Piyush Rana */
    $(document).on('click', '#pdf_preview', function() {
      //alert('hey');
      var base_url = $("#base_url").val();
      //let request_body = $('#p_surety_object').trumbowyg('html');
      let request_body = tinyMCE.get('p_surety_object').getContent();

      var p_surety_no = $("#p_surety_no").val();
      //console.log('content='+request_body);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + 'ajax/getDraftPDF/',
        data: 'editor_content=' + encodeURIComponent(request_body),
        success: function(response) {
          if (response.status) {
            $('#pdf_draft_cotent').html('<embed frameborder="0" width="100%" height="600px" src="<?php echo base_url() ?>/uploads/drafts/' + response.image + '" />');
            $("#pdf_preview_file_name").val(response.image);
            $("#modaldemo3").modal('show');
            $('#draft_html').html("");
          }
        },
        beforeSend: function(d) {
          $('#draft_html').html("<center><strong style='color:red'>Anteprima in corso...<br><img height='50px' width='50px' src='<?php echo base_url(); ?>assets/images/loader.svg' /></strong></center>");
        }
      });
    });


    /* unlink preview file For Practices - piyush rana */
    $(document).on('click', '#closeModaldemo3', function() {
      //$('#modaldemo3').on('hidden', function() {
      console.log("modaldemo3 is closed now");
      var base_url = $("#base_url").val();
      var pdf_preview_file_name = $("#pdf_preview_file_name").val();
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + 'ajax/removeDraftPDF/',
        data: 'pdf_preview_file_name=' + pdf_preview_file_name,
        success: function(response) {
          console.log("deleted");
        },
      });
    });

    /* PDF Preview Code For Appendix - by - Piyush Rana */
    $(document).on('click', '#appx_pdf_preview', function() {
      //alert('hey');
      var base_url = $("#base_url").val();
      let request_body = tinyMCE.get('oda').getContent();
      let rif_codice = $("#rif_codice").val();
      let adf_no = $("#adf_no").val();

      var oda = $("#oda").val();
      //console.log('content='+request_body);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + 'ajax/getAppxDraftPDF/',
        data: 'editor_content=' + encodeURIComponent(request_body) + '&rif_codice=' + rif_codice + '&adf_no=' + adf_no,
        success: function(response) {
          if (response.status) {
            $('#appx_pdf_draft_cotent').html('<embed frameborder="0" width="100%" height="600px" src="<?php echo base_url() ?>/uploads/drafts/' + response.image + '" />');
            $("#appx_pdf_preview_file_name").val(response.image);
            $("#modaldemo_appx").modal('show');
            $('#appx_draft_html').html("");
          }
        },
        beforeSend: function(d) {
          $('#appx_draft_html').html("<center><strong style='color:red'>Anteprima in corso...<br><img height='50px' width='50px' src='<?php echo base_url(); ?>assets/images/loader.svg' /></strong></center>");
        }
      });
    });

    /* unlink preview file For Practices - piyush rana */
    $(document).on('click', '#closeModaldemo_appx', function() {
      //$('#modaldemo3').on('hidden', function() {
      console.log("modaldemo3 is closed now");
      var base_url = $("#base_url").val();
      var appx_pdf_preview_file_name = $("#appx_pdf_preview_file_name").val();
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + 'ajax/removeAppxDraftPDF/',
        data: 'appx_pdf_preview_file_name=' + appx_pdf_preview_file_name,
        success: function(response) {
          console.log("deleted");
        },
      });
    });

    /* get auto format currency */

    $("input[data-type='currency']").on({
      keyup: function() {
        formatCurrency($(this));
      },
      blur: function() {
        formatCurrency($(this), "blur");
      }
    });


    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.

      // get input value
      var input_val = input.val();

      // don't validate empty input
      if (input_val === "") {
        return;
      }

      // original length
      var original_len = input_val.length;

      // initial caret position 
      var caret_pos = input.prop("selectionStart");

      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          //right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 6);

        // join number by .
        input_val = "€" + left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "€" + input_val;

        // final formatting
        if (blur === "blur") {
          // input_val += ".00";
        }
      }

      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }
  </script>
</body>

</html>