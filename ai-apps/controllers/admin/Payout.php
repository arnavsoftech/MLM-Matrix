<?php
class Payout extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data['main'] = 'payouts/tables';
    }

    public function index()
    {
        $this->data['main'] = 'payouts/payout-reports';
        $this->data['list'] = $this->db->select('sum(amount) as total, count(user_id) as total_user, created')->group_by('date(created)')->order_by("date(created)", "DESC")->get_where("transaction", array('notes' => 'Withdraw'))->result();
        $this->load->view('default', $this->data);
    }

    function listview($date)
    {
        $this->data['main'] = 'payouts/listview';
        $this->data['payout'] = $this->db->get_where("transaction", array("date(created)" => $date, 'cr_dr' => 'dr', 'notes' => 'Withdraw'))->result();
        $this->load->view("default", $this->data);
    }

    function generate()
    {
        $rest = $this->db->select('id')->where('status', 1)->get('users')->result();
        foreach ($rest as $r) {
            $bal = $this->User_model->currentIncome($r->id);
            if ($bal == 0) continue;

            // Dr to Transaction
            $pay            = array();
            $pay['user_id'] = $r->id;
            $pay['amount']  = $bal;
            $pay['notes']   = 'Payout';
            $pay['cr_dr']   = 'dr';
            $pay['created'] = date("Y-m-d H:i");
            $this->db->insert('transaction', $pay);

            // Cr to Wallet
            $save = array();
            $save['amount'] = $bal * 0.85;
            $save['user_id'] = $r->id;
            $save['notes'] = "Account";
            $save['cr_dr'] = "cr";
            $save['created'] = date("Y-m-d H:i");
            $this->db->insert('wallet', $save);
        }
        $this->session->set_flashdata('success', "Payout generated successfully");
        redirect(admin_url('payout'));
    }

    function generate_backup()
    {
        header('Content-Type: application/json');
        $ob = new stdClass();
        $is_day = date('l');
        $is_payment = theme_option('payment');
        $member = $this->db->select('user_id')->group_by('user_id')->get_where('transaction', array('user_id>' => 0))->result();


        if ($is_day != 'sunday' and $is_payment != 0) {

            foreach ($member as $u) {
                $user_id = $u->user_id;
                $user = $this->db->select('id,username,bank_info,mobile,kyc_status')->get_where('users', array('id' => $user_id))->row();
                if ($user->kyc_status == 1) {
                    $bal = $this->User_model->MainBalance($user_id);


                    $bank =    $user->bank_info;
                    $arrbank = json_decode($bank, true);
                    if ($bank != '' and @$arrbank['bank_name'] != '' and @$arrbank['ifsc'] != "" and @$arrbank['ac_number'] != "" and strlen($arrbank['ac_number']) >= 10 and $bal > 500) {


                        $exact = intdiv($bal, 100);
                        $amount = $exact * 100;

                        $baseurl = "http://13.127.227.22/freeunlimited/v3"; //LIVE
                        // $baseurl ="http://13.127.227.22/freeunlimited/v3/demo"; //DEMO

                        $apikey = "300179721688063"; //JOLOSOFT api key
                        $userid = $user_id; //JOLOSOFT api userid - get from profile page on jolosoft
                        $callbackurl = site_url("home/payment_process"); //CALL BACK URL

                        $headerstring = "$userid|$apikey";
                        $hashedheaderstring = hash("sha512", $headerstring);

                        $myorderid = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
                        $beneficiary_account_no = $arrbank['ac_number'];
                        $beneficiary_ifsc = $arrbank['ifsc'];

                        $purpose = 'BONUS';
                        $remarks = 'Brightenic';

                        $header = array('Content-Type:application/json', 'Authorization:' . $hashedheaderstring);

                        $pay_amount =   $amount;
                        //build payload in json
                        $paramList = array();
                        $paramList["apikey"] = $apikey;
                        $paramList["mobileno"] = $user->mobile;
                        $paramList["beneficiary_account_no"] = $beneficiary_account_no;
                        $paramList["beneficiary_ifsc"] = $beneficiary_ifsc;
                        $paramList["amount"] =  $pay_amount; // Credit amount by less 2% for admin charge
                        $paramList["orderid"] = $myorderid;
                        $paramList["purpose"] = $purpose;
                        $paramList["remarks"] = $remarks;
                        $paramList["callbackurl"] = $callbackurl;
                        $payload = json_encode($paramList, true);

                        $ch = curl_init("$baseurl/transfer.php");
                        curl_setopt(
                            $ch,
                            CURLOPT_CUSTOMREQUEST,
                            "POST"
                        );
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        $file_contents = curl_exec($ch); // execute
                        $err = curl_error($ch);
                        curl_close($ch);
                        //  var_dump($file_contents); die;

                        if (!empty($file_contents)) {
                            $jsondata = json_decode($file_contents, true);
                            $rcstatus = $jsondata['status'];
                            $ob->message = $jsondata['error'];
                        } else {
                            //handle empty or timeout
                            $rcstatus = "PENDING";
                        }

                        if ($rcstatus == 'ACCEPTED' || $rcstatus == 'SUCCESS') {
                            //COLLECT MORE PARAMETERS HERE
                            $txid = $jsondata['txid']; //jolo order id
                            $desc = $jsondata['desc'];
                            $beneficiaryid = $jsondata['beneficiaryid'];

                            $data = array();
                            $data['user_id'] = $user_id;
                            $data['amount'] = $amount;
                            $data['cr_dr'] = 'dr';
                            $data['created'] = date("Y-m-d H:i");
                            $data['paykey'] = 1;
                            $data['tds'] = $txid;
                            $data['notes'] =  'Withdraw';
                            $data['net_pay'] =  $pay_amount;
                            $this->db->insert('transaction', $data);
                            //send sms
                            // $name = $user->first_name;
                            // $ms = "Hi $name,  Rs." . $pay_amount . " has been created to your Bank Account. Brightenic. Login at: ".site_url();
                            //sendSMS($user->mobile, $ms);
                            // $ob->status = true;
                            // $ob->message = "Amount Transfer to bank Completed";
                            // echo json_encode($ob);
                            $this->session->set_flashdata("success", "Payments paid");
                            redirect(admin_url('payout'));
                        }
                    }
                }
            }
        } else {
            $this->session->set_flashdata("error", "Either today is sunday or payout off today");
            redirect(admin_url('payout'));
        }
    }

    public function markpaid($id)
    {
        echo "Error";
        die;
        $payout = $this->db->get_where("payout", array("id" => $id))->row();
        $users = json_decode($payout->details);
        foreach ($users as $ob) {
            $data = array();
            $data['user_id'] = $ob->id;
            $data['amount'] = $ob->total;
            $data['notes'] = $payout->paytype;
            $data['cr_dr'] = 'dr';
            $data['created'] = date("Y-m-d H:i");
            $this->db->insert("transaction", $data);
        }
        $this->db->update("payout", array('status' => 1), array("id" => $id));
        $this->session->set_flashdata("success", "All payments are marked as paid");
        redirect(admin_url('payout'));
    }

    public function career()
    {
        $list  = $this->db->select('distinct(user_id)')->where('notes', 'Career')->get('transaction')->result();
        //$list = $this->db->order_by("id", "ASC")->get("users")->result();
        $users = array();
        foreach ($list as $ob) {
            $user         = $this->db->get_where("users", array("id" => $ob->user_id))->row();
            // $user->amount = $this->User_model->getCareerIncome($ob->user_id);
            $user->amount = $this->User_model->payoutIncome($ob->user_id);
            $users[]      = $user;
        }
        $this->data['users'] = $users;
        $this->data['type'] = 'Payout';
        $this->load->view('default', $this->data);
    }

    public function autofill()
    {
        $list  = $this->db->select('distinct(user_id)')->where('notes', 'Autofill')->get('transaction')->result();
        $users = array();
        foreach ($list as $ob) {
            $user         = $this->db->get_where("users", array("id" => $ob->user_id))->row();
            $user->amount = $this->User_model->getAutofillIncome($ob->user_id);
            $users[]      = $user;
        }
        $this->data['users'] = $users;
        $this->data['type'] = 'Autofill';
        $this->load->view('default', $this->data);
    }

    public function repurchase()
    {
        $list  = $this->db->select('distinct(user_id)')->where('notes', 'Repurchase')->get('transaction')->result();
        $users = array();
        foreach ($list as $ob) {
            $user         = $this->db->get_where("users", array("id" => $ob->user_id))->row();
            $user->amount = $this->User_model->getRepurchaseIncome($ob->user_id);
            $users[]      = $user;
        }
        $this->data['users'] = $users;
        $this->data['type'] = 'Repurchase';
        $this->load->view('default', $this->data);
    }

    public function rewards()
    {
        $list  = $this->db->select('distinct(user_id)')->where('notes', 'Rewards')->get('transaction')->result();
        $users = array();
        foreach ($list as $ob) {
            $user         = $this->db->get_where("users", array("id" => $ob->user_id))->row();
            $user->amount = $this->User_model->getCareerIncome($ob->user_id);
            $users[]      = $user;
        }
        $this->data['users'] = $users;
        $this->data['type'] = 'Rewards';
        $this->load->view('default', $this->data);
    }

    function generatenow()
    {
        $list  = $this->db->select('distinct(user_id)')->where('cr_dr', 'cr')->get('transaction')->result();
        $data = array();
        foreach ($list as $ob) {
            // $amount = $this->User_model->currentIncome($ob->user_id);
            $amount = $this->User_model->payoutIncome($ob->user_id);
            $payout = $amount - ($amount * 0.15);
            if ($amount >= 200) {
                $user = new stdClass();
                $user->id = $ob->user_id;
                $user->total = $amount;
                $user->paid  = $payout;
                $user->is_paid = 0;
                $data[] = $user;
            }
        }
        $save = array();
        $save['details'] = json_encode($data);
        $save['created'] = date("Y-m-d H:i");
        $save['paytype'] = 'Payout';
        $save['status']  = 0;
        $this->db->insert("payout", $save);
        $this->session->set_flashdata("success", ' Payout generated successfully.');
        redirect(admin_url('payout'));
    }

    function payout_paid($pay_id, $user_id, $mode = "Bank")
    {
        $ob = $this->db->get_where('payout', array('id' => $pay_id))->row();
        $details = json_decode($ob->details);
        $ars = array();
        foreach ($details as $ob) {
            if ($ob->id == $user_id) {
                $ob->is_paid = 1;
                $ob->note = $mode;

                $data = array();
                $data['user_id'] = $ob->id;
                $data['amount'] = $ob->total;
                $data['notes'] = 'Payout';
                $data['cr_dr'] = 'dr';
                $data['created'] = date("Y-m-d H:i");
                $this->db->insert("transaction", $data);

                // Check for wallet payment
                if ($mode == "Wallet") {
                    $data = array();
                    $data['user_id'] = $ob->id;
                    $data['amount'] = $ob->paid;
                    $data['notes'] = 'Wallet';
                    $data['cr_dr'] = 'cr';
                    $data['created'] = date("Y-m-d H:i");
                    $this->db->insert("wallet", $data);
                }
            }
            $ars[] = $ob;
        }
        $this->db->update('payout', array('details' => json_encode($ars)), array('id' => $pay_id));
        $this->session->set_flashdata('success', 'Payment has been marked as paid');
        redirect(admin_url('payout/listview/' . $pay_id));
    }

    function payout_unpaid($id)
    {
        $ob = $this->db->get_where('payout', array('id' => $id))->row();
        $details = json_decode($ob->details);
        $data = array();
        foreach ($details as $ob) {
            $ob->is_paid = 0;
            $data[] = $ob;
        }
        $this->db->update('payout', array('details' => json_encode($data)), array('id' => $id));
    }

    function generatenow1()
    {
        echo 'Work in Progress';
        die;
        $type = $_GET['type'];
        switch ($type) {
            case 'career':
                $list  = $this->db->select('distinct(user_id)')->where('notes', 'Career')->get('transaction')->result();
                $data = array();
                foreach ($list as $ob) {
                    $amount = $this->User_model->currentIncome($ob->user_id);
                    $payout = $amount - ($amount * 0.15);
                    if ($payout >= 200) {
                        $user = new stdClass();
                        $user->id = $ob->user_id;
                        $user->total = $amount;
                        $user->paid  = $payout;
                        $data[] = $user;
                    }
                }
                $save = array();
                $save['details'] = json_encode($data);
                $save['created'] = date("Y-m-d H:i");
                $save['paytype'] = 'Career';
                $save['status']  = 0;
                $this->db->insert("payout", $save);
                break;
            case 'autofill':
                $data = array();
                $list  = $this->db->select('distinct(user_id)')->where('notes', 'Autofill')->get('transaction')->result();
                foreach ($list as $ob) {
                    $amount = $this->User_model->getAutofillIncome($ob->user_id);
                    $payout = $amount - ($amount * 0.15);
                    if ($payout >= 200) {
                        $user = new stdClass();
                        $user->id = $ob->user_id;
                        $user->total = $amount;
                        $user->paid  = $payout;
                        $data[] = $user;
                    }
                }
                $save = array();
                $save['details'] = json_encode($data);
                $save['created'] = date("Y-m-d H:i");
                $save['paytype'] = 'Autofill';
                $save['status']  = 0;
                $this->db->insert("payout", $save);
                break;
            case 'repurchase':
                $data = array();
                $list  = $this->db->select('distinct(user_id)')->where('notes', 'Repurchase')->get('transaction')->result();
                foreach ($list as $ob) {
                    $amount = $this->User_model->getRepurchaseIncome($ob->user_id);
                    $payout = $amount - ($amount * 0.15);
                    if ($payout >= 200) {
                        $user = new stdClass();
                        $user->id = $ob->user_id;
                        $user->total = $amount;
                        $user->paid  = $payout;
                        $data[] = $user;
                    }
                }

                $save = array();
                $save['details'] = json_encode($data);
                $save['created'] = date("Y-m-d H:i");
                $save['paytype'] = 'Repurchase';
                $save['status']  = 0;
                $this->db->insert("payout", $save);
                break;
            case 'rewards':
                $list  = $this->db->select('distinct(user_id)')->where('notes', 'Rewards')->get('transaction')->result();
                foreach ($list as $ob) {
                    $amount = $this->User_model->getCareerIncome($ob->user_id);
                }
                break;
            default:
        }
        $this->session->set_flashdata("success", ucwords($type) . ' Payout generated.');
        redirect(admin_url('payout'));
    }

    function withdrawal()
    {
        $this->data['main'] = 'payouts/withdrawal';
        if (isset($_GET['new']) && $_GET['new'] == 'yes') {
            $this->db->where('status', 0);
        }
        $this->data['paylist'] = $this->db->order_by('id', 'DESC')->get('withdraw')->result();
        $this->load->view('default', $this->data);
    }

    function withdrawal_update($id)
    {
        if (isset($_GET['status'])) {
            $this->Dashboard_model->update_withdraw_request($id, $_GET['status']);
            $this->session->set_flashdata('success', "Withdrawal request has been updated");
        }
        redirect(admin_url('payout/withdrawal'));
    }
}
