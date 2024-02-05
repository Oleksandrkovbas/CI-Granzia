<div id="b_<?=$rowno?>">
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">Denominazione Beneficiario</label>
			<input class="form-control auto_beneficiary" data-bid="<?=$rowno?>" name="pb_beneficiary_name[]" id="pb_beneficiary_name_<?=$rowno?>" maxlength="200" required placeholder="Inserire Denominazione Beneficiario" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">Indirizzo Beneficiario</label>
			<input class="form-control" name="pb_beneficiary_address[]" id="pb_beneficiary_address_<?=$rowno?>" maxlength="200" required placeholder="Inserire Indirizzo Beneficiario" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<label class="form-label">P.IVA o Codice Fiscale Beneficiario</label>
			<input class="form-control" name="pb_beneficiary_vat_no[]" id="pb_beneficiary_vat_no_<?=$rowno?>" maxlength="30" required placeholder="Inserire P.IVA o Codice Fiscale Beneficiario" value="" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary" onclick="addBeneficiary();">Aggiungi</button>
			<button type="button" class="btn btn-danger" onclick="removeBeneficiaryRow('<?=$rowno?>')">Rimuovere</button>
		</div>
	</div>
</div>