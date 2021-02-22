<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Site_library {
	public function __construct()
	{
		$this->CI =& get_instance();
		
	}
	public function myhash($password) 
{  
      
        $salt = "sam@mtcg";  
        $hash = sha1($salt . $password);  
        // make it take 1000 times longer  
        for ($i = 0; $i < 1000; $i++) {  
            $hash = sha1($hash);  
        }  
      
        return $hash;  
    }  

	
	}
// END Session Class

/* End of file Session.php */
/* Location: ./system/libraries/Session.php */