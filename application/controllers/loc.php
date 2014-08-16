<?php

class Loc extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
   }

   public function index ()
   {
      $this->load->model('project_m');
      $this->data['lang'] = $this->project_m->get_data_project_with_total_lang();
      $this->data['subview'] = 'loc/index';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function insert ($project_id)
   {
      $this->data['subview'] = 'loc/insert';
      $this->load->view('_layout_main.php', $this->data);
   }
}