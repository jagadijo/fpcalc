<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">LOC Converter</h2>
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
						<th style="width: 6%">Check</th>
						<th>Language</th>
						<th style="width: 25%">Average SLOC per Function Point</th>
					</tr>
				</thead>
				<tbody>
<?php
if (! empty($lang)) {
   $no = 0;
   foreach ($lang as $value) {
      $no ++;
      ?>
               <tr>
						<td><?php echo $no;?></td>
						<td style="text-align: center;">
						   <input type="checkbox">
						</td>
						<td><?php echo $value->lang_name?></td>
						<td style="text-align: center;"><?php echo $value->lang_value?></td>
					</tr>
<?php
   }
} else {
   ?>
				  <tr>
						<td colspan="4" style="text-align: center; font-style: italic;">--
							Data Not Found --</td>
					</tr>
<?php
}
?>
				</tbody>
			</table>
			<?php echo anchor('loc', 'Back', 'class="btn btn-default"')?>
		   <?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<!-- /.row -->