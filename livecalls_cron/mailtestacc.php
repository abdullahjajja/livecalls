<?php

require_once ('mailer/class.phpmailer.php');
ini_set('memory_limit', '-1');
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
    $user               = 'noreply@khalltelecom.net';
    $password           = 'noreply@livecalls@hk';

    $mail = new PHPMailer();                    //      create a new object
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