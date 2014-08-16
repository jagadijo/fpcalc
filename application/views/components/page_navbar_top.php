<nav class="navbar navbar-default navbar-fixed-top" role="navigation"
	style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
			data-target=".sidebar-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url();?>"><?php echo $application_name;?> <?php echo $application_version;?></a>
	</div>
	<!-- /.navbar-header -->

	<?php $this->load->view('components/page_navbar_left');?>
</nav>