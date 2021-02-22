<?php

class Admin_model extends Master_model
{

    var $user_role, $error;

    function __construct()
    {
        parent::__construct();
        $this->table = "admin";
    }

    public function authenticate($em, $pw)
    {
        $this->db->where(array(
            'email_id' => $em,
            'password' => $pw,
            'status' => 1
        ));
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getAdmin($email_id)
    {
        return $this->db->get_where($this->table, array("email_id" => $email_id))->row();
    }
}
