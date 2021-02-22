<?php
function admin_url($file = '', $redirect = false)
{
    $url = site_url('admin');
    if ($file <> '') {
        $url .= '/' . $file;
    }
    if ($redirect) {
        $cur = urlencode(current_url());
        $url .= '?redirect_to=' . $cur;
    }
    return $url;
}

function admin_view($view = '')
{
    $path = config_item("admin_view");
    if ($view != '') {
        $path = $path . '/' . $view;
    }
    return $path;
}

function inr_rs($amt)
{
    return ' <i class="fa fa-inr"></i> ' . number_format($amt, 2);
}

function upload_dir($file = '')
{
    $f = config_item('upload_dir');
    return $f . '/' . $file;
}

function theme_url($file = '')
{
    $f = config_item('themes');
    $url = base_url('/ai-content/themes/' . $f . '/' . $file);
    return $url;
}

function theme_option($optname)
{
    $CI = &get_instance();
    $v = $CI->Setting_model->get_option_value($optname);
    return $v;
}

function getDayName($id)
{
    $arr = array(1 => 'Sun', 2 => 'Mon', 3 => 'Tue', 4 => 'Wed', 5 => 'Thu', 6 => 'Fri', 7 => 'Sat');
    return $arr[$id];
}

function getDayIndex($name)
{

    $arr = array(1 => 'Sun', 2 => 'Mon', 3 => 'Tue', 4 => 'Wed', 5 => 'Thu', 6 => 'Fri', 7 => 'Sat');
    $id = 0;
    foreach ($arr as $index => $d) {
        if ($name == $d) {
            $id = $index;
        }
    }
    return $id;
}

function is_login()
{
    if (isset($_SESSION['login']) && isset($_SESSION['login']['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function is_admin_login()
{
    if (isset($_SESSION['userid']) && $_SESSION['userid'] > 0) {
        return true;
    } else {
        return false;
    }
}


function id2userid($id)
{
    $prefix = config_item('user_perfix');
    $sid = $prefix .  str_pad($id, 4, '0', STR_PAD_LEFT);
    return $sid;
}

function userid2id($sid)
{
    $prefix = config_item('user_prefix');
    $sid = substr($sid, strlen($prefix));
    return intval($sid);
}


function user_id()
{
    return $_SESSION['login']['user_id'];
}



function is_home()
{
    if (current_url() == site_url()) {
        return true;
    } else {
        return false;
    }
}

function human_timing($time)
{
    $time = strtotime($time);
    $time = time() - $time; // to get the time since that moment
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '') . ' ago';
    }
}


function sendSMS($to, $msg)
{
    $smsConfig = config_item('sms_config');
    $msg = urlencode($msg);
    $username = $smsConfig['username'];
    $password = $smsConfig['password'];
    $sender = $smsConfig['senderid'];
    if ($smsConfig['send_sms']) {
        $url = "http://www.anysms.in/api.php?username=$username&password=$password&sender=$sender&sendto=$to&message=$msg";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}

function get_cashback_rate($provider, $level)
{
    $rates = config_item('rates');
    $item = $rates[$provider];
    return $item[$level];
}

function noOfDays($oldDate)
{
    $d1 = new DateTime($oldDate);
    $d2 = new DateTime();

    $d3 = $d2->diff($d1);
    return $d3->days * ($d3->invert == 0 ? 1 : -1);
}

require 'AI_Email.php';
require 'AI_Product.php';
require 'Recharge.php';
require 'RestApi.php';
