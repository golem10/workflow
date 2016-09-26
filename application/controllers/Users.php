<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	private $permissionsArray;
	private $defaultUrl;
	function __construct()
  	{
		parent::__construct();
		$this->load->model('usersmodel','users');
		$this->load->model('Usersgroupsmodel','usersGroups');
		$this->load->library('form_validation');
		$this->defaultUrl = base_url('/users/');
		$this->permissionsArray = $this->authentication->getAccessArray();
		if(!isset($this->permissionsArray[2])){
			redirect(base_url());
		}
	}
	
	public function index()
	{		
	    $vars['site_info'] = array("title"=>"Użytkownicy",
		"description"=> "Lista",
		"active"=> "users");
		$vars['js'] = array("list.js");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Użytkownicy","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('users/list', $vars, $this->permissionsArray);		
	}
	public function getAllTable()
	{	
	   echo $this->users->getAllTable();		
	}
	public function add()
	{	
		if(!isset($this->permissionsArray[2][1])){
			redirect($this->defaultUrl);
		}
		
	   $vars['site_info'] = array("title"=>"Użytkownicy",
		"description"=> "Dodaj",
		"active"=> "users");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Użytkownicy","url"=>$this->defaultUrl),
			array("name"=>"Dodaj","url"=>"")
		);
		$vars['formAction'] = base_url("users/add");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		$vars['user'] = (object) array('first_name' => '','second_name' => '','email' => '');
		$vars['user_groups'] = $this->usersGroups->getAll();		
		if($this->input->post()){
			if ($this->form_validation->run('user') == TRUE)
			{
					$id_user = $this->users->add($this->security->xss_clean($this->input->post()));
					$this->users->deleteGroupsForUser($id_user);
					if($this->input->post('id_group')){
						$this->users->setGroupsForUser($id_user, $this->security->xss_clean($this->input->post('id_group')));
					}
					redirect($this->defaultUrl);
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
	    $this->stock->displayView('users/form', $vars, $this->permissionsArray);		
	}
	public function changePassword()
	{
		$vars['site_info'] = array("title"=>"Zmień hasło",
		"description"=> "",
		"active"=> "");
		
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Zmień hasło","url"=>""),
		);
		$vars['formAction'] = base_url("users/changePassword");
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		
		if($this->input->post()){
			if ($this->form_validation->run('changePassword') == TRUE)
			{
					$this->users->changePassword($this->session->userdata('id_user'),$this->security->xss_clean($this->input->post()));		
					$vars['msg']['type'] = 1;
					$vars['msg']['value'] = "Hasło zostało zmienione.";
			}
			else
			{
				$vars['msg']['type'] = 0;
				$vars['msg']['value'] = validation_errors();
			}
			
		}
		$this->stock->displayView('users/changePasswordForm', $vars, $this->permissionsArray);		
	}
	public function edit($id_userGet = 0)
	{	
		if(!isset($this->permissionsArray[2][2])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post('id_edit')){
			$id_user = $this->security->xss_clean($this->input->post('id_edit'));
		}
		else{
			$id_user = $this->security->xss_clean($id_userGet);			
		}
		$vars['user'] = $this->users->getById($id_user);		
		if(!$vars['user']){
			redirect($this->defaultUrl);
		}
		$vars['user_groups'] = $this->usersGroups->getAllWithAssignedUsers($id_user);
		$vars['formAction'] = base_url("users/edit");
		$vars['is_edit'] = 1;
	    $vars['site_info'] = array("title"=>$vars['user']->email,
		"description"=> "Edytuj",
		"active"=> "users");
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Użytkownicy","url"=>$this->defaultUrl),
			array("name"=>"Edytuj","url"=>"")
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
		if(!$this->input->post('redirect')){
			if($this->input->post()){
				if ($this->form_validation->run('userEdit') == TRUE)
				{
					$this->users->update($id_user, $this->security->xss_clean($this->input->post()));
					$this->users->deleteGroupsForUser($id_user);
					if($this->input->post('id_group')){
						$this->users->setGroupsForUser($id_user, $this->security->xss_clean($this->input->post('id_group')));
					}
					redirect($this->defaultUrl);
				}
				else
				{
					$vars['msg']['type'] = 0;
					$vars['msg']['value'] = validation_errors();
				}
				
			}
		}
	    $this->stock->displayView('users/form', $vars, $this->permissionsArray);		
	}
	public function delete()
	{	
		if(!isset($this->permissionsArray[2][3])){
			redirect($this->defaultUrl);
		}
		
		if($this->input->post()){			
				$this->users->delete($this->security->xss_clean($this->input->post()));			
		}
	    redirect($this->defaultUrl);	
	}
	public function setPermissions($id_user=0)
	{	
		if(!isset($this->permissionsArray[2][4])){
			redirect($this->defaultUrl);
		}
	
		if($this->users->getById($id_user) === 0){
			 redirect($this->defaultUrl);
		}
		$user = $this->users->getById($this->security->xss_clean($id_user));
		$vars['id_user'] = $id_user;
		$vars['site_info'] = array("title"=>$user->email,
		"description"=> "Uprawnienia",
		"active"=> "users");
		$vars['formAction'] = base_url("users/setPermissions/".$id_user);
		if($this->input->post()){			
			$this->users->setPermissionsForUser($id_user, $this->security->xss_clean($this->input->post()));	
			$vars['msg']['type'] = 1;
			$vars['msg']['value'] = "Zapisano ustawienia.";
		}		
		$varsToBlock['permissionsBlocksArray'] = $this->authentication->getPermissionsBlocks();
		$varsToBlock['permissionsArray'] = $this->users->getPermissionsForUser($id_user);
		$vars['blockPermissionsSettings'] = $this->load->view('blocks/blockPermissionsSettings',$varsToBlock, TRUE);
		$breadcrumbs['breadcrumbs'] = array(
			array("name"=>"Użytkownicy","url"=>$this->defaultUrl),
			array("name"=>$user->email,"url"=>$this->defaultUrl."/edit/".$id_user),
			array("name"=>"Uprawnienia","url"=>""),
		);
		$vars['breadcrumbs'] = $this->load->view('blocks/blockBreadcrumbs',$breadcrumbs, TRUE);
	    $this->stock->displayView('users/formPermissions', $vars, $this->permissionsArray);		
	}
}
