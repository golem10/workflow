<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pz_production extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		require_once(dirname(__FILE__).'/../../tcpdf/tcpdf.php');
		$this->load->model('elementsmodel','elements');
		$this->load->model('paintsmodel','paints');
		$this->load->model('ordersmodel','orders');
		$this->load->model('customersmodel','customers');
		$this->load->model('pzmodel','pz');
		$this->load->model('pdfmodel','pdf');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/pz/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[7])){
			redirect(base_url());
		}
	}
	
	public function index($id_status = 0)
	{				
	    $vars['site_info'] = array("title"=>"Zlecenia",
		"description"=> "Lista",
		"active"=> "pz_production");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zlecenia","url"=>""),
		);
		$statuses_array = array(array("name"=>"Wszytstkie","id"=>0),array("name"=>"Do wypełnienia","id"=>1),array("name"=>"Do realizacji","id"=>2),array("name"=>"Zrealizowane","id"=>3));
		$vars['status_active'] = $statuses_array[$id_status];
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('pz_production/list', $vars, $this->permissionsArray);		
	}
	public function getAllTable($id_status = 0)
	{	
	   echo $this->pz->getAllTable(2);		
	}
	
	
	public function edit($id_pz = 0)
	{	
		
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
		
	    $vars['site_info'] = array("title"=>"Zlecenie dla PZ nr ".$vars['pz']->number,
		"description"=> "Podgląd",
		"active"=> "pz_production");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Druk PZ","url"=>$this->defaultUrl),
			array("name"=>$vars['pz']->number,"url"=>"")
		);
		$vars['js'] = array("pz.js");	
		$vars['order'] = $this->orders->getById($vars['pz']->id_order);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['statuses'] = $this->orders->getStatuses();
		$vars['paints'] = $this->paints->getAll();
		$vars['positions'] = $this->orders->getPositions($vars['pz']->id_order);
		$vars['customer'] = $this->customers->getById($vars['order']->id_customer);
	    $this->stock->displayView('pz_production/form', $vars, $this->permissionsArray);		
	}
	public function pdfList(){
		$data = $this->pz->getTableToPdf(2);	
		$this->pdf->printPzProduction($data);
	}
	
}
