<?php

class DidsController extends AppController {

     var $name = 'Dids';
     var $uses = array('Did', 'User', 'DidsUser', 'Currency', 'Didrate', 'Numberrange', 'Ivrs', 'Ips', 'Mivrs');
     var $layout = 'livecalls';

     function index() {
      ini_set('memory_limit', '-1');
          $id = 0;
          if (isset($_GET['id'])) {
               $id = $_GET['id'];
			   //echo "ID:".$_GET['id'];
          }
		  if (!isset($_GET['id'])){
			$id='90';
		  }
          if (isset($_GET['number'])) {
               $number = $_GET['number'];
			   //echo "NUMBER:".$number;
          } else {
               $number = null;
          }



          //echo $id;
          //exit;
          //$id = null
          //echo "Enterted in index";
          //echo $id;
          //$this->paginate = array('limit' => 3);
          // $this->Paginator->settings = array('limit' => 3);
          $this->paginate = array('order' => array('Did.created' => 'desc'));
          if (!empty($this->data)) {

               //   print_r($this->data);
               //die(print_r($this->data));
//                print_r($this->params);exit;
               /*
                 if(isset($this->params['form']['btnassign_y'])) {

                    $allnumbers='';
                    $allcount=0;
                    $payment_term='';
                    $rangename='';
                    $todayDate = date("Y-m-d H:i:s");
                    $uid=1;
                 $arr_dids = explode(',', $this->data['Did']['hdnselected']);
                 foreach($arr_dids as $did)
                 {
                 $query = "delete from didrates where didrates.did_id = " . $did;
                 echo $query;exit;
                 $this->Didrate->query($query);
                 $query = "delete from dids where dids.did=" . $did;
                 $this->Did->query($query);
                 }
                 }
                */

               if (isset($this->params['form']['btnassign_x'])) {
                    $arr_dids = explode(',', $this->data['Did']['hdnselected']);
                    //print_r($arr_dids);
                    $rangename='';
					$payment_term='';
                    $uid=1;
                    $todayDate = date("Y-m-d H:i:s");
                    $allcount=0;
                    $allnumbers='';
                    foreach ($arr_dids as $did) {
                         //   echo '<br>' . $did . '<br>';
                         if ($this->Auth->user('role_id') == 1) {


                              $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
                              $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $did));
                              $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
                              $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $did));

                              $rangename=$objNumberRange['Numberrange']['name'];
                              $uid=$this->data['Did']['assign_to'];
                              if($allcount==0)
                               {
							   	$allnumbers=$objdidupdate['Did']['did'];
							   }
							   else
							   {
							   	$allnumbers = $allnumbers.', '. $objdidupdate['Did']['did'];;
							   }
                              $allcount = $allcount+1; 
                                   if ($this->data['Did']['isdaily'] == 1) {
                                        $payment_term = "daily";
                                   } else if ($this->data['Did']['isdaily'] == 0) {
                                        $payment_term = "weekly";
                                   } else if ($this->data['Did']['isdaily'] == 2) {
                                        $payment_term = "monthly";
                               }

                              if ($objupdate) {
                                   $objupdate['DidsUser']['superresseler_id'] = $this->data['Did']['assign_to'];
                                   $objupdate['DidsUser']['resseller_id'] = 0;
                                   $objupdate['DidsUser']['subresseller_id'] = 0;
                                   $objupdate['DidsUser']['isdaily'] = $this->data['Did']['isdaily'];
                                   $objupdate['DidsUser']['modified'] = date('Y-m-d H:i:s');

                                   if ($this->data['Did']['isdaily'] == 1) {
                                        $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['daily_title'];
                                   } else if ($this->data['Did']['isdaily'] == 0) {
                                        $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['weekly_title'];
                                   } else if ($this->data['Did']['isdaily'] == 2) {
                                        $objupdate['DidsUser']['payment_term'] = $objNumberRange['Numberrange']['monthly_title'];
                                   }

                                   $this->DidsUser->save($objupdate);
                                   if ($this->data['Did']['routing'] == 1) {
                                        if ($this->data['Did']['ivr_id'] != '0') {
                                        	 $objdidupdate['Did']['ivr_id'] = $this->data['Did']['ivr_id'];
                                        } else if($objNumberRange['Numberrange']['ivrpath'] != '' && $objNumberRange['Numberrange']['ivrpath'] != NULL) {
												$objdidupdate['Did']['ivr_id'] = $objNumberRange['Numberrange']['ivrpath'];
										}	else {
                                             $objdidupdate['Did']['ivr_id'] = 'TeachYourselfEnglishINTHECITY.wav';
								        }
                                         $objdidupdate['Did']['routing'] = 'IVR';
                                   }
                                   if ($this->data['Did']['routing'] == 2) {
                                        if ($this->data['Did']['mivr_id'] == 0) {
                                             $objdidupdate['Did']['ivr_id'] = 'TeachYourselfEnglishINTHECITY.wav';
											 $objdidupdate['Did']['routing'] = 'IVR';
                                        } else {
                                             $objdidupdate['Did']['ivr_id'] = $this->data['Did']['mivr_id'];

                                             $objdidupdate['Did']['routing'] = 'MIVR';
                                        }
                                   }
                                   if ($this->data['Did']['routing'] == 0) {
                                        $objdidupdate['Did']['ivr_id'] = $this->data['Did']['ip_id'];

                                        $objdidupdate['Did']['routing'] = 'IP';
                                   }

                                   $this->Did->save($objdidupdate);

                                   //                                 $objRateupdate['Didrate']['adminbuyrate'] = $this->data['Did']['buyrate'];
                                   if ($objRateupdate) {
                                        if ($this->data['Did']['sellrate'] != '' && $this->data['Did']['sellrate'] != NULL) {
                                             if ($this->data['Did']['sellrate'] > $objNumberRange['Numberrange']['buyingrate']) {
                                                  // $this->Session->setFlash('Number not Assiened . Given rate ' . $this->data['Did']['sellrate'] . ' is greater than buying rate ' . $objNumberRange['Numberrange']['buyingrate']);
                                                  $this->Session->setFlash('Number cannot be assigned, Selling Rate cannot be greater than Buying Rate');
                                                  $this->redirect(array('action' => 'index'));
                                             } else {
                                                  $objRateupdate['Didrate']['superresrate'] = $this->data['Did']['sellrate'];
                                             }
                                        } else {

                                             if ($this->data['Did']['isdaily'] == 1) {

                                                  $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];

                                                  //     print_r($this->data);
                                                  //       die($this->data['Did']['dailyrate']);
                                             } else if ($this->data['Did']['isdaily'] == 0) {
                                                  $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                                             } else if ($this->data['Did']['isdaily'] == 2) {
                                                  $objRateupdate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                                             }
                                             //    die('here');
                                             ///////////
                                        }
//										 if($objRateupdate['Didrate']['currency_id'] == $this->data['Did']['currency_id'] ){							//////////////////////// Currency Change Not Allowe Check Revoked
                                        //       if ($this->data['Did']['currency_id'] != NULL || $this->data['Did']['currency_id'] != '') {
                                        //           $objDidRate['Didrate']['currency_id'] = $this->data['Did']['currency_id'];      ///////
                                        //           $objRateupdate['Didrate']['supres_currency'] = 0;    /////// Block on request by bukhari sb on 2014-03-12
                                        //    } else {
                                        $objRateupdate['Didrate']['admin_currency'] = $objNumberRange['Numberrange']['currency_id']; ///////
                                        $objRateupdate['Didrate']['supres_currency'] = $objNumberRange['Numberrange']['currency_id'];
                                        //  }
//										 echo "((". $objNumberRange['Numberrange']['currency_id'] . "))";exit;
//										 }else{																																							//////////////////////// Currency Change Not Allowe Check else Revoked
//											 $objDidRate['Didrate']['currency_id'] = $objNumberRange['NumberRange']['currency_id'];
//											$this->Session->setFlash(__('Currency Chages are not allowed', true));
//										 }

                                        $this->Didrate->save($objRateupdate);
                                   } else {
                                        $objDidRate = $this->Didrate->create();
                                        $objDidRate['Didrate']['did_id'] = $did;
                                        // $objDidRate['Didrate']['adminbuyrate'] = $this->data['Did']['buyrate'];
//                                        if ($this->data['Did']['isdaily'] == 1) {
//                                             $objDidRate['Didrate']['superresrate'] = $this->data['Did']['dailyrate'];
//                                             print_r($this->data);
//                                             die($this->data['Did']['dailyrate']);
//                                        } else {
                                        $objDidRate['Didrate']['superresrate'] = $this->data['Did']['sellrate'];
                                        // }

                                        $objDidRate['Didrate']['ressellerrate'] = 'NULL';
                                        $objDidRate['Didrate']['subresrate'] = 'NULL';
                                        $objDidRate['Didrate']['assignedBy'] = $this->Auth->user('id');
//									 $objDidRate['Didrate']['currency_id'] = $this->data['Did']['currency_id'];
                                        //        $objDidRate['Didrate']['currency_id'] = $objNumberRange['NumberRange']['currency_id'];
                                   }
                                   /*
                                     if($objRateupdate['Didrate']['currency_id'] == $this->data['Did']['currency_id'] ){


                                     }
                                     else{
                                     $this->Session->setFlash(__('Currency Chages are not allowed', true));

                                     }
                                    */
                              } else {
                                   // save did user
                                   $objdiduser = $this->DidsUser->create();
                                   $objdiduser['DidsUser']['did_id'] = $did;
                                   $objdiduser['DidsUser']['superresseler_id'] = $this->data['Did']['assign_to'];

                                   $objdiduser['DidsUser']['isdaily'] = $this->data['Did']['isdaily'];
                                   $objdiduser['DidsUser']['resseller_id'] = 'NULL';
                                   $objdiduser['DidsUser']['subresseller_id'] = 'NULL';
                                   $objdiduser['DidsUser']['modified'] = date('Y-m-d H:i:s');

                                   $this->DidsUser->save($objdiduser);

                                   //save did rate
                                   $objDidRate = $this->Didrate->create();
                                   $objDidRate['Didrate']['did_id'] = $did;
                                   // $objDidRate['Didrate']['adminbuyrate'] = $this->data['Did']['buyrate'];
                                   //  $objDidRate['Didrate']['superresrate'] = $this->data['Did']['sellrate'];

                                   if ($this->data['Did']['isdaily'] == 1) {

                                        $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['dailyrate'];
                                   } else if ($this->data['Did']['isdaily'] == 0) {
                                        $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['sellingrate'];
                                   } else if ($this->data['Did']['isdaily'] == 2) {
                                        $objDidRate['Didrate']['superresrate'] = $objNumberRange['Numberrange']['monthlyrate'];
                                   }

                                   $objDidRate['Didrate']['ressellerrate'] = 'NULL';
                                   $objDidRate['Didrate']['subresrate'] = 'NULL';
                                   $objDidRate['Didrate']['assignedBy'] = $this->Auth->user('id');
//									 $objDidRate['Didrate']['currency_id'] = $this->data['Did']['currency_id'];
                                   $objDidRate['Didrate']['currency_id'] = $objNumberRange['NumberRange']['currency_id'];

                                   $this->Didrate->save($objDidRate);
                              }
                         } else if ($this->Auth->user('role_id') == 2) {

                              $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $did));
                              $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
                              $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $did));
                              $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
                              if ($objupdate) {
                                   $objupdate['DidsUser']['resseller_id'] = $this->data['Did']['assign_to'];
                                   $objupdate['DidsUser']['subresseller_id'] = 0;
                                   $this->DidsUser->save($objupdate);

                                   $objRateupdate['Didrate']['ressellerrate'] = $this->data['Did']['sellrate'];
                                   //   if ($this->data['Did']['currency_id'] != NULL || $this->data['Did']['currency_id'] != '')
                                   //      $objRateupdate['Didrate']['reseller_currency'] = $this->data['Did']['currency_id'];
                                   // else

                                   $objRateupdate['Didrate']['reseller_currency'] = $objNumberRange['Numberrange']['currency_id'];
//                                $objRateupdate['Didrate']['currency_id'] = $this->data['Did']['currency_id'];
//                                 $objRateupdate['Didrate']['currency_id'] = $objNumberRange['NumberRange']['currency_id'];
                                   // print_r($objRateupdate);
                                   //  die();
                                   $this->Didrate->save($objRateupdate);
                                   //  $this->redirect(array('action' => 'index'));
                              }
                         } else if ($this->Auth->user('role_id') == 3) {
                              $objRateupdate = $this->Didrate->find('first', array('conditions' => 'Didrate.did_id =' . $did));
                              $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
                              $objdidupdate = $this->Did->find('first', array('conditions' => 'Did.id =' . $did));
                              $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $objdidupdate['Did']['numberrange_id']));
                              if ($objupdate) {
                                   $objupdate['DidsUser']['subresseller_id'] = $this->data['Did']['assign_to'];
                                   $this->DidsUser->save($objupdate);

                                   $objRateupdate['Didrate']['subresrate'] = $this->data['Did']['sellrate'];
                                   $objRateupdate['Didrate']['subres_currency'] = $this->data['Did']['currency_id'];
//                                $objRateupdate['Didrate']['currency_id'] = $this->data['Did']['currency_id'];
//                                   $objRateupdate['Didrate']['currency_id'] = $objNumberRange['NumberRange']['currency_id'];
                                   $this->Didrate->save($objRateupdate);
                              }
                         }
                    }
                    //die();
                    if ($this->Auth->user('role_id') == 1)
                    {
                    	
                     $messagefornotification="$allcount numbers from $rangename have been added on $payment_term payment term From My Numbers on this Rate ". $objRateupdate['Didrate']['superresrate'];
                     $query = "INSERT INTO ratecard_log (userid,assigned_dids,log_text,created) VALUE($uid,'$allnumbers','$messagefornotification','$todayDate')";
                     mysql_query($query) or die(mysql_error());
                   }
               }


               $this->redirect(array('action' => 'index'));
          } else {

               //admin did listing
               if ($this->Auth->user('role_id') == 1) {
                    $this->paginate = array('limit' => 100);
                    //print_r($this->paginate());
                    //exit;

                    if ($id != null && $number==null) {
                         //echo $id;
                         if ($id == 0) {
                              $this->paginate = array('order' => array('Numberrange.name' => 'asc'));
                              $this->set('dids', $this->paginate());
                         } else if ($id > 0) {
                              $results = $this->paginate('Did', array('Numberrange.id ' => $id));
                              $this->paginate = array(array('Numberrange.id ' => $id), 'order' => array('Numberrange.name' => 'asc'));
                              $this->set('dids', $results);
                         }
                    } else {
                         if ($number != null) {
						 //echo "abdull";
                              $this->Did->bindModel(array('hasOne' => array('DidsUser')), false);
                              $this->Did->recursive = 2;
                              $Usercount = $this->User->find('count', array('conditions' => array('User.login LIKE' => $number."%" )));
                              
                              if ($Usercount > 0){
                                  $rUserId = $this->User->find('first', array('conditions' => array('User.login LIKE' => $number."%" )));
                              }
                    
                              if(isset($rUserId)){
                                  $concateQuery = $rUserId['User']['id'] ;
                               }
                               else{
                                  $concateQuery = $number;
                               }

                              $results = $this->paginate('Did',array('OR'=>array('LOWER(Did.ivr_id) LIKE ' => $number . "%", 'LOWER(Did.did) LIKE ' => $number . "%" , 'DidsUser.superresseler_id' => $concateQuery)));
                              $this->set('dids', $results);
                         } else {
                              $this->paginate = array('order' => array('Numberrange.name' => 'asc'), 'limit' => 100);
                              $this->set('dids', $this->paginate());
                         }
                    }
               }
               // if super resseller is login
               else if ($this->Auth->user('role_id') == 2) {
                    //$this->paginate = array('limit' => 100);
                    // echo "Super";
                    $this->Did->bindModel(array('hasOne' => array('DidsUser')), false);
                    $this->Did->unbindModel(array('hasMany' => array('DidsUser')), false);
                    $this->paginate['Did']['contain'] = array('DidsUser');
                    $this->paginate = array('order' => array('Did.created' => 'desc'));
                    $this->paginate = array('order' => array('Numberrange.name' => 'asc'), 'limit' => 100);
                    //print_r($this->data);
                    //exit;
                    if ($id != null) {
                         if ($id == 0) {
                              $results = $this->paginate('Did', array('DidsUser.superresseler_id' => $this->Auth->user('id')));
                         } else if ($id > 0) {
                              $results = $this->paginate('Did', array('DidsUser.superresseler_id' => $this->Auth->user('id'), 'Numberrange.id' => $id));
                         }
                         //$this->set('dids',$results);
                         //echo 'condition';
                    } else {

                         $results = $this->paginate('Did', array('DidsUser.superresseler_id' => $this->Auth->user('id')));
                         //echo 'without condition';
                    }

                    $this->set('dids', $results);
               } else if ($this->Auth->user('role_id') == 3) {
                    //$this->paginate = array('limit' => 100);
                    $this->Did->bindModel(array('hasOne' => array('DidsUser')), false);
                    $this->Did->unbindModel(array('hasMany' => array('DidsUser')), false);
                    $this->paginate['Did']['contain'] = array('DidsUser');
                    $this->paginate = array('order' => array('Did.created' => 'desc'));
                    $this->paginate = array('order' => array('Numberrange.name' => 'asc'), 'limit' => 100);
                    if ($id != null) {
                         if ($id == 0) {
                              $results = $this->paginate('Did', array('DidsUser.resseller_id' => $this->Auth->user('id')));
                         } else if ($id > 0) {
                              $results = $this->paginate('Did', array('DidsUser.resseller_id' => $this->Auth->user('id'), 'Numberrange.id' => $id));
                         }
                    } else {
                         $results = $this->paginate('Did', array('DidsUser.resseller_id' => $this->Auth->user('id')));
                    }


                    $this->set('dids', $results);
               } else if ($this->Auth->user('role_id') == 4) {
                    //$this->paginate = array('limit' => 100);

                    $this->Did->bindModel(array('hasOne' => array('DidsUser')), false);
                    $this->Did->unbindModel(array('hasMany' => array('DidsUser')), false);
                    $this->paginate['Did']['contain'] = array('DidsUser');
                    $this->paginate = array('order' => array('Did.created' => 'desc'));
                    $this->paginate = array('order' => array('Numberrange.name' => 'asc'), 'limit' => 100);
                    if ($id != null) {
                         if ($id == 0) {
                              $results = $this->paginate('Did', array('DidsUser.subresseller_id' => $this->Auth->user('id')));
                         } else if ($id > 0) {
                              $results = $this->paginate('Did', array('DidsUser.subresseller_id' => $this->Auth->user('id'), 'Numberrange.id' => $id));
                         }
                    } else {

                         $results = $this->paginate('Did', array('DidsUser.subresseller_id' => $this->Auth->user('id')));
                    }
                    $this->set('dids', $results);
               }
          }

          $this->User->recursive = -1;
          // $users = $this->User->find('list', array('fields' => array('User.login'), 'order' => array('login ASC'), 'conditions' => array('User.role_id =' => $this->Auth->user('role_id') + 1, 'AND' => array('User.created_by = ' => $this->Auth->user('id')))));

          if($this->Auth->user('id') == 2){

            $users = $this->User->find('list',
            array('fields' => array('User.login'),
                  'order' => array('login ASC'),
                  'conditions' => array('User.role_id =' => $this->Auth->user('role_id') + 1,
                    'AND' => array('User.created_by <= ' => '2',
                      array( 'OR' => array(
                              array('User.isdeleted' => 0),
                              array('User.isdeleted' => null),
                              )
                      )
                      )
                    )
                  )
            );

          }
          else{
            $users = $this->User->find('list',
            array('fields' => array('User.login'),
                  'order' => array('login ASC'),
                  'conditions' => array('User.role_id =' => $this->Auth->user('role_id') + 1,
                    'AND' => array('User.created_by = ' => $this->Auth->user('id'),
                      array( 'OR' => array(
                              array('User.isdeleted' => 0),
                              array('User.isdeleted' => null),
                              )
                      )
                      )
                    )
                  )
          );
          }
          
          //ksort($users);
          //$users[0] = '--Select--';
          $currencies = $this->Currency->find('list', array('fields' => array('id', 'currency_name'), 'order' => array('currency_name ASC')));
          $Ivrs = $this->Ivrs->find('list', array('fields' => array('ivr_uploaded_name', 'ivr_name'), 'order' => array('ivr_name ASC')));
          $Ips = $this->Ips->find('list', array('fields' => array('ip_address', 'owner_name'), 'order' => array('owner_name ASC')));
          $Mivrs = $this->Mivrs->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));
          $this->set(compact('users', 'currencies', 'Ivrs', 'Ips', 'Mivrs'));
          $this->set('authUser', $this->Auth->user('role_id'));
          $this->paginate = array('order' => array('Numberrange.name' => 'asc'), 'limit' => 100);

          $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));



          //ksort($numberranges);
          //$numberranges[0] = '--Select--';
		  
		  

          $this->set(compact('numberranges'));
     }

     function assigntestuser($did) {
          //echo $did;
          //$objdiduser = $this->DidsUser->create();
          $objupdate = $this->DidsUser->find('first', array('conditions' => 'DidsUser.did_id =' . $did));
          print_r($objupdate);
          if ($objupdate) {
               $objdiduser['DidsUser']['did_id'] = $did;
               $objdiduser['DidsUser']['superresseler_id'] = 20;
               $objdiduser['DidsUser']['resseller_id'] = 'NULL';
               $objdiduser['DidsUser']['subresseller_id'] = 'NULL';
               $this->DidsUser->save($objdiduser);
          }
     }

     function assigntorootAll($did) {
          //echo $did;

          $objdiduser = $this->DidsUser->create();
          $objdiduser['DidsUser']['did_id'] = $did;
          $objdiduser['DidsUser']['superresseler_id'] = 23;
          $objdiduser['DidsUser']['resseller_id'] = 'NULL';
          $objdiduser['DidsUser']['subresseller_id'] = 'NULL';
          $this->DidsUser->save($objdiduser);
     }

     function test() {
          print_r($this->data);
          exit;
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid did', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('did', $this->Did->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->Did->create();
               if ($this->Did->save($this->data)) {
				   $did_id=$this->Did->getLastInsertID();
				   $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $this->data['Did']['numberrange_id']));				   
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
			   //            print_r($this->data);
                    //exit;
                    // echo $this->data['Did']['did'];
                    //exit;

                    $this->assigntorootAll($this->Did->id);
                    //echo($this->$Did['did']);
                    $this->Session->setFlash(__('The did has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The did could not be saved. Please, try again.', true));
               }
          }
