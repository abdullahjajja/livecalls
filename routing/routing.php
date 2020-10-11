<?php
include('database.php');
//$destination_number="541155190544";
		$database = new MySQLDatabase();
		$destination_number=$_REQUEST["Hunt-Destination-Number"];
		$Hunt_Caller_Id_Number=$_REQUEST["Hunt-Caller-ID-Number"];
		$operator_ip=$_REQUEST["variable_sip_from_host"];

		if($_REQUEST["variable_sip_contact_host"]!=$_REQUEST["variable_sip_from_host"]) {
			$operator_ip=$_REQUEST["variable_sip_contact_host"];
		}
		
		//echo $destination_number;
		//exit;
/*		if($destination_number=="923024215721"){		
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen('/tmp/request.log', 'a');
		fwrite($fp, $req_dump);
		fclose($fp);

		} */
		
		//$destination_number='218912126261';
                $path = $_SERVER["DOCUMENT_ROOT"].'/app/webroot/files/ivr';
		// $path = $_SERVER["DOCUMENT_ROOT"].'/app/webroot/files/ivr';
          //1800 to 2200 sec
		  $call_timeout=rand(1800,2200);
		  //echo $call_timeout;
         $query="SELECT dids.did,dids.numberrange_id,IFNULL(dids.perclilimit,0) as perclilimit,numberranges.route,numberranges.routetype_id,numberranges.ivrpath,dids.ivr_id,numberranges.minduraction,numberranges.maxduration,numberranges.calllimit,numberranges.clilimit,dids.maxdailyminutes,dids_users.superresseler_id,dids_users.resseller_id,dids_users.subresseller_id,dids_users.isdaily,dids_users.payment_term,numberranges.name,numberranges.isringing,users.add_on,didrates.superresrate,didrates.ressellerrate,didrates.subresrate,didrates.currency_id,didrates.admin_currency,didrates.supres_currency,didrates.reseller_currency,didrates.subres_currency,didrates.adminbuyrate,operators.name as operator_name FROM numberranges 
		 INNER JOIN dids ON (numberranges.id = dids.numberrange_id) 
		 INNER JOIN dids_users ON(dids.id=dids_users.did_id) 
		 INNER JOIN users ON(users.id=dids_users.superresseler_id) 
		 INNER JOIN didrates ON(didrates.did_id=dids.id)
	     INNER JOIN operators ON (operators.id=numberranges.operator_id) 
		 INNER JOIN  operator_ips ON (operator_ips.operator_id=operators.id)
	     WHERE (dids.did = '".$destination_number."' and operator_ips.ip='".$operator_ip."') limit 1;";
		 // echo $query;
		 // exit;
		 $results = $database->query($query);
		 //print_r($results);
         //exit;
		 $Query_max_daily_minut_numberrange ="select IFNULL(round(sum(billsec)/60),0) as Max_Min from call_permission_control where date=CURDATE() and numberrange_name='".$results[name]."';";
		 //echo $Query_max_daily_minut_numberrange;
		 $Query_max_daily_minut_number="select IFNULL(round(sum(billsec)/60),0) as Max_Min from call_permission_control where date=CURDATE() and destination='".$results[did]."';";
		 $result_numberrange = $database->query($Query_max_daily_minut_numberrange);
		 //print_r($result_numberrange);
		 //exit;
		 $result_number=$database->query($Query_max_daily_minut_number);
		 $Query_Cli_Limit="select count(*) as percli_perdestination_call_count from channels where dest='".$destination_number."' and cid_num='".$Hunt_Caller_Id_Number."'";
		 $Result_Cli_Limit=$database->query($Query_Cli_Limit);
		 $percli_perDestination_call_limit=$Result_Cli_Limit['percli_perdestination_call_count'];
		 if($results[perclilimit]!=0) { 

			 if($percli_perDestination_call_limit>=$results[perclilimit])
			 {
				 header('Content-Type: text/xml');
				printf("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n");
				printf("<document type=\"freeswitch/xml\">\n");
				printf("<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n");
				printf("<context name=\"public\">\n");
				printf("<extension name=\"$destination_number\">\n");
				printf("<condition field=\"destination_number\" expression=\"^$destination_number$\">\n");
				printf("<action application=\"set\" data=\"custom_hangup_cause=CALL CLI LIMIT REACHED\" />\n");				 
				printf("<action application=\"hangup\" data=\"NORMAL_CIRCUIT_CONGESTION\" />");
				printf("</condition>");
				printf("</extension>");
				printf("</context>");
				printf("</section>");
				printf("</document>\n");
				
				exit;
			 }
		 }
		 
		 
		 //echo $Query_Cli_Limit;
		 //exit;
		  
		 //print_r($Result_Cli_Limit);
		 //echo $percli_perDestination_call_limit;
		 //exit;
		 //per cli call limit for multilevel ivr
		 $Query_per_cli_limit="select count(*) as perclicalllimit from channels where direction='outbound' and cid_num='".$Hunt_Caller_Id_Number."' or cid_num='00".$Hunt_Caller_Id_Number."'";
		 //echo $Query_per_cli_limit;
		 //exit;
		 $Result_per_cli_limit=$database->query($Query_per_cli_limit);
		 $per_cli_call_limit=$Result_per_cli_limit['perclicalllimit'];
		 //echo $per_cli_call_limit;
		 //exit;
		 if($per_cli_call_limit=='3' && $results[name]=='Ascension Island SW1')
		 {
			header('Content-Type: text/xml');
			printf("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n");
			printf("<document type=\"freeswitch/xml\">\n");
			printf("<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n");
			printf("<context name=\"public\">\n");
			printf("<extension name=\"$destination_number\">\n");
			printf("<condition field=\"destination_number\" expression=\"^$destination_number$\">\n");
			printf("<action application=\"set\" data=\"custom_hangup_cause=CALL CLI LIMIT REACHED\" />\n");
			printf("<action application=\"hangup\" data=\"NORMAL_CIRCUIT_CONGESTION\" />");
			printf("</condition>");
			printf("</extension>");
			printf("</context>");
			printf("</section>");
			printf("</document>\n");
			
			exit;
		 }
		 
