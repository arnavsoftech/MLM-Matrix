<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AI_Mail
{
    var $email_body;
    var $email_to, $email_to_name, $email_from, $email_subject;
    var $signature, $siteName;
    public static $_SITE_NAME = "The Smart Life";

    function __construct()
    {
        $this->signature = "<br />Regards<br />The Smart Life Team";
        $this->siteName = "The Smart Life";
    }

    function onSignup($first_name, $email_id, $username, $password)
    {
        $m = new Mail_Template();
        $m->setParam("first_name", $first_name);
        $m->setParam("username", $username);
        $m->setParam("password", $password);
        $link = site_url('verifyacc/?hash=' . md5($username) . '&key=' . $email_id);
        $str = "<p>Hello {first_name} <br /> Welcome to Dream Bits!  <br /><br />";
        $str .= 'Your account has been created. <br />';
        $str .= 'Your Username : {username} <br />Password : {password}';
        $str .= '<br />To complete your registration please click the following link to activate your account:';
        $str .= $link;
        $str .= $this->signature;

        $this->email_body = $m->htmlRender($str);
        $this->email_to = $email_id;
        $this->email_to_name = $first_name;
        $this->email_subject = "Account Registration with " . $this->siteName;
        return $this;
    }

    function activation($first_name, $email_id, $username, $password)
    {
        $m = new Mail_Template();
        $m->setParam("first_name", $first_name);
        $m->setParam("username", $username);
        $m->setParam("password", $password);

        $str = "<p>Hello {first_name} <br /> Welcome to Dream Bits!  <br /><br />";
        $str .= 'Your account has been Activated Successfully. <br />';
        $str .= 'Your Username : {username} <br />Password : {password}';

        // $str .= $link;
        $str .= $this->signature;

        $this->email_body = $m->htmlRender($str);
        $this->email_to = $email_id;
        $this->email_to_name = $first_name;
        $this->email_subject = "Account Activated with " . $this->siteName;
        return $this;
    }

    function onSuccessSignup($first_name, $email_id)
    {

        $m = new Mail_Template();
        $m->setParam("first_name", $first_name);

        $msg = "<p>Welcome to Dream Bits $first_name, <br />Your account is activated and ready to use.</p>";
        $msg .= "Please review our Terms of Service and Frequently Asked Questions.<br />If you have any questions please submit a support ticket.";
        $msg .= $this->signature;

        $this->email_body = $m->htmlRender($msg);
        $this->email_to = $email_id;
        $this->email_to_name = $first_name;
        $this->email_subject = "Account Created with " . $this->siteName;
        return $this;
    }

    function onDonationMode($first_name, $email_id, $type)
    {

        $m = new Mail_Template();
        $m->setParam("first_name", $first_name);

        $msg = '<p>Your ' . $type . ' details are updated Successfully,If u have not done kindly login to your account and change the password.</p>';

        $msg .= $this->signature;

        $this->email_body = $m->htmlRender($msg);
        $this->email_to = $email_id;
        $this->email_to_name = $first_name;
        $this->email_subject = "Modified " . $type . "  details" . $this->siteName;
        return $this;
    }

    function sendSponsorMsg($sponsor, $user, $email_id)
    {
        $user = (object) $user;

        $m = new Mail_Template();

        $msg =  "Hello $sponsor! <br />Thank you for supporting Dream Bits.<br />";
        $msg .= 'Member ' . $user->username . 'has just signed up as your level 1 referral! <br />';
        $msg .= 'Name: ' . $user->first_name . ' ' . $user->last_name . '<br />';
        $msg .= 'Email: ' . $user->email_id . '<br />';
        $msg .= 'Phone: ' . $user->mobile . '<br />';
        $msg .= $this->signature;

        $this->email_body = $m->htmlRender($msg);
        $this->email_to = $email_id;
        $this->email_to_name = $sponsor;
        $this->email_subject = "Referral Account Signup with " . $this->siteName;
        return $this;
    }

    function sendMail()
    {

        require_once APPPATH . 'third_party/phpmailer/src/Exception.php';
        require_once APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
        require_once APPPATH . 'third_party/phpmailer/src/SMTP.php';


        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'localhost';                    // Set the SMTP server to send through
        $mail->Username   = 'automail@thesmartlife.in';                     // SMTP username
        $mail->Password   = 'H{VezXj6tg8i';                               // SMTP password
        $mail->SMTPSecure = false;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 25;
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;

        //Recipients
        $mail->setFrom(SEND_EMAIL_FROM, SEND_EMAIL_FROM_NAME);
        $mail->addAddress($this->email_to, $this->email_to_name);               // Name is optional

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $this->email_subject;
        $mail->Body    = $this->email_body;
        $mail->send();

        //Reset Value;
        $this->email_to = $this->email_to_name = $this->email_subject = $this->email_body = $this->email_from = '';
    }

    function onContact($your_name, $subject, $email_id, $mobile_no, $message)
    {
        $m = new Mail_Template();
        $m->setParam("name", $your_name);
        $str = 'Enquiry through Website <br />
        Name :' . $your_name . '<br/>
        Subject: ' . $subject . '<br/>
        Mobile No:' . $mobile_no . '<br/>
        Email ID: ' . $email_id . '<br/>
        Message:  ' . $message;

        $this->email_body = $m->htmlRender($str);
        $this->email_to = 'info@originitsolution.com';
        $this->email_from = $email_id;
        $this->email_subject = "Contact Us Enquiry through thesmartlife.in";
        return $this;
    }

    function onResetPassword($name, $email, $password)
    {
        $m = new Mail_Template();
        $m->setParam("name", $name);
        $m->setParam("email", $email);
        $m->setParam("password", $password);

        $text = "Dear {name}<br />You have asked for password Reset. Here is your login details: <br />Email: {email} <br />Password: {password}<br />" . $this->signature;

        $this->email_body = $m->htmlRender($text);
        $this->email_to = $email;
        $this->email_to_name = $name;
        $this->email_subject = self::$_SITE_NAME . ": Reset Password";
        return $this;
    }

    function onSuccessResetPassword($name, $email)
    {
        $m = new Mail_Template();
        $m->setParam("name", $name);
        $m->setParam("email", $email);

        $text = "Dear {name}<br />Your password has been changed successfully. <br />" . $this->signature;

        $this->email_body = $m->htmlRender($text);
        $this->email_to = $email;
        $this->email_to_name = $name;
        $this->email_subject = self::$_SITE_NAME . ": Password Changed Successfully";
        return $this;
    }



    function sendTestMail()
    {
        $m = new Mail_Template();
        $m->setParam("name", "Test name");
        $m->setParam("email", "info@originitsolution.com");

        $text = "Dear Kamal <br />Test Emails <br />" . $this->signature;

        $this->email_body = $m->htmlRender($text);
        $this->email_to = "info@originitsolution.com";
        $this->email_to_name = "Origin IT Solution";
        $this->email_subject = self::$_SITE_NAME . ": Testing Email";
        $this->sendMail();
        echo 'Email Sent';
    }
}

class Mail_Template
{

    var $arr;

    public function __construct()
    {
        $this->arr = array();
    }

    public function setParam($name, $value)
    {
        $this->arr[$name] = $value;
    }

    public function htmlRender($template)
    {
        if (is_array($this->arr) && count($this->arr) > 0) {
            foreach ($this->arr as $key => $val) {
                $template = str_replace('{' . $key . '}', $val, $template);
            }
        }
        return $template;
    }

    function __destruct()
    {
        $this->arr = array();
    }
}
