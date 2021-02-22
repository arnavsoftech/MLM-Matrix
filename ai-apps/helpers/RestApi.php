<?php

class RestApi
{

    var $status;
    var $data;
    var $message;
    var $fields;
    const API_OK = true;
    const API_ERROR = false;

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->status = RestAPI::API_ERROR;
        $this->message = "";
        $this->data = array();
        $this->fields = '';
    }

    function setMessage($msg)
    {
        $this->message = $msg;
    }

    function setData($data)
    {
        $this->data = $data;
    }

    function setOK()
    {
        $this->status = RestAPI::API_OK;
    }

    function setError()
    {
        $this->status = RestAPI::API_ERROR;
    }

    function missing()
    {
        $this->setMessage("Required Parameter Missing");
    }

    function render()
    {
        echo json_encode($this, JSON_PRETTY_PRINT);
    }

    function check($keys = array())
    {
        $this->fields = implode(',', $keys);
        $flag = true;
        if (count($keys) > 0) {
            foreach ($keys as $key) {
                if (!isset($_GET[$key])) {
                    $flag = false;
                }
            }
        }
        return $flag;
    }
}
