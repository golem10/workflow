<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pz extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('elementsmodel','elements');
		$this->load->model('paintsmodel','paints');
		$this->load->model('ordersmodel','orders');
		$this->load->model('customersmodel','customers');
		$this->load->model('pzmodel','pz');
		$this->load->model('smsmodel','sms');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/pz/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[6])){
			redirect(base_url());
		}
	}
	
	public function index($id_status = 0)
	{				
	    $vars['site_info'] = array("title"=>"Druki PZ",
		"description"=> "Lista",
		"active"=> "pz");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zamówienia","url"=>""),
		);
		$statuses_array = array(array("name"=>"Wszytstkie","id"=>0),array("name"=>"Do wypełnienia","id"=>1),array("name"=>"Do realizacji","id"=>2),array("name"=>"Zrealizowane","id"=>3),array("name"=>"Anulowane","id"=>4));
		$vars['status_active'] = $statuses_array[$id_status];
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('pz/list', $vars, $this->permissionsArray);		
	}
	public function getAllTable($id_status = 0)
	{	
	   echo $this->pz->getAllTable($id_status);		
	}
	
	public function delete($id_status = 0)
	{	
		if(!isset($this->permissionsArray[6][3])){
			redirect($this->defaultUrl);
		}
		$id_pz = $this->security->xss_clean($this->input->post('id_delete'));
		$this->pz->changeStatus($id_pz, 4);	
		redirect($this->defaultUrl);
	}
	
	public function generatePZ($id_order = 0){
		if(!isset($this->permissionsArray[6][1])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_order')){
			$id_order = $this->security->xss_clean($this->input->post('id_order'));
		}
		
		$order = $this->orders->getById($id_order);
		$id_pz = $this->pz->generate($order);		
		if($id_pz){
			$this->orders->setPzToOrder($id_order,$id_pz);
			redirect($this->defaultUrl."/edit/".$id_pz);
		}
		
	}
	
	public function updateBill($id_pz = 0, $bill_type=0){
		if(!isset($this->permissionsArray[6][2])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_pz')){
			$id_pz = $this->security->xss_clean($this->input->post('id_pz'));
		}		
		$pz = $this->pz->getById($id_pz);
		
		$this->pz->updateBill($id_pz,$this->input->post());
		redirect($this->defaultUrl."/edit/".$id_pz);		
	}
	public function toProduction($id_pz = 0, $bill_type=0){
		if(!isset($this->permissionsArray[6][2])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_pz')){
			$id_pz = $this->security->xss_clean($this->input->post('id_pz'));
		}		
		$pz = $this->pz->getById($id_pz);
		if($pz->id_status == 1){
			$return = $this->pz->changeStatus($id_pz,2);
		}
		elseif($pz->id_status == 2){
			$return = $this->pz->changeStatus($id_pz,3);
			$this->pz->setBillType($id_pz,$bill_type);
		}
		redirect($this->defaultUrl."/edit/".$id_pz);		
	}
	public function changePriority($id_pz = 0){
		if(!isset($this->permissionsArray[6][2])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_priority')){
			$id_pz = $this->security->xss_clean($this->input->post('id_priority'));
		}
		else{
			$id_pz = $this->security->xss_clean($id_pz);			
		}		
		if($id_pz == 0){
			redirect($this->defaultUrl);
		}
		$vars['pz'] = $this->pz->getById($id_pz);
		if($this->input->post('priority')){
				$update_status = $this->pz->updatePriority($id_pz, $this->security->xss_clean($this->input->post('priority')));				
				redirect($this->defaultUrl);	
		}
		 $vars['site_info'] = array("title"=>"Druk PZ nr ".$vars['pz']->number,
		"description"=> "Ustal priorytet",
		"active"=> "pz");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Druk PZ","url"=>$this->defaultUrl),
			array("name"=>$vars['pz']->number,"url"=>"")
		);
		$vars['js'] = array("pz.js");	
		$vars['order'] = $this->orders->getById($vars['pz']->id_order);
		$vars['formAction'] = base_url("pz/changePriority");	
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('pz/formPriority', $vars, $this->permissionsArray);	
		
	}
	public function edit($id_pz = 0)
	{	
		if(!isset($this->permissionsArray[6][2])){
			redirect($this->defaultUrl);
		}
		if($this->input->post('id_edit')){
			$id_pz = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_pz = $this->security->xss_clean($id_pz);			
		}		
		if($id_pz == 0){
			redirect($this->defaultUrl);
		}
		$vars['pz'] = $this->pz->getById($id_pz);
		if($vars['pz']->id_status == 1){
			if(!$this->input->post('redirect')){
				if($this->input->post()){
							$update_status = $this->pz->update($id_pz, $this->security->xss_clean($this->input->post()));				
							$this->pz->updatePositionValues($this->security->xss_clean($this->input->post()));
							$vars['pz'] = $this->pz->getById($id_pz);
				}
			}
			$vars['modalTxt'] = "<p>Przed przekazaniem do produkcji należy zapisać PZ.</p>
			<p>Przekazanie do produkcji uniemożliwi dalszą edycję PZ.</p>
			<p>Czy na pewno chcesz przekazać do produkcji?</p>";
		}
		elseif($vars['pz']->id_status == 2){
			$vars['modalTxt'] = "
			<p>Czy na pewno chcesz oznaczyć druk PZ jako zrealizowany?</p>";			
		}
		else{
			$vars['modalTxt'] = "";
		}
	    $vars['site_info'] = array("title"=>"Druk PZ nr ".$vars['pz']->number,
		"description"=> "Edytuj",
		"active"=> "pz");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Druk PZ","url"=>$this->defaultUrl),
			array("name"=>$vars['pz']->number,"url"=>"")
		);
		$vars['js'] = array("pz.js");	
		$vars['order'] = $this->orders->getById($vars['pz']->id_order);
		$vars['formAction'] = base_url("pz/edit");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['statuses'] = $this->orders->getStatuses();
		$vars['paints'] = $this->paints->getAll();
		$vars['positions'] = $this->orders->getPositions($vars['pz']->id_order);
		$vars['customer'] = $this->customers->getById($vars['order']->id_customer);
	    $this->stock->displayView('pz/form', $vars, $this->permissionsArray);		
	}
	public function addSms($type = 1, $id_pz = 0) // 1 - termin, 2 realizacja
	{
		$id_sms = $this->sms->add();
		$this->pz->updateSms($id_pz,$id_sms,$type);
	}
	
}
