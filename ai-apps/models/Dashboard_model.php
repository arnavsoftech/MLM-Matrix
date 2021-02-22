<?php
class Dashboard_model extends CI_Model
{

    const INCOME_LEVEL = 'level';
    const INCOME_ROI = 'roi';
    const INCOME_FUND_TRANSER = 'fund_transfer';
    const INCOME_REWARD = 'reward';

    const WITHDRAW_APPROVED = 1;
    const WITHDRAW_DECLINED = 2;
    const WITHDRAW_CANCELLED = 3;
    const WITHDRAW_PENDING = 0;
    function __construct()
    {
        parent::__construct();
    }

    function getPackageAvailable($user_id)
    {
        $ar_packages = $this->db->get_where('package', array('user_id' => $user_id, 'status' => 1))->result();
        return count($ar_packages);
    }

    function getIncomeTypes()
    {
        $ar = array(
            self::INCOME_LEVEL,
            self::INCOME_ROI,
            self::INCOME_REWARD
        );
        return $ar;
    }

    function create_withdraw_request($user_id, $amount)
    {
        $data = array();
        $data['user_id'] = $user_id;
        $data['amount'] = $amount;
        $data['created'] = date("Y-m-d H:i");
        $data['updated'] = date("Y-m-d H:i");
        $data['status'] = 0;
        $data['comments'] = null;
        $this->db->insert('withdraw', $data);

        // Create debit from Wallet
        $data = array();
        $data['user_id'] = $user_id;
        $data['amount'] = $amount;
        $data['notes'] = "Withdraw";
        $data['cr_dr'] = 'dr';
        $data['created'] = date("Y-m-d H:i");
        $data['ref_id'] = $this->db->insert_id();
        $this->db->insert('wallet', $data);
    }

    function update_withdraw_request($req_id, $action = 1)
    {
        switch ($action) {
            case '1':
                $this->db->update('withdraw', array('status' => self::WITHDRAW_APPROVED, 'updated' => date("Y-m-d H:i")), array('id' => $req_id));
                break;
            case '2':
                $this->db->update('withdraw', array('status' => self::WITHDRAW_DECLINED, 'updated' => date("Y-m-d H:i"), 'comments' => 'Rejected by admin'), array('id' => $req_id));
                $this->db->delete('wallet', array('ref_id' => $req_id));
                break;
            case '3':
                $this->db->update('withdraw', array('status' => self::WITHDRAW_CANCELLED, 'updated' => date("Y-m-d H:i"), 'comments' => 'Cancelled by user'), array('id' => $req_id));
                $this->db->delete('wallet', array('ref_id' => $req_id));
                break;
            case '0':
                $this->db->update('withdraw', array('status' => self::WITHDRAW_PENDING, 'updated' => date("Y-m-d H:i")), array('id' => $req_id));
                break;
        }
    }
}
