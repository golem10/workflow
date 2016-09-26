<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Ordersmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function getById($id){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('id_order',$id);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			if($row->delivery_date == '0000-00-00' && $row->id_status > 2){
				$row->delivery_date = date("Y-m-d");
			}
			return $row;
		}
		return 0;		
	}
	public function getStatusById($id){
		$this->db->select('*');
		$this->db->from('orders_statuses');
		$this->db->where('id_status',$id);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return $row;
		}
		return 0;		
	}
	private function getMaxNumber(){		
		$this->db->select_max('number');
		$query = $this->db->get('orders');
		foreach ($query->result() as $row){       
			if($row->number)
				return $row->number;		
		}
		return 0;
	}
	public function add($id_customer){
		$data['id_customer'] = $id_customer;
		$data['id_user_add'] = $this->session->id_user;
		$data['id_user_edit'] = $this->session->id_user;
		$data['date_last_edit'] = date("Y-m-d H:i:s");
		$data['number'] = $this->getMaxNumber()+1;
		$data['delivery_date'] =  date("Y-m-d H:i:s");
		$this->db->insert('orders',$data); 
		return $this->db->insert_id();			
	}
	public function update($id_order,$post){	
		$data['delivery_date'] = $post['delivery_date'];
		$data['info'] = trim($post['info']);
		$data['id_status'] = $post['id_status'];
		$data['consecutive_number'] = $post['consecutive_number'];
		$data['id_user_edit'] = $this->session->id_user;
		$data['date_last_edit'] = date("Y-m-d H:i:s");
		$this->deletePositions($id_order);
		$this->setPositions($id_order,$post);
		$this->db->where('id_order',$id_order);
		$this->db->update('orders',$data); 	
		return $this->db->affected_rows();	
	}
	public function changeStatus($id_order,$id_status){	
		$data['id_user_edit'] = $this->session->id_user;
		$data['date_last_edit'] = date("Y-m-d H:i:s");
		$data['id_status'] = $id_status;
		$this->db->where('id_order',$id_order);
		$this->db->update('orders',$data); 	
		return $this->db->affected_rows();	
	}
	public function setPzToOrder($id_order,$id_pz){		
		$data['id_pz'] = $id_pz;
		$this->db->where('id_order',$id_order);
		$this->db->update('orders',$data); 	
		return $this->db->affected_rows();	
	}
	private function setPositions($id_order,$post){
		if($post['element_name'][0] && $post['id_paint'][0]){
			$data[] = array(
			"element_name" => $post['element_name'][0],
			"id_paint" => $post['id_paint'][0],
			"id_order" => $id_order		
			);
		}
		if($post['element_name'][1] && $post['id_paint'][1]){
			$data[] = array(
			"element_name" => $post['element_name'][1],
			"id_paint" => $post['id_paint'][1],
			"id_order" => $id_order			
			);
		}
		if($post['element_name'][2] && $post['id_paint'][2]){
			$data[] = array(
			"element_name" => $post['element_name'][2],
			"id_paint" => $post['id_paint'][2],
			"id_order" => $id_order			
			);
		}
		if(isset($data)){
			$this->db->insert_batch('orders_positions', $data);
			return $this->db->affected_rows();
		}
	}
	private function deletePositions($id_order){
		$this->db->where('id_order',$id_order);
		$this->db->delete('orders_positions'); 	
		return $this->db->affected_rows();
	}
	// public function delete($post){
		// $this->db->where('id_paint',$post['id_delete']);
		// $data['deleted'] = 1;
		// $this->db->update('def_paints',$data); 	
		// return $this->db->affected_rows();
	// }
	public function getPositions($id_order = 0)
	{ 
		$this->db->select('id, element_name, id_paint, quantity,quantity_unit2, unit, price');
		$this->db->from('orders_positions');
		$this->db->where('id_order',$id_order);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function getPositionsPDF($id_order = 0)
	{ 
		$this->db->select('id, element_name, def_paints.name, quantity, unit, price');
		$this->db->join('def_paints', 'def_paints.id_paint = orders_positions.id_paint', 'left');
		$this->db->from('orders_positions');
		$this->db->where('id_order',$id_order);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function getStatuses(){
		$data = array();
		$this->db->select('*');
		$this->db->from('orders_statuses');
		$this->db->where('id_status !=',0);
		$this->db->order_by('order_by');
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;		
	}
	public function getAllTable($id_status = 0)
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */

	 $aColumns = array( 'id_order','number','customers.name','date_add','delivery_date');
	
	$sIndexColumn = "id_order";
	
	$sTable = "orders";
	
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
	$sWhere = "WHERE {$sTable}.deleted = 0 ";
	if($id_status)
	{
		$sWhere .= "and id_status = ".$id_status." ";
	}
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
		LEFT JOIN customers on {$sTable}.id_customer = customers.id_customer
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
		$aRow[] = "<input type='radio' name='r3' class='flat-red' value='{$row->id_order}'>";
		$aRow[] = $row->number;	
		$aRow[] = $row->name;	
		$aRow[] = $row->date_add;
		$aRow[] = $row->delivery_date;
		$output['data'][] = $aRow;
	}	

	
	return json_encode( $output );
	}

}