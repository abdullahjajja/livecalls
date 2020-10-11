<?php

class NumberrangesController extends AppController {

     var $name = 'Numberranges';
     var $uses = array('Numberrange', 'Currency', 'Ivrs', 'Didrate', 'Did', 'DidsUser');
     var $layout = 'livecalls';

     function index() {
          if (isset($_GET['name'])) {
               $name = $_GET['name'];
          } else {
               $name = null;
          }

          $this->Numberrange->recursive = 0;
          if ($name == null) {
               // $this->paginate = array('order' => array('Numberrange.Operator' => 'asc'));
               //$this->paginate = array('order' => array('Numberrange.name'=> 'asc'),'limit' =>100);
               $this->paginate = array('order' => array('Operator.Name' => 'asc', 'Numberrange.name' => 'asc'), 'limit' => 100);
               //print_r ($this->paginate());
               $this->set('numberranges', $this->paginate());
          } else {
               $this->paginate = array('order' => array('Operator.Name' => 'asc', 'Numberrange.name' => 'asc'), 'limit' => 100);
               $this->set('numberranges', $this->paginate(null, array('Numberrange.name Like ' => '%' . $name . '%')));
          }
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid numberrange', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('numberrange', $this->Numberrange->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->Numberrange->create();
               if ($this->data['Numberrange']['routetype_id'] == '2') {
                    if ($this->data['Numberrange']['files'] != "") {
                         //	$this->data['Numberrange']['ivrpath'] = data['Numberrange']['files'];
                         if ($this->Numberrange->save($this->data)) {
                              $this->Session->setFlash(__('The numberrange has been saved', true));
                              $this->redirect(array('action' => 'index'));
                         } else {
                              $this->Session->setFlash(__('The numberrange could not be saved. Please, try again.', true));
                         }
                    } else {
                         $this->Session->setFlash(__('Please select a file to upload', true));
                    }
               } else {
                    $this->data['Numberrange']['ivrpath'] = $this->data['Numberrange']['route'];
                    if ($this->Numberrange->save($this->data)) {
                         $this->Session->setFlash(__('The numberrange has been saved', true));
                         $this->redirect(array('action' => 'index'));
                    } else {
                         $this->Session->setFlash(__('The numberrange could not be saved. Please, try again.', true));
                    }
               }
          }
          $currencies = $this->Currency->find('list', array('fields' => array('id', 'currency_name')));
          $operators = $this->Numberrange->Operator->find('list', array('order' => 'name ASC'));
          $routetypes = $this->Numberrange->Routetype->find('list');
          $Ivrs = $this->Ivrs->find('list', array('fields' => array('ivr_uploaded_name', 'ivr_name'), 'order' => array('ivr_name ASC')));
          /*start for payment term options*/
          $sql="select type,title from payment_terms ORDER BY payment_terms.`type` ASC";
          $data = mysql_query($sql);
          $dailyTitle=array();
          $weeklyTitle=array();
          $monthlyTitle=array();
         while($row=mysql_fetch_array($data,MYSQL_NUM)){
         	switch($row[0])
         	{
				case 1:
				 $dailyTitle[$row[1]]=$row[1];
				 break;
				 case 2:
				 $weeklyTitle[$row[1]]=$row[1];
				 break;
				 case 3:
				 $monthlyTitle[$row[1]]=$row[1];
				 break;
			}
      	
      }
      /*end for payment term options*/
          
