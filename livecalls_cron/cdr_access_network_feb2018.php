<?php
include_once("xlsxwriter.class.php");

ini_set('memory_limit', '-1');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
//define('DB_PASSWORD', 'mypasswd');
define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');

$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());
$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());

// $query1="SELECT * FROM cdrs WHERE billsec = 0 AND DATE(start_stamp) = '2017-10-29' AND (destination_number LIKE '26378739324' OR destination_number LIKE '90000442894548765' OR destination_number LIKE '2917240259')"; 

$query1  = "SELECT REPLACE (cdrs.`caller_id_name`,'+','') AS 'caller_id_name',cdrs.`destination_number` , 
			COUNT(*) AS 'hits',cdrs.`operator_ip` AS 'oper_ips'
			FROM cdrs 
			WHERE billsec = 0 AND start_stamp  >= DATE_SUB(NOW(),INTERVAL 15 MINUTE)
			GROUP BY REPLACE (cdrs.`caller_id_name`,'+',''), destination_number
			ORDER BY hits DESC";

$result=mysql_query($query1) or die(mysql_error());


$superarray 		= array();
$xlsdataarray 		= array();
$destination_count 	= 0;
$caller_ids_string 	= '';
$current_number 	= '';
$previous_number	= '';

while ( $r = mysql_fetch_array($result)){

		// var_dump($r);exit();

		if(is_numeric($r['destination_number'])){
			
			${'act_destination'.$destination_count} = $destination_count;
			$current_number =str_replace('+','',$r['destination_number']);


				$superarray[$destination_count] = array('hits' => $r['hits']);
				$superarray[$destination_count]['destination_num'] = $current_number;
				$superarray[$destination_count]['caller_ids_string'] = (string)$r[0];
				$resulted_country_oper = get_call_id_network((string)$r[0]);
				$resulted_country_oper = explode('_',$resulted_country_oper);

				$superarray[$destination_count]['cc'] 				= $resulted_country_oper[0];
				$superarray[$destination_count]['operator'] 		= $resulted_country_oper[1];

				$superarray[$destination_count]['operator_ips'] 	 = (string)$r['oper_ips'];
				$superarray[$destination_count]['operator_ips_name'] = get_oper_name($r['oper_ips']);

				//triming string for check
				$destination4 = substr($current_number, 0, -4);
				$destination5 = substr($current_number, 0, -5);
				$destination6 = substr($current_number, 0, -6);
				$destination7 = substr($current_number, 0, -7);

				//pushing trim as keys and default val as 0
				 $superarray[$destination_count]['destination4'] = 0;
				 $superarray[$destination_count]['destination5'] = 0;
				 $superarray[$destination_count]['destination6'] = 0;
				 $superarray[$destination_count]['destination7'] = 0;


				$numberrange_available = false;
				for ($i=4; $i <= 7; $i++) { 
					# code...
					if($numberrange_available == false){

						$query2 = "SELECT dids.`did`, dids.`numberrange_id`,numberranges.`id`,numberranges.`name`,numberranges.`sellingrate`,numberranges.`buyingrate`,numberranges.`currency_id` FROM dids INNER JOIN numberranges ON numberranges.`id`=dids.`numberrange_id` WHERE dids.`did` LIKE '${'destination'.$i}%' ORDER BY numberranges.`name`";
	 					   // var_dump($query2);exit();

						$result2=mysql_query($query2) or die(mysql_error());

						$result2_numbers = mysql_num_rows($result2);
						// var_dump($result2_numbers);
						if( $result2_numbers > 0){
							$numberrange_available = true;
	 				//1 for destination available
							for($p = $i; $p <= 7; $p++){
								$superarray[$destination_count]['destination'.$p] = 1;
							}
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

							$superarray[$destination_count]['numberrangesname'] 		= trim($numberranges_name,',');
							$superarray[$destination_count]['numberrangescurr'] 		= trim($numberranges_curr,',');
							$superarray[$destination_count]['numberrangesbuyrate'] 	= trim($numberranges_buyrate,',');
							$superarray[$destination_count]['numberrangetestnumbers'] 	= trim($numberranges_test_num,',');
						}
						else
						{
							$superarray[$destination_count]['numberrangesname'] 		= 'N/A';
	 						$superarray[$destination_count]['numberrangescurr'] 		= 'N/A';
	 						$superarray[$destination_count]['numberrangesbuyrate'] 	= 'N/A';
	 						$superarray[$destination_count]['numberrangetestnumbers'] 	= 'N/A';
						}
					}

				}
				
			
		}
		else
		{
			//not numeric
		}
	
		
	$destination_count = $destination_count + 1;
}


