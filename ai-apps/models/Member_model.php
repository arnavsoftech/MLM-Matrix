<?php

class Member_model extends CI_Model
{



    var $direct_income = 100;

    var $pin_income = 30;

    var $bonus_income = 250;

    function __cosntruct()
    {

        parent::__construct();

    }



    function get_bonus_rate($index)
    {

        $bonus = array(0, 0, 300, 800, 1600, 3200, 6400, 12000, 24000, 50000, 100000, 200000, 400000, 800000, 1600000, 3200000, 5000000);

        $rate = isset($bonus[$index]) ? $bonus[$index] : 0;

        return $rate;

    }



    function get_member_level()
    {

        $bonus = array(50, 126, 525, 1825, 5924, 14926, 42929, 123934, 364942, 784953, 1684973);

        return $bonus;

    }

    function get_member_bonus($index)
    {

        $bonus = array(300, 500, 1700, 3000, 4000, 8000, 12000, 25000, 50000, 105000, 400000);

        $rate = isset($bonus[$index]) ? $bonus[$index] : 0;

        return $rate;

    }



    function get_reward_bonus($index)
    {

        $bonus = array(0, 500, 800, 2000, 3500, 8000, 10000, 30000, 50000, 180000, 320000, 600000);

        $rate = isset($bonus[$index]) ? $bonus[$index] : 0;

        return $rate;

    }



    function get_upgrade_charge($from)
    {

        $charges = array(0, 1500, 3000, 6000, 12000, 24000, 48000, 96000, 192000, 358000, 760000, 1490000, 2800000, 5600000, 11200000, 22400000);

        $charge = isset($charges[$from]) ? $charges[$from] : 0;

        return $charge;

    }



    function get_upgrade_reward($from)
    {

        $charges = array(0, 0, 5000, 0, 12000, 0, 30000, 0, 85000, 0, 300000, 0, 550000, 0, 1300000);

        $charge = isset($charges[$from]) ? $charges[$from] : 0;

        return $charge;

    }



    function get_current_level($user_id)
    {

        $c = $this->db->order_by("id", "DESC")->limit(1)->where('user_id', $user_id)->get("level_manager")->row();

        if (is_object($c)) {

            return $c->level_id;

        }

        return 1;

    }



    function getcurrentLevel($sponsor_id)
    {

        $c = $this->db->order_by("id", "DESC")->limit(1)->where('sponsor_id', $sponsor_id)->get("level_manager")->row();

        if (is_object($c)) {

            return $c->level_id;

        }

        return 1;

    }







    function create_account($user_id, $data)
    {

        //$user_id = $this -> Master_model -> save($data, "users");

       // $us=  $this->generateId($user_id);

        $s = $this->User_model->statecodeById($user_id);

        $spid = "GM" . $s . str_pad($user_id, 3, '0', STR_PAD_LEFT);

        $update = array();

        $update['id'] = $user_id;

        $update['userid'] = $spid;

        $this->Master_model->save($update, "users");

        $msg = "Hi " . ucfirst($data['first_name']) . ", Congratulations on registering in Balaji. Login to https://www.groweas.in Using Your UserID is " . $spid . " and password is " . $data['passwd'] . ". Your Transaction Password is " . $data['txnpin'] . ". Thank you.";

       // send_sms($data['mobile'],$msg);

    }



    function sign($user_id, $state)
    {

        $s = $this->User_model->statecodeById($state);
        $spid = "GM" . $s . $user_id;
        $update = array();
        $update['id'] = $user_id;
        $update['userid'] = $spid;
        $this->Master_model->save($update, "users");
    }





    function generateId()
    {
        $c = $this->db->count_all("users");
        $id = rand($c, $c * 5);
        $chk = $this->db->get_where("users", array("id" => $id))->num_rows();

        if ($chk == 0) {
            return $id;
        } else {
            return $this->generateId();
        }

    }

    function count_pin($epin)
    {

        $user = $this->db->get_where("epin", array('pin' => $epin))->row()->user_id;

        $e = $this->db->query('select count(user_id) as user from epin where user_id=' . $user . ' and pin_status=0')->row();

        if (is_object($e)) {

            return $e->user;

        } else {

            return 0;

        }

    }



