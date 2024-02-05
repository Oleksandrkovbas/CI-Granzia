<div class="page-header">
  <div class="page-leftheader">
    <h4 class="page-title">Aggiungi Appendix</h4>
  </div>
</div>
<?php //echo "jj<pre>";print_r($entry);exit;?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Inserisci Appendice</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="form-label">Lingua Atto:</label>
              <label class="form-label">
              <?=array_search ($entry['a_language'], $this->asset['SD_Language']);?>
              </label>
            </div>
            <div class="form-group">
              <label class="form-label">Rif Codice </label>
              <label class="form-label">
              <?=$entry['rif_codice']?>
              </label>
            </div>
            <div class="form-group">
              <label class="form-label">Atto di Fidejussione N</label>
              <label class="form-label">
              <?=$entry['adf_no']?>
              </label>
            </div>
            <div class="form-group">
              <label class="form-label">Corrispettivo</label>
              <label class="form-label">
			  <?php
			  if($entry['currency_symbol']=="euro"){
				$currency_symbol = "&euro;";
			  }
			  if($entry['currency_symbol']=="doller"){
				$currency_symbol = "$";
			  }
			  echo $currency_symbol;
			 ?>
              <?=$entry['corrispe']?>
              </label>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label class="form-label">A Garanzia: Oggetto della Fidejussione</label>
                <label class="form-label">
                <?=preg_replace('/font-size.+?;/', "", $entry['oda']);?>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col">
              <button type="button" class="btn btn-danger" onclick="$(location).attr('href','<?=base_url().$this->redirect_url?>');">Chiudi</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
