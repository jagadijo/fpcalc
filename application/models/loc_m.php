<?php

class Loc_m extends MY_Model
{

   public $rules = array(
      'lang_id' => array(
         'field' => 'lang_id[]',
         'label' => 'checkbox',
         'rules' => 'trim|intval'
      )
   );

   public function __construct ()
   {
      parent::__construct();
   }

   public function get_lang_by_project_id ($project_id)
   {
      $sql = "
         SELECT * FROM `ref_lang` 
         LEFT JOIN (
            SELECT `pl_lang_id` 
            FROM `trans_project_lang` 
            WHERE `pl_project_id` = ?) AS dyn ON dyn.`pl_lang_id` = lang_id 
      ";
      $query = $this->db->query($sql, array(
         $project_id
      ));
      return $query->result();
   }

   public function do_edit_trans_lang ($project_id, $lang_id)
   {
      $this->db->trans_begin();
      
      $sql_delete = "DELETE FROM trans_project_lang WHERE pl_project_id = ?";
      $this->db->query($sql_delete, array(
         $project_id
      ));
      
      $sql_insert = "INSERT INTO trans_project_lang VALUES (?, ?, NOW())";
      foreach ($lang_id as $value) {
         $this->db->query($sql_insert, array(
            $project_id,
            $value
         ));
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