<?php
  include_once('Parse_XML_CDR.php');

  Header("Content-type: text/plain");
$handle = fopen("/tmp/uuid.txt", "r");
if ($handle) {
while (($line = fgets($handle)) !== false) {
       echo $line;
	   $xmlraw=shell_exec("cat /root/15Jan/".$line);
$xml = new Parse_CDR_XML($xmlraw);
$cdr=$xml->ReturnArray();
 	
	$caller_id_name=$cdr[callflow][0][caller_profile]['caller_id_name'];
	$caller_id_number=$cdr[callflow][0][caller_profile]['caller_id_number'];
	$destination_number=$cdr[callflow][0][caller_profile]['destination_number'];
	$context=$cdr[callflow][0][caller_profile]['context'];
	$start_stamp=urldecode($cdr[variables]['start_stamp']);
	$answer_stamp=urldecode($cdr[variables]['answer_stamp']);
	$end_stamp=urldecode($cdr[variables]['end_stamp']);
	$duration=urldecode($cdr[variables]['duration']);
	$billsec=urldecode($cdr[variables]['billsec']);
	$hangup_cause=urldecode($cdr[variables]['hangup_cause']);
	$uuid =urldecode($cdr[variables]['uuid']);
	$bleg_uuid =urldecode($cdr[callflow][0][caller_profile]['bleg_uuid']);
	$accountcode=$cdr[variables]['accountcode'];
	$SuperResseler_ID=urldecode($cdr[variables]['SuperResseler_ID']);
	$Resseller_ID=urldecode($cdr[variables]['Resseller_ID']);
	$Subresseller_ID=urldecode($cdr[variables]['Subresseller_ID']);
	$isdaily=urldecode($cdr[variables]['isdaily']);
	$numberrange_name=urldecode($cdr[variables]['numberrange_name']);
	$Addone=urldecode($cdr[variables]['Addon']);
	$superresrate=urldecode($cdr[variables]['superresrate']);
	$ressellerrate=urldecode($cdr[variables]['ressellerrate']);
	$subresrate=urldecode($cdr[variables]['subresrate']);
	$currency_id=urldecode($cdr[variables]['currency_id']);
	$admin_currency=urldecode($cdr[variables]['admin_currency']);
	$supres_currency=urldecode($cdr[variables]['supres_currency']);
	$reseller_currency=urldecode($cdr[variables]['reseller_currency']);
	$subres_currency=urldecode($cdr[variables]['subres_currency']);
	$operator_name=urldecode($cdr[variables]['operator_name']);
	$payment_term=urldecode($cdr[variables]['payment_term']);
    $sip_local_network_addr=urldecode($cdr[variables]['sip_local_network_addr']);
	$operator_ip=urldecode($cdr[variables]['sip_contact_host']);
	$adminbuyrate=urldecode($cdr[variables]['adminbuyrate']);

  
   

 $query="INSERT INTO cdrs_fail (caller_id_name, caller_id_number, destination_number, context, start_stamp, answer_stamp, end_stamp, duration, billsec, hangup_cause, uuid, bleg_uuid, accountcode, superresseler_id, resseller_id, subresseller_id, numberrange_name, Addon, superresrate, ressellerrate, subresrate, currency_id, admin_currency, supres_currency, reseller_currency, subres_currency,isdaily,operator_name,payment_term,operator_ip,adminbuyrate) VALUES (".'"'.$caller_id_name.'"'.",".'"'.$caller_id_number.'"'.",".'"'.$destination_number.'"'.",".'"'.$context.'"'.",".'"'.$start_stamp.'"'.",".'"'.$answer_stamp.'"'.",".'"'.$end_stamp.'"'.",".'"'.$duration.'"'.",".'"'.$billsec.'"'.",".'"'.$hangup_cause.'"'.",".'"'.$uuid.'"'.",".'"'.$bleg_uuid.'"'.",".'"'.$accountcode.'"'.",".'"'.$SuperResseler_ID.'"'."
,".'"'.$Resseller_ID.'"'.",".'"'.$Subresseller_ID.'"'.",".'"'.$numberrange_name.'"'.",".'"'.$Addone.'"'.",".'"'.$superresrate.'"'.",".'"'.$ressellerrate.'"'.",".'"'.$subresrate.'"'.",".'"'.$currency_id.'"'.",".'"'.$admin_currency.'"'.",".'"'.$supres_currency.'"'.",".'"'.$reseller_currency.'"'.",".'"'.$subres_currency.'"'.",".'"'.$isdaily.'"'.",".'"'.$operator_name.'"'.",".'"'.$payment_term.'"'.",".'"'.$operator_ip.'"'.",".'"'.$adminbuyrate.'"'.")";

/*	$myFile = "/tmp/query.txt";
	$file = fopen($myFile, 'a');
	fwrite($file,$query);
	fclose($file);*/


//$query_call_permission="INSERT INTO call_permission_control(date,destination,numberrange_name,billsec) VALUES (date(".'"'.$end_stamp.'"'."),".'"'.$destination_number.'"'.",".'"'.$numberrange_name.'"'.",".'"'.$billsec.'"'.") ON DUPLICATE KEY UPDATE billsec=billsec"."+".$billsec;
//$query_delete_from_channels_table="delete from channels where uuid='$uuid'";	
  $con = mysql_connect("108.178.8.202","root","r5dh@t");
  if (!$con)
  {
        die('Could not connect: ' . mysql_error());
  }
        mysql_select_db("livecalls", $con);
        mysql_query($query);
        if($billsec!=0){
	// mysql_query($query_call_permission);
 }
//	mysql_query($query_delete_from_channels_table);
 mysql_close($con);
$query_call_permission="INSERT INTO call_permission_control(date,destination,numberrange_name,billsec) VALUES (date(".'"'.$end_stamp.'"'."),".'"'.$destination_number.'"'.",".'"'.$numberrange_name.'"'.",".'"'.$duration.'"'.") ON DUPLICATE KEY UPDATE billsec=billsec"."+".$duration;
//echo shell_exec("mv {$file_path} /root/15Jan/done/");		   
    }

    fclose($handle);
}

	
?>
