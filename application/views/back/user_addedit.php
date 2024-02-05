<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Aggiungi Utente</h4>
    </div>
</div>	   
<div class="row">    
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <?php if($Action == 'Add'): ?>
                <?=form_open(site_url($this->add_url), 'name="users-form" onsubmit="return validateUserForm()"  enctype="multipart/form-data"'); ?>
            <?php else: ?>
                <?=form_open(site_url($this->edit_url), 'name="users-form" class="form-horizontal ls_form" enctype="multipart/form-data"'); ?>
            <?php endif; ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="user_firstname" id="user_firstname" value="<?=(isset($entry['user_firstname']))?$entry['user_firstname']:''?>" class="form-control" required placeholder="First Name" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Cognome</label>
                            <input type="text" name="user_lastname" id="user_lastname" value="<?=(isset($entry['user_lastname']))?$entry['user_lastname']:''?>" class="form-control" required placeholder="Last Name" />
                        </div>
                    </div>
					<div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Firma</label>
                            <input type="text" name="user_work_title" id="user_work_title" value="<?=(isset($entry['user_work_title']))?$entry['user_work_title']:''?>" class="form-control" required placeholder="Firma" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email address</label>
                            <input type="email" name="user_email" id="user_email" value="<?=(isset($entry['user_email']))?$entry['user_email']:''?>" class="form-control" required placeholder="Email" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 input-group mb-6">
                        <input type="text" class="form-control browse-file" placeholder="Choose" readonly="">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">Carica<input type="file" name="user_image" id="user_image" style="display: none;"></span> </label>
                    </div>
                        <?php if($Action == 'Edit'): ?>
                            <div class="col-sm-12 col-md-12 input-group mb-6">
                                <input type="hidden" name="oldimagefile" value="<?=$entry['user_image']?>"  />
                                <?php if(($entry['user_image'] != '' && file_exists(USERSPATH.$entry['user_image']))): ?>
                                    <br /><img src="<?=base_url()?>uploads/users/thumb/<?=$entry['user_image']?>" width="140" />
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                </div>
				<div class="card-title font-weight-bold">Acccount:</div>
                	<div class="row">
    					<div class="col-sm-6 col-md-6">
    						<div class="input-icon">
                                <span class="input-icon-addon"> <i class="fe fe-user"></i></span>
                                <input type="text" name="user_name" id="user_name" minlength="5" value="<?=(isset($entry['user_name']))?$entry['user_name']:''?>" <?php if($Action == 'Edit'): ?>readonly<?php  endif; ?> class="form-control" required placeholder="Username">
    						</div> 
    					</div>
					<div class="col-sm-6 col-md-6">
						<div class="input-icon">
                            <span class="input-icon-addon"><i class="fe fe-lock"></i></span>
                            <input type="password" name="user_password" id="user_password" minlength="8" value="" <?php if($Action == 'Add'): ?> required <?php endif; ?> class="form-control" placeholder="Password">
						</div> 
					</div>
                </div>
                <?php if($Action == 'Edit'): ?>
                    <br><br>
                    <div class="row">  
                        <input type="hidden" name="pk_id" value="<?=$entry['user_id']?>" />  
                        <div class="col-sm-6 col-md-6">
                            <div class="form-label">Utente</div> 
                            <label class="custom-switch">
                                <input type="checkbox" name="user_status" id="user_status" value="1" class="custom-switch-input" <?php if($entry['user_status'] == 1): ?> checked <?php endif; ?> >
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Abilita e disabilita utente</span> 
                            </label> 
                        </div>
                    </div>
                
                <?php endif; ?>
            </div>
            <div class="card-footer text-right">
                <button type="submit" name="submit" value="Submit" class="btn btn-success">Aggiungi</button>
                <button type="button" class="btn btn-danger" onclick="$(location).attr('href','<?=base_url().$this->redirect_url?>');">Cancella</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>