<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Customersmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function getById($id){
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('id_customer',$id);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return $row;
		}
		return 0;		
	}
	public function add($post){
		$data['name'] = $post['name'];
		$data['email'] = $post['email'];
		$data['post_code'] = $post['post_code'];
		$data['city'] = $post['city'];
		$data['street'] = $post['street'];
		$data['phone'] = $post['phone'];
		$data['person'] = $post['person'];
		$data['nip'] = $post['nip'];
		$this->db->insert('customers',$data); 
		return $this->db->insert_id();			
	}
	public function update($id_customer,$post){
		$data['name'] = $post['name'];
		$data['email'] = $post['email'];
		$data['post_code'] = $post['post_code'];
		$data['city'] = $post['city'];
		$data['street'] = $post['street'];
		$data['phone'] = $post['phone'];
		$data['person'] = $post['person'];
		$data['nip'] = $post['nip'];
		$this->db->where('id_customer',$id_customer);
		$this->db->update('customers',$data); 	
		return $this->db->affected_rows();	
	}
	
	public function delete($post){
		$this->db->where('id_customer',$post['id_delete']);
		$data['deleted'] = 1;
		$this->db->update('customers',$data); 	
		return $this->db->affected_rows();
	}
	
	public function getAllTable()
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */

	 $aColumns = array( 'id_customer','name', 'email', 'person');
	
	$sIndexColumn = "id_customer";
	
	$sTable = "customers";
	
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
	$sWhere = "WHERE deleted = 0 ";
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
		$aRow[] = "<input type='radio' name='r3' class='flat-red' value='{$row->id_customer}'>";
		$aRow[] = $row->name;
		$aRow[] = $row->email;
		$aRow[] = $row->person;
		$output['data'][] = $aRow;
	}	

	
	return json_encode( $output );
	}

}