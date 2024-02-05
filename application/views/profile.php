<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Profilo Utente</h4>
    </div>
</div>
<div class="main-proifle">
    <div class="row">
        <div class="col-lg-7">
            <div class="box-widget widget-user">
                <div class="widget-user-image d-sm-flex"> <img alt="" class="rounded-circle border p-0" src="<?=base_url()?>uploads/users/<?=$user['user_image']?>" width="200" height="200">
                    <div class="ml-sm-4 mt-4">
                        <h4 class="pro-user-username mb-3 font-weight-bold"><?=$user['user_firstname'].' '.$user['user_lastname']?> <i class="fa fa-check-circle text-success"></i></h4>
                        <?php if($user['user_website'] != ''): ?>
                            <div class="d-flex mb-3"> <i class="fe fe-globe text-muted fs-18"></i>
                                <div class="h6 mb-0 ml-3"><?=$user['user_website']?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($user['user_email'] != ''): ?>
                            <div class="d-flex mb-3"> <i class="fe fe-mail text-muted fs-18"></i>
                                <div class="h6 mb-0 ml-3"><?=$user['user_email']?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($user['user_phone'] != ''): ?>
                            <div class="d-flex"> <i class="fe fe-phone-call text-muted fs-18"></i>
                                <div class="h6 mb-0 ml-3"><?=$user['user_phone']?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-auto">
            <div class="text-lg-right mt-4 mt-lg-0"> <a href="<?=base_url()?>profile/edit" class="btn btn-primary">Modifica Profilo</a> </div>
            <div class="mt-5">
                <div class="main-profile-contact-list row">
                    <div class="media col-sm-4">
                        <div class="media-icon bg-gradient-danger text-white mr-3 mt-1"> <i class="fa fa-file fs-18"></i> </div>
                        <div class="media-body"> <small class="text-muted">Pratiche Totali</small>
                            <div class="font-weight-bold fs-25"> <?=$this->dashboard->GetTotalPractices()?></div>
                        </div>
                    </div>
                    <div class="media col-sm-4">
                        <div class="media-icon bg-gradient-teal text-white mr-3 mt-1"> <i class="fa fa-file fs-18"></i> </div>
                        <div class="media-body"> <small class="text-muted">Emesse</small>
                            <div class="font-weight-bold fs-25"> <?=$this->dashboard->GetTotalIssuedPractices()?></div>
                        </div>
                    </div>
                    <div class="media col-sm-4">
                        <div class="media-icon bg-gradient-info text-white mr-3 mt-1"> <i class="fa fa-sticky-note-o fs-18"></i> </div>
                        <div class="media-body"> <small class="text-muted">Bozze</small>
                            <div class="font-weight-bold fs-25"> <?=$this->dashboard->GetTotalDraftPractices()?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-cover">
        <div class="wideget-user-tab">
            <div class="tab-menu-heading p-0">
            </div>
        </div>
    </div>
</div>