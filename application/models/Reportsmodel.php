<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Reportsmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
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
	public function exposedPz($range_from, $range_to){
		$data = array();
		$sql = "SELECT p.id_order, date(p.date_add) date_add, p.number, p.execution_date, p.bill_number, c.name, o.delivery_date, (select sum(quantity*price)  vv from orders_positions op where op.id_order = o.id_order) pz_value, IF(p.id_status = 3,date(p.date_last_edit),'n/d') execution_date_complete
		FROM pz p 
		LEFT JOIN orders o on o.id_order = p.id_order
		LEFT JOIN customers c on o.id_customer = c.id_customer
		";
		$where = " WHERE ";
		if($range_from != $range_to){
			$where .= "date(p.date_add) >= '".$range_from."' and  date(p.date_add) <= '".$range_to."' ";
		}
		else{
			$where .= "date(p.date_add) = '".$range_from."' ";
		}
		$sql .= $where;
		$query = $this->db->query($sql);
		$i=0;
		foreach ($query->result() as $row){
			$data[] = $row;
		}
		 return $data;
	}
	public function executedPz($range_from, $range_to){
		$data = array();
		$sql = "SELECT date(p.date_add) date_add, p.number, p.execution_date, p.bill_number, c.name, o.delivery_date, (select sum(quantity*price)  vv from orders_positions op where op.id_order = o.id_order) pz_value, IF(p.id_status = 3,date(p.date_last_edit),'n/d') execution_date_complete
		FROM pz p 
		LEFT JOIN orders o on o.id_order = p.id_order
		LEFT JOIN customers c on o.id_customer = c.id_customer
		";
		$where = " WHERE p.id_status = 3 and ";
		if($range_from != $range_to){
			$where .= "date(p.date_add) >= '".$range_from."' and  date(p.date_add) <= '".$range_to."' ";
		}
		else{
			$where .= "date(p.date_add) = '".$range_from."' ";
		}
		$sql .= $where;
		
		$query = $this->db->query($sql);
		$i=0;
		foreach ($query->result() as $row){
			$data[] = $row;
		}
		 return $data;
	}
	public function inProgressPz($range_from, $range_to){
		$data = array();
		$sql = "SELECT date(p.date_add) date_add, p.number, p.execution_date, p.bill_number, c.name, o.delivery_date, (select sum(quantity*price)  vv from orders_positions op where op.id_order = o.id_order) pz_value
		FROM pz p 
		LEFT JOIN orders o on o.id_order = p.id_order
		LEFT JOIN customers c on o.id_customer = c.id_customer
		";
		$where = " WHERE p.id_status = 2 and ";
		if($range_from != $range_to){
			$where .= "date(p.date_add) >= '".$range_from."' and  date(p.date_add) <= '".$range_to."' ";
		}
		else{
			$where .= "date(p.date_add) = '".$range_from."' ";
		}
		$sql .= $where;
		
		$query = $this->db->query($sql);
		$i=0;
		foreach ($query->result() as $row){
			$data[] = $row;
		}
		 return $data;
	}
	public function elementsToPz($pz){
		$data = array();
		foreach ($pz as $v){
			$id_orders[] = $v->id_order;
		}
		$this->db->select('element_name,id_order,name');
		$this->db->from('orders_positions');
		$this->db->join('def_paints', 'orders_positions.id_paint = def_paints.id_paint', 'left');
		$this->db->where_in('id_order',$id_orders);
		$query = $this->db->get();
		
		 foreach ($query->result() as $row){
			 $data[$row->id_order][] = $row->element_name.", ".$row->name;
		 }
		
		 return $data;
	}
	public function paints($range_from, $range_to){
		$data = array();
		// $sql = "SELECT op.unit unit,dp.name name,sum(op.quantity) quantity FROM orders_positions op
			 // JOIN orders o on op.id_order = o.id_order
			 // JOIN pz p on p.id_order = o.id_order
			 // JOIN def_paints dp on dp.id_paint = op.id_paint";
		// $where = " WHERE ";
		// if($range_from != $range_to){
			// $where .= "date(p.date_to_realization) >= '".$range_from."' and  date(p.date_to_realization) <= '".$range_to."' ";
		// }
		// else{
			// $where .= "date(p.date_to_realization) = '".$range_from."' ";
		// }
		// $sql .= $where." GROUP BY op.unit,dp.name";
		$sql = "SELECT 'kg' as unit, dp.name name,sum(op.quantity_unit2) quantity FROM orders_positions op
			  JOIN orders o on op.id_order = o.id_order
			  JOIN pz p on p.id_order = o.id_order
			 JOIN def_paints dp on dp.id_paint = op.id_paint";
		$where = " WHERE ";
		if($range_from != $range_to){
			$where .= "date(p.date_to_realization) >= '".$range_from."' and  date(p.date_to_realization) <= '".$range_to."' ";
		}
		else{
			$where .= "date(p.date_to_realization) = '".$range_from."' ";
		}
		$sql .= $where." GROUP BY dp.name";	
		$query = $this->db->query($sql);
		$data = array();
		foreach ($query->result() as $row){       
			$data[] = $row;
		}
		return $data;
		
	}

}