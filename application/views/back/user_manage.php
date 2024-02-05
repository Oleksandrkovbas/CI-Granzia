<div class="page-header">
     <div class="page-leftheader"><h4 class="page-title"></h4></div>
</div>    
<div class="row row-deck">
     <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card overflow-hidden">
               <div class="card-header">
                    <h3 class="card-title">Utenti Registrati</h3>
               </div>
               <div class="card-body pt-0">
                    <!-- <div class="form-group">
                         <div class="row">
                              <div class="col-2">
                                   <input type="text" class="form-control" placeholder="Cerca">
                              </div>
                              <span class="col-auto">
                                   <button class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                              </span>
                         </div>
                    </div> -->
                    <div class="form-group">
                         <div class="row">
                              <div class="col-2">
                                   <a href="<?=base_url().$this->add_url?>" class="btn btn-primary"><i class="fe fe-plus"></i> Aggiungi Utente</a>
                              </div>
                         </div>
                    </div>
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
                   <?=form_open(site_url($this->redirect_url), 'name="listing-form" id="listing-form" enctype="multipart/form-data"'); ?>
                   <div class="e-table">
                    <div class="table-responsive table-lg">
                         
                         
                                        <table id="example1" class="table card-table table-vcenter border table-striped" width="100%">
                                             <thead>
                                                  <tr>
                                                      <th>Utente</th>
                                                      <th>Ultimo Accesso</th>
                                                      <th>Stato</th>
                                                      <th class="text-center">Azioni</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                  <?php if(count($query) == 0): ?>
                                                     <!-- <tr><td colspan="4" align="center"><?=$this->no_records?></td></tr> -->
                                                  <?php else: ?>
                                                       <?php $m = 1; foreach ($query as $row): ?>
                                                       <tr>
                                                            <td>
                                                                 <?php if($row['user_image'] != '' && file_exists(USERSPATH.$row['user_image'])): ?>
                                                                      <img class="w-6 h-6 brround mr-3" src="<?=base_url()?>uploads/users/thumb/<?=$row['user_image']?>" alt="media1" />
                                                                 <?php else: ?>
                                                                      <img class="w-6 h-6 brround mr-3" src="<?=base_url()?>images/admin.jpg" alt="media1" />
                                                                 <?php endif; ?>
                                                                 <?=$row['user_firstname'].' '.$row['user_lastname']?>
                                                            </td>
                                                            <td class="text-muted">
                                                                 <?php if($row['user_last_login'] == '0000-00-00 00:00:00'): ?>
                                                                      Not logged in
                                                                 <?php else: ?>
                                                                      <?=date('d/m/Y H:i', strtotime($row['user_last_login']))?>
                                                                 <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                 <?php if($row['user_status'] == 1): ?>
                                                                      <span class="text-success">Attivo</span>
                                                                 <?php else: ?>
                                                                      <span class="text-danger">Disattivo</span>
                                                                 <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                 <a href="<?=base_url()?><?=$this->action_url?>/edit/<?=$row[$this->{$this->model}->primary_key]?>" data-toggle="tooltip" data-original-title="Modifica">
                                                                      <svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                                                           <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                           <path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path>
                                                                      </svg>
                                                                 </a>
                                                                 <a href="javascript: void(0);" data-toggle="modal" data-target="#delModal" onclick="$('#user_id').val('<?=$row[$this->{$this->model}->primary_key]?>');" data-toggle="tooltip" data-original-title="Cancella"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M8 9h8v10H8z" opacity=".3" fill="none"></path><path d="M15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z" fill="#ef4b4b"></path></svg></a>
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

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered text-center" role="document">
     <div class="modal-content tx-size-sm">
       <div class="modal-body text-center p-4">
         <input type="hidden" name="user_id" id="user_id" />
         <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button> <i class="fe fe-x-circle fs-100 text-danger lh-1 mb-5 d-inline-block"></i>
         <h4 class="text-danger">Confermi la cancellazione?</h4>
         <button class="btn btn-primary pd-x-25" type="button" onClick="javascript: confirmDeleteRecord('<?=$this->action_url?>', $('#user_id').val());">OK</button>
         <button aria-label="Close" class="btn btn-danger pd-x-25" data-dismiss="modal" type="button">Annulla</button>
       </div>
     </div>
   </div>
</div>