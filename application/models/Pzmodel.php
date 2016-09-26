<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Pzmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function update($id_pz, $post){	
		$data['execution_date'] = $post['execution_date'];		
		$data['info'] = trim($post['info']);
		$data['date_last_edit'] = date("Y-m-d H:i:s");
		$data['hour_reception'] = trim($post['hour_reception']);
		$data['trawienie'] = trim($post['trawienie']);
		$data['szlifowanie'] = trim($post['szlifowanie']);
		$data['zapakowanie'] = trim($post['zapakowanie']);
		$data['przygotowanie'] = trim($post['przygotowanie']);
		$data['id_user_edit'] = $this->session->id_user;
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function updateSms($id_pz, $id_sms,$nr){	
		$data['id_sms_'.$nr] = $id_sms;
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function updateBill($id_pz, $post){	
		$data['bill_number'] = trim($post['bill_number']);	
		$data['bill_value'] = str_replace(",",".",$post['bill_value']);
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function changeStatus($id_pz, $id_status){		
		$data['id_status'] = $id_status;
		$data['id_user_edit'] = $this->session->id_user;
		$data['date_last_edit'] = date("Y-m-d H:i:s");
		if($id_status == 2){
			$data['date_to_realization'] = date("Y-m-d");
		}
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function updatePriority($id_pz,$priority){
		$data['priority'] = $priority;
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function setBillType($id_pz, $bill_type){		
		$data['bill_type'] = $bill_type;
		$this->db->where('id_pz',$id_pz);
		$this->db->update('pz',$data); 	
		return $this->db->affected_rows();	
	}
	public function updatePositionValues($post){	
		foreach($post['id_positions'] as $v=>$k){
			$data_temp['id'] = $k;
			$data_temp['quantity'] = str_replace(",",".",$post['quantity_'.$k]);
			$data_temp['quantity_unit2'] = str_replace(",",".",$post['quantity_unit2_'.$k]);
			$data_temp['unit'] = $post['unit_'.$k];
			$data_temp['price'] = str_replace(",",".",$post['price_'.$k]);
			$data[] = $data_temp;				
		}
		$this->db->update_batch('orders_positions', $data, 'id');
	}
	public function getById($id){
		$this->db->select('*');
		$this->db->from('pz');
		$this->db->where('id_pz',$id);
		$query = $this->db->get();	
		foreach ($query->result() as $row){ 
			if($row->execution_date == '0000-00-00' && $row->id_status < 2){
				$row->execution_date = date("Y-m-d");
			}
			return $row;
		}
		return 0;		
	}
	private function getMaxNumber(){		
		$this->db->select_max('number');
		$query = $this->db->get('pz');
		foreach ($query->result() as $row){       
			if($row->number)
				return $row->number;		
		}
		return 0;
	}
	public function generate($order){
		$data['id_order'] = $order->id_order;
		$data['id_user_add'] = $this->session->id_user;
		$data['id_user_edit'] = $this->session->id_user;
		$data['info'] = $order->info;
		$data['number'] = $this->getMaxNumber()+1;
		$this->db->insert('pz', $data); 
		return $this->db->insert_id();		
	}
	
	public function getAllTable($id_status = 0)
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */

	 $aColumns = array( 'pz.id_pz','pz.number','orders.consecutive_number','pz.execution_date','pz.hour_reception','pz.date_add','customers.name','pz.priority');
	
	$sIndexColumn = "id_pz";
	
	$sTable = "pz";
	
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
		$sWhere .= "and {$sTable}.id_status = ".$id_status." ";
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
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", 
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 0,1) paint1,
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 1,1) paint2,
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 2,1) paint3
		FROM   $sTable
		LEFT JOIN orders on {$sTable}.id_order = orders.id_order
		LEFT JOIN customers on orders.id_customer = customers.id_customer
		$sWhere
		$sOrder
		$sLimit
	";
	
	//file_put_contents("aa.txt",$sQuery);
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
		$aRow[] = "<input type='radio' name='r3' class='flat-red' value='{$row->id_pz}'>";
		$aRow[] = $row->number;	
		$aRow[] = $row->consecutive_number;
		$aRow[] = $row->execution_date;	
		$aRow[] = $row->hour_reception;
		$aRow[] = $row->date_add;
		$aRow[] = $row->name;
		$aRow[] = $row->priority;
		$aRow[] = $row->paint1.", ".$row->paint2.", ".$row->paint3;
		$output['data'][] = $aRow;
	}	
	
	return json_encode( $output );
	}
	
	public function  getTableToPdf($id_status = 0){
		$sql  = "SELECT pz.id_pz, pz.number, orders.consecutive_number, pz.execution_date, pz.hour_reception, pz.date_add, customers.name, pz.priority, 
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 0,1) paint1,
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 1,1) paint2,
		(SELECT name FROM orders_positions LEFT JOIN def_paints on def_paints.id_paint = orders_positions.id_paint  WHERE orders_positions.id_order = orders.id_order limit 2,1) paint3
		FROM   pz
		LEFT JOIN orders on pz.id_order = orders.id_order
		LEFT JOIN customers on orders.id_customer = customers.id_customer
		WHERE pz.deleted = 0 and pz.id_status = ".$id_status."
		ORDER BY  pz.priority
				 	asc, pz.execution_date
				 	asc, pz.hour_reception
				 	asc
		";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$data[] = $row;
		}
		 return $data;
	}

}