<div class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-search">
				<div class="input-group custom-search-form">
					<input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div> <!-- /input-group -->
			</li>
			<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
			<li><a href="<?php echo site_url('project');?>"><i class="fa fa-file fa-fw"></i> Projects</a></li>
			<li><a href="<?php echo site_url('cwf')?>"><i class="fa fa-file fa-fw"></i> Complexity Weighting Factors</a></li>
			<li><a href="<?php echo site_url('ef')?>"><i class="fa fa-file fa-fw"></i> Environmental Factors</a></li>
			<li><a href="<?php echo site_url('loc')?>"><i class="fa fa-file fa-fw"></i> LOC Converter</a></li>
			<li><a href="<?php echo site_url('result')?>"><i class="fa fa-file fa-fw"></i> Summary Result</a></li>
		</ul>
		<!-- /#side-menu -->
	</div>
	<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->