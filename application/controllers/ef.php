<?php

class Ef extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
      $this->load->model('ef_m');
   }

   public function index ()
   {
      $this->load->model('project_m');
      $this->data['project'] = $this->project_m->get_data_project_with_total_factor();
      $this->data['subview'] = 'ef/index';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function factor ($project_id)
   {
      $this->load->model('project_m');
      $this->data['project'] = $this->project_m->get_data_project_by_id($project_id);
      
      $rules = $this->ef_m->rules;
      $this->form_validation->set_rules($rules);
      if ($this->form_validation->run() == TRUE) {
         $data = $this->ef_m->array_from_post(array(
            'trans_rating'
         ));
         	
         if ($this->ef_m->do_edit_factor($data, $project_id) == TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('ef/factor/'.$project_id);
      }
      $this->data['factor'] = $this->ef_m->get_data_ef_by_project_id($project_id);
      $this->data['subview'] = 'ef/factor';
      $this->load->view('_layout_main.php', $this->data);
   }
}