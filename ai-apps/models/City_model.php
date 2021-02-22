<?php
class City_model extends Master_model{

	function __construct(){
		parent::__construct();
        $this -> table = 'cities';
	}

	function getStates($id = false){
		if($id){
			$r = $this -> db -> get_where('states', array('id' => $id)) -> first_row();
			return $r;
		}
		$this -> db -> order_by('state_name', 'ASC');
		$r = $this -> db -> get('states') -> result();
		return $r;
	}

    function getCities($state_id=false){
        if($state_id) {
            return $this->db->get_where('cities', array('state_id' => $state_id))->result();
        }
        else{
            return $this->db->get('cities')->result();
        }
    }

    function stateName($id){
        return $this->db->get_where('states', array('id'=>$id))->row();
    }

    function cityName($id){
        return $this->db->get_where('cities', array('id'=>$id))->row();
    }

    function getStoreByCity($state, $city){
        if($state && $city) {
            return $this->db->get_where('store', array('state_id' => $state, 'city_id'=>$city))->result();
        }
        else{
            return $this->db->get('store')->result();
        }
    }
    
    function store_text(){
        return $this->db->get('store_text')->row();
    }
}
