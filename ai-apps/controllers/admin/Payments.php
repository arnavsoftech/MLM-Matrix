<?php
class Payments extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = 'pin';
        $this->load->model('Epin_model');
    }

    function index()
    {
        $this->data['main'] = 'payments/fund-request';
        if (isset($_GET['type'])) {
            $this->db->where('date(created) = CURDATE()');
        }
        $this->data['request'] = $this->Master_model->listAll('fund_request');
        $this->load->view(admin_view('default'), $this->data);
    }

    function fund_transfer()
    {
        $this->data['main'] = "payments/fund-transfer";
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('user_id', 'User', 'required', array('required' => 'Please select user'));
        if ($this->form_validation->run()) {
            $save = array();
            $save['user_id'] = $_POST['user_id'];
            $save['amount']  = $_POST['amount'];
            $save['txn_no']  = time();
            $save['notes']   = "Admin Transfer";
            $save['screenshot'] = "";
            $save['created'] = date("Y-m-d H:i");
            $save['status'] = 1;
            $this->db->insert("fund_request", $save);

            // Saving to Transaction table
            $sp = array();
            $sp['user_id'] = $_POST['user_id'];
            $sp['amount']  = $_POST['amount'];
            $sp['notes']   = Dashboard_model::INCOME_FUND_TRANSER;
            $sp['cr_dr']   = 'cr';
            $sp['created'] = date('Y-m-d H:i');
            $this->db->insert('wallet', $sp);

            $this->session->set_flashdata("success", "Fund transfer completed");
            redirect(admin_url('payments/fund-transfer'));
        } else {
            $this->data['users'] = $this->db->order_by("first_name", "ASC")->get("users")->result();
            $this->load->view("default", $this->data);
        }
    }

    function debit_credit()
    {
        $this->data['main'] = "payments/payment-debit";
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('user_id', 'User', 'required', array('required' => 'Please select user'));
        if ($this->form_validation->run()) {
            // Saving to Transaction table
            $sp = array();
            $sp['user_id'] = $_POST['user_id'];
            $sp['amount']  = $_POST['amount'];
            $sp['notes']   = $_POST['notes'];
            $sp['cr_dr']   = $_POST['cr_dr'];
            $sp['created'] = date('Y-m-d H:i');

            $this->db->insert('transaction', $sp);

            $this->session->set_flashdata("success", "Amount Debit completed");
            redirect(admin_url('payments/debit_credit'));
        } else {
            $this->data['users'] = $this->db->order_by("first_name", "ASC")->get("users")->result();
            $this->load->view("default", $this->data);
        }
    }

    function delete($id)
    {
        if ($id) {
            $this->Master_model->delete($id, 'epin');
            $this->session->set_flashdata('success', 'Pin deleted successfully');
            redirect(admin_url('epin'));
        }
    }

    function decline($id = false)
    {

        if ($id) {
            $c['id'] = $id;
            $c['status'] = 2;
            $this->Master_model->save($c, 'fund_request');
            $this->session->set_flashdata("success", "Request declined successfully");
        }
        redirect(admin_url('payments'));
    }

    function approved($id = false)
    {

        if ($id) {
            $pin = $this->Master_model->getRow($id, 'fund_request');
            //Credit to beneficiary
            $sp = array();
            $sp['user_id'] = $pin->user_id;
            $sp['amount']  = $pin->amount;
            $sp['notes']   = Dashboard_model::INCOME_FUND_TRANSER;
            $sp['cr_dr']   = 'cr';
            $sp['created'] = date('Y-m-d H:i');
            $this->db->insert('transaction', $sp);

            $this->session->set_flashdata("success", "Pin generated successfully");
            $c['id'] = $id;
            $c['status'] = 1;
            $this->Master_model->save($c, 'fund_request');
        }
        redirect(admin_url('epin/request_pin'));
    }
}
