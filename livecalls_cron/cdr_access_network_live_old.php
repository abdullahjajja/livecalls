<?php

// require_once ('mailer/class.phpmailer.php');
require_once ('mailer/class.phpmailer.php');
include_once("xlsxwriter.class.php");
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


// var_dump(get_test_numbers('23079'));exit();


//$query2="SELECT * FROM cdrs WHERE billsec = 0 and start_stamp > (NOW() - INTERVAL 48 HOUR)";
// $query1="SELECT * FROM cdrs WHERE billsec = 0 AND DATE(start_stamp) = '2017-10-29' AND caller_id_name NOT LIKE 'unavailable'";
// $query1="SELECT * FROM cdrs WHERE billsec = 0 AND DATE(start_stamp) = '2017-10-29' AND (destination_number LIKE '26378739324' OR destination_number LIKE '90000442894548765' OR destination_number LIKE '2917240259')"; 
$query1="SELECT * FROM cdrs WHERE billsec = 0 AND start_stamp  >= DATE_SUB(NOW(),INTERVAL 1 HOUR)"; 
$result=mysql_query($query1) or die(mysql_error());


$superarray = array();
$xlsdataarray = array();
$destination_count = 0;
$caller_ids_string = '';
$current_number = '';
$previous_number = '';

while ( $r = mysql_fetch_array($result)){

		// var_dump($r[0]);exit();

		if(is_numeric($r[2])){
			
			${'act_destination'.$destination_count} = str_replace('+','',$r[2]);
			$current_number = ${'act_destination'.$destination_count};
			

			//pushing destination number in superarray as key or increasing the hits
			if (array_key_exists($r[2], $superarray)) {
				$pre_hits = $superarray[$r[2]]['hits'];
				$superarray[$r[2]]['hits'] = $pre_hits + 1;

				$pre_caller_id = $superarray[$r[2]]['caller_ids_string'];
				$caller_ids_string = $pre_caller_id.",".(string)$r[0];
				$superarray[$r[2]]['caller_ids_string'] = $caller_ids_string;


				$pre_cc 			   			= $superarray[$r[2]]['cc'];
				$pre_operator		   			= $superarray[$r[2]]['operator'];

				$resulted_country_oper 			= get_call_id_network((string)$r[0]);
				$resulted_country_oper 			= explode('_',$resulted_country_oper);

				$ccs_strings 					= $pre_cc. ",". $resulted_country_oper[0];
				$operators_strings 				= $pre_operator.",". $resulted_country_oper[1];
				$superarray[$r[2]]['cc'] 		= $ccs_strings;
				$superarray[$r[2]]['operator'] 	= $operators_strings;

				$pre_operator_ip 				= $superarray[$r[2]]['operator_ips'];
				$superarray[$r[2]]['operator_ips'] = $pre_operator_ip. "," . $r['operator_ip'];


			}
			//if not duplicate hit then do the rest
			else
			{
				$destination_count = $destination_count + 1;
				$superarray[$r[2]] = array('hits' => 1);
				$superarray[$r[2]]['caller_ids_string'] = (string)$r[0];
				$resulted_country_oper = get_call_id_network((string)$r[0]);
				$resulted_country_oper = explode('_',$resulted_country_oper);

				$superarray[$r[2]]['cc'] = $resulted_country_oper[0];
				$superarray[$r[2]]['operator'] = $resulted_country_oper[1];

				$superarray[$r[2]]['operator_ips'] = (string)$r['operator_ip'];

				//triming string for check
				$destination4 = substr($current_number, 0, -4);
				$destination5 = substr($current_number, 0, -5);
				$destination6 = substr($current_number, 0, -6);
				$destination7 = substr($current_number, 0, -7);

				//pushing trim as keys and default val as 0
				 $superarray[$r[2]]['destination4'] = 0;
				 $superarray[$r[2]]['destination5'] = 0;
				 $superarray[$r[2]]['destination6'] = 0;
				 $superarray[$r[2]]['destination7'] = 0;
				 // var_dump($string1);
				// var_dump($destination4,$destination5,$destination6,$destination7);
				 // var_dump($superarray); exit();

				$numberrange_available = false;
				for ($i=4; $i <= 7; $i++) { 
					# code...
					if($numberrange_available == false){

						$query2 = "SELECT dids.*, numberranges.* FROM dids INNER JOIN numberranges ON numberranges.`id`=dids.`numberrange_id` WHERE dids.`did` LIKE '${'destination'.$i}%'";
	 					   // var_dump($query2);exit();

						$result2=mysql_query($query2) or die(mysql_error());

						$result2_numbers = mysql_num_rows($result2);
						// var_dump($result2_numbers);
						if( $result2_numbers > 0){
							$numberrange_available = true;
	 				//1 for destination available
							$superarray[$r[2]]['destination'.$i] = 1;
							$numberranges_name 		= '';
							$numberranges_curr 		= '';
							$numberranges_buyrate 	= '';
							$numberranges_test_num 	= '';
							$numberranges_prevoius  = '';
							while ( $result2_rows = mysql_fetch_array($result2)){
	 						// var_dump($result2_rows['name']);
								if($numberranges_prevoius != (string)$result2_rows['name']){

									$numberranges_name 		= $numberranges_name .",". (string)$result2_rows['name'];
									$numberranges_curr 		= $numberranges_curr .",". get_currency($result2_rows['currency_id']);
									$numberranges_buyrate 	= $numberranges_buyrate .",". (float)$result2_rows['buyingrate'];
									$numberranges_test_num 	= $numberranges_test_num .",". get_test_numbers($result2_rows['numberrange_id']);
								}
								$numberranges_prevoius = (string)$result2_rows['name'];
							}

	 				// var_dump(trim($numberranges_name,','));
	 				// var_dump(trim($numberranges_curr,','));
	 				// var_dump(trim($numberranges_buyrate,','));
	 				// exit();
							$superarray[$r[2]]['numberrangesname'] 		= trim($numberranges_name,',');
							$superarray[$r[2]]['numberrangescurr'] 		= trim($numberranges_curr,',');
							$superarray[$r[2]]['numberrangesbuyrate'] 	= trim($numberranges_buyrate,',');
							$superarray[$r[2]]['numberrangetestnumbers'] 	= trim($numberranges_test_num,',');
						}
						else
						{
							$superarray[$r[2]]['numberrangesname'] 		= 'N/A';
	 						$superarray[$r[2]]['numberrangescurr'] 		= 'N/A';
	 						$superarray[$r[2]]['numberrangesbuyrate'] 	= 'N/A';
	 						$superarray[$r[2]]['numberrangetestnumbers'] 	= 'N/A';
						}
					}

				}
				
			}
			
		}
		else
		{
			//not numeric
		}
	
	// var_dump($string1);
		
		
	
}
// var_dump($superarray);
// exit();
// var_dump($destination_count);
// var_dump(get_defined_vars());
				//var_dump($destination_count);
				//var_dump($superarray[$current_number]);
				// exit();
