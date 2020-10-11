<?php
class GCMPushMessage {

	var $url = 'https://android.googleapis.com/gcm/send';
	var $serverApiKey = "";
	var $devices = array();
	
	/*
		Constructor
		@param $apiKeyIn the server API key
	*/
	function GCMPushMessage($apiKeyIn){
		$this->serverApiKey = $apiKeyIn;
	}

	/*
		Set the devices to send to
		@param $deviceIds array of device tokens to send to
	*/
	function setDevices($deviceIds){
	
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	
	}

	/*
		Send the message to the device
		@param $message The message to send
		@param $data Array of data to accompany the message
	*/
	function send($message, $data = false){
		
		if(!is_array($this->devices) || count($this->devices) == 0){
			$this->error("No devices set");
		}
		
		if(strlen($this->serverApiKey) < 8){
			$this->error("Server API Key not set");
		}
		
		$fields = array(
			'registration_ids'  => $this->devices,
			'data'              => array( "message" => $message ),
		);
		
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$fields['data'][$key] = $value;
			}
		}

		$headers = array( 
			'Authorization: key=' . $this->serverApiKey,
			'Content-Type: application/json'
		);

		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
	function error($msg){
		echo "Android send notification failed with error:";
		echo "\t" . $msg;
		exit(1);
	}
}

class ApiController extends AppController {

//var $name = 'Apis';
     var $uses = array('UserNotification', 'Ivrs', 'Didrate', 'OperatorInvoice', 'Profit', 'ProfitDetail', 'OperatorInvoiceDetail', 'Invoice', 'InvoiceDetail', 'Currency', 'Did', 'DidsUser', 'Numberrange', 'Operator', 'Routetype', 'User', 'Channel', 'Cdr', 'News');
     var $helpers = array('Html');
     var $components = array('Email');

//App::import('Controller', 'reports');

     function beforeFilter() {
          parent::beforeFilter();
          $this->Auth->allow('change_status');
          //$this->Auth->allow('GetInvoiceDetail');
          ini_set('memory_limit', '-1');
     }

     function export_operators_weekly_report() {

          // echo "download entered"   ;
          //exit;
          // $file1 = $_GET['cid'];
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          $FirstDay = 0;


          // $sd = date("Y-m-d", strtotime("last Monday")) . ' 00:00:00';
          // $ed = date("Y-m-d", strtotime("last Sunday")) . ' 23:59:59';
          $d = new DateTime();
/*          $weekday = $d->format('m');
          $diff = 7 + ($weekday == 0 ? 6 : $weekday - 1); // Monday=0, Sunday=6
          $d->modify("-$diff day");
          $startdate=$d->format('Y-m-d');
          $d->modify('+6 day');
          $enddate=$d->format('Y-m-d');
*/          
          
          $latest_filename = 'operators_monthly_report.csv';
          $downloadfilename= 'operators_monthly_report_'. date('M', strtotime("last month")).'.csv';
//          echo $file;
          $file = "../../app/webroot/" . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$downloadfilename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function export_users_weekly_report() {

          // echo "download entered"   ;
          //exit;
          // $file1 = $_GET['cid'];
          $this->autoRender = false;

          //$sd = date("Y-m-d", strtotime("last Monday")) . ' 00:00:00';
          //$ed = date("Y-m-d", strtotime("last Sunday")) . ' 23:59:59';
          $d = new DateTime();
          $weekday = $d->format('w');
          $diff = 7 + ($weekday == 0 ? 6 : $weekday - 1); // Monday=0, Sunday=6
          $d->modify("-$diff day");
          $sd = $d->format('Y-m-d') . ' 00:00:00';
          $startdate=$d->format('Y-m-d');
          $d->modify('+6 day');
          $enddate=$d->format('Y-m-d');
          $ed = $d->format('Y-m-d') . ' 23:59:59';



          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          $query = "SELECT  users.`login`,CONCAT(users.`first_name`,' ',users.`last_name`) AS 'user name',
cdrs.`numberrange_name`,ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration, 
currencies.`currency_name` AS 'Currency', cdrs.`superresrate` AS 'Rate'  FROM cdrs
INNER JOIN dids d ON cdrs.`destination_number`=d.`did`
INNER JOIN users ON users.`id`=cdrs.`superresseler_id`
INNER JOIN currencies ON currencies.`id` = cdrs.`currency_id`
INNER JOIN numberranges ON numberranges.`id`=d.`numberrange_id`
WHERE (cdrs.superresseler_id IN(SELECT users.id FROM users WHERE role_id=2 )) AND cdrs.`isdaily`=0 AND cdrs.start_stamp BETWEEN '$sd' AND '$ed'
 GROUP BY users.`login`,d.`numberrange_id`,cdrs.`superresrate` ASC
 ORDER BY users.`login` ASC ,currencies.`currency_name` ASC , cdrs.`numberrange_name` ASC ,duration DESC";
          //   echo $query;
          $data = mysql_query($query) or mysql_error();
          $c = mysql_num_rows($data);
          // echo $query;
          //echo $c;
          if ($c == 0) {
               //return;
               //die();
          }
          $nn = date('ymd');
          // $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/weekly.csv";
          $filename = "../../app/webroot/users_weekly_report.csv";



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


          $line = "";
          $comma = ",";
          $line .= "\n";
          // fputs($fp, $line);

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
          //echo $filepath;
          //  $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/numberranges.csv";
          //echo $file;exit;
          // $file = "../app/webroot/numberranges.csv";
          $latest_filename = 'users_weekly_report.csv';
          $downloadfilename= 'users_weekly_report_'.$startdate.'_to_'.$enddate.'.csv';
//          echo $file;
          $file = "../../app/webroot/" . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$downloadfilename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function export_users() {

          if ($this->Auth->User('role_id') != 1) {
               die();
          }
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          $query = "SELECT login,users.`password`,first_name, last_name ,email ,skype ,users.`add_on`,created , modified FROM users ";
          $query2 = "
               SELECT login,'password',first_name, last_name ,email ,skype ,`add_on`,`created`,`preference`,MAX(USD) AS USD,MAX(EURO) AS  EURO,MAX(GBP) AS GBP ,w AS 'WesternUnion/MoneyGram Detail',p AS 'Payoneer Detail'
FROM (SELECT login,users.`password`,first_name, last_name ,email ,skype ,users.`add_on`,users.`created`,users.`preference`,
(
    CASE
        WHEN  payoneer_users.`status`=2 THEN CONCAT(payoneer_users.name,'|',payoneer_users.`card_number`)

        ELSE ''
    END) AS p,
 (
	CASE
	WHEN wire_users.`status`=2 THEN CONCAT(wire_users.`name`,'|',wire_users.`mobile_number`,'|',wire_users.`city_name`,'|',wire_users.`country_name`)
	ELSE ''
	END
)   AS w,
(
    CASE
        WHEN accounts_users.`currency_id`=4 && accounts_users.`status`=2 THEN CONCAT(accounts_users.`bank_address`,'|',accounts_users.`bank_name`,'|',accounts_users.`account_number`,'|',accounts_users.`swift_code`)
        ELSE ''
    END) AS USD,
  (
    CASE
        WHEN accounts_users.`currency_id`=2 && accounts_users.`status`=2 THEN  CONCAT(accounts_users.`bank_address`,'|',accounts_users.`bank_name`,'|',accounts_users.`account_number`,'|',accounts_users.`swift_code`)
        ELSE ''
    END) AS EURO,
 (
    CASE
        WHEN accounts_users.`currency_id`=1 && accounts_users.`status`=2 THEN CONCAT(accounts_users.`bank_address`,'|',accounts_users.`bank_name`,'|',accounts_users.`account_number`,'|',accounts_users.`swift_code`)
        ELSE ''
    END) AS GBP
FROM users
JOIN accounts_users ON accounts_users.`user_id`=users.`id`
JOIN payoneer_users ON payoneer_users.`user_id`=users.`id`
JOIN wire_users ON wire_users.`user_id`=users.`id`

WHERE users.`id` IN (SELECT id FROM users WHERE role_id=2) )AS tt GROUP BY login
                    ";
          $data = mysql_query($query2) or mysql_error();

          $nn = date('ymd');
          // $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/weekly.csv";
          $filename = "../../app/webroot/users.csv";



          $csv_terminated = "\n";
          $csv_separator = ",";
          $csv_enclosed = '"';
          $csv_escaped = "\\";
          //echo ($query);
          $sql_query = $query2;

          // Gets the data from the database
          $res = mysql_query($sql_query);
          $fp = fopen($filename, "w");


          // $fields_cnt = mysql_num_fields($result);
          // fetch a row and write the column names out to the file
          $row = mysql_fetch_assoc($res);
          // echo ($row);


          $line = "";
          $comma = ",";
          $line .= "\n";
          // fputs($fp, $line);

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
          //echo $filepath;
          //  $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/numberranges.csv";
          //echo $file;exit;
          // $file = "../app/webroot/numberranges.csv";
          $latest_filename = 'users.csv';
//          echo $file;
          $file = "../../app/webroot/" . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function export_numberranges() {

          // echo "download entered"   ;
          //exit;
          // $file1 = $_GET['cid'];
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          $query = "SELECT  numberranges.`name` , route , ivrpath , currencies.`currency_name` , clilimit , buyingrate ,dailyrate, sellingrate AS 'Weekly Rate', `monthlyrate` AS 'Monthly Rate', maxduration , calllimit , maxdailyminutes,DATE(numberranges.`created`) AS 'Creation Date' FROM numberranges
JOIN currencies ON currencies.`id`=numberranges.`currency_id` ORDER BY numberranges.`name` ";
          $data = mysql_query($query) or mysql_error();

          $nn = date('y-m-d ');
          // $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/weekly.csv";
          $filename = "../../app/webroot/" . $nn . "numberranges.csv";



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


          $line = "";
          $comma = ",";
          $line .= "\n";
          // fputs($fp, $line);

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
          //echo $filepath;
          //  $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/numberranges.csv";
          //echo $file;exit;
          // $file = "../app/webroot/numberranges.csv";
          $latest_filename = $nn . 'numberranges.csv';
//          echo $file;
          $file = "../../app/webroot/" . $nn . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function export_dids() {

          
          $this->autoRender = false;

          $path = WWW_ROOT;
    
          $query = "SELECT numberranges.`name` AS 'Range Name', did AS 'Did',numberranges.`buyingrate` AS 'Buying Rate', numberranges.`sellingrate` AS 'Selling Rate', IsTestNumber AS 'Test Number',mincallduration AS 'Minimum Call Duration',perclilimit,dids.maxdailyminutes AS 'Max Daily Minutes',
ivr_id AS 'IVR',routing AS 'Routing' FROM dids
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
ORDER BY dids.id DESC";
          $data = mysql_query($query) or mysql_error();

          $nn = date('y-m-d ');
          $filename = "../../app/webroot/" . $nn . "dids.csv";

          $csv_terminated = "\n";
          $csv_separator = ",";
          $csv_enclosed = '"';
          $csv_escaped = "\\";
          $sql_query = $query;
          // Gets the data from the database
          $res = mysql_query($sql_query);
          $fp = fopen($filename, "w");
          $row = mysql_fetch_assoc($res);
         
          $line = "";
          $comma = ",";
          $line .= "\n";
       
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
         
          $latest_filename = $nn . 'dids.csv';
//          echo $file;
          $file = "../../app/webroot/" . $nn . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function export_ratecard_pdf() {
          $this->autoRender = false;
          //$latest_filename = '/livecalls/app/webroot/ratecard.pdf';
          $latest_filename = 'ratecard.pdf';
          // var_dump(is_file($latest_filename)) . "\n";
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: application/pdf");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists" . $latest_filename;
               return;
          }
     }

     function export_ratecard() {

          // echo "download entered"   ;
          //exit;
          // $file1 = $_GET['cid'];
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          $query = "SELECT numberranges.`name` AS Numberrange ,did AS TestNumber ,
currencies.`currency_name` AS Currency ,numberranges.`maxdailyminutes`,
numberranges.`sellingrate` AS WeeklyRate, numberranges.`dailyrate` AS DailyRate, numberranges.monthlyrate As MonthlyRate 
FROM dids
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
JOIN currencies ON currencies.`id`=numberranges.`currency_id`
WHERE dids.`IsTestNumber`=1 ORDER BY numberranges.`name`";
          $data = mysql_query($query) or die(mysql_error());

          $nn = date('ymd');
          // $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/weekly.csv";
          $filename = "../../app/webroot/ratecard.csv";



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


          $line = "";
          $comma = ",";
          $line .= "\n";
          // fputs($fp, $line);

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
          //echo $filepath;
          //  $file = $_SERVER['SERVER_ADDR'] . "/livecalls/app/webroot/numberranges.csv";
          //echo $file;exit;
          // $file = "../app/webroot/numberranges.csv";
          $latest_filename = 'ratecard.csv';
//          echo $file;
          $file = "../../app/webroot/" . $latest_filename;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function get_notification_count() {
          $this->autoRender = false;
          if ($this->Auth->User('role_id') == 1) {
               $query = "SELECT COUNT(*) FROM notifications WHERE statusid=1";
               $res = mysql_query($query) or die(mysql_error());
               $data = mysql_fetch_array($res);
               return $data[0];
          }
          if ($this->Auth->User('role_id') == 2) {
               $query = "SELECT COUNT(*) FROM user_notifications WHERE status=1 and user_id=" . $this->Auth->user('id');
               $res = mysql_query($query) or die(mysql_error());
               $data = mysql_fetch_array($res);
               return $data[0];
          }
     }

     function notification_reject() {
          $this->autoRender = false;
          if (isset($_REQUEST['id'])) {
               $query = "UPDATE notifications SET notifications.`statusid`=3 WHERE notifications.`id`=" . $_REQUEST['id'];
               mysql_query($query) or die(mysql_error());
          }
     }

     function notification_assign() {
          $limit = 3;
          $isdaily = 0;
          $user_n = array();
          $this->Email->smtpOptions = array(
             'port' => '25',
              'timeout' => '100',
              'host' => 'khalltelecom.net',
              'username' => 'noreply@khalltelecom.net',
              'password' => 'no@reply@khall',
          );
          $this->autoRender = false;
          //  die(print_r($_REQUEST));
          if (isset($_REQUEST['n_id'])) {
               $numberrange_id = $_REQUEST['n_id'];
               $isdaily = $_REQUEST['isdaily'];
          } else {
               echo "1 Not Working . ";
               return;
          }
          if (isset($_REQUEST['isdaily'])) {

               $isdaily = $_REQUEST['isdaily'];
          } else {
               echo "2 Not Working .";
               return;
          }
          if (isset($_REQUEST['u_id'])) {

               $user_id = $_REQUEST['u_id'];
          } else {
               echo "3 Not Working .";
               return;
          }





          $query = "SELECT dids.`id` FROM numberranges
                    JOIN dids ON dids.`numberrange_id`=numberranges.`id`
                    JOIN dids_users ON dids_users.`did_id`=dids.`id`
                    WHERE dids_users.`superresseler_id`=23 AND numberranges.`id`=" . $numberrange_id . " AND dids.`IsTestNumber`=0";

          //   $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
          //  $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $did));
          //  $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
          //  $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $did));
          $call = mysql_query($query) or die(mysql_error());
          $res = '';
          $a = mysql_fetch_assoc($call);
          //  print_r($a);
          $count = 0;
          if (count($call) > 0) {
               while (($c = mysql_fetch_array($call)) && ($count < $limit)) {


                    //   echo $c[0];
                    $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $c[0]));
                    $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $c[0]));
                    $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
                    $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $c[0]));
                    if ($objupdate) {
                         $objupdate['DidsUser']['superresseler_id'] = $user_id;
                         $objupdate['DidsUser']['resseller_id'] = 0;
                         $objupdate['DidsUser']['subresseller_id'] = 0;
                         $objupdate['DidsUser']['isdaily'] = $isdaily;
                         $objupdate['DidsUser']['modified'] = date('Y-m-d H:i:s');

                         if ($isdaily == 1) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['daily_title'];
                         } else if ($isdaily == 0) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['weekly_title'];
                         } else if ($isdaily == 2) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['monthly_title'];
                         }


                         $this->DidsUser->save($objupdate);

