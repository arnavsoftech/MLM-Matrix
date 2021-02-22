<?php

class Media extends Admin_Controller {

    var $submenu;

    function __construct() {
        parent::__construct();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size'] = '*';
        $config['remove_spaces'] = TRUE;
        $this -> load -> library('upload', $config);
        $this -> load -> model('Media_model');
        $this -> data['active_tabs'] = 'cms';
    }

    public function index() {
        $this -> template = 'media/index';
        $media = $this -> Media_model -> getAll($this -> getPageLimit(), $this -> getPageOffset(), "media");
        $this -> data['medias'] = $media['results'];
        $this -> initPagination($media['total']);
        $this -> load -> view('default', $this -> data);
    }

    public function add() {
        $this -> template = admin_view('media/add');
        $this -> data['categories'] = $this -> Category_model -> category_dropdown();
        $this -> load -> library('upload');
        $err_str = '';
        if ($this -> input -> post('submit')) {
            $files = $_FILES;
            $count = count($_FILES['filesToUpload']['name']);
            for ($i = 0; $i < $count; $i++) {
                $_FILES['filesToUpload']['name'] = $files['filesToUpload']['name'][$i];
                $_FILES['filesToUpload']['type'] = $files['filesToUpload']['type'][$i];
                $_FILES['filesToUpload']['tmp_name'] = $files['filesToUpload']['tmp_name'][$i];
                $_FILES['filesToUpload']['error'] = $files['filesToUpload']['error'][$i];
                $_FILES['filesToUpload']['size'] = $files['filesToUpload']['size'][$i];

                $config = array();
                $config['upload_path'] = upload_dir();
                $config['allowed_types'] = '*';
                $config['max_size'] = '0';
                $config['overwrite'] = FALSE;

                $this -> upload -> initialize($config);
                if ($this -> upload -> do_upload('filesToUpload') == False) {
                    $err_str .= $this -> upload -> display_errors();
                } else {
                    $save = $this -> upload -> data();
                    $save['img_title'] = $this -> input -> post('title');
                    $save['type_img'] = $this -> input->post('type_img');
                    $save['id'] = false;
                    //var_dump($save); die;
                    $this -> Media_model -> save($save);
                }
            }
            $this -> session -> set_flashdata('success', 'Media file uploaded');
            redirect(admin_url('media/add'));
        } else {
            $this -> load -> view('default', $this -> data);
        }
    }

    public function edit($id = false) {
        $this -> template = 'media/edit';
        $this -> data['media'] = $this -> Media_model -> getRow($id);
        $this -> data['categories'] = $this -> Category_model -> category_dropdown();
        if ($this -> input -> post('submit')) {
            $s = $this -> input -> post('frm');
            $s['id'] = $id;
            if ($this -> Media_model -> save($s)) {
                $this -> session -> set_flashdata('success', 'Media file updated successfully');
            } else {
                $this -> session -> set_flashdata('error', 'Unable to update files');
            }
            redirect(admin_url('media'));
        } else {
            $this -> load -> view(admin_view('default'), $this -> data);
        }
    }

    public function delete($id = false) {
        if ($id > 0) {
            $this -> Media_model -> delete($id);
            $this -> session -> set_flashdata('success', 'Media file deleted successfully');
        }
        redirect(admin_url('media'));
    }

}
