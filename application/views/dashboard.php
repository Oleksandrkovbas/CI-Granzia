<div class="page-header">
     <div class="page-leftheader"><h4 class="page-title">Dashboard</h4></div>
</div>
<div class="row">
     <div class="col-xl-12 col-md-12 col-lg-12">
      <div class="row">
       <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card bg-gradient-info overflow-hidden text-white">
         <div class="card-body pb-0">
          <p class="mb-1">Tutte le Pratiche</p>
          <h2 class="mb-1 font-weight-bold fs-30"><?=$total_practices?></h2>
     </div>
     <div class="chart-wrapper overflow-hidden">
          <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
           <div class="chartjs-size-monitor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
            <div style="position: absolute; width: 1000000px; height: 1000000px; left: 0; top: 0;"></div>
       </div>
       <div class="chartjs-size-monitor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
            <div style="position: absolute; width: 200%; height: 200%; left: 0; top: 0;"></div>
       </div>
  </div>
  <canvas id="area-chart1" class="area-chart chart-dropshadow-dark chartjs-render-monitor" height="70" width="276" style="display: block; width: 276px; height: 70px;"></canvas>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12">
   <div class="card bg-gradient-success overflow-hidden text-white">
    <div class="card-body pb-0">
     <p class="mb-1">Pratiche Emesse</p>
     <h2 class="mb-1 font-weight-bold fs-30"><?=$total_issued_practices?></h2>
</div>
<div class="chart-wrapper overflow-hidden">
     <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
      <div class="chartjs-size-monitor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
       <div style="position: absolute; width: 1000000px; height: 1000000px; left: 0; top: 0;"></div>
  </div>
  <div class="chartjs-size-monitor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
       <div style="position: absolute; width: 200%; height: 200%; left: 0; top: 0;"></div>
  </div>
</div>
<canvas id="area-chart2" class="area-chart chart-dropshadow-dark chartjs-render-monitor" height="70" width="276" style="display: block; width: 276px; height: 70px;"></canvas>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12">
   <div class="card bg-gradient-danger overflow-hidden text-white">
    <div class="card-body pb-0">
     <p class="mb-1">Pratiche in Bozza</p>
     <h2 class="mb-1 font-weight-bold fs-30"><?=$total_draft_practices?></h2>
</div>
<div class="chart-wrapper overflow-hidden">
     <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
      <div class="chartjs-size-monitor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
       <div style="position: absolute; width: 1000000px; height: 1000000px; left: 0; top: 0;"></div>
  </div>
  <div class="chartjs-size-monitor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
       <div style="position: absolute; width: 200%; height: 200%; left: 0; top: 0;"></div>
  </div>
</div>
<canvas id="area-chart3" class="area-chart chart-dropshadow-dark chartjs-render-monitor" height="70" width="276" style="display: block; width: 276px; height: 70px;"></canvas>
</div>
</div>
</div>

</div>
<hr class="dash1-hr" />


</div>

</div>

<div class="row row-deck">
     <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card overflow-hidden">
             <div class="card-header">
                 <h3 class="card-title">Ultime 10 Pratiche</h3>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive table-lg">
                            <!--<table class="table card-table table-vcenter text-nowrap nowrap border" width="100%" id="example2">-->
							 <table class="table card-table table-vcenter border" width="100%" id="example1">
                                <thead>
                                    <tr class="bold border-bottom" role="row">
                                         <th>Numero Pratica</th>
                                         <th>Data</th>
                                         <th>Importo Garantito</th>
                                         <th>Quietanza</th>
                                         <th>Creato da</th>
                                         <th>Stato</th>
                                         <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
									//echo "<pre>";print_r($recent_practices);
									foreach($recent_practices as $row): ?>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><img class="w-6 h-6 brround mr-3" src="<?=base_url()?>assets/images/file.png" alt="media1" /> <?=$row['p_surety_no']?></td>
                                            <td class="text-muted">
                                                <?php setlocale(LC_TIME, 'it_IT');?>
                                                <?php echo (strftime("%d %B %Y", strtotime($row['p_release_date']))); ?>
                                            </td>
                                            <td class="text-muted">€ <?=number_format($row['p_guaranteed_amount'], 2,',','.')?></td>
                                            <td class="text-muted">€ <?=number_format($row['p_receipt_amount'], 2,',','.')?></td>
                                            <td>
                                                <?php $rsUser = $this->user->GetInfoById($row['updated_by']); ?>
                                                <?=$rsUser['user_firstname'].' '.$rsUser['user_lastname']?>
                                            </td>
                                            <td>
                                                <?php if($row['p_status'] == 0): ?>
                                                    <span class="text-danger"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                                                <?php else: ?>
                                                    <span class="text-success"><?=$this->asset['SD_Status'][$row['p_status']]?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php $rsUpdateUser = $this->user->GetInfoById($row['is_update_mode_user']); ?>
                                                <?php $update_user = $rsUpdateUser['user_firstname'].' '.$rsUpdateUser['user_lastname']?>
                                                <?php if($row['is_update_mode'] == 1 && $row['is_update_mode_user'] != $this->session->userdata('id')): ?>
                                                    <a href="javascript: void(0);" onclick="$('#updateuser').html('<?=$update_user?>');" data-toggle="modal" data-target="#myModal" data-original-title="Modifica">
                                                        <svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                            <path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path>
                                                       </svg>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?=base_url()?>practices/edit/<?=$row['p_id']?>" data-toggle="tooltip" data-original-title="Modifica">
                                                        <svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                            <path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path>
                                                       </svg>
                                                    </a>
                                                <?php endif; ?>
                                              <a href="<?=base_url()?>practices/view/<?=$row['p_id']?>" data-toggle="tooltip" data-original-title="Visualizza"><svg class="svg-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16" height="16" viewBox="0 0 50 50" style="overflow:visible;enable-background:new 0 0 50 50;" xml:space="preserve"><defs></defs><g><path d="M84.27,20.09c-23.4-26.86-60.37-26.72-83.64,0c-0.85,0.94-0.85,2.37,0,3.32c23.4,26.86,60.37,26.72,83.64,0C85.12,22.47,85.12,21.04,84.27,20.09z M42.45,39.16c-22.88-0.41-22.88-34.42,0-34.82C65.34,4.75,65.33,38.76,42.45,39.16zM44.42,16.89c0-2.5,1.24-4.7,3.13-6.06c-7.9-4.38-18.29,1.98-18.06,11.03c-0.05,15,22.27,16.79,24.66,2.1
                                                  C49.15,25.57,44.42,21.78,44.42,16.89z"/></g></svg></a>              
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
