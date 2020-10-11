<?php
ini_set('memory_limit', '-1');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');
$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());

$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());

 $query = "delete from channels 
		where uuid in(
					select tb.uuid from (
										select channels.uuid,channels.dest,channels.cid_num,HOUR(TIMEDIFF(time(now()),time(channels.created)))as Duration from channels)as tb where 
										tb.Duration>=1)";
mysql_query($query) or die(mysql_error());
		  
?>