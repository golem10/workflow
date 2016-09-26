<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('customersmodel','customers');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/customers/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[3])){
			redirect(base_url());
		}
	}
	
	public function index()
	{			
	    $vars['site_info'] = array("title"=>"Klienci",
		"description"=> "Lista",
		"active"=> "customers");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Klienci","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('customers/list', $vars, $this->permissionsArray);		
	}
	public function selectCustomer()
	{			
	    $vars['site_info'] = array("title"=>"Klienci",
		"description"=> "Lista",
		"active"=> "customers");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zamówienia","url"=>base_url('/orders/')),
			array("name"=>"Wybierz klienta","url"=>""),
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('customers/listForOrders', $vars, $this->permissionsArray);		
	}
	public function getAllTable()
	{	
	   echo $this->customers->getAllTable();		
	}
	public function add($isOrder = 0)
	{	
		if(!isset($this->permissionsArray[3][1])){
			redirect($this->defaultUrl);
		}
		
	   $vars['site_info'] = array("title"=>"Klienci",
		"description"=> "Dodaj",
		"active"=> "customers");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Klienci","url"=>$this->defaultUrl),
			array("name"=>"Dodaj","url"=>"")
		);	
		if($isOrder){
			$vars['formAction'] = base_url("customers/add/1");
		}
		else{
			$vars['formAction'] = base_url("customers/add");
		}
		$vars['isOrder'] = $isOrder;
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['customer'] = (object) array('name' => '','city' => '','post_code' => '','street' => '','email' => '', 'phone' => '','person' => '', 'nip'=> '');
		if($this->input->post()){
			if ($this->form_validation->run('customer') == TRUE)
			{
					$id_customer = $this->customers->add($this->security->xss_clean($this->input->post()));
					if($isOrder){
						redirect(base_url("orders/add/".$id_customer));
					}
					else{
						redirect($this->defaultUrl);
					}					
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
	    $this->stock->displayView('customers/form', $vars, $this->permissionsArray);		
	}
	
	public function edit($id_customerGet = 0)
	{	
		if(!isset($this->permissionsArray[3][2])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post('id_edit')){
			$id_customer = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_customer = $this->security->xss_clean($id_userGet);			
		}
		$vars['customer'] = $this->customers->getById($id_customer);		
		if(!$vars['customer']){
			redirect($this->defaultUrl);
		}
		$vars['isOrder'] = 0;
		$vars['formAction'] = base_url("customers/edit");
		$vars['is_edit'] = 1;
	    $vars['site_info'] = array("title"=>$vars['customer']->name,
		"description"=> "Edytuj",
		"active"=> "customers");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Użytkownicy","url"=>$this->defaultUrl),
			array("name"=>"Edytuj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		if(!$this->input->post('redirect')){
			if($this->input->post()){
				if ($this->form_validation->run('customer') == TRUE)
				{
					$this->customers->update($id_customer, $this->security->xss_clean($this->input->post()));
					
					redirect($this->defaultUrl);
				}
				else
				{
					$vars['msg']['type'] = 0;
					$vars['msg']['value'] = validation_errors();
				}
				
			}
		}
	    $this->stock->displayView('customers/form', $vars, $this->permissionsArray);		
	}
	public function delete()
	{	
		if(!isset($this->permissionsArray[3][3])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post()){			
				$this->customers->delete($this->security->xss_clean($this->input->post()));			
		}
	    redirect($this->defaultUrl);	
	}
	
}
