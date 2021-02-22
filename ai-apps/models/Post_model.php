<?php

class Post_model extends Master_model
{
    var $error, $status;
    public function __construct()
    {
        parent::__construct();
        $this->table = 'posts';
    }

    public function post($id)
    {
        $p = $this->db->get_where('post', array('id' => $id))->first_row('array');
        $p['category'] = $this->Category_model->category($p['parent_id']);
        return $p;
    }

    public function page($id)
    {
        $p = $this->db->get_where('posts', array('id' => $id))->first_row('array');
        return $p;
    }

    function get_all($offset = 0, $show_per_page = 10)
    {
        $this->db->select('id');
        if ($show_per_page) {
            $this->db->limit($show_per_page, $offset);
        }

        $this->db->where('post_type', 'post');
        $this->db->order_by('id', 'DESC');
        $rest = $this->db->get('post');
        $p = array();
        if ($rest->num_rows() > 0) {
            foreach ($rest->result_array() as $row) {
                $p[] = $this->post($row['id']);
            }
        }

        $data['data'] = $p;
        $data['total'] = $this->db->get_where('post', array('post_type' => 'post'))->num_rows();
        return $data;
    }

    function pages($offset = 0, $show_per_page = 10, $id)
    {
        $p = array();
        $this->db->select('id');
        if ($show_per_page) {
            $this->db->limit($show_per_page, $offset);
        }

        $this->db->where('post_type', 'page');
        $this->db->where('status', 1);
        $this->db->where('parent_id', $id);
        $this->db->order_by('post_title', 'ASC');
        $rest = $this->db->get('posts');
        if ($rest->num_rows() > 0) {
            foreach ($rest->result_array() as $row) {
                $p[] = $this->page($row['id']);
            }
        }

        $rest->free_result();
        $data['data'] = $p;
        $data['total'] = $this->db->get_where('ai_posts', array('post_type' => 'page', 'status' => 1))->num_rows();
        return $data;
    }

    function get_category_posts($parent_id, $limit = 0, $offset = 10)
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('post');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($offset, $limit);
        $this->db->where('post_category.category_id', $parent_id);
        $this->db->where('post_type', 'post');
        $this->db->join('post_category', 'post_category.post_id = post.id');
        $rest = $this->db->get();
        if ($rest->num_rows() > 0) {
            foreach ($rest->result_array() as $row) {
                $data[] = $row;
            }
        }
        $rest->free_result();
        return $data;
    }



    public function get_page_dd()
    {

        $data = array(0 => 'Main Page');
        $this->db->order_by('post_title', 'ASC');
        $this->db->where("post_type", "page");
        $rest = $this->db->get('posts');
        if ($rest->num_rows() > 0) {
            foreach ($rest->result_array() as $row) {
                $data[$row['id']] = $row['post_title'];
            }
        }

        $rest->free_result();
        return $data;
    }



    public function get_post_dd()
    {
        $data = array(0 => 'Main Page');
        $this->db->order_by('ptitle', 'ASC');
        $rest = $this->db->get('products');
        if ($rest->num_rows() > 0) {
            foreach ($rest->result_array() as $row) {
                $data[$row['id']] = $row['ptitle'];
            }
        }
        $rest->free_result();
        return $data;
    }

    function get_post_categories($post_id)
    {
        $data = array();
        $result = $this->db->get_where('post_category', array('post_id' => $post_id));
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $obj) {
                $data[] = $obj['category_id'];
            }
        }
        $result->free_result();
        return $data;
    }

    function remove_post_category($post_id)
    {
        $this->db->where('post_id', $post_id);
        $this->db->delete('post_category');
    }
}
