
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Import extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function uploadcsv()
    {
        $this->template = "category/import";
        $this->load->view("default", $this->data);
    }
    public function uploadData()
    {

        if ($this->input->post('submit')) {

            $path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;

                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(true, true, true, true);
                    $flag = true;
                    $i = 0;
                    foreach ($allDataInSheet as $value) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }
                        $inserdata[$i]['id'] = $value['A'];
                        $inserdata[$i]['userid'] = $value['A'];
                        $inserdata[$i]['first_name'] = $value['B'];
                        $inserdata[$i]['sponsor_id'] = $value['C'];
                        $inserdata[$i]['passwd'] = $value['D'];
                        $result = $this->db->insert('ai_users', $inserdata);
                        $i++;
                    }

                    if ($result) {
                        echo "Imported successfully";
                    } else {
                        echo "ERROR !";
                    }
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
        }
        $this->load->view('upload');
    }
}
?>
