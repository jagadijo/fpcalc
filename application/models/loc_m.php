<?php

class Loc_m extends MY_Model
{

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
      $query = $this->db->query($sql, array($project_id));
      return $query->result();
   }
}