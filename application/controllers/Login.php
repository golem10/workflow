<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $permissionsArray;
	function __construct()
  	{
		parent::__construct();	
	}
	
	private function display($site=NULL,$vars=array())
	{
		$vars['css'] = array();
		$vars['js'] = array();
		$this->load->view('header',$vars);
		if($site!=NULL)
			$this->load->view($site,$vars);
		$this->load->view('footer',$vars);
	}
	
	public function index()
	{	
		$email =  $this->security->xss_clean($this->input->post('email'));
		$password =  $this->security->xss_clean($this->input->post('password'));
		if($email && $password){
			if($this->authentication->logIn($email,$password)){
				$this->permissionsArray = $this->authentication->getAccessArray();
				if(isset($this->permissionsArray[7])){
					redirect('pz_production','refresh');
				}
				elseif(isset($this->permissionsArray[8])){
					redirect('delivery','refresh');
				}
				elseif(isset($this->permissionsArray[5])){
					redirect('orders','refresh');
				}
				elseif(isset($this->permissionsArray[6])){
					redirect('pz','refresh');
				}
				else{
					redirect('dashboard','refresh');
				}
			}
		}
		$this->load->view('login/login');
	}
	public function out()
	{
		$this->authentication->logOut();
		redirect(base_url('login'),'refresh');
	}
}
