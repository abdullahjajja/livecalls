<?php
// Execute On Sunday 12 am Every Week
require_once ('mailer/class.phpmailer.php');
ini_set('memory_limit', '-1');
define('BASE_DIR', '');
define('WEBSITE_TITLE', 'LiveCalls/');
	  	
		email();

          exit;
		  
		  function email(){
    global $error;
	//$date= date('d/m/y');
	$fname='Weekly.csv';
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
    $mail->Subject = 'Livecalls Weekly Invoice Report Test';
    $mail->Body = 'Test Email from Livecalls Cron Job';
//	$mail->AddAttachment('/var/www/html/setmyleads/app/webroot/weekly.csv', $fname);
    //$mail->AddAddress('kashif.mustfa@techbridgeconsultancy.com');
    // $mail->AddAddress('admin@khalltelecom.net');
	$mail->AddAddress('shirjeel@techbridgeconsultancy.com');
    $mail->AddCC('awaisburki@gmail.com', 'Awais Khan');
    $mail->AddCC('awais.khan@techbridgeconsultancy.com', 'Awais Khan 2');

    if(!$mail->Send()){
      echo $mail->ErrorInfo;
        return false;
    }else{
      echo $mail->ErrorInfo;
        return true;
    }

   }
?>
