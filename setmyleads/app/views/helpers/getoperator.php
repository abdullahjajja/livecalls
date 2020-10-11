<?php

class getoperatorHelper extends AppHelper {

    var $helpers = array('Html');

    function get_oper_name_by_ip($ip){
        $ip = (string) $ip;
    	$query3 = "SELECT op.name FROM operator_ips oi
                    JOIN operators op ON op.`id` = oi.`operator_id`
                    WHERE oi.`ip` = '{$ip}' AND isprimary = 1";
    	// var_dump($query3);exit();
    		$result3=mysql_query($query3) or die(mysql_error());

    		$result3_rows = mysql_num_rows($result3);
    		if($result3_rows == 1){
    			while ( $r3 = mysql_fetch_array($result3)){
    				return $r3[0];
    			}

    		}
            else
            {
    			return '';
    		}
    	return '';
    }


}

?>
