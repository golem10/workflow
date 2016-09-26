<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {
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
		if(!isset($this->permissionsArray[8])){
			redirect(base_url());
		}
	}
	
	public function index($id_status = 0)
	{				
	    $vars['site_info'] = array("title"=>"Dostawa",
		"description"=> "Lista",
		"active"=> "delivery");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Dostawa","url"=>""),
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['positions'] = $this->paints->countToDelivery();
	    $this->stock->displayView('delivery/list', $vars, $this->permissionsArray);		
	}
	
	
	public function pdfList(){
		$data = $this->paints->countToDelivery();	
	    $this->pdf->printPaintsDelivery($data);
	}
	
	
}
