<?php 
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Authenticationmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function checkAccessAndRedirect($id_object,$id_action){
		if(!$this->checkAccess($id_object,$id_action)){
			redirect(base_url("noAccess"));
		}
	}
	public function checkAccess($id_object,$id_action){
		$this->db->select('id_object, id_action');
		$this->db->from('authentication_action_object_user');
		$this->db->where('id_user',$this->session->id_user);
		$this->db->where('id_object',$id_object);
		$this->db->where('id_action',$id_action);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return 1;
		}
		return 0;
	}
	public function getAccessArray(){
		$this->db->select('id_object, id_action');
		$this->db->from('authentication_action_object_user');
		$this->db->where('id_user',$this->session->id_user);
		$data = array();
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			$data[$row->id_object][$row->id_action] = 1;
		}
		return $data;
	}
	public function logIn($email,$password)
	{	
		$this->db->select('id_user,id_club');
		$this->db->from('users');
		$this->db->where('email',strtolower($email));
		$this->db->where('password',$this->hashPass($password));
		$query = $this->db->get();
		$row = $query->row();
		if (isset($row))
		{
				$id_user = $row->id_user;
				$id_club = $row->id_club;
		}
		if(isset($id_user))
		{	
			$newdata = array(
			   'id_user'=> $id_user,
			   'id_club'=> $id_club,
			   'user_name'=> $email,
			   'logged_in' => TRUE		   
		    );			
			$this->lastLoginSetDate($id_user);
			$this->session->set_userdata($newdata);
			return 1;
		}
		else
			return 0;				
	}
	private function lastLoginSetDate($id_user){
		$data['last_login'] = date("Y-m-d H:i:s");
		$this->db->where('id_user',$id_user);
		$this->db->update('users',$data); 	
		return $this->db->affected_rows();	
	}
	public function logOut()
	{	
		$array_items = array('id_user','logged_in','id_club','user_name');
		$this->session->unset_userdata($array_items);
	}
	
	public function isLoggedIn()
	{			 
		return $this->session->userdata('logged_in');
	}

	public function hashPass($pass)
	{
		return md5($pass.KEY_CODE);
	}
	
		
	public function getPermissionsBlocks(){
		$query = "SELECT aog.id_group id_group ,aog.name name_group, ao.id_object id_object, ao.name name_object, aa.id_action id_action, aa.name  name_action FROM authentication_object_groups aog
		JOIN authentication_object_groups_object aogo ON aog.id_group = aogo.id_group
		JOIN authentication_object ao ON aogo.id_object = ao.id_object
		JOIN authentication_object_club aoc ON aogo.id_object = ao.id_object
		JOIN authentication_action_object aao ON ao.id_object = aao.id_object
		JOIN authentication_action aa ON aao.id_action = aa.id_action
		WHERE aoc.id_club = ".$this->session->id_club."
		ORDER BY aog.name,ao.name,aa.order_by
		";
		$result = $this->db->query($query);			
		foreach ($result->result() as $row)
		{ 
		$return[$row->id_group]['name'] = $row->name_group;
		$return[$row->id_group]['objects'][$row->id_object]['name'] = $row->name_object;
		$return[$row->id_group]['objects'][$row->id_object]['actions'][$row->id_action]['name'] = $row->name_action;
		}
		return $return;
		
	}
	
	
	
}