<?php
class Epin_model extends Master_model
{

    function __construct()
    {
        parent::__construct();
    }

    function user()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('first_name', 'ASC');
        $rest = $this->db->get()->result();
        return $rest;
    }

    function user_pin()
    {
        $u = $this->session->userdata('login');
        $this->db->select('*');
        $this->db->from('epin');
        //$this -> db -> where("pin_status", 1);
        $this->db->where('user_id', $u['user_id']);
        $this->db->order_by('id', 'DESC');
        $rest = $this->db->get()->result();
        return $rest;
    }

    function filter_img($match)
    {
        $array = array('file_name' => $match, 'img_title' => $match, 'img_alt' => $match);
        $this->db->like($array);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result();
    }
    function newpin()
    {
        $length = 6;
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $pin = '';
        for ($i = 0; $i < $length; $i++) {
            $pin .= $characters[rand(0, $charactersLength - 1)];
        }
        $c = $this->db->get_where("epin", array('pin' => $pin))->num_rows();
        if ($c == 0) {
            return $pin;
        } else {
            return $this->newpin();
        }
    }

    function used_pin()
    {
        $u = $this->session->userdata('login');
        $this->db->select('*, users.userid, users.first_name, users.last_name, users.mobile');
        $this->db->from('epin');
        $this->db->join("users", "users.epin = epin.pin");
        $this->db->where('user_id', $u['user_id']);
        $this->db->where('epin.pin_status=', 0);
        $this->db->order_by('epin.id', 'DESC');
        $rest = $this->db->get()->result();
        return $rest;
    }
    function check_position($user_id)
    {
        return $this->db->get_where('level_manager', array('user_id' => $user_id))->num_rows();
    }

    function already_Payout($user_id, $spid)
    {
        return $this->db->get_where('bonus', array('user_id' => $user_id, 'sp_id' => $spid))->num_rows();
    }

    function member_position($user_id)
    {
        $position = $this->db->select('role')->get_where('users', array('id' => $user_id))->row();
        return $position->role;
    }
    function is_level_completed($user_id, $level = false)
    {
        $ids = array();
        $flag_1 = $flag_2 = $flag_3 = false;
        $ids = $this->direct_childs($user_id);
        $level_info = $this->level_info($level);
        $member2 = $member4 = $member8 = 0;
        if (is_object($level_info)) {
            $member2 = $level_info->member_2;
            $member4 = $level_info->member_4;
            $member8 = $level_info->member_8;
        }

        if (count($ids) == 2) {
            $flag_1 = true;
            $amt = $member2;
            foreach ($ids as $spid) {
                $s = $this->already_Payout($user_id, $spid);
                if ($s == 0) {
                    //$this->add_to_payout($user_id,$amt,'direct','cr',$spid);
                }
            }
        }
        if ($flag_1) {
            $ids_0 = $this->direct_childs($ids[0]);
            $ids_1 = $this->direct_childs($ids[1]);
            $ids = array_merge($ids_0, $ids_1);
            //print_r($ids);
            if (count($ids_0) == 2 && count($ids_1) == 2) {
                $flag_2 = true;
                $amt = $member4;
                foreach ($ids as $spid) {
                    $s = $this->already_Payout($user_id, $spid);
                    if ($s == 0) {
                        // $this->add_to_payout($user_id,$amt,'direct','cr',$spid);
                    }
                }
            }
        }

        if ($flag_2) {
            $ids_0 = $this->direct_childs($ids[0]);
            $ids_1 = $this->direct_childs($ids[1]);
            $ids_2 = $this->direct_childs($ids[2]);
            $ids_3 = $this->direct_childs($ids[3]);
            $ids = array_merge($ids_0, $ids_1, $ids_2, $ids_3);

            if (count($ids_0) == 2 && count($ids_1) == 2 && count($ids_2) == 2 && count($ids_3) == 2) {
                $flag_3 = true;
                $amt = $member8;
                foreach ($ids as $spid) {
                    $s = $this->already_Payout($user_id, $spid);
                    if ($s == 0) {
                        // $this->add_to_payout($user_id,$amt,'direct','cr',$spid);
                    }
                }
            }
        }
        if ($flag_3) {
            // upgrade to level_manage_table
            // $arr = $this->db->update('level_manager',array('level_id'=>$level_info->id),array('user_id'=>$user_id));

            //level upgrade charge
            // $this->level_upgrade_charge($user_id,$level,$level_info->upgrade_charge,$level_info->reward,$level_info->level);
        }
    }

    function level_upgrade_charge($user_id, $role, $level_charge, $reward, $level_name)
    {
        //upgrade user level
        $ur = array('role' => $role);
        $this->db->update('users', $ur, array('id' => $user_id));

        //level upgrade charge
        $arr = array(
            'id' => false,
            'user_id' => $user_id,
            'amount' => $level_charge,
            'bonus_type' => 'level_upgrade_charge-' . $level_name,
            'drcr' => 'dr'
        );

        $this->db->insert('bonus', $arr);
        //level upgrade charge
        $arr1 = array(
            'id' => false,
            'user_id' => $user_id,
            'amount' => $reward,
            'bonus_type' => 'level_upgrade_reward-' . $level_name,
            'drcr' => 'cr'
        );
        $this->db->insert('bonus', $arr1);
    }



    function direct_childs($user_id)
    {
        $rest =  $this->db->select("id")->get_where("users", array('sponsor_id' => $user_id))->result();
        $ids = array();
        if (is_array($rest) && count($rest) > 0) {
            foreach ($rest as $r) {
                $ids[] = $r->id;
            }
        }
        return $ids;
    }


    function get_parent_of_parent($user_id)
    {
        $flag_1 = $flag_2 = $flag_3 = false;
        $ids = $this->direct_parent($user_id);
        if ($ids) {
            $flag_1 = true;
            $ids =  $this->direct_parent($ids);
        }
        if ($flag_1) {
            $flag_2 = true;
            $ids =  $this->direct_parent($ids);
        }
        if ($flag_2) {
            $flag_3 = true;
        }
        if ($flag_1 and $flag_2 and $flag_3) {
            return $ids;
        } else {
            return false;
        }
    }
    function direct_parent($user_id)
    {
        $rest =  $this->db->select("id,sponsor_id")->get_where("users", array('id' => $user_id))->row();

        if (is_object($rest)) {

            return $rest->sponsor_id;
        }
    }

    function level_info($level)
    {
        $rest =  $this->db->get_where("role", array('id' => $level))->row();
        return $rest;
    }

    function add_to_payout($user_id, $amt, $inc_type, $drcr, $spid)
    {

        //level upgrade charge
        $arr = array(
            'id' => false,
            'user_id' => $user_id,
            'amount' => $amt,
            'bonus_type' => $inc_type,
            'drcr' => $drcr,
            'sp_id' => $spid
        );

        $this->db->insert('bonus', $arr);
    }

    function check_mobile_unique($mb)
    {

        $num = $this->db->get_where('users', array('mobile' => $mb))->num_rows();
        return $num;
    }


    function generatePackageCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 8);
        $chk = $this->db->get_where('package', array('pcode' => $code))->num_rows();
        if ($chk == 0) {
            return $code;
        } else {
            return $this->generatePackageCode();
        }
    }
}