//		$numberranges = $this->Did->Numberrange->find('list');
          $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));

          $this->set(compact('numberranges'));
     }

     function edit($id = null) {

          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid did', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {

               //assigntestuser();
               //DidIsTestNumber
               //print_r($this->data);
               //exit;
               if ($this->Did->save($this->data)) {

                    if ($this->data['Did']['IsTestNumber'] == 1) {
                         // echo "entered";
                         //$this->assigntestuser($id);
                         //exit;
                         App::import('Helper', 'Getuser'); // loadHelper('Html'); in CakePHP 1.1.x.x
                         $getuser = new GetuserHelper();
                         $assingroot = $getuser->updatetest($id);
                         //echo $assingroot;
                         //     exit;
                    } else if ($this->data['Did']['IsTestNumber'] == 0) {

                    }


                    $this->Session->setFlash(__('The did has been saved', true));
//                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The did could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->Did->read(null, $id);
          }
//		$numberranges = $this->Did->Numberrange->find('list');
          $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));
          $this->set(compact('numberranges'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for did', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->Did->delete($id)) {
               $this->Session->setFlash(__('Did deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Did was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function assigndid() {
          $this->autoRender = false;
          //   print_r($this->data);
          //  echo 'ok';
     }

     function uploaddid() {
          if (!empty($this->data)) {

               if (substr(strrchr($this->data['Did']['did']['name'], '.'), 1) == 'csv') {
                    $fileOK = $this->uploadFiles('files', $this->data['Did']);
                    $handle = fopen($fileOK['urls'][0], "r");
                    $count = 0;
                    $duplicate = 0;
                    $this->Numberrange->recursive = 0;
                    $objNumberRange = $this->Numberrange->find('first', array('conditions' => 'Numberrange.id=' . $this->data['Did']['numberrange_id']));

                    $dids_count = $this->Did->find('count', array('conditions' => 'Did.numberrange_id='. $this->data['Did']['numberrange_id']));
                    // var_dump( $objNumberRange);
                    // exit();
                    while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {

                      //  var_dump($data[0], $data[1]);
                      //  $userdata = $this->User->findByLogin($data[1]);
                      //  var_dump($userdata);
                      // exit();
                         // foreach ($data as $element) {
                              $userdata = $this->User->findByLogin($data[1]);

                              $found = $this->Did->findByDid($data[0]);
                              if ($found != "") {
                                   $duplicate++;
                              } else {

                                   $objDid = $this->Did->create();
                                   $objDid['Did']['numberrange_id'] = $this->data['Did']['numberrange_id'];
                                   $objDid['Did']['did'] = $data[0];
                                   $objDid['Did']['maxdailyminutes'] = $objNumberRange['Numberrange']['maxdailyminutes'];
                                   $objDid['Did']['perclilimit'] = $objNumberRange['Numberrange']['clilimit'];
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

                                      if ($userdata != "") {
                                        $objDidUser['DidsUser']['superresseler_id'] = $userdata['User']['id'];
                                      }
                                      else{
                                        $objDidUser['DidsUser']['superresseler_id'] = 23;
                                      }

                                    }
                                   
                                   $objDidUser['DidsUser']['resseller_id'] = 0;
                                   $objDidUser['DidsUser']['subresseller_id'] = 0;
                                   $objDidUser['DidsUser']['isdaily'] = 0;
                                  
                                  $this->DidsUser->save($objDidUser);
                                   
                                   $count++;
                              }
                         // }
                    }
                    $this->Session->setFlash(__('Inserted = ' . $count . ', Duplicate = ' . $duplicate, true));
                    fclose($handle);
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('not a valid csv file', true));
               }
          }
//		$numberranges = $this->Did->Numberrange->find('list');
          $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));
          $this->set(compact('numberranges'));
     }


     function uploaddidrange() {
          if (!empty($this->data)) {

               if (substr(strrchr($this->data['Did']['did']['name'], '.'), 1) == 'csv') {
                    $fileOK = $this->uploadFiles('files', $this->data['Did']);
                    $handle = fopen($fileOK['urls'][0], "r");
                    $count = 0;
                    $duplicate = 0;
                    $rangeNotFound=0;
                   
                    while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
                        // if($count!=0)
                        // {
							
						      $objNumberRange = $this->Numberrange->findByName($data[0]);
                  // die(var_dump($objNumberRange));
                  $dids_count = $this->Did->find('count', array('conditions' => 'Did.numberrange_id='. $objNumberRange['Numberrange']['id']));
                  
                  // die(var_dump($dids_count));
						      if($objNumberRange != "")
						      {
							 
                              $userdata = $this->User->findByLogin($data[2]);
                              $found = $this->Did->findByDid($data[1]);

                              if ($found != "") {
                                   $duplicate++;
                                   // die(var_dump("duplicate"));
                              } else {

                                   $objDid = $this->Did->create();
                                   $objDid['Did']['numberrange_id'] = $objNumberRange['Numberrange']['id'];
                                   $objDid['Did']['did'] = $data[1];
                                  $objDid['Did']['perclilimit'] = $objNumberRange['Numberrange']['clilimit'];
                                   $objDid['Did']['maxdailyminutes'] = $objNumberRange['Numberrange']['maxdailyminutes'];

                                   if($count == 0 && $dids_count == 0){
                                    // die(var_dump('enter'));
                                        $objDid['Did']['IsTestNumber'] = '1';
                                    }

                                   if(!empty($objNumberRange['Numberrange']['ivrpath']))
                                   {
                  								   	$objDid['Did']['ivr_id'] = $objNumberRange['Numberrange']['ivrpath'];
                  								   }
                  								   else{
                  								   $objDid['Did']['ivr_id'] = 'TeachYourselfEnglishINTHECITY.wav';	
                                    }
                                    // die(var_dump($objDid));
                                   $this->Did->save($objDid);
                                   $did_id=$this->Did->getLastInsertID();
                                    // die(var_dump($did_id));

                                   
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
                                    if($count == 0 && $dids_count == 0){
                                        $objDidUser['DidsUser']['superresseler_id'] = 20;
                                    }
                                    else{
                                       if ($userdata != "") {
                                          $objDidUser['DidsUser']['superresseler_id'] = $userdata['User']['id'];
                                        }
                                        else{
                                          $objDidUser['DidsUser']['superresseler_id'] = 23;
                                        }
                                        
                                    }
                                   $objDidUser['DidsUser']['resseller_id'] = 0;
                                   $objDidUser['DidsUser']['subresseller_id'] = 0;
                                   $objDidUser['DidsUser']['isdaily'] = 0;
                                  
                                  $this->DidsUser->save($objDidUser);
                                   
                                   $count++;
                              }
                            }
                         else
                         {
						 	$rangeNotFound++;
						 }
       //                   }
                         
       //                   else
       //                   {
						 // 	$count++;
						 // }
                   }
                   $count=$count - 1;
                    $this->Session->setFlash(__('Inserted = ' . $count . ', Duplicate = ' . $duplicate. ', Range Not Found = ' . $rangeNotFound, true));
                    fclose($handle);
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('not a valid csv file', true));
               }
          }
