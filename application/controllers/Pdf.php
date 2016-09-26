<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {
	private $defaultUrl;
	private $permissionsArray;
	function __construct()
  	{
		parent::__construct();
		require_once(dirname(__FILE__).'/../../tcpdf/tcpdf.php');
		$this->load->model('pdfmodel','pdf');
		$this->load->model('pzmodel','pz');
		$this->load->model('elementsmodel','elements');
		$this->load->model('paintsmodel','paints');
		$this->load->model('ordersmodel','orders');
		$this->load->model('customersmodel','customers');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/usersGroups/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		
	}
	
	public function index($pz_t = 0, $pz_c_t = 0, $order_t = 0, $id_pz = 0,$id_order = 0)
	{	
		$docsType = array("pz"=>$pz_t,"pz_c"=>$pz_c_t,"order"=>$order_t);
		if($id_pz){
			$pz = $this->pz->getById($id_pz);
			$order = $this->orders->getById($pz->id_order);
			$positions = $this->orders->getPositionsPDF($pz->id_order);
			$customer = $this->customers->getById($order->id_customer);
		}
		elseif($id_order){
			$order = $this->orders->getById($id_order);
			$pz = $this->pz->getById($order->id_pz);
			$positions = $this->orders->getPositionsPDF($id_order);
			$customer = $this->customers->getById($order->id_customer);
		}
		
		
		$this->pdf->printDocs($docsType,$pz,$order,$positions,$customer);

	}


}
