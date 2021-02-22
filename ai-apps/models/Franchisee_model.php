<?php
class Franchisee_model extends Master_model{

	function __construct(){
		$this -> table = 'ai_franchisee';
	}

    function isExists($cat_id){
        $c = $this -> db -> get_where($this -> table, array('id' => $cat_id)) -> num_rows();
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

	function get_categories_tierd($parent=0, $product_type = false) {
		$categories	= array();
		$result	= $this -> categories($parent, $product_type);
		foreach ($result as $category) {
			$categories[$category -> id]['category']	= $category;
			$categories[$category -> id]['children']	= $this->get_categories_tierd($category -> id);
		}
		return $categories;
	}

	function categories($parent = 0, $product_type = false){
        if($product_type){
            $this -> db -> where('product_type', $product_type);
        }
		return $this -> db -> get_where($this -> table, array('parent_id' => $parent)) -> result();
	}

    function allCat($pid){
        $this -> db -> order_by('name', 'ASC');
        return $this -> db -> get_where('categories', array('product_type' => $pid)) -> result();
    }
	function hasChildren($parent_id){
		$c = $this -> db -> get_where($this -> table, array('parent_id' => $parent_id)) -> num_rows();
		if($c > 0){
			return true;
		}else{
			return false;
		}
	}

    function hasProduct($id){
        $p= $this->db->get_where('products_categories',array('cid'=>$id))->num_rows();
        if($p>0){
            return true;
        }
        else{
            return false;
        }
    }

	function category_dropdown(){
		$data = array(
			0 => 'Main Category'
		);
		$this -> db -> select('id,name');
		$this -> db -> order_by('name', "ASC");
		$this -> db -> where('parent_id', 0);
        $this -> db -> where('product_type',3);
		$rest = $this -> db -> get_where('categories', array('status' => 1));
		if($rest -> num_rows() > 0){
			foreach($rest -> result() as $r){
				$tname = ucwords(strtolower($r -> name));
				$data[$r -> id] = $tname;
				$data = $this -> sub_child($r -> id, $tname, $data);
			}
		}
		return $data;
	}

    function category_dropdown1($pid= null){
        $data = array(
            0 => 'Main Category'
        );
        $this -> db -> select('id,name');
        $this -> db -> order_by('name', "ASC");
        $this -> db -> where('parent_id', 0);
        if($pid != NULL){
            $this -> db -> where('product_type', $pid);
        }
        //$this -> db -> where('product_type', $pid);
        $rest = $this -> db -> get_where('categories', array('status' => 1));
        if($rest -> num_rows() > 0){
            foreach($rest -> result() as $r){
                $tname = ucwords(strtolower($r -> name));
                $data[$r -> id] = $tname;
                $data = $this -> sub_child($r -> id, $tname, $data);
            }
        }
        return $data;
    }

    function get_parent_by_type($pid= null){
        $this->db->select('id, parent_id, name, status');
        if($pid != NULL){
            $this -> db -> where('product_type', $pid);
        }
        $this->db->where('status', 1);
        $this -> db -> order_by('name', 'ASC');
        $query = $this->db->get('categories');
        $models = array();
        if($query->result()){
            foreach ($query->result() as $model) {
                $models[$model->id] = $model->name;
            }
            return $models;
        }else{
            return FALSE;
        }
    }

	function sub_child($parent_id, $name, $old_arr = array()){
		$this -> db -> select('id, name');
		$this -> db -> where('parent_id', $parent_id);
		$this -> db -> order_by('name', 'ASC');
		$rest = $this -> db -> get('categories');
		if($rest -> num_rows() > 0){
			foreach($rest -> result() as $r){
				$fname = $name . ' &#x021D2; ' . ucwords(strtolower($r -> name));
				$old_arr[$r -> id] = $fname;
				$old_arr = $this -> sub_child($r -> id, $fname, $old_arr);
			}
		}
		return $old_arr;
	}

	function get_category_links(){
		$data = array();
		$rest = $this -> db -> get($this -> table);
		if($rest -> num_rows() > 0){
			foreach($rest -> result() as $row){
				$data[$row -> id] = $row -> name;
			}
		}
		$rest -> free_result();
		return $data;
	}

    function get_category($cate_name=false){
        return $this -> db -> get_where('categories', array('name' => $cate_name)) -> result();
    }
    function get_category_exist($pid, $cid1){
        return $this -> db -> get_where('products_categories', array('pid' => $pid, 'cid'=>$cid1)) -> result();
    }
    function getAll_franchisee_order($offset = 0, $limit = 40,$user_id)
    {
        $this->db->where('user_id', $user_id);
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get('franchisee');
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> get('franchisee') -> num_rows();
        return $data;
    }
}