    function count_total_referal($id)

    {

        $e = $this->db->query('select count(user_id) as t from epin where user_id=' . $id . ' and pin_status=0')->row();

        if (is_object($e)) {

            return $e->t;

        } else {

            return 0;

        }

    }

    function get_between_members($user_id, $u_id)

    {

        $this->db->where('id>', $user_id);

        $this->db->where('id<=', $u_id);

        $q = $this->db->get('users')->num_rows();

        return $q;



    }

    function get_all_members($user_id)

    {

        $q = $this->db->query('select id from users where id<' . $user_id)->result();

        return $q;

    }

    function get_bottom_members($user_id)

    {

        $q = $this->db->query('select count(id) as total from users where id>' . $user_id)->row();

        return $q->total;



    }

    function growth_bonus($sponsor_id, $bonus, $member, $level_id, $status = 0)

    {

        $arr = array('id' => false, 'user_id' => $sponsor_id, 'amount' => $bonus, 'member' => $member, 'created' => date('Y-m-d'), 'level' => $level_id, 'status' => $status);

        $this->Master_model->save($arr, 'member_match');

    }



  /*  function add_member_bonus($sponsor_id,$member=0){

        $spil_count = $this->count_spil($sponsor_id);

        if($member==50){//50

            $bonus = $this->get_member_bonus(0);

            //insert into matching table

            $this->growth_bonus($sponsor_id,$bonus,1,1);

        }

        if($member==220){//220

            $bonus = $this->get_member_bonus(1);

            $this->growth_bonus($sponsor_id,$bonus,0,2,1);

            $this -> credit($sponsor_id, $bonus, 'growth_bonus',0);  

        }

        if($member==919){//919

            $bonus = $this->get_member_bonus(2);

           // $this->growth_bonus($sponsor_id,$bonus,1);

            $this->growth_bonus($sponsor_id,$bonus,0,3,1);

            $this->Member_model->credit($sponsor_id,$bonus,'growth_bonus');

            $this -> debit($sponsor_id, '1500', 'udgrade');



            $this->upgrade($sponsor_id);

        }

        elseif($member==2318){//2318

           $bonus = $this->get_member_bonus(3);

           // $this->growth_bonus($sponsor_id,$bonus,1);

            $this->Member_model->credit($sponsor_id,$bonus,'growth_bonus');

            $this->growth_bonus($sponsor_id,$bonus,0,4,1);

            $arr = array('id'=>false,'user_id'=>$sponsor_id,'created'=>date('Y-m-d'));

            $this->Master_model->save($arr,'reward_user');

            $this -> debit($sponsor_id, '2200', 'udgrade');

        }

        elseif($member==6017){//3699

            $bonus = $this->get_member_bonus(4);

            $this->growth_bonus($sponsor_id,$bonus,2,5);

        }

        elseif($member==15016){//8999

            $bonus = $this->get_member_bonus(5);

            $this->growth_bonus($sponsor_id,$bonus,3,6);  

        }

        elseif($member==43015){//27999

            $bonus = $this->get_member_bonus(6);

            $this->growth_bonus($sponsor_id,$bonus,4,7);

        }

        elseif($member==133014){//89999

            $bonus = $this->get_member_bonus(7);

           $this->growth_bonus($sponsor_id,$bonus,8,8);

        }

        elseif($member==383013){//249999

            $bonus = $this->get_member_bonus(8);

           $this->growth_bonus($sponsor_id,$bonus,12,9);

        }

        elseif($member==883012){//499999

            $bonus = $this->get_member_bonus(9);

            $this->growth_bonus($sponsor_id,$bonus,15,10);  

        }

        elseif($member==1783011){//899999

            $bonus = $this->get_member_bonus(10);

            $this->growth_bonus($sponsor_id,$bonus,23,11);

        }

        



    }

     */

    /* count no. of user spil member*/



    function count_spil($sponsor_id)

    {

        return $this->db->get_where('users', array('spil_id' => $sponsor_id))->num_rows();

    }



    function rejoin_member_count($user_id, $created)

