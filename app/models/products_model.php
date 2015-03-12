<?php
	class Products_model extends CI_Model
	{
		function __construct()
	    {
			parent::__construct();
	    }
	    
		function get_products()
		{
			$query = $this->db->get('produit', 10);
			return ($query->result());
		}
		
	}