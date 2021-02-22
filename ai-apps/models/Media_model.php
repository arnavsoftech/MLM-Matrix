<?php
class Media_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'media';
	}

	function allimages(){
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(100);
		return $this -> db -> get($this -> table) -> result();
	}

    function filter_img($match){
        $array = array('file_name' => $match, 'img_title' => $match, 'img_alt' => $match);
        $this -> db -> like($array);
        $this -> db -> order_by('id', 'DESC');
        return $this -> db -> get($this -> table) -> result();
    }
}