    {

      //count rejoin of member

        $this->db->where('sponsor_id', $user_id);

        $this->db->where('join_date >=', $created);

        $total = $this->db->get('users')->num_rows();

        if ($total == 50) {

            $bonus = $this->get_reward_bonus(1);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 195) {

            $bonus = $this->get_reward_bonus(2);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 694) {

            $bonus = $this->get_reward_bonus(3);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 1993) {

            $bonus = $this->get_reward_bonus(4);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 5692) {

            $bonus = $this->get_reward_bonus(5);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 14691) {

            $bonus = $this->get_reward_bonus(6);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 42690) {

            $bonus = $this->get_reward_bonus(7);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 123689) {

            $bonus = $this->get_reward_bonus(8);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 364688) {

            $bonus = $this->get_reward_bonus(9);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 8646687) {

            $bonus = $this->get_reward_bonus(10);

            $this->credit($user_id, $bonus, 'reward');

        } elseif ($total == 1764686) {

            $bonus = $this->get_reward_bonus(11);

            $this->credit($user_id, $bonus, 'reward');

        } else {
        }





    }

    /*

    @user_id for the newly signed person

     */

    function add_signup_credit($user_id)
    {

        $sponsor = $this->get_sponsor_id($user_id);

        $spil_id = $this->get_spiller_id($user_id);

        if ($sponsor > 0) {

            $this->credit($sponsor, 100, 'signup');

            //Credit to level2 sponsor

            $sponsor = $this->get_sponsor_id($sponsor);

            if ($sponsor > 0) {

                $this->credit($sponsor, 100, 'signup');

                //Credit to level 3 sponsor

                $sponsor = $this->get_sponsor_id($sponsor);

                if ($sponsor > 0) {

                    $this->credit($sponsor, 100, 'signup');

                }

            }

        }

        //Benefit to spilled person

        $this->credit($spil_id, 100, 'spill');

    }



    function credit($user_id, $amount, $notes = '')
    {

        $data = array();

        $data['user_id'] = $user_id;

        $data['amount'] = $amount;

        $data['notes'] = $notes;

        $data['cr_dr'] = 'cr';

        $data['created'] = date("Y-m-d H:i");



        $this->Master_model->save($data, "transaction");

    }



    function debit($user_id, $amount, $notes = '')
    {

        $data = array();

        $data['user_id'] = $user_id;

        $data['amount'] = $amount;

        $data['notes'] = $notes;

        $data['cr_dr'] = "dr";

        $data['created'] = date("Y-m-d H:i");



        $this->Master_model->save($data, "transaction");

    }



    function add_sponsor2level($user_id, $sponsor_id)

    {

        $position = $this->get_current_level($user_id); 



         //Insert upgrade

        $total_members = $this->get_level_member_counter($position + 1);

        $me_position = $total_members + 1;

       

       // $sponsor_id = $this -> get_sponsor_parent($me_position, $position + 1);

        $up = array();

        $up['user_id'] = $user_id;

        $up['level_id'] = $position + 1;

        $up['sponsor_id'] = $sponsor_id;

        $up['position'] = ($me_position % 2 == 0) ? 1 : 2;

        $up['created'] = date("Y-m-d H:i");



        $this->Master_model->save($up, "level_manager");

    }



