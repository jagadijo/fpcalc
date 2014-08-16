<?php

class Project extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
      $this->load->model('project_m');
   }

   public function index ()
   {
      $this->data['project'] = $this->project_m->get_data_project();
      $this->data['subview'] = 'project/index';
      $this->load->view('_layout_main', $this->data);
   }

   public function Add ()
   {
      $rules = $this->project_m->rules;
      $this->form_validation->set_rules($rules);
      
      if ($this->form_validation->run() == TRUE) {
         $data = $this->project_m->array_from_post(array(
            'project_name',
            'project_description'
         ));
         
         if ($this->project_m->do_add_project($data) == TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('project');
      }
      
      $this->data['project'] = $this->project_m->get_new_project();
      $this->data['subview'] = 'project/insert';
      $this->load->view('_layout_main', $this->data);
   }

   public function edit ($project_id = NULL)
   {
      $rules = $this->project_m->rules;
      $this->form_validation->set_rules($rules);
      if ($this->form_validation->run() == TRUE) {
         $data = $this->project_m->array_from_post(array(
            'project_name',
            'project_description'
         ));
         
         if ($this->project_m->do_edit_project($data, $project_id) == TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('project');
      }
      $this->data['project'] = $this->project_m->get_data_project_by_id($project_id);
      $this->data['subview'] = 'project/insert';
      $this->load->view('_layout_main', $this->data);
   }

   public function delete ($project_id = NULL)
   {
      if ($this->project_m->do_delete_project_by_id($project_id) == TRUE) {
         $this->session->set_flashdata('message', '<p>Success.</p>');
      } else {
         $this->session->set_flashdata('message', '<p>Failed.</p>');
      }
      redirect('project');
   }
}