<?php

//class PayoneerUsersController extends AppController {
//
//     function beforeFilter() {
//          $this->Auth->allow('update_status');
//     }
//
//     var $name = 'PayoneerUser';
//     var $components = array('Email');
//     var $layout = 'livecalls3';
//
//     function index($id = null) {
//          //die('abc');
//          if (!$id) {
//               if ($this->Auth->User('role_id') == 1) {
//                    $this->Session->setFlash(__('Invalid accounts user', true));
//                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
//               } else {
//                    $id = $this->Auth->User('id');
//               }
//          }
//          if ($this->Auth->User('role_id') != 1) {
//               if ($this->Auth->User('id') != $id) {
//                    $this->Session->setFlash(__('Invalid accounts user', true));
//                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
//               }
//          }
//          $user = $this->PayoneerUser->User->findById($id);
//          $this->PayoneerUser->recursive = 0;
//          $this->Session->setFlash(__('', true));
//          $this->set('user', $user);
//          $this->set('payoneerUsers', $this->paginate(null, array('user_id' => $id)));
//     }
//
//     function view($id = null) {
//          if ($this->Auth->User('role_id') != 1) {
//               $ac = $this->PayoneerUser->findById($id);
//               if ($this->Auth->User('id') != $ac['PayoneerUser']['user_id']) {
//                    $this->Session->setFlash(__('Invalid accounts user', true));
//                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
//               }
//          }
//          if (!$id) {
//               $this->Session->setFlash(__('Invalid payoneer user', true));
//               $this->redirect(array('action' => 'index'));
//          }
//          $this->set('payoneerUser', $this->PayoneerUser->read(null, $id));
//     }
//
//     function add() {
//          if (!empty($this->data)) {
//               $this->PayoneerUser->create();
//               if ($this->PayoneerUser->save($this->data)) {
//                    $this->Session->setFlash(__('The payoneer user has been saved', true));
//                    $this->redirect(array('action' => 'index'));
//               } else {
//                    $this->Session->setFlash(__('The payoneer user could not be saved. Please, try again.', true));
//               }
//          }
//          $users = $this->PayoneerUser->User->find('list');
//          $this->set(compact('users'));
//     }
//
//     function edit($id = null) {
//          if ($this->Auth->User('role_id') != 1) {
//               $ac = $this->PayoneerUser->findById($id);
//               if ($this->Auth->User('id') != $ac['PayoneerUser']['user_id']) {
//                    $this->Session->setFlash(__('Invalid accounts user', true));
//                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
//               }
//          }
//          if (!$id && empty($this->data)) {
//               $this->Session->setFlash(__('Invalid payoneer user', true));
//               $this->redirect(array('action' => 'index'));
//          }
//          if (!empty($this->data)) {
//               $this->data['PayoneerUser']['status'] = 1;
//               if ($this->PayoneerUser->save($this->data)) {
//                    $this->Session->setFlash(__('The payoneer user has been saved', true));
//                    $this->Email->smtpOptions = array(
//                        'port' => '465',
//                        'timeout' => '100',
//                        'host' => 'ssl://smtp.gmail.com',
//                        'username' => 'livecalls1@gmail.com',
//                        'password' => 'live!123',
//                    );
//
//                    $User = $this->PayoneerUser->read(null, $id);
//                    $this->set('User', $User);
//                    $this->Email->to = $User['User']['email'];
//                    $this->Email->bcc = array('rameez931@gmail.com');
//                    $this->Email->subject = 'Account Details Confirmation';
//                    $this->Email->replyTo = 'livecalls1@gmail.com';
//                    $this->Email->from = 'Live Calls <no-reply@livecalls.hk>';
//                    $this->Email->template = 'payoneer_verification'; // note no '.ctp'
//                    //Send as 'html', 'text' or 'both' (default is 'text')
//                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
//                    //Set view variables as normal
//
//                    $this->Email->delivery = 'smtp';
//                    //Do not pass any args to send()
//                    $this->Email->send();
//                    $this->redirect(array('action' => 'index'));
//               } else {
//                    $this->Session->setFlash(__('The payoneer user could not be saved. Please, try again.', true));
//               }
//          }
//          if (empty($this->data)) {
//               $this->data = $this->PayoneerUser->read(null, $id);
//          }
//          $users = $this->PayoneerUser->User->find('list');
//          $this->set(compact('users'));
//     }
//
//     function delete($id = null) {
////          if (!$id) {
////               $this->Session->setFlash(__('Invalid id for payoneer user', true));
////               $this->redirect(array('action' => 'index'));
////          }
////          if ($this->PayoneerUser->delete($id)) {
////               $this->Session->setFlash(__('Payoneer user deleted', true));
////               $this->redirect(array('action' => 'index'));
////          }
////          $this->Session->setFlash(__('Payoneer user was not deleted', true));
//          $this->redirect(array('action' => 'index'));
//     }
//
//     function update_status($id = null) {
//          if (!$id) {
//               $this->Session->setFlash(__('Invalid id for accounts user', true));
//               $this->redirect(array('action' => 'index'));
//          }
//
//          $this->PayoneerUser->updateAll(
//                  array('PayoneerUser.status' => 2), array('PayoneerUser.id' => $id)
//          );
//          $this->redirect(array('action' => 'index'));
//     }
//
//}

