<div class="page-header">
  <div class="page-leftheader">
    <h4 class="page-title">Aggiungi Appendice</h4>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Inserisci Appendice</div>
      </div>
      <?php if ($Action == 'Add') : ?>
        <?= form_open(site_url($this->add_url), 'name="users-form"   enctype="multipart/form-data"'); ?>
      <?php else : ?>
        <?= form_open(site_url($this->edit_url), 'name="users-form" class="form-horizontal ls_form" enctype="multipart/form-data"'); ?>
      <?php endif; ?>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="form-label">RIF. Codice:</label>
              <?php
              if (isset($entry['rif_codice']) && $entry['rif_codice'] != "") {
                $default_rif_codice = $entry['rif_codice'];
              } else {
                $rs_order_default = getDefaultRifNumer();

                if ($rs_order_default->rif_codice == "") {
                  $default_rif_codice = '01';
                } else {
                  $default_rif_codice = ++$rs_order_default->rif_codice;
                }
              }


              ?>
              <input type="text" name="rif_codice" id="rif_codice" class="form-control" style="text-transform: uppercase" placeholder="Inserire Numero di Riferimento Codice" value="<?php echo sprintf("%02d", $default_rif_codice); ?>" readonly="readonly" />
            </div>
            <div class="form-group">
              <label class="form-label">Atto di Fidejussione N:</label>
              <input name="adf_no" id="adf_no" class="form-control" style="text-transform: uppercase" placeholder="Inserire Numero o Bozza" maxlength="20" required value="<?= (isset($entry['adf_no']) ? $entry['adf_no'] : '') ?>" />
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label class="form-label">Corrispettivo:</label>
                <!--<input type="text" name="corrispe" id="corrispe" class="form-control" style="text-transform: uppercase" placeholder="&euro;1,000,000.00" data-type="currency" required  value="<?= (isset($entry['corrispe']) ? $entry['corrispe'] : '') ?>" />-->
                <div class="row">
                  <div class="col-md-2">
                    <select name="currency_symbol" id="currency_symbol" class="form-control">
                      <option value="euro" <?php if ($entry['currency_symbol'] == "euro") echo "selected"; ?>>&euro;</option>
                      <option value="doller" <?php if ($entry['currency_symbol'] == "doller") echo "selected"; ?>>$</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="text" name="corrispe" id="corrispe" class="form-control" style="text-transform: uppercase" placeholder="Inserire importo" required value="<?= (isset($entry['corrispe']) ? $entry['corrispe'] : '') ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Stato:</label>
                <div class="row">
                  <div class="col-md-6">
                    <select name="status" id="status" class="form-control">
                      <option value="BOZZA" <?php if ($entry['status'] == "BOZZA") echo "selected"; ?>>BOZZA</option>
                      <option value="EMESSA" <?php if ($entry['status'] == "EMESSA") echo "selected"; ?>>EMESSA</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>
            <div class="form-group row float-right">
              <div class="col-md-12">
                <input type="button" class="btn btn-primary" name="appx_pdf_preview" id="appx_pdf_preview" value="Mostra Anteprima">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label class="form-label">Oggetto dell'Appendice:</label>
                <div id="appx_draft_html"></div>
                <textarea name="oda" id="oda" class="form-control"><?= (isset($entry['oda']) ? $entry['oda'] : '') ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label class="form-label">Scadenza:</label>
                <div id="appx_draft_html"></div>
                <div class="wd-200 mg-b-30">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18">
                          <path d="M0 0h24v24H0V0z" fill="none"></path>
                          <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path>
                          <path d="M4 5.01h16V8H4z" opacity=".3"></path>
                        </svg>
                      </div>
                    </div>
                    <input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="expiration" id="expiration" required value="<?= ($entry['expiration']) ? $this->functions->EntryDate($entry['expiration']) : '' ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col">
              <input type="hidden" name="ak_id" value="<?= $entry['a_id'] ?>" />
              <button type="submit" name="submit" id="issue" value="Issue" class="btn btn-facebook"><i class="fa fa-file-text-o mr-2"></i>Crea Appendice</button>
              <?php if ($Action == 'Add') : ?>
                <button type="button" class="btn btn-danger" onclick="$(location).attr('href','<?= base_url() . $this->redirect_url ?>');">Annulla</button>
              <?php else : ?>
                <button type="submit" class="btn btn-danger" name="cancel" value="cancel">Annulla</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" name="appx_pdf_preview_file_name" id="appx_pdf_preview_file_name" value="">
<div class="modal" id="modaldemo_appx" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
      <div class="modal-header">
        <h6 class="modal-title">Anteprima Bozza PDF</h6>
        <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="closeModaldemo_appx"><span aria-hidden="true">x</span></button>
      </div>
      <div class="modal-body">
        <div id="appx_pdf_draft_cotent">
          <embed src="../../uploads/drafts/Draft-1.pdf" frameborder="0" width="100%" height="600px">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-dismiss="modal" type="button" id="closeModaldemo_appx">Chiudi</button>
      </div>
    </div>
  </div>
</div>
<?php
$api_key = $api_data->config_value; ?>
<script src="https://cdn.tiny.cloud/1/<?php echo $api_key ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>