<?php

class WireUsersController extends AppController {

     function beforeFilter() {
          $this->Auth->allow('update_status');
          ini_set('memory_limit', '-1');
     }

     var $name = 'WireUsers';
     var $components = array('Email');
     var $layout = 'livecalls3';

     //var $uses = array('City');

     function index($id = null) {
          if (!$id) {
               if ($this->Auth->User('role_id') == 1) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
               } else {
                    $id = $this->Auth->User('id');
               }
          }
          $user = $this->WireUser->User->findById($id);
          $this->WireUser->recursive = 0;
          $this->Session->setFlash(__('', true));
          $this->set('user', $user);
          $this->set('wireUsers', $this->paginate(null, array('user_id' => $id)));
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid wire user', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('wireUser', $this->WireUser->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->WireUser->create();
               if ($this->WireUser->save($this->data)) {
                    $this->Session->setFlash(__('The wire user has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The wire user could not be saved. Please, try again.', true));
               }
          }
          $countries = $this->WireUser->Country->find('list');
          //     $cities = $this->WireUser->City->find('list');
          $users = $this->WireUser->User->find('list');
          $states = $this->WireUser->State->find('list');
          $this->set(compact('countries', 'users', 'states'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid wire user', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               //  die(print_r($this->data));

               $this->data['WireUser']['status'] = 1;
               if ($this->WireUser->save($this->data)) {
                    $this->Session->setFlash(__('The wire user has been saved', true));
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '100',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'livecalls1@gmail.com',
                        'password' => 'G+8~#\m+$5^5xsy',
                    );

                    $User = $this->WireUser->read(null, $id);
                    $this->set('User', $User);
                    $this->Email->to = $User['User']['email'];
                    $this->Email->bcc = array('rameez931@gmail.com');
                    $this->Email->subject = 'Account Details Confirmation';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <no-reply@livecalls.hk>';
                    $this->Email->template = 'wire_verification'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The wire user could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->WireUser->read(null, $id);
          }
          $users = $this->WireUser->User->find('list');
//
          $countries = $this->WireUser->Country->find('list');
          $states = $this->WireUser->State->find('list');
          $cities = $this->WireUser->City->find('list');
          $this->set(compact('countries', 'cities', 'users', 'states'));
          //      $this->set('users');
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for wire user', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->WireUser->delete($id)) {
               $this->Session->setFlash(__('Wire user deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Wire user was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function update_status($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for accounts user', true));
               $this->redirect(array('action' => 'index'));
          }

          $this->WireUser->updateAll(
                  array('WireUser.status' => 2), array('WireUser.id' => $id)
          );
          $this->redirect(array('action' => 'index'));
     }

}