                         $objdidupdate['Did']['ivr_id'] = 'Punjabi_IVR.wav';
                         if ($objupdate['DidsUser']['superresseler_id'] == $user_id) {
                              if ($isdaily == 1) {
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Daily , payout: ' . $objNumberRange['Numberrange']['dailyrate'] . ')';
                              } else if ($isdaily == 0) {
                                   // $user_n[] = $objdidupdate['Did']['did'];
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Weekly , payout: ' . $objNumberRange['Numberrange']['sellingrate'] . ')';
                              } else if ($isdaily == 2) {
                                   // $user_n[] = $objdidupdate['Did']['did'];
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Monthly , payout: ' . $objNumberRange['Numberrange']['monthlyrate'] . ')';
                              }
                         }
                         $this->Did->save($objdidupdate);

                         if ($objRateupdate) {


                              if ($isdaily == 1) {

                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];
                              } else if ($isdaily == 0) {
                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                              } else if ($isdaily == 2) {
                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                              }
                              // die(print_r($objNumberRange));
                              $objRateupdate['Didrate']['admin_currency'] = $objNumberRange['Numberrange']['currency_id']; ///////
                              $objRateupdate['Didrate']['supres_currency'] = $objNumberRange['Numberrange']['currency_id'];

                              // die(print_r($objRateupdate));
                              $this->Didrate->save($objRateupdate);
                         } else {
                              $objDidRate = $this->Didrate->create();
                              $objDidRate['Didrate']['did_id'] = $c[0];
                              if ($isdaily == 1) {

                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];
                              } else if ($isdaily == 0) {
                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                              } else if ($isdaily == 2) {
                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                              }

                              $objDidRate['Didrate']['ressellerrate'] = 'NULL';
                              $objDidRate['Didrate']['subresrate'] = 'NULL';
                              $objDidRate['Didrate']['assignedBy'] = $this->Auth->User('id');
                         }
                    } else {
                         echo 'Unable to Assign ';
                    }

                    $count++;
               }
               if ($count == 0) {

                    echo'No number Avalible in this range .';
               } else {
                    $query = "UPDATE notifications SET notifications.`statusid`=2 WHERE notifications.`user_id`=" . $user_id . " AND notifications.`numberrange_id`=" . $numberrange_id;
                    mysql_query($query) or die(mysql_error());
                    $mes = ' Following numbers have been assigned to your account<br>';
                    foreach ($user_n as $number) {
                         $mes.= $number . '<br/> ';
                    }

                    $query = "INSERT INTO user_notifications (user_id,detail) VALUE($user_id,'$mes')";
                    mysql_query($query) or die(mysql_error());
                    $user = $this->User->find('first', array('conditions' => 'User.id=' . $user_id));
                    $nr = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $numberrange_id));
                    $this->set('name', $nr);
                    $this->set('user', $user);
                    $this->set('numbers', $user_n);
                    $this->Email->to = $user['User']['email'];
                    $this->Email->bcc = array('hklivecalls@gmail.com');
                    $this->Email->subject = 'New Assigned Numbers';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <noreply@khalltelecom.net>';
                    $this->Email->template = 'new_numbers_assign'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    echo 'Successfully Assign ' . $count . ' Numbers . ' . $user['User']['email'];
                    return;
                    echo 'Successfully Assign ' . $count . ' Numbers . ';
               }
               //echo $res;
          } else {
               echo'All Number are Assigned.';
          }
     }

     function auto_assign() {
     	
     	  $limit = 0;
          $isdaily = 0;
          $userid = $this->Auth->User('id');
          $this->Email->smtpOptions = array(
              'port' => '25',
              'timeout' => '100',
              'host' => 'khalltelecom.net',
              'username' => 'noreply@khalltelecom.net',
              'password' => 'no@reply@khall',
          );
          
         
          $this->autoRender = false;
          //  die(print_r($_REQUEST));
          if (isset($_REQUEST['n_id'])) {
               $numberrange_id = $_REQUEST['n_id'];
               // $isdaily = $_REQUEST['isdaily'];
          } else {
               echo "1 Not Working . Kindly Contact System Administrator";
               return;
          }
          if (isset($_REQUEST['isdaily'])) {

               $isdaily = $_REQUEST['isdaily'];
          } else {
               echo "2 Not Working . Kindly Contact System Administrator";
               return;
          }
          if (isset($_REQUEST['name'])) {

               $name = $_REQUEST['name'];
          } else {
               echo "2 Not Working . Kindly Contact System Administrator";
               return;
          }

          if ($this->Auth->User('user_type_id') == 1) {
               $limit = 3;
          }
          if ($this->Auth->User('user_type_id') == 2) {
               $limit = 5;
          }

          $query2 = "SELECT COUNT(*) FROM dids_users
          JOIN dids ON dids.`id`=dids_users.`did_id`
          JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
          WHERE dids_users.`superresseler_id`=" . $this->Auth->User('id') . " AND numberranges.`id`=" . $numberrange_id;
          $a = mysql_query($query2) or die(mysql_error());
          $res = mysql_fetch_array($a);
          if ($this->Auth->User('user_type_id') == 3) {
               if ($res[0] < 10) {
                    $limit = 10;
               }if ($res[0] >= 10 && $res[0] < 15) {
                    $limit = 5;
               } if ($res[0] >= 15) {
                    $uid = $this->Auth->User('id');
                    $query = "INSERT INTO notifications (user_id,numberrange_id,isdaily,assign_total) VALUE($uid,$numberrange_id,$isdaily,$res[0])";
                    mysql_query($query) or die(mysql_error());
                    echo "You already have " . $res[0] . " Numbers Of " . $name . " Range. Your's request for numbers is sent to admin.\n Your request will be process as soon as possible";
                   $query3 = "select deviceid from registration_ids";
                  $data = mysql_query($query3);
            if (!empty($data)) {
                $devices = array(); 
                $i=0;
                 while($row=mysql_fetch_array($data,MYSQL_NUM)){
              	$devices[$i]=$row[0];
             	$i++;
             }
                    $username=$this->Auth->User('login');
                  $messageNotify = $username." has requested numbers from ". $name . ". ".$username." has already assigned ".$res[0]." numbers";
                    
                    $apiKey = "AIzaSyAggctlVGdYwSJ2eMNLMOwM5pvqGfO-X1U";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($messageNotify, array('title' => 'Request for Number assignment'));
                    
                    }
                    
                    return;
               }
          } else {
               if ($res[0] >= $limit) {
                    $uid = $this->Auth->User('id');
                    $query = "INSERT INTO notifications (user_id,numberrange_id,isdaily,assign_total) VALUE($uid,$numberrange_id,$isdaily,$res[0])";
                    mysql_query($query) or die(mysql_error());
                    echo "You already have " . $res[0] . " Numbers Of " . $name . " Range. Your's request for numbers is sent to admin.\n Your request will be process as soon as possible";
            
                     $query3 = "select deviceid from registration_ids";
                  $data = mysql_query($query3);
            if (!empty($data)) {
                $devices = array(); 
                $i=0;
                 while($row=mysql_fetch_array($data,MYSQL_NUM)){
              	$devices[$i]=$row[0];
             	$i++;
             }
                     $username=$this->Auth->User('login');
                  $messageNotify = $username." has requested numbers from ". $name . ". ".$username." has already assigned ".$res[0]." numbers";
                    
                    $apiKey = "AIzaSyAggctlVGdYwSJ2eMNLMOwM5pvqGfO-X1U";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($messageNotify, array('title' => 'Request for Number assignment'));
               }     
                    return;
               }
          }

          $query = "SELECT dids.`id` FROM numberranges
                    JOIN dids ON dids.`numberrange_id`=numberranges.`id`
                    JOIN dids_users ON dids_users.`did_id`=dids.`id`
                    WHERE dids_users.`superresseler_id`=23 AND numberranges.`id`=" . $numberrange_id . " AND dids.`IsTestNumber`=0";

          //   $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
          //  $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $did));
          //  $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
          //  $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $did));
          $call = mysql_query($query) or die(mysql_error());
          $res = '';
          $a = mysql_fetch_assoc($call);
          //  print_r($a);$userid
          $count = 'c' . $userid;
          $count = 0;
          $user_n = 'u' . $userid;
          $dids_List="";
          $user_n = array();
          if (count($call) > 0) {
               while (($c = mysql_fetch_array($call)) && ( $count < $limit)) {


                    //   echo $c[0];
                    $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $c[0]));
                    $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $c[0]));
                    $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
                    $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $c[0]));
                    if ($objupdate) {
                         $objupdate['DidsUser']['superresseler_id'] = $this->Auth->User('id');
                         $objupdate['DidsUser']['resseller_id'] = 0;
                         $objupdate['DidsUser']['subresseller_id'] = 0;
                         $objupdate['DidsUser']['isdaily'] = $isdaily;
                         $objupdate['DidsUser']['modified'] = date('Y-m-d H:i:s');

                         if ($isdaily == 1) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['daily_title'];
                         } else if ($isdaily == 0) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['weekly_title'];
                         } else if ($isdaily == 2) {
                              $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['monthly_title'];
                         }


                         App::import('Helper', 'getcurrency'); // loadHelper('Html'); in CakePHP 1.1.x.x
                         $getcurrency = new getcurrencyHelper();
                         $cc = $objNumberRange['Numberrange']['currency_id'];
                         $curname = $getcurrency->getcurrencyNameById($cc);

                         if ($objupdate['DidsUser']['superresseler_id'] == $userid) {
                              if ($isdaily == 1) {
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Daily , payout: ' . $objNumberRange['Numberrange']['dailyrate'] . ')' . $curname;
                              } else if ($isdaily == 0) {
                                   // $user_n[] = $objdidupdate['Did']['did'];
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Weekly , payout: ' . $objNumberRange['Numberrange']['sellingrate'] . ')' . $curname;
                              } else if ($isdaily == 2) {
                                   // $user_n[] = $objdidupdate['Did']['did'];
                                   $user_n[] = $objdidupdate['Did']['did'] . ' ' . $objNumberRange['Numberrange']['name'] . '(Billing Period : Monthly , payout: ' . $objNumberRange['Numberrange']['monthlyrate'] . ')' . $curname;
                              }
                         }
                         $this->DidsUser->save($objupdate);
						 if($objNumberRange['Numberrange']['ivrpath'] != NULL) {
							//echo $objNumberRange['Numberrange']['ivrpath'];exit;
							$objdidupdate['Did']['ivr_id'] = $objNumberRange['Numberrange']['ivrpath'];
						} else {
							//echo "i am in else";exit;
							$objdidupdate['Did']['ivr_id'] = 'TeachYourselfEnglishINTHECITY.wav';
						}
                        // $objdidupdate['Did']['ivr_id'] = 'Punjabi_IVR.wav';

                         $this->Did->save($objdidupdate);

                         if ($objRateupdate) {


                              if ($isdaily == 1) {

                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];
                              } else if ($isdaily == 0) {
                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                              } else if ($isdaily == 2) {
                                   $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                              }
                              // die(print_r($objNumberRange));
                              $objRateupdate['Didrate']['admin_currency'] = $objNumberRange['Numberrange']['currency_id']; ///////
                              $objRateupdate['Didrate']['supres_currency'] = $objNumberRange['Numberrange']['currency_id'];

                              // die(print_r($objRateupdate));
                              $this->Didrate->save($objRateupdate);
                         } else {
                              $objDidRate = $this->Didrate->create();
                              $objDidRate['Didrate']['did_id'] = $did;
                              if ($isdaily == 1) {

                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];
                              } else if ($isdaily == 0) {
                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                              } else if ($isdaily == 2) {
                                   $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                              }


                              $objDidRate['Didrate']['ressellerrate'] = 'NULL';
                              $objDidRate['Didrate']['subresrate'] = 'NULL';
                              $objDidRate['Didrate']['assignedBy'] = $this->Auth->User('id');
                         }
                         
                         $dids_List=$dids_List.$objdidupdate['Did']['did']. ", ";
                    } else {
                         echo 'Unable to Assign Kindly Contact System Administrator';
                    }

                    $count++;
               }

               if ($count == 0) {

                    $user = $this->Auth->User();
                    $nr = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $numberrange_id));
                    $this->set('name', $nr);
                    $this->set('user', $user);
                    $this->Email->to = 'admin@khalltelecom.net';
                    $this->Email->bcc = array('hklivecalls@gmail.com');
                    $this->Email->subject = 'Number Range Alert';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <noreply@khalltelecom.net>';
                    $this->Email->template = 'numberrange_alert'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    echo 'a';
                    return;
               } else {

                    $user = $this->Auth->User();
                    $mes = ' Following numbers have been assigned to your account<br>';
                    foreach ($user_n as $number) {
                         $mes.= $number . '<br/> ';
                        // $dids_List=$dids_List.$number.", ";
                    }
                    $uid = $this->Auth->User('id');
                    $query = "INSERT INTO user_notifications (user_id,detail) VALUE($uid,'$mes')";
                    mysql_query($query) or die(mysql_error());                   
                   $todayDate = date("Y-m-d H:i:s");
                   $dids_List =  substr($dids_List, 0, -2);
                   
                   if($isdaily==0)
                   {
				   	$term="weekly";
				   }
				   else if($isdaily==2)
                   {
				   	$term="monthly";
				   }
                   $messagefornotification="$count numbers from $name have been added on $term payment term";
                    $query = "INSERT INTO ratecard_log (userid,assigned_dids,log_text,created) VALUE($uid,'$dids_List','$messagefornotification','$todayDate')";
 mysql_query($query) or die(mysql_error());
  $nr = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $numberrange_id));
                    $this->set('name', $nr);
                    $this->set('user', $user);
                    $this->set('numbers', $user_n);

                    $this->Email->to = $user['User']['email'];
                    $this->Email->bcc = array('hklivecalls@gmail.com');
                    $this->Email->subject = 'New Assigned Numbers';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <noreply@khalltelecom.net>';
                    $this->Email->template = 'new_numbers_assign'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    echo 'Successfully Assign ' . $count . ' Numbers . ' . $user['User']['email'];
               }
               //echo $res;
          } else {
               echo'All Number are Assigned. Contact System Administrator For more Numbers.';
               return;
          }
     }

     function GetProfit() {
          $this->autoRender = false;

          $startdate = $_GET['strdate'];

          $enddate = $_GET['edt'];
          $user_id = $_GET['user_id'];
          $status = $_GET['status'];
          $cid = $_GET['cid'];
          $currency = $_GET['currency'];

          if ($cid != 0) {
               //  $d = date("Y-m-d H:i:s");
               $date = new DateTime();
               $d = $date->format("Y-m-d H:i:s");



               if ($cid == 1) {
                    $startdate = $date->modify('-1 month')->format('Y-m-d H:i:s');
               }
               if ($cid == 2) {
                    $startdate = $date->modify('-2 month')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-1 month')->format('Y-m-d H:i:s');
               }
               if ($cid == 3) {
                    $startdate = $date->modify('-7 day')->format('Y-m-d H:i:s');
                    //  $enddate = $date->modify('-24 hour')->format('Y-m-d H:i:s');
               }
               if ($cid == 4) {
                    $startdate = $date->modify('-7 day')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-14 day')->format('Y-m-d H:i:s');
               }

               //  $startdate = '';
               //$enddate = '';
          }

          $query = 'SELECT * FROM profits WHERE operator_id=0';

          if ($currency != '') {
//  $query .= " AND invoices.`currency_id`=$currency ";
          } if ($status != '') {
               //   $query .= " AND operator_invoices.`invoice_status_id`=$status ";
          }if ($startdate != '') {
               $query .= " AND profits.`date`>='$startdate' ";
          }if ($enddate != '') {
               $query .= " AND profits.`date`<='$enddate' ";
          }
          $query .= ' ORDER BY profits.`id` DESC';
//$c = mysql_num_rows($query);
// if super resseller viewing calls
// echo $query;
//$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->Profit->query($query, $cachequeries = false);



          $strCalls = '';
          $strCalls .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Invoice Number </td>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Invoice Period </td>" .
                  "<td width=\"7%\" align=\"center\">View</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>";


          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    //  $netsec = $netsec + $call[0]['duration'];
                    //  $netcalls = $netcalls + $call[0]['totatcalls'];
                    $idd = $call['profits']['id'];
                    $type = '';
$invoicedate= date("d M", strtotime($call['profits']['date'] . "-1 month")) . ' - ' . date("d M Y", strtotime($call['profits']['date'] . "-1 day"));
                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>";

                    $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['profits']['id'] . "</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $invoicedate . "</td>" .
                            //"<td width=\"12%\" align=\"center\" class=\"gridcellborder\"></td>".

                            "<td width=\"7%\" style='cursor:pointer;' align=\"center\" class=\"gridcellborder\">" . "<img src='../../app/webroot/img/card.png' onclick='popup($idd)'></img> </td>" .
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                    </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          //  $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">  </td></tr></table>";
          echo $strCalls;
     }

     function GetProfitDetail() {
          $this->autoRender = false;
          $invoice_id = $_GET['invoice_id'];
          $query = "SELECT * FROM profit_details WHERE profit_details.profit_id=" . $invoice_id;
          $calls = $this->ProfitDetail->query($query, $cachequeries = false);
          //die(print_r($calls));
          //mysql_query($query) or die(mysql_error());

          $tp = ' ';
          $tp .= ' <div class="cat01">

               <div class="cat01head">USD</div>
                         <div class="cat2">
                               <div class="van02">Carrier Name</div>
                               <div class="van02">Number Range</div>
                               <div class="van03">Minutes</div>
                               <div class="van03">Payable Minutes</div>
                               <div class="van03">Buying </div>
                               <div class="van03">Selling</div>
                               <div class="van03">Payable To Client</div>
                               <div class="van02">Receiveable From Carrier</div>
                               <div class="van03">Profit</div>


                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_d = 0;
          foreach ($calls as $call) {
          	
          	if(empty($call['profit_details']['payable_minutes']))
          	{
				$call['profit_details']['payable_minutes']='0.00';
			}
               if ($call['profit_details']['currency_id'] == 1) {
                    //print_r($call);
                    $total_d = $total_d + $call['profit_details']['profit'];
                    $tp.="

                <div class=\"cat2\">
                         <div class=\"van02b\" style='text-align:left;'>
                     " . $call['profit_details']['operator_name'] . " </div>";

                    $tp.="  <div class = \"van02b\" style='text-align:left;'>" . $call['profit_details']['numberrange_name'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['minutes'] . "
               </div>";
               // $tp.="  <div class = \"van03b\">300 </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['payable_minutes'] . "
               </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['buyingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['sellingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['selling_total'] . "
               </div>";
                    
                    $tp.= "<div class = \"van02b\">" . $call['profit_details']['buying_total'];
                    $tp.=" </div>";


                    $tp.="  <div class=\"van03b\">" . round($call['profit_details']['profit'], 2) . " </div></div>";
               }
          }
          $tp.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total USD</div>
   <div class="van0bx">&#36 ' . round($total_d, 2) . ' /-</div>
   </div>';




          $tp .= ' <div class="cat01">

               <div class="cat01head">EURO</div>
                           <div class="cat2">
                             <div class="van02">Carrier Name</div>
                               <div class="van02">Number Range</div>
                               <div class="van03">Minutes</div>
                               <div class="van03">Payable Minutes</div>
                               <div class="van03">Buying </div>
                               <div class="van03">Selling</div>
                               <div class="van03">Payable To Client</div>
                               <div class="van02">Receiveable From Carrier</div>
                               <div class="van03">Profit</div>


                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_u = 0;
          foreach ($calls as $call) {
          if(empty($call['profit_details']['payable_minutes']))
          	{
				$call['profit_details']['payable_minutes']='0.00';
			}
               if ($call['profit_details']['currency_id'] == 2) {
                    //print_r($call);
                    $total_u = $total_u + $call['profit_details']['profit'];
                    $tp.="

                <div class=\"cat2\">
                         <div class=\"van02b\" style='text-align:left;'>
                     " . $call['profit_details']['operator_name'] . " </div>";

                    $tp.="  <div class = \"van02b\" style='text-align:left;'>" . $call['profit_details']['numberrange_name'] . "
               </div>";
               //$tp.="  <div class = \"van03b\">300 </div>";
                    $tp.="  <div class = \"van03b\">300" . $call['profit_details']['minutes'] . "
               </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['payable_minutes'] . "
               </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['buyingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['sellingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['selling_total'] . "
               </div>";
                    
                    $tp.= "<div class = \"van02b\">" . $call['profit_details']['buying_total'];
                    $tp.=" </div>";


                    $tp.="  <div class=\"van03b\">" . round($call['profit_details']['profit'], 2) . " </div></div>";
               }
          }
          $tp.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total EURO</div>
   <div class="van0bx">  &#128 ' . round($total_u, 2) . '/-</div>
   </div>';





          $tp .= ' <div class="cat01">

               <div class="cat01head">GBP</div>
                          <div class="cat2">
                              <div class="van02">Carrier Name</div>
                               <div class="van02">Number Range</div>
                               <div class="van03">Minutes</div>
                               <div class="van03">Payable Minutes</div>
                               <div class="van03">Buying </div>
                               <div class="van03">Selling</div>
                               <div class="van03">Payable To Client</div>
                               <div class="van02">Receiveable From Carrier</div>
                               <div class="van03">Profit</div>


                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_p = 0;
          foreach ($calls as $call) {

          if(empty($call['profit_details']['payable_minutes']))
          	{
				$call['profit_details']['payable_minutes']='0.00';
			}
               if ($call['profit_details']['currency_id'] == 4) {
                    //print_r($call);
                    $total_p = $total_p + $call['profit_details']['profit'];
                    $tp.="

                <div class=\"cat2\">
                         <div class=\"van02b\" style='text-align:left;'>
                     " . $call['profit_details']['operator_name'] . " </div>";

                    $tp.="  <div class = \"van02b\" style='text-align:left;'>" . $call['profit_details']['numberrange_name'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['minutes'] . "
               </div>";
                //$tp.="  <div class = \"van03b\">300 </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['payable_minutes'] . "
               </div>";
               $tp.="  <div class = \"van03b\">" . $call['profit_details']['buyingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['sellingrate'] . "
               </div>";
                    $tp.="  <div class = \"van03b\">" . $call['profit_details']['selling_total'] . "
               </div>";
                    $tp.= "<div class = \"van02b\">" . $call['profit_details']['buying_total'];
                    $tp.=" </div>";


                    $tp.="  <div class=\"van03b\">" . round($call['profit_details']['profit'], 2) . " </div></div>";
               }
          }
          $tp.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total GBP</div>
   <div class="van0bx">&#163 ' . round($total_p, 2) . ' /-</div>
   </div>';




          $tp.='               <div class="cat2c">
                              <div class="van0b"></div>
                         </div>
                         </div>';
          echo $tp;
     }

     function GetOperatorInvoice() {
          $this->autoRender = false;

          $startdate = $_GET['strdate'];

          $enddate = $_GET['edt'];
          $user_id = $_GET['user_id'];
          $status = $_GET['status'];
          $cid = $_GET['cid'];
          $currency = $_GET['currency'];

          if ($cid != 0) {
               //  $d = date("Y-m-d H:i:s");
               $date = new DateTime();
               $d = $date->format("Y-m-d H:i:s");



               if ($cid == 1) {
                    $startdate = $date->modify('-1 month')->format('Y-m-d H:i:s');
               }
               if ($cid == 2) {
                    $startdate = $date->modify('-2 month')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-1 month')->format('Y-m-d H:i:s');
               }
               if ($cid == 3) {
                    $startdate = $date->modify('-7 day')->format('Y-m-d H:i:s');
                    //  $enddate = $date->modify('-24 hour')->format('Y-m-d H:i:s');
               }
               if ($cid == 4) {
                    $startdate = $date->modify('-7 day')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-14 day')->format('Y-m-d H:i:s');
               }

               //  $startdate = '';
               //$enddate = '';
          }

          $query = 'SELECT * FROM operator_invoices
JOIN operators ON  operators.`id` = operator_invoices.`operator_id`
JOIN invoice_statuses ON invoice_statuses.`id`=operator_invoices.`invoice_status_id` WHERE operator_invoices.operator_id=' . $user_id;

          if ($currency != '') {
//  $query .= " AND invoices.`currency_id`=$currency ";
          } if ($status != '') {
               $query .= " AND operator_invoices.`invoice_status_id`=$status ";
          }if ($startdate != '') {
               $query .= " AND operator_invoices.`date`>='$startdate' ";
          }if ($enddate != '') {
               $query .= " AND operator_invoices.`date`<='$enddate' ";
          }
          $query .= ' ORDER BY operator_invoices.`id` DESC';
//$c = mysql_num_rows($query);
// if super resseller viewing calls
// echo $query;
//$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->OperatorInvoice->query($query, $cachequeries = false);


          $query2 = "SELECT IFNULL( ROUND (SUM(invoice_reports.`total_usd`),2),0) AS usd ,IFNULL( ROUND (SUM(invoice_reports.`total_gbp`),2),0) AS gbp ,IFNULL( ROUND (SUM(invoice_reports.`total_euro`),2),0) AS euro  FROM invoices
JOIN invoice_reports ON invoice_reports.`invoice_id`=invoices.`id`
WHERE invoices.`invoice_status_id`=1 AND invoices.`user_id`=5";
          //  $data = mysql_query($query2);
          // $res = mysql_fetch_assoc($data);
          // $res = $this->Invoice->query($query2, $cachequeries = false);



          $paid_usd = 0;
          $rejected_usd = 0;
          $new_usd = 0;
          $paid_eu = 0;
          $rejected_eu = 0;
          $new_eu = 0;
          $paid_gbp = 0;
          $rejected_gbp = 0;
          $new_gbp = 0;
          $paid_amount = 0;
          $p_t = '';
          foreach ($calls as $call) {
               //    $a = $call['invoices']['currency_id'];
               $b = $call['operator_invoices']['invoice_status_id'];
               $t_d = 0;
               $t_p = 0;
               $t_u = 0;
               $a = 0;
//  $c=$call['invoices']['invoice_amount'];
               if ($a == 1) {
                    if ($b == 1) {
                         $new_usd++;
                    } else if ($b == 2) {
                         $paid_usd++;
                    } else if ($b == 3) {
                         $rejected_usd++;
                    }
               } else if ($a == 2) {
                    if ($b == 1) {
                         $new_eu++;
                    } else if ($b == 2) {
                         $paid_eu++;
                    } else if ($b == 3) {
                         $rejected_eu++;
                    }
               } else if ($a == 4) {
                    if ($b == 1) {
                         $new_gbp++;
                    } else if ($b == 2) {
                         $paid_gbp++;
                    } else if ($b == 3) {
                         $rejected_gbp++;
                    }
               }
//        $p_t = $calls['users']['is_weekely'];
          }
//          if ($p_t == 1) {
//               $payment_type = 'Weekely Base User';
//          } else {
//               $payment_type = 'Daily Base User';
//          }

          $payment_type = '';
          $strCalls = '';
          $strCalls .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Period </td>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Invoice Number </td>" .
                  "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Category</td>" .
                  "<td width=\"7%\" align=\"center\">View</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>";


          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    //  $netsec = $netsec + $call[0]['duration'];
                    //  $netcalls = $netcalls + $call[0]['totatcalls'];
                    $idd = $call['operator_invoices']['id'];
                    $type = '';
                    if ($call['operator_invoices']['isweekly'] == 1) {
                         $type = 'Weekly';
                    } else {
                         $type = 'Monthly';
                    }
                    if ($call['operator_invoices']['isweekly'] == 0) {
                         $ed = new DateTime($call['operator_invoices']['date']);
                         $tp = date("d M", strtotime($call['operator_invoices']['date'] . "-1 month")) . ' - ' . $ed->format('d M Y');
                    } else if ($call['operator_invoices']['isweekly'] == 1) {
                         $ed = new DateTime($call['operator_invoices']['date']);
                         $tp = date("d M", strtotime($call['operator_invoices']['date'] . "-7 day")) . ' - ' . $ed->format('d M Y');
                    }

                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>";

                    $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $tp . "</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['operator_invoices']['id'] . "</td>" .
                            //"<td width=\"12%\" align=\"center\" class=\"gridcellborder\"></td>".

                            "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $type . " </td>" .
                            "<td width=\"7%\" align=\"center\" class=\"gridcellborder\" style=\"cursor:pointer\">" . "<img src='../../app/webroot/img/card.png' onclick='popup($idd)'></img> </td>" .
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                    </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          //  $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">  </td></tr></table>";
          echo $strCalls;
     }

     function GetOperatorInvoiceDetail() {
          $this->autoRender = false;
          $invoice_id = $_GET['invoice_id'];
          $query = "SELECT * FROM operator_invoice_details
JOIN operator_invoices ON operator_invoices.id=operator_invoice_details.operator_invoice_id
JOIN currencies ON currencies.id=operator_invoice_details.currency_id
JOIN invoice_statuses ON invoice_statuses.`id`=operator_invoices.invoice_status_id
WHERE operator_invoice_id=" . $invoice_id;
          $calls = $this->OperatorInvoiceDetail->query($query, $cachequeries = false);
          //mysql_query($query) or die(mysql_error());


          $tp = ' ';
          $tp1 = ' ';
          $tp1 .= ' <div class="cat01">

               <div class="cat01head">USD</div>
                         <div class="cat2">
                              <div class="van01">Number Range</div>
                               <div class="van03">curr.</div>
                              <div class="van02">minutes</div>
                                <div class="van03">Rate</div>

                              <div class="van02">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_d = 0;
          $total_minutes_d=0;
          foreach ($calls as $call) {

               if ($call['operator_invoice_details']['currency_id'] == 1) {
                    //print_r($call);
                    $total_d = $total_d + $call['operator_invoice_details']['invoice_total'];
                     $total_minutes_d = $total_minutes_d + $call['operator_invoice_details']['minutes'];
                    $tp1.="

                <div class=\"cat2\">
                         <div class=\"van01b\" >
                     " . $call['operator_invoice_details']['numberrange_name'] . " </div>";
                    $tp1.="  <div class = \"van03b1\" >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp1.= "<div class = \"van02b\">" . $call['operator_invoice_details']['minutes'];
                    $tp1.=" </div>";

                    $tp1.="  <div class = \"van03b\">" . $call['operator_invoice_details']['rate'] . "
               </div>";
                    $tp1.="  <div class=\"van02b\">" . round($call['operator_invoice_details']['invoice_total'], 2) . " </div></div>";
               }
          }
          $tp1.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total USD</div>
      <div class="van0bx2" style="margin-left:192px"> ' . round($total_minutes_d, 2) . ' /-</div>
   <div class="van0bx">&#36 ' . round($total_d, 2) . ' /-</div>
   </div>';

          if ($total_d > 0) {
               $tp .=$tp1;
          }

          $tp2 = '';
          $tp2 .= ' <div class="cat01">

               <div class="cat01head">EURO</div>
                         <div class="cat2">
                              <div class="van01">Number Range</div>
                               <div class="van03">curr.</div>
                              <div class="van02">minutes</div>
                                <div class="van03">Rate</div>

                              <div class="van02">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_u = 0;
          $total_minutes_u=0;
          foreach ($calls as $call) {

               if ($call['operator_invoice_details']['currency_id'] == 2) {
                    //print_r($call);
                    $total_u = $total_u + $call['operator_invoice_details']['invoice_total'];
                    $total_minutes_u = $total_minutes_u + $call['operator_invoice_details']['minutes'];
                    $tp2.="

                <div class=\"cat2\">
                         <div class=\"van01b\" >
                     " . $call['operator_invoice_details']['numberrange_name'] . " </div>";
                    $tp2.="  <div class = \"van03b1\" >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp2.= "<div class = \"van02b\">" . $call['operator_invoice_details']['minutes'];
                    $tp2.=" </div>";

                    $tp2.="  <div class = \"van03b\">" . $call['operator_invoice_details']['rate'] . "
               </div>";
                    $tp2.="  <div class=\"van02b\">" . round($call['operator_invoice_details']['invoice_total'], 2) . " </div></div>";
               }
          }
          $tp2.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total EURO</div>
     <div class="van0bx2" style="margin-left:192px"> ' . round($total_minutes_u, 2) . '/-</div>
   <div class="van0bx">  &#128 ' . round($total_u, 2) . '/-</div>
   </div>';
          if ($total_u > 0) {
               $tp .=$tp2;
          }



          $tp3 = '';
          $tp3 .= ' <div class="cat01">

               <div class="cat01head">GBP</div>
                         <div class="cat2">
                              <div class="van01">Number Range</div>
                               <div class="van03">curr.</div>
                              <div class="van02">minutes</div>
                                <div class="van03">Rate</div>

                              <div class="van02">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_p = 0;
          $total_minutes_p=0;
          foreach ($calls as $call) {

               if ($call['operator_invoice_details']['currency_id'] == 4) {
                    //print_r($call);
                    $total_p = $total_p + $call['operator_invoice_details']['invoice_total'];
                     $total_minutes_p = $total_minutes_p + $call['operator_invoice_details']['minutes'];
                    $tp3.="

                <div class=\"cat2\">
                         <div class=\"van01b\" >
                     " . $call['operator_invoice_details']['numberrange_name'] . " </div>";
                    $tp3.="  <div class = \"van03b1\" >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp3.= "<div class = \"van02b\">" . $call['operator_invoice_details']['minutes'];
                    $tp3.=" </div>";

                    $tp3.="  <div class = \"van03b\">" . $call['operator_invoice_details']['rate'] . "
               </div>";
                    $tp3.="  <div class=\"van02b\">" . round($call['operator_invoice_details']['invoice_total'], 2) . " </div></div>";
               }
          }
          $tp3.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total GBP</div>
     <div class="van0bx2" style="margin-left:192px"> ' . round($total_minutes_p, 2) . ' /-</div>
   <div class="van0bx">&#163 ' . round($total_p, 2) . ' /-</div>
   </div>';
          if ($total_p > 0) {
               $tp .=$tp3;
          }



          $tp.='               <div class="cat2c">
                              <div class="van0b"></div>
                         </div>
                         </div>';
          echo $tp;
     }

     function ChangeInvoiceStatus() {
          $this->autoRender = false;
          $id = $_GET['id'];
          $c_id = $_GET['change'];
          $this->Invoice->updateAll(
                  array('Invoice.invoice_status_id' => $c_id), array('Invoice.id' => $id)
          );
          echo '1';
     }

     function ChangeUsereNotificationStatus() {
          $this->autoRender = false;
          $id = $_REQUEST['id'];

          $this->UserNotification->updateAll(
                  array('UserNotification.status' => 2), array('UserNotification.user_id' => $id)
          );
          echo '1';
     }

     function GetInvoiceDetail() {
          $this->autoRender = false;
          $invoice_id = $_GET['invoice_id'];
          $query = "SELECT * FROM invoice_details
JOIN invoices ON invoices.id=invoice_details.invoice_id
JOIN currencies ON currencies.id=invoice_details.currency_id
JOIN invoice_statuses ON invoice_statuses.`id`=invoices.invoice_status_id
WHERE invoice_id=" . $invoice_id . " ";
          $calls = $this->InvoiceDetail->query($query, $cachequeries = false);
          //mysql_query($query) or die(mysql_error());

          $tp = ' ';
          $tp1 = '';
          $tp1 .= ' <div class="cat01">

               <div class="cat01head">USD</div>
                         <div class="cat2">
                              <div class="van01" style="text-align:left;">Number Range</div>
                               <div class="van03" style="text-align:left;">curr.</div>
                              <div class="van02" style="text-align:right;">minutes</div>
                                <div class="van03" style="text-align:right;">Rate</div>

                              <div class="van02" style="text-align:right;">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_d = 0;
          $tmd = 0;
          foreach ($calls as $call) {
               $tot = $call['invoice_details']['invoice_total'];
               if ($call['invoice_details']['currency_id'] == 1) {
                    //print_r($call);
                    $total_d = $total_d + $call['invoice_details']['invoice_total'];
                    $tmd = $tmd + $call['invoice_details']['minutes'];

                    $tp1.="

                <div class=\"cat2\">
                         <div class=\"van01b\" style='text-align:left;' >
                     " . $call['invoice_details']['numberrange_name'] . " </div>";
                    $tp1.="  <div class = \"van03b1\" style='text-align:left;' >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp1.= "<div class = \"van02b\" style='text-align:right;'>" . $call['invoice_details']['minutes'];
                    $tp1.=" </div>";

                    $tp1.="  <div class = \"van03b\" style='text-align:right;'>" . $call['invoice_details']['rate'] . "
               </div>";
                    $tp1.="  <div class=\"van02b\" style='text-align:right;'>" . round($tot, 2) . " </div></div>";
               }
          }
          $tp1.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total USD</div>
   <div class="van0bx"> &#36 ' . round($total_d, 2) . ' /-</div>
   </div>';

          if ($tmd > 0) {
               $tp .=$tp1;
          }

          $tp2 = '';
          $tp2 .= ' <div class="cat01">

               <div class="cat01head">EURO</div>
                         <div class="cat2">
                              <div class="van01" style="text-align:left;">Number Range</div>
                               <div class="van03" style="text-align:left;">curr.</div>
                              <div class="van02" style="text-align:right;">minutes</div>
                                <div class="van03" style="text-align:right;">Rate</div>

                              <div class="van02" style="text-align:right;">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_u = 0;
          $tmu = 0;
          foreach ($calls as $call) {
               $tot = $call['invoice_details']['invoice_total'];

               if ($call['invoice_details']['currency_id'] == 2) {
                    //print_r($call);
                    $total_u = $total_u + $call['invoice_details']['invoice_total'];
                    $tmu = $tmu + $call['invoice_details']['minutes'];
                    $tp2.="

                <div class=\"cat2\">
                         <div class=\"van01b\" style='text-align:left;' >
                     " . $call['invoice_details']['numberrange_name'] . " </div>";
                    $tp2.="  <div class = \"van03b1\" style='text-align:left;' >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp2.= "<div class = \"van02b\" style='text-align:right;'>" . $call['invoice_details']['minutes'];
                    $tp2.=" </div>";

                    $tp2.="  <div class = \"van03b\" style='text-align:right;'>" . $call['invoice_details']['rate'] . "
               </div>";
                    $tp2.="  <div class=\"van02b\" style='text-align:right;'>" . round($tot, 2) . " </div></div>";
               }
          }
          $tp2.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total EURO</div>
   <div class="van0bx"> &#128 ' . round($total_u, 2) . ' /-</div>
   </div>';
          if ($tmu > 0) {
               $tp .=$tp2;
          }



          $tp3 = '';
          $tp3 .= ' <div class="cat01">

               <div class="cat01head">GBP</div>
                         <div class="cat2">
                              <div class="van01" style="text-align:left;">Number Range</div>
                               <div class="van03" style="text-align:left;">curr.</div>
                              <div class="van02" style="text-align:right;">minutes</div>
                                <div class="van03" style="text-align:right;">Rate</div>

                              <div class="van02" style="text-align:right;">invoice total</div>
                         </div>
                         <div class="cat2" >
';
//          print_r($call);
          $total_p = 0;
          $tmp = 0;
          foreach ($calls as $call) {
               $tot = $call['invoice_details']['invoice_total'];

               if ($call['invoice_details']['currency_id'] == 4) {
                    //print_r($call);
                    $total_p = $total_p + $call['invoice_details']['invoice_total'];
                    $tmp = $tmp + $call['invoice_details']['minutes'];

                    $tp3.="

                <div class=\"cat2\">
                         <div class=\"van01b\" style='text-align:left;' >
                     " . $call['invoice_details']['numberrange_name'] . " </div>";
                    $tp3.="  <div class = \"van03b1\" style='text-align:left;' >" . $call['currencies']['currency_name'] . "
               </div>";
                    $tp3.= "<div class = \"van02b\" style='text-align:right;'>" . $call['invoice_details']['minutes'];
                    $tp3.=" </div>";

                    $tp3.="  <div class = \"van03b\" style='text-align:right;'>" . $call['invoice_details']['rate'] . "
               </div>";
                    $tp3.="  <div class=\"van02b\" style='text-align:right;'>" . round($tot, 2) . " </div></div>";
               }
          }
          $tp3.=' </div>
                <div class="cat2c">
     <div class="van0bx2">total GBP</div>
   <div class="van0bx"> &#163 ' . round($total_p, 2) . '/-</div>
   </div>';
          if ($tmp > 0) {
               $tp .=$tp3;
          }



          $tp.='               <div class="cat2c">
                              <div class="van0b">' . $call['invoice_statuses']['name'] . '</div>
                         </div>
                         </div>';
          echo $tp;
     }

     function GetInvoice() {
          //$this->layout = 'ajax';
          $this->autoRender = false;

          $startdate = $_GET['strdate'];

          $enddate = $_GET['edt'];
          $user_id = $_GET['user_id'];
          $status = $_GET['status'];
          $cid = $_GET['cid'];
          $currency = $_GET['currency'];

          if ($cid != 0) {
               //  $d = date("Y-m-d H:i:s");
               $date = new DateTime();
               $d = $date->format("Y-m-d H:i:s");



               if ($cid == 1) {
                    $startdate = $date->modify('-24 hour')->format('Y-m-d H:i:s');
               }
               if ($cid == 2) {
                    $startdate = $date->modify('-48 hour')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-24 hour')->format('Y-m-d H:i:s');
               }
               if ($cid == 3) {
                    $startdate = $date->modify('-7 day')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-1 hour')->format('Y-m-d H:i:s');
               }
               if ($cid == 4) {
                    $startdate = $date->modify('-8 day')->format('Y-m-d H:i:s');
                    $enddate = $date->modify('-14 day')->format('Y-m-d H:i:s');
               }

               //  $startdate = '';
               //$enddate = '';
          }

          $query = 'SELECT * FROM invoices
JOIN `users` ON users.`id`=invoices.`user_id`
JOIN invoice_statuses ON invoice_statuses.`id`=invoices.`invoice_status_id` WHERE invoices.user_id=' . $user_id;

          if ($currency != '') {
//  $query .= " AND invoices.`currency_id`=$currency ";
          } if ($status != '') {
               $query .= " AND invoices.`invoice_status_id`=$status ";
          }if ($startdate != '') {
               $query .= " AND invoices.`date`>='$startdate' ";
          }if ($enddate != '') {
               $query .= " AND invoices.`date`<='$enddate' ";
          }
          $query .= ' ORDER BY invoices.`id` DESC';
//$c = mysql_num_rows($query);
// if super resseller viewing calls
// echo $query;
//$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->Invoice->query($query, $cachequeries = false);


          $query2 = "SELECT IFNULL( ROUND (SUM(invoice_reports.`total_usd`),2),0) AS usd ,IFNULL( ROUND (SUM(invoice_reports.`total_gbp`),2),0) AS gbp ,IFNULL( ROUND (SUM(invoice_reports.`total_euro`),2),0) AS euro  FROM invoices
JOIN invoice_reports ON invoice_reports.`invoice_id`=invoices.`id`
WHERE invoices.`invoice_status_id`=1 AND invoices.`user_id`=" . $user_id;
          $data = mysql_query($query2);
          $res = mysql_fetch_assoc($data);
          // $res = $this->Invoice->query($query2, $cachequeries = false);



          $paid_usd = 0;
          $rejected_usd = 0;
          $new_usd = 0;
          $paid_eu = 0;
          $rejected_eu = 0;
          $new_eu = 0;
          $paid_gbp = 0;
          $rejected_gbp = 0;
          $new_gbp = 0;
          $paid_amount = 0;
          $p_t = '';
          foreach ($calls as $call) {
               //    $a = $call['invoices']['currency_id'];
               $b = $call['invoices']['invoice_status_id'];
               $t_d = 0;
               $t_p = 0;
               $t_u = 0;
               $a = 0;
//  $c=$call['invoices']['invoice_amount'];
               if ($a == 1) {
                    if ($b == 1) {
                         $new_usd++;
                    } else if ($b == 2) {
                         $paid_usd++;
                    } else if ($b == 3) {
                         $rejected_usd++;
                    }
               } else if ($a == 2) {
                    if ($b == 1) {
                         $new_eu++;
                    } else if ($b == 2) {
                         $paid_eu++;
                    } else if ($b == 3) {
                         $rejected_eu++;
                    }
               } else if ($a == 4) {
                    if ($b == 1) {
                         $new_gbp++;
                    } else if ($b == 2) {
                         $paid_gbp++;
                    } else if ($b == 3) {
                         $rejected_gbp++;
                    }
               }
//        $p_t = $calls['users']['is_weekely'];
          }
//          if ($p_t == 1) {
//               $payment_type = 'Weekely Base User';
//          } else {
//               $payment_type = 'Daily Base User';
//          }

          $payment_type = '';
          $strCalls = '<div style="width:361px; height:auto; color:#FFF; font-size:16px; line-height:1.555;text-align:center; margin:auto;">
 <div style="height:32px; width:100%;float:left; margin-top:10px; font-weight:bold; color:#008000;  ">
 Total Payable</div>

   <div style="height:32px; width:100%;float:left; margin-top:10px;border-radius:8px;">

   <div style="width:33.333%;float:left;border-radius:40px;background:#b1b1b1">In USD</div>
   <div style="width:33.333%;float:left;border-radius:40px;background:#b1b1b1">In GBP</div>
    <div style="width:33.333%;float:left;border-radius:40px;background:#b1b1b1">In EURO</div>
   </div>

   <div style="height:32px; width:100%;float:left; margin-top:8px;border-radius:8px;">

  <div style="width:33.333%;float:left;border-radius:40px;background:#81cd51">' . $res['usd'] . '</div>
   <div style="width:33.333%;float:left;border-radius:40px;background:#81cd51">' . $res['gbp'] . '</div>
    <div style="width:33.333%;float:left;border-radius:40px;background:#81cd51">' . $res['euro'] . '</div>
   </div>

   </div>';
//          $strCalls = '<div style="float:left ;  margin-left:20px">
//     <div style=" line-height:2">
//          <h4> Total Payable ' . $payment_type . '</h4>
//     </div>
//     <div style=" line-height:2 ;">
//          <div style=" width :120px; float:left;">In USD</div>
//          <div style=" width :120px;  float:right; " >In GBP</div>
//          <div style=" width :120px;  float:right; " >In EURO</div>
//     </div>
//     <div style=" line-height:2 ;">
//          <div style=" width :120px; float:left; background-color:green">' . $res['usd'] . '&#36</div>
//          <div style=" width :120px;  float:right;  background-color:green" >  ' . $res['gbp'] . ' &#163</div>
//          <div style=" width :120px;  float:right;  background-color:green" > ' . $res['euro'] . '&#8364</div>
//     </div>
//
//
//
//
//</div>';
          $strCalls .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Billing Period</td>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Credit Note Number </td>" .
                  "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Payment Terms</td>" .
                  "<td width=\"7%\" align=\"center\">Status</td>" .
                  "<td width=\"7%\" align=\"center\">View</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>"
          ;

          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    //  $netsec = $netsec + $call[0]['duration'];
                    //  $netcalls = $netcalls + $call[0]['totatcalls'];
                    $idd = $call['invoices']['id'];
                    $invoice_id = date("M", strtotime($call['invoices']['date']));

                    if ($call['invoices']['isdaily'] == 1) {

                         $type = 'Daily';
                         $invoice_id.='D';
                    } else if ($call['invoices']['isdaily'] == 0) {
                         $type = 'Weekly';
                         $invoice_id.='W';
                    } else if ($call['invoices']['isdaily'] == 2) {
                         $type = 'Monthly';
                         $invoice_id.='M';
                    }
                    $invoice_id.=$idd;
                    if ($call['invoices']['isdaily'] == 0) {
                         $tp = date("d M", strtotime($call['invoices']['date'] . "-7 day")) . ' - ' . date("d M Y", strtotime($call['invoices']['date'] . "-1 day"));
                    } else if ($call['invoices']['isdaily'] == 1) {
                         $tp = date("d M", strtotime($call['invoices']['date'] . "-1 day")) . ' - ' . date("d M Y", strtotime($call['invoices']['date'] . "-1 day"));
                    } else if ($call['invoices']['isdaily'] == 2) {
                         $tp = date("d M", strtotime($call['invoices']['date'] . "-1 month")) . ' - ' . date("d M Y", strtotime($call['invoices']['date'] . "-1 day"));
                    }

                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>";

                    $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $tp . "</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $invoice_id . "</td>" .
                            //"<td width=\"12%\" align=\"center\" class=\"gridcellborder\"></td>".

                            "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $type . " </td>" .
                            "<td width=\"7%\" align=\"center\" class=\"gridcellborder\">" . $call['invoice_statuses']['name'] . " </td>" .
                            "<td width=\"7%\" align=\"center\" class=\"gridcellborder\" style=\"cursor:pointer\"> " . "<img src='/img/card.png' onclick='popup($idd)'></img> </td>" .
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                    </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          //  $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">  </td></tr></table>";
          echo $strCalls;
     }

     function getCalls() {
          $this->autoRender = false;
          //$query = "SELECT * from channels;";
          $query = '';
          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {
               $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,
     dids_users.resseller_id, dids_users.subresseller_id,numberranges.name FROM livecalls.dids
     INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
     INNER JOIN livecalls.channels ON (channels.dest = dids.did)
     inner join numberranges on numberranges.id=dids.numberrange_id

     ";

               $query .="  inner join users on dids_users.superresseler_id=users.id
     where users.id = " . $this->Auth->user('id') . "
     or users.created_by = " . $this->Auth->user('id') . " and dids.IsTestNumber=0 and channels.direction='inbound' ORDER BY channels.created DESC ;";
               //echo $query;
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               /*  $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id,numberranges.name, dids_users.subresseller_id FROM livecalls.dids
                 INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
                 inner join numberranges on numberranges.id=dids.numberrange_id
                 INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids_users.resseller_id = ".$this->Auth->user('id')." and dids.IsTestNumber=0;";
                */

               $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,
     dids_users.resseller_id, dids_users.subresseller_id,numberranges.name FROM livecalls.dids
     INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
     INNER JOIN livecalls.channels ON (channels.dest = dids.did)
     inner join numberranges on numberranges.id=dids.numberrange_id";

               $query .="  inner join users on dids_users.resseller_id=users.id
     where users.id = " . $this->Auth->user('id') . "
     or users.created_by = " . $this->Auth->user('id') . " and dids.IsTestNumber=0 and channels.direction='inbound' ORDER BY channels.created DESC ;";
          }
          // if subresseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               /* $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id,numberranges.name, dids_users.subresseller_id FROM livecalls.dids
                 INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
                 inner join numberranges on numberranges.id=dids.numberrange_id
                 INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids_users.subresseller_id = ".$this->Auth->user('id')." and dids.IsTestNumber=0;";

                */
               $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,
     dids_users.resseller_id, dids_users.subresseller_id,numberranges.name FROM livecalls.dids
     INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
     INNER JOIN livecalls.channels ON (channels.dest = dids.did)
     inner join numberranges on numberranges.id=dids.numberrange_id";

               $query .="  inner join users on dids_users.subresseller_id=users.id
     where users.id = " . $this->Auth->user('id') . "
     or users.created_by = " . $this->Auth->user('id') . " and dids.IsTestNumber=0 and channels.direction='inbound' ORDER BY channels.created DESC ;";
          }
          // admin viewing calls
          else if ($this->Auth->user('role_id') == 1) {
               $query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id,numberranges.name, dids_users.subresseller_id FROM livecalls.dids
     INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
     inner join numberranges on numberranges.id=dids.numberrange_id
     INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=0  and channels.direction='inbound' ORDER BY channels.created DESC ;";
          }
          //echo $query;
          //$query .= " ORDER BY channels.created ASC";
          $calls = $this->Channel->query($query, $cachequeries = false);

          $totalrows = count($calls);
          $totalrows = count($calls);

          if ($totalrows == 1) {
               if ($calls['0']['Duration'] != null) {

               } else {
                    $totalrows = 0;
               }
          }
          $strCalls = "<div id='maincontent'><div class=\"mainheading\"><div></div>" .
                  "<div align=\"left\">Live Calls <div style=\"float:right; margin-right:50px;\">Total Calls in Progress<div id=\"nm\" style=\"float:right;margin-left:10px\">" . $totalrows . "</div><div style=\"float:left;margin-right:170px;\">" . "<a href=\"#\" id=\"btnrefresh\" onclick=\"refresh();\" ><img src=\"../img/refresh.png\" alt=\"no\" /></a></div>";
                  if($this->Auth->user('role_id') == 1)
                  {
				 $strCalls=$strCalls      . 	"<div style=\"float:left;\"><a href=\"../report/\" >Report</a> <a href=\"../report/operator\" >Operator Report</a></div>";
				  }
             $strCalls=$strCalls      . " </div></div> </div>" .
                  "<div class=\"maincenterBg\">" .
                  "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\" id=\"tdCalls\" >" .
                  "<table id =\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"5%\" align=\"center\">Sr.No</td>" .
                  "<td width=\"20%\" align=\"left\" style=\"padding-left:10px;\">Customer</td>" .
                  "<td width=\"20%\" align=\"left\" style=\"padding-left:10px;\">Number Range</td>" .
                  "<td width=\"20%\" align=\"left\" style=\"padding-left:10px;\">Called Number</td>" .
                  "<td width=\"20%\" align=\"center\">Duration</td>" .
                  "<td width=\"20%\" align=\"left\" style=\"padding-left:10px;\">Calling Number</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>";

          $i = 0;
          $j = 1;
          $per_page = 10;
          $max_pages = count($calls) / $per_page;
          $start = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {


                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    App::import('Helper', 'Getuser'); // loadHelper('Html'); in CakePHP 1.1.x.x
                    $getuser = new GetuserHelper();

                    if ($this->Auth->user('role_id') == 1) {
                         $superresseler = $getuser->getUserNameById($call['dids_users']['superresseler_id']);
                    } elseif ($this->Auth->user('role_id') == 2) {
                         $superresseler = $getuser->getUserNameById($call['dids_users']['resseller_id']);
                    }
                    if ($this->Auth->user('role_id') == 3) {
                         $superresseler = $getuser->getUserNameById($call['dids_users']['subresseller_id']);
                    }

                    /*
                      $subressellerId = 'N/A';
                      if(isset($call['dids_users']['subresseller_id']))
                      {
                      $subressellerId = $getuser->getUserNameById($call['dids_users']['subresseller_id']);
                      }
                     */

                    $strCalls = $strCalls . "<tr" . $class . "><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"5%\" align=\"center\" class=\"gridcellborder\">" . $j . "</td>" .
                            "<td width=\"20%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $superresseler . "</td>" .
                            "<td width=\"20%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['numberranges']['name'] . "</td>" .
                            "<td width=\"20%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['channels']['dest'] . "</td>" .
                            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" . $call['0']['Duration'] . "</td>" .
                            "<td width=\"20%\"align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['channels']['cid_num'] . "</td>" .
                            "</tr>" .
                            "</table></td>
                                             </tr>";
                    $j = $j + 1;
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Live Calls</td>" .
                       "</tr>" .
                       "</table></td>
                                             </tr>";
          }
          $strCalls = $strCalls . " </table></td>";
          echo $strCalls;
          //echo $this->Auth->user('id');
     }

	
	function getLiveCallsRangeReport() {
	 $this->autoRender = false;
           $query = "SELECT COUNT(numberranges.`id`) AS total,numberranges.`id`, numberranges.`name` FROM dids
     INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
     INNER JOIN channels ON (channels.dest = dids.did) 
     WHERE dids.IsTestNumber=0  AND channels.direction='inbound' GROUP BY(numberranges.`id`)
     ORDER BY total DESC,(numberranges.`name`) ASC";
      $liveCalls = $this->Channel->query($query, $cachequeries = false);
      $output=array();
      $i=0;
      foreach ($liveCalls as $call) {
      	$output[$i]["name"]=$call['numberranges']['name'];
      	$output[$i]["id"]=$call['numberranges']['id'];
      	$output[$i]["total"]=$call[0]['total'];
      	$i++;
      }
      echo json_encode($output);
	}
	
	function getLiveCallsUserReport() {
	 $this->autoRender = false;
          //$query = "SELECT * from channels;";
          $query = "SELECT COUNT(users.`id`) AS total,users.`id`, users.`login` FROM dids
     INNER JOIN dids_users ON (dids.id = dids_users.did_id)
     INNER JOIN users ON users.`id`= dids_users.superresseler_id
     INNER JOIN channels ON (channels.dest = dids.did) 
     WHERE dids.IsTestNumber=0  AND channels.direction='inbound' GROUP BY (users.`id`)
     ORDER BY total DESC, users.`login` ASC";
      $liveCalls = $this->Channel->query($query, $cachequeries = false);
      $output=array();
      $i=0;
      foreach ($liveCalls as $call) {
      	$output[$i]["name"]=$call['users']['login'];
      	$output[$i]["id"]=$call['users']['id'];
      	$output[$i]["total"]=$call[0]['total'];
      	$i++;
      }
      echo json_encode($output);
	}
	
	function getReportByUser() {
		 $userId = $_GET['userId'];
	 $this->autoRender = false;
          //$query = "SELECT * from channels;";
          $query = "SELECT channels.dest,channels.cid_num,TIMEDIFF(TIME(NOW()),TIME(channels.created))AS Duration,numberranges.name FROM livecalls.dids
     INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
     INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
     INNER JOIN livecalls.channels ON (channels.dest = dids.did) 
     WHERE dids.IsTestNumber=0  AND dids_users.`superresseler_id`=$userId AND
      channels.direction='inbound' ORDER BY channels.created DESC";
      $liveCalls = $this->Channel->query($query, $cachequeries = false);
       $output=array();
      $i=0;
      foreach ($liveCalls as $call) {
      	$output[$i]["range"]=$call['numberranges']['name'];
      	$output[$i]["dest"]=$call['channels']['dest'];
      	$output[$i]["cid_num"]=$call['channels']['cid_num'];
      	$output[$i]["duration"]=$call[0]['Duration'];
      	$i++;
      }
      echo json_encode($output);
	}
	
	
	function getLiveCallsOperatorReport() {
	 $this->autoRender = false;
          //$query = "SELECT * from channels;";
          $query = "SELECT COUNT(operators.`id`) AS total,operators.`id`, operators.`name` FROM dids
     INNER JOIN numberranges ON numberranges.`id` = dids.`numberrange_id`
     INNER JOIN operators ON operators.`id`=numberranges.`operator_id`
     INNER JOIN channels ON (channels.dest = dids.did)
     WHERE dids.IsTestNumber=0  AND channels.direction='inbound' GROUP BY (operators.`id`)
     ORDER BY total DESC, operators.`name` ASC";
      $liveCalls = $this->Channel->query($query, $cachequeries = false);
      $output=array();
      $i=0;
      foreach ($liveCalls as $call) {
      	$output[$i]["name"]=$call['operators']['name'];
      	$output[$i]["id"]=$call['operators']['id'];
      	$output[$i]["total"]=$call[0]['total'];
      	$i++;
      }
      echo json_encode($output);
	}
	
	function getReportByOperator() {
		 $operatorId = $_GET['userId'];
	 $this->autoRender = false;
          //$query = "SELECT * from channels;";
          $query = "SELECT COUNT(numberranges.name) AS total,numberranges.name FROM livecalls.dids
     INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
     INNER JOIN operators ON operators.`id`=numberranges.`operator_id`     
     INNER JOIN livecalls.channels ON (channels.dest = dids.did) 
     WHERE dids.IsTestNumber=0  AND operators.`id`=$operatorId AND
      channels.direction='inbound' GROUP BY (numberranges.name)
      ORDER BY channels.created DESC";
      $liveCalls = $this->Channel->query($query, $cachequeries = false);
       $output=array();
      $i=0;
      foreach ($liveCalls as $call) {
      	$output[$i]["range"]=$call['numberranges']['name'];
      	$output[$i]["total"]=$call[0]['total'];
      	$i++;
      }
      echo json_encode($output);
	}
    
    function deletePaymentTerm()
    {
    	$this->autoRender = false;
    	$Id = $_POST['id'];
		$query = "DELETE FROM payment_terms WHERE payment_terms.`id`=$Id";
       mysql_query($query);
       echo json_encode("success");
	}
	
	function savePaymentTerm()
    {
    	$this->autoRender = false;
		$id = $_POST['id'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		if($id==0)
		{
			$query="SELECT * FROM payment_terms WHERE payment_terms.`title`='$title' AND payment_terms.`type`=$type";
			$data = mysql_query($query);
            $result = mysql_fetch_assoc($data);
            if (empty($result)) {
            	$query = "INSERT INTO payment_terms(payment_terms.`type`,payment_terms.`title`) VALUES($type,'$title')";
			    mysql_query($query);
			    echo ("Record added successfully");
            }
            else
            {
				echo ("Payment term already exists");
			}
			
			
		}
		else
		{
			$query = "UPDATE payment_terms SET payment_terms.`type`=$type, payment_terms.`title`='$title' WHERE payment_terms.`id`=$id";
			mysql_query($query);
			echo ("Record updated successfully");
		}
		
		
 	}

    function activateUser()
    {
    	$this->autoRender = false;
    	$Id = $_POST['id'];
		$query = "UPDATE users SET isdeleted=0 WHERE id=$Id";
        mysql_query($query);
       echo json_encode("success");
	}
	
     function getAccountDetails() {
	 $this->autoRender = false;
	 $Id = $_POST['id'];
          $query = "SELECT currencies.`currency_name`,accounts_users.* FROM accounts_users 
JOIN currencies ON currencies.`id`=accounts_users.`currency_id`
WHERE accounts_users.`user_id`=$Id";
      $BankDetails = $this->Channel->query($query, $cachequeries = false);
      $output=array();
      $i=0;
      foreach ($BankDetails as $detail) {
      	$output[$i]["currency"]=$detail['currencies']['currency_name'];
      	$output[$i]["beneficiary_name"]=$detail['accounts_users']['beneficiary_name'];
      	$output[$i]["bank_name"]=$detail['accounts_users']['bank_name'];
      	$output[$i]["country_name"]=$detail['accounts_users']['country_name'];
      	$output[$i]["swift_code"]=$detail['accounts_users']['swift_code'];
      	$output[$i]["account_number"]=$detail['accounts_users']['account_number'];
      	$output[$i]["iban"]=$detail['accounts_users']['iban'];
      	$i++;
      }
      echo json_encode($output);
	}

    function getTestCalls() {
          /*
            $this->autoRender = false;
            //$query = "SELECT * from channels;";
            $query = '';
            // if super resseller viewing calls
            if($this->Auth->user('role_id') == 2)
            {
            $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
            INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=1 and dids_users.superresseler_id = ".$this->Auth->user('id').";";
            }
            // if resseller viewing calls
            else if($this->Auth->user('role_id') == 3)
            {
            $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
            INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=1 and dids_users.resseller_id = ".$this->Auth->user('id').";";
            }
            // if sub resseller viewing calls
            else if($this->Auth->user('role_id') == 4)
            {
            $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
            INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=1 and dids_users.subresseller_id = ".$this->Auth->user('id').";";
            }
            // admin viewing calls
            else
            {
            $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
            INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=1 ;";
            }
            $calls = $this->Channel->query($query, $cachequeries = false);

            $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
            "<tr>" .
            "<td class=\"gridtableHeader\"><table width=\"100%\" id= \"main\"border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
            "<tr>" .
            "<td width=\"20%\" align=\"center\">Called Number</td>" .
            "<td width=\"20%\" align=\"center\">Customer</td>" .
            "<td width=\"20%\" align=\"center\">Customer</td>" .
            "<td width=\"20%\" align=\"center\">Duration</td>" .
            "<td width=\"20%\" align=\"center\">Calling Number</td>" .
            "</tr>" .
            "</table></td>" .
            "</tr>";
            $i = 0;
            if (count($calls) > 0) {
            foreach ($calls as $call) {
            $class = ' class="grid2dark"';
            if ($i++ % 2 == 0) {
            $class = ' class="grid1light"';
            }
            App::import('Helper', 'Getuser'); // loadHelper('Html'); in CakePHP 1.1.x.x
            $getuser = new GetuserHelper();
            $superresseler = $getuser->getUserNameById($call['dids_users']['superresseler_id']);
            $subressellerId = 'N/A';
            if(isset($call['dids_users']['subresseller_id']))
            {
            $subressellerId = $getuser->getUserNameById($call['dids_users']['subresseller_id']);
            }

            $calltime = date("h:i:s", strtotime($call['channels']['created']));
            $currentTime = date("h:i:s");
            App::import('Helper', 'Date'); // loadHelper('Html'); in CakePHP 1.1.x.x
            $date = new DateHelper();
            $duration = $date->myTime($calltime,$currentTime);
            $strCalls = $strCalls . "<tr" . $class . "><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
            "<tr>" .
            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" . $call['channels']['dest'] . "</td>" .
            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" . $superresseler . "</td>" .
            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" . $subressellerId . "</td>" .
            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" .$duration."</td>" .
            "<td width=\"20%\" align=\"center\" class=\"gridcellborder\">" . $call['channels']['cid_num'] . "</td>" .
            "</tr>" .
            "</table></td>
            </tr>";
            }
            }
            else
            {
            $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
            "<tr>" .
            "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Live Calls</td>" .
            "</tr>" .
            "</table></td>
            </tr>";
            }
            $strCalls = $strCalls . " </table></td>";
            echo $strCalls;
           */
     }

     function getTNActiveCalls() {
          $this->autoRender = false;

          if ($this->Auth->user('role_id')) {

               //$query = "SELECT * from channels;";
               $query = '';
               // if super resseller viewing calls
               if ($this->Auth->user('role_id') == 2) {
                    $query = "SELECT numberranges.`name`, channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) INNER JOIN numberranges ON (numberranges.id=dids.`numberrange_id`) where dids_users.superresseler_id = " . $this->Auth->user('id') . " and dids.IsTestNumber=1 and channels.direction='inbound';";
               }
               // if resseller viewing calls
               else if ($this->Auth->user('role_id') == 3) {
                    $query = "SELECT numberranges.`name`, channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did)  INNER JOIN numberranges ON (numberranges.id=dids.`numberrange_id`) where dids_users.resseller_id = " . $this->Auth->user('id') . " and dids.IsTestNumber=1 and channels.direction='inbound';";
               }
               // if sub resseller viewing calls
               else if ($this->Auth->user('role_id') == 4) {
                    $query = "SELECT numberranges.`name`, channels.created,channels.dest,channels.cid_num,TIMEDIFF(TIME(NOW()),TIME(channels.created))AS Duration,dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did)    INNER JOIN numberranges ON (numberranges.id=dids.`numberrange_id`) where dids_users.subresseller_id = " . $this->Auth->user('id') . " and dids.IsTestNumber=1 and channels.direction='inbound';";
               }
               // admin viewing calls
               else {
                    $query = "SELECT numberranges.`name`, channels.created,channels.dest,channels.cid_num,TIMEDIFF(TIME(NOW()),TIME(channels.created))AS Duration,dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) 
                    INNER JOIN livecalls.channels ON (channels.dest = dids.did) 
                    INNER JOIN numberranges ON (numberranges.id=dids.`numberrange_id`)
                    WHERE dids.IsTestNumber=1 and channels.direction='inbound';";
               }
               $calls = $this->Channel->query($query, $cachequeries = false);
               //print_r($calls);
               $strCalls = "<div class=\"mainheading\"><div></div>" .
                       "<div align=\"left\">Live Calls <div style=\"float:right; margin-right:100px;\">Total Calls in Progress<div id=\"nm\" style=\"float:right;margin-left:10px\">" . count($calls) . "</div></div></div>  </div>" .
                       "<div class=\"maincenterBg\">" .
                       "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                       "<tr>" .
                       "<td align=\"left\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtable\" id=\"tdCalls\" >" .
                       "<table id=\"main3\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"10%\" align=\"center\">Sr.No</td>" .
                        "<td width=\"15%\" align=\"center\">Number Range</td>" .
                       "<td width=\"15%\" align=\"center\">Called Number</td>" .
                       "<td width=\"15%\" align=\"center\" >Customer</td>" .
                       "<td width=\"15%\" align=\"center\">Sub Customer</td>" .
                       "<td width=\"15%\" align=\"center\">Duration</td>" .
                       "<td width=\"15%\" align=\"center\">Calling Number</td>" .
                       "</tr>" .
                       "</table></td>" .
                       "</tr>";

               $i = 0;
               $j = 1;
               if (count($calls) > 0) {
                    foreach ($calls as $call) {


                         $class = ' class="grid2dark"';
                         if ($i++ % 2 == 0) {
                              $class = ' class="grid1light"';
                         }
                         App::import('Helper', 'Getuser'); // loadHelper('Html'); in CakePHP 1.1.x.x
                         $getuser = new GetuserHelper();
                         $superresseler = $getuser->getUserNameById($call['dids_users']['superresseler_id']);
                         $subressellerId = 'N/A';
                         if (isset($call['dids_users']['subresseller_id'])) {
                              $subressellerId = $getuser->getUserNameById($call['dids_users']['subresseller_id']);
                         }

                         //                    	$cli= preg_replace('/\d{5}$/', 'xxxxx', $call['channels']['cid_num']);
                         $strCalls = $strCalls . "<tr" . $class . "><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                                 "<tr>" .
                                 "<td width=\"10%\" align=\"center\" class=\"gridcellborder\">" . $j . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . $call['numberranges']['name'] . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . $call['channels']['dest'] . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . $superresseler . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . $subressellerId . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . $call['0']['Duration'] . "</td>" .
                                 "<td width=\"15%\" align=\"center\" class=\"gridcellborder\">" . preg_replace('/\d{5}$/', 'xxxxx', $call['channels']['cid_num']) . "</td>" .
                                 "</tr>" .
                                 "</table></td>
                                                       </tr>";
                         $j = $j + 1;
                    }
               } else {
                    $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Live Calls</td>" .
                            "</tr>" .
                            "</table></td>
                                                       </tr>";
               }
               $strCalls = $strCalls . " </table></td>";
               echo $strCalls;
          } else {
               echo "you are not authorize to view, please login!";
          }
     }

     function GetCDRS() {
          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $page = $_GET['pg'];
          //echo $page;
          //echo $Subcustomer. "".  $destination ;
          //echo  $destinationval;
          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }


          //	$add_on = $this->getAddOn($this->Auth->user('role_id'), $this->Auth->user('id'));

          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          $query = "select cdrs.`isdaily`,cdrs.operator_name, cdrs.`superresrate`, cdrs.`ressellerrate` , cdrs.`subresrate` ,users.`login`,cdrs.caller_id_name, cdrs.caller_id_number, cdrs.destination_number, cdrs.start_stamp, (cdrs.billsec-cdrs.billsec * (cdrs.Addon/100)) as billsec , cdrs.answer_stamp, cdrs.numberrange_name from cdrs ";
          $querycount = "select count(*) as totalcalls from cdrs ";

          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs.numberrange_name=" . "'" . $destination . "'" . "";
          }
//if super reseller viewing calls
          if ($this->Auth->user('role_id') == 2) {
               $query .= " Inner Join users on users.id = cdrs.superresseler_id ";
               $query1 .= " and $conditonOnTerm  cdrs.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query .= " Inner Join users on users.id = cdrs.resseller_id ";
               $query1 .= " and  cdrs.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query .= " Inner Join users on users.id = cdrs.subresseller_id ";
               $query1 .= " and  cdrs.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
               $query .= " Inner Join users on users.id = cdrs.superresseler_id ";
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and $conditonOnTerm cdrs.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs.start_stamp DESC ";

          $querycount = $querycount . $query1;
          $query = $query . $query1;


          //echo $query . "<br><br>";

          $query .= "limit " . $page . ",100";

          $calls = $this->Cdr->query($query, $cachequeries = false);
          //print_r ($calls);
          //echo $querycount . "<br><br>";
          //		echo $querycount;
          $pagecount = $this->Cdr->query($querycount, $cachequeries = false);
          //print_r ($pagecount);
          $totalrec = $pagecount[0][0]['totalcalls'];
          //echo $totalrec;
          // echo "<br><br>";
          $totalpages = Round(($totalrec) / 100);
          //echo  $totalpages;
          //	 echo "After execution";
          // exit;
          //print_r($calls);


          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\"><tr><td align=\"left\" valign=\"top\">" .
                  "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table id =\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  // "<td width=\"7%\" height=\"29px\" align=\"center\">Vendor</td>".
                  //"<td width=\"12%\" align=\"center\">VendorIP</td>".
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Date/Time</td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Range Name</td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Customer </td>";
                  if($this->Auth->user('role_id') == 1)
               { 
                $strCalls= $strCalls.   "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Operator Name </td>";
               } 
               $strCalls= $strCalls.    "<td width=\"10%\" align=\"left\" style=\"padding-left:5px;\">Payment Term </td>" .
                  "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\">Selling Rate </td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Called Number</td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\">Calling Number</td>" .
                  "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\">Duration(Sec)</td>" .
                  //"<td width=\"7%\" align=\"center\">Billtime</td>".
                  //"<td width=\"7%\" align=\"center\">Reason</td>".
                  "</tr>" .
                  "</table></td>
                                                                           </tr>"
          ;
          // print_r($calls);

          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    $rate = '';
                    if ($this->Auth->user('role_id') == 1) {
                         $rate = "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['superresrate'] . "</td>";
                    }
                    if ($this->Auth->user('role_id') == 2) {
                         $rate = "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['ressellerrate'] . "</td>";
                    }
                    if ($this->Auth->user('role_id') == 3) {
                         $rate = "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['subresrate'] . "</td>";
                    }
                    if ($this->Auth->user('role_id') == 4) {
                         //  $rate = ;
                    }
                    $paymentTermText="Any";
    switch($call['cdrs']['isdaily'])
    {
	case 0:
	$paymentTermText="Weekly";
	break;
	case 1:
	$paymentTermText="Daily";
	break;
	case 2:
	$paymentTermText="Monthly";
	break;
    }
                    //die(print_r($call));
                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            // "<td width=\"7%\" height=\"29px\" align=\"center\" class=\"gridcellborder\">". $call['cdrs']['caller_id_name'] ."</td>".
                            // "<td width=\"14%\" align=\"center\" class=\"gridcellborder\">" . $call['numberranges']['name'] . " </td>".
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['answer_stamp'] . "</td>" .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\" >". $call['cdrs']['numberrange_name'] ."</td>" . "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['users']['login'] . " </td>" ;
                            if($this->Auth->user('role_id') == 1)
                    {
						 $strCalls = $strCalls . "<td width=\"12%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:5px;\">" . $call['cdrs']['operator_name']. "</td>";
					}
                        $strCalls = $strCalls .     "<td width=\"10%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:5px;\">". $paymentTermText ."</td>" .
                             $rate .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['destination_number'] . "</td>" .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . $call['cdrs']['caller_id_number'] . "</td>" .
                            "<td width=\"7%\" align=\"left\" style=\"padding-left:5px;\" class=\"gridcellborder\">" . round($call[0]['billsec'], 2) . "</td>" .
                            // "<td width=\"7%\" align=\"center\">". $call['cdrs']['billsec'] ."</td>".
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No CDRS in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                           </tr>";
          }
          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "
                                                            <div style=\"margin-left:434px;\">
                                                                 <table id=\"navigations\" style=\"margin-left:434px;\">
                                                                      <tr>
                                                                           <td><a href=\"#\" onclick=\"previouse();\"><img src=\"../../app/webroot/img/Previous.png\" width=\"16\" height=\"16\"  /></a></td>
                                                                           <td>Page <input type=\"text\" id=\"pagesnm\" style=\"width:20px;\" onchange=\"recordbyinput();\" /> of	<label id=\"totalpages\">" . $totalpages . "</lable></td>
                                                                           <td><a href=\"#\"  onclick=\"next();\"><img src=\"../../app/webroot/img/Next.png\" width=\"16\" height=\"16\"  /> </a></td>
                                                                      </tr>
                                                                 </table>

                                                            </div>";
          echo $strCalls;
     }

     /*      * ************************************************************ GET Admin CDRS of Last 3 months ********************************* */

     function GetPreAdminCDRS() {
          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $page = $_GET['pg'];
          //echo $page;
          //echo $Subcustomer. "".  $destination ;
          //echo  $destinationval;
          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }


          //	$add_on = $this->getAddOn($this->Auth->user('role_id'), $this->Auth->user('id'));

          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs_archive.isdaily=$payment_term and";	
}

          $query = "select cdrs_archive.caller_id_name, cdrs_archive.caller_id_number, cdrs_archive.destination_number, cdrs_archive.start_stamp, (cdrs_archive.billsec-cdrs_archive.billsec * (cdrs_archive.Addon/100)) as billsec , cdrs_archive.answer_stamp, cdrs_archive.numberrange_name from cdrs_archive ";
          $querycount = "select count(*) as totalcalls from cdrs_archive ";

          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs_archive.numberrange_name=" . "'" . $destination . "'" . "";
          }

          if ($this->Auth->user('role_id') == 2) {
               $query .= " Inner Join users on users.id = cdrs_archive.superresseler_id ";
               $query1 .= " and $conditonOnTerm cdrs_archive.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query .= " Inner Join users on users.id = cdrs_archive.resseller_id ";
               $query1 .= " and  cdrs_archive.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query .= " Inner Join users on users.id = cdrs_archive.subresseller_id ";
               $query1 .= " and  cdrs_archive.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
               $query .= " Inner Join users on users.id = cdrs_archive.superresseler_id ";
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and $conditonOnTerm cdrs_archive.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs_archive.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs_archive.start_stamp DESC ";

          $querycount = $querycount . $query1;
          $query = $query . $query1;


          //			echo $query . "<br><br>";

          $query .= "limit " . $page . ",100";

          $calls = $this->Cdr->query($query, $cachequeries = false);
          //print_r ($calls);
          //echo $querycount . "<br><br>";
          //		echo $querycount;
          $pagecount = $this->Cdr->query($querycount, $cachequeries = false);
          //print_r ($pagecount);
          $totalrec = $pagecount[0][0]['totalcalls'];
          //echo $totalrec;
          // echo "<br><br>";
          $totalpages = Round(($totalrec) / 100);
          //echo  $totalpages;
          //	 echo "After execution";
          // exit;
          //print_r($calls);


          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\"><tr><td align=\"left\" valign=\"top\">" .
                  "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table id =\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  // "<td width=\"7%\" height=\"29px\" align=\"center\">Vendor</td>".
                  //"<td width=\"12%\" align=\"center\">VendorIP</td>".
                  "<td width=\"14%\" align=\"center\">Date/Time</td>" .
                  "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Destination Group</td>" .
                  "<td width=\"14%\" align=\"center\">Caller</td>" .
                  "<td width=\"10%\" align=\"center\">Called</td>" .
                  "<td width=\"7%\" align=\"center\">Duration(Sec)</td>" .
                  //"<td width=\"7%\" align=\"center\">Billtime</td>".
                  //"<td width=\"7%\" align=\"center\">Reason</td>".
                  "</tr>" .
                  "</table></td>
                                                                                               </tr>"
          ;
          // print_r($calls);

          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }

                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            // "<td width=\"7%\" height=\"29px\" align=\"center\" class=\"gridcellborder\">". $call['cdrs']['caller_id_name'] ."</td>".
                            // "<td width=\"14%\" align=\"center\" class=\"gridcellborder\">" . $call['numberranges']['name'] . " </td>".
                            "<td width=\"14%\" align=\"center\" class=\"gridcellborder\">" . $call['cdrs_archive']['answer_stamp'] . "</td>" .
                            "<td width=\"14%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs_archive']['numberrange_name'] . " </td>" .
                            "<td width=\"14%\" align=\"center\" class=\"gridcellborder\">" . $call['cdrs_archive']['caller_id_number'] . "</td>" .
                            "<td width=\"10%\" align=\"center\" class=\"gridcellborder\">" . $call['cdrs_archive']['destination_number'] . "</td>" .
                            "<td width=\"7%\" align=\"center\" class=\"gridcellborder\">" . $call[0]['billsec'] . "</td>" .
                            // "<td width=\"7%\" align=\"center\">". $call['cdrs']['billsec'] ."</td>".
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No CDRS in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                                               </tr>";
          }
          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "
                                                                                <div style=\"margin-left:434px;\">
                                                                                     <table id=\"navigations\" style=\"margin-left:434px;\">
                                                                                          <tr>
                                                                                               <td><a href=\"#\" onclick=\"previouse();\"><img src=\"../../app/webroot/img/Previous.png\" width=\"16\" height=\"16\"  /></a></td>
                                                                                               <td>Page <input type=\"text\" id=\"pagesnm\" style=\"width:20px;\" onchange=\"recordbyinput();\" /> of	<label id=\"totalpages\">" . $totalpages . "</lable></td>
                                                                                               <td><a href=\"#\"  onclick=\"next();\"><img src=\"../../app/webroot/img/Next.png\" width=\"16\" height=\"16\"  /> </a></td>
                                                                                          </tr>
                                                                                     </table>

                                                                                </div>";
          echo $strCalls;
     }

     /*      * *********************************************************** GET Admin CDRS of Last 3 months ********************************* */

     /*      * ************************************************************* Get Admin CDRS ************************************************* */

     function GetAdminCDRS() {
          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $page = $_GET['pg'];
          //echo $page;
          //echo $Subcustomer. "".  $destination ;
          //echo  $destinationval;
          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }

          //echo  (substr($enddate,8,2)+1); ;
          //$query = "SELECT * from channels;";
          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          $query = "select cdrs.caller_id_name,cdrs.operator_name, cdrs.`superresrate`, users.`login`, cdrs.caller_id_number, cdrs.destination_number, cdrs.start_stamp, cdrs.billsec , cdrs.answer_stamp, cdrs.numberrange_name,cdrs.isdaily from cdrs ";
          $querycount = "select count(*) as totalcalls from cdrs ";

          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs.numberrange_name=" . "'" . $destination . "'" . "";
          }

          if ($this->Auth->user('role_id') == 2) {
               $query1 .= " and $conditonOnTerm  cdrs.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query1 .= " and  cdrs.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query1 .= " and  cdrs.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
			$query .= " Inner Join users on users.id = cdrs.superresseler_id ";              
			  if ($subcustomer != -1) {
                    $query1 = $query1 . " and $conditonOnTerm cdrs.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs.start_stamp DESC ";

          $querycount = $querycount . $query1;
          $query = $query . $query1;


          //echo $query . "<br><br>";

          $query .= "limit " . $page . ",100";

          //			echo $query;exit;

          $calls = $this->Cdr->query($query, $cachequeries = false);
          //print_r ($calls);
          //echo $querycount . "<br><br>";
          //		echo $querycount;
          $pagecount = $this->Cdr->query($querycount, $cachequeries = false);
          //print_r ($pagecount);
          $totalrec = $pagecount[0][0]['totalcalls'];
          //echo $totalrec;
          // echo "<br><br>";
          $totalpages = Round(($totalrec) / 100);
          //echo  $totalpages;
          //	 echo "After execution";
          // exit;
          //print_r($calls);


          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\"><tr><td align=\"left\" valign=\"top\">" .
                  "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table id =\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Date/Time</td>" ;
                  if($this->Auth->user('role_id') == 1)
               { 
                $strCalls= $strCalls.   "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Operator Name </td>";
               }    
                $strCalls= $strCalls.   "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Range Name</td>" .
                "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Customer</td>" .
				"<td width=\"10%\" align=\"left\" style=\"padding-left:10px;\">Payment Term</td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Calling Number</td>" .
                  "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\">Called Number</td>" .
                  "<td width=\"10%\" align=\"left\" style=\"padding-left:10px;\">Sel. Rate</td>" .
                  "<td width=\"7%\" align=\"left\" style=\"padding-left:10px;\">Duration(Sec)</td>" .
                  "</tr>" .
                  "</table></td>
                                                                                                                   </tr>"
          ;
          // print_r($calls);

          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
           $paymentTermText="Any";
    switch($call['cdrs']['isdaily'])
    {
	case 0:
	$paymentTermText="Weekly";
	break;
	case 1:
	$paymentTermText="Daily";
	break;
	case 2:
	$paymentTermText="Monthly";
	break;
    }    	
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }

                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['answer_stamp'] . "</td>" ;
                            if($this->Auth->user('role_id') == 1)
                    {
						 $strCalls = $strCalls . "<td width=\"12%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['operator_name']. "</td>";
					}
                       $strCalls = $strCalls .     "<td width=\"12%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['numberrange_name'] . " </td>" .
                             "<td width=\"12%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['users']['login'] . "</td>" .
							"<td width=\"10%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $paymentTermText . "</td>" .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['caller_id_number'] . "</td>" .
                            "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['destination_number'] . "</td>" .
                            "<td width=\"10%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['superresrate'] . "</td>" .
                            "<td width=\"7%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['billsec'] . "</td>" .
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No CDRS in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                                                                   </tr>";
          }
          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "
                                                                                                    <div style=\"margin-left:434px;\">
                                                                                                         <table id=\"navigations\" style=\"margin-left:434px;\">
                                                                                                              <tr>
                                                                                                                   <td><a href=\"#\" onclick=\"previouse();\"><img src=\"../../app/webroot/img/Previous.png\" width=\"16\" height=\"16\"  /></a></td>
                                                                                                                   <td>Page <input type=\"text\" id=\"pagesnm\" style=\"width:20px;\" onchange=\"recordbyinput();\" /> of	<label id=\"totalpages\">" . $totalpages . "</lable></td>
                                                                                                                   <td><a href=\"#\"  onclick=\"next();\"><img src=\"../../app/webroot/img/Next.png\" width=\"16\" height=\"16\"  /> </a></td>
                                                                                                              </tr>
                                                                                                         </table>

                                                                                                    </div>";
          echo $strCalls;
     }

     /*      * ********************************************************************************************************************************** */

     function GetVoiceCall() {

          $this->autoRender = false;

          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $payment_term = $_GET['term'];
          //echo $starttime;
          //echo $endtime;
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];


          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';
