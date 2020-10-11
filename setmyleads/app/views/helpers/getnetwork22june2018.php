<?php

class getnetworkHelper extends AppHelper {

    var $helpers = array('Html');

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
    				return $r3['country'].'_'.$r3['network'].'_'.$numberlength;

    			}

    		}
    		else{
    			return 'N/A_N/A_4';
    		}
    	return 'N/A_N/A_4';
    }


    function get_numberrabges_trim($number){
    	$numberrange_available = false;
    	$superarray	  = array();
    	$destination4 = substr($number, 0, -4);
		$destination5 = substr($number, 0, -5);
		$destination6 = substr($number, 0, -6);
		$destination7 = substr($number, 0, -7);
		$numberranges_prevoius  = '';
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
							
							$numberranges_name 		= '';
							$numberranges_curr 		= '';
							$numberranges_buyrate 	= '';
							$numberranges_test_num 	= '';
							
							while ( $result2_rows = mysql_fetch_array($result2)){
	 						// var_dump($result2_rows);
	 						// exit();
								if($numberranges_prevoius != (string)$result2_rows['name']){

									$numberranges_name 		= $numberranges_name .", ". (string)$result2_rows['name'];
									// $numberranges_curr 		= $numberranges_curr .",". get_currency($result2_rows['currency_id']);
									$numberranges_buyrate 	= $numberranges_buyrate .", ". (float)$result2_rows['sellingrate'];
									$numberranges_test_num 	= $numberranges_test_num .", ". $this->get_test_numbers($result2_rows['numberrange_id']);
								}
								$numberranges_prevoius = (string)$result2_rows['name'];
							}
							// exit();
							$superarray['numberrangesname'] 		= trim($numberranges_name,',');
							// $superarray['numberrangescurr'] 		= trim($numberranges_curr,',');
							$superarray['numberrangessellrate'] 	= trim($numberranges_buyrate,',');
							$superarray['numberrangetestnumbers'] 	= trim($numberranges_test_num,',');
						}
						else
						{
							$superarray['numberrangesname'] 		= 'N/A';
	 						// $superarray['numberrangescurr'] 		= 'N/A';
	 						$superarray['numberrangessellrate'] 	= 'N/A';
	 						$superarray['numberrangetestnumbers'] 	= 'N/A';
						}

					}

				}
				return $superarray;

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

}

?>
