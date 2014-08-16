<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
<?php
if (! empty($subviewmodal) and is_file(__DIR__ . '/' . $subviewmodal . '.php')) {
	$this->load->view($subviewmodal);
}
?>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->