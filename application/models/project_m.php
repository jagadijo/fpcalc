<?php

class Project_m extends MY_Model
{

   public $rules = array(
      'project_name' => array(
         'field' => 'project_name',
         'label' => 'project',
         'rules' => 'trim|required|xss_clean'
      ),
      'project_description' => array(
         'field' => 'project_description',
         'label' => 'description',
         'rules' => 'trim|xss_clean'
      )
   );

   public function __construct ()
   {
      parent::__construct();
   }

   public function get_data_project ()
   {
      $query = $this->db->query("SELECT * FROM project ORDER BY project_id DESC");
      return $query->result();
   }

   public function get_data_project_with_total_function ()
   {
      $query = $this->db->query(
         "
			SELECT project_id, project_name, COUNT(`function_id`) AS `function` 
			FROM project 
			  JOIN `cwf` ON cwf_project_id = project_id 
			  LEFT JOIN `function` ON `function_cwf_id` = `cwf_id` 
			GROUP BY project_id 
			ORDER BY project_id DESC	
		");
      return $query->result();
   }

   public function get_data_project_with_total_factor ()
   {
      $sql = "
         SELECT project_id, project_name, SUM(trans_rating) AS total_rating 
         FROM trans_project_ef 
         JOIN `project` ON project_id = `trans_project_id`
         GROUP BY project_id ORDER BY project_id DESC
      ";
      
      $query = $this->db->query($sql);
      return $query->result();
   }
   
   public function get_data_project_with_total_lang ()
   {
      $sql = "
         SELECT project_id, project_name, COUNT(pl_project_id) AS total
         FROM project 
         LEFT JOIN `trans_project_lang` ON `pl_project_id` = `project_id`
         GROUP BY project_id ORDER BY project_id DESC
      ";
   
      $query = $this->db->query($sql);
      return $query->result();
   }

   public function get_data_project_by_id ($project_id)
   {
      $sql = "SELECT * FROM project WHERE project_id = ?";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      return $query->row();
   }

   public function do_add_project ($data)
   {
      $this->db->trans_begin();
      
      // -- start : insert project
      
      $sql = "INSERT INTO project (project_name, project_description) VALUES (?, ?)";
      $query = $this->db->query($sql, 
         array(
            $data['project_name'],
            $data['project_description']
         ));
      // -- end : insert project
      
      $project_id = $this->db->insert_id();
      
      $array_cwf = array(
         array(
            'cwf_name' => 'Outputs',
            'weight_simple' => '4',
            'weight_average' => '5',
            'weight_complex' => '7'
         ),
         array(
            'cwf_name' => 'Inputs',
            'weight_simple' => '3',
            'weight_average' => '4',
            'weight_complex' => '6'
         ),
         array(
            'cwf_name' => 'Inquiry Outputs',
            'weight_simple' => '4',
            'weight_average' => '5',
            'weight_complex' => '7'
         ),
         array(
            'cwf_name' => 'Inquiry Inputs',
            'weight_simple' => '3',
            'weight_average' => '4',
            'weight_complex' => '6'
         ),
         array(
            'cwf_name' => 'Files',
            'weight_simple' => '7',
            'weight_average' => '10',
            'weight_complex' => '15'
         ),
         array(
            'cwf_name' => 'Interfaces',
            'weight_simple' => '5',
            'weight_average' => '7',
            'weight_complex' => '10'
         )
      );
      
      // -- start : insert default worksheet for complexity weighting factors
      
      foreach ($array_cwf as $cwf) {
         $sql = "
				INSERT INTO cwf (
					`cwf_project_id`,
					`cwf_name`,
					`cwf_weight_simple`,
					`cwf_weight_average`,
					`cwf_weight_complex`,
					`cwf_sysdate`
				) VALUES (
					?, ?, ?, ?, ?, NOW()
				)
			";
         $query = $this->db->query($sql, 
            array(
               $project_id,
               $cwf['cwf_name'],
               $cwf['weight_simple'],
               $cwf['weight_average'],
               $cwf['weight_complex']
            ));
      }
      // -- end : insert default worksheet for complexity weighting factors
      
      // -- start : insert default worksheet for environtmental factors
      $sql = "
			INSERT INTO trans_project_ef (
				`trans_project_id`, `trans_ef_id`, `trans_rating`, `trans_sysdate`
			) 
			SELECT 
				?, `ef_id`, 0, NOW()
			FROM
			  `ref_ef`
		";
      
      $query = $this->db->query($sql, array(
         $project_id
      ));
      // -- end : insert default worksheet for environtmental factors
      
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }

   public function do_edit_project ($data, $project_id)
   {
      $sql = "
			UPDATE project SET 
				project_name = ?, 
				project_description = ?
			WHERE 
				project_id = ?
		";
      $query = $this->db->query($sql, 
         array(
            $data['project_name'],
            $data['project_description'],
            $project_id
         ));
      
      return $this->db->affected_rows();
   }

   public function do_delete_project_by_id ($project_id)
   {
      $sql = "DELETE FROM project WHERE project_id = ?";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      return $this->db->affected_rows();
   }

   public function get_new_project ()
   {
      $project = new stdClass();
      $project->project_name = '';
      $project->project_description = '';
      return $project;
   }
}