    function upgrade($user_id)
    {

        //Assign gift and reward.



        //Fetch current level

        $position = $this->get_current_level($user_id); 



         //Insert upgrade

        $total_members = $this->get_level_member_counter($position + 1);

        $me_position = $total_members + 1;



        $sponsor_id = $this->get_sponsor_parent($me_position, $position + 1);

        $up = array();

        $up['user_id'] = $user_id;

        $up['level_id'] = $position + 1;

        $up['sponsor_id'] = $sponsor_id;

        $up['position'] = ($me_position % 2 == 0) ? 1 : 2;

        $up['created'] = date("Y-m-d H:i");



        $this->Master_model->save($up, "level_manager");



        //credit reward bonus

        $reward_charge = $this->get_upgrade_reward($position - 1);

        if ($reward_charge > 0) {

            $this->credit($user_id, $reward_charge, "reward");

        }

        

        //Credit level bonus.

        $bonus = $this->get_bonus_rate($position + 1);

        $this->credit($sponsor_id, $bonus, "bonus");

     

        //cut upgrade charge of user

        $this->cut_upgrade_charge($sponsor_id, $position);

    

        //Credit to next level sponsor

        $sponsor_2 = $this->get_sponsor_id($sponsor_id);

        if ($sponsor_2 > 0) {

            $this->credit($sponsor_2, $bonus, 'bonus');

            $this->cut_upgrade_charge($sponsor_2, $position);

            //Credit to level 3 sponsor

            $sponsor_3 = $this->get_sponsor_id($sponsor_2);

            if ($sponsor_3 > 0) {

                $this->credit($sponsor_3, $bonus, 'bonus');

                $this->cut_upgrade_charge($sponsor_3, $position);

            }

        }





        //Iterate the loop for n times and upgrade.

        $root_id = $this->get_parent_root($user_id);



        //Check the no of childs for the root user

        if ($this->has_14($root_id, $position + 1)) {

            //Apply upgrade to root user

            $this->upgrade($root_id, $position + 1);

        }

    }



    function get_upgrade_value($position, $member_lbl)
    {

        $q = $this->db->get_where('role', array('id' => $position))->row();



        if (is_object($q)) {

            if ($member_lbl == 2) {

                return $q->member_2;

            } elseif ($member_lbl == 4) {

                return $q->member_4;

            } elseif ($member_lbl == 8) {

                return $q->member_8;

            } else {

                return 0;

            }

        }



    }



    function cut_upgrade_charge($sponsor_id, $position)

    {

        $pos = $this->get_user_level($sponsor_id);

       // echo $pos; die;

        $lr_pos = explode('-', $pos);

        $left = $lr_pos[0];

        $right = $lr_pos[1];



        if ($left == 1 and $right == 1) {

            $charge = $this->get_upgrade_value($position, 2);

            $this->debit($sponsor_id, $charge, 'upgrade');

        } elseif ($left == 3 and $right == 3) {

            $charge = $this->get_upgrade_value($position, 4);

            $this->debit($sponsor_id, $charge, 'upgrade');

        } elseif ($left == 7 and $right == 7) {

            $charge = $this->get_upgrade_value($position, 8);

            $this->debit($sponsor_id, $charge, 'upgrade');

        } else {



        }

    }



    function get_user_level($sponsor_id)

    {

        $users = array();

        $users = $this->User_model->member_tree($sponsor_id);

        $left = $right = 0;

        for ($i = 1; $i <= 14; $i++) {

            $user = $users[$i];

            if ($user->fullname != null) {

                if ($i == 1 || $i == 3 || $i == 4 || $i == 7 || $i == 8 || $i == 9 || $i == 10) {

                    $left++;

                }

                if ($i == 2 || $i == 5 || $i == 6 || $i == 11 || $i == 12 || $i == 13 || $i == 14) {

                    $right++;

                }

            }

        }

        return $left . '-' . $right;



    }



    function get_level_member_counter($level)
    {

        return $this->db->select('count(*) as c')->where("level_id", $level)->get("level_manager")->row()->c;

    }



    function get_level_member_counter_me($level, $sponsor_id)
    {

        $this->db->select('count(*) as c');

        $this->db->where("level_id", $level);

        $this->db->where("sponsor_id", $sponsor_id);

        return $this->db->get("level_manager")->row()->c;

    }

    function getrow_info($number)
    {

        $s = 0;

        for ($i = 0; $s < $number; $i++) {

            $t = pow(2, $i);

            $s = $s + $t;

        }

        return $i;

    }



    function get_level_members($level)
    {

        $data = array();

        $this->db->order_by("id", "ASC");

        $rest = $this->db->select("user_id")->get_where("level_manager", array("level_id" => $level))->result();

        if (is_array($rest) && count($rest) > 0) {

            foreach ($rest as $r) {

                $data[] = $r->user_id;

            }

        }

        return $data;

    }









    function bonus1()
    {

        $this->get_current_level(user_id());



    }



