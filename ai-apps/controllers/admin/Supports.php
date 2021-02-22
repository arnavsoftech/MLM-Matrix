<?php
class Supports extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = "supports";
    }

    function index()
    {
        $this->template = "supports/index";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $this->per_page;
        $result = $this->Master_model->getAll($this->per_page, $offset, "supports");

        $this->data['datalist'] = $result['results'];
        $this->initPagination($result['total']);
        $this->load->view("default", $this->data);
    }

    function reply($id)
    {
        $this->template = "supports/send-reply";
        $this->data['m'] = $this->Master_model->getRow($id, "feedback");
        $this->load->view("default", $this->data);
    }

    function feedback()
    {
        $this->template = "supports/feedback";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $this->per_page;
        if (isset($_GET['status'])) {
            $rule = array();
            $rule['status'] = $_GET['status'];
            $result = $this->Master_model->getWhereRecords($this->per_page, $offset, $rule, "feedback");
        } elseif (isset($_GET['q'])) {
            $q = $_GET['q'];
            $rules = array(
                'users.id' => $q,
                'users.email_id' => $q,
                'users.first_name' => $q
            );
            $result = $this->Master_model->getAllSearched($this->per_page, $offset, $rules, "feedback");
        } else {
            $result = $this->Master_model->getAll($this->per_page, $offset, "feedback");
        }
        $this->data['sl'] = $offset + 1;
        $this->data['datalist'] = $result['results'];
        $this->initPagination($result['total']);
        $this->load->view("default", $this->data);
    }

    function views($id)
    {
        $this->template = "supports/view";
        $this->data['ticket'] = $t = $this->Master_model->getRow($id, "supports");
        if ($this->input->post("description")) {
            $s = array();
            $s['support_id'] = $id;
            $s['from_id'] = 0;
            $s['to_id'] = $t->user_id;
            $s['description'] = $this->input->post("description");
            $s['created'] = date("Y-m-d H:i");

            $this->Master_model->save($s, "supports_view");
            $this->session->set_flashdata("success", "Reply updated");
            redirect(admin_url("supports/views/" . $id));
        }
        $this->data['views'] = $this->db->order_by('id', 'DESC')->get_where("supports_view", array('support_id' => $id))->result();
        $this->load->view("default", $this->data);
    }

    function json()
    {
        $this->db->order_by("id", "DESC");
        $rest = $this->db->get("feedback")->result();
        header('Content-Type: application/json');
        $ob = new stdClass();
        $newarr = array();
        if (is_array($rest) && count($rest) > 0) {
            $sl = 1;
            foreach ($rest as $r) {
                $a = array($sl++, $r->name, $r->email, $r->subject, $r->description);
                $newarr[] = $a;
            }
        }
        $ob->data = $newarr;
        echo json_encode($ob, JSON_PRETTY_PRINT);
    }

}
