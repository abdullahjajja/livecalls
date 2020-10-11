<?php

class ProfitsController extends AppController {

     var $name = 'Profits';
     var $layout = 'livecalls';

     function beforeFilter() {

          ini_set('memory_limit', '-1');
     }

     function index() {
          $this->Profit->recursive = 0;
          $this->set('profits', $this->paginate());
     }

     function view($id = null) {
          $this->layout = false;
          if (!$id) {
               $this->Session->setFlash(__('Invalid profit', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('profit', $this->Profit->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->Profit->create();
               if ($this->Profit->save($this->data)) {
                    $this->Session->setFlash(__('The profit has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The profit could not be saved. Please, try again.', true));
               }
          }
          $operators = $this->Profit->Operator->find('list');
          $this->set(compact('operators'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid profit', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               if ($this->Profit->save($this->data)) {
                    $this->Session->setFlash(__('The profit has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The profit could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->Profit->read(null, $id);
          }
          $operators = $this->Profit->Operator->find('list');
          $this->set(compact('operators'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for profit', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->Profit->delete($id)) {
               $this->Session->setFlash(__('Profit deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Profit was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

}
