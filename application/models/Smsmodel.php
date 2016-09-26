<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Smsmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	
	public function add($post){
		$data['id_user'] = $this->session->id_user;
		$data['date'] = date("Y-m-d");
		$this->db->insert('sms',$data); 
		return $this->db->insert_id();			
	}
	
}