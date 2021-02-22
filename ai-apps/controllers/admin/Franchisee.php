<?php
class Franchisee extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('Franchisee_model');
		$this -> data['active_tabs'] = "Store_locator";
		
	}

	function index(){
		$this -> data['dashboard_title'] = "Manage Franchisee";
		$this->template = admin_view('franchisee/index');
		$data	= $this -> Franchisee_model -> listAll();
		$this -> data['franchisee'] = $data;
		$this->load->view(admin_view('default'), $this -> data);
	}


	function add($id = false){
        $this->load->model('City_model');
        $this->data['id'] = $id;
        $this->data['state'] = $this->City_model->getStates();
		$this->template 			= admin_view('franchisee/add');
		$this ->data['p'] = $this->Product_model->product_dropdown();
        $this ->data['u'] = $this->Product_model->franchisee_dropdown();
		$this -> data['f'] = $this -> Franchisee_model -> getNew();
		if($id){
			$this -> data['f'] = $this->Franchisee_model->getRow($id);
		}
		$this->form_validation->set_rules('f[product_id]', 'product', 'required');
        $this->form_validation->set_rules('f[qty]', 'Quantity', 'required');
      
		if($this -> form_validation -> run()){
			//print_r($_FILES);
			$data = $this -> input -> post('f');
			$pname = $this->db->select('*')->get_where('products',array('id'=>$data['product_id']))->row();
			//var_dump($pname); die;
			if($pname->qty>=$data['qty']){
			$data['id'] = $id;
			$data['ptitle'] = $pname->ptitle;
			$id	= $this->Master_model->save($data,'franchisee');
			$d= array();
			$d['id'] =  $data['product_id'];
			$d['qty'] = $pname->qty - $data['qty'];
			$this->Master_model->save($d,'ai_products');
			$this -> session -> set_flashdata('success', 'Order send successfully.');
			redirect(admin_url('franchisee/add'));
			}
			else
			{
				$this -> session -> set_flashdata('error', 'Stock Not available. Only '.$pname->qty.' item Available');
				redirect(admin_url('franchisee/add'));
			}
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}
	function quantity()
	{
		$id= $_POST['id'];
		$qty = $this->db->get_where('products',array('id'=>$id))->row();
		echo $qty->qty;
	}

	public function delete($id){
		if($id > 0){
            $this -> db -> where('id', $id);
            $this -> db -> delete('franchisee');
            redirect(admin_url('franchisee'));
			$this -> session -> set_flashdata('success', 'Franchisee deleted successfully');
		}
		redirect(admin_url('franchisee'));
	}

}
