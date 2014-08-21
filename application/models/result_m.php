<?php

class Result_m extends MY_Model
{

   public function __construct ()
   {
      parent::__construct();
   }

   public function get_data_summary_result ()
   {
      $this->load->model('project_m');
      $this->load->model('cwf_m');
      $this->load->model('ef_m');
      
      $tmp = array();
      $data = $this->project_m->get_data_project();
      foreach ($data as $value) {
         // -- EF
         $total_ef = 0;
         $ef = $this->ef_m->get_data_ef_by_project_id($value->project_id);
         foreach ($ef as $value_ef) {
            $total_ef += $value_ef->trans_rating;
         }
         
         // -- CWF
         $total_cwf = 0;
         $cwf = $this->cwf_m->get_data_cwf_by_project($value->project_id);
         foreach ($cwf as $value_cwf) {
            $total_cwf += ($value_cwf->cwf_simple * $value_cwf->cwf_weight_simple) +
                ($value_cwf->cwf_avarage * $value_cwf->cwf_weight_average) +
                ($value_cwf->cwf_complex * $value_cwf->cwf_weight_complex);
         }
         
         $tmp['project_id'] = $value->project_id;
         $tmp['project_name'] = $value->project_name;
         $tmp['caf'] = 0.65 + (0.01 * $total_ef);
         $tmp['afp'] = $total_cwf * $tmp['caf'];
         $result[] = $tmp;
      }
      return $result;
   }

   public function get_data_summary_result_by_project_id ($project_id)
   {
      $this->load->model('project_m');
      $this->load->model('cwf_m');
      $this->load->model('ef_m');
      $this->load->model('loc_m');
      
      $project = $this->project_m->get_data_project_by_id($project_id);
      $cwf = $this->cwf_m->get_data_cwf_by_project($project_id);
      $ef = $this->ef_m->get_data_ef_by_project_id($project_id);
      $loc = $this->loc_m->get_lang_by_project_id($project_id);
      
      $total_ef = 0;
      foreach ($ef as $value_ef) {
         $total_ef += $value_ef->trans_rating;
      }
      
      $total_cwf = 0;
      foreach ($cwf as $value_cwf) {
         $total_cwf += ($value_cwf->cwf_simple * $value_cwf->cwf_weight_simple) +
             ($value_cwf->cwf_avarage * $value_cwf->cwf_weight_average) +
             ($value_cwf->cwf_complex * $value_cwf->cwf_weight_complex);
      }
      
      return array(
         'project' => $project,
         'cwf' => $cwf,
         'cwf_total' => $total_cwf,
         'ef' => $ef,
         'ef_total' => $total_ef,
         'loc' => $loc
      );
   }
}