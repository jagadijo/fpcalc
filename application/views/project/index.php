<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Projects</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
	<?php echo $this->session->flashdata('message');?>
	<p><?php echo btn_add('project/add', 'Add a project');?></p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 5%">#</th>
						<th style="width: 10%">Action</th>
						<th>Project Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
<?php
if (! empty($project)) {
	$no = 0;
	foreach ($project as $value) {
		$no ++;
		?>
					<tr>
						<td><?php echo $no;?></td>
						<td>
							<?php echo btn_edit('project/edit/'.$value->project_id);?>
							<?php echo btn_delete('project/delete/'.$value->project_id);?>
						</td>
						<td><?php echo $value->project_name;?></td>
						<td><?php echo $value->project_description;?></td>
					</tr>
<?php
	}
} else {
	?>
					<tr>
						<td colspan="4" style="text-align: center;font-style:italic;">-- Data Not Found --</td>
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