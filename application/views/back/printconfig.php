<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Modello Stampa</h4>
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
    <?=form_open(site_url(config_item('admin_url').'/printconfig/update/'), 'name="settings-form" enctype="multipart/form-data"'); ?>
    <div class="card">
      <div class="card-body">
          <?php $m=0; foreach($params as $key => $val): ?>
            <?php $rs = $this->print->GetParamValues($key)?>
            <div class="card-title font-weight-bold mt-4"><?=$val?>:</div>
            <div class="row">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                      <label class="form-label">Font Size:</label>
                      <input type="text" name="font_size[]" id="font_size_<?$m?>" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$rs['font_size']?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                      <label class="form-label">Font Type:</label>
                      <select name="font_type[]" id="font_type_<?=$m?>" class="form-control" required>
                        <?php foreach($this->asset['SD_FontType'] as $key => $val): ?>
                          <?php if($rs['font_type'] == $key): ?>
                            <option value="<?=$key?>" selected="selected"><?=$val?></option>
                          <?php else: ?>
                            <option value="<?=$key?>"><?=$val?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                      <label class="form-label">Width:</label>
                      <input type="text" name="width[]" id="width_<?$m?>" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$rs['width']?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                      <label class="form-label">X Coordinate:</label>
                      <input type="text" name="x_coordinate[]" id="x_coordinate_<?=$m?>" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$rs['x_coordinate']?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                      <label class="form-label">Y Coordinate:</label>
                      <input type="text" name="y_coordinate[]" id="y_coordinate_<?=$m?>" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$rs['y_coordinate']?>">
                    </div>
                </div>
            </div>
          <?php $m++; endforeach; ?>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary" type="submit" name="submit" value="Update"><i class="fa fa-save"></i>&nbsp;&nbsp;Salva Modifiche</button>
        <button type="button" onclick="$(location).attr('href','<?=base_url().config_item('admin_url')?>/dashboard/');" class="btn btn-danger">Cancella</button>
      </div>
    </div>
    <?=form_close()?>
  </div>
</div>