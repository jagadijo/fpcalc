<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Functions in Each Category</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<h3>Project : <?php echo $project->project_name;?></h3>
	<?php echo $this->session->flashdata('message');?>
		<p>
			<?php echo anchor('cwf', 'Back', 'title="Back" class="btn btn-default"')?>
			<?php echo btn_add('cwf/add_function/'.$project_id, 'Add a activity');?>
		</p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 5%">#</th>
						<th style="width: 10%">Action</th>
						<th>Activity</th>
						<th style="width: 12%">Item/Data</th>
						<th style="width: 12%">File/Record</th>
						<th style="width: 12%">Complexity</th>
					</tr>
				</thead>
				<tbody>
<?php
if (! empty($function)) {
	$no = 0;
	foreach ($function as $value) {
		$no ++;
		?>
					<tr>
						<td><?php echo $no;?></td>
						<td>
							<?php echo btn_edit('cwf/edit_function/'.$project_id.'/'.$value->function_id.'/'.$value->function_cwf_id.'/'.$value->function_complexity_id);?>
							<?php echo btn_delete('cwf/delete_function/'.$project_id.'/'.$value->function_id.'/'.$value->function_cwf_id.'/'.$value->function_complexity_id);?>
						</td>
						<td>
							<?php echo anchor('cwf/edit_function/'.$project_id.'/'.$value->function_id.'/'.$value->function_cwf_id.'/'.$value->function_complexity_id, $value->function_name);?><br />
							<strong>Category : </strong><?php echo $value->cwf_name;?>
						</td>
						<td style="text-align: right;"><?php echo $value->function_item_data;?></td>
						<td style="text-align: right;"><?php echo $value->function_file_record;?></td>
						<td><?php echo $value->function_complexity;?></td>
					</tr>
<?php
	}
} else {
	?>
					<tr>
						<td colspan="6" style="text-align: center; font-style: italic;">--
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