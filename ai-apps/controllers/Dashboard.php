<?php
class Dashboard extends AI_Controller
{
    public $category;
    private $__perPage = 24;
    public function __construct()
    {
        parent::__construct();
        $flag = $this->session->userdata('login');

        if ($flag == false) {
            $this->session->set_flashdata("error", "Your must login to View this page.");
            redirect('login');
        }
        $this->data['me'] = $this->data['user'] = $this->User_model->getUserById(user_id());
        $this->load->helper(array('cookie', 'url'));
    }

    public function index()
    {
        $this->data['main']     = "dashboard/index";
        $this->data['level_income']  = $this->User_model->getIncomeByType(user_id(), Dashboard_model::INCOME_LEVEL);
        $this->data['roi_income']  = $this->User_model->getIncomeByType(user_id(), Dashboard_model::INCOME_ROI);
        $this->data['self_team']  = $this->db->get_where('users', array('sponsor_id' => user_id()))->num_rows();
        $s = $this->User_model->getDownloadLineIds(user_id());
        $tm = 0;
        foreach ($s as $sid) {
            $ob = $this->db->select('epin')->get_where('users', array('id' => $sid))->row();
            if ($ob->epin != '') {
                $tm++;
            }
        }
        $this->data['active_members'] = $tm;
        $this->data['total_team']  = count($s);
        $this->data['total_income'] = $this->User_model->totalIncome(user_id());
        $in = $this->User_model->currentIncome(user_id());
        $wlt = $this->User_model->getWalletBalance(user_id());
        $this->data['wallet_income'] = ($in * 0.80) + $wlt;
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function addnew($pin = false)
    {
        $this->data['main'] = 'dashboard/add-new';
        if ($pin) {
            $p = $this->db->get_where('epin', array('pin' => $pin))->row();
            if (is_object($p) && $p->status == 1) {
                $this->data['pin'] = $p;
                $sponsor           = $this->input->post('sponsor');
                $spuser            = $this->db->get_where('users', array('username' => strtoupper($sponsor)))->row();
                $this->form_validation->set_rules('form[first_name]', 'First name', 'required');
                $this->form_validation->set_rules('form[last_name]', 'Last name', 'required');
                $this->form_validation->set_rules('form[mobile]', 'Mobile no', 'required|numeric|exact_length[10]');
                if ($this->form_validation->run() && is_object($spuser)) {

                    $user                = $this->input->post("form");
                    $user['sponsor_id']  = $spuser->id;
                    $user['join_date']   = date("Y-m-d");
                    $user['ac_active_date']   = date("Y-m-d");
                    $user['status']      = 1;
                    $pass                = rand(1111, 9999);
                    $user['passwd']      = $pass;
                    $user['father_name'] = '';
                    $user['plan_total']  = $p->pintype;
                    $user['ac_status']   = 0;
                    $user['epin']        = $pin;

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

                    //Disable pin for next joining
                    $this->db->update('epin', array('status' => 0), array('pin' => $pin));

                    //Do All Payment Calculation
                    $this->User_model->doAllPaymentCalculations($id);

                    $password = $user['passwd'];
                    $this->session->set_flashdata('success', 'New account has been created with Username : ' . $username . ' and Password: ' . $user['passwd']);
                    $name = $user['first_name'] . ' ' . $user['last_name'];

                    $company = config_item('company');
                    $msg = "Hi $name, Welcome to $company. Your username: " . $username . " and Password: " . $password . " Please Login at: " . site_url('login');
                    sendSMS($user['mobile'], $msg);

                    redirect('dashboard/pin-list');
                }
                $this->load->front_view('dashboard/default', $this->data);
            } else {
                $this->session->set_flashdata('error', 'Sorry !! PIN already has been used');
                redirect('dashboard/pin-list');
            }
        } else {
            $this->session->set_flashdata('error', 'Opps!! Some Error occured');
            redirect('dashboard');
        }
    }

    public function addnew_deprecated($pin = false)
    {

        $this->data['main'] = 'dashboard/add-new';
        if ($pin) {
            $p = $this->db->get_where('epin', array('pin' => $pin))->row();
            if (is_object($p)) {

                $this->data['pin'] = $p;

                $this->form_validation->set_rules('sponsor', 'user id', 'required');

                if ($this->form_validation->run()) {

                    $sponsor           = $this->input->post('sponsor');
                    $spuser            = $this->db->get_where('users', array('username' => strtoupper($sponsor)))->row();
                    if ($spuser->ac_status == 1) {
                        $this->session->set_flashdata('error', 'Your Account Already  Activated');
                        redirect('dashboard/addnew/' . $pin);
                    }
                    $table = 'matrix';

                    $user['ac_active_date']   = date("Y-m-d H:i");
                    $user['plan_total']  = $p->pintype;
                    $user['ac_status']   = 1;
                    $user['epin']        = $pin;
                    $this->db->where("id", $spuser->id);
                    $this->db->update("users", $user);
                    $this->User_model->upgradeToDiamond($spuser->id, $table);

                    //Disable pin for next joining
                    $this->db->update('epin', array('status' => 0), array('pin' => $pin));

                    $this->session->set_flashdata('success', 'Your Account Activated successfully');


                    redirect('dashboard/pin-list');
                }
                $this->load->front_view('dashboard/default', $this->data);
            } else {
                $this->session->set_flashdata('error', 'Sorry !! PIN already has been used');
                redirect('dashboard/pin-list');
            }
        } else {
            $this->session->set_flashdata('error', 'Opps!! Some Error occured');
            redirect('dashboard');
        }
    }

    public function change_password()
    {
        $this->data['main']  = "dashboard/change-password";
        $this->data['title'] = 'CHANGE PASSWORD';
        $this->form_validation->set_rules("oldpass", "Old Password", "required");
        $this->form_validation->set_rules("new_pass", "New Password", "required");
        $this->form_validation->set_rules("cnfpassword", "Confirm Password", "required|matches[new_pass]");
        if ($this->form_validation->run()) {
            $old = $this->input->post("oldpass");
            $new = $this->input->post("new_pass");

            $userid = $_SESSION['login']['user_id'];
            $u      = $this->Master_model->getRow($userid, "ai_users");
            if ($u->passwd == $old) {
                $s           = array();
                $s['id']     = $u->id;
                $s['passwd'] = $new;
                $this->Master_model->save($s, "ai_users");
                $this->session->set_flashdata("success", "Password Changed Successfully");
            } else {
                $this->session->set_flashdata("error", "Old Password not matching");
            }
            redirect("dashboard/change_password");
        }

        $this->load->front_view('dashboard/default', $this->data);
    }

    public function edit_profile()
    {

        $config['upload_path']   = upload_dir();
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
        $config['max_size']      = 0;
        $config['max_width']     = 0;
        $config['max_height']    = 0;
        $this->load->library('upload', $config);
        $this->data['title']   = 'PROFILE';
        $this->data['main']    = 'dashboard/profile';
        $this->data['st']      = $this->db->get('ai_states')->result();
        $this->data['profile'] = $e = $this->User_model->edit_profile();

        $this->form_validation->set_rules('form[city_name]', 'Bank name', 'required');
        $this->form_validation->set_rules('form[address]', 'Bank branch', 'required');
        if ($e->ac_status == 0) {
            $this->form_validation->set_rules('bank[bank_name]', 'Bank name', 'required');
            $this->form_validation->set_rules('bank[branch]', 'Bank branch', 'required');
            $this->form_validation->set_rules('bank[ac_number]', 'Account number', 'required');
            $this->form_validation->set_rules('bank[ac_name]', 'Account holder name', 'required');
            $this->form_validation->set_rules('bank[ifsc]', 'IFSC Code', 'required');
        }

        if ($this->form_validation->run()) {
            $m        = $this->input->post("form");
            $m['id']  = user_id();
            $uploaded = $this->upload->do_upload('image');
            if ($this->input->post('del_image')) {
                $img_name = $this->input->post('hid_image');
                @unlink(upload_dir($img_name));
                $m['image'] = '';
            }
            if ($uploaded) {
                $image      = $this->upload->data();
                $m['image'] = $image['file_name'];
            }
            if ($this->input->post('bank')) {
                $bank           = $this->input->post("bank");
                $m['bank_info'] = json_encode($bank);
                $m['ac_status'] = 1;
            }

            $this->Master_model->save($m, "users");
            $this->session->set_flashdata('success', "Details updated successfully");
            redirect(site_url('dashboard/edit-profile'));
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function kyc()
    {
        $config['upload_path']   = upload_dir();
        $config['allowed_types'] = '*';
        $config['max_size']      = '5000';
        $config['max_width']     = '3000';
        $config['max_height']    = '2000';
        $this->load->library('upload', $config);
        $this->data['title'] = "upload file";
        $this->data['main']  = 'dashboard/kyc';
        $this->data['doc']   = $this->db->get_where('users', array('id' => user_id()))->row();

        $kyc      = $this->db->get_where('users', array('id' => user_id()))->row();
        $uploaded = $this->upload->do_upload('photo');
        //print_r($uploaded );
        if ($uploaded) {
            $image      = $this->upload->data();
            $s['photo'] = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            $i = true;
            redirect(site_url('dashboard/kyc'));
        }

        $uploaded = $this->upload->do_upload('pan');

        if ($uploaded) {
            $image    = $this->upload->data();
            $s['pan'] = $image['file_name'];
            $this->session->set_flashdata("success", "Pan card uploaded Successfully.Please Upload Other remain document.");
            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            redirect(site_url('dashboard/kyc'));
        }

        $uploaded = $this->upload->do_upload('aadharf');

        if ($uploaded) {

            $image        = $this->upload->data();
            $s['aadharf'] = $image['file_name'];

            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            $this->session->set_flashdata("success", "AAdhar Front  uploaded Successfully.Please Upload Other remain document.");
            redirect(site_url('dashboard/kyc'));
        }
        $uploaded = $this->upload->do_upload('aadharb');

        if ($uploaded) {

            $image        = $this->upload->data();
            $s['aadharb'] = $image['file_name'];

            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            $this->session->set_flashdata("success", "AAdhar Back Uploaded Successfully.Please Upload Other remain document.");
            redirect(site_url('dashboard/kyc'));
        }

        $uploaded = $this->upload->do_upload('passbook');

        if ($uploaded) {

            $image         = $this->upload->data();
            $s['passbook'] = $image['file_name'];
            $this->session->set_flashdata("success", "Passbook Uploaded Successfully.Please Upload Other remain document.");
            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            redirect(site_url('dashboard/kyc'));
        }

        if ($this->input->post('adhar_no')) {
            $save = array();
            $save['adhar_no'] = $this->input->post('adhar_no');
            $this->db->update('users', $save, array('id' => user_id()));
            $this->session->set_flashdata("success", "Aadhar no updated");
            redirect(site_url('dashboard/kyc'));
        }
        if ($this->input->post('pan_no')) {
            $save = array();
            $save['pan_no'] = $this->input->post('pan_no');
            $this->db->update('users', $save, array('id' => user_id()));
            $this->session->set_flashdata("success", "PAN no updated");
            redirect(site_url('dashboard/kyc'));
        }

        if ($kyc->image != '' && $kyc->pan != '' && $kyc->aadharf != '' && $kyc->aadharb != '' && $kyc->passbook != '') {
            $s['kyc_status'] = 1;

            $this->db->where('id', user_id());
            $this->db->update('users', $s);
            $this->session->set_flashdata("success", "All documents are uploaded successfully");
            redirect(site_url('dashboard/kyc'));
        }

        $this->load->front_view('dashboard/default', $this->data);
    }

    public function welcome()
    {

        $this->data['title'] = 'WELCOME LETTER';
        $this->data['let']   = $this->User_model->letter();
        $this->load->front_view('dashboard/welcome', $this->data);
    }
    function card()
    {
        $this->data['main'] = 'card';
        $this->load->front_view('card', $this->data);
    }
    public function id_card()
    {

        $this->data['title'] = 'WELCOME LETTER';
        //$this->data['let']   = $this->User_model->letter();
        $this->load->front_view('card', $this->data);
    }

    function fund_request()
    {
        $this->data['main']     = 'dashboard/fund-request';
        $this->data['arorders'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('fund_request')->result();
        $this->form_validation->set_rules('amount', 'Amount', 'required');

        $config                  = array();
        $config['upload_path']   = upload_dir();
        $config['allowed_types'] = 'jpeg|jpg|png|bmp';
        $config['max_size']      = '0';
        $this->load->library('upload', $config);

        if ($this->form_validation->run()) {
            $x            = array();
            $x['id']      = false;
            $x['user_id'] = user_id();
            $x['amount'] = $this->input->post("amount");
            $x['txn_no']  = $this->input->post("txn_no");
            $x['notes']   = $this->input->post("notes");
            $x['created'] = date('Y-m-d H:i');
            $x['status']  = 0;

            $uploaded = $this->upload->do_upload('screenshot');
            if ($uploaded) {
                $image           = $this->upload->data();
                $x['screenshot'] = $image['file_name'];
            }

            $this->Master_model->save($x, 'fund_request');
            $this->session->set_flashdata('success', "Fund Request has been done successfully");
            redirect(site_url('dashboard/fund-request'));
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function income($type)
    {
        $this->data['main']     = 'dashboard/income';
        if ($type == 'reward') {
            $this->data['title'] = 'Level Reward Completion Income';
        } elseif ($type == 'rebirth') {
            $this->data['title'] = 'Rebirth Magic Income';
        } else {
            $this->data['title'] = ucwords($type) . ' Income';
        }
        $this->data['type'] = $type;
        $this->data['arorders'] = $this->db->group_by('notes')->order_by('id', 'asc')->get_where('transaction', array('user_id' => user_id(), 'notes' => $type))->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function income_detail($type)
    {
        $this->data['main']     = 'dashboard/income_detail';
        if ($type == 'reward') {
            $this->data['title'] = 'Level Reward Completion Income';
        } elseif ($type == 'rebirth') {
            $this->data['title'] = 'Rebirth Magic Income';
        } else {
            $type = 'level';
            $this->data['title'] = ucwords($type) . ' Income';
        }


        $this->data['type'] = $type;

        $this->data['arorders'] = $this->db->order_by('id', 'asc')->get_where('transaction', array('user_id' => user_id(), 'notes' => $type))->result();

        $this->load->front_view('dashboard/default', $this->data);
    }

    public function rebirth_wallet()
    {
        $this->data['main']     = 'dashboard/rebirth_wallet';


        $this->data['cr'] = $this->db->select('sum(rebirth) as total')->get_where('transaction', array('user_id' => user_id(), 'cr_dr' => 'cr'))->row()->total;

        $this->data['dr'] = $this->db->select('sum(amount) as total')->get_where('wallet', array('user_id' => user_id(), 'cr_dr' => 'dr'))->row()->total;

        $this->data['total'] = $this->data['cr'] - $this->data['dr'];
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function payout_history()
    {
        $this->data['main']     = 'dashboard/payout_history';
        $this->data['arorders'] = $this->db->order_by('id', 'DESC')->get_where('transaction', array('user_id' => user_id(), 'cr_dr' => 'dr'))->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function pin_request_bank()
    {
        $this->data['main']     = 'dashboard/pin-request-bank';
        $this->data['arorders'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('epin_request')->result();
        $this->form_validation->set_rules('pin_qty', 'Quantity', 'required');

        $config                  = array();
        $config['upload_path']   = upload_dir();
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']      = '0';
        $this->load->library('upload', $config);

        if ($this->form_validation->run()) {
            $x            = array();
            $x['id']      = false;
            $x['user_id'] = user_id();
            $x['pin_qty'] = $this->input->post("pin_qty");
            $x['txn_no']  = $this->input->post("txn_no");
            $x['notes']   = $this->input->post("notes");
            $x['pintype']   = $this->input->post("pintype");
            $x['created'] = date('Y-m-d H:i');
            $x['status']  = 0;

            $uploaded = $this->upload->do_upload('screenshot');
            if ($uploaded) {
                $image           = $this->upload->data();
                $x['screenshot'] = $image['file_name'];
            }

            $this->Master_model->save($x, 'epin_request');
            $this->session->set_flashdata('success', "Request has been done successfully");
            redirect(site_url('dashboard/pin-request-bank'));
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function pin_request_balance()
    {
        $this->load->model('Epin_model');
        $this->data['main']     = 'dashboard/pin-request-balance';
        $this->data['arorders'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('epin_request')->result();
        $this->form_validation->set_rules('pin_qty', 'Quantity', 'required');

        $config                  = array();
        $config['upload_path']   = upload_dir();
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']      = '0';
        $this->load->library('upload', $config);

        if ($this->form_validation->run()) {
            $x            = array();
            $x['id']      = false;
            $x['user_id'] = user_id();
            $x['pin_qty'] = $this->input->post("pin_qty");
            $x['txn_no']  = "Balance"; //$this->input->post("txn_no");
            $x['notes']   = $this->input->post("notes");
            $x['pintype'] = $this->input->post("pintype");
            $x['created'] = date('Y-m-d H:i');
            $x['status']  = 1;
            $this->Master_model->save($x, 'epin_request');

            //  create pin
            $qty = $this->input->post('pin_qty');
            for ($i = 1; $i <= $qty; $i++) {
                $x = array(
                    'id' => false,
                    'user_id' => user_id(),
                    'owner_id' => user_id(),
                    'pintype' => $this->input->post("pintype"),
                    'status' => 1,
                    'pin_from' => 0,
                    'pin' => $this->Epin_model->newpin()
                );
                $this->Master_model->save($x, 'epin');
            }

            // transaction update
            $amt = $qty * $this->input->post("pintype");
            $pay            = array();
            $pay['user_id'] = user_id();
            $pay['amount']  = $amt;
            $pay['notes']   = 'Pin';
            $pay['cr_dr']   = 'dr';
            $pay['created'] = date("Y-m-d H:i");
            $this->db->insert('transaction', $pay);

            $this->session->set_flashdata('success', "Pin has been created successfuly");
            redirect(site_url('dashboard/pin-request-balance'));
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function pin_transfer()
    {
        $this->data['main']  = 'dashboard/pin-transfer';
        $this->data['epins'] = $this->db->order_by('id', 'DESC')->where(array('user_id' => user_id(), 'status' => 1))->get('epin')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function transfer()
    {
        $this->data['main'] = 'dashboard/transfer';
        if ($this->input->post('pinids')) {
            $ids                 = $this->input->post('pinids');
            $this->data['epins'] = $ids;
            $this->load->front_view('dashboard/default', $this->data);
        } else {
            $this->session->set_flashdata('error', "You must select pin to transfer");
            redirect('dashboard/pin-transfer');
        }
    }

    public function dotransfer()
    {
        if ($this->input->post('sponser')) {
            $sp = $this->input->post('sponser');
            $ob = $this->db->get_where('users', array('username' => $sp))->row();
            if (is_object($ob)) {
                $pin   = $this->input->post("pin");
                $arpin = explode(':', $pin);
                foreach ($arpin as $pin) {
                    $this->db->update('epin', array('user_id' => $ob->id), array('pin' => $pin));
                }
                $this->session->set_flashdata('error', 'PIN Transfer Completed');
            } else {
                $this->session->set_flashdata('error', 'Invalid Sponser Details');
            }
        }
        redirect('dashboard/pin-transfer');
    }

    public function pin_list()
    {

        $this->data['main']  = 'dashboard/pin-list';
        if (isset($_GET['status'])) {
            $this->db->where('status', $_GET['status']);
        }
        $this->data['epins'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('epin')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function members()
    {
        $this->data['main'] = 'dashboard/members';
        $this->data['members'] = $this->db->get_where('users', array('sponsor_id' => user_id()))->result();
        $this->load->front_view('dashboard/default', $this->data);
    }
    public function member_tree($id = false)
    {
        $this->data['main'] = 'dashboard/member-tree';
        $this->data['id']  = $id;
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function payment_history()
    {
        $this->data['main']    = 'dashboard/payment-history';
        $this->data['title'] = "Payment History";
        $this->data['arrdata'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('transaction')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function wallet_history()
    {
        $this->data['main']    = 'dashboard/payment-history';
        $this->data['title'] = "Wallet History";
        $this->data['arrdata'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('wallet')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function business()
    {
        $this->data['main']    = 'dashboard/business';
        $this->data['arrdata'] = $this->db->order_by('id', 'DESC')->where('user_id', user_id())->get('business')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function activate($user_id = false)
    {
        $this->data['main'] = 'dashboard/activate';
        $this->data['user'] = $this->db->get_where('users', array('id' => $user_id))->row();
        if ($this->input->post('submit')) {
            $pin = $this->input->post('epin');
            $p   = $this->db->get_where('epin', array('pin' => $pin))->row();
            if (is_object($p) && $p->status == 1) {
                $arr = array('epin' => $pin, 'ac_status' => 1);
                $arr['ac_active_date']   = date("Y-m-d");
                $arr['plan_total'] = $p->pintype;
                $this->db->update('users', $arr, array('id' => $user_id));

                //Disable pin for next joining
                $this->db->update('epin', array('status' => 0), array('pin' => $pin));
                $this->session->set_flashdata('success', 'Your account is now active');
                $this->User_model->doAllPaymentCalculations($user_id);
            } else {
                $this->session->set_flashdata('error', 'Invalid PIN encountered');
            }
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    public function search()
    {
        $this->data['main']  = 'dashboard/search';
        $this->data['users'] = array();
        if ($this->input->post('search')) {
            $q = $this->input->post('q');
            $this->db->or_like(array('first_name' => $q, 'username' => $q, 'mobile' => $q));
            $this->db->order_by('id', 'DESC');
            $this->db->limit(50);
            $this->data['users'] = $this->db->get('users')->result();
        }
        $this->load->front_view('dashboard/default', $this->data);
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

    function repurchase_package()
    {
        $this->data['main'] = 'dashboard/repurchase-package';
        $this->data['epins'] = $this->db->get_where('package', array('user_id' => user_id()))->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    function repurchase($pcode)
    {
        $this->data['main'] = 'dashboard/repurchase';
        $this->data['code'] = $pcode;
        $this->load->front_view('dashboard/default', $this->data);
    }

    function orders()
    {
        $this->data['main'] = 'dashboard/orders';
        $this->load->front_view('dashboard/default', $this->data);
    }

    function recharge()
    {
        $this->data['main'] = 'dashboard/recharge';
        $this->data['rech_bal'] = $total = $this->User_model->getWalletBalance(user_id());
        $this->data['total_bal'] = $total;
        $this->load->front_view('dashboard/default', $this->data);
    }

    function products()
    {
        $this->data['main'] = 'dashboard/products';
        $this->data['products'] = $this->db->order_by('id', 'DESC')->get('products')->result();
        $this->load->front_view('dashboard/default', $this->data);
    }

    function ajax_money_transfer()
    {
        header('Content-Type: application/json');
        $ob = new stdClass();

        if (config_item('jolo_test_mode')) {
            $baseurl = "http://13.127.227.22/freeunlimited/v3/demo"; //DEMO
        } else {
            $baseurl = "http://13.127.227.22/freeunlimited/v3"; //LIVE
        }

        $apikey = config_item('jolo_apikey'); // JOLOSOFT api key
        $userid = config_item('jolo_userid'); // JOLOSOFT api userid - get from profile page on jolosoft
        $callbackurl = config_item('jolo_callback'); // CALL BACK URL OF your server

        $bal = $this->User_model->getWalletBalance(user_id());
        $amount = $_GET['amount'];

        $user = $this->db->get_where('users', array('id' => user_id()))->row();
        $bankinfo = json_decode($user->bank_info);

        if ($amount <= $bal) {
            // Do transfer

            $headerstring = "$userid|$apikey";
            $hashedheaderstring = hash("sha512", $headerstring);

            $myorderid = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
            $beneficiary_account_no = $bankinfo->ac_number;
            $beneficiary_ifsc = $bankinfo->ifsc;

            $purpose = 'BONUS';
            $remarks = 'Account Transfer';

            $header = array('Content-Type:application/json', 'Authorization:' . $hashedheaderstring);

            //build payload in json
            $paramList = array();
            $paramList["apikey"] = $apikey;
            $paramList["mobileno"] = $user->mobile;
            $paramList["beneficiary_account_no"] = $beneficiary_account_no;
            $paramList["beneficiary_ifsc"] = $beneficiary_ifsc;
            $paramList["amount"] = ceil($amount - 20); // Credit amount by less 2% for admin charge
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

                // Debit from his wallet
                $save = array();
                $save['amount'] = $amount;
                $save['user_id'] = user_id();
                $save['notes'] = "Account";
                $save['cr_dr'] = "dr";
                $save['created'] = date("Y-m-d H:i");
                $this->db->insert('wallet', $save);

                $ob->status = true;
                $ob->message = "Amount Transfer Completed";
            }

            if ($rcstatus == 'FAILED') {
                $ob->status = false;
            }

            if ($rcstatus == 'PENDING') {

                // Debit from his wallet
                $save = array();
                $save['amount'] = $amount;
                $save['user_id'] = user_id();
                $save['notes'] = "Account";
                $save['cr_dr'] = "dr";
                $save['created'] = date("Y-m-d H:i");
                $this->db->insert('wallet', $save);

                $ob->status = true;
                $ob->message = "Amount Transfer is in Pending";
            }
        } else {
            $ob->status = false;
            $ob->message = "Sorry!! You have in-sufficient Account Balance";
        }
        echo json_encode($ob);
    }

    function matrix()
    {

        $id = $this->session->userdata('login');
        $this->data['main'] = 'dashboard/matrix';
        $this->data['title'] = 'MEMBER';
        $this->data['table'] = 'matrix';
        $this->data['user_id'] = user_id();
        $this->data['val'] = $this->db->get_where('users', array('sponsor_id' => user_id()))->result();

        if ($this->input->get('q')) {

            $this->data['user_id'] = userid2id($this->input->get('q'));
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    function member_level()
    {
        $this->data['main'] = 'dashboard/member-level';
        $this->load->front_view('dashboard/default', $this->data);
    }

    function withdraw()
    {
        $min_limit = config_item('min_withdraw_limit');
        $this->data['wallet_bal'] = $this->User_model->getWalletBalance(user_id());
        $this->data['main'] = 'dashboard/withdraw';
        $this->data['reqlist'] = $this->db->order_by('id', 'DESC')->get_where('withdraw', array('user_id' => user_id()))->result();
        if ($this->input->post('btnsubmit')) {
            $amt = $this->input->post('amount');
            if ($amt >= $min_limit) {
                if ($amt <= $this->data['wallet_bal']) {
                    $this->Dashboard_model->create_withdraw_request();
                    $this->session->set_flashdata('success', "Withdrawal Request submitted succesfully");
                } else {
                    $this->session->set_flashdata('error', "Opps!! In-sufficient balance");
                }
            } else {
                $this->session->set_flashdata('error', "Min withdrawal amount must be Rs " . $min_limit);
            }
            redirect('dashboard/withdraw');
        }
        $this->load->front_view('dashboard/default', $this->data);
    }

    function withdraw_history()
    {
        $this->data['main'] = 'dashboard/withdraw-history';
        $this->data['reqlist'] = $this->db->order_by('id', 'DESC')->get_where('withdraw', array('user_id' => user_id()))->result();

        $this->load->front_view('dashboard/default', $this->data);
    }

    function call($m = null)
    {
        $api = new RestApi();
        switch ($m) {
            case 'remove-withdaw':
                $id = $_GET['req_id'];
                $this->Dashboard_model->update_withdraw_request($id, Dashboard_model::WITHDRAW_CANCELLED);
                $this->session->set_flashdata('success', 'Request deleted successfully');
                $api->setOK();
                break;
            case 'withdraw':

                $amt = $_GET['amt'];
                $user_id = user_id();
                $balance = $this->User_model->getWalletBalance(user_id());

                if ($amt <= $balance) {
                    $c = $this->db->get_where('withdraw', array('user_id' => $user_id, 'status' => 1))->num_rows();
                    $is_first = $c == 0 ? true : false;
                    if ($amt < 100) {
                        $api->setError();
                        $api->setMessage("Min Withdrawal more than Rs 99");
                    } else {
                        $childs = $this->db->get_where('users', array('sponsor_id' => $user_id, 'epin != ' => ''))->num_rows();
                        if ($is_first) {
                            if ($amt <= 200) {
                                $api->setOK();
                                $this->Dashboard_model->create_withdraw_request($user_id, $amt);
                                $api->setMessage("Withdrawal request submitted successfully");
                            } else {
                                if ($childs < 2) {
                                    $api->setError();
                                    $api->setMessage("You must have direct two sponser");
                                } else {
                                    $api->setOK();
                                    $this->Dashboard_model->create_withdraw_request($user_id, $amt);
                                    $api->setMessage("Withdrawal request submitted successfully");
                                }
                            }
                        } else {
                            if ($childs < 2) {
                                $api->setError();
                                $api->setMessage("You must have direct two sponser");
                            } else {
                                $api->setOK();
                                $this->Dashboard_model->create_withdraw_request($user_id, $amt);
                                $api->setMessage("Withdrawal request submitted successfully");
                            }
                        }
                    }
                } else {
                    $api->setError();
                    $api->setMessage("You do not have sufficient balance.");
                }
                break;
            default:
        }
        $api->render();
    }
}
