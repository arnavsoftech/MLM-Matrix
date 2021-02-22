<?php
class User_model extends Master_model
{

    public $join_id;
    public function __construct()
    {
        parent::__construct();
        $this->table   = 'users';
        $this->join_id = 0;
    }

    public function loginCheck($userid, $pass)
    {

        $this->db->group_start();
        $this->db->where('username', $userid);
        $this->db->or_where('email_id', $userid);
        $this->db->group_end();

        $this->db->where("passwd", $pass);
        $this->db->where(array('status' => 1));
        $r = $this->db->get('users');
        if ($r->num_rows() > 0) {
            return $r->row();
        } else {
            return false;
        }
    }

    //Pass Id of new join user
    public function pinIncome($user_id)
    {
        $user = $this->db->get_where('users', array('id' => $user_id))->row();
        $pin  = $this->db->get_where('epin', array('pin' => $user->epin))->row();
        $u    = $this->db->get_where('users', array('id' => $pin->owner_id))->row();
        if (is_object($u) && $u->franchise == 1) {
            $pay            = array();
            $pay['user_id'] = $pin->owner_id;
            $pay['amount']  = 25;
            $pay['notes']   = 'PIN';
            $pay['cr_dr']   = 'cr';
            $pay['created'] = date("Y-m-d H:i");
            $this->db->insert('transaction', $pay);
        }
    }

