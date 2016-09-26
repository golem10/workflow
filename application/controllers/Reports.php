<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
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
		$this->load->model('reportsmodel','reports');
		$this->load->model('pdfmodel','pdf');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/pz/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[9][5])){
			redirect(base_url());
		}
	}
	
	public function index()
	{				
	    $vars['site_info'] = array("title"=>"Raporty",
		"description"=> "",
		"active"=> "reports");
		$vars['js'] = array("reports.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zamówienia","url"=>""),
		); 
		$range_from = "";
		$range_to = "";
		$vars['dataBlock'] = "";
		$vars['id_report'] = 0;
		if($this->input->post('id_report') && ($this->input->post('range_from') || $this->input->post('range_to'))){
			$range_from = $this->input->post('range_from');
			$range_to = $this->input->post('range_to');
			$id_report = $this->input->post('id_report');
			if(!$range_from && $range_to){
				$range_from = $range_to;
			}
			elseif($range_from && !$range_to){
				$range_to = $range_from;
			}	
			switch ($id_report) {
				case 1:
					$dataRaport['data'] = $this->reports->exposedPz($range_from,$range_to);
					$viewReport = "report1"; // wystawione pz
					break;
				case 2:
					$dataRaport['data'] = $this->reports->executedPz($range_from,$range_to);
					$viewReport = "report2"; // wykonane pz
					break;
				case 3:
					$dataRaport['data'] = $this->reports->inProgressPz($range_from,$range_to);
					$viewReport = "report3"; // w trakcie realizacji pz
					break;
				case 4:
					$dataRaport['data'] = $this->reports->exposedPz($range_from,$range_to);
					$dataRaport['dataElements'] = $this->reports->elementsToPz($dataRaport['data']);
					$viewReport = "report4"; // wg kontrahentow
					break;
				case 5:
					$dataRaport['data'] = $this->reports->paints($range_from,$range_to);
					$viewReport = "report5"; // wg farby na dany dzien
					break;
			}
			$vars['dataBlock'] = $this->load->view('reports/'.$viewReport,$dataRaport, TRUE);
			$vars['id_report'] = $id_report;
		}
		$vars['range_from'] = $range_from;
		$vars['range_to'] = $range_to;
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('reports/form', $vars, $this->permissionsArray);		
	}
	public function pdfList($id_report = 0, $range_from, $range_to){
		switch ($id_report) {
				case 1:
					$dataRaport['data'] = $this->reports->exposedPz($range_from,$range_to);
					break;
				case 2:
					$dataRaport['data'] = $this->reports->executedPz($range_from,$range_to);
					break;
				case 3:
					$dataRaport['data'] = $this->reports->inProgressPz($range_from,$range_to);
					break;
				case 4:
					$dataRaport['data'] = $this->reports->exposedPz($range_from,$range_to);
					$dataRaport['dataElements'] = $this->reports->elementsToPz($dataRaport['data']);
					break;
				case 5:
					$dataRaport['data'] = $this->reports->paints($range_from,$range_to);
					break;
			}
	    $this->pdf->printRaport($id_report, $dataRaport, $range_from, $range_to);
	}
	
}
