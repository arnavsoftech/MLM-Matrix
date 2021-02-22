<?php
class Home extends AI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['main'] = 'index';
        $this->load->front_view('default', $this->data);
    }

    public function login()
    {
        $this->form_validation->set_rules('data[userid]', 'userid', 'required');
        $this->form_validation->set_rules('data[passwd]', 'Password', 'required');
        if ($this->form_validation->run()) {
            $data   = $this->input->post('data');
            $userid = $data['userid'];
            $pass   = $data['passwd'];
            $user   = $this->User_model->loginCheck($userid, $pass);
            if (is_object($user)) {
                $u    = $user;
                $data = (array) $u;
                $s    = array(
                    'user_id' => $u->id,
                );
                $this->session->set_userdata('login', $s);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                redirect('login');
            }
        }
        $this->data['main'] = 'login';
        $this->load->front_view('default', $this->data);
    }

    public function about()
    {
        $this->data['main'] = 'about';
        $this->load->front_view('default', $this->data);
    }

    public function plans()
    {
        $this->data['main'] = 'plan';
        $this->load->front_view('default', $this->data);
    }

    public function legal()
    {
        $this->data['main'] = 'legal';
        $this->load->front_view('default', $this->data);
    }
    public function banking()
    {
        $this->data['main'] = 'banking';
        $this->load->front_view('default', $this->data);
    }

    public function contacts()
    {
        $this->data['main'] = 'contact';
        $this->load->front_view('default', $this->data);
    }

    public function gallery()
    {
        $this->data['main'] = 'gallery';
        $this->load->front_view('default', $this->data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function register()
    {
        $refcode = isset($_GET['ref']) ? $_GET['ref'] : '';
        if ($refcode != '') {
            $this->session->set_userdata('refcode', $refcode);
        }
        if ($this->session->has_userdata('refcode')) {
            $refcode = $this->session->userdata('refcode');
        }
        $this->data['refcode'] = $refcode;
        $this->data['main']    = 'register';
        if ($this->input->post('save')) {
            $type = $this->input->post('jointype');
            $user = $this->input->post('form');
            $join_amt = 1000;
            if ($type == 1) { // Joining by sponsor id
                $sp = $user['epin']; //
                $us = $this->db->get_where('users', array('username' => $sp))->row();
                if (is_object($us)) {
                    $user['epin']       = '';
                    $user['sponsor_id'] = $us->id;
                } else {
                    $this->session->set_flashdata('error', 'Sorry!! Sponsor Id is Invalid');
                    redirect('register');
                }
            } else { // Joining by pin
                $p = $this->db->get_where('epin', array('pin' => $user['epin']))->row();
                if (is_object($p) && $p->status == 1) {
                    $user['sponsor_id'] = $p->user_id;
                    //Disable pin for next joining
                    $this->db->update('epin', array('status' => 0), array('pin' => $user['epin']));
                } else {
                    $this->session->set_flashdata('error', 'Sorry!! Activation PIN Id is Invalid');
                    redirect('register');
                }
                $join_amt = $p->pintype;
            }
            $user['join_date']   = date("Y-m-d");
            $user['status']      = 1;
            $pass                = rand(1111, 9999);
            $user['passwd']      = $pass;
            $user['father_name'] = '';
            $user['plan_total']  = $join_amt;
            $user['ac_status']   = 0;

            $random_chk = config_item('random_id');
            $username = null;
            if ($random_chk) {
                $id = $user['id'] = $this->User_model->getRandomUserId();
                $user['username'] = $username = id2userid($id);
                $this->db->insert('users', $user);
            } else {
                $this->db->insert('users', $user);
                $id       = $this->db->insert_id();
                $username = id2userid($id);

                // Create new accounts
                $this->db->update('users', array('username' => $username), array('id' => $id));
            }

            if ($type == 2) {
                // Pass newly registered users id for payment calculation
                $this->User_model->doAllPaymentCalculations($id);
            }

            $this->session->set_flashdata('success', 'New account has been created with Username : ' . $username . ' and Password: ' . $user['passwd']);
            redirect('register');
        }
        $this->load->front_view('default', $this->data);
    }

    function ajax_signup_check()
    {
        header('Content-Type: application/json');
        $ob = new stdClass();
        $ob->success = false;
        $ob->message = null;
        $p = $_GET;
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $v = $_GET['txt'];
            if ($type == 1) {
                // Sponsor Id Test
                $me = $this->db->get_where('users', array('username' => strtoupper($v)))->row();
                if (is_object($me)) {
                    $ob->message = $me->first_name . ' ' . $me->last_name;
                    $ob->success = true;
                } else {
                    $ob->message = "Opps!! Invalid Sponsor Id";
                    $ob->success = false;
                }
            } else {
                // Pin Test
                $p = $this->db->get_where('epin', array('pin' => $v, 'status' => 1))->row();
                if (is_object($p)) {
                    $ob->success = true;
                    $ob->message = "Congratulation!! You can use pin";
                } else {
                    $ob->success = false;
                    $ob->message = "Opps!! PIN has been expired or used.";
                }
            }
        }
        echo json_encode($ob);
    }


    public function autologin()
    {
        $userid = $_GET['user'];
        $pass   = $_GET['pass'];
        $user   = $this->User_model->loginCheck($userid, $pass);
        if (is_object($user)) {
            $u = $user;
            $s = array(
                'user_id' => $u->id,
            );
            $this->session->set_userdata('login', $s);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid Username or Password');
            redirect('login');
        }
    }

    function recharge()
    {

        $bal = $this->User_model->getWalletBalance(user_id());

        $ob = new stdClass();
        header('Content-Type: application/json');
        $app = new Recharge();
        $act = $_POST['act'];

        if ($act == 'Prepaid' || $act == 'Postpaid') {

            $scode = $_POST['net'];
            $amount = intval($_POST['amt']);
            $mobile = $_POST['mob'];

            if ($amount == 0 || $amount < 10) {
                $ob->status = false;
                $ob->message = 'Min recharge Rs 10';
            } else if ($amount > $bal) {
                $ob->status = false;
                $ob->message = 'Opps!! Insufficient balance.';
            } else if (strlen($mobile) != 10) {
                $ob->status = false;
                $ob->message = 'Opps!! Enter 10 digit mobile number only';
            } else {

                $app->setConfig(Recharge::SERVICE_CODE, $scode);
                $app->setConfig(Recharge::CUSTOMER_NUMBER, $mobile);
                $app->setConfig(Recharge::RECHARGE_AMOUNT, $amount);
                $resp = $app->rechargeMobile();

                //Recharge History
                $data = array();
                $data['user_id'] = user_id();
                $data['mobile_no'] = $mobile;
                $data['rech_type'] = 'Mobile';
                $data['rech_resp'] = $resp;
                $data['rech_amt'] = $amount;
                $data['created'] = date("Y-m-d H:i");
                $data['rech_provider'] = $scode;

                $this->db->insert('recharge_history', $data);

                $respOb = json_decode($resp);
                if ($respOb->STATUSCODE == 0) {

                    $ob->status = true;
                    $ob->data = $respOb;

                    //Transaction update
                    $pay            = array();
                    $pay['user_id'] = user_id();
                    $pay['amount']  = $amount;
                    $pay['notes']   = 'Recharge';
                    $pay['cr_dr']   = 'dr';
                    $pay['created'] = date("Y-m-d H:i");
                    $this->db->insert('wallet', $pay);
                } else {
                    $ob->status = false;
                    $ob->data = $respOb;
                }
            }
        } else if ($act == 'DTH') {
            $scode = $_POST['net'];
            $amount = $_POST['amt'];
            $mobile = $_POST['mob'];


            if ($amount == 0 || $amount < 10) {
                $ob->status = false;
                $ob->message = 'Min recharge Rs 10';
            } else if ($amount > $bal) {
                $ob->status = false;
                $ob->message = 'Opps!! Insufficient balance.';
            } else if (strlen($mobile) != 10) {
                $ob->status = false;
                $ob->message = 'Opps!! Enter 10 digit mobile number only';
            } else {
                $app->setConfig(Recharge::SERVICE_CODE, $scode);
                $app->setConfig(Recharge::DTH_REFNO, $mobile);
                $app->setConfig(Recharge::RECHARGE_AMOUNT, $amount);
                $app->setConfig(Recharge::CUSTOMER_NUMBER, user_id());
                $resp = $app->rechargeMobile();
                $ob->status = true;
                $ob->data = $resp;
            }
        }
        echo json_encode($ob);
    }
    function ajax_get_name()
    {
        header('Content-Type: application/json');
        $userid = $_GET['userid'];
        $this->db->select("first_name, last_name, mobile");
        $user = $this->db->get_where("users", array("username" => $userid))->row();
        if (is_object($user)) {
            $user->success = true;
        } else {
            $user = new stdClass();
            $user->success = false;
        }
        echo json_encode($user);
    }

    function jolo_callback()
    {
        print_r($_POST);
    }

    function cron_jobs()
    {
        $list = $this->db->get_where("payments", array("status" => 1))->result();
        $dayNum = date("w");
        foreach ($list as $ob) {
            if ($dayNum == 0 || $dayNum == 6) continue; // No payout on Sat = 6 and Sun = 0

            $pay            = array();
            $pay['user_id'] = $ob->user_id;
            $pay['amount']  = $ob->amount;
            $pay['notes']   = $ob->paylevel == 0 ? Dashboard_model::INCOME_ROI : Dashboard_model::INCOME_LEVEL;
            $pay['cr_dr']   = 'cr';
            $pay['created'] = date("Y-m-d H:i");
            $pay['ref_id'] = date("Ymd") . '-' . $ob->payfor;
            $pay['paylevel'] = $ob->paylevel;
            $this->db->insert('transaction', $pay);

            $days = noOfDays($ob->ed_date);

            // Check and deactivate Payments
            if ($days <= 0) {
                $this->db->update("payments", array("status" => 2), array("id" => $ob->id));
            }
        }
    }

    function cron_payment_status_check()
    {
        $ids = $this->db->get_where('payments', array('status' => 0))->result();
        foreach ($ids as $ob) {
            $childs = $this->db->get_where('users', array('sponsor_id' => $ob->user_id, 'epin !=' => ''))->num_rows();
            $i = $ob->paylevel;
            $pay = array();
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
            if ($pay['status'] == 1) {
                // echo "User: " . $ob->user_id . '><Level: ' . $ob->paylevel . "\r\n";
                $this->db->update('payments', $pay, array('id' => $ob->id));
            }
        }
    }

    function cron_daily_payout()
    {
        $rest = $this->db->select('id')->where(array('epin !=' => ''))->get('users')->result();
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
            $save['amount'] = $bal * 0.80;
            $save['user_id'] = $r->id;
            $save['notes'] = "Account";
            $save['cr_dr'] = "cr";
            $save['created'] = date("Y-m-d H:i");
            $save['ref_id'] = $this->db->insert_id();

            $this->db->insert('wallet', $save);
        }
    }

    function reset()
    {
        $this->data['main'] = 'reset-password';
        $this->load->front_view('default', $this->data);
    }

    function call($m = null)
    {
        $api = new RestApi();
        switch ($m) {
            case 'reset':
                $m = $_GET['mobile'];
                $us = $this->db->get_where('users', array('username' => $m))->row();
                if (is_object($us)) {
                    // Send SMS to Reg. mobile number
                    $msg = "Dear " . $us->first_name . " Your password with " . config_item('company') . " is : " . $us->passwd;
                    sendSMS($us->mobile, $msg);
                    $api->setOK();
                    $api->setMessage("Password has been sent on your mobile");
                } else {
                    $api->setError();
                    $api->setMessage('Username does not exist!!');
                }
                $api->setData($m);
                break;
            case 'email':
                if ($api->check(array('username', 'phone', 'email', 'comment'))) {
                    $em = new AI_Mail();
                    $em->onContact($_GET['username'], "Contact Enquiry", $_GET['email'], $_GET['phone'], $_GET['comment']);
                    $em->sendMail();

                    $api->setOK();
                    $api->setMessage("Email sent successfully");
                } else {
                    $api->missing();
                }
                break;
            case 'userinfo':
                if ($api->check(array('username'))) {
                    $username = $_GET['username'];
                    $us = $this->db->get_where('users', array('username' => $username))->row();
                    if (is_object($us)) {
                        $api->setOK();
                        $api->setData($us);
                    } else {
                        $api->setError();
                        $api->setMessage("Opps!! Invalid username");
                    }
                } else {
                    $api->missing();
                }
                break;
            default:
        }
        $api->render();
    }

    function test_sms()
    {
        sendSMS(9334628120, 'Hello Testing SMS Delivery');
    }
}
