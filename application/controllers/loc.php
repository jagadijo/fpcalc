<?php

class Loc extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
      $this->load->model('loc_m');
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
      $this->load->model('project_m');
      $this->data['project'] = $this->project_m->get_data_project_by_id($project_id);
      $this->data['lang'] = $this->loc_m->get_lang_by_project_id($project_id);
      $this->data['subview'] = 'loc/insert';
      $this->load->view('_layout_main.php', $this->data);
   }
}