<?php
/*
Web URL: www.rechargedaddy.in
Login ID:
Password:
*/

class Recharge
{
    protected $mobile;
    protected $provider;
    protected $circle;
    protected $number_type;

    protected $baseUrl = 'https://www.rechargedaddy.in/RDRechargeAPI/RechargeAPI.aspx';
    protected $apiKey = '';
    protected $regMobileNo = '';

    const SERVICE_CODE = 'SERCODE';
    const CUSTOMER_NUMBER = 'CUSTNO';
    const RECHARGE_AMOUNT = 'AMT';
    const DTH_REFNO = 'REFMOBILENO';

    protected $options;
    function __construct()
    {
        $this->options = array();
    }

    function setConfig($name, $value)
    {
        $this->options[$name] = $value;
    }

    function rechargeMobile()
    {
        $data = $this->options;
        $data['APIKey'] = $this->apiKey;
        $data['REQTYPE'] = 'RECH';
        $data['RESPTYPE'] = 'JSON';
        $data['REFNO'] = $data['CUSTNO'] . '_' . time();
        $data['STV'] = 0;
        $data['MobileNo'] = $this->regMobileNo;
        $str = '';
        foreach ($data as $key  => $val) {
            $str .= $key . '=' . $val . '&';
        }
        $post = rtrim($str, '&');
        return $this->execute($post);
    }

    function checkRechargeStatus($mobile, $refNo)
    {
        //https://www.rechargedaddy.in/RDRechargeAPI/RechargeAPI.aspx?MobileNo=[MobileNo]&APIKey=[APIKey]&REQTYPE=STATUS&REFNO=[APIRefNo]&RESPTYPE=JSON

        $options = array();
        $options['MobileNo'] = $mobile;
        $options['APIKey'] = $this->apiKey;
        $options['REQTYPE'] = 'RECH';
        $options['REFNO'] = $refNo;
        $options['RESPTYPE'] = 'JSON';
        $str = '';
        foreach ($options as $key  => $val) {
            $str .= $key . '=' . $val . '&';
        }
        $post = rtrim($str, '&');
        return $this->execute($post);
    }

    function execute($post)
    {
        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        return curl_exec($ch);
    }
}
