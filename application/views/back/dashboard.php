<div class="page-header">
    <div class="page-leftheader"><h4 class="page-title"></h4></div>
</div>
<div class="row row-deck">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-header"><h3 class="card-title">Utenti e Pratiche</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive mb-0">
                        <table class="table text-nowrap card-table table-vcenter text-nowrap border-top mb-0">
                            <tbody>
                                <?php $users = $this->user->ViewAll(); ?>
                                <?php foreach($users as $u): ?>
            						<tr>
                                        <td>
                                            <div class="media mt-0 mb-0">
                                                <div class="card-aside-img">
                                                    <?php if($u['user_image'] != '' && file_exists(USERSPATH.$u['user_image'])): ?>
                                                          <img class="brround w-7 h-7" src="<?=base_url()?>uploads/users/thumb/<?=$u['user_image']?>" alt="<?=$u['user_firstname']?>" />
                                                     <?php else: ?>
                                                          <img class="brround w-7 h-7" src="<?=base_url()?>images/admin.jpg" alt="<?=$u['user_firstname']?>" />
                                                     <?php endif; ?>
                                                </div>
                                                <div class="media-body">
                                                    <div class="card-item-desc ml-4 p-0 mt-2">
                                                        <a class="text-dark" href="#"><h4 class="font-weight-bold fs-14 mb-1"><?=$u['user_firstname'].' '.$u['user_lastname']?></h4></a>
                                                        <p class="text-muted mb-0"><?=$u['user_work_title']?></p>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($u['user_status'] == 1): ?>
                                                <span class="badge badge-success-light badge-pill mt-2 font-weight-semibold">Utente Attivo</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger-light badge-pill mt-2 font-weight-semibold">Utente Disattivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h4 class="font-weight-normal mb-0 fs-18 mt-1"><?=$this->dashboard->GetPracticesForUser($u['user_id'])?></h4>
                                            <p class="text-muted mb-0">Pratiche Totali</p>
                                        </td>
            							<td>
                                            <h4 class="font-weight-normal mb-0 fs-18 mt-1"><?=$this->dashboard->GetPracticesForUser($u['user_id'], '1')?></h4>
                                            <p class="text-muted mb-0">Pratiche Emesse</p>
                                        </td>
            							<td>
                                            <h4 class="font-weight-normal mb-0 fs-18 mt-1"><?=$this->dashboard->GetPracticesForUser($u['user_id'], '0')?></h4>
                                            <p class="text-muted mb-0">Bozze Emesse</p>
                                        </td>
            							<td>
                                            <h4 class="font-weight-normal mb-0 fs-16 mt-1">Esporta Dettagli Pratiche</h4>
                                            <p class="text-muted mb-0"><a href="<?=base_url()?>admin/dashboard/generate/<?=$u['user_id']?>" target="_blank"><i class="fa fa-file-excel-o" data-original-title="fa fa-file-excel-o"></i></a></p>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>