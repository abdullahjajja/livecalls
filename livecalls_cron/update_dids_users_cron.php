<?php
// Execute On 12 am Every day

//die();
require_once ('mailer/class.phpmailer.php');
ini_set('memory_limit', '-1');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
//define('DB_PASSWORD', 'mypasswd');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');
define('SITE_URL', 'http://localhost/setmyleads/');
define('BASE_DIR', '');
define('WEBSITE_TITLE', 'LiveCalls/');


$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());

$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());


		$query2="
SELECT dids.`id` ,users.`email`,CONCAT( dids.`did`,'-----',numberranges.`name`) AS number,users.`id` AS uid FROM dids 
JOIN dids_users ON dids_users.`did_id`=dids.`id`
JOIN users ON users.`id`=dids_users.`superresseler_id`
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
WHERE dids_users.`superresseler_id`!=23 
AND users.`id`!=20
AND dids.`IsTestNumber`=0
AND (dids.`routing` IS NULL OR dids.`routing` !='IP' OR dids.`routing` ='MIVR' OR dids.`routing` ='IVR')
AND (dids_users.`modified` <= NOW() + INTERVAL -7 DAY)
AND((dids.`last_used`  <= NOW() + INTERVAL -7 DAY) OR  dids.`last_used` IS NULL)
ORDER BY users.`id`,dids.`numberrange_id`

	";
		$result2=mysql_query($query2) or die(mysql_error());
		
		$count=mysql_num_rows($result2);
		
		echo 'count ='.$count;
		
			
		$c=0;
		$email='';
		$uid;
		
		$dids='';
		$numberrange='';
		$date = date( 'Y-m-d H:i:s');
		while ( $r2 = mysql_fetch_array($result2)){
				if($email==$r2[1]){
										
					$dids.=$r2[2].'<br>';
				}else{
					if($c!=0){
							$body='Dear partner.<br> The following numbers have just been removed from your pool due to inactivity in the last 7 days.<br>
Thanks for understanding.<br> '.$dids;
							  $query = "INSERT INTO user_notifications (user_id,detail) VALUE($uid,'$body')";
                    mysql_query($query) or die(mysql_error());
							smtpmailer($email,$body);
							$dids='';
							
					}
					$uid=$r2[3];
					$email=$r2[1];
					$dids.=$r2[2].',';
				}
				
				$c++;
				$q10="UPDATE dids_users SET dids_users.`superresseler_id`=23,dids_users.resseller_id =0 ,dids_users.subresseller_id =0 ,dids_users.`modified`='$date' WHERE dids_users.`did_id`=".$r2[0];
			//echo  $r2[0]."<br>";
			mysql_query($q10) or die(mysql_error());
		
		
		}
		echo "<br><br> Final count =".$c;
		  function smtpmailer($emailTo, $body) {


    global $error;
	$subject='Livecalls Numbers Alert';
	//$emailTo='rameez931@gmail.com';

    $smtpSecurity       = "tls";
    $smtpHost           = 'smtp.gmail.com';
    $smtpPort           = 587;
    $smtpAuth           = true;
    $smtpDebug          = false;
    $user               = 'livecalls1@gmail.com';
    $password           = 'G+8~#\m+$5^5xsy';

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
    $mail->AddReplyTo('livecalls1@gmail.com');
    $mail->SetFrom('Live Calls <no-reply@livecalls.hk>');
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($emailTo);
//   $mail->AddAddress("rameez931@gmail.com"); 
// $mail->AddAddress("shirjeel@techbridgeconsultancy.com");
    if(!$mail->Send()){
//      echo $mail->ErrorInfo;
        return false;
    }else{
//        echo $mail->ErrorInfo;
        return true;
    }

   }
	

?>
