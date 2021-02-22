<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends AI
{

    var $data, $per_page;
    var $active_tab, $template;
    var $page_links;
    var $dashboard_title;

    function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        if (!$this->session->userdata('userid')) {
            redirect(admin_url('users/login'), 'refresh');
        }

        $this->load->model("Admin_model");
        $this->active_tab = "dashboard";
        $this->per_page = 40;
        $this->dashboard_title = "Dashboard";
        $this->data['title'] = '';
        $this->data['description'] = ' ';
    }

    function getPageLimit()
    {
        return $this->per_page;
    }

    function getPageOffset()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $this->per_page;
        $this->data['page_serial'] = $offset;
        return $offset;
    }

    function initPagination($total)
    {
        $config['base_url'] = current_url();
        $config['num_links'] = 2;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total;
        $config['per_page'] = $this->per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a  class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = "page";
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
    }

    function view($page, $data = array())
    {
        $this->template = $page;
        $data = array_merge($this->data, $data);
        $this->load->view("default", $data);
    }
}



class AI_Controller extends AI
{

    var $data, $isLogin;
    var $user = false;
    var $per_page;
    var $pageTitle;

    function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->data['seo_title'] = theme_option('title');
        $this->data['seo_description'] = '';
        $this->data['seo_keywords'] = '';
        $this->data['og_image'] = base_url('assets/img/logo.png');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->isLogin = false;
        $this->per_page = 30;
        $this->pageTitle = "Dashboard";
    }

    function getUser()
    {
        $login = $this->session->userdata("login");
        return $login;
    }



    function getPageLimit()
    {
        return $this->per_page;
    }


    function getPageOffset()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $this->per_page;
        return $offset;
    }

    function initPagination($total)
    {
        $config['base_url'] = current_url();
        $config['num_links'] = 2;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total;
        $config['per_page'] = $this->per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = "page";
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
    }

    function view($page, $data = array())
    {
        $this->data['main'] = $page;
        $data = array_merge($this->data, $data);
        $this->load->front_view("default", $data);
    }
}



class AI extends CI_Controller
{

    function resize($source_file = FALSE, $dir = false)
    {
        $this->load->library('image_lib');
        $file = basename($source_file);
        $filearr = explode('.', $file);
        $file_p = $filearr[0];
        $file_a = $filearr[1];
        $sizes = config_item("img_sizes");
        if (is_array($sizes) && count($sizes) > 0) {
            foreach ($sizes as $key => $size_ar) {
                $width = $size_ar[0];
                $height = $size_ar[1];
                $filename = $file_p . '-' . $key . '.' . $file_a;
                $config = array();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $source_file;
                $config['upload_path'] = upload_dir();
                $config['new_image'] = $filename;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = $width;
                $config['height'] = $height;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }
        }
    }

    function img_files($source_file)
    {
        $data = array();
        $file = basename($source_file);
        $filearr = explode('.', $file);
        $file_p = $filearr[0];
        $file_a = $filearr[1];
        $sizes = config_item("img_sizes");
        if (is_array($sizes) && count($sizes) > 0) {
            foreach ($sizes as $key => $size_ar) {
                $filename = $file_p . '-' . $key . '.' . $file_a;
                $data[] = $filename;
            }
        }
        return $data;
    }



    function delImages($source_file, $dir = false)
    {
        $imgarr = $this->img_files($source_file);
        if (is_array($imgarr) && count($imgarr) > 0) {
            foreach ($imgarr as $fname) {
                @unlink(upload_dir($fname));
            }
        }
    }
}
