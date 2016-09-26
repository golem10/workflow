<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Usersmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function getById($id){
		$this->db->select('id_user, email, first_name, second_name');
		$this->db->from('users');
		$this->db->where('id_user',$id);
		$this->db->where('id_club',$this->session->id_club);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return $row;
		}
		return 0;		
	}
	public function add($post){
		$data['id_club'] = $this->session->id_club;
		$data['first_name'] = $post['first_name'];
		$data['second_name'] = $post['second_name'];
		$data['email'] = $post['email'];
		$data['password'] = $this->authentication->hashPass($post['password']);
		$this->db->insert('users',$data); 
		return $this->db->insert_id();			
	}
	public function update($id_user,$post){
		$data['first_name'] = $post['first_name'];
		$data['second_name'] = $post['second_name'];
		if($post['password']){
			 $data['password'] = $this->authentication->hashPass($post['password']);
		}
		$this->db->where('id_user',$id_user);
		$this->db->where('id_club',$this->session->id_club);
		$this->db->update('users',$data); 	
		return $this->db->affected_rows();	
	}
	public function changePassword($id_user,$post){		
		if($post['password']){
			 $data['password'] = $this->authentication->hashPass($post['password']);
		}
		$this->db->where('id_user',$id_user);
		$this->db->where('id_club',$this->session->id_club);
		$this->db->update('users',$data); 	
		return $this->db->affected_rows();	
	}
	public function delete($post){
		$this->db->where('id_user',$post['id_delete']);
		$this->db->where('id_club',$this->session->id_club);
		$data['deleted'] = 1;
		$this->db->update('users',$data); 	
		return $this->db->affected_rows();
	}
	public function setGroupsForUser($id_user, $post){	
		$i=0;
		$id_groupsArray = array();
		foreach($post as $v){		
				$data[$i]['id_group'] = $v;
				$data[$i]['id_user'] = $id_user;
				$id_groupsArray[] = $v;
				$i++;
		}
		$this->setPermissionsFromGroups($id_user,$id_groupsArray);
		$this->db->insert_batch('users_groups_users', $data);
		return $this->db->affected_rows();
		
	}
	public function setPermissionsFromGroups($id_user,$id_groupsArray){
		$this->deletePermissionsForUser($id_user);
		$this->db->select('id_object, id_action');
		$this->db->distinct();
		$this->db->from('authentication_action_object_group');
		$this->db->where_in('id_group',$id_groupsArray);
		$query = $this->db->get();
		$data = array();
		$i=0;
		foreach ($query->result() as $row){   
			$data[$i]['id_user'] = $id_user;
			$data[$i]['id_object'] = $row->id_object;
			$data[$i]['id_action'] = $row->id_action;	
			$i++;
		}
		if(count($data)){
			$this->db->insert_batch('authentication_action_object_user', $data);
		}
	}
	public function deleteGroupsForUser($id){
		$this->db->where('id_user',$id);
		$this->db->delete('users_groups_users');
		return $this->db->affected_rows();
	}
	
	public function getPermissionsForUser($id){
		$this->db->select('id_object, id_action');
		$this->db->from('authentication_action_object_user');
		$this->db->where('id_user',$id);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function setPermissionsForUser($id, $post){
		$i = 0;
		$this->deletePermissionsForUser($id);
		foreach($post as $k=>$v){			
			foreach($v as $id_action){				
				$data[$i]['id_user'] = $id;
				$data[$i]['id_object'] = $k;
				$data[$i]['id_action']  =$id_action;
				$i++;
			}
		}
		$this->db->insert_batch('authentication_action_object_user', $data);
		return $this->db->affected_rows();
	}
	private function deletePermissionsForUser($id){
		$this->db->where('id_user',$id);
		$this->db->delete('authentication_action_object_user'); 	
		return $this->db->affected_rows();		
	}
	public function getAllTable()
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */

	 $aColumns = array( 'id_user','email', 'first_name', 'second_name');
	
	$sIndexColumn = "id_user";
	
	$sTable = "users";
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' )
	{
		$sLimit = "LIMIT ".$this->db->escape_like_str(  $_GET['start'] ).", ".
			$this->db->escape_like_str( $_GET['length'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder="";
	if ( isset($_GET['order']) && count($_GET['order']) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<count( $_GET['order'] ) ; $i++ )
		{
			if ( $_GET['columns'][$i]['orderable']  == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['order'][$i]['column'] ) ]."
				 	".$this->db->escape_like_str( $_GET['order'][$i]['dir'] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "WHERE deleted = 0 and id_club = ".$this->session->id_club;
	if ( $_GET['search']['value'] != "" )
	{
		$sWhere .= " AND (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%". $this->db->escape_like_str( $_GET['search']['value'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}

	/* Individual column filtering */
	// for ( $i=0 ; $i<count($aColumns) ; $i++ )
	// {
		// if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		// {
			// if ( $sWhere == "" )
			// {
				// $sWhere = "WHERE ";
			// }
			// else
			// {
				// $sWhere .= " AND ";
			// }
			// $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		// }
	// }
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */

	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	
	$rResult = $this->db->query($sQuery);	
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as FilteredTotal
	";
	$rResultFilterTotal = $this->db->query($sQuery);
	$aResultFilterTotal = $rResultFilterTotal->row();
	$iFilteredTotal = $aResultFilterTotal->FilteredTotal;
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.") as Total
		FROM   $sTable
	";
	$rResultTotal = $this->db->query($sQuery);
	$aResultTotal = $rResultTotal->row();
	$iTotal = $aResultTotal->Total;
	
	
	
	/*
	 * Output
	 */
	$output = array(
		"draw" => intval($_GET['draw']),
		"recordsTotal" => $iTotal,
		"recordsFiltered" => $iFilteredTotal,
		"data" => array()
	);
	foreach ($rResult->result() as $row)
	{       
		$aRow=array();
		$aRow[] = "<input type='radio' name='r3' class='flat-red' value='{$row->id_user}'>";
		$aRow[] = $row->email;
		$aRow[] = $row->first_name;
		$aRow[] = $row->second_name;
		$output['data'][] = $aRow;
	}	

	
	return json_encode( $output );
	}

}