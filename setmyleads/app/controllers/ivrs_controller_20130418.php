<?php
class IvrsController extends AppController {

	var $name = 'Ivrs';
    var $layout ='livecalls';
	
	function index() {
		$this->Ivr->recursive = 0;
		$this->set('ivrs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ivr', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ivr', $this->Ivr->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ivr->create();
			   if($this->data['Ivr']['ivr_name']['name'] != "")
			   {
			   $fileOK = $this->uploadFiles('files/ivr', $this->data['Ivr']);                          
			   $this->data['Ivr']['ivr_uploaded_name'] = $fileOK['fname'][0];
//			   echo $fileOK['fname'][0];exit;
			   $this->data['Ivr']['ivr_name'] = $this->data['Ivr']['ivr_name']['name'] ;
				if ($this->Ivr->save($this->data)) {
					$this->Session->setFlash(__('The ivr has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ivr could not be saved. Please, try again.', true));
				}
			   }else {
                     $this->Session->setFlash(__('Please select a file to upload', true)); 
			   }
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ivr', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			   if($this->data['Ivr']['ivr_name']['name'] != "")
			   {
				   $fileOK = $this->uploadFiles('files/ivr', $this->data['Ivr']);                          
				   $this->data['Ivr']['ivr_uploaded_name'] = $fileOK['fname'][0];
				   $this->data['Ivr']['ivr_name'] = $this->data['Ivr']['ivr_name']['name'] ;
					if ($this->Ivr->save($this->data)) {
						$this->Session->setFlash(__('The ivr has been saved', true));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('The ivr could not be saved. Please, try again.', true));
					}
			   }else {
				   $this->Session->setFlash(__('Please select a file to upload', true)); 
			   }
		}
		if (empty($this->data)) {
			$this->data = $this->Ivr->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ivr', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ivr->delete($id)) {
			$this->Session->setFlash(__('Ivr deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ivr was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

function uploadFiles($folder, $formdata, $itemId = null) {
	// setup dir names absolute and relative
	$folder_url = WWW_ROOT.$folder;
	$rel_url = $folder;
	$savedfilename = '';
	// create the folder if it does not exist
	if(!is_dir($folder_url)) {
		mkdir($folder_url);
	}
	
	// if itemId is set create an item folder
	if($itemId) {
		// set new absolute folder
		$folder_url = WWW_ROOT.$folder.'/'.$itemId; 
		// set new relative folder
		$rel_url = $folder.'/'.$itemId;
		// create directory
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
	}
	
	// list of permitted file types, this is only images but documents can be added
	$permitted = array('audio/x-ms-wma');
	
	// loop through and deal with the files
	foreach($formdata as $file) {
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
		if($typeOK) {
			// switch based on error code

			switch($file['error']) {
				case 0:
					// check filename already exists
					if(!file_exists($folder_url.'/'.$filename)) {
						// create full filename
						$full_url = $folder_url.'/'.$filename;
						$url = $rel_url.'/'.$filename;
                                                $savedfilename = $filename;
						// upload the file
						$success = move_uploaded_file($file['tmp_name'], $url);
					} else {
						// create unique filename and upload file
						ini_set('date.timezone', 'Europe/London');
						$now = date('Y-m-d-His');
						$now = str_replace("-","",$now);
						$full_url = $folder_url.'/'.$now.$filename;
						$url = $rel_url.'/'.$now.$filename;
						$success = move_uploaded_file($file['tmp_name'], $url);
						$savedfilename = $now.$filename;

					}
					// if upload was successful
					if($success) {
						// save the url of the file
						$result['urls'][] = $url;
                        $result['fname'][] = $savedfilename;
						$connection = ssh2_connect('192.168.1.13', 22);
						if($connection){
							ssh2_auth_password($connection, 'root', 'r5dh@t');
							ssh2_scp_send($connection, $url, '/var/www/html/livecalls/app/webroot/'.$url, 0777);
						} else {
							echo "connection failed 164";
						}
						$connection = ssh2_connect('192.168.1.13', 22);
						ssh2_auth_password($connection, 'root', 'r5dh@t');
						ssh2_scp_send($connection, $url, '/var/www/html/livecalls/app/webroot/'.$url, 0777);						

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
		} elseif($file['error'] == 4) {
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
