<?php
class Package_model extends Master_model{

	function __construct(){
		$this -> table = 'ai_package';
	}

    function package_type()
    {
        $pack = array('1'=>'Registration','2'=>'Topup');
        return $pack;
    }

    function package_info($id)
    {
        if($id==1){
            return 'Registration';
        }
        elseif($id==2){
            return 'Topup';
        }
        elseif($id==3)
        {
            return 'Others';
        }

    }

    function package_detail()
    {
         $pack = array('1'=>'Registration','2'=>'Topup','3'=>'Others');
        return $pack;
    }
    
    function package($id)
    {
        return $this->db->get_where('package',array('id'=>$id))->row();
    }

    function package_name($id)
    {
        $x = $this->db->get_where('package',array('id'=>$id))->row();
        if(is_object($x)){
            return $x->package;
        }
    }

}
