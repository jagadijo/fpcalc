<?php

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index() {
		$this->data['subview'] = 'dashboard/index';
		$this->load->view('_layout_main.php', $this->data);
	}
}