for ($z=0; $z < $destination_count; $z++) { 

	$end_dest4 = destination_string_for_excel($superarray[${'act_destination'.$z}]['destination4']);
	$end_dest5 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination5']);
	$end_dest6 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination6']);
	$end_dest7 =destination_string_for_excel($superarray[${'act_destination'.$z}]['destination7']);
	// var_dump(${'act_destination'.$z});
	array_push($xlsdataarray, array($superarray[${'act_destination'.$z}]['caller_ids_string'],$superarray[${'act_destination'.$z}]['cc'],$superarray[${'act_destination'.$z}]['operator'],$superarray[${'act_destination'.$z}]['destination_num'],$superarray[${'act_destination'.$z}]['hits'],$superarray[${'act_destination'.$z}]['operator_ips'],$superarray[${'act_destination'.$z}]['operator_ips_name'],$superarray[${'act_destination'.$z}]['numberrangesname'],$superarray[${'act_destination'.$z}]['numberrangetestnumbers'],$end_dest4,$end_dest5,$end_dest6,$end_dest7,$superarray[${'act_destination'.$z}]['numberrangescurr'],$superarray[${'act_destination'.$z}]['numberrangesbuyrate']));
}
				
// var_dump($xlsdataarray);
// exit();
$header = array(
  'Caller_id_name'=>'string',//text
  'Access from'=>'string',//text
  'Network'=>'string',//text
  'Destination number'=>'string',//text
  'No of Hits'=>'string',//text
  'Oprator ip'=>'string',//text
  'Oprator Name'=>'string',//text
  'Range Name in Livecalls'=>'string',//text
  'Test Numbers'=>'string',//text
  '4 digit trim'=>'string',//text
  '5 digit trim'=>'string',//text
  '6 digit trim'=>'string',//text
  '7 digit trim'=>'string',//text
  'Currency'=>'string',//text
  'Buying rate'=>'string'//text

  
);
$rows = $xlsdataarray;
$writer = new XLSXWriter();

$writer->writeSheetHeader('Sheet1', $header,array('font-style'=>"bold", 'font-size' => '11'));
foreach($rows as $row){
	$writer->writeSheetRow('Sheet1', $row);
}

//$writer->writeSheet($rows,'Sheet1', $header);//or write the whole sheet in 1 call

$writer->writeToFile('cdrs_access_test.xlsx');
// print_r($superarray);




function get_call_id_network($number){
	    $number = str_replace('+','',$number);
    	$dest_str_length = strlen($number);

    	$string1		 = '' ;
    	$dest_str_length = $dest_str_length + 1 ;
    	for ($j=$dest_str_length; $j >= 1; $j--) { 
    		$string1 = $string1 .',' .substr($number,0,$j);
    	}

    	$string2 = trim($string1,',');
    	$string3 = str_replace(",", "','", $string2);

    	$query3 = "SELECT * FROM access_network WHERE number IN('{$string3}') ORDER BY number DESC LIMIT 1";
    	// var_dump($query3);exit();
    		$result3=mysql_query($query3) or die(mysql_error());

    		$result3_rows = mysql_num_rows($result3);
    		if($result3_rows == 1){
    			while ( $r3 = mysql_fetch_array($result3)){
    				$numberlength = strlen($r3['number']);
    				return $r3['country'].'_'.$r3['network'];

    			}

    		}
    		else{
    			return 'N/A_N/A';
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

function get_oper_name($oper_ip){
	$query11="SELECT operator_ips.`ip`,operators.`name` 
	FROM operator_ips JOIN operators ON operators.id = operator_ips.operator_id WHERE ip = '{$oper_ip}'";
	$result11=mysql_query($query11) or die(mysql_error());
	if(mysql_num_rows($result11) > 0){
		while ($result11_rows = mysql_fetch_array($result11)) {
		# code...	
		return $result11_rows['name'];
		}
	}
	
	return 'n/a'; 
}

function destination_string_for_excel($flag)
{
	if($flag == 1 || $flag == '1'){
		return 'Available';
	}
	if($flag == 0 || $flag == '0'){
		return 'n/a';

	}
}



?>