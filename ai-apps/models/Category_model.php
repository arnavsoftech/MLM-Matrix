<?php



class Category_model extends Master_model

{



    function __construct()

    {

        $this->table = 'categories';

    }



    function get_categories_tierd($parent = 0)

    {

        $categories = array();

        $result = $this->categories($parent);

        foreach ($result as $category) {

            $categories[$category->id]['category'] = $category;

            $categories[$category->id]['children'] = $this->get_categories_tierd($category->id);

        }

        return $categories;

    }



    function categories($parent = 0)

    {

        return $this->db->get_where($this->table, array('parent_id' => $parent))->result();

    }



    function hasChildren($parent_id)

    {

        $c = $this->db->get_where($this->table, array('parent_id' => $parent_id))->num_rows();

        if ($c > 0) {

            return true;

        } else {

            return false;

        }

    }



    function category_dropdown()

    {

        $data = array(

            0 => 'Select'

        );

        $this->db->select('id,name');

        $this->db->order_by('name', "ASC");

       $this->db->where('parent_id', 0);

        $rest = $this->db->get_where('categories', array('status' => 1));

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $r) {

                $tname = ucwords(strtolower($r->name));

                $data[$r->id] = $tname;

                //$data = $this->sub_child($r->id, $tname, $data);

            }

        }

        return $data;

    }


    function video_dropdown()

    {

        $data = array(

            0 => 'Select'

        );

        $this->db->select('id,name');

        $this->db->order_by('name', "ASC");

       $this->db->where('parent_id', 2);

        $rest = $this->db->get_where('categories', array('status' => 1));

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $r) {

                $tname = ucwords(strtolower($r->name));

                $data[$r->id] = $tname;

                //$data = $this->sub_child($r->id, $tname, $data);

            }

        }

        return $data;

    }

    function cat_list($limit = 40, $offset = 0, $table = false) {

        if ($table) {

            $this -> table = $table;

        }
        $this -> db -> where('parent_id', 0);
        $this -> db -> order_by('id', 'DESC');

        $this -> db -> limit($limit, $offset);

        $rest = $this -> db -> get($this -> table);

        $data['results'] = $rest -> result();
       // echo $this->db->last_query();
        $data['total'] = $this -> db -> get($this -> table) -> num_rows();

        return $data;

    }

    function blog_list($limit = 40, $offset = 0, $table = false) {

        if ($table) {

            $this -> table = $table;

        }
        $this -> db -> where('parent_id', 1);
        $this -> db -> order_by('id', 'DESC');

        $this -> db -> limit($limit, $offset);

        $rest = $this -> db -> get($this -> table);

        $data['results'] = $rest -> result();
       // echo $this->db->last_query();
        $data['total'] = $this -> db -> get($this -> table) -> num_rows();

        return $data;

    }


    function video_list($limit = 40, $offset = 0, $table = false) {

        if ($table) {

            $this -> table = $table;

        }
        $this -> db -> where('parent_id', 2);
        $this -> db -> order_by('id', 'DESC');

        $this -> db -> limit($limit, $offset);

        $rest = $this -> db -> get($this -> table);

        $data['results'] = $rest -> result();
       // echo $this->db->last_query();
        $data['total'] = $this -> db -> get($this -> table) -> num_rows();

        return $data;

    }


    function category_blog()

    {

        $data = array(

            0 => 'Select'

        );

        $this->db->select('id,name');

        $this->db->order_by('name', "ASC");

       $this->db->where('parent_id', 1);

        $rest = $this->db->get_where('categories', array('status' => 1));

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $r) {

                $tname = ucwords(strtolower($r->name));

                $data[$r->id] = $tname;

               // $data = $this->sub_child($r->id, $tname, $data);

            }

        }

        return $data;

    }

    function sub_child($parent_id, $name, $old_arr = array())

    {

        $this->db->select('id, name');

        $this->db->where('parent_id', $parent_id);

        $this->db->order_by('name', 'ASC');

        $rest = $this->db->get('categories');

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $r) {

                $fname = $name . ' &#x021D2; ' . ucwords(strtolower($r->name));

                $old_arr[$r->id] = $fname;

                $old_arr = $this->sub_child($r->id, $fname, $old_arr);

            }

        }

        return $old_arr;

    }



    function get_category_links()

    {

        $data = array();

        $rest = $this->db->get($this->table);

        if ($rest->num_rows() > 0) {

            foreach ($rest->result() as $row) {

                $data[$row->id] = $row->name;

            }

        }

        $rest->free_result();

        return $data;

    }



    function popularCategories()

    {

        $this->db->select("*");

       // $this->db->order_by("sequence", 'ASC');

        $this->db->order_by("id", "DESC");

        $this->db->where("parent_id", 0);

        return $this->db->get_where("categories", array('status' => 1))->result();

    }

    function BlogCategories()

    {

        $this->db->select("*");

       // $this->db->order_by("sequence", 'ASC');

        $this->db->order_by("id", "DESC");

        $this->db->where("parent_id", 1);

        return $this->db->get_where("categories", array('status' => 1))->result();

    }

    function videoCategories()

    {

        $this->db->select("*");

       // $this->db->order_by("sequence", 'ASC');

        $this->db->order_by("id", "DESC");

        $this->db->where("parent_id", 2);

        return $this->db->get_where("categories", array('status' => 1))->result();

    }



    function getCatId($slug)

    {

        $r = $this->db->get_where("categories", array("slug" => $slug))->row();

        if (is_object($r)) {

            return $r->id;

        } else {

            return 0;

        }

    }





    function name($id)

    {

        $s = $this->getRow($id);

        if (is_object($s)) {

            return $s->name;

        } else {

            return null;

        }

    }



}

