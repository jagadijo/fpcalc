<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Functions in Each Category</h2>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<h3><?php echo empty($function->function_id) ? 'Add a new activity' : 'Edit a activity'?></h3>
		<?php echo form_open()?>
		<div class="form-group">
			<label>Activity</label> 
			<?php echo form_input('function_name', set_value('function_name', $function->function_name), 'placeholder="Activity / Function Name" class="form-control" required')?>
			<div class="help-block"><?php echo form_error('function_name')?></div>
		</div>
		<div class="form-group">
			<label>Item/Data</label> <input type="number"
				name="function_item_data"
				value="<?php echo set_value('function_item_data', $function->function_item_data);?>"
				style="text-align: right;" class="form-control" min="1" max=""
				required>
			<div class="help-block"><?php echo form_error('function_item_data')?></div>
		</div>
		<div class="form-group">
			<label>File/Record</label> <input type="number"
				name="function_file_record"
				value="<?php echo set_value('function_file_record', $function->function_file_record);?>"
				style="text-align: right;" class="form-control" min="1" max=""
				required>
			<div class="help-block"><?php echo form_error('function_file_record')?></div>
		</div>
		<div class="form-group">
			<label>Category</label>
			<?php
			   if($this->input->post('function_cwf_id')){
			      $function_cwf_id = $this->input->post('function_cwf_id');
			   } else {
               $function_cwf_id = '';
               foreach ($combo_cwf as $key => $value) {
                  if($key == $function->function_cwf_id.'-'.$value){
                     $function_cwf_id = $key;break;
                  }
               }
            }
			   echo form_dropdown('function_cwf_id', $combo_cwf, $function_cwf_id, 'class="form-control" required');
		   ?>
		</div>
		<div class="form-group">
			<label>Description</label>
			<?php echo form_textarea('function_description', set_value('function_description', $function->function_description), 'placeholder="Description" class="form-control" style="height:8em"')?>
		</div>
		<?php echo anchor('cwf/functions/'.$project_id, 'Back', 'class="btn btn-default"')?>
		<?php echo form_submit('submit', 'Submit', 'class="btn btn-primary"');?>
		<?php echo form_close();?>
	</div>
</div>