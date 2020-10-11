<?php

class AccountsUsersController extends AppController {

     function beforeFilter() {
          $this->Auth->allow('update_status');
          ini_set('memory_limit', '-1');
     }

     //var $uses = array('User', 'Country', 'State', 'City');
     var $name = 'AccountsUsers';
     var $helpers = array('Ajax');
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

          $user = $this->AccountsUser->User->findById($id);
          if ($this->Auth->User('role_id') != 1) {
               if ($this->Auth->User('id') != $id) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          $this->AccountsUser->recursive = 0;
          $this->Session->setFlash(__('', true));
          $this->set('user', $user);
          $this->set('accountsUsers', $this->paginate(null, array('AccountsUser.user_id ' => $id)));
     }

     function view($id = null) {
          if ($this->Auth->User('role_id') != 1) {
               $ac = $this->AccountsUser->findById($id);
               if ($this->Auth->User('id') != $ac['AccountsUser']['user_id']) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          if (!$id) {

               $this->Session->setFlash(__('Invalid accounts user', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('accountsUser', $this->AccountsUser->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->AccountsUser->create();
               if ($this->AccountsUser->save($this->data)) {
                    $this->Session->setFlash(__('The accounts user has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The accounts user could not be saved. Please, try again.', true));
               }
          }
          $countries = $this->AccountsUser->Country->find('list');
          $states = $this->AccountsUser->State->find('list');
          $cities = $this->AccountsUser->City->find('list');
          $currencies = $this->AccountsUser->Currency->find('list');
          $users = $this->AccountsUser->User->find('list');
          $this->set(compact('countries', 'states', 'cities', 'currencies', 'users'));
     }

     function edit($id = null) {
          if ($this->Auth->User('role_id') != 1) {
               $ac = $this->AccountsUser->findById($id);
               if ($this->Auth->User('id') != $ac['AccountsUser']['user_id']) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid accounts user', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               $this->data['AccountsUser']['status'] = 1;
               if ($this->AccountsUser->save($this->data)) {

                    $this->Session->setFlash(__('The accounts details have saved. Kindly Check your mail for account confirmation ', true));
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '100',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'livecalls1@gmail.com',
                        'password' => 'G+8~#\m+$5^5xsy',
                    );

                    $User = $this->AccountsUser->read(null, $id);
                    $this->set('User', $User);
                    $this->Email->to = $User['User']['email'];
                    $this->Email->bcc = array('rameez931@gmail.com');
                    $this->Email->subject = 'Account Details Confirmation';
                    $this->Email->replyTo = 'livecalls1@gmail.com';
                    $this->Email->from = 'Live Calls <no-reply@livecalls.hk>';
                    $this->Email->template = 'account_verification'; // note no '.ctp'
                    //Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail
                    //Set view variables as normal

                    $this->Email->delivery = 'smtp';
                    //Do not pass any args to send()
                    $this->Email->send();
                    $this->Session->setFlash(__('The accounts user could not be saved. Please, try again.' . $User['User']['email'], true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The accounts user could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->AccountsUser->read(null, $id);
          }
          $countries = $this->AccountsUser->Country->find('list');
          $states = $this->AccountsUser->State->find('list');
          $cities = $this->AccountsUser->City->find('list');
          $currencies = $this->AccountsUser->Currency->find('list');
          $cc = $this->AccountsUser->read(null, $id);
          $users = $this->AccountsUser->User->find('list');






          $this->set(compact('countries', 'states', 'cities', 'currencies', 'users', 'cc'));
     }

     function view_all() {

          $this->AccountsUser->recursive = 0;
          $this->set('accountsUsers', $this->paginate());
//          if (!$id) {
//               $this->Session->setFlash(__('Invalid id for accounts user', true));
//               $this->redirect(array('controller' => 'users', 'action' => 'index'));
//          }
//          $this->Session->setFlash(__('The accounts user could not be saved. Please, try again.', true));
//          $this->AccountsUser->recursive = 0;
//          $this->set('accountsUsers', $this->paginate());
     }

     function selection($id = null) {
          if (!$id) {
               if ($this->Auth->User('role_id') == 1) {
                    $this->Session->setFlash(__('Unable to find record.', true));
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
               } else {
                    $id = $this->Auth->User('id');
                    //  $this->set('user', $user);
               }
          }
          $user = $this->AccountsUser->User->findById($id);
          if (!$user) {
               $this->Session->setFlash(__('The accounts user could not be found. Please, try again.', true));
               $this->redirect(array('controller' => 'users', 'action' => 'index'));
          }
          $this->set('user', $user);
     }

     function delete($id = null) {
//          if (!$id) {
//               $this->Session->setFlash(__('Invalid id for accounts user', true));
//               $this->redirect(array('action' => 'index'));
//          }
//          if ($this->AccountsUser->delete($id)) {
//               $this->Session->setFlash(__('Accounts user deleted', true));
//               $this->redirect(array('action' => 'index'));
//          }
          $this->Session->setFlash(__('Accounts user was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

     function update_status($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for accounts user', true));
               $this->redirect(array('action' => 'index'));
          }

          $this->AccountsUser->updateAll(
                  array('AccountsUser.status' => 2), array('AccountsUser.id' => $id)
          );
          $this->redirect(array('action' => 'index'));
     }

}
