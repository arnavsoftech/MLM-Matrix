<?php



class Fransadmin_model extends Master_model {



    var $user_role, $error;



    function __construct() {

        parent::__construct();

        $this -> table = "franch";

    }



    public function authenticate($em, $pw) {

        $this -> db -> where(array(

            'userid' => $em,

            'passwd' => $pw,

            'status' => 1

        ));

        $query = $this -> db -> get($this -> table);

        if ($query -> num_rows() > 0) {

            return TRUE;

        } else {

            return FALSE;

        }

    }



    function getAdmin($email_id) {

        return $this -> db -> get_where($this -> table, array("userid" => $email_id)) -> row();

    }



}

