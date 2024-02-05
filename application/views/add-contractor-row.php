<div id="c_<?=$rowno?>">
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">Denominazione Contraente</label>
			<input class="form-control auto_contractor" data-cid="<?=$rowno?>" name="pc_contractor_name[]" id="pc_contractor_name_<?=$rowno?>" maxlength="200" required placeholder="Inserire Contraente" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">Indirizzo Contraente</label>
			<input class="form-control" name="pc_contractor_address[]" id="pc_contractor_address_<?=$rowno?>" maxlength="200" required placeholder="Inserire Indirizzo" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">P.IVA o Codice Fiscale Contraente</label>
			<input class="form-control" name="pc_contractor_vat_no[]" id="pc_contractor_vat_no_<?=$rowno?>" maxlength="30" required placeholder="Inserire P.IVA" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary" onclick="addContractor();">Aggiungi</button>
			<button type="button" class="btn btn-danger" onclick="removeContractorRow('<?=$rowno?>')">Rimuovere</button>
		</div>
	</div>
</div>