for ($z=0; $z < $destination_count; $z++) { 

	$end_dest4 = destination_string_for_excel($superarray[${'act_destination'.$z}]['destination4']);
	$end_dest5 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination5']);
	$end_dest6 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination6']);
	$end_dest7 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination7']);
	// var_dump(${'act_destination'.$z});
	array_push($xlsdataarray, array($superarray[${'act_destination'.$z}]['caller_ids_string'],$superarray[${'act_destination'.$z}]['cc'],${'act_destination'.$z},$superarray[${'act_destination'.$z}]['numberrangesname'],$superarray[${'act_destination'.$z}]['numberrangetestnumbers'],$end_dest4,$end_dest5,$end_dest6,$end_dest7,$superarray[${'act_destination'.$z}]['numberrangescurr'],$superarray[${'act_destination'.$z}]['numberrangesbuyrate'],$superarray[${'act_destination'.$z}]['operator_ips'],$superarray[${'act_destination'.$z}]['operator'], $superarray[${'act_destination'.$z}]['hits']));
}
				
// var_dump($xlsdataarray);
$header = array(
  'caller_id_name'=>'string',//text
  'access from'=>'@',//text
  'destination number'=>'@',//text
  'Range Name in Livecalls'=>'@',//text
  'Test Numbers'=>'@',//text
  '4 digit trim'=>'@',//text
  '5 digit trim'=>'@',//text
  '6 digit trim'=>'@',//text
  '7 digit trim'=>'@',//text
  'currency'=>'@',//text
  'buying rate'=>'@',//text
  'oprator ip'=>'@',//text
  'oprator name'=>'@',//text
  'No of Hits'=>'@',//text
  //'c3-integer'=>'integer',
  //'c4-integer'=>'0',
  //'c5-price'=>'price',
  //'c6-price'=>'#,##0.00',//custom
  //'c7-date'=>'date',
  //'c8-date'=>'YYYY-MM-DD',
);
$rows = $xlsdataarray;
$writer = new XLSXWriter();

$writer->writeSheetHeader('Sheet1', $header);
foreach($rows as $row){
	$writer->writeSheetRow('Sheet1', $row);
}

//$writer->writeSheet($rows,'Sheet1', $header);//or write the whole sheet in 1 call

$writer->writeToFile('xlsx-test.xlsx');
// print_r($superarray);




function get_call_id_network($number){
	$number = str_replace('+','',$number);
	$dest_str_length = strlen($number);
	$dest_str_length = $dest_str_length + 1 ;
	for ($j=$dest_str_length; $j >= 1; $j--) { 
		// var_dump($number,$dest_str_length,$j);exit();
		$dest_chunk_for_network = substr($number,0,$j);
		$query3 = "SELECT * FROM access_network where number LIKE '{$dest_chunk_for_network}%'";
			// var_dump($query3);

		$result3=mysql_query($query3) or die(mysql_error());

		$result3_rows = mysql_num_rows($result3);
		// var_dump($result3_rows);
		if($result3_rows == 1){
			while ( $r3 = mysql_fetch_array($result3)){
					// var_dump($r3,$j,$dest_str_length);
					return $r3['country'].'_'.$r3['operator'];
					// exit();
			}
				// break 1;
		}


	}
	return 'N/A_N/A';
}

function get_currency($id){
	if($id == 1 || $id == '1'){
		return 'USD';
	}
	if($id == 2 || $id == '2'){
		return 'EURO';
		
	}
	if($id == 4 || $id == '4'){
		return 'GBP';
		
	}
	else{
		return 'USD';
	}
}

function get_test_numbers($range_id){

	$query10="SELECT did FROM dids WHERE numberrange_id = {$range_id} AND IsTestNumber = 1";
	$result10=mysql_query($query10) or die(mysql_error());
	$test_dids = '';
	while ($result10_rows = mysql_fetch_array($result10)) {
		# code...	
		$test_dids = $test_dids  . ' and '.$result10_rows['did'];
	}
	return trim($test_dids,' and '); 

}

function destination_string_for_excel($flag)
{
	if($flag == 1 || $flag == '1'){
		return 'Available';
	}
	if($flag == 0 || $flag == '0'){
		return 'Range Doesnt Exist.';

	}
}




?>