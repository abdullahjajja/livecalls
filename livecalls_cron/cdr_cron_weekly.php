<?php
// Execute On Sunday 12 am Every Week
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

$query5="SELECT users.id FROM users WHERE role_id=2 AND ((SELECT COUNT(*) FROM dids_users WHERE dids_users.`superresseler_id`=users.id) >0) ";
//echo $query5;
$result=mysql_query($query5) or die(mysql_error());
$usd=0;
		$gbp=0;
		$euro=0;
		$aa=-1;
	while ( $r = mysql_fetch_array($result)){
		//echo'id ='.$r[0].'<br>';
		
		$query2="
SELECT cdrs.`superresrate`, cdrs.`isdaily`, cdrs.superresseler_id, cdrs.destination_number, cdrs.`destination_number`,
ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration, 
ROUND(((ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2))* cdrs.`superresrate`),2) AS total , 
COUNT(cdrs.start_stamp) AS totatcalls, currencies.id AS currenciesid ,cdrs.`numberrange_name`  FROM cdrs
INNER JOIN users u1 ON cdrs.superresseler_id=u1.id
LEFT JOIN currencies ON currencies.id = cdrs.currency_id 
WHERE (cdrs.superresseler_id =".$r[0]." ) AND cdrs.start_stamp BETWEEN CURDATE()+INTERVAL -7 DAY AND SUBTIME( CONCAT(CURDATE(), ' 00:00:00'),'00:00:01') AND cdrs.`isdaily`=0 GROUP BY cdrs.`numberrange_name`,cdrs.`superresrate`,cdrs.`Addon`
		";
		$result2=mysql_query($query2) or die(mysql_error());
		
			
		$c=0;
		
		while ( $r2 = mysql_fetch_array($result2)){
				
				$r=$r2['superresrate'];
				if(!is_numeric( $r)){
				$r=0.0;
				}
				
				$d=$r2['duration'];
				if(!is_numeric( $d)){
				$d=0.0;
				}
				$sr=$r2['currenciesid'];
				if(!is_numeric( $sr)){
				$sr=0;
				}
				$nr=$r2['numberrange_name'];
				$nr = str_replace("'", "\'", $nr);				
				if($nr==' ' || $nr==null){
					$nr='Unknown';
				}
			
			$tp=$d*$r;
			
			if($sr==1){
				$usd=$usd + $tp;
			}
			if($sr==4){
				$gbp=$gbp + $tp;
			}
			if($sr==2){
				$euro=$euro + $tp;
			}
			
			
			//echo "OUT";
			if($c==0){
			//echo "<br>iN<br>";
				$c++;
				$q10="INSERT INTO `invoices`( `user_id`,`isdaily`) VALUES ({$r2['superresseler_id']},0) ";
			//echo  $q10;
			mysql_query($q10) or die(mysql_error());
			$invoice_id=mysql_insert_id();
				
				
				
			}
			
			$q7="INSERT INTO `invoice_details`( `invoice_id`, `currency_id`,  `minutes`, `rate`, `invoice_total`,`numberrange_name`) VALUES ({$invoice_id},{$sr},{$d},{$r},{$tp},'{$nr}') ";
		//	echo $q7;
		 mysql_query($q7) or die(mysql_error());
		
		}
		
		if($aa != $invoice_id){
			$aa = $invoice_id;
			echo 'invoice_id='.$invoice_id;
			//$iid=$invoice_id-1;
			if($invoice_id == '' || $invoice_id == null){
			
			}else{
		$q8="INSERT INTO `invoice_reports`( `invoice_id`, `total_usd`,`total_gbp`,`total_euro`) VALUES ({$invoice_id},{$usd},{$gbp},{$euro} )";
			echo $q8.'<br>';
			mysql_query($q8) or die(mysql_error());
			}
		 $usd=0;
		$gbp=0;
		$euro=0;
		}	
	}
//echo '<br>'.$query9.'<br>';
//mysql_query($query9) or die(mysql_error());


$query="select users.`login` as 'User Login', round (ir.total_usd ,2)AS 'Total USD',  ROUND (ir.total_euro ,2)  AS 'Total EURO',  ROUND (ir.total_gbp,2) AS 'Total GBP'  ,concat(users.`first_name`,' ',users.`last_name`) as 'User Name' ,users.`preference`,users.`email` from invoice_reports as ir
left JOIN invoices ON invoices.`id`=ir.invoice_id
left JOIN users ON users.id=invoices.`user_id`
where invoices.`date`>= curdate() and invoices.`isdaily`=0
ORDER BY users.`login` ASC";
$data=mysql_query($query);
while($r=mysql_fetch_array($data)){
//echo $r[0].' '.$r[1].'<br>';
send_email_to_user($r[0],$r[6]);
}
$nn=date('ymd');
 //$filename = "../livecalls/app/webroot/weekly.csv";
 $filename = "/var/www/html/setmyleads/app/webroot/weekly.csv";
   $csv_terminated = "\n";
          $csv_separator = ",";
          $csv_enclosed = '"';
          $csv_escaped = "\\";
          //echo ($query);
          $sql_query = $query;

          // Gets the data from the database
          $res = mysql_query($sql_query);
          $fp = fopen($filename, "w");


          // $fields_cnt = mysql_num_fields($result);
          // fetch a row and write the column names out to the file
          $row = mysql_fetch_assoc($res);
         // echo ($row);
		 
		 	$date= date('d/m/y');
		 $line="";
		  $comma = ",";
		   $line .=$date.' Weekly';
		    $line .= "\n";
          fputs($fp, $line);

          $line = "";
          $comma = ",";
          foreach ($row as $name => $value) {
               $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
               $comma = ",";
          }
          $line .= "\n";
          fputs($fp, $line);
          mysql_data_seek($res, 0);
		  
          while ($row = mysql_fetch_assoc($res)) {

               $line = "";
               $comma = ",";
               foreach ($row as $value) {
                    $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
                    $comma = ",";
               }
               $line .= "\n";

               fputs($fp, $line);
          }

          fclose($fp);
		  	
		email();

          exit;
		  
		  function email(){
    global $error;
	$date= date('d/m/y');
	$fname=$date.' Weekly.csv';
    $smtpSecurity       = "tls";
     $smtpHost           = 'khalltelecom.net';
    $smtpPort           = 587;
    $smtpAuth           = true;
    $smtpDebug          = true;
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
    $mail->Subject = 'Livecalls Weekly Invoice Report';
    $mail->Body = 'Download the attached csv file';
	$mail->AddAttachment('/var/www/html/setmyleads/app/webroot/weekly.csv', $fname);
    $mail->AddAddress('shirjeel@techbridgeconsultancy.com');
	$mail->AddAddress('admin@khalltelecom.net');
	$mail->AddCC('awaisburki@gmail.com', 'Awais Khan');

    if(!$mail->Send()){
      echo $mail->ErrorInfo;
        return false;
    }else{
      echo $mail->ErrorInfo;
        return true;
    }

   }

   function send_email_to_user($login, $emailid){
	
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
    $mail->Body = 'Hi '.$login.', Your weekly invoice for Livecalls has been created, Please visit livecalls.hk for more details.';
    $mail->AddAddress($emailid);
    $mail->AddBCC('admin@khalltelecom.net');
    $mail->AddBCC('shirjeel@techbridgeconsultancy.com');

	// $mail->AddAddress('admin@khalltelecom.net');

    if(!$mail->Send()){
      echo $mail->ErrorInfo;
        return false;
    }else{
      echo $mail->ErrorInfo;
        return true;
    }
	}
?>
