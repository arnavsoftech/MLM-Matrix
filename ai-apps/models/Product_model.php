<?php
class Product_model extends Master_model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
    }

    function isExists($p_id)
    {
        $c = $this->db->get_where($this->table, array('id' => $p_id))->num_rows();
        if ($c == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function delete_p_cat($id)
    {
        $this->db->delete('products_categories', array('pid' => $id));
    }

    function resetCategory($pid, $cats = array())
    {
        $this->db->delete('products_categories', array('pid' => $pid));
        foreach ($cats as $cid) {
            $p = array(
                'pid' => $pid,
                'cid' => $cid
            );
            $this->db->insert('products_categories', $p);
        }
    }

    function getProduct($id)
    {
        $p = $this->getRow($id);
        $cats_arr = $this->db->get_where('products_categories', array('pid' => $id))->result();
        if (is_array($cats_arr) && count($cats_arr) > 0) {
            $temp = array();
            foreach ($cats_arr as $c) {
                $temp[] = $c->cid;
            }
        } else {
            $temp = array();
        }
        $p->cats = $temp;
        if ($p->sizes <> '') {
            $p->sizes = json_decode($p->sizes);
        } else {
            $p->sizes = array();
        }
        if ($p->params <> '') {
            $p->params = json_decode($p->params);
        } else {
            $p->params = array();
        }
        return $p;
    }

    function getNew($table = false)
    {
        $p = parent::getNew();
        $p->cats = array();
        $p->sizes = array();
        return $p;
    }

    function check_duplicate($id, $ptitle)
    {
        $this->db->where(array('id' => $id, 'ptitle' => $ptitle));
        $c = $this->db->get('products')->num_rows();
        if ($c > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveProduct($data)
    {
        if ($data['id']) {
            $this->db->update('products', $data, array('id' => $data['id']));
            return $data['id'];
        } else {
            $this->db->insert('products', $data);
            return $this->db->insert_id();
        }
    }

    function insert_cat_id($tp)
    {
        $row = $this->db->get_where('products', array('id' => $tp));
        if ($row->num_rows() == 0) {
            $this->db->insert('products_categories', array('pid' => $tp[0], 'cid' => $tp[2]));
            //$this -> db -> insert('categories', array('name' => $name, 'product_type' => "5"));
            return $this->db->insert_id();
        } else {
            $r = $row->first_row();
            return $r->id;
        }
    }
    function updateAll($data)
    {
        $r = $this->db->update('pincode_cod', $data);
        return $r;
    }

    function get_product($brand_id = false)
    {
        return $this->db->get_where('products', array('brand_id' => $brand_id))->result();
    }

    function get_products($cat_id = false)
    {
        return $this->db->get_where('products', array('category' => $cat_id))->result();
    }
    function getProductsName()
    {
        $data = $this->db->get_where('products', array('status' => 1))->result_array();
        //echo  $this->db->last_query();
        return $data;
    }

    function product_dropdown()
    {
        $data = array(
            '' => 'Select Product'
        );
        $this->db->select('id,ptitle');
        $this->db->order_by('ptitle', "ASC");
        $rest = $this->db->get_where('products', array('status' => 1));
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = ucwords(strtolower($r->ptitle));
                $data[$r->id] = $tname;
            }
        }
        return $data;
    }

    function franchase_product_dropdown($user_id)
    {
        $data = array(
            '' => 'Select Product'
        );

        $this->db->select('product_id,ptitle');
        $this->db->order_by('ptitle', "ASC");
        $rest = $this->db->get_where('franchisee', array('user_id' => $user_id));
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = ucwords(strtolower($r->ptitle));
                $data[$r->product_id] = $tname;
            }
        }

        return $data;
    }
    function user_dropdown()
    {
        $data = array(
            0 => 'Select User'
        );

        $this->db->select('id,username');
        $this->db->order_by('username', "ASC");
        $rest = $this->db->get_where('users', array('status' => 1));
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = ucwords(strtolower($r->username));
                $data[$r->id] = $tname;
            }
        }
        return $data;
    }

    function user_dropdown_active()
    {
        $data = array(
            0 => 'Select User'
        );

        $this->db->select('id,username');
        $this->db->order_by('username', "ASC");
        $rest = $this->db->get_where('users', array('status' => 1));
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = ucwords(strtolower($r->username));
                $data[$r->id] = $tname;
            }
        }
        return $data;
    }

    function franchisee_dropdown()
    {

        $data = array(
            '' => 'Select Franchisee'
        );

        $this->db->select('id,userid,first_name,last_name');
        $this->db->order_by('id', "ASC");
        $rest = $this->db->get_where('ai_franch', array('status' => 1));
        if ($rest->num_rows() > 0) {
            foreach ($rest->result() as $r) {
                $tname = strtoupper($r->userid . '(' . $r->first_name . ' ' . $r->last_name . ')');
                $data[$r->id] = $tname;
            }
        }
        return $data;
    }

    function categorySearchedWhere($offset = 0, $limit = 40, $where = array(), $table = false)
    {
        if ($table) {
            $this->table = $table;
        }
        $this->db->order_by('id', 'DESC');
        $this->db->where($where);
        $sql = $this->db->get_compiled_select($this->table, false);
        $this->db->limit($limit, $offset);
        $rest = $this->db->get();
        $data['results'] = $rest->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function getWherePtype($limit = 40, $offset = 0, $rules = array(), $product_type, $table = false)
    {
        $this->db->order_by('id', 'DESC');
        if ($table) {
            $this->table = $table;
        }
        if (is_array($rules) && count($rules) > 0) {
            foreach ($rules as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $sql = $this->db->get_compiled_select($this->table, false);
        $this->db->limit($limit, $offset);
        $rest = $this->db->get();
        $data['results'] = $rest->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }
}
