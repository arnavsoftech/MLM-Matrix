<?php
$config['company'] = "The Smartlife";
$config['company_email'] = 'info@thesmartlife.in';
$config['sms_config'] = array(
    'send_sms' => false, // false to disable sms
    'username' => 'seamoon',
    'password' => '851608',
    'senderid' => 'DAMOTP'
);
$config['user_perfix'] = 'SL';
$config['package'] = [
    '1000' => 'Basic(Rs 1000)',
    '1500' => 'Premium(Rs 1500)'
];
$config['random_id'] = false;

$config['min_withdraw_limit'] = 100;

// Jolosoft Transfer
$config['bank_transfer'] = false;
$config['jolo_test_mode'] = false;
$config['jolo_apikey'] = null;
$config['jolo_userid'] = null;
$config['jolo_callback'] = 'https://www.thesmartlife.in/home/jolo_callback';

// Manual Withdrawal Request
$config['manual_withdraw'] = true;

$config['admin_charge'] = 10; // In Percent
$config['tds_charge'] = 5; // In Percent
$config['extra_charge'] = 5; // In Percent

$config['direct_ids'] = array(2, 2, 4, 6, 10, 30, 55, 110);
$config['commission'] = array(50, 25, 25, 10, 20, 15, 15, 10);
