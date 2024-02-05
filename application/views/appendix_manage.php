<div class="page-header">
  <div class="page-leftheader">
    <h4 class="page-title">Appendice</h4>
  </div>
</div>
<div class="row">
  <div class="col-lg-12" width="800px;">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-4">
            <a href="<?= base_url() . $this->add_url ?>" class="btn btn-primary"><i class="fe fe-plus"></i> Aggiungi Appendice</a>
          </div>
        </div>
        <?php if ($this->session->flashdata('success_notification')) : ?>
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <?= $this->session->flashdata('success_notification') ?>
          </div>
        <?php elseif ($this->session->flashdata('error_notification')) : ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <?= $this->session->flashdata('error_notification') ?>
          </div>
        <?php endif; ?>
        <?= form_open(site_url($this->redirect_url), 'name="listing-form" id="listing-form" enctype="multipart/form-data"'); ?>
        <div class="e-table">
          <div class="table-responsive table-lg">
            <table class="table card-table table-vcenter border" width="100%" id="example1">
              <thead>
                <tr>
                  <th>RIF Cod.</th>
                  <th>CONTRAENTE</th>
                  <th>DATA</th>
                  <th>CORRISPETTIVO</th>
                  <th>BROKER</th>
                  <th>SCADENZA</th>
                  <th>CREATO DA</th>
                  <th>Stato</th>
                  <th>Opzioni</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($query) == 0) : ?>
                  <!-- <tr><td colspan="9" align="center"><?= $this->no_records ?></td></tr> -->
                <?php else : ?>
                  <?php
                  $m = 1;
                  $currency_symbol = "";
                  foreach ($query as $row) :
                    /* copy from practice based on rif code */
                    $p_data = getPracticeData($row['rif_codice']);
                    //echo "<pre>";print_r($p_data);
                    /* get Practice contractor */
                    if (isset($p_data->p_id) && $p_data->p_id != "") {
                      $contractor_data = getPracticeContractor($p_data->p_id);
                      // echo "<pre>";print_r($contractor_data);exit;
                    } else {
                      $contractor_data = null;
                    }
                  ?>
                    <tr>
                      <td class="align-middle">
                        <div class="d-flex">
                          <div class="mt-1"><a class="btn-link" href="<?= base_url() ?><?= $this->action_url ?>/view/<?= $row[$this->{$this->model}->primary_key] ?>"><?= $row['rif_codice'] ?></a></div>
                        </div>
                      </td>
                      <td class="align-middle contracter">
                        <?php
                        if (isset($contractor_data->pc_contractor_name) && $contractor_data->pc_contractor_name != "") {
                          echo $contractor_data->pc_contractor_name;
                        } else {
                        ?>
                          <div class="font-weight-bold" align="center"> - </div>
                        <?php
                        }
                        ?>

                      </td>
                      <td class="align-middle">
                        <?php echo date('d/m/Y', strtotime($row['created_at'])); ?>
                      </td>
                      <td class="text-nowrap align-middle">
                        <?php
                        if ($row['currency_symbol'] == "euro") {
                          $currency_symbol = "&euro;";
                        }
                        if ($row['currency_symbol'] == "doller") {
                          $currency_symbol = "$";
                        }

                        ?>
                        <span class="font-weight-bold"><?php echo $currency_symbol; ?> <?= $row['corrispe'] ?></span>
                      </td>
                      <td class="text-nowrap align-middle broker">
                        <?php
                        if (isset($p_data->p_broker) && $p_data->p_broker != "") {
                          echo $p_data->p_broker;
                        } else {
                        ?>
                          <div class="font-weight-bold" align="center"> - </div>
                        <?php
                        }
                        ?>
                      </td>
                      <td class="text-nowrap align-middle">
                        <?php
                        if (isset($row['expiration']) && $row['expiration'] != "") {
                          echo date('d/m/Y', strtotime($row['expiration']));
                        } else {
                        ?>
                          <div class="font-weight-bold" align="center"> - </div>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <?php $rsUser = $this->user->GetInfoById($row['updated_by']); ?>
                        <?= $rsUser['user_firstname'] . ' ' . $rsUser['user_lastname'] . '<br>' . date('d/m/Y H:i', strtotime($row['updated_at'])) ?>
                      </td>
                      <td class="text-nowrap align-middle">

                        <?php
                        if (isset($row['status']) && $row['status'] != "") {
                          if ($row['status'] == 'BOZZA') : ?>
                            <span class="badge badge-danger-light badge-pill mt-2 font-weight-semibold">Bozza</span>
                          <?php else : ?>
                            <span class="badge badge-success-light badge-pill mt-2 font-weight-semibold">Emessa</span>
                          <?php endif;
                        } else {
                          ?>
                          <div class="font-weight-bold" align="center"> - </div>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="#" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opzioni <i class="fa fa-angle-down"></i></a>
                          <div class="dropdown-menu">
                            <?php $rsUpdateUser = $this->user->GetInfoById($row['is_update_mode_user']); ?>
                            <?php $update_user = $rsUpdateUser['user_firstname'] . ' ' . $rsUpdateUser['user_lastname'] ?>
                            <a class="dropdown-item" href="<?= base_url() ?><?= $this->action_url ?>/view/<?= $row[$this->{$this->model}->primary_key] ?>"><i class="fe fe-eye mr-2"></i> Visualizza</a>
                            <?php if ($row['is_update_mode'] == 1 && $row['is_update_mode_user'] != $this->session->userdata('id')) : ?>
                              <a class="dropdown-item" href="javascript: void(0);" onclick="$('#updateuser').html('<?= $update_user ?>');" data-toggle="modal" data-target="#myModal"><i class="fe fe-edit mr-2"></i> Modifica</a>
                            <?php else : ?>
                              <a class="dropdown-item" href="<?= base_url() ?><?= $this->action_url ?>/edit/<?= $row[$this->{$this->model}->primary_key] ?>"><i class="fe fe-edit mr-2"></i> Modifica</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?= base_url() ?><?= $this->action_url ?>/download/<?= $row[$this->{$this->model}->primary_key] ?>"><i class="fe fe-download mr-2"></i> Genera Bozza</a>
                            <?php if ($row['a_status'] == 1) : ?>
                              <a class="dropdown-item" href="<?= base_url() ?><?= $this->action_url ?>/print/<?= $row[$this->{$this->model}->primary_key] ?>"><i class="fe fe-printer mr-2"></i> Stampa</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?= base_url() ?><?= $this->action_url ?>/duplicate/<?= $row[$this->{$this->model}->primary_key] ?>"><i class="fe fe-copy mr-2"></i> Duplica</a>
                            <?php if (empty($p_data)) { ?>
                              <a class="dropdown-item" href="javascript: void(0);" data-toggle="modal" data-target="#delModal" onclick="$('#pr_id').val('<?= $row[$this->{$this->model}->primary_key] ?>');"><i class="fe fe-trash mr-2"></i> Cancella</a>
                            <?php } ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php $m++;
                  endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="ak_id" id="ak_id" />
            <input type="hidden" name="status" id="status" />
          </div>
        </div>
        <?= form_close() ?>
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
        <p class="mb-4 mx-4">il file selizionato e gia utilizzato dall'utente: <strong><span id="updateuser"></span></strong> e non puo essere aperto. Grazie.</p>
        <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered text-center" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-body text-center p-4">
        <input type="hidden" name="pr_id" id="pr_id" />
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">x</span></button> <i class="fe fe-x-circle fs-100 text-danger lh-1 mb-5 d-inline-block"></i>
        <h4 class="text-danger">Confermi la cancellazione?</h4>
        <button class="btn btn-primary pd-x-25" type="button" onClick="javascript: confirmDeleteRecordForAppendix('<?= $this->action_url ?>', $('#pr_id').val());">OK</button>
        <button aria-label="Close" class="btn btn-danger pd-x-25" data-dismiss="modal" type="button">Annulla</button>
      </div>
    </div>
  </div>
</div>
<!-- /Modal -->

<style>
  .table>thead>tr>th {
    text-align: center;
  }

  td.contracter,
  td.broker {
    font-weight: bold;
  }
</style>