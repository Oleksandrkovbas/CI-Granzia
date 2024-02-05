<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Modifica Profilo Admin</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('success_notification')): ?>
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
        <?=form_open(site_url('admin/profile'), 'name="profile-form" enctype="multipart/form-data"'); ?>
        <div class="card">
            <div class="card-body">
                <div class="card-title font-weight-bold">Informazioni Profilo:</div>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group"> <label class="form-label">Nome</label> <input type="text" name="user_firstname" id="user_firstname" class="form-control" value="<?=$user['user_firstname']?>" required> </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group"> <label class="form-label">Cognome</label> <input type="text" name="user_lastname" id="user_lastname" class="form-control" value="<?=$user['user_lastname']?>" required> </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group"> <label class="form-label">Firma</label> <input type="text" name="user_work_title" id="user_work_title" class="form-control" value="<?=$user['user_work_title']?>" required> </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group"> <label class="form-label">Indirizzo Email</label> <input type="email" class="form-control" name="user_email" id="user_email" value="<?=$user['user_email']?>" required> </div>
                    </div>
                </div>

                <div class="card-title font-weight-bold">Admin Account:</div>
                <div class="row">
                   <div class="col-sm-6 col-md-6">
                      <div class="input-icon"> <span class="input-icon-addon"> <i class="fe fe-user"></i> </span> <input type="text" name="user_name" id="user_name" required readonly class="form-control" value="<?=$user['user_name']?>">
                      </div> 
                  </div>
                  <div class="col-sm-6 col-md-6">
                      <div class="input-icon"> <span class="input-icon-addon"> <i class="fe fe-lock"></i> </span> <input type="password" name="user_password" id="user_password" class="form-control" minlength="8" value="">
                      </div> 
                  </div>
              </div>

        <input type="hidden" name="user_id" id="user_id" value="<?=$this->session->userdata('id')?>">
        <div class="card-title font-weight-bold mt-5">Modifica Immagine Profilo:</div>
        <div class=" row">
            <div class="col-sm-12 col-md-12 input-group mb-6">
                <input type="text" class="form-control browse-file" placeholder="Choose" readonly="">
                <label class="input-group-btn">
                <span class="btn btn-primary">Carica<input type="file" name="user_image" id="user_image" style="display: none;"></span> </label>
            </div>
            <div class="col-sm-12 col-md-12 input-group mb-6">
                <input type="hidden" name="oldimagefile" value="<?=$user['user_image']?>"  />
                <?php if(($user['user_image'] != '' && file_exists(USERSPATH.$user['user_image']))): ?>
                    <br /><img src="<?=base_url()?>uploads/users/thumb/<?=$user['user_image']?>" width="140" />
                <?php endif; ?>
            </div>
      </div>
  </div>
  <div class="card-footer text-right">
    <button class="btn btn-primary" type="submit" name="submit" value="Update"><i class="fa fa-save"></i>&nbsp;&nbsp;Salva Modifiche</button>
    <button type="button" onclick="$(location).attr('href','<?=base_url()?>admin/dashboard/');" class="btn btn-danger">Cancella</button>
  </div>
</div>
<?=form_close()?>
</div>
</div>