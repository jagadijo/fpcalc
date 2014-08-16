<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Projects</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-6">
		<h3><?php echo empty($project->project_id) ? 'Add a new project' : 'Edit a project'?></h3>
		<?php echo form_open()?>
		<div class="form-group">
			<label>Project</label> 
			<?php echo form_input('project_name', set_value('project_name', $project->project_name), 'placeholder="Project name" class="form-control" required')?>
			<div class="help-block"><?php echo form_error('project_name')?></div>
		</div>
		<div class="form-group">
			<label>Description</label>
			<?php echo form_textarea('project_description', set_value('project_description', $project->project_description), 'placeholder="Description" class="form-control" style="height:8em"')?>
		</div>
		<?php echo anchor('project', 'Back', 'class="btn btn-default"')?>
		<?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?>
		<?php echo form_close();?>
	</div>
</div>