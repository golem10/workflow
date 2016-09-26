<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Elementsmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function getById($id){
		$this->db->select('id_element, name');
		$this->db->from('def_elements');
		$this->db->where('id_element',$id);
		$query = $this->db->get();	
		foreach ($query->result() as $row){       
			return $row;
		}
		return 0;		
	}
	public function getAll()
	{ 
		$this->db->select('id_element, name');
		$this->db->from('def_elements');
		$this->db->where('deleted',0);
		$query = $this->db->get();	
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
	}
	public function add($post){
		$data['name'] = $post['name'];
		$this->db->insert('def_elements',$data); 
		return $this->db->insert_id();			
	}
	public function update($id_element,$post){
		$data['name'] = $post['name'];
		$this->db->where('id_element',$id_element);
		$this->db->update('def_elements',$data); 	
		return $this->db->affected_rows();	
	}
	
	public function delete($post){
		$this->db->where('id_element',$post['id_delete']);
		$data['deleted'] = 1;
		$this->db->update('def_elements',$data); 	
		return $this->db->affected_rows();
	}
	
	public function getAllTable()
	{ 
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */

	 $aColumns = array( 'id_element','name');
	
	$sIndexColumn = "id_element";
	
	$sTable = "def_elements";
	
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
		$aRow[] = "<input type='radio' name='r3' class='flat-red' value='{$row->id_element}'>";
		$aRow[] = $row->name;	
		$output['data'][] = $aRow;
	}	

	
	return json_encode( $output );
	}

}