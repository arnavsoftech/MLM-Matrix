<?php

date_default_timezone_set('Asia/Kolkata');

// Daily payments check and update
$url = 'https://www.thesmartlife.in/home/cron_payment_status_check';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

// Create payments to Users Daily
$url = 'https://www.thesmartlife.in/home/cron_jobs';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

// Enable Daily Payout
$url = 'https://www.thesmartlife.in/home/cron_daily_payout';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
