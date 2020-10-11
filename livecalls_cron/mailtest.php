<?php

require_once ('mailer/class.phpmailer.php');
ini_set('memory_limit', '-1');
define('DB_HOST', '108.178.8.199');
define('DB_USER', 'root');
//define('DB_PASSWORD', 'mypasswd');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');
define('SITE_URL', 'http://localhost/setmyleads/');
define('BASE_DIR', '');
define('WEBSITE_TITLE', 'LiveCalls/');

email();
	function email(){
    global $error;
	$date= date('d/m/y');
	$fname='xlsx-test.xlsx';

    $smtpSecurity       = "tls";
    $smtpHost           = 'khalltelecom.net';
    $smtpPort           = 587;
    $smtpAuth           = true;
    $smtpDebug          = 2;
    $user               = 'access@khalltelecom.net';
    $password           = 'access@#Kh@11#$';

    $mail = new PHPMailer();                    //      create a new object
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    $mail->IsSMTP();                            //      enable SMTP
    $mail->CharSet      = "utf-8";              //      $mail->CharSet="windows-1251";
    $mail->SMTPDebug    = $smtpDebug;           //      debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth     = $smtpAuth;            //      authentication enabled
    $mail->SMTPSecure   = $smtpSecurity;        //      secure transfer enabled REQUIRED for Gmail
    $mail->Host         = $smtpHost;            //      $smtpHost;
    $mail->Port         = $smtpPort;            //      $smtpPort;
    $mail->Username     = $user;                //      $smtpUser;
    $mail->Password     = $password;            //      $smtpPassword;

    $mail->IsHTML(true);
    $mail->AddReplyTo('info@livecalls.com');
    $mail->SetFrom('no-reply@livecalls.com', 'Livecalls');
    $mail->Subject = 'hourly cdr access network log';
    $mail->Body = 'Download the attached excel file';
	//$mail->AddAttachment('../setmyleads/app/webroot/monthly.csv', $fname);
	$mail->AddAttachment('xlsx-test.xlsx', $fname);
    $mail->AddAddress('awaisburki@gmail.com');

    if(!$mail->Send()){
      echo '1';
        return false;
    }else{
     echo $mail->ErrorInfo;
	 echo 2;
        return true;
    }

   }
?>