<?php $this->load->view('components/page_header');?>
<?php $this->load->view('components/page_navbar_top');?>
<div id="wrapper">
	<div id="page-wrapper">
<?php
	if (!empty($subview) and is_file(__DIR__.'/'.$subview.'.php')) {
		$this->load->view($subview);
	} 
?>
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php $this->load->view('components/page_footer');?>