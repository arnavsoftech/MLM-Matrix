<?php

class Members extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->activeTabs = 'members';
    }

    public function index()
    {

        $this->data['main'] = 'members/index';
        if ($this->input->get('from') and $this->input->get('to')) {
            //$this->db->where('date(join_date) >=', $_GET['from']);
            //$this->db->where('date(join_date) <=', $_GET['to']);
        }

        if ($this->input->get('pack_type')) {
            $pc = $_GET['pack_type']; // 1 = Registration, 2 => Top-up
            $date1 = $_GET['from'];
            $date2 = $_GET['to'];
            if ($pc == 1) {
                $this->db->where("join_date BETWEEN '$date1' AND '$date2'");
            } else {
                $this->db->where("ac_active_date BETWEEN '$date1' AND '$date2'");
            }
        }
        if (isset($_GET['filter']) == '?=today') {
            $today = date("Y-m-d");
            $this->db->where('date(join_date)', $today);
        }
        $this->db->order_by('id', 'DESC');
        $user                  = $this->db->get('ai_users')->result();
        $this->data['members'] = $user;
        $this->load->view(admin_view('default'), $this->data);
    }

    function kyc()
    {
        $this->data['main'] = admin_view('members/kyc');
        $this->data['doc'] = $this->db->get('users')->result();
        $this->load->view(admin_view('default'), $this->data);
    }

    function edit_image($id = false)
    {
        $this->data['main'] = admin_view('members/image');
        $config['upload_path']      = upload_dir();
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
        $config['max_size']         = '5000';
        $config['max_width']        = '3000';
        $config['max_height']       = '2000';
        $this->load->library('upload', $config);
        $this->data['title'] = "upload file";

        $this->data['doc'] = $this->db->get_where('users', array('id' => $id))->row();

        $i = $j = $k = $l = false;
        $s['pan_no'] = $this->input->post('pan_no');
        $kyc = $this->db->get_where('users', array('id' => $id))->row();
        $uploaded = $this->upload->do_upload('image');
        if ($uploaded) {
            $image     = $this->upload->data();
            $s['image'] = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', $id);
            $this->db->update('users', $s);
            $i = true;
        }

        $uploaded = $this->upload->do_upload('pan');

        if ($uploaded) {
            $image    = $this->upload->data();
            $s['pan']   = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', $id);
            $this->db->update('users', $s);
        }

        $uploaded = $this->upload->do_upload('aadharf');

        if ($uploaded) {

            $image    = $this->upload->data();
            $s['aadharf']   = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', $id);
            $this->db->update('users', $s);
            $j = true;
        }
        $uploaded = $this->upload->do_upload('aadharb');

        if ($uploaded) {

            $image    = $this->upload->data();
            $s['aadharb']   = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', $id);
            $this->db->update('users', $s);
            $k = true;
        }

        $uploaded = $this->upload->do_upload('account');

        if ($uploaded) {

            $image    = $this->upload->data();
            $s['passbook']   = $image['file_name'];
            $this->session->set_flashdata("success", "Photo uploaded successfully.Please Upload Other remain document.");
            $this->db->where('id', $id);
            $this->db->update('users', $s);
            $l = true;
        }


        if ($this->input->post('btn_reg')) {

            $s['kyc_status'] = $this->input->post('kyc_status');
            $this->db->where('id', $id);
            $this->db->update('users', $s);

            if ($s['kyc_status'] == 0) {
                $this->session->set_flashdata("error", "Kyc Disapproved");
            } else {
                $this->session->set_flashdata("success", "Kyc Approved.");
            }
            redirect(admin_url('members/edit_image/' . $id));
        }

        if ($this->input->post('bankd')) {
            $bank           = $this->input->post("bank");
            $m['bank_info'] = json_encode($bank);
            $m['ac_status'] = 1;
        }


        if ($kyc->image != '' && $kyc->pan != '' && $kyc->aadharf != '' && $kyc->aadharb != '' && $kyc->passbook != '') {
            $s['kyc_status'] = 1;
            $this->db->where('id', $id);
            $this->db->update('users', $s);
            //      $this -> session -> set_flashdata("success", "All documents are uploaded successfully");
            //   //  redirect(site_url('dashboard/kyc'));
            // }else{
            //     $this -> session -> set_flashdata("error", "All documents are not uploaded ");
            // }
        }


        $this->load->view(admin_view('default'), $this->data);
    }

    public function edit($id)
    {
        $this->data['main'] = 'members/edit';
        $this->data['m']    = $this->db->get_where('users', array('id' => $id))->row();

        if ($this->input->post('submit')) {
            $user = $this->input->post('frm');
            $this->db->update('users', $user, array('id' => $id));
            $this->session->set_flashdata('success', 'Details updated Successfully');
            redirect(admin_url('members/edit/' . $id));
        }

        $this->load->view('default', $this->data);
    }

    public function delete($id)
    {
        $this->db->delete('users', array('id' => $id));
        $this->session->set_flashdata('success', 'Account deleted Successfully');
        redirect(admin_url('members'));
    }

    public function details($id)
    {
        $this->data['main']     = 'members/details';
        $this->data['user']     = $this->db->get_where('users', array('id' => $id))->row();
        $this->data['purchase'] = $this->db->order_by('id', 'DESC')->where('user_id', $id)->limit(10)->get('purchase')->result();
        $this->data['members'] = $this->db->get_where("users", array("sponsor_id" => $id))->result();
        $ids = $this->User_model->getDownloadLineIds($id);
        $this->data['downline'] = count($ids);
        $this->data['current_income'] = $this->User_model->getWalletBalance($id);
        $this->data['total_income'] = $this->User_model->totalIncome($id);
        $this->load->view('default', $this->data);
    }

    public function add_purchase($id)
    {
        $this->data['main'] = 'members/purchase';
        $this->data['id']   = $id;
        if ($this->input->post('button')) {
            $save            = $this->input->post('form');
            $save['user_id'] = $id;
            $save['created'] = date('Y-m-d H:i');
            $this->db->insert('purchase', $save);
            $this->session->set_flashdata('success', 'Purchase value added');
            $this->User_model->upgrade($id);
            $this->User_model->creditPurchaseBenefit($id);
            redirect(admin_url('members/details/' . $id));
        }
        $this->load->view('default', $this->data);
    }

    function automagiclist()
    {
        $this->data['main'] = 'members/magic-list';
        $this->db->select("users.username, users.first_name, users.last_name, users.mobile, matrix.*");
        $this->db->from('matrix');
        $this->db->join("users", "users.id = matrix.user_id");
        $this->db->order_by('matrix.id', 'DESC');
        $result = $this->db->get()->result();
        $this->data['users'] = $result;
        $this->load->view('default', $this->data);
    }


    public function add_magic($id)
    {
        $this->data['main'] = 'members/auto-magic';
        $this->data['id']   = $id;
        if ($this->input->post('button')) {
            $save            = $this->input->post('form');
            $sp = $this->User_model->autoMagicSponsor();
            $save['parent_id'] = $sp->parent_id;
            $save['position'] = $sp->position;
            $save['user_id'] = $id;
            $save['created'] = date("Y-m-d H:i");
            $this->db->insert("matrix", $save);

            //Auto magic income credit
            $this->User_model->autoMagicIncome($id);

            $this->session->set_flashdata("success", "Account added for Auto magic income");
            redirect(admin_url('members/details/' . $id));
        }
        $this->data['magicdata'] = $this->User_model->users_magic_list($id);
        $this->load->view('default', $this->data);
    }

    function delivered($id)
    {
        $this->db->update('users', array('kit_issue' => 1, 'kit_issue_date' => date('Y-m-d')), array('id' => $id));
        redirect(admin_url('members'));
    }
}
