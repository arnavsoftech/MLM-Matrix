<?php

defined('BASEPATH') or exit('No direct script access allowed');
$config['upload_dir'] = "ai-content/uploads";
$config['admin']      = 'admin';
$config['themes']     = "krs";

$config['layouts'] = array(
    'page'  => array(
        'page'    => 'Default Page',
        'contact' => "Contact us",
    ),

    'posts' => array(
        'single' => 'Default',
    ),
);

$config['pay_status'] = array(
    0 => 'Pending',
    1 => 'Approved',
    2 => 'Rejected',
);

//for recaptch v3
define('GOOGLE_SITE_KEY', '6LdKB8MUAAAAAJee_MIbRLkgCu6-TGxFrEfSDuMG');
define('GOOGLE_SECRET_KEY', '6LdKB8MUAAAAANxYYT2jK3oDeRE5ubgcQeyHEWcw');

$config['commission'] = array(20, 10, 7, 3, 2, 2, 2, 2, 2);
$config['autofill']   = array(1000, 1000, 1000, 1400, 1400, 2000, 2000, 4000, 4000, 14000, 30000, 40000, 60000, 100000, 800000);

$config['rank'] = array(
    array('Siler', 5000),
    array('Gold', 10000),
    array('Platinum', 15000),
    array('Sapphire', 25000),
    array('Pearl', 100000),
    array('Emrald', 250000),
    array('Blue Diamond', 525000),
);


$config['rates'] = array(
    "RJ" => array(3, 5, 4.50, 4.75, 5.00, 5.25, 5.50, 5.75, 6.00),
    "AR" => array(2, 2.50, 2.60, 2.70, 2.80, 2.90, 3.00, 3.10, 3.20),
    "VF" => array(1, 1.50, 1.60, 1.70, 1.80, 1.90, 2.00, 2.10, 2.20),
    "TD" => array(2, 2.50, 2.60, 2.70, 2.80, 2.90, 3.00, 3.10, 3.20),
    "MTS" => array(2, 2.50, 2.60, 2.70, 2.80, 2.90, 3.00, 3.10, 3.20),
    "ID" => array(1, 1.50, 1.60, 1.70, 1.80, 1.90, 2.00, 2.10, 2.20),
    "BS" => array(2, 2.50, 2.60, 2.70, 2.80, 2.90, 3.00, 3.10, 3.20),
);