/*		 if(!($result_numberrange[Max_Min]<$results[calllimit] && $result_number[Max_Min]<$results[maxdailyminutes])){
			header('Content-Type: text/xml');
			printf("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n");
			printf("<document type=\"freeswitch/xml\">\n");
			printf("<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n");
			printf("<context name=\"public\">\n");
			printf("<extension name=\"$destination_number\">\n");
			printf("<condition field=\"destination_number\" expression=\"^$destination_number$\">\n");
			printf("<action application=\"set\" data=\"custom_hangup_cause=CALL ALLOW MIN LIMIT REACHED\" />\n");
			printf("<action application=\"hangup\" data=\"NORMAL_CIRCUIT_CONGESTION\" />");
			printf("</condition>");
			printf("</extension>");
			printf("</context>");
			printf("</section>");
			printf("</document>\n");
			
			exit;
		 } */
		 

		 $call_timeout=rand($results[minduraction],$results[maxduration]);
		 $filename=null;
			 if(preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/",$results[ivr_id]) && $result_numberrange[Max_Min]<$results[calllimit] && $result_number[Max_Min]<$results[maxdailyminutes]){
                        $dialplan="<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n";
                        $dialplan.="<context name=\"public\">\n";
                        $dialplan.="<extension name=\"$results[did]\">\n";
                        $dialplan.="<condition field=\"destination_number\" expression=\"^$results[did]$\">\n";
                        $dialplan.="<action application=\"answer\"/>";
                        $dialplan.="<action application=\"set\" data=\"SuperResseler_ID=$results[superresseler_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"Resseller_ID=$results[resseller_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"Subresseller_ID=$results[subresseller_id]\"/>";
						$dialplan.="<action application=\"set\" data=\"isdaily=$results[isdaily]\"/>";
                        $dialplan.="<action application=\"set\" data=\"numberrange_name=$results[name]\"/>";
                        $dialplan.="<action application=\"set\" data=\"Addon=$results[add_on]\"/>";
                        $dialplan.="<action application=\"set\" data=\"superresrate=$results[superresrate]\"/>";
                        $dialplan.="<action application=\"set\" data=\"ressellerrate=$results[ressellerrate]\"/>";
                        $dialplan.="<action application=\"set\" data=\"subresrate=$results[subresrate]\"/>";
                        $dialplan.="<action application=\"set\" data=\"currency_id=$results[currency_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"admin_currency=$results[admin_currency]\"/>";
                        $dialplan.="<action application=\"set\" data=\"supres_currency=$results[supres_currency]\"/>";
                        $dialplan.="<action application=\"set\" data=\"reseller_currency=$results[reseller_currency]\"/>";
                        $dialplan.="<action application=\"set\" data=\"subres_currency=$results[subres_currency]\"/>";
						$dialplan.="<action application=\"set\" data=\"operator_name=$results[operator_name]\"/>";
						$dialplan.="<action application=\"set\" data=\"payment_term=$results[payment_term]\"/>";
						$dialplan.="<action application=\"set\" data=\"adminbuyrate=$results[adminbuyrate]\"/>";
                        $dialplan.="<action application=\"sched_hangup\" data=\"+$call_timeout alloted_timeout\"/>";
                        $dialplan.="<action application=\"set\" data=\"process_cdr=a_only\"/>";
                        $dialplan.="<action application=\"set\" data=\"bypass_media=true\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_copy_custom_headers=true\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_h_X-SuperResseler_ID=$results[superresseler_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_h_X-Resseller_ID=$results[resseller_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_h_X-Subresseller_ID=$results[subresseller_id]\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_h_X-numberrange_name=$results[name]\"/>";
                        $dialplan.="<action application=\"set\" data=\"sip_h_X-Addon=$results[add_on]\"/>";
                        $dialplan.="<action application=\"bridge\" data=\"sofia/external/$results[did]@$results[ivr_id]\"/>";
                        $dialplan.="</condition>";
                        $dialplan.="</extension>";
                        $dialplan.="</context>";
                        $dialplan.="</section>";

                }
		else if($results['routetype_id']== '2' && $result_numberrange[Max_Min]<$results[calllimit] && $result_number[Max_Min]<$results[maxdailyminutes]){

		
			$dialplan="<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n";
			//echo $dialplan;
			//exit;
			$dialplan.="<context name=\"public\">\n";
			$dialplan.="<extension name=\"$results[did]\">\n";
			$dialplan.="<condition field=\"destination_number\" expression=\"^$results[did]$\">\n";
			
		if($results[isringing]==1){
			$dialplan.="<action application=\"ring_ready\"/>";
			$dialplan.="<action application=\"sleep\" data=\"7000\"/>";
		}
			$dialplan.="<action application=\"answer\"/>";
			$dialplan.="<action application=\"set\" data=\"SuperResseler_ID=$results[superresseler_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"Resseller_ID=$results[resseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"Subresseller_ID=$results[subresseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"isdaily=$results[isdaily]\"/>";
			$dialplan.="<action application=\"set\" data=\"numberrange_name=$results[name]\"/>";
			$dialplan.="<action application=\"set\" data=\"Addon=$results[add_on]\"/>";
			$dialplan.="<action application=\"set\" data=\"superresrate=$results[superresrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"ressellerrate=$results[ressellerrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"subresrate=$results[subresrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"currency_id=$results[currency_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"admin_currency=$results[admin_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"supres_currency=$results[supres_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"reseller_currency=$results[reseller_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"subres_currency=$results[subres_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"operator_name=$results[operator_name]\"/>";
			$dialplan.="<action application=\"set\" data=\"payment_term=$results[payment_term]\"/>";
			$dialplan.="<action application=\"set\" data=\"adminbuyrate=$results[adminbuyrate]\"/>";
			$dialplan.="<action application=\"sched_hangup\" data=\"+$call_timeout alloted_timeout\"/>";


		 if($results[ivr_id]==''){
		 $filename =  explode(".",$results[ivrpath]);
		 //$filename=$path."/".$filename;
		 }
		 else{
		 $filename =  explode(".",$results[ivr_id]);
		 //$filename=$path."/".$filename;
		 }
			$dialplan.="<action application=\"endless_playback\" data=\"$path/$filename[0]\"/>";
			$dialplan.="</condition>";
			$dialplan.="</extension>";
			$dialplan.="</context>";
			$dialplan.="</section>";
			//echo 'Here';
			//exit;

		 }

		 //else if($results['routetype_id']== '1' && $result_numberrange[Max_Min]<$results[calllimit] && $result_number[Max_Min]<$results[maxdailyminutes] && $percli_perDestination_call_limit=='0')
		 else if($results['routetype_id']== '1' && $result_numberrange[Max_Min]<$results[calllimit] && $result_number[Max_Min]<$results[maxdailyminutes]){
		
			$dialplan="<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n";
			$dialplan.="<context name=\"public\">\n";
			$dialplan.="<extension name=\"$results[did]\">\n";
			$dialplan.="<condition field=\"destination_number\" expression=\"^$results[did]$\">\n";
			$dialplan.="<action application=\"answer\"/>";
			$dialplan.="<action application=\"set\" data=\"SuperResseler_ID=$results[superresseler_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"Resseller_ID=$results[resseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"Subresseller_ID=$results[subresseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"isdaily=$results[isdaily]\"/>";
			$dialplan.="<action application=\"set\" data=\"numberrange_name=$results[name]\"/>";
			$dialplan.="<action application=\"set\" data=\"Addon=$results[add_on]\"/>";
			$dialplan.="<action application=\"set\" data=\"superresrate=$results[superresrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"ressellerrate=$results[ressellerrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"subresrate=$results[subresrate]\"/>";
			$dialplan.="<action application=\"set\" data=\"currency_id=$results[currency_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"admin_currency=$results[admin_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"supres_currency=$results[supres_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"reseller_currency=$results[reseller_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"subres_currency=$results[subres_currency]\"/>";
			$dialplan.="<action application=\"set\" data=\"operator_name=$results[operator_name]\"/>";
			$dialplan.="<action application=\"set\" data=\"payment_term=$results[payment_term]\"/>";
			$dialplan.="<action application=\"set\" data=\"adminbuyrate=$results[adminbuyrate]\"/>";
			$dialplan.="<action application=\"sched_hangup\" data=\"+$call_timeout alloted_timeout\"/>";
			$dialplan.="<action application=\"set\" data=\"process_cdr=a_only\"/>";
			$dialplan.="<action application=\"set\" data=\"bypass_media=true\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_copy_custom_headers=true\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_h_X-SuperResseler_ID=$results[superresseler_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_h_X-Resseller_ID=$results[resseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_h_X-Subresseller_ID=$results[subresseller_id]\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_h_X-numberrange_name=$results[name]\"/>";
			$dialplan.="<action application=\"set\" data=\"sip_h_X-Addon=$results[add_on]\"/>";
			$dialplan.="<action application=\"bridge\" data=\"sofia/external/$results[did]@$results[route]\"/>";
			$dialplan.="</condition>";
			$dialplan.="</extension>";
			$dialplan.="</context>";
			$dialplan.="</section>";

		 }
		 else{
                        $dialplan="<section name=\"dialplan\" description=\"RE Dial Plan For FreeSwitch\">\n";
                        $dialplan.="<context name=\"public\">\n";
                        $dialplan.="<extension name=\"$destination_number\">\n";
                        $dialplan.="<condition field=\"destination_number\" expression=\"^$destination_number$\">\n";
                        $dialplan.="<action application=\"hangup\" data=\"NORMAL_CIRCUIT_CONGESTION\" />";
                        $dialplan.="</condition>";
                        $dialplan.="</extension>";
			            $dialplan.="</context>";
                        $dialplan.="</section>";

		 
		 }
		 //printf($filename[0]);
		 //exit;
		 
		 header('Content-Type: text/xml');
		 printf("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n");
		 printf("<document type=\"freeswitch/xml\">\n");
		 echo $dialplan;
		 printf("</document>\n");
         


?>
