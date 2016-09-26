<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersGroups extends CI_Controller {
	private $defaultUrl;
	private $permissionsArray;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('usersGroupsmodel','usersGroups');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/usersGroups/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[1])){
			redirect(base_url());
		}
	}
	
	public function index()
	{			
	    $vars['site_info'] = array("title"=>"Grupy użytkowników",
		"description"=> "Lista",
		"active"=> "usersGroups");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Grupy użytkowników","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs', $breadcrumbs, TRUE);
	    $this->stock->displayView('usersGroups/list', $vars, $this->permissionsArray);		
	}
	public function getAllTable()
	{	
	   echo $this->usersGroups->getAllTable();		
	}
	public function add()
	{	
		if(!isset($this->permissionsArray[1][1])){
			redirect($this->defaultUrl);
		}
		
	    $vars['site_info'] = array("title"=>"Grupy użytkowników",
		"description"=> "Dodaj",
		"active"=> "usersGroups");
		$vars['formAction'] = base_url("usersGroups/add");
		$vars['group'] = (object) array('name' => '');
		$varsToBlock['permissionsBlocksArray'] = $this->authentication->getPermissionsBlocks();
		$vars['blockPermissionsSettings'] = $this->load->view('blocks/blockPermissionsSettings',$varsToBlock, TRUE);	
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Grupy użytkowników","url"=>$this->defaultUrl),
			array("name"=>"Dodaj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs', $breadcrumbs, TRUE);
		if($this->input->post()){
			
			if ($this->form_validation->run('userGroup') == TRUE)
			{
					$dataGroup['name']  = $this->security->xss_clean($this->input->post('name'));
					$id_group = $this->usersGroups->add($dataGroup);
					redirect($this->defaultUrl);
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
	    $this->stock->displayView('usersGroups/form', $vars, $this->permissionsArray);		
	}
	public function edit($id_groupGet = 0)
	{	
		if(!isset($this->permissionsArray[1][2])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post('id_edit')){
			$id_group = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_group = $this->security->xss_clean($id_groupGet);			
		}
		$vars['group'] = $this->usersGroups->getById($id_group);
		if(!$vars['group']){
			redirect($this->defaultUrl);
		}
		
		$vars['formAction'] = base_url("usersGroups/edit");
		$vars['is_edit'] = 1;
	    $vars['site_info'] = array("title"=>$vars['group']->name,
		"description"=> "Edytuj",
		"active"=> "usersGroups");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Grupy użytkowników","url"=>$this->defaultUrl),
			array("name"=>"Edytuj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		if(!$this->input->post('redirect')){
			if($this->input->post()){
				if ($this->form_validation->run('userGroup') == TRUE)
				{
					$this->usersGroups->update($this->security->xss_clean($this->input->post()));
					redirect($this->defaultUrl);
				}
				else
				{
					$vars['msg']['type'] = 0;
					$vars['msg']['value'] = validation_errors();
				}
				
			}
		}
	    $this->stock->displayView('usersGroups/form', $vars, $this->permissionsArray);		
	}
	public function delete()
	{	
		if(!isset($this->permissionsArray[1][3])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post()){			
				$this->usersGroups->delete($this->security->xss_clean($this->input->post()));			
		}
	    redirect($this->defaultUrl);	
	}
	public function setPermissions($id_group=0)
	{	
		if(!isset($this->permissionsArray[1][2])){
			redirect($this->defaultUrl);
		}
		
		if($this->usersGroups->getById($id_group) === 0){
			 redirect($this->defaultUrl);
		}
		$group = $this->usersGroups->getById($this->security->xss_clean($id_group));
		$vars['site_info'] = array("title"=>$group->name,
		"description"=> "Uprawnienia",
		"active"=> "usersGroups");
		$vars['formAction'] = base_url("usersGroups/setPermissions/".$id_group);
		if($this->input->post()){			
			$this->usersGroups->setPermissionsForGroup($id_group, $this->security->xss_clean($this->input->post()));
			$this->usersGroups->updatePermissionsGroupsForUserByGroupId($id_group);			
			
			$vars['msg']['type'] = 1;
			$vars['msg']['value'] = "Zapisano ustawienia.";
		}		
		$varsToBlock['permissionsBlocksArray'] = $this->authentication->getPermissionsBlocks();
		$varsToBlock['permissionsArray'] = $this->usersGroups->getPermissionsForGroup($id_group);
		$vars['blockPermissionsSettings'] = $this->load->view('blocks/blockPermissionsSettings',$varsToBlock, TRUE);
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Grupy użytkowników","url"=>$this->defaultUrl),
			array("name"=>$group->name,"url"=>$this->defaultUrl."/edit/".$id_group),
			array("name"=>"Uprawnienia","url"=>""),
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('usersGroups/formPermissions', $vars, $this->permissionsArray);		
	}
}
