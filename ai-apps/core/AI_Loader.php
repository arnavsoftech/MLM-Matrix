<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AI_Loader extends CI_Loader {

    function __construct(){
        parent::__construct();
    }

    function front_view($file, $data = array(), $return = false){
        $theme = config_item("themes");
        $file = '../../ai-content/themes/' . $theme . '/'.$file;
        return parent::view($file, $data, $return);
    }
}
