<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">LOC Converter</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
	<?php echo $this->session->flashdata('message');?>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 5%">#</th>
						<th style="width: 10%">Action</th>
						<th>Project Name</th>
						<th style="width: 15%">Total LOC Item</th>
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
						<td>
							<?php echo btn_edit('loc/insert/'.$value->project_id);?>
						</td>
						<td><?php echo $value->project_name;?></td>
						<td style="text-align: center;"><?php echo $value->total;?></td>
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
		</div>
		<!-- /.table-responsive -->
	</div>
</div>
<!-- /.row -->