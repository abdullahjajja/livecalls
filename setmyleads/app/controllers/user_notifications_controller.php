<?php

class UserNotificationsController extends AppController {

     var $name = 'UserNotifications';
     var $layout = 'livecalls';

     function index() {
          $this->UserNotification->recursive = 0;
          $user_id = $this->Auth->User('id');
          $this->paginate = array(
              'conditions' => array('user_id' => $user_id, 'status' => '1'),
              'order' => array('UserNotification.id' => 'DESC'),
              'limit' => 10
          );
          $this->set('userNotifications', $this->paginate());
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid user notification', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('userNotification', $this->UserNotification->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->UserNotification->create();
               if ($this->UserNotification->save($this->data)) {
                    $this->Session->setFlash(__('The user notification has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The user notification could not be saved. Please, try again.', true));
               }
          }
          $users = $this->UserNotification->User->find('list');
          $this->set(compact('users'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid user notification', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               if ($this->UserNotification->save($this->data)) {
                    $this->Session->setFlash(__('The user notification has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The user notification could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->UserNotification->read(null, $id);
          }
          $users = $this->UserNotification->User->find('list');
          $this->set(compact('users'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for user notification', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->UserNotification->delete($id)) {
               $this->Session->setFlash(__('User notification deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('User notification was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

}
