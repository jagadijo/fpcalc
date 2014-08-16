<?php

class Cwf extends MY_Controller
{

   public function __construct ()
   {
      parent::__construct();
      $this->load->model('cwf_m');
   }

   public function index ()
   {
      $this->load->model('project_m');
      $this->data['project'] = $this->project_m->get_data_project_with_total_function();
      $this->data['subview'] = 'cwf/index';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function functions ($project_id = NULL)
   {
      $this->load->model('project_m');
      $this->data['project_id'] = $project_id;
      $this->data['project'] = $this->project_m->get_data_project_by_id($project_id);
      $this->data['function'] = $this->cwf_m->get_data_function($project_id);
      $this->data['subview'] = 'cwf/functions';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function add_function ($project_id = NULL)
   {
      $rules = $this->cwf_m->rules;
      $this->form_validation->set_rules($rules);
      
      if ($this->form_validation->run() == TRUE) {
         $data = $this->cwf_m->array_from_post(
            array(
               'function_name',
               'function_item_data',
               'function_file_record',
               'function_cwf_id',
               'function_description'
            ));
         if ($this->cwf_m->do_add_function($data, $project_id) == TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('cwf/functions/' . $project_id);
      }
      
      $this->data['project_id'] = $project_id;
      $this->data['combo_cwf'] = $this->cwf_m->get_combo_cwf($project_id);
      $this->data['function'] = $this->cwf_m->get_new_function();
      $this->data['subview'] = 'cwf/insert_function';
      $this->load->view('_layout_main.php', $this->data);
   }

   public function edit_function ($project_id, $function_id, $function_cwf_id, $function_complexity_id)
   {
      $rules = $this->cwf_m->rules;
      $this->form_validation->set_rules($rules);
      
      if ($this->form_validation->run() == TRUE) {
         $data = $this->cwf_m->array_from_post(
            array(
               'function_name',
               'function_item_data',
               'function_file_record',
               'function_cwf_id',
               'function_description'
            ));
         
         if ($this->cwf_m->do_edit_function($data, $project_id, $function_id, $function_cwf_id, $function_complexity_id) ==
             TRUE) {
            $this->session->set_flashdata('message', '<p>Success.</p>');
         } else {
            $this->session->set_flashdata('message', '<p>Failed.</p>');
         }
         redirect('cwf/functions/' . $project_id);
      }
      
      $this->data['project_id'] = $project_id;
      $this->data['combo_cwf'] = $this->cwf_m->get_combo_cwf($project_id);
      $this->data['subview'] = 'cwf/insert_function';
      $this->data['function'] = $this->cwf_m->get_data_function_by_id($function_id);
      $this->load->view('_layout_main.php', $this->data);
   }

   public function delete_function ($project_id = NULL, $function_id = NULL, $function_cwf_id = NULL, $function_complexity_id = NULL)
   {
      if ($this->cwf_m->do_delete_function($project_id, $function_id, $function_cwf_id, $function_complexity_id) == TRUE) {
         $this->session->set_flashdata('message', '<p>Success.</p>');
      } else {
         $this->session->set_flashdata('message', '<p>Failed.</p>');
      }
      redirect('cwf/functions/' . $project_id);
   }
}