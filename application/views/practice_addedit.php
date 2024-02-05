<div class="page-header">
	<div class="page-leftheader"><h4 class="page-title">Aggiungi Pratica</h4></div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><div class="card-title">Inserisci Pratica</div></div>
			<?php if($Action == 'Add'): ?>
                <?=form_open(site_url($this->add_url), 'name="users-form" onsubmit="return validateUserForm()"  enctype="multipart/form-data"'); ?>
            <?php else: ?>
                <?=form_open(site_url($this->edit_url), 'name="users-form" class="form-horizontal ls_form" enctype="multipart/form-data"'); ?>
            <?php endif; ?>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="form-label">Lingua Atto:</label>
							<select name="p_language" id="p_language" class="form-control select2" required>
								<?php foreach($this->asset['SD_Language'] as $key => $val): ?>
									<?php if($val == $entry['p_language']): ?>
										<option value="<?=$val?>" selected="selected"><?=$this->asset['SD_LanguageFlag'][$val]?>&nbsp;&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?=$key?></option>
									<?php else: ?>
										<option value="<?=$val?>"><?=$this->asset['SD_LanguageFlag'][$val]?>&nbsp;&nbsp;<?=$key?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Atto di Fidejussione N°</label>
							<input class="form-control" placeholder="Inserire Numero o Bozza" name="p_surety_no" id="p_surety_no" maxlength="20" required value="<?=(isset($entry['p_surety_no'])?$entry['p_surety_no']:'') ?>" />
						</div>
						
						<div class="form-group">
							<label class="form-label">Broker</label>
							<input class="form-control" placeholder="Inserire Numero del Broker" name="p_broker" id="p_broker" maxlength="20" required value="<?=(isset($entry['p_broker'])?$entry['p_broker']:'') ?>" />
						</div>
						
						<?php if($Action == 'Add'): ?>
							<div id="c_1">
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">Denominazione Contraente</label>
										<input class="form-control auto_contractor" data-cid="1" name="pc_contractor_name[]" id="pc_contractor_name_1" maxlength="200" placeholder="Inserire Contraente" required value="" />
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">Indirizzo Contraente</label>
										<input class="form-control" name="pc_contractor_address[]" id="pc_contractor_address_1" maxlength="200" required placeholder="Inserire Indirizzo" value="" />
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">P.IVA o Codice Fiscale Contraente</label>
										<input class="form-control" name="pc_contractor_vat_no[]" id="pc_contractor_vat_no_1" maxlength="30" required placeholder="Inserire P.IVA" value="" />
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<input type="hidden" name="ccount" id="ccount" value="1">
										<input type="hidden" name="contractor_count" id="contractor_count" value="1">
										<button type="button" class="btn btn-primary" onclick="addContractor();">Aggiungi</button>
									</div>
								</div>
							</div>
						<?php else: ?>
							<?php if(count((is_countable($contractors)?$contractors:[])) > 0): ?>
              					<?php $i=1; foreach($contractors as $k => $v): ?>
              						<div id="c_<?=$i?>">
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">Denominazione Contraente</label>
												<input class="form-control auto_contractor" data-cid="<?=$i?>" name="pc_contractor_name[]" id="pc_contractor_name_<?=$i?>" maxlength="200" required placeholder="Inserire Contraente" value="<?=$v['pc_contractor_name']?>" />
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">Indirizzo Contraente</label>
												<input class="form-control" name="pc_contractor_address[]" id="pc_contractor_address_<?=$i?>" maxlength="200" required placeholder="Inserire Indirizzo" value="<?=$v['pc_contractor_address']?>" />
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">P.IVA o Codice Fiscale Contraente</label>
												<input class="form-control" name="pc_contractor_vat_no[]" id="pc_contractor_vat_no_<?=$i?>" maxlength="30" required placeholder="Inserire P.IVA" value="<?=$v['pc_contractor_vat_no']?>" />
											</div>
										</div>
										<?php //if(count($contractors) == 2): ?>
											
												<div class="form-group row">
													<div class="col-md-12">
														<button type="button" class="btn btn-primary" onclick="addContractor();">Aggiungi</button>
														<?php if($i > 1): ?>
															<button type="button" class="btn btn-danger" onclick="removeContractorRow('<?=$i?>')">Rimuovere</button>
														<?php endif; ?>
													</div>
												</div>

										<?php //else: ?>
											<!-- <div class="form-group row">
												<div class="col-md-12">
													
												</div>
											</div> -->
										<?php //endif; ?>
									</div>
              					<?php $i++; endforeach; ?>
              					<input type="hidden" name="ccount" id="ccount" value="<?=count($contractors);?>">
              					<input type="hidden" name="contractor_count" id="contractor_count" value="<?=count($contractors);?>">
              				<?php endif; ?>
						<?php endif; ?>

						<div id="contractordiv"></div>

						<hr>

						<!-- <div class="form-group row">
							<div class="col-md-4">
								<label class="form-label">Denominazione Contraente</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_contractor_name_font_size" id="p_contractor_name_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_contractor_name_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_contractor_name_y_coordinate" id="p_contractor_name_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_contractor_name_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
							<div class="col-md-4">
								<label class="form-label">Indirizzo Contraente</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_contractor_addr_font_size" id="p_contractor_addr_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_contractor_addr_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_contractor_addr_y_coordinate" id="p_contractor_addr_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_contractor_addr_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
							<div class="col-md-4">
								<label class="form-label">P.IVA o Codice Fiscale Contraente</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_contractor_vat_font_size" id="p_contractor_vat_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_contractor_vat_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_contractor_vat_y_coordinate" id="p_contractor_vat_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_contractor_vat_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
						</div>

						<hr> -->

						<?php if($Action == 'Add'): ?>
							<div id="b_1">
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">Denominazione Beneficiario</label>
										<input class="form-control auto_beneficiary" data-bid="1" name="pb_beneficiary_name[]" id="pb_beneficiary_name_1" maxlength="200" required placeholder="Inserire Denominazione Beneficiario" value="" />
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">Indirizzo Beneficiario</label>
										<input class="form-control" name="pb_beneficiary_address[]" id="pb_beneficiary_address_1" maxlength="200" required placeholder="Inserire Indirizzo Beneficiario" value="" />
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label class="form-label">P.IVA o Codice Fiscale Beneficiario</label>
										<input class="form-control" name="pb_beneficiary_vat_no[]" id="pb_beneficiary_vat_no_1" maxlength="30" required placeholder="Inserire P.IVA o Codice Fiscale Beneficiario" value="" />
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<input type="hidden" name="bcount" id="bcount" value="1">
										<input type="hidden" name="beneficiary_count" id="beneficiary_count" value="1">
										<button type="button" class="btn btn-primary" onclick="addBeneficiary();">Aggiungi</button>
									</div>
								</div>
							</div>
						<?php else: ?>
							<?php if(count((is_countable($beneficiaries)?$beneficiaries:[])) > 0): ?>
              					<?php $i=1; foreach($beneficiaries as $k => $v): ?>
              						<div id="b_<?=$i?>">
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">Denominazione Beneficiario</label>
												<input class="form-control auto_beneficiary" data-bid="<?=$i?>" name="pb_beneficiary_name[]" id="pb_beneficiary_name_<?=$i?>" maxlength="200" required placeholder="Inserire Denominazione Beneficiario" value="<?=$v['pb_beneficiary_name']?>" />
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">Indirizzo Beneficiario</label>
												<input class="form-control" name="pb_beneficiary_address[]" id="pb_beneficiary_address_<?=$i?>" maxlength="200" required placeholder="Inserire Indirizzo Beneficiario" value="<?=$v['pb_beneficiary_address']?>" />
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label class="form-label">P.IVA o Codice Fiscale Beneficiario</label>
												<input class="form-control" name="pb_beneficiary_vat_no[]" id="pb_beneficiary_vat_no_<?=$i?>" maxlength="30" required placeholder="Inserire P.IVA o Codice Fiscale Beneficiario" value="<?=$v['pb_beneficiary_vat_no']?>" />
											</div>
										</div>
										<?php //if(count($beneficiaries) == 2): ?>
											
												<div class="form-group row">
													<div class="col-md-12">
														<button type="button" class="btn btn-primary" onclick="addBeneficiary();">Aggiungi</button>
														<?php if($i > 1): ?>
															<button type="button" class="btn btn-danger" onclick="removeBeneficiaryRow('<?=$i?>')">Rimuovere</button>
														<?php endif; ?>
													</div>
												</div>
											
										<?php //else: ?>
											<!-- <div class="form-group row">
												<div class="col-md-12">
													
												</div>
											</div> -->
										<?php //endif; ?>
									</div>
              					<?php $i++; endforeach; ?>
              					<input type="hidden" name="bcount" id="bcount" value="<?=count($beneficiaries);?>">
              					<input type="hidden" name="beneficiary_count" id="beneficiary_count" value="<?=count($beneficiaries);?>">
              				<?php endif; ?>
						<?php endif; ?>

						<div id="beneficiarydiv"></div>

						<hr>

						<!-- <div class="form-group row">
							<div class="col-md-4">
								<label class="form-label">Denominazione Beneficiario</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_beneficiary_name_font_size" id="p_beneficiary_name_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_beneficiary_name_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_beneficiary_name_y_coordinate" id="p_beneficiary_name_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_beneficiary_name_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
							<div class="col-md-4">
								<label class="form-label">Indirizzo Beneficiario</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_beneficiary_addr_font_size" id="p_beneficiary_addr_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_beneficiary_addr_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_beneficiary_addr_y_coordinate" id="p_beneficiary_addr_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_beneficiary_addr_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
							<div class="col-md-4">
								<label class="form-label">P.IVA o Codice Fiscale Beneficiario</label>
								<div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Font Size:</label>
				                      <input type="text" name="p_beneficiary_vat_font_size" id="p_beneficiary_vat_font_size" onkeypress="return isNumberKey(event)" maxlength="5" required class="form-control" value="<?=$entry['p_beneficiary_vat_font_size']?>">
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-12">
				                    <div class="form-group">
				                      <label class="form-label">Y Coordinate:</label>
				                      <input type="text" name="p_beneficiary_vat_y_coordinate" id="p_beneficiary_vat_y_coordinate" onkeypress="return isNumberKey(event)" maxlength="6" required class="form-control" value="<?=$entry['p_beneficiary_vat_y_coordinate']?>">
				                    </div>
				                </div>
							</div>
						</div> -->

						<!-- <hr> -->

						<!-- <div class="form-group">
							<label class="form-label">Denominazione Beneficiario</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Inserire Denominazione Beneficiario"> <div class="input-group-append"> <button type="button" class="btn btn-primary">Aggiungi</button> <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle" aria-expanded="false"></button> <div class="dropdown-menu dropdown-menu-right" style=""> <a class="dropdown-item" href="javascript:void(0)">Nuovo</a></div></div></div></div>

						<div class="form-group"> <label class="form-label">Indirizzo Beneficiario</label> <div class="input-group"> <input type="text" class="form-control" placeholder="Inserire Indirizzo Beneficiario"> <div class="input-group-append"> <button type="button" class="btn btn-primary">Aggiungi</button> <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle" aria-expanded="false"></button> <div class="dropdown-menu dropdown-menu-right" style=""> <a class="dropdown-item" href="javascript:void(0)">Nuovo</a></div></div></div></div>

						<div class="form-group"> <label class="form-label">P.IVA o Codice Fiscale Beneficiario</label> <div class="input-group"> <input type="text" class="form-control" placeholder="Inserire P.IVA o Codice Fiscale Beneficiario"> <div class="input-group-append"> <button type="button" class="btn btn-primary">Aggiungi</button> <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle" aria-expanded="false"></button> <div class="dropdown-menu dropdown-menu-right" style=""> <a class="dropdown-item" href="javascript:void(0)">Nuovo</a></div></div></div></div> -->

						<div class="form-group row float-right">
						<div class="col-md-12">
								<input type="button" class="btn btn-primary" name="pdf_preview" id="pdf_preview" value="Mostra Anteprima">
								</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
							
								<label class="form-label">A Garanzia: Oggetto della Fidejussione</label>
								<div id="draft_html"></div>
								
								<textarea name="p_surety_object" id="p_surety_object" class="form-control"><?=(isset($entry['p_surety_object'])?$entry['p_surety_object']:'') ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Aggiungi Appendice</label> 
							<div class="row">
								<div class="col-md-6">
									<?php 
										$rif_rs = getRIF();
										// in case if edit practice otherwise consider add practice in else part
										if(isset($entry['p_rif_code']) && $entry['p_rif_code']!=""){
										$elements = explode(',', $entry['p_rif_code']);
									?>
									<select class="select2 related-post form-control" name="appendix_rif[]" multiple>
									<?php 
										foreach($rif_rs as $rif_data){
											$elementToCheck = $rif_data['rif_codice'];
											// check if rif already associated with any practice
											$p_data=checkRifExistInPractice($elementToCheck,$entry['p_id']);
											if(empty($p_data)){
											
									?>
										<option value="<?php echo $rif_data['rif_codice']?>" <?php if(in_array($elementToCheck,$elements)) echo "selected";?>><?php echo $rif_data['rif_codice']?></option>
									<?php
											}
										}
										?>
									</select>
									<?php
										}
										else{
									?>
										<select class="select2 related-post form-control" name="appendix_rif[]" multiple>
									<?php 
										foreach($rif_rs as $rif_data){
										
											$elementToCheck = $rif_data['rif_codice'];
											// check if rif already associated with any practice
											$p_data=checkRifExistInPractice($elementToCheck,0);
											if(empty($p_data)){
											
									?>
										<option value="<?php echo $rif_data['rif_codice']?>" ><?php echo $rif_data['rif_codice']?></option>
									<?php
											}
										}
										?>
									</select>
									<?php
										
										}
									?>
									
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Importo garantito</label> 
							<div class="row">
								<div class="col-md-2">
									<input class="form-control" name="p_guaranteed_amount_currency" id="p_guaranteed_amount_currency" maxlength="15" placeholder="Inserire Valuta" value="<?=(isset($entry['p_guaranteed_amount_currency'])?$entry['p_guaranteed_amount_currency']:'') ?>" required />
								</div>
								<div class="col-md-10">
									<div class="input-group">
										<input type="text" name="p_guaranteed_amount" id="p_guaranteed_amount" class="form-control" maxlength="10" placeholder="Inserire Importo" value="<?=(isset($entry['p_guaranteed_amount'])?$entry['p_guaranteed_amount']:'') ?>" required onkeypress="return isNumberKey(event)" />
										<span class="input-group-append">
											<input class="btn btn-primary" name="p_guaranteed_amount_words_text" id="p_guaranteed_amount_words_text" type="button" value="<?=(isset($entry['p_guaranteed_amount_words'])?$entry['p_guaranteed_amount_words']:'LETTERE')?>">
										</span>
										<input type="hidden" name="p_guaranteed_amount_words" id="p_guaranteed_amount_words" value="<?=(isset($entry['p_guaranteed_amount_words'])?$entry['p_guaranteed_amount_words']:'') ?>">
									</div>
								</div>
								<!-- <br><div id="risultato" style="text-align:center; font-weight: 600;"></div> -->
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label class="form-label">Durata dal</label>
								<div class="wd-200 mg-b-30">
									<div class="input-group"> 
										<div class="input-group-prepend"> 
											<div class="input-group-text">
												<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
											</div>
										</div>
										<input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="p_from_date" id="p_from_date" <?php if($Action == 'Edit'): ?> value="<?=$this->functions->EntryDate($entry['p_from_date'])?>" <?php endif; ?> required>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<label class="form-label">al</label>
									<div class="wd-200 mg-b-30">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
												</div>
											</div>
											<input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="p_to_date" id="p_to_date" <?php if($Action == 'Edit'): ?> value="<?=$this->functions->EntryDate($entry['p_to_date'])?>" <?php endif; ?> required>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="form-label">Emessa il</label>
								<div class="wd-200 mg-b-30">
									<div class="input-group"> 
										<div class="input-group-prepend"> 
											<div class="input-group-text">
												<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"></path><path d="M4 5.01h16V8H4z" opacity=".3"></path></svg>
											</div>
										</div>
										<input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="p_release_date" id="p_release_date" <?php if($Action == 'Edit'): ?> value="<?=$this->functions->EntryDate($entry['p_release_date'])?>" <?php endif; ?> required>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Per quietanza</label>
							<div class="row">
								<div class="col-md-2">
									<input class="form-control" name="p_receipt_amount_currency" id="p_receipt_amount_currency" maxlength="15" placeholder="Inserire Valuta" value="<?=(isset($entry['p_receipt_amount_currency'])?$entry['p_receipt_amount_currency']:'') ?>" required />
								</div>
								<div class="col-md-10">
									<div class="input-group">
										<input type="text" name="p_receipt_amount" id="p_receipt_amount" class="form-control" maxlength="10" placeholder="Inserire Importo" value="<?=(isset($entry['p_receipt_amount'])?$entry['p_receipt_amount']:'') ?>" required onkeypress="return isNumberKey(event)" />
										<span class="input-group-append">
											<input class="btn btn-primary" type="button" value="<?=(isset($entry['p_receipt_amount_words'])?$entry['p_receipt_amount_words']:'LETTERE') ?>" name="p_receipt_amount_words_text" id="p_receipt_amount_words_text">
										</span>
										<input type="hidden" name="p_receipt_amount_words" id="p_receipt_amount_words" value="<?=(isset($entry['p_receipt_amount_words'])?$entry['p_receipt_amount_words']:'') ?>">
									</div>
								</div>
								<!-- <br><div id="risultato" style="text-align:center"></div> -->
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col">
							<input type="hidden" name="pk_id" value="<?=$entry['p_id']?>" /> 
							<button type="submit" name="submit" id="draft" value="Draft" class="btn btn-facebook"><i class="fa fa-download mr-2"></i>Crea Bozza</button>&nbsp;&nbsp; 
							<button type="submit" name="submit" id="issue" value="Issue" class="btn btn-green"><i class="fa fa-print mr-2"></i>Emetti Pratica</button>&nbsp;&nbsp;
							<?php if($Action == 'Add'): ?>
								<button type="button" class="btn btn-danger" onclick="$(location).attr('href','<?=base_url().$this->redirect_url?>');">Annulla</button>
							<?php else: ?>
								<button type="submit" class="btn btn-danger" name="cancel" value="cancel">Annulla</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?=form_close()?>
		</div>
	</div>
</div>

<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
<input type="hidden" name="pdf_preview_file_name" id="pdf_preview_file_name" value="">
<div class="modal" id="modaldemo3" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
      <div class="modal-header">
        <h6 class="modal-title">Anteprima Bozza PDF</h6>
        <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="closeModaldemo3"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        
		<div id="pdf_draft_cotent">
			<embed src="../../uploads/drafts/Draft-1.pdf" frameborder="0" width="100%" height="600px">
		</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-dismiss="modal" type="button" id="closeModaldemo3">Chiudi</button>
      </div>
    </div>
  </div>
</div>
<?php 
$api_key = $api_data->config_value;?>
<script src="https://cdn.tiny.cloud/1/<?php echo $api_key?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>