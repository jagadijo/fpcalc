<?php

class MY_Model extends CI_Model
{

	public $rules = array();

	public function __construct()
	{
		parent::__construct();
	}
	
	public function array_from_post($fields)
	{
		$data = array();
		foreach ($fields as $value) {
			$data[$value] = $this->input->post($value);
		}
		return $data;
	}
}