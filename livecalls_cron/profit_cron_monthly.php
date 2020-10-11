<?php
// Execute On 12 am 1st day of Every  Month
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


	
		//echo'id ='.$r[0].'<br>';
		
		$query2="
SELECT  numberranges.`sellingrate` AS sellingrate,ROUND(SUM(cdrs.billsec)/60,2) AS minutes, ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2) AS duration, 
ROUND(((ROUND(ROUND(SUM(cdrs.billsec)/60,2)-ROUND(SUM(cdrs.billsec)/60,2)*(cdrs.Addon/100),2))* numberranges.`sellingrate`),2) AS selling_total , 
COUNT(cdrs.start_stamp) AS totatcalls ,cdrs.`numberrange_name` ,currencies.id AS currenciesid , operators.`name` AS operator_name ,operators.`id` AS operator_id,
ROUND(((ROUND(ROUND(SUM(cdrs.billsec)/60,2)))* numberranges.`buyingrate`),2) AS buying_total,
numberranges.`buyingrate` , numberranges.`id` AS numberranges_id
FROM cdrs
JOIN numberranges ON numberranges.`name`=cdrs.`numberrange_name`
JOIN operators ON operators.`id`=numberranges.`operator_id`
LEFT JOIN currencies ON currencies.id = cdrs.currency_id 
WHERE  cdrs.start_stamp BETWEEN NOW()+INTERVAL -1 MONTH AND NOW()
GROUP BY cdrs.`superresrate`,cdrs.`Addon`,cdrs.`superresseler_id`
ORDER BY currenciesid ASC , operators.`name` ASC,numberrange_name ASC

	";
		$result2=mysql_query($query2) or die(mysql_error());
		
			
		$c=0;
		
		while ( $r2 = mysql_fetch_array($result2)){
				
				$sr=$r2['sellingrate'];
				if(!is_numeric( $sr)){
				$sr=0.0;
				}
				$st=$r2['selling_total'];
				if(!is_numeric( $st)){
				$st=0.0;
				}
				$br=$r2['buyingrate'];
				if(!is_numeric( $br)){
				$br=0.0;
				}
				$bt=$r2['buying_total'];
				if(!is_numeric( $bt)){
				$bt=0.0;
				}
				
				$d=$r2['duration'];
				if(!is_numeric( $d)){
				$d=0.0;
				}
				$minutes=$r2['minutes'];
				if(!is_numeric($minutes)){
				$minutes=0.0;
				}
				$ci=$r2['currenciesid'];
				if(!is_numeric( $ci)){
				$ci=0;
				}
				$nr=$r2['numberrange_name'];
				$nr = str_replace("'", "\'", $nr);	
				if($nr==' ' || $nr==null){
					$nr='Unknown';
				}
				$on=$r2['operator_name'];
				if($on==' ' || $on==null){
					$on='Unknown';
				}
			
			$tp=round(($bt-$st),2);
			
		
			if($c==0){
			//echo "<br>iN<br>";
				$c++;
				$q10="INSERT INTO `profits`( `operator_id`) VALUES (0) ";
			//echo  $q10;
			mysql_query($q10) or die(mysql_error());
			$invoice_id=mysql_insert_id();
				
				
				
			}
			
			$q7="INSERT INTO `profit_details`( `profit_id`, `currency_id`,`minutes`,`payable_minutes`, `sellingrate`, `selling_total`, `buyingrate`, `buying_total`, `profit`,`operator_name`,`numberrange_name`) VALUES ({$invoice_id},{$ci},{$minutes},{$d},{$sr},{$st},{$br},{$bt},{$tp},'{$on}','{$nr}') ";
			echo $q7.'<br>';
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
	
//echo '<br>'.$query9.'<br>';
//mysql_query($query9) or die(mysql_error());


?>
