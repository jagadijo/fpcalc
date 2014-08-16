<?php

class Cwf_m extends MY_Model
{

   public $rules = array(
      'function_name' => array(
         'field' => 'function_name',
         'label' => 'activity',
         'rules' => 'trim|required|xss_clean'
      ),
      'function_item_data' => array(
         'field' => 'function_item_data',
         'label' => 'item/data',
         'rules' => 'trim|required|intval'
      ),
      'function_file_record' => array(
         'field' => 'function_file_record',
         'label' => 'file/record',
         'rules' => 'trim|required|intval'
      ),
      'function_cwf_id' => array(
         'field' => 'function_cwf_id',
         'label' => 'category',
         'rules' => 'trim|required|xss_clean'
      ),
      'function_description' => array(
         'field' => 'function_description',
         'label' => 'description',
         'rules' => 'trim|xss_clean'
      )
   );

   public function __construct ()
   {
      parent::__construct();
   }

   public function get_data_function ($project_id)
   {
      $sql = "
			SELECT   		
				`function_id`,
				`function_name`,
				`cwf_name`,
				`cwf_project_id`,
				`function_item_data`,
				`function_file_record`,
				`function_complexity` AS `function_complexity_id`,
				CASE `function_complexity`
					WHEN 1 THEN 'SIMPLE'
					WHEN 2 THEN 'AVERAGE'
					WHEN 3 THEN 'COMPLEX'
					ELSE 'NOT SET'
				END AS `function_complexity`,
				`function_cwf_id`
			FROM `function`
			JOIN `cwf` ON `cwf_id` = `function_cwf_id`
			WHERE `cwf_project_id` = ?	
         ORDER BY function_sysdate DESC
		";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      
      return $query->result();
   }

   public function get_data_function_by_id ($function_id)
   {
      $sql = "
   		SELECT
           `function_id`,
   		  `function_name`,
   		  `function_cwf_id`,
   		  `function_item_data`,
   		  `function_file_record`,
   		  `function_complexity`,
   		  `function_description`
   		FROM `function`
   		WHERE `function_id` = ?
      ";
      $query = $this->db->query($sql, array(
         $function_id
      ));
      return $query->row();
   }

   public function get_data_cwf_by_project ($project_id)
   {
      $sql = "
   		SELECT * FROM `cwf` WHERE `cwf_project_id` = ?
      ";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      return $query->result();
   }

   public function do_add_function ($data, $project_id)
   {
      $data_explode = explode('-', $data['function_cwf_id']);
      $function_cwf_id = (int) $data_explode[0];
      $function_cwf_name = trim($data_explode[1]);
      $function_complexity = $this->get_complexity($data['function_item_data'], $data['function_file_record'], 
         $function_cwf_name);
      
      $array_insert = array(
         $data['function_name'],
         $function_cwf_id,
         $data['function_item_data'],
         $data['function_file_record'],
         $function_complexity,
         $data['function_description']
      );
      
      $this->db->trans_begin();
      
      // insert function in each category
      $sql = "
			INSERT INTO `function` (
			`function_name`, `function_cwf_id`, `function_item_data`, `function_file_record`, 
			`function_complexity`, `function_description`, `function_sysdate`)
			VALUES (?, ?, ?, ?, ?, ?, NOW());	
		";
      $this->db->query($sql, $array_insert);
      
      // get weight
      $sql = "
			SELECT COUNT(`function_id`) AS total 
			FROM `function` 
			JOIN `cwf` ON `cwf_id` = `function_cwf_id`
			WHERE `cwf_project_id` = ? AND `cwf_id` = ? 
			AND function_complexity = ?
			GROUP BY `function_cwf_id`
		";
      $query = $this->db->query($sql, 
         array(
            $project_id,
            $function_cwf_id,
            $function_complexity
         ));
      $total = $query->row_array();
      
      $field = '';
      if ($function_complexity == 1) {
         $field = ", `cwf_simple` = '{$total['total']}' ";
      } elseif ($function_complexity == 2) {
         $field = ", `cwf_avarage` = '{$total['total']}' ";
      } elseif ($function_complexity == 3) {
         $field = ", `cwf_complex` = '{$total['total']}' ";
      }
      
      // update complexity weighting factor
      $sql = "
			UPDATE `cwf` SET
			  `cwf_sysdate` = NOW(){$field}
			WHERE `cwf_project_id` = ? 
			  AND `cwf_id` = ?
		";
      $this->db->query($sql, array(
         $project_id,
         $function_cwf_id
      ));
      
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }

