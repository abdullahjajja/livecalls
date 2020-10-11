<?php
include_once('Parse_XML_CDR.php');
Header("Content-type: text/plain");

function read_file($filename)
{
    if ( file_exists($filename) && ($fd = @fopen($filename, 'rb')) ) {
        $contents = '';
        while (!feof($fd)) {
            $contents .= fread($fd, 8192);
        }
        fclose($fd);
        return $contents;
    } else {
        return false;
    }
}

$xmlraw=read_file("testcdr.xml");
if($xmlraw !== false) {
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
	$uuid =$cdr[callflow][0][caller_profile]['uuid'];
	$bleg_uuid =$cdr[callflow][0][caller_profile]['bleg_uuid'];
	$accountcode=$cdr[variables]['accountcode'];
	$SuperResseler_ID=$cdr[variables]['SuperResseler_ID'];
	$Resseller_ID=$cdr[variables]['Resseller_ID'];
	$Subresseller_ID=$cdr[variables]['Subresseller_ID'];
	$numberrange_name=urldecode($cdr[variables]['numberrange_name']);
$fields =array(
	'$caller_id_name'=>"'".$cdr[callflow][0][caller_profile]['caller_id_name']."'",
	'$caller_id_number'=>"'".$cdr[callflow][0][caller_profile]['caller_id_number']."'",
	'$destination_number'=>"'".$cdr[callflow][0][caller_profile]['destination_number']."'",
	'$context'=>"'".$cdr[callflow][0][caller_profile]['context']."'",
	'$start_stamp'=>"'".urldecode($cdr[variables]['start_stamp'])."'",
	'$answer_stamp'=>"'".urldecode($cdr[variables]['answer_stamp'])."'",
	'$end_stamp'=>"'".urldecode($cdr[variables]['end_stamp'])."'",
	'$duration'=>"'".urldecode($cdr[variables]['duration'])."'",
	'$billsec'=>"'".urldecode($cdr[variables]['billsec'])."'",
	'$hangup_cause'=>"'".urldecode($cdr[variables]['hangup_cause'])."'",
	'$uuid '=>"'".$cdr[variables]['uuid']."'",
	'$bleg_uuid '=>"'".$cdr[callflow][0][caller_profile]['bleg_uuid']."'",
	'$accountcode'=>"'".$cdr[variables]['accountcode']."'",
	'$SuperResseler_ID'=>"'".$cdr[variables]['SuperResseler_ID']."'",
	'$Resseller_ID'=>"'".$cdr[variables]['Resseller_ID']."'",
	'$Subresseller_ID'=>$cdr[variables]['Subresseller_ID']."'",
	'$numberrange_name'=>"'".urldecode($cdr[variables]['numberrange_name'])."'"
);
	//print_r($fields);
	echo join(",",$fields);
	//print $SuperResseler_ID." ".$Resseller_ID." ".$Subresseller_ID." ".$numberrange_name;
	//print $caller_id_name.",".$caller_id_number.",".$destination_number.",".$context.",".$start_stamp.",".$answer_stamp.",".$end_stamp.",".$duration.",".$billsec.",".$hangup_cause.",".$uuid.",".$bleg_uuid.",".$accountcode;
   /* $query="INSERT INTO cdrs VALUES (".'"'.$caller_id_name.'"'.",".'"'.$caller_id_number.'"'.",".'"'.$destination_number.'"'.",".'"'.$context.'"'.",".'"'.$start_stamp.'"'.",".'"'.$answer_stamp.'"'.",".'"'.$end_stamp.'"'.",".'"'.$duration.'"'.",".'"'.$billsec.'"'.",".'"'.$hangup_cause.'"'.",".'"'.$uuid.'"'.",".'"'.$bleg_uuid.'"'.",".'"'.$accountcode.'"'.",".'"'.$SuperResseler_ID.'"'."
,".'"'.$Resseller_ID.'"'.",".'"'.$Subresseller_ID.'"'.",".'"'.$numberrange_name.'"'.")";*/
	//print $query;
	}
?>
