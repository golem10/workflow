<?php 
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Stock{
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('authenticationmodel','authentication');
		$this->checkLogin();
	}
	
	public function displayView($site = NULL, $vars = array(), $permissionsArray = array())
	{
		if(!isset($vars['css']))
			$vars['css'] = array();

		$vars['js'][] = "general.js";
		if(isset($vars['msg'])){
				$vars['msgBlock'] = $this->CI->load->view('blocks/blockAlert',  $vars['msg'], TRUE);
		}
		else {
			$vars['msgBlock'] = "";
		}
		$vars['access'] = $permissionsArray;

		$this->CI->load->view('header',$vars);
		$this->CI->load->view('left',$vars);
		if($site!=NULL){
			$this->CI->load->view($site,$vars);
		}
		$this->CI->load->view('footer',$vars);
	}
	private function checkLogin($site=NULL,$vars=array())
	{  
		//if(!$this->CI->authentication->isLoggedIn() && $this->CI->input->server('ORIG_PATH_INFO') != '/login'){
		if(!$this->CI->authentication->isLoggedIn() && $this->CI->input->server('PATH_INFO') != '/login'){
			redirect(base_url('login'),'refresh');			
		}
		
	}
    
}