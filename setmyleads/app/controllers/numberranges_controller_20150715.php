<?php

class NumberrangesController extends AppController {

     var $name = 'Numberranges';
     var $uses = array('Numberrange', 'Currency', 'Ivrs', 'Didrate');
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
          $Ivrs = $this->Ivrs->find('list', array('fields' => array('ivr_name', 'ivr_name'), 'order' => array('ivr_name ASC')));
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
                          if($this->data['Numberrange']['files']!='0')
	                   {
                    $this->data['Numberrange']['ivrpath'] = $this->data['Numberrange']['files'];
                            }
                    if ($this->Numberrange->save($this->data)) {

                         $query = "update didrates inner join dids on dids.id = didrates.did_id set adminbuyrate=" . $this->data['Numberrange']['buyingrate'] . ", currency_id = " . $this->data['Numberrange']['currency_id'] . ", superresrate = " . $this->data['Numberrange']['sellingrate'] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];

//									echo $query;exit;

                         $calls = $this->Didrate->query($query, $cachequeries = false);

                         $query = "update dids set maxdailyminutes=" . $this->data['Numberrange']['maxdailyminutes'] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];
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

                         $query = "update dids set maxdailyminutes=" . $this->data[Numberrange][maxdailyminutes] . " where dids.numberrange_id = " . $this->data['Numberrange']['id'];
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
          $Ivrs = $this->Ivrs->find('list', array('fields' => array('ivr_name', 'ivr_name'), 'order' => array('ivr_name ASC')));
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
                                   $objRange['Numberrange']['ivrpath'] = 'Punjabi_IVR.wav';
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
}
