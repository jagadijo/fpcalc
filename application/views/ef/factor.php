<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Environmental Factors</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<h3>Project : <?php echo $project->project_name?></h3>
		<?php echo validation_errors();?>
		<?php echo $this->session->flashdata('message');?>
		<div class="table-responsive">
		<?php echo form_open();?>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 5%">#</th>
						<th style="width: 25%">Rating (0, 1, 2, 3, 4, 5)</th>
						<th>Environmental Factor</th>
					</tr>
				</thead>
				<tbody>
<?php
if (! empty($factor)) {
   $no = 0;
   foreach ($factor as $value) {
      $no ++;
      ?>
					<tr>
						<td><?php echo $no;?></td>
						<td>
							<div class="form-group">
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 0, ($value->trans_rating == 0)?TRUE:FALSE)?>0</label>
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 1, ($value->trans_rating == 1)?TRUE:FALSE)?>1</label>
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 2, ($value->trans_rating == 2)?TRUE:FALSE)?>2</label>
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 3, ($value->trans_rating == 3)?TRUE:FALSE)?>3</label>
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 4, ($value->trans_rating == 4)?TRUE:FALSE)?>4</label>
								<label class="radio-inline"><?php echo form_radio('trans_rating['.$value->ef_id.']', 5, ($value->trans_rating == 5)?TRUE:FALSE)?>5</label>
							</div>
						</td>
						<td><?php echo $value->ef_subject;?></td>
					</tr>
<?php
   }
} else {
   ?>
					<tr>
						<td colspan="3" style="text-align: center; font-style: italic;">--
							Data Not Found --</td>
					</tr>
<?php
}
?>
				</tbody>
			</table>
			<?php echo anchor('ef', 'Back', 'class="btn btn-default"')?>
		   <?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?>
			<?php echo form_close();?>
		</div>
		<!-- /.table-responsive -->
	</div>
</div>
<!-- /.row -->