   public function do_edit_function ($data, $project_id, $function_id, $function_cwf_id_old, $function_complexity_id_old)
   {
      $data_explode = explode('-', $data['function_cwf_id']);
      $function_cwf_id = (int) $data_explode[0];
      $function_cwf_name = trim($data_explode[1]);
      $function_complexity = $this->get_complexity($data['function_item_data'], $data['function_file_record'], 
         $function_cwf_name);
      
      $array_update = array(
         $data['function_name'],
         $function_cwf_id,
         $data['function_item_data'],
         $data['function_file_record'],
         $function_complexity,
         $data['function_description'],
         $function_id
      );
      
      $this->db->trans_begin();
      
      // update function
      $sql = "
	   	UPDATE function SET
				`function_name` = ?,
			  	`function_cwf_id` = ?,
			  	`function_item_data` = ?,
			  	`function_file_record` = ?,
			  	`function_complexity` = ?,
			  	`function_description` = ?,
			  	`function_sysdate` = NOW()
			WHERE 	
				`function_id` = ?
      ";
      
      $this->db->query($sql, $array_update);
      
      // get total data after update first
      $sql = "
         SELECT COUNT(`function_id`) AS total FROM `function` 
			JOIN `cwf` ON `cwf_id` = `function_cwf_id`
			WHERE `cwf_project_id` = ? 
			AND `cwf_id` = ? AND function_complexity = ?
			GROUP BY `function_cwf_id`
      ";
      
      $query = $this->db->query($sql, 
         array(
            $project_id,
            $function_cwf_id,
            $function_complexity
         ));
      $total = $query->row_array();
      
      $field = '';
      if ($function_complexity == 1) {
         $field = ", `cwf_simple` = '{$total['total']}' ";
      } elseif ($function_complexity == 2) {
         $field = ", `cwf_avarage` = '{$total['total']}' ";
      } elseif ($function_complexity == 3) {
         $field = ", `cwf_complex` = '{$total['total']}' ";
      }
      
      // update new data cwf
      $sql = "
      	UPDATE `cwf` SET
			  `cwf_sysdate` = NOW(){$field}
			WHERE `cwf_project_id` = ? 
			  AND `cwf_id` = ? 
      ";
      
      $this->db->query($sql, array(
         $project_id,
         $function_cwf_id
      ));
      
      // get total data after update second
      $sql = "
			SELECT COUNT(`function_id`) AS total FROM `function` 
			JOIN `cwf` ON `cwf_id` = `function_cwf_id`
			WHERE `cwf_project_id` = ? 
			AND `cwf_id` = ? AND function_complexity = ?
			GROUP BY `function_cwf_id`
      ";
      
      $query = $this->db->query($sql, 
         array(
            $project_id,
            $function_cwf_id_old,
            $function_complexity_id_old
         ));
      
      $total = $query->row_array();
      
      $field = '';
      if ($function_complexity_id_old == 1) {
         $field = ", `cwf_simple` = '{$total['total']}' ";
      } elseif ($function_complexity_id_old == 2) {
         $field = ", `cwf_avarage` = '{$total['total']}' ";
      } elseif ($function_complexity_id_old == 3) {
         $field = ", `cwf_complex` = '{$total['total']}' ";
      }
      
      // update old data cwf
      $sql = "
         UPDATE `cwf` SET
			  `cwf_sysdate` = NOW(){$field}
			WHERE `cwf_project_id` = ? 
			  AND `cwf_id` = ? 
      ";
      
      $this->db->query($sql, array(
         $project_id,
         $function_cwf_id_old
      ));
      
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }

