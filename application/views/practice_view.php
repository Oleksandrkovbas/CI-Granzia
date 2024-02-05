<div class="page-header">
	<div class="page-leftheader"><h4 class="page-title">Aggiungi Pratica</h4></div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><div class="card-title">Inserisci Pratica</div></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="form-label">Lingua Atto:</label>
							<label class="form-label"><?=array_search ($entry['p_language'], $this->asset['SD_Language']);?></label>
						</div>
						<div class="form-group">
							<label class="form-label">Atto di Fidejussione N°</label>
							<label class="form-label"><?=$entry['p_surety_no']?></label>
						</div>
						<div class="form-group">
							<label class="form-label">Broker</label>
							<label class="form-label"><?=$entry['p_broker']?></label>
						</div>

						<?php if(count((is_countable($contractors)?$contractors:[])) > 0): ?>
          					<?php $i=1; foreach($contractors as $k => $v): ?>
          						<div id="b_<?=$i?>">
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">Denominazione Contraente</label>
											<label class="form-label"><?=$v['pc_contractor_name']?></label>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">Indirizzo Contraente</label>
											<label class="form-label"><?=$v['pc_contractor_address']?></label>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">P.IVA Contraente</label>
											<label class="form-label"><?=$v['pc_contractor_vat_no']?></label>
										</div>
									</div>
								</div>
          					<?php $i++; endforeach; ?>
          				<?php endif; ?>
          				<hr>
						<?php if(count((is_countable($beneficiaries)?$beneficiaries:[])) > 0): ?>
          					<?php $i=1; foreach($beneficiaries as $k => $v): ?>
          						<div id="b_<?=$i?>">
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">Denominazione Beneficiario</label>
											<label class="form-label"><?=$v['pb_beneficiary_name']?></label>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">Indirizzo Beneficiario</label>
											<label class="form-label"><?=$v['pb_beneficiary_address']?></label>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<label class="form-label">P.IVA Beneficiario</label>
											<label class="form-label"><?=$v['pb_beneficiary_vat_no']?></label>
										</div>
									</div>
								</div>
          					<?php $i++; endforeach; ?>
          				<?php endif; ?>
						<hr>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="form-label">A Garanzia: Oggetto della Fidejussione</label>
								<label class="form-label"><?=preg_replace('/font-size.+?;/', "", $entry['p_surety_object']);?></label>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Importo garantito</label>
							<label class="form-label"><?=$entry['p_guaranteed_amount_currency'].' '.number_format($entry['p_guaranteed_amount'], 2, ',', '.').' ['.$entry['p_guaranteed_amount_words'].']'?></label> 
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label class="form-label">Durata dal</label>
								<label class="form-label"><?=$this->functions->EntryDate($entry['p_from_date'])?></label>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<label class="form-label">al</label>
									<label class="form-label"><?=$this->functions->EntryDate($entry['p_to_date'])?></label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="form-label">Emessa il</label>
								<label class="form-label"><?=$this->functions->EntryDate($entry['p_release_date'])?></label>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Per quietanza</label>
							<label class="form-label"><?=$entry['p_receipt_amount_currency'].' '.number_format($entry['p_receipt_amount'], 2, ',', '.').' ['.$entry['p_receipt_amount_words'].']'?></label>
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