<?php

class IpsController extends AppController {

     var $name = 'Ips';
     var $layout = 'livecalls';

     function index() {
          $this->Ip->recursive = 0;
          $this->set('ips', $this->paginate());
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid ip', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('ip', $this->Ip->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->Ip->create();
               //$a = $this->data['Ips']['owner_name'];
               //$b = $this->data['Ips']['ip_address'];
               // $this->Ip->query("INSERT INTO ips (owner_name,ip_address) VALUE ('$a','$b')");

               if ($this->Ip->save($this->data)) {
                    // print_r($this->data);
                    //die();
                    $this->Session->setFlash(__('The ip has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The ip could not be saved. Please, try again.', true));
               }
          }
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid ip', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               if ($this->Ip->save($this->data)) {
                    $this->Session->setFlash(__('The ip has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The ip could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->Ip->read(null, $id);
          }
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for ip', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->Ip->delete($id)) {
               $this->Session->setFlash(__('Ip deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Ip was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

}
