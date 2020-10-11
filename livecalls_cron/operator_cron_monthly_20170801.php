<?php
//  Execute On 12 am 1st day of Every  Month

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

$query5="SELECT operators.`id` FROM operators WHERE operators.isweekly=0";
//echo $query5;
$result=mysql_query($query5) or die(mysql_error());
$usd=0;
		$gbp=0;
		$euro=0;
		$aa=-1;
	while ( $r = mysql_fetch_array($result)){
		//echo'id ='.$r[0].'<br>';
		
		$query2="
SELECT  numberranges.`buyingrate` AS superresrate,ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration, 
ROUND(((ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2))* numberranges.`sellingrate`),2) AS total , COUNT(cdrs.start_stamp) AS totatcalls ,cdrs.`numberrange_name` ,currencies.id AS currenciesid , numberranges.`operator_id` FROM cdrs
JOIN numberranges ON numberranges.`name`=cdrs.`numberrange_name`
JOIN operators ON operators.`id`=numberranges.`operator_id`
LEFT JOIN currencies ON currencies.id = cdrs.currency_id 
WHERE numberranges.`operator_id`=".$r[0]." AND cdrs.start_stamp BETWEEN CURDATE()+INTERVAL -1 MONTH AND SUBTIME( CONCAT(CURDATE(), ' 00:00:00'),'00:00:01')
GROUP BY numberranges.`id`,cdrs.`superresrate`,cdrs.`Addon`
	";
	$query_temp="
SELECT  numberranges.`buyingrate` AS superresrate,ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration, 
ROUND(((ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2))* numberranges.`sellingrate`),2) AS total , COUNT(cdrs.start_stamp) AS totatcalls ,cdrs.`numberrange_name` ,currencies.id AS currenciesid , numberranges.`operator_id` FROM cdrs
JOIN numberranges ON numberranges.`name`=cdrs.`numberrange_name`
JOIN operators ON operators.`id`=numberranges.`operator_id`
LEFT JOIN currencies ON currencies.id = cdrs.currency_id 
WHERE numberranges.`operator_id`=".$r[0]." AND cdrs.start_stamp BETWEEN '2014-08-01 00:00:00' AND '2014-08-31 23:59:59'
GROUP BY numberranges.`id`
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
				if($nr==' ' || $nr==null){
					$nr='Unknown';
				}
			
			$tp=$d*$r;
			
		//	if($sr==1){
		//		$usd=$usd + $tp;
		//	}
		//	if($sr==4){
		//		$gbp=$gbp + $tp;
		//	}
		//	if($sr==2){
		//		$euro=$euro + $tp;
		//	}
			
			
			//echo "OUT";
			if($c==0){
			//echo "<br>iN<br>";
				$c++;
				$q10="INSERT INTO `operator_invoices`( `operator_id`,isweekly) VALUES ({$r2['operator_id']},0) ";
			//echo  $q10;
			mysql_query($q10) or die(mysql_error());
			$invoice_id=mysql_insert_id();
				
				
				
			}
			
			$q7="INSERT INTO `operator_invoice_details`( `operator_invoice_id`, `currency_id`,  `minutes`, `rate`, `invoice_total`,`numberrange_name`) VALUES ({$invoice_id},{$sr},{$d},{$r},{$tp},'{$nr}') ";
			echo $q7;
		 mysql_query($q7) or die(mysql_error());
		
		}
		
		//if($aa != $invoice_id){
		//	$aa = $invoice_id;
			//$iid=$invoice_id-1;
		//$q8="INSERT INTO `invoice_reports`( `invoice_id`, `total_usd`,`total_gbp`,`total_euro`) VALUES ({$invoice_id},{$usd},{$gbp},{$euro} )";
		//	echo $q8.'<br>';
		//	mysql_query($q8) or die(mysql_error());
		 $usd=0;
		$gbp=0;
		$euro=0;
		//}	
	}
//echo '<br>'.$query9.'<br>';
//mysql_query($query9) or die(mysql_error());


?>
