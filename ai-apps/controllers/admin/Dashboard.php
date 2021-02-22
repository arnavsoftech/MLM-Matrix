<?php

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = "dashboard";
        $this->load->model("Admin_model");
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $this->load->library('upload', $config);
    }

    public function index()
    {
        $this->data['main'] = "dashboard";
        $this->data['users'] = $this->db->get_where('users', array('join_date' => 'CURDATE()'))->num_rows();
        $this->data['total'] = $this->db->select('count(*) as c')->get('users')->row()->c;
        $this->data['franchise'] = $this->db->select('count(*) as c')->get_where('users', array('franchise' => 1))->row()->c;
        $this->data['pin'] = $this->db->select('count(*) as c')->get_where('epin_request', array('status' => 0))->row()->c;
        $this->load->view("default", $this->data);
    }


    public function profile()
    {
        $this->data['main'] = 'admin/edit';
        $id = $this->session->userdata('userid');
        $this->data['admin'] = $this->Admin_model->getRow($id);
        $valid = array(array('field' => 'password', 'label' => 'Password', 'rules' => 'required'), array('field' => 'password2', 'label' => 'Retype password', 'rules' => 'required|matches[password]'));
        $this->form_validation->set_rules($valid);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('default', $this->data);
        } else {
        }
    }

    public function changepass()
    {
        $this->data['active_tabs'] = "settings";
        $this->activeTabs = 'Change Pasasword';
        $this->data['main'] = "users/changepwd";
        $id = $_SESSION['userid'];
        $this->data['users'] = $this->db->get_where('admin', array('id' => $id))->first_row();
        $admin = $this->data['users'];
        $this->form_validation->set_rules("old_pass", "old password", "required");
        $this->form_validation->set_rules("new_pass", "New password", "required");
        $this->form_validation->set_rules("cnf_pass", "Re Type password", "required|matches[new_pass]", array(
            'matches' => "Your New and Re-Type Password is Not Correct...!"
        ));
        if ($this->form_validation->run()) {
            $userid = $_SESSION['userid'];
            $admin = $this->Admin_model->getRow($userid);
            $old_pass = $this->input->post("old_pass");
            $new_pass = $this->input->post("new_pass");
            if ($admin->password == md5($old_pass)) {
                $s = array();
                $s['id'] = $admin->id;
                $s['password'] = md5($new_pass);
                $this->Admin_model->save($s);
                $this->session->set_flashdata('success', 'Your Password Changed Successfully');
            } else {
                $this->session->set_flashdata('error', 'Your New and Re-Type Password is Not Correct...!');
            }
            redirect(admin_url("dashboard/changepass"));
        } else {
            $this->load->view("default", $this->data);
        }
    }


    function announcement($id = false)
    {
        //echo "ghgyj";
        $this->activeTabs = 'Announcement';
        $this->data['main'] = "users/announcement";
        $this->data['p'] = $this->Master_model->getNew('announcement');
        if ($id) {
            $this->data['p'] = $post = $this->Master_model->getRow($id, 'announcement');
        }
        $this->form_validation->set_rules('form[title]', 'Title', 'required');
        if ($this->form_validation->run()) {
            $save = $this->input->post('form');
            if ($this->input->post('del_img')) {
                $del_img = $this->input->post('hid_img');
                @unlink(upload_dir($del_img));
                $save['image'] = '';
            }
            $uploaded = $this->upload->do_upload('image');
            if ($uploaded) {
                $image = $this->upload->data();
                $save['image'] = $image['file_name'];
                $this->resize($image['full_path']);
            } else {
                $error = $this->upload->display_errors();
                if ($error <> '<p>You did not select a file to upload.</p>') {
                    $this->session->set_flashdata("error", $error);
                }
            }

            $save['id'] = $id;
            $id = $this->Master_model->save($save, 'announcement');
            $this->session->set_flashdata('success', 'Page saved successfully');
            redirect(admin_url('dashboard/announcement/' . $id));
        } else {
            $this->load->view("default", $this->data);
        }
    }

    function announce()
    {

        $this->data['main'] = "users/announce";
        $data = $this->Master_model->listAll("announcement");
        $this->data['post_list'] = $data;
        $this->load->view("default", $this->data);
    }
    function delete($id)
    {
        if ($id) {
            $this->db->delete('announcement', array('id' => $id));
            $this->session->set_flashdata('sucsess', 'Data deleted successfully');
        }
        redirect(admin_url('dashboard/announce'));
    }

    function deactive($id = false)
    {
        if ($id) {
            $this->db->update("users", array('status' => 0), array('id' => $id));
            $this->session->set_flashdata('success', 'Login deactive successfully');
        }
        redirect(admin_url('dashboard'));
    }
}
