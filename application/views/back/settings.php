<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Modifica Configurazione Admin</h4>
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
    <?=form_open(site_url(config_item('admin_url').'/settings/update/'), 'name="settings-form" enctype="multipart/form-data"'); ?>
    <div class="card">
      <div class="card-body">
          <div class="card-title font-weight-bold">Notifiche:</div>
          <div class="row">
              <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">Giorni Prima:</label>
                    <input type="text" name="reminder_days" id="reminder_days" onkeypress="return isNumberKey(event)" maxlength="2" required class="form-control" value="<?=$this->system->reminder_days?>">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">Modifica PDF:</label>
                    <select name="protect_pdf" id="protect_pdf" required class="form-control">
                      <?php foreach($this->asset['SD_YesNoInt'] as $key => $val): ?>
                        <?php if($val == $this->system->protect_pdf): ?>
                          <option selected="selected" value="<?=$val?>"><?=$key?></option>
                        <?php else: ?>
                          <option value="<?=$val?>"><?=$key?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
              </div>
          </div>
		  
		  <!-- Code For API key -->
		  <div class="row">
		  <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">API Key:</label>
					<input type="text" name="editor_api_key" id="editor_api_key" class="form-control" value="<?=$this->system->editor_api_key?>" required>
                   
                  </div>
              </div>
		  
		  </div>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary" type="submit" name="submit" value="Update"><i class="fa fa-save"></i>&nbsp;&nbsp;Salva Modifiche</button>
        <button type="button" onclick="$(location).attr('href','<?=base_url().config_item('admin_url')?>/dashboard/');" class="btn btn-danger">Cancella</button>
      </div>
    </div>
    <?=form_close()?>
  </div>
</div>