    public function getUser($userid)
    {

        $rest = $this->db->get_where($this->table, array('userid' => $userid));
        if ($rest->num_rows() > 0) {
            return $rest->row();
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $r = $this->db->get_where($this->table, array('id' => $id))->first_row();
        return $r;
    }

    public function statecodeById($id)
    {
        $this->db->select('state_code');
        $this->db->where('id', $id);
        return $this->db->get('state')->row()->state_code;
    }

    public function getAdminUser($id)
    {

        return $this->db->get_where("admin", array('id' => $id))->row();
    }

    public function state_dropdown()
    {

        $this->db->select("id, state_name");
        $this->db->from("states");
        $this->db->order_by("state_name", "ASC");
        $rest = $this->db->get()->result();
        $data = array();
        foreach ($rest as $ob) {
            $data[$ob->id] = $ob->state_name;
        }
        return $data;
    }

    public function edit_profile()
    {

        $u = $this->session->userdata('login');
        $this->db->select('*');
        $this->db->from('ai_users');
        $this->db->where('id=', $u['user_id']);
        $this->db->order_by('id', 'DESC');
        $rest = $this->db->get()->row();
        return $rest;
    }

    public function letter()
    {
        $u = $this->session->userdata('login');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id=', $u['user_id']);
        $this->db->order_by('id', 'DESC');
        $rest = $this->db->get()->row();
        return $rest;
    }

    public function get_members($sponsor_id, $members = array())
    {
        $this->db->where('sponsor_id', $sponsor_id);
        $rest = $this->db->get("users");
        if ($rest->num_rows() > 0) {
            $ob = new stdClass();
            foreach ($rest->result() as $r) {
                if ($r->position == 1) {
                    $ob->left = $r->user_id;
                } else {
                    $ob->right = $r->user_id;
                }
                $members[$sponsor_id] = $ob;
                $members              = $this->get_members($r->user_id, $members);
            }
        }
        return $members;
    }

    public function member()
    {
        if (isset($_GET['search'])) {
            $q = $_GET['q'];
            if ($q != "") {
                $this->db->where('id', $q);
            }
        }
        $this->db->order_by('id', 'DESC');
        $rest            = $this->db->get('users');
        $data['results'] = $rest->result();
        return $data;
    }

    public function getDirectChild($user_id)
    {
        $ids = $this->db->where(array('sponsor_id' => $user_id))->get('users')->result();
        return $ids;
    }

    public function totalIncome($user_id)
    {
        $cr = $this->db->select('sum(amount) as c')->where(array('cr_dr' => 'cr', 'user_id' => $user_id))->get('transaction')->row()->c;
        return $cr;
    }

    public function totalPaid($user_id)
    {
        $cr = $this->db->select('sum(amount) as c')->where(array('cr_dr' => 'dr', 'user_id' => $user_id))->get('transaction')->row()->c;
        return $cr;
    }

    public function getIncomeByType($user_id, $type = Dashboard_model::INCOME_LEVEL)
    {
        $cr = $this->db->select('sum(amount) as c')->where(array('user_id' => $user_id, 'cr_dr' => 'cr', 'notes' => $type))->get('transaction')->row()->c;
        $dr = $this->db->select('sum(amount) as c')->where(array('user_id' => $user_id, 'cr_dr' => 'dr', 'notes' => $type))->get('transaction')->row()->c;
        return $cr - $dr;
    }

    public function totalDownline($user_id)
    {
        $ids = $this->getDownloadLineIds($user_id);
        return count($ids);
    }

    public function currentIncome($user_id)
    {
        $bl = $this->totalIncome($user_id);
        $lp = $this->totalPaid($user_id);
        $sum = $bl - $lp;

        return $sum;
    }

    public function getActiveDownLineIds($sponsor_id, $ids = array())
    {
        $rest = $this->db->select('id')->get_where('users', array('sponsor_id' => $sponsor_id, 'epin !=' => ''))->result();
        if (is_array($rest) > 0) {
            foreach ($rest as $obr) {
                $ids[] = $obr->id;
                $ids   = $this->getActiveDownLineIds($obr->id, $ids);
            }
        }
        return $ids;
    }

    public function getDownloadLineIds($user_id, $ids = array())
    {
        $rest = $this->db->select('id')->get_where('users', array('sponsor_id' => $user_id))->result();
        if (is_array($rest) > 0) {
            foreach ($rest as $obr) {
                $ids[] = $obr->id;
                $ids   = $this->getDownloadLineIds($obr->id, $ids);
            }
        }
        return $ids;
    }

    public function getAutoSponsor($level)
    {
        $ids            = $this->db->order_by('id', 'ASC')->where('level_id', $level)->select('user_id')->get('level_manager')->result();
        $ob             = new stdClass();
        $ob->position   = 1;
        $ob->sponsor_id = 0;
        if (count($ids) > 0) {
            foreach ($ids as $r) {
                $childs = $this->db->get_where('level_manager', array('sponsor_id' => $r->user_id, 'level_id' => $level))->num_rows();
                if ($childs == 0) {
                    $ob->sponsor_id = $r->user_id;
                    $ob->position   = 1;
                    break;
                } elseif ($childs == 1) {
                    $ob->sponsor_id = $r->user_id;
                    $ob->position   = 2;
                    break;
                }
            }
        }
        return $ob;
    }

    public function get_sponsor_id($user_id, $level = 0)
    {

        $ob = $this->db->select("sponsor_id")->where(array('user_id' => $user_id, "level_id" => $level))->get("level_manager")->row();
        if (is_object($ob)) {
            return $ob->sponsor_id;
        } else {
            return false;
        }
    }

    public function add_to_level_manager($user_id, $sponsor_id, $position, $level_id)
    {
        $arr = array(
            'id'         => false,
            'user_id'    => $user_id,
            'sponsor_id' => $sponsor_id,
            'level_id'   => $level_id,
            'position'   => $position,
        );
        $this->db->insert('level_manager', $arr);
    }

    public function getDirectChilds($user_id, $level)
    {
        $ob       = new stdClass();
        $ob->left = $ob->right = null;
        $rest     = $this->db->get_where('level_manager', array('sponsor_id' => $user_id, 'level_id' => $level))->result();
        if (count($rest) > 0) {
            foreach ($rest as $row) {
                if ($row->position == 1) {
                    $ob->left = $row->user_id;
                } else {
                    $ob->right = $row->user_id;
                }
            }
        }
        return $ob;
    }

    public function get_my_level($user_id)
    {
        $me = $this->db->order_by('id', 'DESC')->limit(1)->where('user_id', $user_id)->get('level_manager')->row();
        if (is_object($me)) {
            return $me->level_id;
        } else {
            return 1;
        }
    }

    public function getUserParent($user_id)
    {
        $ob = $this->db->get_where('users', array('id' => $user_id))->row();
        if (is_object($ob)) {
            return $ob->sponsor_id;
        } else {
            return 0;
        }
    }

    public function getRankId($user_id)
    {
        $rank_list = config_item("rank");
        $ids       = $this->getDownloadLineIds($user_id);
        if (count($ids) > 0) {
            $sum = (count($ids) * 1100);
            foreach ($ids as $id) {
                $amt = $this->getPointValue($id);
                $sum += $amt;
            }
            $target = 0;
            $pos    = '';
            foreach ($rank_list as $ind => $arr) {
                $target = $target + $arr[0];
                if ($sum < $target) {
                    $pos = $ind;
                    break;
                }
            }
            $pre = $pos;
            if (isset($rank_list[$pre])) {
                $me = $rank_list[$pre];
                return strtoupper($me[3]);
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getMyRank($user_id)
    {
        $rank_list = config_item("rank");
        $ids       = $this->getDownloadLineIds($user_id);
        if (count($ids) > 0) {
            $sum = (count($ids) * 1100);
            foreach ($ids as $id) {
                $amt = $this->getPointValue($id);
                $sum += $amt;
            }
            $target = 0;
            $pos    = '';
            foreach ($rank_list as $ind => $arr) {
                $target = $arr[0];
                if ($sum < $target) {
                    $pos = $ind;
                    break;
                }
            }
            $pre = $pos;
            if (isset($rank_list[$pre])) {
                $me = $rank_list[$pre];
                return strtoupper($me[2]);
            } else {
                return 'DISTRIBUTOR';
            }
        } else {
            return 'DISTRIBUTOR';
        }
    }

    public function getRankIndex($user_id)
    {
        $rank_list = config_item("rank");
        $ids       = $this->getDownloadLineIds($user_id);
        if (count($ids) > 0) {
            $sum = (count($ids) * 1100);
            foreach ($ids as $id) {
                $amt = $this->getPointValue($id);
                $sum += $amt;
            }
            $target = 0;
            $pos    = '';
            foreach ($rank_list as $ind => $arr) {
                $target = $arr[0];
                if ($sum < $target) {
                    $pos = $ind;
                    break;
                }
            }
            $pre = $pos;
            if (isset($rank_list[$pre])) {
                $me = $rank_list[$pre];
                return $me[3];
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function users_magic_list($user_id)
    {
        $this->db->select("users.username, users.first_name, users.last_name, matrix.*");
        $this->db->from('matrix');
        $this->db->join("users", "users.id = matrix.parent_id");
        $this->db->where('matrix.user_id', $user_id);
        $result = $this->db->get()->result();
        return $result;
    }

    function autoMagicSponsor()
    {
        $ob = new stdClass();
        $ids = $this->db->select("user_id")->from('level_manager')->order_by('id', 'ASC')->get()->result();
        if (count($ids) > 0) {
            foreach ($ids as $u) {
                $childs = $this->db->select('count(*) as c')->get_where('level_manager', array('sponsor_id' => $u->user_id))->row()->c;
                if ($childs < 4) {
                    $ob->parent_id = $u->user_id;
                    $ob->position = $childs + 1;
                    break;
                }
            }
        } else {
            $ob->parent_id = 0;
            $ob->position = 1;
        }
        return $ob;
    }

    function getMatrixParent($user_id)
    {
        $ob = $this->db->get_where('level_manager', array('user_id' => $user_id))->row()->sponsor_id;
        return $ob;
    }

    function getMatrixDirectChilds($parent_id)
    {
        if ($parent_id == 0) return array();
        $childs = $this->db->get_where("users", array('sponsor_id' => $parent_id))->result();
        $ids = array();
        foreach ($childs as $ob) {
            $ids[] = $ob->id;
        }
        return $ids;
    }

    function getMatrixDownlineIds($parent_id, $level = 1, $merge = true)
    {
        $data = array();

        // Level 1
        $ar1 = $this->getMatrixDirectChilds($parent_id);

        // Level 2
        $ar2 = array();
        foreach ($ar1 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar2 = array_merge($ar2, $ids);
        }

        // Level 3
        $ar3 = array();
        foreach ($ar2 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar3 = array_merge($ar3, $ids);
        }

        // Level 4
        $ar4 = array();
        foreach ($ar3 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar4 = array_merge($ar4, $ids);
        }

        // Level 5
        $ar5 = array();
        foreach ($ar4 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar5 = array_merge($ar5, $ids);
        }

        // Level 6
        $ar6 = array();
        foreach ($ar5 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar6 = array_merge($ar6, $ids);
        }

        // Level 7
        $ar7 = array();
        foreach ($ar6 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar7 = array_merge($ar7, $ids);
        }

        // Level 8
        $ar8 = array();
        foreach ($ar7 as $id) {
            $ids = $this->getMatrixDirectChilds($id);
            $ar8 = array_merge($ar8, $ids);
        }

        if ($level == 1) {
            $data = array_merge($ar1);
        } else if ($level == 2) {
            $data = $merge ? array_merge($ar1, $ar2) : $ar2;
        } else if ($level == 3) {
            $data = $merge ? array_merge($ar1, $ar2, $ar3) : $ar3;
        } else if ($level == 4) {
            $data = $merge ? array_merge($ar1, $ar2, $ar3, $ar4) : $ar4;
        } else if ($level == 5) {
            $data =  $merge ? array_merge($ar1, $ar2, $ar3, $ar4, $ar5) : $ar5;
        } else if ($level == 6) {
            $data =  $merge ? array_merge($ar1, $ar2, $ar3, $ar4, $ar5, $ar6) : $ar6;
        } else if ($level == 7) {
            $data =  $merge ? array_merge($ar1, $ar2, $ar3, $ar4, $ar5, $ar6, $ar7) : $ar7;
        } else if ($level == 8) {
            $data =  $merge ? array_merge($ar1, $ar2, $ar3, $ar4, $ar5, $ar6, $ar7, $ar8) : $ar8;
        }
        return $data;
    }

    function getRandomUserId()
    {
        $id = rand(11111, 99999);
        $chk = $this->db->get_where("users", array('id' => $id))->row();
        if (!is_object($chk)) {
            return $id;
        } else {
            return $this->getRandomUserId();
        }
    }


    // Newly reg id
    function doAllPaymentCalculations($new_id)
    {
        $us = $this->db->get_where('users', array('id' => $new_id))->row();

        // Rs 50 for 100 Days
        $pay = array();
        $pay['user_id'] = $new_id;
        $pay['amount'] = 40;
        $pay['st_date'] = date("Y-m-d");
        $pay['ed_date'] = date("Y-m-d", strtotime(date("Y-m-d") . " +90 days"));
        $pay['status'] = 1;
        $pay['payfor'] = $new_id;
        $pay['paylevel'] = 0;
        $this->db->insert("payments", $pay);
        $pv = array(0, 3, 4, 5, 5, 5, 6, 7);

        $sponsor_id = $us->sponsor_id;

        for ($i = 1; $i <= 7; $i++) {
            if ($sponsor_id > 0) {
                $childs = $this->db->get_where('users', array('sponsor_id' => $sponsor_id, 'epin !=' => ''))->num_rows();

                $pay = array();
                $pay['user_id'] = $sponsor_id;
                $pay['amount'] = $pv[$i];
                $pay['st_date'] = date("Y-m-d");
                $pay['ed_date'] = date("Y-m-d", strtotime(date("Y-m-d") . " +30 days"));
                $pay['payfor'] = $new_id;
                $pay['paylevel'] = $i;
                $pay['status'] = 0;

                if ($i == 1 || $i == 2) {
                    if ($childs >= 2) {
                        $pay['status'] = 1;
                    }
                } else if ($i == 3 && $childs >= 3) {
                    $pay['status'] = 1;
                } else if ($i == 4 && $childs >= 4) {
                    $pay['status'] = 1;
                } else if ($i == 5 && $childs >= 6) {
                    $pay['status'] = 1;
                } else if ($i == 6 && $childs >= 8) {
                    $pay['status'] = 1;
                } else if ($i == 7 && $childs >= 10) {
                    $pay['status'] = 1;
                }

                $this->db->insert("payments", $pay);

                // Move to next parent sponsor
                $us = $this->db->get_where('users', array('id' => $sponsor_id))->row();
                $sponsor_id = $us->sponsor_id;
            }
        }
    }

    function doRewardCalculations($user_id)
    {
        $ids = $this->getActiveDownLineIds($user_id);
        if (count($ids) == 2000) {
            // Reward this use with Rs 5000
            $pay            = array();
            $pay['user_id'] = $user_id;
            $pay['amount']  = 5000;
            $pay['notes']   = Dashboard_model::INCOME_REWARD;
            $pay['cr_dr']   = 'cr';
            $pay['created'] = date("Y-m-d H:i");
            $this->db->insert('transaction', $pay);

            // Set current rank
            $this->db->update("users", array('rank' => 1), array('id' => $user_id));
        }
    }

    function getWalletBalance($user_id)
    {
        $cr = $this->db->select("SUM(amount) as c")->get_where('wallet', array('user_id' => $user_id, 'cr_dr' => 'cr'))->row()->c;
        $dr = $this->db->select("SUM(amount) as c")->get_where('wallet', array('user_id' => $user_id, 'cr_dr' => 'dr'))->row()->c;

        $sum = $cr  - $dr;
        if ($sum < 0) {
            $sum = 0;
        }
        return $sum;
    }

    function level_income($user_id, $level = 0)
    {
        $s = $this->db->select('sum(amount) as s')->get_where('transaction', array('user_id' => $user_id, 'paylevel' => $level))->row()->s;
        if ($s == null) {
            $s = '0.00';
        }
        return $s;
    }
}