class PayoneerUsersController extends AppController {

     function beforeFilter() {
          $this->Auth->allow('update_status');
     }

     var $name = 'PayoneerUsers';
     var $components = array('Email');
     var $layout = 'livecalls3';

     function index($id = null) {
          if (!$id) {
               if ($this->Auth->User('role_id') == 1) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
               } else {
                    $id = $this->Auth->User('id');
               }
          }
          $user = $this->PayoneerUser->User->findById($id);
          $this->PayoneerUser->recursive = 0;
          $this->Session->setFlash(__('', true));
          $this->set('user', $user);
          $this->set('payoneerUsers', $this->paginate(null, array('user_id' => $id)));
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid payoneer user', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('payoneerUser', $this->PayoneerUser->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->PayoneerUser->create();
               if ($this->PayoneerUser->save($this->data)) {
                    $this->Session->setFlash(__('The payoneer user has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The payoneer user could not be saved. Please, try again.', true));
               }
          }
          $users = $this->PayoneerUser->User->find('list');
          $this->set(compact('users'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid payoneer user', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               $this->data['PayoneerUser']['status'] = 1;
               if ($this->PayoneerUser->save($this->data)) {
                    $this->Session->setFlash(__('The payoneer user has been saved', true));
                    $this->Email->smtpOptions = array(
                        'port' => '25',
              'timeout' => '100',
              'host' => 'khalltelecom.net',
              'username' => 'noreply@khalltelecom.net',
              'password' => 'no@reply@khall',
                    );

                    $User = $this->PayoneerUser->read(null, $id);
                    $this->set('User', $User);
                    $this->Email->to = $User['User']['email'];
                    $this->Email->bcc = array('hklivecalls@gmail.com');
                    $this->Email->subject = 'Account Details Confirmation';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <noreply@khalltelecom.net>';
                    $this->Email->template = 'payoneer_verification'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The payoneer user could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->PayoneerUser->read(null, $id);
          }
          $users = $this->PayoneerUser->User->find('list');
          $this->set(compact('users'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for payoneer user', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->PayoneerUser->delete($id)) {
               $this->Session->setFlash(__('Payoneer user deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Payoneer user was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function update_status($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for accounts user', true));
               $this->redirect(array('action' => 'index'));
          }

          $this->PayoneerUser->updateAll(
                  array('PayoneerUser.status' => 2), array('PayoneerUser.id' => $id)
          );
          $this->redirect(array('action' => 'index'));
     }

}
