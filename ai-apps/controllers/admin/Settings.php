<?php

class Settings extends Admin_Controller
{

    var $global;

    function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = 'settings';
    }

    public function index()
    {
        $this->data['main'] = 'setting/theme-options';
        $this->data['options'] = $this->Setting_model->all_options();
        if ($this->input->post('submit')) {
            $fields = $this->input->post('fields');
            $arr_fields = explode(',', $fields);
            if (is_array($arr_fields) and count($arr_fields) > 0) {
                foreach ($arr_fields as $fname) {
                    $fname = trim($fname);
                    $s['option_name'] = $fname;
                    $s['option_value'] = $this->input->post($fname);
                    $this->Setting_model->save_option($s);
                }
                $this->session->set_flashdata('success', 'Settings updated successfully');
            }
            redirect(admin_url('settings'));
        } else {
            $this->load->view('default', $this->data);
        }
    }

    function restore()
    {
        $this->db->truncate('options');
        $this->session->set_flashdata('success', 'Global Setting reset to Default');
        redirect(admin_url('settings'));
    }

    function reset_db()
    {
        // Code to reset the database
        $this->db->truncate("epin");
        $this->db->truncate("epin_request");
        $this->db->truncate("transaction");
        $this->db->truncate("rewards");
        $this->db->truncate("news");
        $this->db->truncate("news_event");
        $this->db->delete("level_manager", array('id >' => 1));
        $this->db->delete("users", array('id >' => 1));
    }

    function sql()
    {
        $this->data['main'] = 'setting/sql';
        if ($this->input->post('sql')) {
            $sql = $this->input->post('sql');
            $this->db->query($sql);
            $this->session->set_flashdata("success", "SQL Executed");
            redirect(admin_url('settings/sql'));
        }
        $this->load->view('default', $this->data);
    }
}
