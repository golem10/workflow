<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Definitions extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('elementsmodel','elements');
		$this->load->model('paintsmodel','paints');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/definitions/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[4])){
			redirect(base_url());
		}
	}
	
	public function elements()
	{		
		
	    $vars['site_info'] = array("title"=>"Definicje",
		"description"=> "Elementy",
		"active"=> "definitions");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Elementy","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('definitions/elements/list', $vars, $this->permissionsArray);		
	}
	public function getAllTableElements()
	{	
	   echo $this->elements->getAllTable();		
	}
	public function addElement()
	{	
	
		
	   $vars['site_info'] = array("title"=>"Elementy",
		"description"=> "Dodaj",
		"active"=> "definitions");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Elementy","url"=>$this->defaultUrl."/elements"),
			array("name"=>"Dodaj","url"=>"")
		);
			
		$vars['formAction'] = base_url("definitions/addElement");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['element'] = (object) array('name' => '');
		if($this->input->post()){
			if ($this->form_validation->run('element') == TRUE)
			{
					$id_element = $this->elements->add($this->security->xss_clean($this->input->post()));					
					redirect($this->defaultUrl."/elements");
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
	    $this->stock->displayView('definitions/elements/form', $vars, $this->permissionsArray);		
	}
	
	public function editElement($id_elementGet = 0)
	{	
		
		
		if($this->input->post('id_edit')){
			$id_element = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_element = $this->security->xss_clean($id_elementGet);			
		}
		$vars['element'] = $this->elements->getById($id_element);		
		if(!$vars['element']){
			redirect($this->defaultUrl."/elements");
		}
		$vars['formAction'] = base_url("definitions/editElement");
		$vars['is_edit'] = 1;
	    $vars['site_info'] = array("title"=>"Elementy",
		"description"=> "Edytuj",
		"active"=> "definitions");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Elementy","url"=>$this->defaultUrl."/elements"),
			array("name"=>"Edytuj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		if(!$this->input->post('redirect')){
			if($this->input->post()){
				if ($this->form_validation->run('element') == TRUE)
				{
					$this->elements->update($id_element, $this->security->xss_clean($this->input->post()));			
					redirect($this->defaultUrl."/elements");
				}
				else
				{
					$vars['msg']['type'] = 0;
					$vars['msg']['value'] = validation_errors();
				}
				
			}
		}
	    $this->stock->displayView('definitions/elements/form', $vars, $this->permissionsArray);		
	}
	public function deleteElement()
	{	
		
		if($this->input->post()){			
				$this->elements->delete($this->security->xss_clean($this->input->post()));			
		}
	    redirect($this->defaultUrl."/elements");	
	}
	public function paints()
	{		
		
	    $vars['site_info'] = array("title"=>"Definicje",
		"description"=> "Farby",
		"active"=> "definitions");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Farby","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('definitions/paints/list', $vars, $this->permissionsArray);		
	}
	public function getAllTablePaints()
	{	
	   echo $this->paints->getAllTable();		
	}
	public function addPaint()
	{	
	
		
	   $vars['site_info'] = array("title"=>"Farby",
		"description"=> "Dodaj",
		"active"=> "definitions");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Farby","url"=>$this->defaultUrl."/paints"),
			array("name"=>"Dodaj","url"=>"")
		);
			
		$vars['formAction'] = base_url("definitions/addPaint");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['paint'] = (object) array('name' => '');
		if($this->input->post()){
			if ($this->form_validation->run('paint') == TRUE)
			{
					$id_paint = $this->paints->add($this->security->xss_clean($this->input->post()));					
					redirect($this->defaultUrl."/paints");
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
	    $this->stock->displayView('definitions/paints/form', $vars, $this->permissionsArray);		
	}
	
	public function editPaint($id_paintGet = 0)
	{	
		
		
		if($this->input->post('id_edit')){
			$id_paint = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_paint = $this->security->xss_clean($id_paintGet);			
		}
		$vars['paint'] = $this->paints->getById($id_paint);		
		if(!$vars['paint']){
			redirect($this->defaultUrl."/paints");
		}
		$vars['formAction'] = base_url("definitions/editpaint");
		$vars['is_edit'] = 1;
	    $vars['site_info'] = array("title"=>"Farby",
		"description"=> "Edytuj",
		"active"=> "definitions");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Definicje","url"=>""),
			array("name"=>"Farby","url"=>$this->defaultUrl."/paints"),
			array("name"=>"Edytuj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		if(!$this->input->post('redirect')){
			if($this->input->post()){
				if ($this->form_validation->run('paint') == TRUE)
				{
					$this->paints->update($id_paint, $this->security->xss_clean($this->input->post()));			
					redirect($this->defaultUrl."/paints");
				}
				else
				{
					$vars['msg']['type'] = 0;
					$vars['msg']['value'] = validation_errors();
				}
				
			}
		}
	    $this->stock->displayView('definitions/paints/form', $vars, $this->permissionsArray);		
	}
	public function deletePaint()
	{	
		
		if($this->input->post()){			
				$this->paints->delete($this->security->xss_clean($this->input->post()));			
		}
	    redirect($this->defaultUrl."/paints");	
	}
}
