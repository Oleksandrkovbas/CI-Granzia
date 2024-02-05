<div class="page-header">
  <div class="page-leftheader"><h4 class="page-title">Cerca Pratiche</h4></div>
</div>
<div class="row">
  <div class="col-lg-12" width="800px;" style="min-height: 500px;">
    <div class="card">
      <div class="card-body">
        <?=form_open(site_url('practices/search'), 'name="listing-form" id="listing-form" enctype="multipart/form-data"'); ?>
        <div class="row">
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Atto di Fidejussione N°:</label>
                <input type="text" name="filter_surety_no" id="filter_surety_no" maxlength="20" class="form-control" value="<?=(($this->session->userdata('sel_filter_surety_no'))?$this->session->userdata('sel_filter_surety_no'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Denominazione Contraente:</label>
                <input type="text" name="filter_contractor_name" id="filter_contractor_name" maxlength="60" class="form-control" value="<?=(($this->session->userdata('sel_filter_contractor_name'))?$this->session->userdata('sel_filter_contractor_name'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">P.IVA Contraente:</label>
                <input type="text" name="filter_contractor_vat_no" id="filter_contractor_vat_no" maxlength="20" class="form-control" value="<?=(($this->session->userdata('sel_filter_contractor_vat_no'))?$this->session->userdata('sel_filter_contractor_vat_no'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Denominazione Beneficiario:</label>
                <input type="text" name="filter_beneficiary_name" id="filter_beneficiary_name" maxlength="60" class="form-control" value="<?=(($this->session->userdata('sel_filter_beneficiary_name'))?$this->session->userdata('sel_filter_beneficiary_name'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">P.IVA Beneficiario:</label>
                <input type="text" name="filter_beneficiary_vat_no" id="filter_beneficiary_vat_no" maxlength="20" class="form-control" value="<?=(($this->session->userdata('sel_filter_beneficiary_vat_no'))?$this->session->userdata('sel_filter_beneficiary_vat_no'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Dal:</label>
                <div class="wd-200 mg-b-30">
                  <div class="input-group"> 
                    <div class="input-group-prepend"> 
                      <div class="input-group-text">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
                      </div>
                    </div>
                    <input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="filter_from_date" id="filter_from_date" value="<?=($this->session->userdata('sel_filter_from_date'))?>">
                  </div>
                </div>
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">al:</label>
                <div class="wd-200 mg-b-30">
                  <div class="input-group"> 
                    <div class="input-group-prepend"> 
                      <div class="input-group-text">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
                      </div>
                    </div>
                    <input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="filter_to_date" id="filter_to_date" value="<?=($this->session->userdata('sel_filter_to_date'))?>">
                  </div>
                </div>
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Emessa il:</label>
                <div class="wd-200 mg-b-30">
                  <div class="input-group"> 
                    <div class="input-group-prepend"> 
                      <div class="input-group-text">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
                      </div>
                    </div>
                    <input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="filter_release_date" id="filter_release_date" value="<?=($this->session->userdata('sel_filter_release_date'))?>">
                  </div>
                </div>
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Importo garantito:</label>
                <input type="text" name="filter_guaranteed_amount" id="filter_guaranteed_amount" maxlength="10" class="form-control" value="<?=(($this->session->userdata('sel_filter_guaranteed_amount'))?$this->session->userdata('sel_filter_guaranteed_amount'):'') ?>">
              </div>
          </div>
          <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Per quietanza:</label>
                <input type="text" name="filter_receipt_amount" id="filter_receipt_amount" maxlength="10" class="form-control" value="<?=(($this->session->userdata('sel_filter_receipt_amount'))?$this->session->userdata('sel_filter_receipt_amount'):'') ?>">
              </div>
          </div>
		  <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Broker:</label>
                <input type="text" name="filter_broker" id="filter_broker" maxlength="60" class="form-control" value="<?=(($this->session->userdata('sel_filter_broker'))?$this->session->userdata('sel_filter_broker'):'') ?>">
              </div>
          </div>
		  <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Oggetto :</label>
                <input type="text" name="filter_object" id="filter_object" maxlength="60" class="form-control" value="<?=(($this->session->userdata('sel_filter_object'))?$this->session->userdata('sel_filter_object'):'') ?>">
              </div>
          </div>
		  <div class="col-sm-3 col-md-3">
              <div class="form-group">
                <label class="form-label">Appendice :</label>
                <input type="text" name="filter_appenice" id="filter_appenice" maxlength="60" class="form-control" value="<?=(($this->session->userdata('sel_filter_appenice'))?$this->session->userdata('sel_filter_appenice'):'') ?>">
              </div>
          </div>
          <div class="col-sm-6 col-md-6 text-right">
              <div class="form-group">
                <label class="form-label">&nbsp;</label>
                <button type="submit" name="submit" id="btnsearch" value="Search" class="btn btn-facebook"><i class="fa fa-search mr-2"></i>Cerca</button>
              </div>
          </div>
      </div>
    </div>
  </div>

  <?php if($search == true): ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="e-table" style="width: 100%;">
          <div class="table-responsive table-lg">
            <table class="table card-table table-vcenter border" width="100%" id="example3">
              <thead>
                <tr>
                  <th>Pratica</th>
                  <th>Contraente</th>
                  <th>Beneficiario</th>
                  <th style="width:12%;">IMP. GARANTITO</th>
                  <th>Emissione</th>
                  <th>Durata</th>
                  <th>Broker</th>
				  <th>Creato da</th>
				  <th style="width:8%;">APP.CE</th>
                  <th>Stato</th>
                  <th>Azioni</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($query) == 0): ?>
                  <!-- <tr><td colspan="9" align="center"><?=$this->no_records?></td></tr> -->
                <?php else: ?>
                  <?php $m = 1; foreach ($query as $row): ?>
                  <tr>
                    <td class="align-middle">
                      <div class="d-flex">
                        <div class="mt-1"><a class="btn-link" target="_blank" href="<?=base_url()?><?=$this->action_url?>/view/<?=$row[$this->{$this->model}->primary_key]?>"><?=$row['p_surety_no']?></a></div>
                      </div>
                    </td>
                    <td class="align-middle">
                      <?php $contractors = $this->{$this->model}->GetContractors($row[$this->{$this->model}->primary_key]); ?>
                      <?php $str_contractor = ''; $m=0; foreach($contractors as $b): ?>
                        <?php 
                          if($m == 0):
                            $str_contractor = $b['pc_contractor_name'];
                          else:
                            $str_contractor .= '<br>'.$b['pc_contractor_name'];
                          endif; 
                        ?>
                      <?php $m++; endforeach; ?>
                      <span class="font-weight-bold"><?=$str_contractor?></span>
                    </td>
                    <td class="align-middle">
                      <?php $beneficiaries = $this->{$this->model}->GetBeneficiaries($row[$this->{$this->model}->primary_key]); //print_r($beneficiaries); ?>
                      <?php $str_beneficiary = ''; $m=0; foreach($beneficiaries as $b): ?>
                        <?php 
                          if($m == 0):
                            $str_beneficiary = $b['pb_beneficiary_name'];
                          else:
                            $str_beneficiary .= '<br>'.$b['pb_beneficiary_name'];
                          endif; 
                        ?>
                      <?php $m++; endforeach; ?>
                      <span class="font-weight-bold"><?=$str_beneficiary?></span>
                    </td>
                    <td class="text-nowrap align-middle"><span class="font-weight-bold">€ <?=number_format($row['p_guaranteed_amount'], 2,',','.')?></span></td>
                    <td class="text-nowrap align-middle"><?=$this->functions->EntryDate($row['p_release_date'])?></td>
                    <td class="text-nowrap align-middle">Dal <?=$this->functions->EntryDate($row['p_from_date'])?><br>al <?=$this->functions->EntryDate($row['p_to_date'])?></td>
					 <td class="align-middle">
                      <div class="d-flex">
                        <div class="mt-1"><?=$row['p_broker']?></div>
                      </div>
                    </td>
                    <td>
                        <?php $rsUser = $this->user->GetInfoById($row['updated_by']); ?>
                        <?=$rsUser['user_firstname'].' '.$rsUser['user_lastname']?>
                    </td>
					<td><?php echo "<strong>".str_replace(","," - ",$row['p_rif_code'])."</strong>";?></td>
                    <td class="text-nowrap align-middle">
                      <?php if($row['p_status'] == 0): ?>
                        <span class="badge badge-danger-light badge-pill mt-2 font-weight-semibold"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                      <?php else: ?>
                        <span class="badge badge-success-light badge-pill mt-2 font-weight-semibold"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
					<div class="btn-group">
                        <a href="#" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opzioni <i class="fa fa-angle-down"></i></a>
                        <div class="dropdown-menu">
                      <?php $rsUpdateUser = $this->user->GetInfoById($row['is_update_mode_user']); ?>
                      <?php $update_user = $rsUpdateUser['user_firstname'].' '.$rsUpdateUser['user_lastname']?>
                      <?php if($row['is_update_mode'] == 1 && $row['is_update_mode_user'] != $this->session->userdata('id')): ?>
                          <a class="dropdown-item" href="javascript: void(0);" onclick="$('#updateuser').html('<?=$update_user?>');" data-toggle="modal" data-target="#myModal" data-original-title="Modifica"><i class="fe fe-edit mr-2"></i>Modifica</a>
                      <?php else: ?>
                          <a class="dropdown-item" href="<?=base_url()?>practices/edit/<?=$row['p_id']?>" data-toggle="tooltip" data-original-title="Modifica"><i class="fe fe-edit mr-2"></i>Modifica</a>
                      <?php endif; ?>
                    <a class="dropdown-item" href="<?=base_url()?>practices/view/<?=$row['p_id']?>" data-toggle="tooltip" data-original-title="Visualizza"><i class="fe fe-eye mr-2"></i>Visualizza</a>    
					   </div>
					</div>
				   </td>
                  </tr>
                  <?php $m++; endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="pk_id" id="pk_id" />
            <input type="hidden" name="status" id="status" />
          </div>
        </div>
        <?=form_close()?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-body text-center">
        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="80" viewBox="0 0 24 24" width="80">
          <path d="M4.47 19h15.06L12 5.99 4.47 19zM13 18h-2v-2h2v2zm0-4h-2v-4h2v4z" opacity=".3" fill="none"></path>
          <path d="M1 21h22L12 2 1 21zm3.47-2L12 5.99 19.53 19H4.47zM11 16h2v2h-2zm0-6h2v4h-2z" fill="#dc3545"></path>
        </svg>
        <h4 class="text-danger fs-20 font-weight-semibold">Sessione Attiva</h4>
        <progress id="custom-bar" class="custom-progress mb-4 wd-70p mt-3" max="100" value="100">0%</progress>
        <p class="mb-4 mx-4">il file selizionato è già utilizzato dall'utente: <strong><span id="updateuser"></span></strong> e non può essere aperto. Grazie.</p>
        <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>
<!-- /Modal -->
