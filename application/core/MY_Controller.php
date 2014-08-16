<?php

class MY_Controller extends CI_Controller
{

   public $data = array();

   function __construct()
   {
      parent::__construct();
      
      $this->data ['application_name'] = config_item ( 'application_name' );
      $this->data ['application_version'] = config_item ( 'application_version' );
      $this->data ['company_name'] = config_item ( 'company_name' );
      $this->data ['company_address'] = config_item ( 'company_address' );
   }
}