          $this->set(compact('operators', 'routetypes', 'currencies', 'Ivrs','dailyTitle','weeklyTitle','monthlyTitle'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid numberrange', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               // var_dump($this->data);
               // exit();

               $log_name        = $this->data['Numberrange']['name'];
               $log_monthlyrate = $this->data['Numberrange']['monthlyrate']." ".$this->data['Numberrange']['monthly_title'];
               $log_weeklyrate  = $this->data['Numberrange']['sellingrate']." ". $this->data['Numberrange']['weekly_title'];
               $log_dailyrate   = $this->data['Numberrange']['dailyrate']." ". $this->data['Numberrange']['daily_title'];
               $log_opratorid   = $this->data['Numberrange']['operator_id'];
               $uid = $this->Auth->User('id');
               $log_text = "$log_name has been edited ";
               $todayDate = date("Y-m-d H:i:s");

               // echo("{$log_text} {$log_monthlyrate} {$log_weeklyrate} {$log_dailyrate} {$uid} {$log_text} {$todayDate} {$log_opratorid}");
               // exit();

               $monthlyrate = $this->data['Numberrange']['monthlyrate'];
               $weeklyrate  = $this->data['Numberrange']['sellingrate'];
               $dailyrate   = $this->data['Numberrange']['dailyrate'];
                
               $query = "INSERT INTO numberranges_log (userid,log_text,created,monthly_rate,weekly_rate,daily_rate,range_name,operatorid) VALUE($uid,'$log_text','$todayDate','$log_monthlyrate','$log_weeklyrate','$log_dailyrate', '$log_name', '$log_opratorid')";

               mysql_query($query) or die(mysql_error());

               if ($this->data['Numberrange']['routetype_id'] == '2') {
//                    print_r($this->data);
//                    if ($this->data['Numberrange']['ivrpath']['name'] != "") {
////                           $fileOK = $this->uploadFiles('files/ivr', $this->data['Numberrange']);
////                           $this->data['Numberrange']['ivrpath'] = $fileOK['fname'][0];
//                         if ($this->Numberrange->save($this->data)) {
//
//                              $this->Session->setFlash(__('The numberrange has been saved', true));
//                              $this->redirect(array('action' => 'index'));
//                         } else {
//                              $this->Session->setFlash(__('The numberrange could not be saved. Please, try again.', true));
//                         }
//                    } else {
                    if($this->data['Numberrange']['files']!='0'){
                         $this->data['Numberrange']['ivrpath'] = $this->data['Numberrange']['files'];
                    }

                    if ($rekk = $this->Numberrange->save($this->data)) {
                         // 
                    $query = "UPDATE didrates 
                    inner join dids on dids.id = didrates.did_id 
                    inner join dids_users on dids.id = dids_users.did_id 
                    set didrates.adminbuyrate="   . $this->data['Numberrange']['buyingrate'] . ",
                    didrates.currency_id = "      . $this->data['Numberrange']['currency_id'] . ",
                    didrates.admin_currency = "   . $this->data['Numberrange']['currency_id'] . ",
                    didrates.supres_currency = ". $this->data['Numberrange']['currency_id'] . ",
                    didrates.superresrate = Case When dids_users.isdaily = 0 Then {$weeklyrate}
                                        when dids_users.isdaily = 1 Then {$dailyrate}
                                        When dids_users.isdaily = 2 Then {$monthlyrate}
                                        End

                    where dids.numberrange_id = " . $this->data['Numberrange']['id'];

									 // echo $query;exit;

                         $calls = $this->Didrate->query($query, $cachequeries = false);

                         $query = "update dids set perclilimit = ". $this->data['Numberrange']['clilimit']." ,maxdailyminutes=" . $this->data['Numberrange']['maxdailyminutes'] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];
//								 echo $query;exit;
                         $calls = $this->Didrate->query($query, $cachequeries = false);
                         $this->Session->setFlash(__('The numberrange has been saved', true));
                         $this->redirect(array('action' => 'index'));
                    }
                    //      }
               } else {
                    $this->data['Numberrange']['ivrpath'] = $this->data['Numberrange']['route'];
                    if ($this->Numberrange->save($this->data)) {

                         $query = "update didrates inner join dids on dids.id = didrates.did_id set adminbuyrate=" . $this->data['Numberrange']['buyingrate'] . ", currency_id = " . $this->data['Numberrange']['currency_id'] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];

//									echo $query;exit;

                         $calls = $this->Didrate->query($query, $cachequeries = false);

                         $query = "update dids set perclilimit = ". $this->data['Numberrange']['clilimit']." ,maxdailyminutes=" . $this->data['Numberrange']['maxdailyminutes'] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];
                         
//								 echo $query;exit;
                         $calls = $this->Didrate->query($query, $cachequeries = false);

                         $this->Session->setFlash(__('The numberrange has been saved', true));
                         $this->redirect(array('action' => 'index'));
                    } else {
                         $this->Session->setFlash(__('The numberrange could not be saved. Please, try again.', true));
                    }
               }
          }
          if (empty($this->data)) {
               $this->data = $this->Numberrange->read(null, $id);
          }
          $currencies = $this->Currency->find('list', array('fields' => array('id', 'currency_name')));
          $operators = $this->Numberrange->Operator->find('list', array('order' => array('name ASC')));
          $routetypes = $this->Numberrange->Routetype->find('list');
          $Ivrs = $this->Ivrs->find('list', array('fields' => array('ivr_uploaded_name', 'ivr_name'), 'order' => array('ivr_name ASC')));
          array_unshift($Ivrs,"select ivr");
          /*start for payment term options*/
          $sql="select type,title from payment_terms ORDER BY payment_terms.`type` ASC";
          $data = mysql_query($sql);
          $dailyTitle=array();
          $weeklyTitle=array();
          $monthlyTitle=array();
         while($row=mysql_fetch_array($data,MYSQL_NUM)){
         	switch($row[0])
         	{
				case 1:
				 $dailyTitle[$row[1]]=$row[1];
				 break;
				 case 2:
				 $weeklyTitle[$row[1]]=$row[1];
				 break;
				 case 3:
				 $monthlyTitle[$row[1]]=$row[1];
				 break;
			}
      	
      }
      /*end for payment term options*/
          
          $this->set(compact('operators', 'routetypes', 'currencies', 'Ivrs','dailyTitle','weeklyTitle','monthlyTitle'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for numberrange', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->Numberrange->delete($id)) {
               $this->Session->setFlash(__('Numberrange deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Numberrange was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function numberrange_log() {
        if ($this->Auth->user('role_id') == 1) {

          $query="SELECT users.`login`, operators.`name` ,numberranges_log.* FROM numberranges_log JOIN users ON users.`id`=numberranges_log.`userid` JOIN operators ON operators.`id` = numberranges_log.`operatorid` ORDER BY numberranges_log.`created` DESC LIMIT 2000";

          $results = $this->Numberrange->query($query, $cachequeries = false);

          $this->set('nr_logs', $results);
        }
        else
         $this->redirect(array('action' => 'index'));
     }

     function uploadFiles($folder, $formdata, $itemId = null) {
          // setup dir names absolute and relative
          $folder_url = WWW_ROOT . $folder;
          $rel_url = $folder;
          $savedfilename = '';
          // create the folder if it does not exist
          if (!is_dir($folder_url)) {
               mkdir($folder_url);
          }

          // if itemId is set create an item folder
          if ($itemId) {
               // set new absolute folder
               $folder_url = WWW_ROOT . $folder . '/' . $itemId;
               // set new relative folder
               $rel_url = $folder . '/' . $itemId;
               // create directory
               if (!is_dir($folder_url)) {
                    mkdir($folder_url);
               }
          }

          // list of permitted file types, this is only images but documents can be added
          $permitted = array('audio/x-ms-wma');

          // loop through and deal with the files
          foreach ($formdata as $file) {
               // replace spaces with underscores
               $filename = str_replace(' ', '_', $file['name']);
               // assume filetype is false
               $typeOK = false;
               // check filetype is ok
               //foreach($permitted as $type) {
               //	if($type == $file['type']) {
               $typeOK = true;
               //		break;
               //	}
               //}
               // if file type ok upload the file
               if ($typeOK) {
                    // switch based on error code
                    switch ($file['error']) {
                         case 0:
                              // check filename already exists
                              if (!file_exists($folder_url . '/' . $filename)) {
                                   // create full filename
                                   $full_url = $folder_url . '/' . $filename;
                                   $url = $rel_url . '/' . $filename;
                                   $savedfilename = $filename;
                                   // upload the file
                                   $success = move_uploaded_file($file['tmp_name'], $url);
                              } else {
                                   // create unique filename and upload file
                                   ini_set('date.timezone', 'Europe/London');
                                   $now = date('Y-m-d-His');
                                   $full_url = $folder_url . '/' . $now . $filename;
                                   $url = $rel_url . '/' . $now . $filename;
                                   $success = move_uploaded_file($file['tmp_name'], $url);
                                   $savedfilename = $now . $filename;
                              }
                              // if upload was successful
                              if ($success) {
                                   // save the url of the file
                                   $result['urls'][] = $url;
                                   $result['fname'][] = $savedfilename;
                              } else {
                                   $result['errors'][] = "Error uploaded $filename. Please try again.";
                              }
                              break;
                         case 3:
                              // an error occured
                              $result['errors'][] = "Error uploading $filename. Please try again.";
                              break;
                         default:
                              // an error occured
                              $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                              break;
                    }
               } elseif ($file['error'] == 4) {
                    // no file was selected for upload
                    $result['nofiles'][] = "No file Selected";
               } else {
                    // unacceptable file type
                    $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
               }
          }
          return $result;
     }

     function importrange() {
          if (!empty($this->data)) {

               if (substr(strrchr($this->data['Numberrange']['range']['name'], '.'), 1) == 'csv') {
                    $fileOK = $this->uploadFiles('files', $this->data['Numberrange']);
                    $handle = fopen($fileOK['urls'][0], "r");
                    $count = 0;
                    $duplicate = 0;
                    $operatorNotFound=0;
                    while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
                    	if($count!=0)
                    	{
                    		$found = $this->Numberrange->findByName($data[0]);
                              if ($found != "") {
                                   $duplicate++;
                              }
                              else
                              {
							  
							  
						           $operator = $this->Numberrange->Operator->findByName($data[1]);
                                   if($operator)
                                   {
								   $objRange = $this->Numberrange->create();
                                   $objRange['Numberrange']['name'] = $data[0];
                                   $objRange['Numberrange']['operator_id'] = $operator['Operator']['id'];
								   
                                   $objRange['Numberrange']['buyingrate'] = (float) $data[2];
                                   $objRange['Numberrange']['sellingrate'] = (float) $data[3];
                                   $objRange['Numberrange']['minduraction'] = (int) $data[4];
                                   $objRange['Numberrange']['maxduration'] = (int) $data[5];
                                   $objRange['Numberrange']['dailyrate'] = (float) $data[6];
                                   $objRange['Numberrange']['monthlyrate'] = (float) $data[7];
                                   $objRange['Numberrange']['daily_title'] = $data[8];
                                   $objRange['Numberrange']['weekly_title'] = $data[9];
                                   $objRange['Numberrange']['monthly_title'] = $data[10];
                                   $currencyId=1;
                                   switch($data[11])
                                   {
								   	case 'USD':
								   	$currencyId=1;
								   	break;
								   	case 'EURO':
								   	$currencyId=2;
								   	break;
								   	case 'GBP':
								   	$currencyId=4;
								   	break;
								   }
                                   
                                   // Default values
                                   $objRange['Numberrange']['ivrpath'] = 'TeachYourselfEnglishINTHECITY.wav';
                                   $objRange['Numberrange']['routetype_id'] = 2;
                                   $objRange['Numberrange']['currency_id'] = $currencyId;
                                   $objRange['Numberrange']['calllimit'] = 100000;
                                   $objRange['Numberrange']['maxdailyminutes'] = 3000;
                                   $objRange['Numberrange']['mivr_id'] = 0;
                                  
                                   $this->Numberrange->save($objRange);	
                                   
                                   $count++;
								   }
								   else
								   {
								   	$operatorNotFound++;
								   }
                             }
						}
						else
						{
							// first line of csv
							$count++;
						}
                    	
                    }
                    $count=$count-1;
                    $this->Session->setFlash(__('Inserted = ' . $count . ', Duplicate = ' . $duplicate. ', Operators not found = ' . $operatorNotFound, true));
                    fclose($handle);
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('not a valid csv file', true));
               }
          }
     }

     function payment_terms() {
          if ($this->Auth->user('role_id') == 1) {
     	
          $query="SELECT * FROM payment_terms
ORDER BY payment_terms.`type` ASC";
         
          $results = $this->Numberrange->query($query, $cachequeries = false);
       
          $this->set('terms', $results);
         }
         else
         $this->redirect(array('controller' => 'numberranges', 'action' => 'index'));
     }


     function numberrange_bulk(){

          $query="SELECT * FROM numberrange_rate_list";
         
          $results = $this->Numberrange->query($query, $cachequeries = false);
           $this->set('results', $results);
     }


     function uploadbulkratelist(){


           if (!empty($this->data)) {
                // die(var_dump($this->data));
          // exit();

               if (substr(strrchr($this->data['Numberrange']['numberrangeratelist']['name'], '.'), 1) == 'csv') {
                    $fileOK = $this->uploadFiles('files', $this->data['Numberrange']);
                    $handle = fopen($fileOK['urls'][0], "r");
                    $count = 0;
                    $duplicate = 0;
                    $query0 = "TRUNCATE TABLE numberrange_rate_list";
                    mysql_query($query0) or die(mysql_error());
                    while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
                         // foreach ($data as $element) {
                         //      var_dump($element);
                         // }
                         if(is_numeric($data[0])){
                              // var_dump($data[0].'_'.$data[1].'_'.$data[2]);
                              $query1 ="INSERT INTO numberrange_rate_list (buyinrate,monthly,weekly,created,updated) VALUE({$data[0]}, {$data[1]}, {$data[2]}, NOW(), NOW())";
                              // var_dump($query1);exit();
                              mysql_query($query1) or die(mysql_error());
                         }
                    }
                    // die();
                    $this->Session->setFlash(__('Rate List updated !', true));
                    fclose($handle);
                    $this->redirect(array('action' => 'numberrange_bulk'));
               } else {
                    $this->Session->setFlash(__('not a valid csv file', true));
               }
          }
          // $numberranges = $this->Did->Numberrange->find('list');
          // $this->set(compact('numberranges'));
     }
  //    array (size=12)
  // 0 => string '1' (length=1)
  // 'id' => string '1' (length=1)
  // 1 => string '0.2600' (length=6)
  // 'buyinrate' => string '0.2600' (length=6)
  // 2 => string '0.0210' (length=6)
  // 'monthly' => string '0.0210' (length=6)
  // 3 => string '0.1900' (length=6)
  // 'weekly' => string '0.1900' (length=6)
  // 4 => string '2018-02-16 18:34:32' (length=19)
  // 'created' => string '2018-02-16 18:34:32' (length=19)
  // 5 => string '2018-02-16 18:34:32' (length=19)
  // 'updated' => string '2018-02-16 18:34:32' (length=19)
                    

     function applyratelist(){
 
          $query = "SELECT * from numberrange_rate_list";
          $result = mysql_query($query) or die(mysql_error());

          $result_num = mysql_num_rows($result);
          if($result_num > 0){
               while ( $r = mysql_fetch_array($result)){

                    // var_dump($r);

                    $qbuyingrate = $r['buyinrate'];
                    $qmonthly    = $r['monthly'];
                    $qweekly     = $r['weekly'];

                    $query2 = "SELECT * FROM numberranges WHERE buyingrate = '{$qbuyingrate}'";
                    $result2 = mysql_query($query2) or die(mysql_error());

                    while ( $r2 = mysql_fetch_array($result2)){
                         $numberrange_id = $r2['id'];
                         // var_dump($r2);
                         if ($r2['isfixed'] != '1') {
                              $query4 = "UPDATE didrates 
                         inner join dids on dids.id = didrates.did_id 
                         inner join dids_users on dids.id = dids_users.did_id 
                         set didrates.adminbuyrate='{$qbuyingrate}',
                         didrates.superresrate = Case When dids_users.isdaily = 0 Then {$qweekly}
                         When dids_users.isdaily = 2 Then {$qmonthly}
                         End
                         where dids.numberrange_id = {$numberrange_id}";

                         $res4 =  mysql_query($query4) or die(mysql_error());
                         // var_dump($query4, $res4);
                         }
                         
                    }
                    // exit();
                    $query3 = "UPDATE numberranges set monthlyrate='{$qmonthly}', sellingrate='{$qweekly}' 
                    WHERE numberranges.buyingrate = '{$qbuyingrate}' AND (isfixed != '1' OR isfixed IS NULL)";

                    mysql_query($query3) or die(mysql_error());


               }
                    $this->Session->setFlash(__('Rates Applied Successfully to Numberranges.', true));
                    $this->redirect(array('action' => 'numberrange_bulk'));
          } else{
               $this->Session->setFlash(__('No Date in Rate List', true));
               $this->redirect(array('action' => 'numberrange_bulk'));
          }
     }

     function randnum_log() {
          if ($this->Auth->user('role_id') == 1) {

               $query="SELECT * FROM randomdid_log ORDER BY created DESC LIMIT 2500";
               $this->Numberrange->recursive = -1;
               $results = $this->Numberrange->query($query, $cachequeries = false);
               $this->set('dids', $results);
          }
          else
               $this->redirect(array('controller' => 'dids', 'action' => 'ratecard'));
     }

     private function randomGendids($min, $max, $quantity) {
         $numbers = range($min, $max);
         shuffle($numbers);
         return array_slice($numbers, 0, $quantity);
     }

     function uploadrandomnumbers(){

               if (!empty($this->data)) {

                         $count = 0;
                         $duplicate = 0;
                         $this->Numberrange->recursive = -1;
                         $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $this->data['Numberrange']['numberrange_id']));

                         $dids_count = $this->Did->find('count', array('conditions' => 'Did.numberrange_id='. $this->data['Numberrange']['numberrange_id']));

                              $start_did      = $this->data['Numberrange']['didrangestart'];
                              $end_did        = $this->data['Numberrange']['didrangeend'];
                              $did_qty        = $this->data['Numberrange']['rangeqty'];

                              $numbers   = $this->randomGendids($start_did,$end_did,$did_qty);
                              $duplicate_dids = '';
                              $inserted_dids  = '';
                              $inner_duplicate = 0;

                             foreach ($numbers as $element) {
                              $found = $this->Did->findByDid($element);
                              if ($found != "") {
                                   $duplicate_dids = $duplicate_dids .' '.(string)$element;
                                   $duplicate++;
                                   $inner_duplicate++;
                              } 
                              else 
                              {

                                   $objDid = $this->Did->create();
                                   $objDid['Did']['numberrange_id'] = $this->data['Numberrange']['numberrange_id'];
                                   $objDid['Did']['did'] = $element;
                                   $objDid['Did']['maxdailyminutes'] = 3000;

                                   if(!empty($objNumberRange['Numberrange']['ivrpath']))
                                   {
                                        $objDid['Did']['ivr_id'] = $objNumberRange['Numberrange']['ivrpath'];
                                   }
                                   else{
                                      $objDid['Did']['ivr_id'] = 'TeachYourselfEnglishINTHECITY.wav';     
                                 }

                                         //first number always test
                                 if($count == 0 && $dids_count == 0){
                                   $objDid['Did']['IsTestNumber'] = '1';
                              }


                              $this->Did->save($objDid);
                              $did_id=$this->Did->getLastInsertID();

                              //save did rate
                              $objDidRate = $this->Didrate->create();

                              $objDidRate['Didrate']['did_id'] = $did_id;
                              $objDidRate['Didrate']['adminbuyrate']=$objNumberRange['Numberrange']['buyingrate'];
                              $objDidRate['Didrate']['ressellerrate'] = 'NULL';
                              $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                              $objDidRate['Didrate']['subresrate'] = 'NULL';
                              $objDidRate['Didrate']['assignedBy'] = 23;
                              $objDidRate['Didrate']['currency_id'] = $objNumberRange['Numberrange']['currency_id'];
                              $objDidRate['Didrate']['admin_currency'] = $objNumberRange['Numberrange']['currency_id'];
                              $objDidRate['Didrate']['supres_currency'] = $objNumberRange['Numberrange']['currency_id'];

                              $this->Didrate->save($objDidRate);

                              $objDidUser = $this->DidsUser->create();
                              $objDidUser['DidsUser']['did_id'] = $did_id;

                              //assign to testroom if 1st did
                              if($count == 0 && $dids_count == 0){
                                   $objDidUser['DidsUser']['superresseler_id'] = 20;
                              }
                              else{
                                   $objDidUser['DidsUser']['superresseler_id'] = 23;
                              }

                              $objDidUser['DidsUser']['resseller_id'] = 0;
                              $objDidUser['DidsUser']['subresseller_id'] = 0;
                              $objDidUser['DidsUser']['isdaily'] = 0;

                              $this->DidsUser->save($objDidUser);

                              $inserted_dids  = $inserted_dids . ' ' . (string)$element;
                              $count++;
                         }
                         
                    }

                    // if($inner_duplicate > 0){
                         $duplicate_log_text="{$duplicate_dids}";

                         $log_query = "INSERT INTO randomdid_log (start_did,end_did,qty,duplicate_log,inserted_log,created) VALUE('{$start_did}','{$end_did}','{$did_qty}','{$duplicate_log_text}','{$inserted_dids}',NOW())";

                         mysql_query($log_query) or die(mysql_error());
                         // }
               
               $this->Session->setFlash(__('Inserted = ' . $count . ', Duplicate = ' . $duplicate, true));
               fclose($handle);
               $this->redirect(array('action' => 'randnum_log'));
          
     }

     $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));
     $this->set(compact('numberranges'));
     }
}