$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {
               /*
                 $query = "SELECT users.first_name,users.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(users.add_on/100),2) AS duration,
                 COUNT(cdrs.start_stamp) AS totatcalls,  cdrs.numberrange_name as destination FROM cdrs
                 INNER JOIN users ON cdrs.superresseler_id=users.id";
                */

               $query = "SELECT cdrs.isdaily,u1.first_name,u1.last_name, u2.first_name,u2.last_name, cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration,
                                                                                                    COUNT(cdrs.start_stamp) AS totatcalls,  cdrs.numberrange_name as destination, currencies.currency_name, cdrs.superresrate FROM cdrs
                                                                                                    INNER JOIN users u1 ON cdrs.superresseler_id=u1.id
                                                                                                    LEFT JOIN users u2 ON cdrs.resseller_id=u2.id
                                                                                                    Left Join currencies on currencies.id = cdrs.currency_id ";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.resseller_id=" . $subcustomer . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm cdrs.resseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               /*
                 $query = "SELECT users.first_name,users.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*0.1,2) AS duration,
                 COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                 INNER JOIN users ON cdrs.resseller_id=users.id";
                */

               $query = "SELECT cdrs.isdaily,u1.first_name,u1.last_name,u2.first_name,u2.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration,
                                                                                                    COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination, currencies.currency_name, cdrs.ressellerrate FROM cdrs
                                                                                                    INNER JOIN users u1 ON cdrs.resseller_id=u1.id
                                                                                                    Left Join users u2 on cdrs.subresseller_id = u2.id
                                                                                                    LEFT Join currencies on currencies.id = cdrs.currency_id 					";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.resseller_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and (cdrs.resseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {

               /*
                 $query = "SELECT users.first_name,users.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*0.1,2) AS duration,
                 COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                 INNER JOIN users ON cdrs.resseller_id=users.id";
                */

               $query = "SELECT cdrs.isdaily,users.first_name,users.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2)  AS duration,
                                                                                                    COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination, currencies.currency_name, cdrs.subresrate FROM cdrs
                                                                                                    INNER JOIN users ON cdrs.subresseller_id=users.id
                                                                                                    LEFT Join currencies on currencies.id = cdrs.currency_id ";



               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.subresseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {

               $query = "SELECT cdrs.isdaily,cdrs.operator_name, users.first_name,users.last_name,cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration,
                                                                                                    COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination, currencies.currency_name, cdrs.superresrate FROM cdrs
                                                                                                    INNER JOIN users ON cdrs.superresseler_id=users.id
                                                                                                    LEFT Join currencies on currencies.id = cdrs.currency_id ";
               /*
                 INNER JOIN dids ON cdrs.destination_number=dids.did
                 INNER JOIN numberranges on numberranges.id=dids.numberrange_id ";

                */


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               }
          }

     //   print_r($query);
       // exit();
          //    die();
          //$calls = $this->Channel->query($query, $cachequeries = false);
          // die();
          $calls = $this->Cdr->query($query, $cachequeries = false);
          //  die('outer');

          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Customer </td>";
                if($this->Auth->user('role_id') == 1)
               { 
                $strCalls= $strCalls.   "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Operator Name </td>";
               }    
                 $strCalls= $strCalls.   "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number </td>" .
                  "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\">Calls</td>" .
                  "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\">Minutes</td>" .
                  "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Payment Terms</td>" .
                  "<td width=\"7%\" align=\"center\">Currency</td>" .
                  "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\">Rate</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>";

          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {

    $paymentTermText="Any";
    switch($call['cdrs']['isdaily'])
    {
	case 0:
	$paymentTermText="Weekly";
	break;
	case 1:
	$paymentTermText="Daily";
	break;
	case 2:
	$paymentTermText="Monthly";
	break;
    }

                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    $netsec = $netsec + $call[0]['duration'];
                    $netcalls = $netcalls + $call[0]['totatcalls'];
                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>";
                    if (($this->Auth->user('role_id') == 2) || ($this->Auth->user('role_id') == 3)) {
                         $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['u2']['first_name'] . " " . $call['u2']['last_name'] . "</td>";
                    } else {
                         $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['users']['first_name'] . " " . $call['users']['last_name'] . "</td>";
                         
                    }
                    if($this->Auth->user('role_id') == 1)
                    {
						 $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['operator_name']. "</td>";
					}
                    $strCalls = $strCalls . "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">". $call['cdrs']['destination'] ."</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['destination_number'] . "</td>" .
                            //"<td width=\"12%\" align=\"center\" class=\"gridcellborder\"></td>".
                            "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['totatcalls'] . " </td>" .
                            "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['duration'] . " </td>" .
                            "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $paymentTermText . " </td>" .
                            "<td width=\"7%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['currencies']['currency_name'] . " </td>" .
                            "<td width=\"7%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['cdrs']['superresrate'] . " </td>" .
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                                                                        </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">Total Calls=" . $netcalls . "                Total Minutes=" . $netsec . " </td></tr></table>";
          echo $strCalls;
     }

     /*      * ************************************************ Get Admin Voice Call ************************************************************* */

     function GetAdminVoiceCall() {

          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          //echo $starttime;
          //echo $endtime;
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];
          //echo $destinationtxt;
          //echo $start;
          //echo $end;
          //echo $startdate;
          //$called = $_GET['cld'];
          /*
            $caller = $_GET['clr'];
            $subcustomer = $_GET['sub'];

           */
          //echo $subcustomer;
          // echo   $startdate;
          //$query = "SELECT * from channels;";

          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}
          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {

               $query = "SELECT cdrs.isdaily,users.first_name,users.last_name,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                         COUNT(cdrs.start_stamp) AS totatcalls,  cdrs.numberrange_name as destination FROM cdrs
                                                                                                         INNER JOIN users ON cdrs.superresseler_id=users.id";

               /* numberranges.name
                * INNER JOIN dids ON cdrs.destination_number=dids.did
                 INNER JOIN numberranges on numberranges.id=dids.numberrange_id ";

                */


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {

               $query = "SELECT cdrs.isdaily,users.first_name,users.last_name,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                         COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                         INNER JOIN users ON cdrs.resseller_id=users.id";



               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.resseller_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and (cdrs.resseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {


               $query = "SELECT cdrs.isdaily,users.first_name,users.last_name,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                         COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                         INNER JOIN users ON cdrs.resseller_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.subresseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.isdaily";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {

               $query = "SELECT cdrs.isdaily,cdrs.operator_name,users.first_name,users.last_name,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                         COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination, currencies.currency_name, cdrs.superresrate  FROM cdrs
                                                                                                         INNER JOIN users ON cdrs.superresseler_id=users.id
																										 LEFT Join currencies on currencies.id = cdrs.currency_id ";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               }
          }

          //echo $query;
          //$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->Cdr->query($query, $cachequeries = false);


          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"15%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Customer </td>";
                  if($this->Auth->user('role_id') == 1)
               { 
                $strCalls= $strCalls.   "<td width=\"15%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Operator Name </td>";
               }    

                 $strCalls= $strCalls.  "<td width=\"15%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                  "<td width=\"10%\"  height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number </td>" .
                  "<td width=\"10%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Payment Terms</td>" .
                  "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\">Calls</td>" .
                  "<td width=\"10%\" align=\"right\" style=\"padding-right:10px;\">Minutes</td>" .
                  "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\">Curr.</td>" .
                  "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\">Rate</td>" .				  
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>"
          ;

          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
               
    $paymentTermText="Any";
    switch($call['cdrs']['isdaily'])
    {
	case 0:
	$paymentTermText="Weekly";
	break;
	case 1:
	$paymentTermText="Daily";
	break;
	case 2:
	$paymentTermText="Monthly";
	break;
    } 	
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    $netsec = $netsec + $call[0]['duration'];
                    $netcalls = $netcalls + $call[0]['totatcalls'];
                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"15%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['users']['first_name'] . " " . $call['users']['last_name'] . "</td>";
                            if($this->Auth->user('role_id') == 1)
                    {
						 $strCalls = $strCalls . "<td width=\"15%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['operator_name']. "</td>";
					}
                      $strCalls = $strCalls .      "<td width=\"15%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['destination'] . "</td>" .
                            "<td width=\"10%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['destination_number'] . "</td>" .
                            "<td width=\"10%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $paymentTermText . " </td>" .
                            "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['totatcalls'] . " </td>" .
                            "<td width=\"10%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['duration'] . " </td>" .
                            "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['currencies']['currency_name'] . " </td>" .
                            "<td width=\"5%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['cdrs']['superresrate'] . " </td>" .
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                                                                             </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">Total Calls=" . $netcalls . "                Total Minutes=" . $netsec . " </td></tr></table>";
          echo $strCalls;
     }

     /*      * ************************************************************************************************************************************* */

     /*      * ************************************************ Get Pre Admin Voice Call ************************************************************* */

     function GetPreAdminVoiceCall() {

          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          //echo $starttime;
          //echo $endtime;
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];
          //echo $destinationtxt;
          //echo $start;
          //echo $end;
          //echo $startdate;
          //$called = $_GET['cld'];
          ///        /*
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];

          ///        */
          //echo $subcustomer;
          // echo   $startdate;
          //$query = "SELECT * from channels;";

          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs_archive.isdaily=$payment_term and";	
}
          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {

               $query = "SELECT cdrs_archive.isdaily,users.first_name,users.last_name,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                              COUNT(cdrs_archive.start_stamp) AS totatcalls,  cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                              INNER JOIN users ON cdrs_archive.superresseler_id=users.id";

               /* numberranges.name
                 INNER JOIN dids ON cdrs.destination_number=dids.did
                 INNER JOIN numberranges on numberranges.id=dids.numberrange_id ";

                */


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {

               $query = "SELECT cdrs_archive.isdaily,users.first_name,users.last_name,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                              COUNT(cdrs_archive.start_stamp) AS totatcalls, cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                              INNER JOIN users ON cdrs_archive.resseller_id=users.id";



               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs_archive.resseller_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs_archive.subresseller_id=" . $subcustomer . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs_archive.subresseller_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {


               $query = "SELECT cdrs_archive.isdaily,users.first_name,users.last_name,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                              COUNT(cdrs_archive.start_stamp) AS totatcalls, cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                              INNER JOIN users ON cdrs_archive.resseller_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs_archive.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs_archive.subresseller_id= " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.subresseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.isdaily";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {

               $query = "SELECT cdrs_archive.isdaily,users.first_name,users.last_name,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                              COUNT(cdrs_archive.start_stamp) AS totatcalls, cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                              INNER JOIN users ON cdrs_archive.superresseler_id=users.id";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.superresseler_id,cdrs_archive.isdaily";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.superresseler_id,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.superresseler_id=" . $subcustomer . " and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.superresseler_id,cdrs_archive.isdaily";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.superresseler_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number,cdrs_archive.superresseler_id,cdrs_archive.isdaily";
               }
          }

          //echo $query;
          //$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->Cdr->query($query, $cachequeries = false);


          $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                  "<tr>" .
                  "<td align=\"left\" valign=\"top\"><table id=\"main\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                  "<tr>" .
                  "<td width=\"7%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Customer </td>" .
                  "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                  "<td width=\"14%\" height=\"29px\" align=\"center\">Number </td>" .
                  "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Payment Term</td>" .
                  "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Calls</td>" .
                  "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Minutes</td>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>" .
                  "<tr>" .
                  "</tr>" .
                  "</table></td>" .
                  "</tr>"
          ;

          //print_r($calls);
          $i = 0;
          $txt = 5000;
          $netsec = 0;
          $netcalls = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
    
    $paymentTermText="Any";
    switch($call['cdrs_archive']['isdaily'])
    {
	case 0:
	$paymentTermText="Weekly";
	break;
	case 1:
	$paymentTermText="Daily";
	break;
	case 2:
	$paymentTermText="Monthly";
	break;
    }
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }
                    $netsec = $netsec + $call[0]['duration'];
                    $netcalls = $netcalls + $call[0]['totatcalls'];
                    $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"7%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['users']['first_name'] . " " . $call['users']['last_name'] . "</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs_archive']['destination'] . "</td>" .
                            "<td width=\"14%\" height=\"29px\" align=\"center\" class=\"gridcellborder\">" . $call['cdrs_archive']['destination_number'] . "</td>" .
                            //"<td width=\"12%\" align=\"center\" class=\"gridcellborder\"></td>".
                             "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $paymentTermText . " </td>" .
                            "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['totatcalls'] . " </td>" .
                            "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call[0]['duration'] . " </td>" .
                            //"<td width=\"7%\" align=\"center\">-</td>".
                            "</tr>" .
                            "</table></td>" .
                            "</tr>";
               }
          } else {
               $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Voice Report in this Criteria</td>" .
                       "</tr>" .
                       "</table></td>
                                                                                                                                  </tr>";
          }

          $strCalls = $strCalls . " </table></td>";

          $strCalls = $strCalls . "<table style=\"margin-left:550px;\"><tr><td class=\"mainheading\" style=\"vertical-align:text-top;\">Total Calls=" . $netcalls . "                Total Minutes=" . $netsec . " </td></tr></table>";
          echo $strCalls;
     }

     /*      * ************************************************************************************************************************************* */

     function GetTNList() {

          $this->autoRender = false;
          if ($this->Auth->user('role_id')) {

               //$query = "SELECT * from channels;";
               $query = '';
               // if super resseller viewing calls
               if ($this->Auth->user('role_id') == 2) {
                    $query = "SELECT dids.did, numberranges.name FROM dids
                                                                                                                   INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                                   WHERE dids.IsTestNumber=1 order by name asc ";
               }
               // if resseller viewing calls
               else if ($this->Auth->user('role_id') == 3) {
                    $query = "SELECT dids.did, numberranges.name FROM dids
                                                                                                                   INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                                   WHERE dids.IsTestNumber=1 order by name asc ";
               }
               // if sub resseller viewing calls
               else if ($this->Auth->user('role_id') == 4) {
                    $query = "SELECT dids.did, numberranges.name FROM dids
                                                                                                                   INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                                   WHERE dids.IsTestNumber=1 order by name asc ";

                    // $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    //       INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids_users.subresseller_id = ".$this->Auth->user('id').";";
               }
               // admin viewing CDR
               else {
                    $query = "SELECT dids.did, numberranges.name FROM dids
                                                                                                                   INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                                   WHERE dids.IsTestNumber=1 order by name asc ";
               }
               //$calls = $this->Channel->query($query, $cachequeries = false);
               //echo $query;

               $calls = $this->Cdr->query($query, $cachequeries = false);

               $total = count($calls);

               $half = Round(count($calls) / 3);


               $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                       "<tr>" .
                       "<td align=\"left\" valign=\"top\"><table id=\"main\"  width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtable\"><table  width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtableHeader\"><table  width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"10%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                       "<td width=\"12%\" align=\"right\" style=\"padding-right:10px;\" >Number</td>" .
                       "<td width=\"7%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                       "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Number</td>" .
                       "<td width=\"7%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Number Range </td>" .
                       "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Number</td>" .
                       "</tr>" .
                       "</table></td>" .
                       "</tr>" .
                       "<tr>" .
                       "</tr>" .
                       "</table></td>" .
                       "</tr>"
               ;

               // print_r($calls);
               $i = 0;
               $counter = 0;
               if (count($calls) > 0) {
                    $strCalls = $strCalls . "<tr" . $class . "><td><table width=\"100%\" border=\"0\"><tr><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

                    foreach ($calls as $call) {
                         //foreach(array_combine($calls1, $calls2) as $call1 )
                         $class = ' class="grid2dark"';
                         if ($i++ % 2 == 0) {
                              $class = ' class="grid1light"';
                         }

                         if ($counter >= 0 and $counter <= $half) {
                              $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" valign=\"top\">" .
                                      "<tr>";
                              $strCalls .= "<td width=\"50%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['numberranges']['name'] . "</td>" .
                                      "<td width=\"50%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['dids']['did'] . " </td></tr></table></td></tr>";
                              if ($counter == $half) {
                                   $strCalls .= "</td></tr></table><td class=\"grid1light\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" valign=\"top\">";
                              }
                         } elseif ($counter > $half) {

                              $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                                      "<tr>";
                              $strCalls .= "<td width=\"50%\" height=\"29px\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['numberranges']['name'] . "</td>" .
                                      "<td width=\"50%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['dids']['did'] . " </td></tr></table></td></tr>";

                              $counter = -1;
                         }

                         //"<td width=\"7%\" align=\"center\">-</td>".
                         $counter++;
                    }

                    $strCalls .= "</td></tr></table></td></tr>" .
                            "</table></td>" .
                            "</tr>";
               } else {
                    $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Test Number Found</td>" .
                            "</tr>" .
                            "</table></td>
                                                                                                                   </tr>";
               }
               $strCalls = $strCalls . " </table></td>";
               echo $strCalls;
          } else {
               echo "You are not authorized to view, please login!";
          }
     }

     function GetTNLog() {

          $this->autoRender = false;
          if ($this->Auth->user('role_id')) {
               $query = '';
               // if super resseller viewing calls
               if ($this->Auth->user('role_id') == 2) {
                    $query = " SELECT (cdrs.start_stamp) ,cdrs.caller_id_number, cdrs.destination_number, cdrs.billsec, numberranges.name
                                                                                                              FROM cdrs
                                                                                                              INNER JOIN dids ON dids.did=cdrs.destination_number
                                                                                                              INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                              WHERE dids.IsTestNumber=1 and cdrs.billsec > 0 order by cdrs.start_stamp desc limit 0,99";
               }
               // if resseller viewing calls
               else if ($this->Auth->user('role_id') == 3) {
                    $query = " SELECT (cdrs.start_stamp) ,cdrs.caller_id_number, cdrs.destination_number, cdrs.billsec, numberranges.name
                                                                                                              FROM cdrs
                                                                                                              INNER JOIN dids ON dids.did=cdrs.destination_number
                                                                                                              INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                              WHERE dids.IsTestNumber=1 and cdrs.billsec > 0 order by cdrs.start_stamp desc limit 0,99";
               }
               // if sub resseller viewing calls
               else if ($this->Auth->user('role_id') == 4) {
                    // $query = "SELECT channels.created,channels.dest,channels.cid_num, dids_users.superresseler_id,dids_users.resseller_id, dids_users.subresseller_id FROM livecalls.dids
                    //       INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id) INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids_users.subresseller_id = ".$this->Auth->user('id').";";

                    $query = " SELECT (cdrs.start_stamp) ,cdrs.caller_id_number, cdrs.destination_number, cdrs.billsec, numberranges.name
                                                                                                              FROM cdrs
                                                                                                              INNER JOIN dids ON dids.did=cdrs.destination_number
                                                                                                              INNER JOIN numberranges ON numberranges.id=dids.numberrange_id
                                                                                                              WHERE dids.IsTestNumber=1 and cdrs.billsec > 0 order by cdrs.start_stamp desc limit 0,99";
               }
               // admin viewing CDR
               else {
                    $query = " SELECT DISTINCT (cdrs.start_stamp) ,cdrs.caller_id_number, cdrs.destination_number, cdrs.billsec, numberrange_name
                                                                                                              FROM cdrs
                                                                                                              INNER JOIN dids ON dids.did=cdrs.destination_number																											  
                                                                                                              WHERE dids.IsTestNumber=1 and (cdrs.start_stamp <= Curdate() + 1 and cdrs.start_stamp >= DATE_SUB(NOW(),INTERVAL 5 DAY)) 
																											  and cdrs.billsec > 0 
																											  Group by cdrs.caller_id_number, cdrs.destination_number 
																											  order by cdrs.start_stamp desc limit 0,99";
			
               }
//			   echo $query;exit;
               //$calls = $this->Channel->query($query, $cachequeries = false);
               $calls = $this->Cdr->query($query, $cachequeries = false);
               //print_r($calls);

               $strCalls = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">" .
                       "<tr>" .
                       "<td align=\"left\" valign=\"top\"><table  id=\"main2\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td class=\"gridtableHeader\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                       "<tr>" .
                       "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\">Call Date </td>" .
                       "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">Number Range</td>" .
                       "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Number</td>" .
                       "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\">Duration(Sec)</td>" .
                       "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\">CLI</td>" .
                       "</tr>" .
                       "</table></td>" .
                       "</tr>" .
                       "<tr>" .
                       "</tr>" .
                       "</table></td>" .
                       "</tr>"
               ;

               // print_r($calls);
               $i = 0;
               if (count($calls) > 0) {
                    foreach ($calls as $call) {
                         $class = ' class="grid2dark"';
                         if ($i++ % 2 == 0) {
                              $class = ' class="grid1light"';
                         }
                         $cli = "";
                         $cli = preg_replace('/\d{5}$/', 'xxxxx', $call['cdrs']['caller_id_number']);

                         $strCalls = $strCalls . "<tr" . $class . "><td class=\"grid1light\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                                 "<tr>" .
                                 "<td width=\"14%\" height=\"29px\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $call['cdrs']['start_stamp'] . "</td>" .
                                 "<td width=\"14%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $call['cdrs']['numberrange_name'] . "</td>" .
                                 "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['cdrs']['destination_number'] . "</td>" .
                                 "<td width=\"14%\" align=\"right\" style=\"padding-right:10px;\" class=\"gridcellborder\">" . $call['cdrs']['billsec'] . "</td>" .
                                 "<td width=\"14%\" align=\"left\" style=\"padding-left:10px;\" class=\"gridcellborder\">" . $cli . "</td>" .
                                 //"<td width=\"7%\" align=\"center\">-</td>".
                                 "</tr>" .
                                 "</table></td>" .
                                 "</tr>";
                    }
               } else {
                    $strCalls = $strCalls . "<tr class=\"grid2dark\" ><td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" .
                            "<tr>" .
                            "<td width=\"100%\" align=\"center\" class=\"gridcellborder\">No Test Number Found</td>" .
                            "</tr>" .
                            "</table></td>
                                                                                                                                  </tr>";
               }
               $strCalls = $strCalls . " </table></td>";
               echo $strCalls;
          } else {
               echo "You are not authorized to view, please login!";
          }
     }

     function getContentNew() {
          $timestamp = $_GET['timestamp'];
          $timestamp = $this->timeStampToDate($timestamp);
          $pageContentArr = array();
          $languages = $this->Language->find('all', array('fields' => array('Language.lc', 'Language.name', 'Language.id')));
          $pageContentArr = array();
          $temparr = array();
          foreach ($languages as $lang) {
               $uber_bilgro = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Uber Bilgro')));
               $sortiment = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Sortiment')));
               $angebote = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Angebote')));
               $servicetitle = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Service')));
               $standorte = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Standorte')));
               $adresse = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Adresse')));
               $telefon = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Telefon')));
               $mobil = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Mobil')));
               $fax = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Fax')));
               $email = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'E-Mail')));
               $internet = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Internet')));
               $geoffnet = $this->Titlestranslation->find('first', array('conditions' => array('Titlestranslation.language_id = ' => $lang['Language']['id'], 'Title.name = ' => 'Geoffnet')));

               //about bilgro section
               $aboutbilgro = $this->Section->find('first', array('conditions' => array('Fold.name =' => 'Uber Bilgro', 'Section.language_id =' => $lang['Language']['id'])));
               $about_bilgro = array('title' => $aboutbilgro['Section']['title'], 'heading' => $aboutbilgro['Section']['heading'], 'text' => $aboutbilgro['Section']['content']);

               // getting service
               $path = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'files/';
               $serviceArr = array();
               $allServices = $this->Service->find('all', array('conditions' => array('Service.language_id =' => $lang['Language']['id'], 'Service.status = ' => 1, 'OR' => array('Service.created > ' => $timestamp, 'Service.modified > ' => $timestamp))));

               foreach ($allServices as $service) {
                    array_push($serviceArr, array('service_name' => $service['Service']['title'], 'service_icon' => $path . $service['Service']['image']));
               }

               $pageContentArr[$lang['Language']['lc']] = array('uber_bilgro' => $uber_bilgro['Titlestranslation']['translation'], 'sortiment' => $sortiment['Titlestranslation']['translation'], 'angebote' => $angebote['Titlestranslation']['translation'], 'service' => $servicetitle['Titlestranslation']['translation'], 'standorte' => $standorte['Titlestranslation']['translation'], 'adresse' => $adresse['Titlestranslation']['translation'], 'telefon' => $telefon['Titlestranslation']['translation'], 'mobil' => $mobil['Titlestranslation']['translation'], 'fax' => $fax['Titlestranslation']['translation'], 'email' => $email['Titlestranslation']['translation'], 'internet' => $internet['Titlestranslation']['translation'], 'geoffnet' => $geoffnet['Titlestranslation']['translation'], 'about_bilgro_page' => $about_bilgro, 'services' => $serviceArr);
          }
          echo json_encode($pageContentArr);
          exit;
     }

     function getAllLocations() {
          $timestamp = $_GET['timestamp'];
          $timestamp = $this->timeStampToDate($timestamp);

          $cities = $this->Location->find('list', array('fields' => 'Location.city', 'order' => 'Location.city ASC', 'group' => 'Location.city'));
          $locationService = array();
          $arrdeleted = array();
          $locationArr = array();

          foreach ($cities as $ct) {
               $addedloc = array();
               $allLocations = $this->Location->find('all', array('conditions' => array('Location.deleted = ' => 0, 'Location.city ' => $ct, 'Location.status = ' => 1, 'OR' => array('Location.created > ' => $timestamp, 'Location.modified > ' => $timestamp))));
               foreach ($allLocations as $location) {
                    $weekdayopen = 0;
                    $weekdayclose = 0;
                    $saturdayopen = 0;
                    $saturdayclose = 0;
                    $sundayopen = 0;
                    if ($location['Location']['weekdaysopen'] == 1) {
                         $weekdayopen = 1;
                    } else {
                         $weekdayclose = 1;
                    }
                    if ($location['Location']['saturdaysopen'] == 1) {
                         $saturdayopen = 1;
                    } else {
                         $weekdayclose = 1;
                    }
                    if ($location['Location']['sundayopen'] == 1) {
                         $sundayopen = 1;
                    }
                    array_push($addedloc, array('location_id' => $location['Location']['id'], 'location_name' => $location['Location']['name'], 'location_description' => $location['Location']['description'], 'city' => $location['Location']['city'], 'latitude' => $location['Location']['latitude'], 'longitude' => $location['Location']['longitude'], 'address1' => $location['Location']['address1'], 'address2' => $location['Location']['address2'], 'telephone' => $location['Location']['phone'], 'mobile' => $location['Location']['mobile'], 'fax' => $location['Location']['fax'], 'email' => $location['Location']['email'], 'internet' => $location['Location']['internet'], 'business_hour_text' => $location['Location']['opentiming'], 'weekday_open' => $weekdayopen, 'weekday_close' => $weekdayclose, 'saturday_open' => $saturdayopen, 'saturday_close' => $saturdayclose, 'sunday_open' => $sundayopen));
               }
               $locationArr[$ct] = $addedloc;
          }
          // deleted service
          $deletedLocation = $this->Location->find('all', array('conditions' => array('Location.deleted = ' => 1, 'OR' => array('Location.created > ' => $timestamp, 'Location.modified > ' => $timestamp))));
          foreach ($deletedLocation as $delLocation) {
               array_push($arrdeleted, $delLocation['Location']['id']);
          }
          //max time stamp
          $maxcreated = $this->Location->find('first', array('conditions' => array('Location.deleted = ' => 0), 'fields' => array('MAX(Location.created) as created', 'MAX(Location.modified) as modified')));
          $maxdate = '';

          if ($maxcreated[0]['created'] > $maxcreated[0]['modified']) {
               $maxdate = $maxcreated[0]['created'];
          } else {
               $maxdate = $maxcreated[0]['modified'];
          }
          if (!empty($maxdate)) {
               $maxdate = $this->dateToTimeStamp($maxdate);
          } else {
               $maxdate = $_GET['timestamp'];
          }
          $locationService['added'] = $locationArr;
          $locationService['deleted'] = $arrdeleted;
          $locationService['timestamp'] = $maxdate;
          echo json_encode($locationService);
          exit;
     }

     function getAllDeals() {
          $timestamp = $_GET['timestamp'];
          $timestamp = $this->timeStampToDate($timestamp);
          $anegbote = $this->Anegbote->find('all', array('conditions' => array('Anegbote.deleted = ' => 0, 'Anegbote.status = ' => 1, 'OR' => array('Anegbote.created > ' => $timestamp, 'Anegbote.modified > ' => $timestamp))));
          $AnegboteService = array();
          $arrdeletedcat = array();
          $arrdeleteditems = array();
          $arrAdded = array();
          $imgPath = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'files/';
          $imgThumbPath = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'imagecache/';

          foreach ($anegbote as $angb) {
               $anegbotedetail = $this->Anegbotedetail->find('all', array('conditions' => array('Anegbotedetail.deleted = ' => 0, 'Anegbotedetail.started <=' => date('Y-m-d'), 'Anegbotedetail.ended >=' => date('Y-m-d'), 'Anegbotedetail.anegbote_id = ' => $angb['Anegbote']['id'], 'Anegbotedetail.status = ' => 1, 'OR' => array('Anegbotedetail.created > ' => $timestamp, 'Anegbotedetail.modified > ' => $timestamp))));
               $arrandDetail = array();
               foreach ($anegbotedetail as $detail) {
                    $img = '';
                    $img = $detail['Anegbotedetail']['image'];
                    $imgPath1 = $imgPath . $img;
                    $imgThumbPath1 = $imgThumbPath . $img;
                    array_push($arrandDetail, array('deal_id' => $detail['Anegbotedetail']['id'], 'name' => $detail['Anegbotedetail']['name'], 'deal_thumbnail' => $imgThumbPath1, 'deal_image' => $imgPath1));
               }
               $arrAdded[$angb['Anegbote']['name']] = $arrandDetail;
          }
          // deleted categories
          $deletedanegbote = $this->Anegbote->find('all', array('conditions' => array('Anegbote.deleted = ' => 1, 'Anegbote.status = ' => 1, 'OR' => array('Anegbote.created > ' => $timestamp, 'Anegbote.modified > ' => $timestamp))));
          foreach ($deletedanegbote as $delang) {
               array_push($arrdeletedcat, $delang['Anegbote']['id']);
          }
          // deleted items
          $delAgneDetail = $this->Anegbotedetail->find('all', array('conditions' => array('Anegbotedetail.deleted = ' => 1, 'Anegbotedetail.anegbote_id = ' => $angb['Anegbote']['id'], 'Anegbotedetail.status = ' => 1, 'OR' => array('Anegbotedetail.created > ' => $timestamp, 'Anegbotedetail.modified > ' => $timestamp))));
          foreach ($delAgneDetail as $delangDetail) {
               array_push($arrdeleteditems, $delangDetail['Anegbotedetail']['id']);
          }

          //max time stamp
          $maxcreated = $this->Anegbote->find('first', array('conditions' => array('Anegbote.deleted = ' => 0), 'fields' => array('MAX(Anegbote.created) as created', 'MAX(Anegbote.modified) as modified')));
          $maxdate = '';

          if ($maxcreated[0]['created'] > $maxcreated[0]['modified']) {
               $maxdate = $maxcreated[0]['created'];
          } else {
               $maxdate = $maxcreated[0]['modified'];
          }
          if (!empty($maxdate)) {
               $maxdate = $this->dateToTimeStamp($maxdate);
          } else {
               $maxdate = $_GET['timestamp'];
          }
          $AnegboteService['added'] = $arrAdded;
          $AnegboteService['deleted_category'] = $arrdeletedcat;
          $AnegboteService['deleted_item'] = $arrdeleteditems;
          $AnegboteService['timestamp'] = $maxdate;
          echo json_encode($AnegboteService);
          exit;
     }

     function getAllRanges() {
          $timestamp = $_GET['timestamp'];
          $timestamp = $this->timeStampToDate($timestamp);
          $sortiment = $this->Sortiment->find('all', array('conditions' => array('Sortiment.deleted = ' => 0, 'Sortiment.status = ' => 1, 'OR' => array('Sortiment.created > ' => $timestamp, 'Sortiment.modified > ' => $timestamp))));
          $SortimentService = array();
          $arrdeletedcat = array();
          $arrdeleteditems = array();
          $arrAdded = array();
          $imgPath = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'files/';
          $imgThumbPath = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'imagecache/';

          foreach ($sortiment as $srmnt) {
               $sortimentdetail = $this->Sortimentdetail->find('all', array('conditions' => array('Sortimentdetail.deleted = ' => 0, 'Sortimentdetail.sortiment_id = ' => $srmnt['Sortiment']['id'], 'Sortimentdetail.status = ' => 1, 'OR' => array('Sortimentdetail.created > ' => $timestamp, 'Sortimentdetail.modified > ' => $timestamp))));
               $arrsortDetail = array();
               foreach ($sortimentdetail as $detail) {
                    $img = '';
                    $img = $detail['Sortimentdetail']['image'];
                    $imgPath1 = $imgPath . $img;
                    $imgThumbPath1 = $imgThumbPath . $img;
                    array_push($arrsortDetail, array('product_id' => $detail['Sortimentdetail']['id'], 'product_name' => $detail['Sortimentdetail']['name'], 'product_url' => $imgThumbPath1));
               }
               array_push($arrAdded, array('range_id' => $srmnt['Sortiment']['id'], 'range_name' => $srmnt['Sortiment']['name'], 'range_thumbnail' => $imgThumbPath . $srmnt['Sortiment']['image'], 'range_products' => $arrsortDetail));
          }
          // deleted categories
          $deletedanegbote = $this->Sortiment->find('all', array('conditions' => array('Sortiment.deleted = ' => 1, 'Sortiment.status = ' => 1, 'OR' => array('Sortiment.created > ' => $timestamp, 'Sortiment.modified > ' => $timestamp))));
          foreach ($deletedanegbote as $delang) {
               array_push($arrdeletedcat, $delang['Sortiment']['id']);
          }
          // deleted items
          $delAgneDetail = $this->Sortimentdetail->find('all', array('conditions' => array('Sortimentdetail.deleted = ' => 1, 'Sortimentdetail.sortiment_id = ' => $srmnt['Sortiment']['id'], 'Sortimentdetail.status = ' => 1, 'OR' => array('Sortimentdetail.created > ' => $timestamp, 'Sortimentdetail.modified > ' => $timestamp))));
          foreach ($delAgneDetail as $delangDetail) {
               array_push($arrdeleteditems, $delangDetail['Sortimentdetail']['id']);
          }

          //max time stamp
          $maxcreated = $this->Sortiment->find('first', array('conditions' => array('Sortiment.deleted = ' => 0), 'fields' => array('MAX(Sortiment.created) as created', 'MAX(Sortiment.modified) as modified')));
          $maxdate = '';

          if ($maxcreated[0]['created'] > $maxcreated[0]['modified']) {
               $maxdate = $maxcreated[0]['created'];
          } else {
               $maxdate = $maxcreated[0]['modified'];
          }
          if (!empty($maxdate)) {
               $maxdate = $this->dateToTimeStamp($maxdate);
          } else {
               $maxdate = $_GET['timestamp'];
          }
          $SortimentService['added'] = $arrAdded;
          $SortimentService['deleted_range'] = $arrdeletedcat;
          $SortimentService['deleted_products'] = $arrdeleteditems;
          $SortimentService['timestamp'] = $maxdate;
          echo json_encode($SortimentService);
          exit;
     }

     function getStory() {

          $this->autoRender = false;
          $query = '';


          $query = "select news.detail from news where status=1 order by id desc limit 1 ";

          //$calls = $this->Channel->query($query, $cachequeries = false);
          $calls = $this->News->query($query, $cachequeries = false);
          //print_r($calls);
          // print_r($calls);
          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }


                    $strCalls = $call['news']['detail'];
               }
          } else {

          }

          echo $strCalls;
     }

     function timeStampToDate($timestamp) {
          $year = $timestamp[0] . $timestamp[1];
          $month = $timestamp[2] . $timestamp[3];
          $day = $timestamp[4] . $timestamp[5];
          $hour = $timestamp[6] . $timestamp[7];
          $min = $timestamp[8] . $timestamp[9];
          $sec = $timestamp[10] . $timestamp[11];
          return $tempdate = '20' . $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec;
     }

     function dateToTimeStamp($date) {
          $timestamp = strtotime($date);
          return $date = date("ymdHis", $timestamp);
     }

     function convertToUTF8($str) {
          $enc = mb_detect_encoding($str);

          if ($enc && $enc != 'UTF-8') {
               return iconv($enc, 'UTF-8', $str);
          } else {
               return $str;
          }
     }

     function NumberRange() {
          $number = $_GET['number'];
          echo $number;
          $this->autoRender = false;
          //echo "called";
          $this->redirect(array('controller' => 'dids', 'action' => 'index'));
          //$this->redirect('/dids/index/'.$number);
          // $this->requestAction('/dids/index/'.$number);
          //$this->set('data', $damu);
          //print_r (data);
     }

     function downlaodcdr() {

          //data
          //$this->autoRender = false;
          //         $filename = "cdrs.csv";
          //         $objWrite = fopen($filName, "w");
          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          ////echo $startdate;
          //echo $subcustomer;

          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }

          //echo  (substr($enddate,8,2)+1); ;
          //$query = "SELECT * from channels;";
          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          $query = "select cdrs.caller_id_name, cdrs.caller_id_number, cdrs.destination_number, cdrs.start_stamp, (cdrs.billsec-cdrs.billsec * (cdrs.Addon/100))  as billsec, cdrs.answer_stamp, cdrs.numberrange_name ,CASE cdrs.`isdaily`  WHEN 1 THEN 'Daily' WHEN 0 THEN 'Weekly' WHEN 2 THEN 'Monthly' ELSE 'Any' END AS   'Payment Term' from cdrs ";


          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs.numberrange_name=" . "'" . $destination . "'" . "";
          }

          if ($this->Auth->user('role_id') == 2) {
               $query1 .= " and $conditonOnTerm  cdrs.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query1 .= " and  cdrs.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query1 .= " and  cdrs.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
				$query = "select cdrs.caller_id_name, cdrs.caller_id_number, cdrs.destination_number, cdrs.start_stamp, (cdrs.billsec-cdrs.billsec * (cdrs.Addon/100))  as billsec, cdrs.answer_stamp, cdrs.numberrange_name ,cdrs.`operator_name` as 'Operator Name',CASE cdrs.`isdaily`  WHEN 1 THEN 'Daily' WHEN 0 THEN 'Weekly' WHEN 2 THEN 'Monthly' ELSE 'Any' END AS   'Payment Term' from cdrs ";
				if ($subcustomer != -1) {
			   $query1 = $query1 . " and $conditonOnTerm cdrs.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs.start_stamp DESC ";
          $query = $query . $query1;
//			echo $query;exit;
          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);




          //$today = date('Y-m-d H:i:s');
          $today = $todaydate . $NowisTime;
          $filename = "CDR" . $this->Auth->user('id') . $today . ".csv";
          //     echo $filename;

          $csv_terminated = "\n";
          $csv_separator = ",";
          $csv_enclosed = '"';
          $csv_escaped = "\\";
          //echo ($query);
          $sql_query = $query;

          // Gets the data from the database
          $res = mysql_query($sql_query);
          $fp = fopen("../../app/webroot/" . $filename, "w");
          //	echo $fp;exit;
          // $fields_cnt = mysql_num_fields($result);
          // fetch a row and write the column names out to the file
          $row = mysql_fetch_assoc($res);
          //echo ($row);

          $line = "";
          $comma = ",";
          foreach ($row as $name => $value) {
               $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
               $comma = ",";
          }
          $line .= "\n";

          fputs($fp, $line);
          // remove the result pointer back to the start
          mysql_data_seek($res, 0);

          // and loop through the actual data
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
          //header( 'Location: http://184.154.5.83/livecalls/app/webroot/export.csv' ) ;
          fclose($fp);
          //$Reports->download($filename);
          //$this->download($filename);
          //echo $filename;
          exit;
          // $this->requestAction('/reprots/download', array('pass' => array($filename)));
          //  echo $this->requestAction('/reprots/download/');
     }

     /*      * **************************************************************** Admin Download CDR ******************************************************** */

     function downlaodadmincdr() {
          //data
          //$this->autoRender = false;
          $filename = "cdrs.csv";
          $objWrite = fopen($filName, "w");

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          ////echo $startdate;
          //echo $subcustomer;

          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }

          //echo  (substr($enddate,8,2)+1); ;
          //$query = "SELECT * from channels;";
          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          $query = "select cdrs.caller_id_name, cdrs.caller_id_number, cdrs.destination_number, cdrs.start_stamp, cdrs.billsec , cdrs.answer_stamp, cdrs.numberrange_name,cdrs.`operator_name` as 'Operator Name',CASE cdrs.`isdaily`  WHEN 1 THEN 'Daily' WHEN 0 THEN 'Weekly' WHEN 2 THEN 'Monthly' ELSE 'Any' END AS   'Payment Term' from cdrs ";


          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs.numberrange_name=" . "'" . $destination . "'" . "";
          }

          if ($this->Auth->user('role_id') == 2) {
               $query1 .= " and $conditonOnTerm  cdrs.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query1 .= " and  cdrs.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query1 .= " and  cdrs.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and $conditonOnTerm cdrs.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs.start_stamp DESC ";
          $query = $query . $query1;

          echo $query;
          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);




          //$today = date('Y-m-d H:i:s');
          $today = $todaydate . $NowisTime;
          $filename = "CDR" . $this->Auth->user('id') . $today . ".csv";
          echo $filename;

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
          //echo ($row);

          $line = "";
          $comma = ",";
          foreach ($row as $name => $value) {
               $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
               $comma = ",";
          }
          $line .= "\n";

          fputs($fp, $line);
          // remove the result pointer back to the start
          mysql_data_seek($res, 0);

          // and loop through the actual data
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
          //header( 'Location: http://184.154.5.83/livecalls/app/webroot/export.csv' ) ;
          fclose($fp);
          //$Reports->download($filename);
          //$this->download($filename);
          //echo $filename;
          exit;
          // $this->requestAction('/reprots/download', array('pass' => array($filename)));
          //  echo $this->requestAction('/reprots/download/');
     }

     /*      * ************************************************************************************************************************************************** */


     /*      * **************************************************************** Admin Download CDR ******************************************************** */

     function downlaodpreadmincdr() {
          //data
          //$this->autoRender = false;
          $filename = "cdrs.csv";
          $objWrite = fopen($filName, "w");

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $called = $_GET['cld'];
          $caller = $_GET['clr'];
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationval = $_GET['nmval'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          ////echo $startdate;
          //echo $subcustomer;

          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               //echo $enddate;
          } else {

          }

          //echo  (substr($enddate,8,2)+1); ;
          //$query = "SELECT * from channels;";
          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs_archive.isdaily=$payment_term and";	
}

          $query = "select cdrs_archive.caller_id_name, cdrs_archive.caller_id_number, cdrs_archive.destination_number, cdrs_archive.start_stamp, cdrs_archive.billsec , cdrs_archive.answer_stamp, cdrs_archive.numberrange_name from cdrs_archive ";


          $query1 = " where ";
          if ($startdate != null && $enddate != null) {
               $query1 = $query1 . "  start_stamp BETWEEN  " . "'" . $start . "'" . " and " . "'" . $end . "'";
          }
          if ($called != null) {
               $query1 = $query1 . " and destination_number=" . $called . "";
          }
          if ($caller != null) {
               $query1 = $query1 . " and caller_id_number=" . $caller . "";
          }
          if ($destinationval != -1) {
               $query1 = $query1 . " and cdrs_archive.numberrange_name=" . "'" . $destination . "'" . "";
          }

          if ($this->Auth->user('role_id') == 2) {
               $query1 .= " and $conditonOnTerm  cdrs_archive.superresseler_id = " . $this->Auth->user('id');

               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.resseller_id=" . $subcustomer . "";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {
               $query1 .= " and  cdrs_archive.resseller_id= " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.subresseller_id=" . $subcustomer . "";
               }
               //             $query=$query . " and cdrs.resseller_id=".$subcustomer ."" ;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {
               $query1 .= " and  cdrs_archive.subresseller_id = " . $this->Auth->user('id');
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and cdrs_archive.subresseller_id=" . $subcustomer . "";
               }
          }
          // admin viewing CDR
          else if ($this->Auth->user('role_id') == 1) {
               if ($subcustomer != -1) {
                    $query1 = $query1 . " and $conditonOnTerm cdrs_archive.superresseler_id=" . $subcustomer . "";
               }
               else if($conditonOnTerm!='')
               {
			   $query1 = $query1 . " and cdrs_archive.isdaily=$payment_term";
			   }
          }
          $query1 = $query1 . " order by cdrs_archive.start_stamp DESC ";
          $query = $query . $query1;

          echo $query;
          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);




          //$today = date('Y-m-d H:i:s');
          $today = $todaydate . $NowisTime;
          $filename = "CDR" . $this->Auth->user('id') . $today . ".csv";
          echo $filename;

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
          //echo ($row);

          $line = "";
          $comma = ",";
          foreach ($row as $name => $value) {
               $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
               $comma = ", ";
          }
          $line .= "\n";

          fputs($fp, $line);
          // remove the result pointer back to the start
          mysql_data_seek($res, 0);

          // and loop through the actual data
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
          //header( 'Location: http://184.154.5.83/livecalls/app/webroot/export.csv' ) ;
          fclose($fp);
          //$Reports->download($filename);
          //$this->download($filename);
          //echo $filename;
          exit;
          // $this->requestAction('/reprots/download', array('pass' => array($filename)));
          //  echo $this->requestAction('/reprots/download/');
     }

     /*      * ************************************************************************************************************************************************** */

     function download($file1) {

          // echo "download entered"   ;
          //exit;
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;
          $latest_ctime = 0;
          $latest_filename = '';

          $d = dir($path);
          while (false !== ($entry = $d->read())) {
               $filepath = "{$path}/{$entry}";
               // could do also other checks than just checking whether the entry is a file

               if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
                    $latest_ctime = filectime($filepath);
                    $latest_filename = $entry;
               }
          }

          //echo $filepath;

          $file = $_SERVER['SERVER_ADDR'] . "../../app/webroot/" . $latest_filename;
          //echo $file;exit;
          @ob_end_clean();
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function getsubcus() {
          //echo "me called";
          $this->autoRender = false;


          $query = '';
          // if admin viewing calls
          if ($this->Auth->user('role_id') == 1) {
               $query = "select users.id, users.first_name, login from users where users.role_id=2 ORDER BY users.login ASC";
          } else if ($this->Auth->user('role_id') == 2) {
               $query = "select users.id, users.first_name, login from users where users.role_id=3 and users.created_by= " . $this->Auth->user('id') . " ORDER BY users.login ASC";
          } else if ($this->Auth->user('role_id') == 3) {
               $query = "select users.id, users.first_name, login from users where users.role_id=4 and users.created_by= " . $this->Auth->user('id') . " ORDER BY users.login ASC";
          }


          $calls = $this->User->query($query, $cachequeries = false);
          //print_r($calls);

          $strCalls = "<select   name=\"subcustomer\" style=\"width:200px\" id=\"subcustomers\">";
          $strCalls = $strCalls . "<option value=\"-1\">Any</option>";


          //
          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }


                    $strCalls = $strCalls . "<option value=" . $call['users']['id'] . ">" . $call['users']['login'] . "</option>";
               }
          } else {

          }
          $strCalls = $strCalls . " </select>";
          echo $strCalls;
     }

     function getdestinations() {
          //echo "me called";
          $this->autoRender = false;


          $query = '';
          // if admin viewing calls
          //$query = "select numberranges.id, numberranges.name from numberranges";
          $query = "Select distinct numberranges.name, numberranges.id
                                                                                                                   from numberranges
                                                                                                                   Inner Join dids on dids.numberrange_id = numberranges.id
                                                                                                                   Inner Join dids_users on dids_users.did_id = dids.id";

          if ($this->Auth->user('role_id') == 1) {

               $query = "select numberranges.id, numberranges.name from numberranges ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 2) {

               $query = $query . " Inner Join users on users.id = (dids_users.superresseler_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 3) {

               $query = $query . " Inner Join users on users.id = (dids_users.resseller_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 4) {

               $query = $query . " Inner Join users on users.id = (dids_users.subresseller_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          //echo $query;
          $calls = $this->Numberrange->query($query, $cachequeries = false);
          // print_r($calls);

          $strCalls = "<select   name=\"ddlnumber\" style=\"width:200px\" id=\"ddlnumber\">";
          $strCalls = $strCalls . "<option value=\"-1\">Any</option>";


          //
          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }


                    $strCalls = $strCalls . "<option value=" . $call['numberranges']['id'] . ">" . $call['numberranges']['name'] . "</option>";
               }
          } else {

          }
          $strCalls = $strCalls . " </select>";
          echo $strCalls;
     }

     function getdestinationsmynm() {

          $this->autoRender = false;


          $query = '';
          // if admin viewing calls
          //$query = "select numberranges.id, numberranges.name from numberranges";
          $query = "Select distinct numberranges.name, numberranges.id
                                                                                                                   from numberranges
                                                                                                                   Inner Join dids on dids.numberrange_id = numberranges.id
                                                                                                                   Inner Join dids_users on dids_users.did_id = dids.id";

          if ($this->Auth->user('role_id') == 1) {

               $query = "select numberranges.id, numberranges.name from numberranges ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 2) {

               $query = $query . " Inner Join users on users.id = (dids_users.superresseler_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 3) {

               $query = $query . " Inner Join users on users.id = (dids_users.resseller_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          if ($this->Auth->user('role_id') == 4) {

               $query = $query . " Inner Join users on users.id = (dids_users.subresseller_id)
                                                                                                                   where users.id =" . $this->Auth->user('id') . " ORDER BY numberranges.name ASC";
          }

          //echo $query;
          $calls = $this->Numberrange->query($query, $cachequeries = false);
          // print_r($calls);

          $strCalls = "<select name=\"ddlnumber\" style=\"border:1px solid #40C900;float: left;height: 30px; width: 102px\" id=\"DidNumberrangeId\" onchange=\"numberfilter();\">";
          $strCalls = $strCalls . "<option value=\"-1\">Any</option>";


          //
          $i = 0;
          if (count($calls) > 0) {
               foreach ($calls as $call) {
                    $class = ' class="grid2dark"';
                    if ($i++ % 2 == 0) {
                         $class = ' class="grid1light"';
                    }


                    $strCalls = $strCalls . "<option value=" . $call['numberranges']['id'] . ">" . $call['numberranges']['name'] . "</option>";
               }
          } else {

          }
          $strCalls = $strCalls . " </select>";
          echo $strCalls;
     }

     function downloadvoicecall() {

          $this->autoRender = false;

          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];

          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];
          $payment_term = $_GET['term'];


          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}

          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {


               $query = "SELECT users.login, cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2)  AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls,  cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.superresseler_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {


               $query = "SELECT users.login, cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2)  AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.resseller_id=users.id";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.resseller_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and (cdrs.resseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {

          }
          // admin viewing CDR
          else {


               $query = "SELECT users.login, cdrs.destination_number,Round(Round(SUM(cdrs.billsec)/60,2)-Round(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.superresseler_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number, cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`,cdrs.`Addon`";
               }
          }


          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);

          $today = $todaydate . $NowisTime;
          $filename = "SB" . $this->Auth->user('id') . $today . ".csv";
          // echo $filename;

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
          echo ($row);

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
          exit;
     }

     /*      * **************************************************** Download Admin Voice Call *************************************************** */

     function downloadadminvoicecall() {

          $this->autoRender = false;

          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];
          $payment_term = $_GET['term'];

          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];


          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs.isdaily=$payment_term and";	
}
          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {


               $query = "SELECT users.login,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls,  cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.superresseler_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.superresseler_id = " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {


               $query = "SELECT users.login,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.resseller_id=users.id";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs.resseller_id = " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and (cdrs.resseller_id= " . $this->Auth->user('id') . ") and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs.subresseller_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs.resseller_id= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {

          }
          // admin viewing CDR
          else {


               $query = "SELECT users.login,cdrs.destination_number,Round(SUM(cdrs.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs.start_stamp) AS totatcalls, cdrs.numberrange_name as destination FROM cdrs
                                                                                                                   INNER JOIN users ON cdrs.superresseler_id=users.id";
                                                                                                                   


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm  cdrs.superresseler_id=" . $subcustomer . " and cdrs.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs.destination_number,cdrs.superresseler_id,cdrs.isdaily,cdrs.`superresrate`";
               }
          }


          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);

          $today = $todaydate . $NowisTime;
          $filename = "SB" . $this->Auth->user('id') . $today . ".csv";
          // echo $filename;

          $csv_terminated = "\n";
          $csv_separator = ",";
          $csv_enclosed = '"';
          $csv_escaped = "\\";
         
          $sql_query = $query;

          // Gets the data from the database
          $res = mysql_query($sql_query);
          $fp = fopen($filename, "w");


          // $fields_cnt = mysql_num_fields($result);
          // fetch a row and write the column names out to the file
          $row = mysql_fetch_assoc($res);
          echo ($row);

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
          exit;
     }

     /*      * ************************************************************************************************************************************** */

     /*      * **************************************************** Download Pre Admin Voice Call *************************************************** */

     function predownloadadminvoicecall() {

          $this->autoRender = false;

          $payment_term = $_GET['term'];
          $startdate = $_GET['strdt'];
          $enddate = $_GET['edt'];
          $starttime = $_GET['stt'];
          $endtime = $_GET['endt'];

          $start = $startdate . " " . $starttime;
          $end = $enddate . " " . $endtime;
          $subcustomer = $_GET['sub'];
          $destination = $_GET['dst'];
          $destinationtxt = $_GET['dsttxt'];


          $day = substr($enddate, 8, 2);
          $month = substr($enddate, 5, 2);
          $year = substr($enddate, 0, 4);

          if (substr($day, 0, 1) == 0 && substr($day, 1, 1) == 9) {
               $day = 10;
          } else if (substr($day, 0, 1) == 1 && substr($day, 1, 1) == 9) {

               $day = 20;
          } else if (substr($day, 0, 1) == 2 && substr($day, 1, 1) == 9) {

               $day = 30;
          } else if (substr($day, 0, 1) == 0 && substr($day, 1, 1) < 9) {

               $day = ($day + 1);
               $day = "0" . $day;
          } else {
               $day = $day + 1;
          }
          // echo("day=".$day."month=".$month."year=".$year);
          if ($startdate == $enddate) {
               if (strlen($day) == 1) {
                    $day = "0" . $day;
               }
               $enddate = $year . "-" . $month . "-" . $day;
               // echo $enddate;
          } else {

          }




          $query = '';

$conditonOnTerm="";
if($payment_term!=-1)
{
$conditonOnTerm="cdrs_archive.isdaily=$payment_term and";	
}
          // if super resseller viewing calls
          if ($this->Auth->user('role_id') == 2) {


               $query = "SELECT users.login,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs_archive.start_stamp) AS totatcalls,  cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                                   INNER JOIN users ON cdrs_archive.superresseler_id=users.id";


               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm dids_users.resseller_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.superresseler_id = " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               }
          }
          // if resseller viewing calls
          else if ($this->Auth->user('role_id') == 3) {


               $query = "SELECT users.login,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs_archive.start_stamp) AS totatcalls, cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                                   INNER JOIN users ON cdrs_archive.resseller_id=users.id";

               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE (cdrs_archive.resseller_id = " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . "GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE cdrs_archive.subresseller_id=" . $subcustomer . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . ") and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE cdrs_archive.subresseller_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (cdrs_archive.resseller_id= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               }

               // echo $query;
          }
          // if sub resseller viewing calls
          else if ($this->Auth->user('role_id') == 4) {

          }
          // admin viewing CDR
          else {


               $query = "SELECT users.login,cdrs_archive.destination_number,Round(SUM(cdrs_archive.billsec)/60,2) AS duration,
                                                                                                                   COUNT(cdrs_archive.start_stamp) AS totatcalls, cdrs_archive.numberrange_name as destination FROM cdrs_archive
                                                                                                                   INNER JOIN users ON cdrs_archive.superresseler_id=users.id";



               if ($subcustomer == -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer == -1 && $destination != -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and (users.id = " . $this->Auth->user('id') . " or users.created_by= " . $this->Auth->user('id') . " ) and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination == -1) {

                    $query = $query . " WHERE $conditonOnTerm  cdrs_archive.superresseler_id=" . $subcustomer . " and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               } else if ($subcustomer != -1 && $destination != -1) {
                    $query = $query . " WHERE $conditonOnTerm  cdrs_archive.superresseler_id=" . $subcustomer . " and cdrs_archive.numberrange_name=" . "'" . $destinationtxt . "'" . " and cdrs_archive.start_stamp BETWEEN " . "'" . $start . "'" . " and " . "'" . $end . ":59'" . " GROUP BY cdrs_archive.destination_number";
               }
          }


          $todaydate = date('Ymd');
          $time_utc = mktime(date('G'), date('i'), date('s'));
          $NowisTime = date('Gis', $time_utc);

          $today = $todaydate . $NowisTime;
          $filename = "SB" . $this->Auth->user('id') . $today . ".csv";
          // echo $filename;

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
          echo ($row);

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
          exit;
     }

     /*      * ************************************************************************************************************************************** */

     function downloadsb($file1) {

          // echo "download entered"   ;
          //exit;
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;
          $latest_ctime = 0;
          $latest_filename = '';

          $d = dir($path);
          while (false !== ($entry = $d->read())) {
               $filepath = "{$path}/{$entry}";
               // could do also other checks than just checking whether the entry is a file

               if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
                    $latest_ctime = filectime($filepath);
                    $latest_filename = $entry;
               }
          }

          //echo $filepath;

          $file = "../../app/webroot/" . $latest_filename;
          //echo $file;exit;

          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$latest_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function download_invoice_report($file1) {

          // echo "download entered"   ;
          //exit;
          // $file1 = $_GET['cid'];
          $this->autoRender = false;

          $path = WWW_ROOT;
          //echo WWW_ROOT;
          //$path = "../webroot";
          //exit;

          if ($file1 == 1) {
          	 $download_filename = 'daily_'.date('d-m-Y',strtotime("-1 days")).'.csv';
               $latest_filename = 'daily.csv';
          } else if ($file1 == 0) {
            $formate_date = date('d-m-Y',strtotime('Monday last week')).'_to_'.date('d-m-Y',strtotime('Sunday last week'));
          	$download_filename = 'weekly_'.$formate_date.'.csv';
               $latest_filename = 'weekly.csv';
          }
          else if ($file1 == 2) {
            $formate_date = date('d-m-Y',strtotime('first day of last month')).'_to_'.date('d-m-Y',strtotime('last day of last month'));
          	$download_filename = 'monthly_'.$formate_date.'.csv';
               $latest_filename = 'monthly.csv';
          }
          //echo $filepath;
          //echo $file;exit;
          $file = "../../app/webroot/" . $latest_filename;
          //  $latest_filename = $file;
          if (file_exists($latest_filename)) {

               header("Pragma: public");
               header("Expires: 0");
               header("Cache-Control: private", false); // required for certain browsers
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-Type: text/x-csv");
               header("Content-Disposition: attachment;filename=\"$download_filename\"");
               header('Content-Length: ' . filesize($latest_filename));
               header("Content-Transfer-Encoding: binary");
               readfile("$latest_filename");
               exit;
          } else {
               echo "File Does not exists";
          }
     }

     function change_status() {
          $this->autoRender = FALSE;
          $pref = '';
          //   echo 'hello';
          $user_id = $this->Auth->user('id');
          if (isset($_GET['pref'])) {
               $pref = $_GET['pref'];
               $query = "UPDATE users SET users.`preference`='{$pref}' WHERE users.`id`=" . $user_id;
               mysql_query($query) or die('Unable To Update Status');
               echo "Successfully Updated Your's Preferences";
          }
     }

     function get_status() {
          $this->autoRender = FALSE;
          $user_id = $this->Auth->user('id');
          $query = "SELECT users.`preference` FROM users WHERE users.`id`=" . $user_id;
          $result = mysql_query($query) or die('');
          $r = mysql_fetch_array($result);
          echo $r[0];
     }

}



?>
