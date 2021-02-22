<?php
class Products extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        //SET @@GLOBAL connect_timeout=300;
        $this->load->model('Product_model');
        $this->load->model('Media_model');
    }



    function bulksave()
    {
        $url = admin_url('products');
        if ($this->input->post('frmall')) {
            print_r($_POST['ids']);
            die;
            $url = $this->input->post('url');
            $pids = $this->input->post('pid');
            $ship = $this->input->post('ship');
            $qty = $this->input->post('qty');
            $off = $this->input->post('offer');
            $sequence = $this->input->post('sequence');
            foreach ($pids as $id => $val) {
                $item = array();
                $item['id'] = $id;
                $item['sale_price'] = $val;
                $item['ship_charge'] = $ship[$id];
                $item['qty'] = $qty[$id];
                $item['offer'] = $off[$id];
                $item['sequence'] = $sequence[$id];
                $this->Product_model->save($item);
            }
            $this->session->set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }

    function index()
    {


        $show_per_page = isset($_GET['show_page']) ? $_GET['show_page'] : 100;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->data['category']     = $this->Category_model->category_dropdown();
        $offset = ($page - 1) * $show_per_page;
        $this->data['main']  = admin_view('products/index');
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $rule = array();
        if ($status == 'active') {
            $rule['status'] = 1;
            $data    = $this->Product_model->getWherePtype($show_per_page, $offset, $rule, 5);
        } elseif ($status == 'inactive') {
            $rule['status'] = 0;
            $data    = $this->Product_model->getWherePtype($show_per_page, $offset, $rule, 5);
        } else {
            $data    = $this->Product_model->getWherePtype($show_per_page, $offset, '', 5);
        }

        $this->data['filter_status'] = $status;
        $this->data['q'] = '';
        if ($this->input->get('btnsearch')) {
            $q = $this->input->get('q');
            if ($q <> '') {
                $likes = array(
                    'ptitle' => $q, 'id' => $q, 'sku' => $q
                );
                $data = $this->Product_model->getAllSearchedWhere($offset, $show_per_page, $likes);
                $this->data['q'] = $q;
            }
        }

        if ($this->input->get('category')) {
            $q = $this->input->get('category');
            if ($q <> '') {
                $likes = array(
                    'category' => $q
                );
                $data = $this->Product_model->categorySearchedWhere($offset, $show_per_page, $likes);
                //$this -> data['q'] = $q;
            }
        }


        $this->data['products'] = $data['results'];
        $config['base_url']      = admin_url('products/index');
        $config['num_links']      = 2;
        $config['uri_segment']     = 4;
        $config['total_rows']     = $data['total'];
        $config['per_page']      = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link']      = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']      = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link']      = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link']      = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this->data['paginate']     =  $this->pagination->create_links();

        $this->data['categories'] = $data['results'];
        $this->load->view(admin_view('default'), $this->data);
    }

    function stock()
    {
        $this->template  = admin_view('products/design-index');
        $this->data['designs'] = $this->Master_model->listAll('products');
        $this->load->view(admin_view('default'), $this->data);
    }

    function server_image_upload($fileTo, $fileFrom)
    {

        $ftp_server = "images-aldivo.com";
        $ftp_user = "aldivoimages";
        $ftp_password = "Booklele@#123";
        $conn = ftp_connect($ftp_server) or die("Cannot connect to host");
        if (@ftp_login($conn, $ftp_user, $ftp_password)) {
            ftp_pasv($conn, true);
            $uploaded = ftp_put($conn, $fileTo, $fileFrom, FTP_BINARY);
            ftp_close($conn);
            if ($uploaded) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            return "Couldn't connect as $ftp_user\n";
        }
    }

    function add($id = false)
    {
        $this->data['main']  = admin_view('products/add');
        $this->data['dashboard_title'] = ($id == false) ? "Add Products" : "Edit Products";
        $this->data['categories']        = $this->Category_model->get_categories_tierd();
        $this->data['category']     = $this->Category_model->category_dropdown();
        $this->data['gift'] = $this->Master_model->listAllWhere('categories', array('parent_id' => 102));
        $this->data['images'] = $this->Media_model->allimages();
        $this->data['p'] = $this->Product_model->getNew();
        if ($id) {
            $this->data['p'] = $this->Product_model->getProduct($id);
            $this->data['categories']    = $this->Category_model->get_categories_tierd(0, $this->data['p']->product_type);
        }

        $this->form_validation->set_rules('frm[ptitle]', 'Product Title', 'required');

        if ($this->form_validation->run()) {
            $p = $this->input->post('frm');
            $p['id'] = $id;
            $p['gallery'] = $this->input->post('img_selected');
            $p['available'] = $this->input->post('frm[available]') ? 1 : 0;
            $p['discount'] = $this->input->post('frm[discount]') ? 1 : 0;
            $p['cod_available'] = $this->input->post('cod_available') ? 1 : 0;

            $config = array();
            $config['upload_path'] = upload_dir();
            $config['allowed_types'] = 'png|jpg|jpeg|gif';
            $config['max_size'] = 3000;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);

            $uploaded = $this->upload->do_upload('cover_image');
            if ($uploaded) {
                $image = $this->upload->data();
                $p['image'] = $image['file_name'];
                $image = site_url(upload_dir($image['file_name']));
            }

            $p['gallery'] = $image;

            $slug = $p['slug'];
            if (empty($slug) || $slug == '') {
                $slug = $p['ptitle'];
            }
            $slug    = strtolower(url_title($slug));
            $p['slug'] = $this->Product_model->get_unique_url($slug, $id);

            if ($this->input->post('sizes')) {
                $p['sizes'] = json_encode($this->input->post('sizes'));
            }
            if ($this->input->post('params')) {
                $p['params'] = json_encode($this->input->post('params'));
            }

            $id = $this->Product_model->save($p);
            if ($this->input->post('cats')) {
                $cats = $this->input->post('cats');
                $this->Product_model->resetCategory($id, $cats);
            }
            $this->session->set_flashdata("success", "Product saved successfully");
            redirect(admin_url('products/add/' . $id));
        }

        $this->load->view(admin_view('default'), $this->data);
    }

    function return_product()
    {
        $this->template  = admin_view('members/return');

        $this->form_validation->set_rules('frm[user_id]', 'user id', 'required');


        if ($this->form_validation->run()) {
            $p = $this->input->post('frm');


            $f = $this->db->get_where('products', array('id' => $p['p_id']))->row()->qty;
            $arr = array('qty' => $p['qty'] + $f, 'id' => $p['p_id']);
            $this->Master_model->save($arr, 'products');
            $id = $this->Master_model->save($p, 'return_product');

            $this->session->set_flashdata("success", "Product Return successfully");
            redirect(admin_url('products/return/'));
        }

        $this->load->view(admin_view('default'), $this->data);
    }
    function package()
    {
        $this->template  = admin_view('products/package');
        $this->data['pack'] = $this->db->get('package')->result();
        $this->load->view(admin_view('default'), $this->data);
    }



    function create_package($id = false)
    {

        $config['upload_path']      = 'img/uploads';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
        $config['max_size']         = '5000';
        $config['max_width']        = '3000';
        $config['max_height']       = '2000';
        $this->load->library('upload', $config);
        $this->template  = admin_view('products/create_package');
        $this->data['product'] = $this->db->get('products')->result();
        $this->data['m'] = $this->Master_model->getNew('package');
        if ($id) {
            $this->data['m'] = $this->Master_model->getRow($id, 'package');
        }
        $this->form_validation->set_rules('frm[name]', 'Name', 'required');
        if ($this->form_validation->run()) {
            $m = $this->input->post('frm');
            $m['id'] = $id;

            if ($this->input->post('item')) {
                $m['item'] = implode(',', $this->input->post('item'));
            }

            $uploaded    = $this->upload->do_upload('image');
            if ($id) {
                if ($this->input->post('del_image')) {
                    $img_name = $this->input->post('hid_image');
                    @unlink('img/products/' . $img_name);
                    $m['image'] = '';
                }
            }

            if ($uploaded) {
                $image          = $this->upload->data();
                $m['image']   = $image['file_name'];
            } //else{
            //
            $id = $this->Master_model->save($m, 'package');
            $this->session->set_flashdata("success", "Package created successfully");
            redirect(admin_url('products/create_package/' . $id));
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }
    function add_item($id = false)
    {

        if ($id == '') {
            redirect(admin_url('products/package'));
        }
        $this->data['item'] = '';
        $this->data['id'] = $id;
        $this->template  = admin_view('products/add_item');
        if ($this->input->post('pr_name')) {

            $p = $this->input->post('pr_name');


            $this->data['item'] = $this->db->get_where('products', array('ptitle' => $p))->result();
        }

        if ($this->input->post('add_item')) {
            $itm =  $this->input->post('frm');
            $itm['id'] = false;
            $itm['packid'] = $id;
            $this->Master_model->save($itm, 'pack_item');
            $this->session->set_flashdata("success", "Item  added successfully");
        }
        $this->data['product'] = $this->db->get_where('pack_item', array('packid' => $id))->result();
        $this->load->view(admin_view('default'), $this->data);
    }


    function deletep()
    {
        $pid = $this->input->get('pid');
        $pkd = $this->input->get('pkd');
        $this->Master_model->delete($pid, 'pack_item');
        $this->session->set_flashdata("success", "Item deleted");

        redirect(admin_url('products/add_item/' . $pkd));
    }
    function pincode_upload()
    {
        //print_r($_FILES);
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'txt|pdf';
        $config['max_size'] = 200;
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $uploaded = $this->upload->do_upload('pincode');
        //$p['pincodes'] = '';
        $p = array();
        if ($uploaded) {
            $file_name = $this->upload->data('file_name');
            $this->load->helper("file");
            $string = file_get_contents('./temp/' . $file_name);
            $p['pincodes'] = $string;
            $this->Product_model->updateAll($p);
            $this->session->set_flashdata('success', 'Pincode updated Successfully');
            redirect(admin_view('products'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(admin_view('products/upload_pin'));
            //echo $this -> upload -> display_errors();
        }
    }
    function mobile_models()
    {
        $brand_id = $this->input->post('brand_id');
        $m = $this->Mobile_model->get_models($brand_id);
        if (is_array($m) && count($m) > 0) { ?>
            <?php foreach ($m as $id => $title) {
            ?>
                <option value="<?= $id; ?>"><?= $title; ?></option>
            <?php
            }
        }
    }

    function activate($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('products');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 1;
            $this->Product_model->save($c);
            $this->session->set_flashdata("success", "Product activated");
        }
        redirect($redirect);
    }

    function deactivate($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('products');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 0;
            $this->Product_model->save($c);
            $this->session->set_flashdata("success", "Product deactivated");
        }
        redirect($redirect);
    }

    function del_designs($id = false)
    {
        if ($id) {
            $this->Master_model->delete($id, 'designs');
            $this->session->set_flashdata("success", "Design deleted");
        }
        redirect(admin_url('products/designs'));
    }

    /*function delete($id = false){
        if($id){
            $this -> Product_model -> delete($id, 'products');
            $this -> Product_model -> deletepcat($id, 'products_categories');
            $this -> session -> set_flashdata("success", "Product delete successfully");
        }
        redirect(admin_url('products'));
    }*/

    public function delete($id = false)
    {
        $data['status'] = 1;
        if ($id) {
            $this->Product_model->delete($id);
            $this->Product_model->delete_p_cat($id);
            $this->session->set_flashdata('success', 'Products deleted successfully');
        } else {
            $ids = $this->input->post('ids');
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $this->Product_model->delete($id);
                    $this->Product_model->delete_p_cat($id);
                }
            }
            $this->session->set_flashdata('success', 'Bulk Products deleted');
        }
        redirect('admin/products');
    }

    function export_selected($id = false)
    {
        $data['status'] = 1;
        $this->db->select('id, ptitle, slug, description, fit_details, fabric_details, delivery_info, short_description, sizes, size_price, price, sale_price, image, gallery, min_order, max_order, status, created, params, meta_title, meta_description, meta_keywords, qty, discount_type, discount, discount_rate, available, ship_charge, ship_notes, pincodes, brand_id, models, material, theme, specification, highlights, customize, product_type, cod, feature, sequence, sku, design_code, model_code, name, event, is_printed');
        if ($id) {

            $this->session->set_flashdata('success', 'Products Exported successfully');
        } else {
            $ids = $this->input->post('ids');
            //print_r($ids); //exit();
            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');
            ini_set('memory_limit', '1024M');
            $delimiter = ",";
            $newline = "\r\n";
            $filename = "products.csv";
            $this->db->where_in('id', $ids);
            $result = $this->db->get('products');
            //$query = "SELECT * FROM products order by id DESC";
            //$result = $this->db->query($query);
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            //$this->Stock_manage_model->ExportCSV();
            redirect(admin_url('products'));
            /*if(is_array($ids)){
                foreach($ids as $id){
                    $this -> Product_model -> delete($id);
                    $this -> Product_model -> delete_p_cat($id);
                }
            }*/
            $this->session->set_flashdata('success', 'Bulk Products exported');
        }
        redirect('admin/products');
    }

    function export_all()
    {
        $data['status'] = 1;
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        ini_set('memory_limit', '1024M');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "products.csv";
        $result = $this->db->get('products');
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        redirect(admin_url('products'));
        $this->session->set_flashdata('success', 'Bulk Products deleted');
        redirect('admin/products');
    }


    function ajax_upload()
    {
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $d['msg'] = '';
        $this->load->library('upload', $config);
        if ($this->input->post('submit')) {
            $total = count($_FILES['filesToUpload']['name']);
            $files = $_FILES;
            for ($i = 0; $i < $total; $i++) {
                $_FILES['filesToUpload']['name'] = $files['filesToUpload']['name'][$i];
                $_FILES['filesToUpload']['type'] = $files['filesToUpload']['type'][$i];
                $_FILES['filesToUpload']['tmp_name'] = $files['filesToUpload']['tmp_name'][$i];
                $_FILES['filesToUpload']['error'] = $files['filesToUpload']['error'][$i];
                $_FILES['filesToUpload']['size'] = $files['filesToUpload']['size'][$i];

                if ($this->upload->do_upload('filesToUpload')) {
                    $save = $this->upload->data();
                    $save['id'] = false;
                    $save['img_title']        = "Untitled";
                    $save['img_alt']        = "Untitled";
                    $this->Media_model->save($save);
                } else {
                    //echo $this -> upload -> display_errors();
                }
            }
            $d['msg'] = "File uploaded successfully";
        }
        $this->load->view(admin_view('products/ajax-upload'), $d);
    }

    function filter_img($q = '')
    {
        $imglist = $this->Media_model->filter_img($q);
        if ($q == '') {
            $imglist = $this->Media_model->allimages();
        }
        if (is_array($imglist) && count($imglist) > 0) {
            foreach ($imglist as $imob) {
            ?>
                <li><img src="<?= base_url(upload_dir($imob->file_name)); ?>" class="img-thumbnail img-responsive img-popup" /> </li>
            <?php
            }
        } else {
            ?>
            <li style="width: 100%">
                <div class="alert alert-danger">NO FILE FOUND</div>
            </li>
        <?php
        }
    }

    function ajaximgdel()
    {
        $imgsrc = $this->input->post('imgsrc');
        $str['id'] = $this->input->post('pid');
        $m = $this->Product_model->getProduct($str['id']);
        if ($m->gallery <> '') {
            $str['gallery'] = str_replace($imgsrc . ',', '', $m->gallery);
        }
        $this->Product_model->save($str);
        echo true;
    }

    function ajaxLoadCategory($product_type)
    {
        $p = $this->Category_model->get_categories_tierd(0, $product_type);
        $this->list_categories($p, '', array());
    }

    function list_categories($cats, $sub = '', $pcats)
    {
        foreach ($cats as $cat) : ?>
            <li><label class="checkbox checkbox-inline"><input type="checkbox" name="cats[]" value="<?php echo  $cat['category']->id; ?>" <?php if (in_array($cat['category']->id, $pcats)) echo ' checked'; ?> /><?php echo  $sub . $cat['category']->name; ?></label> </li>
<?php
            if (sizeof($cat['children']) > 0) {
                $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
                $sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
                $this->list_categories($cat['children'], $sub2, $pcats);
            }
        endforeach;
    }

    function import_files()
    {
        $this->template  = admin_view('products/import-file');
        if ($this->input->post('import_btn')) {
            $count = 0;
            if ($_FILES['excel_file']['name'] <> '') {
                $fn = $_FILES['excel_file']['tmp_name'];
                $file = fopen($fn, "r");
                while (($tp = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $count++;
                    if ($count > 1) {
                        $this->check_nd_update($tp);
                        // echo "hi".$this->db->last_query();
                    }
                }
            }
        }
        $this->load->view(admin_view('default'), $this->data);
    }

    function check_nd_update($tp)
    {
        $data = array();
        $data['id'] = false;
        $data['product_type'] = $tp[1];
        if ($tp[1] == "") {
            //if($tp[1]=="" && $tp[2]==""){
            $this->session->set_flashdata('error', "Product Main Category and a child category must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $cate_name1 = $tp[2];
        $cate_name2 = $tp[3];
        $cate_name3 = $tp[4];
        $data['sku'] = $tp[5];
        if ($tp[5] == "") {
            $this->session->set_flashdata('error', "Product SKU must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['ptitle'] = $tp[6];
        if ($tp[6] == "") {
            $this->session->set_flashdata('error', "Product Title must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $slug = $tp[7];
        if (trim($slug) == '') {
            $slug = $tp[6];
        }
        $data['slug'] = url_title($slug);
        $data['price'] = $tp[8];
        if ($tp[8] == "") {
            $this->session->set_flashdata('error', "Price must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['sale_price'] = $tp[9];
        $data['qty'] = $tp[10];
        if ($tp[10] == "") {
            $this->session->set_flashdata('error', "Quantity must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['ship_charge'] = $tp[11];
        $data['cod'] = $tp[12];
        if ($tp[12] == "") {
            $this->session->set_flashdata('error', "COD must not be blank");
            redirect(admin_url('products/import_files'));
        }
        //print_r($data); exit();
        if ($tp[1] == 3) {
            $data['fit_details'] = $tp[13];
            $data['fabric_details'] = $tp[14];
            $data['sizes'] = $tp[20];
            if ($tp[20] == "") {
                $this->session->set_flashdata('error', "Size must not be blank");
                redirect(admin_url('products/import_files'));
            }
            $data['size_price'] = $tp[21];
        }
        $data['description'] = $tp[17];
        $data['delivery_info'] = $tp[18];
        $data['short_description'] = $tp[19];
        $data['image'] = $tp[22];
        if ($tp[22] == "") {
            $this->session->set_flashdata('error', "Main Image must not be blank");
            redirect(admin_url('products/import_files'));
        }
        //$image1=$image2=$image3=$image4=$image5="";
        if (!$tp[23] == "") {
            $image1 = $tp[23];
        } else {
            $image1 = "";
        }
        if (!$tp[24] == "") {
            $image2 = ',' . $tp[24];
        } else {
            $image2 = "";
        }
        if (!$tp[25] == "") {
            $image3 = ',' . $tp[25];
        } else {
            $image3 = "";
        }
        if (!$tp[26] == "") {
            $image4 = ',' . $tp[26];
        } else {
            $image4 = "";
        }
        if (!$tp[27] == "") {
            $image5 = ',' . $tp[27];
        } else {
            $image5 = "";
        }
        $data2['gallery'] = $image1 . $image2 . $image3 . $image4 . $image5;
        $st = str_replace(',,', ',', $data2['gallery']);
        $st = str_replace(',,,', ',', $data2['gallery']);
        $data['gallery'] = trim($st, ',');

        $data['min_order'] = $tp[28];
        $data['max_order'] = $tp[29];
        $data['status'] = $tp[30];
        if ($tp[30] == "") {
            $this->session->set_flashdata('error', "Status must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['created'] = date('Y-m-d H:i:s');
        $data['params'] = $tp[31];
        $data['meta_title'] = $tp[32];
        $data['meta_description'] = $tp[33];
        $data['meta_keywords'] = $tp[34];
        $data['discount_type'] = $tp[35];
        $data['discount'] = $tp[36];
        $data['discount_rate'] = $tp[37];
        $data['available'] = $tp[38];
        $data['ship_notes'] = $tp[39];
        //$data['pincodes']= $tp[38];
        $file_name = $tp[40];
        if (!$file_name == "") {
            if (is_numeric($file_name)) {
                $data['pincodes'] = $file_name;
            } else {
                $url = upload_dir($file_name);
                if (file_exists($url)) {
                    $string = file_get_contents($url);
                    $data['pincodes'] = $string;
                }
            }
        }

        if ($tp[1] == 5) {
            $data['specification'] = $tp[15];
            $data['highlights'] = $tp[16];
            $data2['brand_name'] = $tp[41];
            $brand_name = $data2['brand_name'];
            if ($tp[41] == "") {
                $this->session->set_flashdata('error', "Brand Name must not be blank");
                redirect(admin_url('products/import_files'));
            }
            $data3['models'] = $tp[42];
            $models = $data3['models'];
            if ($tp[42] == "") {
                $this->session->set_flashdata('error', "Model Name must not be blank");
                redirect(admin_url('products/import_files'));
            }
            $data['material'] = $tp[43];
            $data['theme'] = $tp[44];
            $brand_id = $this->Mobile_model->get_brand_id_by_name($brand_name);
            //echo $brand_id; exit();
            $data['brand_id'] = $brand_id;

            $models1 = $this->Mobile_model->get_model_id_by_brand_id($brand_id, $models);
            //print_r($models1); exit();
            if (is_object($models1)) {
                $data['models'] = $models1->id;
                //print_r($data['models']);
            }
        }
        $data['customize'] = $tp[45];
        if ($tp[45] == "") {
            $this->session->set_flashdata('error', "Customization must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['product_type'] = $tp[46];
        $data['feature'] = $tp[47];
        if (!isset($data['brand_id']) || $data['brand_id'] == 0) {
            echo "Error: " . $data['sku'];
            exit();
        }
        $data['sequence'] = $tp[48];
        $data['event'] = $tp[49];
        $data['is_printed'] = $tp[50];
        $pid = $this->Product_model->saveProduct($data);
        $cid_exists = $this->Category_model->get_category_exist($pid, $tp[1]);
        if (is_array($cid_exists) && count($cid_exists) > 0) {
        } else {
            $this->db->insert('products_categories', array('pid' => $pid, 'cid' => $tp[1]));
        }

        $cid_exist = $this->Category_model->get_category_exist($pid, $tp[2]);
        if (is_array($cid_exist) && count($cid_exist) > 0) {
        } else {
            $this->db->insert('products_categories', array('pid' => $pid, 'cid' => $tp[2]));
        }

        $cid_exist = $this->Category_model->get_category_exist($pid, $tp[3]);
        if (is_array($cid_exist) && count($cid_exist) > 0) {
        } else {
            $this->db->insert('products_categories', array('pid' => $pid, 'cid' => $tp[3]));
        }

        $cid_exist = $this->Category_model->get_category_exist($pid, $tp[4]);
        if (is_array($cid_exist) && count($cid_exist) > 0) {
        } else {
            $this->db->insert('products_categories', array('pid' => $pid, 'cid' => $tp[4]));
        }

        $this->session->set_flashdata('success', "Data Imported Successfully");
        //endif;
        /*if($this -> Product_model -> check_duplicate($data['id'], $data['ptitle']) == false){
            $this -> Product_model -> saveProduct($data);
            $this -> session -> set_flashdata('success', "Data Imported Successfully");
        }*/
    }

    function update_files()
    {
        $this->template  = admin_view('products/update-product-file');
        if ($this->input->post('import_btn')) {
            $count = 0;
            if ($_FILES['excel_file']['name'] <> '') {
                $fn = $_FILES['excel_file']['tmp_name'];
                $file = fopen($fn, "r");
                while (($tp = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $count++;
                    if ($count > 1) {
                        $this->check_and_update($tp);
                    }
                }
                $this->session->set_flashdata('success', "Data Imported Successfully");
                redirect(admin_url('products/update_files'));
            }
        }
        $this->load->view(admin_view('default'), $this->data);
    }

    function check_and_update($tp)
    {
        $data = array();
        $data['id'] = $tp[0];
        $data['product_type'] = $tp[38];
        if ($tp[38] == "") {
            $this->session->set_flashdata('error', "Product Main Category and a child category must not be blank");
            redirect(admin_url('products/import_files'));
        }
        $data['ptitle'] = $tp[1];
        $data['slug'] = $tp[2];
        $data['description'] = $tp[3];
        $data['fit_details'] = $tp[4];
        $data['fabric_details'] = $tp[5];
        $data['delivery_info'] = $tp[6];
        $data['short_description'] = $tp[7];
        $data['sizes'] = $tp[8];
        $data['size_price'] = $tp[9];
        $data['price'] = $tp[10];
        $data['sale_price'] = $tp[11];
        $data['image'] = $tp[12];
        $data['gallery'] = $tp[13];
        $data['min_order'] = $tp[14];
        $data['max_order'] = $tp[15];
        $data['status'] = $tp[16];
        $data['created'] = $tp[17];
        $data['params'] = $tp[18];
        $data['meta_title'] = $tp[19];
        $data['meta_description'] = $tp[20];
        $data['meta_keywords'] = $tp[21];
        $data['qty'] = $tp[22];
        $data['discount_type'] = $tp[23];
        $data['discount'] = $tp[24];
        $data['discount_rate'] = $tp[25];
        $data['available'] = $tp[26];
        $data['ship_charge'] = $tp[27];
        $data['ship_notes'] = $tp[28];
        $data['pincodes'] = $tp[29];
        $data['brand_id'] = $tp[30];
        $data['models'] = $tp[31];
        $data['material'] = $tp[32];
        $data['theme'] = $tp[33];
        $data['specification'] = $tp[34];
        $data['highlights'] = $tp[35];
        $data['customize'] = $tp[36];
        $data['product_type'] = $tp[37];
        $data['cod'] = $tp[38];
        $data['feature'] = $tp[39];
        $data['sequence'] = $tp[40];
        $data['sku'] = $tp[41];
        $data['design_code'] = $tp[42];
        $data['model_code'] = $tp[43];
        $data['name'] = $tp[44];
        $data['event'] = $tp[45];
        $data['is_printed'] = $tp[46];
        /*$data['ptitle'] = $tp[1];
        $data['slug'] = $tp[2];
        $data['description'] = $tp[3];
        $data['delivery_info'] = $tp[6];
        $data['short_description'] = $tp[7];
        $data['sku'] = $tp[10];
        $data['price'] = $tp[11];
        $data['sale_price'] = $tp[12];
        $data['image'] = $tp[13];
        $data['gallery'] = $tp[14];
        $data['min_order'] = $tp[15];
        $data['max_order'] = $tp[16];
        $data['status'] = $tp[17];
        //$data['created'] = $tp[18];
        $data['meta_title'] = $tp[20];
        $data['meta_description'] = $tp[21];
        $data['meta_keywords'] = $tp[22];
        $data['qty'] = $tp[23];
        $data['discount_type'] = $tp[24];
        $data['discount'] = $tp[25];
        $data['discount_rate'] = $tp[26];
        $data['available'] = $tp[27];
        $data['ship_charge'] = $tp[28];
        $data['ship_notes'] = $tp[29];
        //$data['pincodes'] = $tp[30];
        $data['brand_id'] = $tp[30];
        $data['models'] = $tp[31];
        $data['material'] = $tp[32];
        $data['theme'] = $tp[33];
        $data['specification'] = $tp[34];
        $data['highlights'] = $tp[35];
        $data['customize'] = $tp[36];
        $data['product_type'] = $tp[37];
        $data['cod'] = $tp[38];
        $data['feature'] = $tp[39];
        $data['sequence'] = $tp[40];
		$data['event'] = $tp[41];
		$data['is_printed'] = $tp[42];*/

        //print_r($data);die;
        $pid = $this->Product_model->saveProduct($data);
    }


    function export()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "products.csv";
        $query = "SELECT * FROM products order by id DESC";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        //$this->Stock_manage_model->ExportCSV();
        redirect(admin_url('stock_manage'));
    }

    function barcode()
    {
        $filepath = (isset($_GET["filepath"]) ? $_GET["filepath"] : '');
        $text = (isset($_GET["text"]) ? $_GET["text"] : "0");
        $size = (isset($_GET["size"]) ? $_GET["size"] : "20");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["code_type"]) ? $_GET["code_type"] : "code128");
        $print = (isset($_GET["print"]) && $_GET["print"] == 'true' ? true : false);
        $SizeFactor = (isset($_GET["sizefactor"]) ? $_GET["sizefactor"] : "1");

        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }

            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");

            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }

            for ($X = 1; $X <= strlen($text); $X += 2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }

            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (int) (substr($code_string, ($i - 1), 1));
        }

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length * $SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $SizeFactor;
        }

        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1));
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
        if ($filepath == "") {
            header('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image, $filepath);
            imagedestroy($image);
        }
    }

    function print_barcode()
    {
        // $this->data['id'] = $id ;

        $this->load->view(admin_view('products/barcode'), $this->data);
    }

    function gen_code()
    {
        $this->data['id'] = 3;

        $this->load->view(admin_view('products/printbar'), $this->data);
    }

    function gen_code1()
    {
        $this->data['id'] = 3;

        $this->load->view(admin_view('products/printbar22'), $this->data);
    }
    function barcode_form()
    {
        $this->template  = admin_view('products/barcode_form');
        $this->data['q'] = '';
        $this->load->view(admin_view('default'), $this->data);
    }

    function user_info()
    {
        if ($this->input->get('user_id')) {
            $p =   $this->db->get_where('ai_users', array('userid' => $this->input->get('user_id')))->row();

            if (is_object($p)) {
                $pack = $this->Package_model->package($p->package);
                echo '<label class="col-sm-2">Associate Name</label>
                    <div class="col-sm-4">
                      <b>  ' . $p->first_name . ' ' . $p->last_name . '</b>
                    </div>
                    <label class="col-sm-2">Package</label>
                    <div class="col-sm-4"><b>
                      ' . $p->package_name . '</b>
                    </div>';
            } else {
                echo '<span class="error" style="display:block;width:100%; text-align:center; color:red;">invalid Associate id</span>';
            }
        } else {
            echo "invalid Associate id";
        }
    }
    function tuser_info()
    {
        if ($this->input->get('user_id')) {
            $p =   $this->db->get_where('ai_users', array('userid' => $this->input->get('user_id')))->row();

            if (is_object($p)) {
                $pack = $this->Package_model->package($p->package);
                echo $p->first_name . ' ' . $p->last_name;
            } else {
                echo '<span class="error" style="display:block;width:100%; text-align:center; color:red;">invalid CODE</span>';
            }
        } else {
            echo "invalid CODE";
        }
    }

    public function delivery_report()
    {

        $this->template = 'products/product_delivery';
        $user = '';
        if (isset($_GET['from']) && isset($_GET['to'])) {
            $this->db->where('created >=', $_GET['from']);
            $this->db->where('created <=', $_GET['to']);
            $this->db->order_by('id', 'DESC');
            $user = $this->db->get('ai_delivery')->result();

            if ($this->input->get('export')) {
                $this->export_report($user);
            }
        } else {
            $this->db->order_by('id', 'DESC');
            $user = $this->db->get('ai_delivery')->result();
        }


        $this->data['members'] = $user;
        $this->load->view(admin_view('default'), $this->data);
    }

    function export_report($user)
    {
        $pay = array();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        ini_set('memory_limit', '1024M');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "payout.csv";
        $members = $user;
        $ids = array();
        $list = array();
        $s = 1;
        if (is_array($user) and count($user) > 0) {
            foreach ($user as $ob) {
                $m = $this->Master_model->getRow($ob->user_id, 'ai_users');
                $pack_info = $this->Package_model->getRow($m->package);
                $item = array();
                if (isset($user)) {
                    $item['slno'] = $s++;
                    $item['associa'] = $m->userid;
                    $item['name'] = $m->first_name . '' . $m->last_name;
                    $item['package'] = $pack_info->package;
                    $item['DOJ'] = date("Y-m-d h:i:s a", strtotime($m->join_date));
                    $item['DOA'] = date("Y-m-d h:i:s a", strtotime($m->activated_date));
                    $item['deliver_date'] = date("Y-m-d", strtotime($ob->created));
                    $item['notes'] = $ob->comment;
                    $item['deliver'] = $ob->status == 1 ? 'Yes' : 'No';
                }

                $list[] = $item;
            }
            $filename = date('dmY') . "_report.csv";
            $fp = fopen('php://output', 'w');
            $headers = array('sl.no', "Associate", "Associate Name", "Package", "DOJ", "DOA", "Deliver Date", "Naration", "Deliver");
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $headers);
            foreach ($list as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
            die;
        }
    }

    public function add_delivery($id = false)
    {

        $this->template = 'products/add_delivery';
        $this->data['m'] = $this->Master_model->getNew('ai_delivery');
        $this->data['package_name'] =  $this->data['u'] = '';
        if ($id) {
            $this->data['m'] = $this->Master_model->getRow($id, 'ai_delivery');
            // $this -> data['package_name'] = $this->Package_model->package_name( $this -> data['m']->package_id);
            $u =  $this->Master_model->getRow($this->data['m']->user_id, 'ai_users');
            $this->data['u'] = $u->first_name . ' ' . $u->last_name;
            $this->data['package_name'] = $u->package_name;
        }

        $this->form_validation->set_rules('user_id', 'Associate id', 'required');
        if ($this->form_validation->run()) {
            $p = $this->input->post('frm');
            $s =   $this->db->get_where('ai_users', array('userid' => $this->input->post('user_id')))->row();

            if ($id == false) {
                $found =   $this->db->get_where('ai_delivery', array('user_id' => $s->id))->num_rows();
                if ($found > 0) {
                    $this->session->set_flashdata("error", "Bill already generated for this user.");
                    redirect(admin_url('products/add_delivery/'));
                }
            }



            if (is_object($s)) {
                $p['id'] = $id;
                $p['user_id'] = $s->id;

                // $p['package_id'] = $s->package;

                //  $pack_name =  $this->Package_model->package_name($s->package);

                // if($this->input->post('gst'))
                // {
                //     $gst = $this->input->post('gst');
                //     $p['combo'] = json_encode($gst);
                // }

                //send sms for product delivary
                // $u =  $this->Master_model->getRow($s->id,'ai_users');

                if ($id == false and $p['status'] == 1) {
                    $ms = "Hi " . $s->first_name . ", Your Product(" . $s->package_name . ") is delivery on " . date('d-m-Y', strtotime($p['created'])) . " Thank You for business with us. Wavenet Skills Pvt. Ltd, Login at: http://www.wspl.biz";

                    sendSMS($s->mobile, $ms);
                }

                $id = $this->Master_model->save($p, 'ai_delivery');

                $this->session->set_flashdata("success", "Product Deliver successfully");
                redirect(admin_url('products/add_delivery/' . $id));
            } else {
                $this->session->set_flashdata("error", "invalid Associate Id");
                redirect(admin_url('products/add_delivery/' . $id));
            }
        }

        $this->load->view(admin_view('default'), $this->data);
    }

    function bill($user_id = false)
    {
        $this->db->select('users.*,ai_delivery.*,ai_delivery.id as invoice');
        $this->db->from('ai_delivery');
        $this->db->join('users', 'users.id = ai_delivery.user_id');
        $this->db->where('ai_delivery.user_id', $user_id);
        $this->data['rs'] = $this->db->get()->row();
        $this->load->front_view('bill', $this->data);
    }


    function billing()
    {
        $this->template = 'products/print_bill';
        $this->load->view(admin_view('default'), $this->data);
    }


    function print_bill()
    {
        $to_date = date('Y-m-d', strtotime('next sunday'));
        $from_date = date('Y-m-d', strtotime('-6 day', strtotime($to_date)));

        $user_id = $this->input->get('user_id');
        $this->db->select('*');
        $this->db->where('userid', $user_id);
        $this->db->from('ai_users');
        $this->data['rs'] = $this->db->get()->row();
        //var_dump( $this->data['rs'] ); die;
        // var_dump(expression)

        //count seesion id
        $this->data['sess'] = $this->db->group_by('to_date')->get_where('ai_bill')->num_rows();

        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->from('ai_bill');
        $x = $this->db->get()->row();
        if (!is_object($x)) {

            $this->db->insert('ai_bill', array('user_id' => $user_id, 'from_date' => $from_date, 'to_date' => $to_date, 'created' => date('Y-m-d')));
            $this->db->select('*');
            $this->db->where('user_id', $user_id);
            $this->db->from('ai_bill');
            $x = $this->db->get()->row();
        }
        //  var_dump($this->data['rs']); die;
        $this->data['bill'] = $x;


        if ($this->data['rs']->plan_total == 8997) {

            $this->load->front_view('bill_8997', $this->data);
            // $this -> load -> front_view('bill_4500', $this -> data);
        } elseif ($this->data['rs']->plan_total == 7500 and $this->data['rs']->package_name == 'SUPER WAVE 12+ SL COMBO') {

            $this->load->front_view('bill_7500', $this->data);
        } elseif ($this->data['rs']->plan_total == 7500 and $this->data['rs']->package_name == 'AGRO+SL COMBO') {

            $this->load->front_view('bill_7500_argo', $this->data);
        } elseif ($this->data['rs']->plan_total == 7665) {

            $this->load->front_view('bill_7665', $this->data);
        } elseif ($this->data['rs']->plan_total == 7000) {

            $this->load->front_view('bill_7000', $this->data);
        } elseif ($this->data['rs']->plan_total == 6500 and $this->data['rs']->package_name == 'POWER SAVER + SL COMBO') {

            $this->load->front_view('bill_6500_power', $this->data);
        } elseif ($this->data['rs']->plan_total == 6500) {

            $this->load->front_view('bill_6500', $this->data);
        } elseif ($this->data['rs']->plan_total == 9500) {

            $this->load->front_view('bill_9500', $this->data);
        } elseif ($this->data['rs']->plan_total == 3596) {

            $this->load->front_view('bill_3596', $this->data);
        } elseif ($this->data['rs']->plan_total == 5000) {

            $this->load->front_view('bill_5000', $this->data);
        } elseif ($this->data['rs']->plan_total == 4500) {

            $this->load->front_view('bill_4500', $this->data);
        }
    }
}
