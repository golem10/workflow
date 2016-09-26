<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('elementsmodel','elements');
		$this->load->model('paintsmodel','paints');
		$this->load->model('ordersmodel','orders');
		$this->load->model('customersmodel','customers');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/orders/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[5])){
			redirect(base_url());
		}
	}
	
	public function index($id_status = 0)
	{				
	    $vars['site_info'] = array("title"=>"Zamówienia",
		"description"=> "Lista",
		"active"=> "orders");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zamówienia","url"=>""),
		);
		$vars['statuses'] = $this->orders->getStatuses();
		$vars['status_active'] = $this->orders->getStatusById($id_status);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('orders/list', $vars, $this->permissionsArray);		
	}
	public function getAllTable($id_status = 0)
	{	
	   echo $this->orders->getAllTable($id_status);		
	}
	
	public function add($id_customer = 0){
		if(!isset($this->permissionsArray[5][1])){
			redirect($this->defaultUrl);
		}
		if(!$id_customer){
			$id_customer = $this->security->xss_clean($this->input->post('id_edit'));
		}
		$id_order = $this->orders->add($id_customer);
		if($id_order){
			redirect($this->defaultUrl."/edit/".$id_order);
		}
		
	}
	public function edit($id_order = 0)
	{	
		if(!isset($this->permissionsArray[5][2])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_edit')){
			$id_order = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_order = $this->security->xss_clean($id_order);			
		}		
		if($id_order == 0){
			redirect($this->defaultUrl);
		}
		if(!$this->input->post('redirect')){
			if($this->input->post()){
						$vars['order'] = $this->orders->getById($id_order);
						if(!$vars['order']->id_pz){
							$update_status = $this->orders->update($id_order, $this->security->xss_clean($this->input->post()));		
						}
						
						// if($update_status){
							// $vars['msg']['type'] = 1;
							// $vars['msg']['value'] = "Zmiany zapisano pomyślnie.";
						// }
						// else{
							// $vars['msg']['type'] = 0;
							// $vars['msg']['value'] = "Zmiany nie zostały zapisane.";
						// }						
			}
		}
		$vars['order'] = $this->orders->getById($id_order);
	    $vars['site_info'] = array("title"=>"Zamówienie nr ".$vars['order']->number,
		"description"=> "Edytuj",
		"active"=> "orders");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zamówienie","url"=>$this->defaultUrl),
			array("name"=>$vars['order']->number,"url"=>"")
		);
		$vars['js'] = array("orders.js");	
		$vars['formAction'] = base_url("orders/edit");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['statuses'] = $this->orders->getStatuses();
		$vars['paints'] = $this->paints->getAll();
		$vars['positions'] = $this->orders->getPositions($id_order);
		$vars['customer'] = $this->customers->getById($vars['order']->id_customer);
	    $this->stock->displayView('orders/form', $vars, $this->permissionsArray);		
	}
	public function delete($id_order = 0)
	{	
		if(!isset($this->permissionsArray[5][3])){
			redirect($this->defaultUrl);
		}
		$id_order = $this->security->xss_clean($this->input->post('id_delete'));
		$this->orders->changeStatus($id_order, 3);	
		redirect($this->defaultUrl);
	}
}
