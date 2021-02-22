<?php

class Categories extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = "cms";
        $this->load->model(array('Category_model'));
    }

    function index($page = 1)
    {
        $this->data['dashboard_title'] = "Manage Category";
        $show_per_page = 40;
        $offset = ($page - 1) * $show_per_page;
        $this->data['main'] = 'category/index';
        $this->activeTabs = "category";
        $data = $this->Category_model->getAll($show_per_page, $offset);
        $this->data['categories'] = $data['results'];
        $this->initPagination($data['total']);
        $this->load->view('default', $this->data);
    }

    function add($id = false)
    {

        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
        $config['max_size'] = '5000';
        $config['max_width'] = '3000';
        $config['max_height'] = '2000';
        $this->load->library('upload', $config);
        $this->data['main'] = 'category/add';
        $this->data['categories'] = $this->Category_model->category_dropdown();
        $this->data['cat'] = $this->Category_model->getNew();
        if ($id) {
            $this->data['cat'] = $this->Category_model->getRow($id);
        }
        $this->form_validation->set_rules('cat[name]', 'Name in hindi', 'trim|required|max_length[64]');
        $this->form_validation->set_rules('cat[slug]', 'Slug', 'trim');
        $this->form_validation->set_rules('cat[description]', 'Description', 'trim');
        $this->form_validation->set_rules('cat[sequence]', 'Sequence', 'trim|integer');
        $this->form_validation->set_rules('cat[parent_id]', 'Parent id', 'trim');
        if ($this->form_validation->run()) {
            $catdata = $this->input->post('cat');
            $catdata['id'] = $id;
            $catdata['sequence'] = intval($catdata['sequence']);
            $uploaded = $this->upload->do_upload('image');
            if ($id) {
                if ($this->input->post('del_image')) {
                    $img_name = $this->input->post('hid_image');
                    @unlink(upload_dir($img_name));
                    $catdata['image'] = '';
                }
            }
            if ($uploaded) {
                $image = $this->upload->data();
                $catdata['image'] = $image['file_name'];
            }
            $slug = $catdata['slug'];
            if (empty($slug) || $slug == '') {
                $slug = $this->input->post('cat[name]');
            }
            $slug = strtolower(url_title($slug));
            $catdata['popular_cat'] = isset($catdata['popular_cat']) ? 1 : 0;
            $catdata['slug'] = $this->Category_model->get_unique_url($slug, $id);

            $id = $this->Category_model->save($catdata);

            $this->session->set_flashdata('success', 'Category saved successfully.');
            redirect(admin_url('categories/add/' . $id));
        } else {
            $this->load->view('default', $this->data);
        }
    }

    function activate($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('categories');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 1;
            $this->Category_model->save($c);
            $this->session->set_flashdata("success", "Category saved");
        }
        redirect($redirect);
    }

    function deactivate($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('categories');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 0;
            $this->Category_model->save($c);
            $this->session->set_flashdata("success", "Category saved");
        }
        redirect($redirect);
    }

    public function delete($id)
    {
        if ($id > 0) {
            if ($this->Category_model->hasChildren($id)) {
                $this->session->set_flashdata("error", "Subcategory exists, Please delete them first");
                redirect(admin_url('categories'));
                exit();
            }
            $data = $this->Category_model->getRow($id);
            if ($data->image != '') {
                $file = array();
                $file[] = upload_dir($data->image);
                foreach ($file as $f) {
                    if (file_exists($f)) {
                        @unlink($f);
                    }
                }
            }
            $this->Category_model->delete($id);
            $this->session->set_flashdata('success', 'Category deleted successfully');
        }
        redirect(admin_url('categories'));
    }

    function modules()
    {
        $this->template = "category/modules";
        if (isset($_GET['cid']) && $_GET['cid'] > 0) {
            $rules = array(
                'course_id' => $_GET['cid']
            );
            $result = $this->Master_model->getWhereRecords($this->getPageLimit(), $this->getPageOffset(), $rules, "modules");
        } else {
            $result = $this->Master_model->getAll($this->getPageLimit(), $this->getPageOffset(), "modules");
        }

        $this->data['modules'] = $result['results'];
        $this->initPagination($result['total']);
        $this->load->view("default", $this->data);
    }

    function add_module($id = false)
    {
        /* $sql = "
          create table if not exists ai_modules(
          id int not null auto_increment primary key,
          title varchar(255),
          course_id int(10),
          slug varchar(255),
          sequence int(3),
          description text,
          status tinyint(1),
          created datetime
          )";
          $this -> db -> query($sql); */

        if ($id) {
            $this->data['m'] = $this->Master_model->getRow($id, "modules");
        } else {
            $this->data['m'] = $this->Master_model->getNew("modules");
        }

        $this->data['courses'] = $this->Category_model->category_dropdown();
        $this->template = "category/add-module";

        $this->form_validation->set_rules("form[title]", "Title", "required");
        if ($this->form_validation->run()) {
            $s = $this->input->post("form");
            $s['id'] = $id;

            $slug = $s['slug'];
            if ($s['slug'] == "") {
                $slug = $s['title'];
            }
            $slug = strtolower(url_title($slug));
            $slug = $this->Master_model->get_unique_url($slug, $id);
            $s['slug'] = $slug;
            $id = $this->Master_model->save($s, "modules");
            $this->session->set_flashdata("success", "Module saved successfully");
            redirect(admin_url("categories/add-module/" . $id));
        } else {
            $this->load->view("default", $this->data);
        }
    }

    function delete_module($id = false)
    {
        if ($id) {
            $this->Master_model->delete($id, "modules");
            $this->session->set_flashdata("success", "Modules removed Successfully");
        }
        redirect(admin_url("categories/modules"));
    }

    function qset()
    {
        $this->template = "categories/qset";
        $this->load->view("default", $this->data);
    }
}