    function get_sponsor_parent($me_no, $level)
    {

        if ($me_no == 1) {

            return 0;

        }

        $ids = $this->get_level_members($level);

        if ($me_no == 2 || $me_no == 3) {

            return $ids[0];

        }

        $total = count($ids);



        $c = $this->getrow_info($me_no - 1);

        $rem = ($me_no % 2);

        $preids = ceil(($me_no - pow(2, $c - 1)) / 2);

        $pre_start = pow(2, $c - 2);

        if ($rem == 0) {

            $sponsor = $pre_start + $preids;

        } else {

            $sponsor = $pre_start + $preids - 1;

        }

        return $ids[$sponsor - 1];

    }



    function get_parent_root($user_id)
    {

        $p1 = $this->get_sponsor_id($user_id); //First level

        $p2 = $this->get_sponsor_id($p1); //Second level

        $p3 = $this->get_sponsor_id($p2); //Thired

        if ($p3 > 0) {

            return $p3;

        } else {

            return false;

        }

    }



    function is_child_exists($user_id, $position = 1)
    {

        $level_id = $this->get_current_level($user_id);

        $c = $this->db->get_where("level_manager", array('sponsor_id' => $user_id, 'position' => $position, 'level_id' => 1))->num_rows();

        return ($c > 0);

    }



    function get_direct_child($user_id)
    {

        $position = $this->get_current_level($user_id);

        $rest = $this->db->get_where('level_manager', array('sponsor_id' => $user_id, 'level_id' => $position));

        $ob = new stdClass();

        $ob->left = null;

        $ob->right = null;

        if ($rest->num_rows() > 0) {

            $result = $rest->result();

            foreach ($result as $r) {

                if ($r->position == 1) $ob->left = id2userid($r->user_id);

                if ($r->position == 2) $ob->right = id2userid($r->user_id);

            }

        }

        return $ob;

    }



    function get_child($user_id, $position = 1)
    {

        $rest = $this->db->get_where('level_manager', array('sponsor_id' => $user_id, 'level_id' => $position))->result();

        $ids = array();

        if (is_array($rest) && count($rest) > 0) {

            foreach ($rest as $r) {

                $ids[] = $r->user_id;

            }

        }

        return $ids;

    }



