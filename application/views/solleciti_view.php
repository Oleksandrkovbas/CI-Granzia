<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title">Solleciti</h4>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<?php if ($this->session->flashdata('success_notification')) : ?>
					<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?= $this->session->flashdata('success_notification') ?>
					</div>
				<?php elseif ($this->session->flashdata('error_notification')) : ?>
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?= $this->session->flashdata('error_notification') ?>
					</div>
				<?php endif; ?>
				<?= form_open(site_url('solleciti/index'), 'name="listing-form" id="listing-form" enctype="multipart/form-data"'); ?>
				<div class="row">
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label">Atto di Fideiussione e Appendice:</label>
							<input type="text" name="p_surety_no" id="p_surety_no" required class="form-control" value="<?= (($this->session->userdata('p_surety_no')) ? $this->session->userdata('p_surety_no') : '') ?>">
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label">Emessa dal:</label>
							<input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="p_from_date" id="from_date" required value="<?= (($this->session->userdata('p_from_date')) ? $this->session->userdata('p_from_date') : '') ?>">
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label">al:</label>
							<input class="form-control fc-datepicker" placeholder="GG/MM/AAAA" type="text" name="p_to_date" id="to_date" required value="<?= (($this->session->userdata('p_to_date')) ? $this->session->userdata('p_to_date') : '') ?>">
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label">Broker:</label>
							<input type="text" name="broker" id="broker" required class="form-control" value="<?= (($this->session->userdata('broker')) ? $this->session->userdata('broker') : '') ?>">
						</div>
					</div>
				</div>

				<br>
				<div class="row">
					<div class="col" align="center">
						<button type="submit" class="btn btn-primary" value="Export" name="submit"> <i class="fe fe-download mr-2"></i> Estrai</button>
					</div>
				</div>
				<br>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>