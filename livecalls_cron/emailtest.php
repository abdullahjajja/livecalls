<?php
require_once ('mailer/class.phpmailer.php');
ini_set('memory_limit', '-1');
define('DB_HOST', '192.168.1.106');
define('DB_USER', 'root');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');
define('SITE_URL', 'http://localhost/setmyleads/');
define('BASE_DIR', '');
define('WEBSITE_TITLE', 'LiveCalls/');


$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());

$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());

function send_email_to_user($emailid){
	echo $emailid;
	//$date= date('d/m/y');
	//$fname=$date.' Weekly.csv';
    $smtpSecurity       = "tls";
    $smtpHost           = 'khalltelecom.net';
    $smtpPort           = 587;
    $smtpAuth           = true;
    $smtpDebug          = 2;
    $user               = 'noreply@khalltelecom.net';
    $password           = 'noreply@livecalls@hk';

    $mail = new PHPMailer();                    //      create a new object
   // $mail->IsSMTP();                            //      enable SMTP
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
    $mail->Subject = 'Livecalls Weekly Invoice Report';
    $mail->Body = 'Hi,'.$emailid.' Your weekly invoice for Livecalls has been created, Please visit livecalls.hk for more details.';
    // $mail->AddAddress($emailid);
    //$mail->AddAddress("shirjeel@gmail.com");
    $mail->AddAddress("awais.khan@techbridgeconsultancy.com");
    $mail->AddAddress("shirjeel@techbridgeconsultancy.com");
    $mail->AddAddress("shirjeel_jamal@yahoo.com");
    $mail->AddAddress("sherjeel_jamal@hotmail.com");
    $mail->AddAddress("sherjeel_jamal@hotmail.com");
    $mail->AddAddress("awaisburki@outlook.com");
    $mail->AddBCC("awaisburki07@gmail.com");
	// $mail->AddAddress('admin@khalltelecom.net');

    if(!$mail->Send()){
      echo $mail->ErrorInfo;
        return false;
    }else{
      echo $mail->ErrorInfo;
        return true;
    }
	}
// $query="select users.`login` as 'User Login', round (ir.total_usd ,2)AS 'Total USD',  ROUND (ir.total_euro ,2)  AS 'Total EURO',  ROUND (ir.total_gbp,2) AS 'Total GBP'  ,concat(users.`first_name`,' ',users.`last_name`) as 'User Name' ,users.`preference`,users.`email` from invoice_reports as ir
// left JOIN invoices ON invoices.`id`=ir.invoice_id
// left JOIN users ON users.id=invoices.`user_id`
// where invoices.`date`>= curdate() and invoices.`isdaily`=0
// ORDER BY users.`login` ASC";

// $data=mysql_query($query);
// while($r=mysql_fetch_array($data)){
// 	send_email_to_user($r[6]);
// }
	//$arr = array("awaisburki07@gmail.com", "awaisburki@gmail.com", "shirjeel@techbridgeconsultancy.com");
send_email_to_user("awaisburki");
?>