<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->permissionsArray = $this->authentication->getAccessArray();
	}
	
	public function index()
	{	
		 $vars['site_info'] = array("title"=>"Użytkownicy",
		"description"=> "Lista",
		"active"=> "dashboard");
	   
	    $this->stock->displayView('index', $vars, $this->permissionsArray);		
	}
	
}
