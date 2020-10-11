<?php

class OperatorInvoicesController extends AppController {

     var $name = 'OperatorInvoices';
     var $layout = 'livecalls';

     function beforeFilter() {

          ini_set('memory_limit', '-1');
     }

     function index($id) {
//    die('hel');
//          $this->OperatorInvoice->recursive = 0;
//          $this->set('operatorInvoices', $this->paginate());
//          if (!$id) {
//               $this->redirect(array('controller' => 'user', ' action' => 'index'));
//          }
//          if ($this->Auth->User('role_id') != 1) {
//               if ($this->Auth->User('id') != $id) {
//                    $this->Session->setFlash(__('Invalid accounts user', true));
//                    //       $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
//               }
//          }
//   $users = $this->OperatorInvoice->User->find('all');
// $numberranges = $this->Invoice->Numberrange->find('list');
// $currencies = $this->Invoice->Currency->find('list');
          $invoiceStatuses = $this->OperatorInvoice->InvoiceStatus->find('list');
          $ida = $id;
          $this->set(compact('users', 'numberranges', 'currencies', 'invoiceStatuses', 'ida'));
     }

     function view($id = null) {
          $this->layout = false;
          if (!$id) {
               $this->Session->setFlash(__('Invalid operator invoice', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('operatorInvoice', $this->OperatorInvoice->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               $this->OperatorInvoice->create();
               if ($this->OperatorInvoice->save($this->data)) {
                    $this->Session->setFlash(__('The operator invoice has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The operator invoice could not be saved. Please, try again.', true));
               }
          }
          $invoiceStatuses = $this->OperatorInvoice->InvoiceStatus->find('list');
          $operators = $this->OperatorInvoice->Operator->find('list');
          $this->set(compact('invoiceStatuses', 'operators'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid operator invoice', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               if ($this->OperatorInvoice->save($this->data)) {
                    $this->Session->setFlash(__('The operator invoice has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The operator invoice could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->OperatorInvoice->read(null, $id);
          }
          $invoiceStatuses = $this->OperatorInvoice->InvoiceStatus->find('list');
          $operators = $this->OperatorInvoice->Operator->find('list');
          $this->set(compact('invoiceStatuses', 'operators'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for operator invoice', true));
               $this->redirect(array('action' => 'index'));
          }
          if ($this->OperatorInvoice->delete($id)) {
               $this->Session->setFlash(__('Operator invoice deleted', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->Session->setFlash(__('Operator invoice was not deleted', true));
          $this->redirect(array('action' => 'index'));
     }

}
