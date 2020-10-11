<?php

class MivrsController extends AppController {

     var $name = 'Mivrs';
     var $layout = 'livecalls';

     function beforeFilter() {
          parent::beforeFilter();

          ini_set('memory_limit', '-1');
          // ini_set('upload_max_filesize', '60M');
          //  ini_set('post_max_size', '60M');
     }

     function index() {
          $this->Mivr->recursive = 0;
          $this->set('mivrs', $this->paginate());
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid mivr', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('mivr', $this->Mivr->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               // $fileOK = $this->uploadFiles('files/ivr', $this->data['Mivr']);
               $folder_url = WWW_ROOT;
               // echo $folder_url;
               $fileOK = $this->uploadFiles('files/mivrs', $this->data['Mivr']);

               //  print_r($fileOK);
               //die();
//   $this->data['Mivr']['ivr_uploaded_name'] = $fileOK['fname'][0];
//			   echo $fileOK['fname'][0];exit;
               //  $this->data['Mivr']['0'] = $this->data['Mivr']['0']['name'];
               $this->data['Mivr']['0'] = $fileOK['fname'][0];
               $this->data['Mivr']['1'] = $fileOK['fname'][1];
               $this->data['Mivr']['2'] = $fileOK['fname'][2];
               $this->data['Mivr']['3'] = $fileOK['fname'][3];
               $this->data['Mivr']['4'] = $fileOK['fname'][4];
               $this->data['Mivr']['5'] = $fileOK['fname'][5];
               $this->data['Mivr']['6'] = $fileOK['fname'][6];
               $this->data['Mivr']['7'] = $fileOK['fname'][7];
               $this->data['Mivr']['8'] = $fileOK['fname'][8];
               $this->data['Mivr']['9'] = $fileOK['fname'][9];
               $this->data['Mivr']['10'] = $fileOK['fname'][10];
               // print_r($fileOK);
               //die(print_r($this->data));
               $this->Mivr->create();
               if ($this->Mivr->save($this->data)) {
                    $this->Session->setFlash(__('The mivr has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The mivr could not be saved. Please, try again.', true));
               }
          }
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid mivr', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               if ($this->Mivr->save($this->data)) {
                    $this->Session->setFlash(__('The mivr has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The mivr could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->Mivr->read(null, $id);
          }
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for mivr', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->Mivr->delete($id)) {
               $this->Session->setFlash(__('Mivr deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Mivr was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function uploadFiles($folder, $formdata, $itemId = null) {
          // echo 'HERE';
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
                                   $now = str_replace("-", "", $now);
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
                                   /* 						$connection = ssh2_connect('69.175.121.164', 22);
                                     if($connection){
                                     ssh2_auth_password($connection, 'root', 'r5dh@t');
                                     ssh2_scp_send($connection, $url, '/var/www/html/livecalls/app/webroot/'.$url, 0777);
                                     } else {
                                     echo "connection failed 164";
                                     }
                                     $connection = ssh2_connect('69.175.121.165', 22);
                                     ssh2_auth_password($connection, 'root', 'r5dh@t');
                                     ssh2_scp_send($connection, $url, '/var/www/html/livecalls/app/webroot/'.$url, 0777);
                                    */
                              } else {
                                   $result['errors'][] = "Error uploaded 1 $filename. Please try again.";
                              }
                              break;
                         case 3:
                              // an error occured
                              $result['errors'][] = "Error uploading 2 $filename. Please try again.";
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

}
