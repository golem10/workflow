<?php

class UsersGroupsmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
		$this->load->model('usersmodel','users');
    }
	
	public function add($post){
		$data['name'] = $post['name'];
		$data['id_club'] = $this->session->id_club;
		$this->db->insert('users_groups',$data); 
		return $this->db->insert_id();	
	}
	public function update($post){
		$data['name'] = $post['name'];
		$this->db->where('id_group',$post['id_edit']);
		$this->db->where('id_club',$this->session->id_club);
		$this->db->update('users_groups',$data);
		return $this->db->affected_rows();		
	}
	public function delete($post){
		$this->db->where('id_group',$post['id_delete']);
		$this->db->where('id_club',$this->session->id_club);
		$this->db->delete('users_groups'); 	
		return $this->db->affected_rows();
	}
	public function getById($id){

		$this->db->select('id_group, name');
		$this->db->from('users_groups');
		$this->db->where('id_group',$id);
		$this->db->where('id_club',$this->session->id_club);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return $row;
		}
		return 0;		
	}
	
	public function getPermissionsForGroup($id){
		$this->db->select('id_object, id_action');
		$this->db->from('authentication_action_object_group');
		$this->db->where('id_group',$id);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function updatePermissionsGroupsForUserByGroupId($id_group){
		$this->db->select('ugu.id_user,ugu2.id_group');
		$this->db->from('users_groups_users ugu');
		$this->db->join('users_groups_users ugu2', 'ugu.id_user = ugu2.id_user', 'left');
		$this->db->where('ugu.id_group',$id_group);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[$row->id_user][] = $row->id_group;
		}
		foreach ($data as $k=>$v){     	
			$this->users->setPermissionsFromGroups($k,$v);
		}
	}
	public function setPermissionsForGroup($id, $post){
		$i = 0;
		$this->deletePermissionsForGroup($id);
		foreach($post as $k=>$v){			
			foreach($v as $id_action){				
				$data[$i]['id_group'] = $id;
				$data[$i]['id_object'] = $k;
				$data[$i]['id_action']  =$id_action;
				$i++;
			}
		}
		$this->db->insert_batch('authentication_action_object_group', $data);
		return $this->db->affected_rows();
	}
	private function deletePermissionsForGroup($id){
		$this->db->where('id_group',$id);
		return $this->db->delete('authentication_action_object_group'); 			
	}
	public function getAll()
	{ 
		$this->db->select('id_group, name');
		$this->db->from('users_groups');
		$this->db->where('id_club',$this->session->id_club);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function getAllWithAssignedUsers($id_user = 0)
	{ 
		$this->db->select('users_groups.id_group, name, id_user');
		$this->db->from('users_groups');
		$this->db->join('users_groups_users', 'users_groups_users.id_group = users_groups.id_group and users_groups_users.id_user = '.$id_user, 'left');
		$this->db->where('id_club',$this->session->id_club);
		$this->db->order_by('id_user','desc');
		$this->db->order_by('name','asc');
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function getAllTable()
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */
	
	$aColumns = array( 'id_group','name');
	
	$sIndexColumn = "id_group";
	
	$sTable = "users_groups";
	
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
	$sWhere = "WHERE id_club = ".$this->session->id_club;
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
		$aRow[] = "<input type='radio' name='r3' class='flat-red list-select' value='{$row->id_group}'>";			
		$aRow[] = $row->name;			
		$output['data'][] = $aRow;	
	}	

	
	return json_encode( $output );
	}

}