   public function do_delete_function ($project_id, $function_id, $function_cwf_id, $function_complexity_id)
   {
      $this->db->trans_begin();
      
      // -- delete function
      $sql = "DELETE FROM function WHERE function_id = ?";
      
      $this->db->query($sql, array(
         $function_id
      ));
      
      // -- get total function after delete
      $sql = "
         SELECT 
           COUNT(`function_id`) AS total 
         FROM
           `function` 
           JOIN `cwf` 
             ON `cwf_id` = `function_cwf_id` 
         WHERE `cwf_project_id` = ? 
           AND `cwf_id` = ? 
           AND function_complexity = ? 
         GROUP BY `function_cwf_id` 
      ";
      
      $query = $this->db->query($sql, 
         array(
            $project_id,
            $function_cwf_id,
            $function_complexity_id
         ));
      $total = $query->row_array();
      
      $field = '';
      if ($function_complexity_id == 1) {
         $field = ", `cwf_simple` = '{$total['total']}' ";
      } elseif ($function_complexity_id == 2) {
         $field = ", `cwf_avarage` = '{$total['total']}' ";
      } elseif ($function_complexity_id == 3) {
         $field = ", `cwf_complex` = '{$total['total']}' ";
      }
      
      // -- update complexity weighting factor
      $sql = "
         UPDATE 
           `cwf` 
         SET
           `cwf_sysdate` = NOW(){$field}
         WHERE `cwf_project_id` = ? 
           AND `cwf_id` = ?
      ";
      $this->db->query($sql, array(
         $project_id,
         $function_cwf_id
      ));
      
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }

   public function get_combo_cwf ($project_id)
   {
      $sql = "SELECT `cwf_id`, `cwf_name` FROM `cwf` WHERE cwf_project_id = ?";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      
      foreach ($query->result_array() as $key => $value) {
         $return[$value['cwf_id'] . '-' . $value['cwf_name']] = $value['cwf_name'];
      }
      return $return;
   }

   public function get_new_function ()
   {
      $function = new stdClass();
      $function->function_id = '';
      $function->function_name = '';
      $function->function_item_data = '0';
      $function->function_file_record = '0';
      $function->function_cwf_id = '';
      $function->function_description = '';
      return $function;
   }

   public function get_complexity ($file, $data, $factor)
   {
      $factor = strtolower($factor);
      switch ($factor) {
         case 'outputs':
            $row1 = $file <= 1;
            $row2 = $file <= 3;
            $row3 = $file >= 4;
            $col1 = $data <= 5;
            $col2 = $data <= 19;
            $col3 = $data >= 20;
            break;
         case 'inputs':
            $row1 = $file <= 1;
            $row2 = $file <= 3;
            $row3 = $file >= 4;
            $col1 = $data <= 5;
            $col2 = $data <= 19;
            $col3 = $data >= 20;
            break;
         case 'inquiry outputs':
            $row1 = $file <= 1;
            $row2 = $file <= 3;
            $row3 = $file >= 4;
            $col1 = $data <= 5;
            $col2 = $data <= 19;
            $col3 = $data >= 20;
            break;
         case 'inquiry inputs':
            $row1 = $file <= 1;
            $row2 = $file <= 3;
            $row3 = $file >= 4;
            $col1 = $data <= 5;
            $col2 = $data <= 19;
            $col3 = $data >= 20;
            break;
         case 'files':
            $row1 = $file <= 1;
            $row2 = $file <= 5;
            $row3 = $file >= 6;
            $col1 = $data <= 19;
            $col2 = $data <= 49;
            $col3 = $data >= 50;
            break;
         case 'interfaces':
            $row1 = $file <= 1;
            $row2 = $file <= 5;
            $row3 = $file >= 6;
            $col1 = $data <= 19;
            $col2 = $data <= 49;
            $col3 = $data >= 50;
            break;
         default:
            $factor = '';
            break;
      }
      
      if (! empty($factor)) {
         if ($row1) {
            if ($col1) {
               return 1;
            } elseif ($col2) {
               return 1;
            } elseif ($col3) {
               return 3;
            }
         } elseif ($row2) {
            if ($col1) {
               return 1;
            } elseif ($col2) {
               return 2;
            } elseif ($col3) {
               return 3;
            }
         } elseif ($row3) {
            if ($col1) {
               return 2;
            } elseif ($col2) {
               return 3;
            } elseif ($col3) {
               return 3;
            }
         }
      } else {
         return 'Factor Error!';
      }
   }
}