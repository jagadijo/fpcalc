<?php

class Result extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
      $this->load->model('result_m');
   }

   public function index ()
   {
      $this->data['result'] = $this->result_m->get_data_summary_result();
      $this->data['subview'] = 'result/index';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function detail ($project_id)
   {
      $this->data['result'] = $this->result_m->get_data_summary_result_by_project_id($project_id);
      $this->data['subview'] = 'result/detail';
      $this->load->view('_layout_main.php', $this->data);
   }
}