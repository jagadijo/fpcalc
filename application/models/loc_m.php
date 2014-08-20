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
      ";
      $query = $this->db->query($sql, array($project_id));
      return $query->result();
   }
}