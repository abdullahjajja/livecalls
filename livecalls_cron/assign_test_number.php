<?php
ini_set('memory_limit', '-1');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');
$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());

$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());

 $query = "select Distinct numberranges.id, numberranges.name from numberranges where numberranges.id not in (
	select numberranges.id from numberranges 
	inner join dids on dids.numberrange_id = numberranges.id 
	where dids.IsTestNumber = 1 and numberranges.operator_id = 57 order by numberranges.id asc 
)";
//mysql_query($query) or die(mysql_error());

$result=mysql_query($query) or die(mysql_error());
		
			
		$c=0;
		
		while ( $row = mysql_fetch_array($result)){
		$did_id = 0;
		$query1 = "select dids.id, dids.did from dids where dids.numberrange_id =  " . $row['id'] . " order by dids.id asc limit 1";
		$did = mysql_fetch_array(mysql_query($query1));
			if($did[0] > 0) {
				$c++;
				mysql_query("update dids set dids.isTestNumber = 1 where id = " . $did[0]);
				echo "$c >> Test Number ". $did[1] ." assign against " . $row['name'] . " <br>";
			}
		
		}
		
		  
?>