    function get_members($sponsor_id, $members = array())
    {

        $this->db->where('sponsor_id', $sponsor_id);
        $rest = $this->db->get("users");
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $ob = new stdClass();
                $ob->sponsor_id = $sponsor_id;
                $ob->user_id = $r->id;
                $ob->position = ($r->position == 1) ? 'left' : 'right';
                $ob->spil_id = $r->spil_id;
                $members[] = $ob;
                if ($sponsor_id > 0) {
                    $members = $this->get_members($r->id, $members);
                }
            }

        }

        return $members;

    }



    function grand_total($user_id)
    {

        $meids = $this->get_members($user_id);

        $c = 0;

        $p = 0;

        $total = 0;

        if (is_array($meids) && count($meids) > 0) {

            foreach ($meids as $ob) {

                if ($ob->spil_id == $user_id) {

                    $p++;

                }

            }

            $c = count($meids) > 14 ? 14 : count($meids);

            $total = ($c * 100) + ($p * 30);

        }

        $withdraw = 0;

        $bonus = 0;

        $sum = $total - $withdraw + $bonus;

        return $sum;

    }



    function balance($user_id)
    {

        $sum_cr = $this->db->select('sum(amount) as s')->where(array('user_id' => $user_id, 'cr_dr' => 'cr'))->get('transaction')->row()->s;

        $sum_dr = $this->db->select('sum(amount) as s')->where(array('user_id' => $user_id, 'cr_dr' => 'dr'))->get('transaction')->row()->s;
        $sum_dm = $this->db->select('sum(amount) as s')->where(array('user_id' => $user_id,'repurch_status'=>1))->get("diamond_income")->row()->s;
        $balance = ($sum_cr + $sum_dm - $sum_dr);

        return $balance;

    }



    function has_14($user_id, $position = 1)
    {

        $data = $this->get_level_childs($user_id, $position);

        $c = 0;

        foreach ($data as $dr) {

            if ($dr != 0) {

                $c++;

            }

        }

        return ($c == 15);

    }





    function get_level_childs($user_id, $position)
    {

        $data = array();

        $ids = $this->get_child($user_id, $position);

        $data[0] = $user_id;

        $data[1] = isset($ids[0]) ? $ids[0] : 0;

        $data[2] = isset($ids[1]) ? $ids[1] : 0;

        if (isset($data[1]) && $data[1] > 0) {

            $ids = $this->get_child($data[1], $position);

            $data[3] = isset($ids[0]) ? $ids[0] : 0;

            $data[4] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[2]) && $data[2] > 0) {

            $ids = $this->get_child($data[2], $position);

            $data[5] = isset($ids[0]) ? $ids[0] : 0;

            $data[6] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[3]) && $data[3] > 0) {

            $ids = $this->get_child($data[3], $position);

            $data[7] = isset($ids[0]) ? $ids[0] : 0;

            $data[8] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[4]) && $data[4] > 0) {

            $ids = $this->get_child($data[4], $position);

            $data[9] = isset($ids[0]) ? $ids[0] : 0;

            $data[10] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[5]) && $data[5] > 0) {

            $ids = $this->get_child($data[5], $position);

            $data[11] = isset($ids[0]) ? $ids[0] : 0;

            $data[12] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[6]) && $data[6] > 0) {

            $ids = $this->get_child($data[6], $position);

            $data[13] = isset($ids[0]) ? $ids[0] : 0;

            $data[14] = isset($ids[1]) ? $ids[1] : 0;

        }

        return $data;

    }



    function get_sponsor_id($user_id)
    {

        if ($user_id == 0) {

            return 0;

        }

        $ob = $this->db->select("sponsor_id")->order_by("id", "DESC")->limit(1)->where('user_id', $user_id)->get("level_manager")->row();

        if (is_object($ob)) {

            return $ob->sponsor_id;

        }

        return 0;

    }



    function get_spiller_id($user_id)
    {

        if ($user_id == 0) {

            return 0;

        }

        $ob = $this->db->select("spil_id")->where('id', $user_id)->get("users")->row();

        if (is_object($ob)) {

            return $ob->spil_id;

        }

        return 0;

    }



    function get_userid_from_position($level)
    {

        $result = $this->db->select("user_id")->where(array("level_id" => $level))->order_by("id", "ASC")->get("level_manager")->result();



        print_r($result);

    }



    function level_childs($level, $user_id)
    {

        $ids = $this->get_members($user_id);

        $c = 0;

        print_r($ids);

    }



    function level_manager($user_id, $sponsor_id, $position)

    {

        //Insert to Level Manager

        $level = array();

        $level['user_id'] = $user_id;

        $level['level_id'] = 1;

        $level['sponsor_id'] = $sponsor_id;

        $level['position'] = $position;

        $level['created'] = date("Y-m-d H:i");

        $this->Master_model->save($level, "level_manager");



        //Assign credit to Sponsor Person

        $this->add_signup_credit($user_id);

    }



    /***********************************************************************************/



    function last_user_id($sponsor_id, $members = array())
    {

        $this->db->where('sponsor_id', $sponsor_id);

        $s = $this->db->get("users")->row();



        if (is_object($s)) {

            $members[] = $s->id;

            $members = $this->last_user_id($s->id, $members);

        }

        return $members;

    }



    function get_parent_id($user_id)

    {

        $q = $this->db->get_where('users', array('sponsor_id' => $user_id))->row();

        if (is_object($q)) {

            $x = $this->last_user_id($user_id);

            return end($x);



        } else {

            return $user_id;

        }

    }



    function get_parent_members($sponsor_id, $members = array())
    {

        $this->db->where('id', $sponsor_id);

        $rest = $this->db->get("users");

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $r) {

                $ob = new stdClass();

              //  $ob -> sponsor_id = $sponsor_id;

                $ob->user_id = $r->id;



                $members[] = $ob;

                $members = $this->get_parent_members($r->sponsor_id, $members);

            }

        }

        return $members;

    }



    function upgrade_level_charge($user_id, $position)
    {

        $data = array();

        $ids = $this->get_child($user_id, $position);

        $data[0] = $user_id;

        $data[1] = isset($ids[0]) ? $ids[0] : 0;

        $data[2] = isset($ids[1]) ? $ids[1] : 0;

        if (isset($data[1]) && $data[1] > 0) {

            $ids = $this->get_child($data[1], $position);

            $data[3] = isset($ids[0]) ? $ids[0] : 0;

            $data[4] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[2]) && $data[2] > 0) {

            $ids = $this->get_child($data[2], $position);

            $data[5] = isset($ids[0]) ? $ids[0] : 0;

            $data[6] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[3]) && $data[3] > 0) {

            $ids = $this->get_child($data[3], $position);

            $data[7] = isset($ids[0]) ? $ids[0] : 0;

            $data[8] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[4]) && $data[4] > 0) {

            $ids = $this->get_child($data[4], $position);

            $data[9] = isset($ids[0]) ? $ids[0] : 0;

            $data[10] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[5]) && $data[5] > 0) {

            $ids = $this->get_child($data[5], $position);

            $data[11] = isset($ids[0]) ? $ids[0] : 0;

            $data[12] = isset($ids[1]) ? $ids[1] : 0;

        }

        if (isset($data[6]) && $data[6] > 0) {

            $ids = $this->get_child($data[6], $position);

            $data[13] = isset($ids[0]) ? $ids[0] : 0;

            $data[14] = isset($ids[1]) ? $ids[1] : 0;

        }

        return $data;

    }



    function count_total_member()

    {



        $me = $this->db->query('select count(id) as total from users where id>' . user_id())->row()->total;

        return $me;



    }



    function serial_number()

    {

        $sl_no = $this->db->query('select sl_no from ai_users order by sl_no desc limit 1')->row()->sl_no;

        return $sl_no + 1;

    }



    function check_sponsor_completed($user_id, $no, $sp, $pin, $bonus)

    {

        $found = $this->db->get_where('milestone', array('userid' => $user_id, 'milestone' => $no, 'sponsor' => $sp))->num_rows();

        if ($found > 0) {

            return true;

        } else {

            if ($pin >= $sp) {

                //add sponsor to milestone table

                $q = $this->db->get_where('milestone', array('userid' => $user_id, 'milestone' => $no))->row();

                if (is_object($q)) {

                    $data['id'] = $q->id;

                    $data['sponsor'] = $sp;

                    $data['create_sponsor'] = $pin;

                    $this->Master_model->save($data, 'milestone');

                    $u = $this->db->get_where('transaction', array('user_id' => $user_id, 'amount' => $bonus))->num_rows();

                    if ($u == 0) {

                        $this->credit($user_id, $bonus, 'bonus');

                    }

                }

                //add bouus to user



            }

        }

    }

    function check_milestone($user_id, $no)

    {

        $found = $this->db->get_where('milestone', array('userid' => $user_id, 'milestone' => $no))->num_rows();

        if ($found > 0) {

            return true;

        }



    }

    function purchase_amount($user_id)
    {
        $credit = $this->db->query('select sum(amount) as total from orders where user_id=' . $user_id . ' and status=1')->row();
     // echo $this->db->last_query();die;



        if (is_object($credit)) {

            $credit_amount = $credit->total;

        }

        return $credit_amount;
    }

    function add_milestone($user_id, $no, $count_pin, $amount)
    {

        $found = $this->db->get_where('milestone', array('userid' => $user_id, 'milestone' => $no))->num_rows();



        if ($found == 0) {

            $data = array();

            $data['milestone'] = $no;

            $data['userid'] = $user_id;

            $data['sponsor'] = 0;

            $data['create_sponsor'] = $count_pin;



            $data['created'] = date("Y-m-d H:i");

            $this->Master_model->save($data, "milestone");



            $this->credit($user_id, $amount, "bonus");



            return true;

        }



    }

    function distributor_balance($user_id)
    {

        $sum_cr = $this->db->select('sum(amount) as s')->where(array('user_id' => $user_id, 'cr_dr' => 'cr'))->get('transaction')->row()->s;

        $sum_dm = $this->db->select('sum(amount) as s')->where(array('user_id' => $user_id,'repurch_status'=>1))->get("diamond_income")->row()->s;
        $balance = ($sum_cr + $sum_dm);

        return $balance;

    }

}