//		$numberranges = $this->Did->Numberrange->find('list');
          $numberranges = $this->Numberrange->find('list', array('fields' => array('id', 'name'), 'order' => array('name ASC')));
          $this->set(compact('numberranges'));
     }
     /**
      * uploads files to the server
      * @params:
      * 		$folder 	= the folder to upload the files e.g. 'img/files'
      * 		$formdata 	= the array containing the form files
      * 		$itemId 	= id of the item (optional) will create a new sub folder
      * @return:
      * 		will return an array with the success of each file upload
      */
     function uploadFiles($folder, $formdata, $itemId = null) {
          // setup dir names absolute and relative
          $folder_url = WWW_ROOT . $folder;
          $rel_url = $folder;

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
          $permitted = array('text/csv', 'application/vnd.ms-excel', 'text/x-csv');

          // loop through and deal with the files
          foreach ($formdata as $file) {
               // replace spaces with underscores
               $filename = str_replace(' ', '_', $file['name']);
               // assume filetype is false
               $typeOK = false;
               // check filetype is ok
               foreach ($permitted as $type) {
                    if ($type == $file['type']) {
                         $typeOK = true;
                         break;
                    }
               }

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
                                   // upload the file
                                   $success = move_uploaded_file($file['tmp_name'], $url);
                              } else {
                                   // create unique filename and upload file
                                   ini_set('date.timezone', 'Europe/London');
                                   $now = date('Y-m-d-His');
                                   $full_url = $folder_url . '/' . $now . $filename;
                                   $url = $rel_url . '/' . $now . $filename;
                                   $success = move_uploaded_file($file['tmp_name'], $url);
                              }
                              // if upload was successful
                              if ($success) {
                                   // save the url of the file

                                   /* 						$connection = ssh2_connect('http://69.175.121.164', 22);
                                     echo "I am in success";exit;
                                     ssh2_auth_password($connection, 'root', 'r5dh@t');

                                     ssh2_scp_send($connection,$url, '/var/www/html/livecalls/app/webroot/files/ivr/', 0644);
                                    */

                                   $result['urls'][] = $url;
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
                    $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: CSV.";
               }
          }
          return $result;
     }

     function numberrange() {

          //echo "called in controller";
     }

     function download() {

     }

     function ratecard() {
     	$name="";
        if (isset($_GET['name'])) {
        	  $str=$_GET['name'];
               $name ="and (numberranges.`name` like '%$str%' OR dids.did like '%$str%')";
          }
          $query="SELECT numberranges.`id`, numberranges.`created`,numberranges.`name`,did,
currencies.`currency_name`,numberranges.`maxdailyminutes`,
numberranges.`sellingrate`, numberranges.`dailyrate`,numberranges.`monthlyrate`,
numberranges.`weekly_title`,numberranges.`monthly_title`
FROM dids
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
JOIN currencies ON currencies.`id`=numberranges.`currency_id`
WHERE dids.`IsTestNumber`=1 $name ORDER BY numberranges.`name` ";
         
          $results = $this->Did->query($query, $cachequeries = false);
          $this->set('dids', $results);
/*		  
          $query="SELECT numberranges.`id`, numberranges.`name`,did,
currencies.`currency_name`,numberranges.`maxdailyminutes`,
numberranges.`sellingrate`, numberranges.`dailyrate`,numberranges.`monthlyrate`,
numberranges.`weekly_title`,numberranges.`monthly_title`
FROM dids
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
JOIN currencies ON currencies.`id`=numberranges.`currency_id`
WHERE dids.`IsTestNumber`=1 $name ORDER BY numberranges.`name` limit 1500,1000 ";
         
          $results = $this->Did->query($query, $cachequeries = false);
//		  echo "i am here before Set statement";		
         $this->set('dd', $results);
//		  echo "i am here after Set statement";		
*/
	}
     
     function ratecard_log() {
     	if ($this->Auth->user('role_id') == 1) {
     	
          $query="SELECT users.`login`, ratecard_log.`id`,ratecard_log.`userid`,ratecard_log.`assigned_dids`,
ratecard_log.`log_text`,ratecard_log.`created` FROM ratecard_log
JOIN users ON users.`id`=ratecard_log.`userid` ORDER BY ratecard_log.`created` DESC limit 2000";
         
          $results = $this->Did->query($query, $cachequeries = false);
       
          $this->set('dids', $results);
         }
         else
         $this->redirect(array('controller' => 'dids', 'action' => 'ratecard'));
     }
     
     

     function bulkdelete() {

          $this->autoRender = false;
//	echo $_GET['hdnselected'];exit;
          $arr_dids = explode(',', $_GET['hdnselected']);
          foreach ($arr_dids as $did) {
               $query = "delete from didrates where didrates.did_id = " . $did;
               $this->Didrate->query($query);
               $query = "delete from dids where dids.id=" . $did;
               $this->Did->query($query);
          }
          $this->redirect(array('action' => 'index'));
     }

     function delete_orphan_dids(){
          $this->autoRender = false;
          // delete those dids where number range does not exist
          $query = " DELETE FROM dids WHERE numberrange_id NOT IN ( select id from numberranges )";
          $this->Did->query($query);


          $this->redirect(array('action' => 'index'));
     }

}
