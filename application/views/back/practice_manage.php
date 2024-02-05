<div class="page-header">
  <div class="page-leftheader"><h4 class="page-title">Pratiche</h4></div>
</div>
<div class="row">
  <div class="col-lg-12" width="800px;">
    <div class="card">
      <div class="card-body">
        <?php if($this->session->flashdata('success_notification')): ?>
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Success:&nbsp;<?=$this->session->flashdata('success_notification')?>
          </div>
        <?php elseif($this->session->flashdata('error_notification')): ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Error:&nbsp;<?=$this->session->flashdata('error_notification')?>
          </div>
        <?php endif; ?>
        <?=form_open(site_url($this->redirect_url), 'name="listing-form" id="listing-form" enctype="multipart/form-data"'); ?>
        <div class="e-table">
          <div class="table-responsive table-lg">
            <table class="table card-table table-vcenter border" width="100%" id="example1">
              <thead>
                <tr>
                  <th>Pratica</th>
                  <th>Contraente</th>
                  <th>Beneficiario</th>
                  <th style="width:12%;">IMP. GARANTITO</th>
                  <th>Emissione</th>
                  <th>Durata</th>
                  <th>Creato da</th>
                  <th>Stato</th>
                  <th>Opzioni</th>
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
                        <div class="mt-1"><a class="btn-link" href="<?=base_url()?><?=$this->action_url?>/view/<?=$row[$this->{$this->model}->primary_key]?>">#<?=$row['p_surety_no']?></a></div>
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
                    <td>
                        <?php $rsUser = $this->user->GetInfoById($row['updated_by']); ?>
                        <?=$rsUser['user_firstname'].' '.$rsUser['user_lastname']?>
                    </td>
                    <td class="text-nowrap align-middle">
                      <?php if($row['p_status'] == 0): ?>
                        <span class="badge badge-danger-light badge-pill mt-2 font-weight-semibold"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                      <?php else: ?>
                        <span class="badge badge-success-light badge-pill mt-2 font-weight-semibold"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="btn-group">
                        <a href="#" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opzioni <i class="fa fa-angle-down"></i></a>
                        <div class="dropdown-menu">
                          <?php $rsUpdateUser = $this->user->GetInfoById($row['is_update_mode_user']); ?>
                          <?php $update_user = $rsUpdateUser['user_firstname'].' '.$rsUpdateUser['user_lastname']?>
                          <a class="dropdown-item" href="<?=base_url()?><?=$this->action_url?>/view/<?=$row[$this->{$this->model}->primary_key]?>"><i class="fe fe-eye mr-2"></i> Visualizza</a>
                          <?php if($row['is_update_mode'] == 1 && $row['is_update_mode_user'] != $this->session->userdata('id')): ?>
                            <a class="dropdown-item" href="javascript: void(0);" onclick="$('#updateuser').html('<?=$update_user?>');" data-toggle="modal" data-target="#myModal"><i class="fe fe-edit mr-2"></i> Modifica</a>
                          <?php else: ?>
                            <a class="dropdown-item" href="<?=base_url()?><?=$this->action_url?>/edit/<?=$row[$this->{$this->model}->primary_key]?>"><i class="fe fe-edit mr-2"></i> Modifica</a>
                          <?php endif; ?>
                          <a class="dropdown-item" href="<?=base_url()?><?=$this->action_url?>/download/<?=$row[$this->{$this->model}->primary_key]?>"><i class="fe fe-download mr-2"></i> Genera Bozza</a>
                          <?php if($row['p_status'] == 1): ?>
                            <a class="dropdown-item" href="<?=base_url()?><?=$this->action_url?>/print/<?=$row[$this->{$this->model}->primary_key]?>"><i class="fe fe-printer mr-2"></i> Stampa</a>
                          <?php endif; ?>
                          <a class="dropdown-item" href="javascript: void(0);" data-toggle="modal" data-target="#delModal" onclick="$('#pr_id').val('<?=$row[$this->{$this->model}->primary_key]?>');"><i class="fe fe-trash mr-2"></i> Cancella</a>
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

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered text-center" role="document">
     <div class="modal-content tx-size-sm">
       <div class="modal-body text-center p-4">
         <input type="hidden" name="pr_id" id="pr_id" />
         <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button> <i class="fe fe-x-circle fs-100 text-danger lh-1 mb-5 d-inline-block"></i>
         <h4 class="text-danger">Confermi la cancellazione?</h4>
         <button class="btn btn-primary pd-x-25" type="button" onClick="javascript: confirmDeleteRecord('<?=$this->action_url?>', $('#pr_id').val());">OK</button>
         <button aria-label="Close" class="btn btn-danger pd-x-25" data-dismiss="modal" type="button">Annulla</button>
       </div>
     </div>
   </div>
</div>