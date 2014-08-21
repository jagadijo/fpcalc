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

   public function insert ($project_id, $lang_id = null)
   {
      $this->load->model('project_m');
      
      $rules = $this->loc_m->rules;
      $this->form_validation->set_rules($rules);
      if ($this->form_validation->run() == TRUE) {
         $data = $this->loc_m->array_from_post(array(
            'lang_id'
         ));
         
         if ($this->loc_m->do_edit_trans_lang($project_id, $data['lang_id']) == TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('loc/insert/' . $project_id);
      }
      
      $this->data['project'] = $this->project_m->get_data_project_by_id($project_id);
      $this->data['lang'] = $this->loc_m->get_lang_by_project_id($project_id);
      $this->data['subview'] = 'loc/insert';
      $this->load->view('_layout_main.php', $this->data);
   }
}