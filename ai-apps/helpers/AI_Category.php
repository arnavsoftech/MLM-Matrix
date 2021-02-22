<?php

class AI_Category {

    var $id;
    var $row;
    var $posts;

    function __construct($id) {
        $this -> id = $id;
        $CI = & get_instance();
        //$this->row = $CI->Category_model->getRowArray($id);
        //$this->posts = $CI->Category_model->getPosts($id);
    }

    function __get($key) {
        if (isset($this -> row[$key])) {
            return $this -> row[$key];
        } else {
            return FALSE;
        }
    }

    function __set($key, $val) {
        $this -> row[$key] = $val;
    }

    function ID() {
        return $this -> id;
    }

    function data($field) {
        if (isset($this -> row[$field])) {
            return $this -> row[$field];
        } else {
            return false;
        }
    }

    function permalink() {
        $link = site_url($this -> data('slug'));

        return $link;
    }

    function title() {
        return $this -> data('name');
    }

    function get_title_hn() {
        return $this -> data('name');
    }

    function hasImage() {
        if ($this -> data('image') <> '') {
            return true;
        } else {
            return false;
        }
    }

    function description() {
        return $this -> data('description');
    }

    function havePosts() {
        if (is_array($this -> posts) && count($this -> posts) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function allPosts() {
        return $this -> posts;
    }

    function image($size = 'sm', $options = array()) {
        $str = '<img src="' . $this -> data('image') . '" alt="' . $this -> title() . '" title = "' . $this -> title() . '" ' . $this -> __arr_to_str($options) . ' />';

        return $str;
    }

    private function __arr_to_str($arr) {
        $str = '';
        foreach ($arr as $key => $value) {
            $str .= $key . '="' . $value . '" ';
        }

        return $str;
    }

    function metaTitle() {
        $seo_title = $this -> data('seo_title');
        if ($seo_title == '') {
            $seo_title = $this -> title();
        }

        return $seo_title;
    }

    function metaDescription() {
        return $this -> data('seo_description');
    }

    function metaKeywords() {
        return $this -> data('seo_keywords');
    }

}
