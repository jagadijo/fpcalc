<?php

class Ef_m extends MY_Model
{

   public $rules = array(
      'trans_rating' => array(
         'field' => 'trans_rating[]',
         'label' => 'rating',
         'rules' => 'trim|required|intval'
      )
   );

   public function __construct ()
   {
      parent::__construct();
   }

   public function get_data_ef_by_project_id ($project_id)
   {
      $sql = "
         SELECT ef_id, ef_subject, trans_rating 
         FROM trans_project_ef 
         JOIN ref_ef ON ef_id = trans_ef_id 
         WHERE trans_project_id = ?
         ORDER BY `trans_ef_id`
      ";
      
      $query = $this->db->query($sql, $project_id);
      return $query->result();
   }

   public function do_edit_factor ($data, $project_id)
   {
      $sql = "
         UPDATE trans_project_ef 
         SET trans_rating = ?, trans_sysdate = NOW()
         WHERE trans_project_id = ? AND trans_ef_id = ?
      ";
      $this->db->trans_begin();
      foreach ($data['trans_rating'] as $key => $value) {
         $array_update = array(
            $value,
            $project_id,
            $key
         );
         $this->db->query($sql, $array_update);
      }
      
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }
}