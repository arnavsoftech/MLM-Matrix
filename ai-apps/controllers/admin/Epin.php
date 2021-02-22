<?php
class Epin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = 'pin';
        $this->load->model('Epin_model');
    }

    function index()
    {
        $this->data['main'] = 'epin/index';
        $this->data['mem_list']     =     $this->db->order_by('id', 'DESC')->get("epin")->result();
        $this->load->view(admin_view('default'), $this->data);
    }
    public function add()
    {

        $this->data['main'] = admin_view('epin/add');
        $this->data['us'] = $this->Epin_model->user();

        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
        if ($this->form_validation->run()) {
            $qty = $this->input->post('quantity');
            for ($i = 1; $i <= $qty; $i++) {
                $x = array(
                    'id' => false,
                    'user_id' => $this->input->post('user_id'),
                    'owner_id' => $this->input->post('user_id'),
                    'pintype' => $this->input->post('pintype'),
                    'status' => 1,
                    'pin_from' => 0,
                    'pin' => $this->Epin_model->newpin()
                );
                $this->Master_model->save($x, 'epin');
            }
            $this->session->set_flashdata("success", "PIN Genrate successfully");
            redirect(admin_url('epin/add/'));
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }


    function request_pin()
    {
        $this->data['main'] = admin_view('epin/request_pin');
        $this->data['request'] = $this->Master_model->listAll('epin_request');
        $this->load->view(admin_view('default'), $this->data);
    }
    function delete($id)
    {
        if ($id) {
            $this->Master_model->delete($id, 'epin');
            $this->session->set_flashdata('success', 'Pin deleted successfully');
        }
        redirect(admin_url('epin'));
    }

    function decline($id = false)
    {

        if ($id) {
            $c['id'] = $id;
            $c['status'] = 2;
            $this->Master_model->save($c, 'epin_request');
            $this->session->set_flashdata("success", "Request declined successfully");
        }
        redirect(admin_url('epin/request_pin'));
    }

    function approved($id = false)
    {

        if ($id) {
            $pin = $this->Master_model->getRow($id, 'epin_request');
            for ($i = 1; $i <= $pin->pin_qty; $i++) {
                $x = array(
                    'id' => false,
                    'user_id' => $pin->user_id,
                    'owner_id' => $pin->user_id,
                    'pintype' => $pin->pintype,
                    'status' => 1,
                    'pin_from' => 0,
                    'pin' => $this->Epin_model->newpin()
                );
                $this->Master_model->save($x, 'epin');
            }
            $this->session->set_flashdata("success", "Pin generated successfully");
            $c['id'] = $id;
            $c['status'] = 1;
            $this->Master_model->save($c, 'epin_request');
        }
        redirect(admin_url('epin/request_pin'));
    }


    function support($id = false)
    {
        $this->data['main'] = admin_view('support/add');
        $this->data['support'] = $this->Master_model->getNew('support');
        if ($id) {
            $this->data['support'] = $this->Master_model->getrow($id, 'support');
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('query', 'Query', 'required');
        if ($this->form_validation->run()) {
            $u = $this->session->userdata('login');
            $x = array();
            $x['id'] = $id;
            $x['name'] = $this->input->post('name');
            $x['query'] = $this->input->post('query');
            $x['answer'] = $this->input->post('answer');
            $x['created'] = date('Y-m-d H:i');
            $this->Master_model->save($x, 'support');
            $this->session->set_flashdata('success', "Answer has been sent successfully");
            redirect(admin_url('epin/support/' . $id));
        }
        $this->load->view(admin_view('default'), $this->data);
    }


    function support_list()
    {
        $this->data['main'] = admin_view('support/list');
        $this->data['list'] = $this->Master_model->listAll('support');
        $this->load->view(admin_view('default'), $this->data);
    }



    function delete_support($id)
    {
        if ($id) {
            $this->Master_model->delete($id, 'support');
            $this->session->set_flashdata('success', 'Query deleted successfully');
        }
        redirect(admin_url('epin/support_list'));
    }


    function update_request($id = false)
    {

        $this->data['main'] = admin_view('members/update_request');
        $r = $this->db->get_where('users', array('req_profile_status' => 1));
        $this->data['update_req'] = $r->result();
        if ($id) {
            $x = array();
            $x['id'] = $id;
            $x['req_profile_status'] = 2;
            $this->Master_model->save($x, 'users');
            $this->session->set_flashdata('success', 'Update has been sent successfully');
            redirect(admin_url('epin/update_request/'));
        }
        $this->load->view(admin_view('default'), $this->data);
    }


    function update_request_kyc($id = false)
    {

        $this->data['main'] = admin_view('members/kyc_request');
        $r = $this->db->get_where('users', array('req_kyc_update' => 1));
        $this->data['update_kyc'] = $r->result();
        if ($id) {
            $x = array();
            $x['id'] = $id;
            $x['req_kyc_update'] = 2;
            $this->Master_model->save($x, 'users');
            $this->session->set_flashdata('success', 'Update has been sent successfully');
            redirect(admin_url('epin/update_request_kyc/'));
        }
        $this->load->view(admin_view('default'), $this->data);
    }

    function franchise_deactivate($id = false)
    {
        if ($id) {
            $c['id'] = $id;
            $c['franchise'] = 0;
            $this->Master_model->save($c, 'users');
            $this->session->set_flashdata("success", "Franchise account deactivated");
        }
    }

    function transfer_pin($user_id = false)
    {

        if ($user_id) {
            $this->data['main'] = admin_view('Epin/transfer_by');
            $this->data['user_id'] = $user_id;
            $this->data['mem_list']          =    $this->db->order_by('act_date', 'desc')->select('*')->get_where('epin')->result();
        } else {
            $this->data['main'] = admin_view('Epin/transfer');
            $this->data['mem_list1']          =    $this->db->order_by('act_date', 'desc')->select('*')->get_where('epin')->result();
            $this->data['mem_list']          =    $this->db->select('*')->get_where('epin', array('transfer!=' => ''))->result();
        }


        $this->load->view(admin_view('default'), $this->data);
    }

    function package()
    {
        $this->data['main'] = admin_view('epin/package');
        $this->data['us'] = $this->db->order_by('first_name', 'ASC')->get_where('users', array('franchise' => 1))->result();
        if ($this->input->post('submit')) {
            $user_id = $this->input->post('user_id');
            $qty = $this->input->post('quantity');
            for ($i = 1; $i <= $qty; $i++) {
                $data = array();
                $data['pcode'] = $this->Epin_model->generatePackageCode();
                $data['pvalue'] = 2500;
                $data['user_id'] = $user_id;
                $data['status'] = 1;
                $data['created'] = date("Y-m-d H:i");
                $data['usedat'] = null;

                $this->db->insert("package", $data);
            }

            $this->session->set_flashdata('success', 'Package Created');
            redirect(admin_url('epin/package'));
        }

        $this->data['ar_packages'] = $this->db->get('package')->result();
        $this->load->view(admin_view('default'), $this->data);
    }
}
