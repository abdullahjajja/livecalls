<?php

class InvoicesController extends AppController {

     var $name = 'Invoices';
     var $helpers = array('Ajax');
     var $components = array('Session');
     var $layout = 'livecalls';

     // var $uses = array('User');
     //var $uses = array('InvoiceDetail');

     function beforeFilter() {

          ini_set('memory_limit', '-1');
     }

     function index($id) {

          //  $this->Invoice->recursive = 0;
          //  $this->set('invoices', $this->paginate());
          if (!$id) {
               $this->redirect(array('controller' => 'user', ' action' => 'index'));
          }
          if ($this->Auth->User('role_id') != 1) {
               if ($this->Auth->User('id') != $id) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          $users = $this->Invoice->User->find('all');

          // $numberranges = $this->Invoice->Numberrange->find('list');
          // $currencies = $this->Invoice->Currency->find('list');
          $invoiceStatuses = $this->Invoice->InvoiceStatus->find('list');
          $ida = $id;
          $this->set(compact('users', 'numberranges', 'currencies', 'invoiceStatuses', 'ida'));
     }

     function index2() {


          $ac = $this->Invoice->findById($id);
          if ($this->Auth->User('role_id') != 1) {

               if ($this->Auth->User('id') != $ac['Invoice']['user_id']) {
                    //  $this->Session->setFlash(__('Invalid accounts user', true));
                    $this->layout = false;
                    die('Access Denied');
                    //  $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          $users = $this->Invoice->User->find('all');
          $this->Invoice->recursive = 0;
          $this->paginate = array(
              "conditions" => array('invoice_status_id !=' => 2),
              "order" => array('date' => 'DESC'),
              'limit' => 100
          );
          $this->set('invoices', $this->paginate());

          // $this->set(compact('users', 'numberranges', 'currencies', 'invoiceStatuses', 'ida'));
     }

     function view($id = null) {
          $ac = $this->Invoice->findById($id);
          if ($this->Auth->User('role_id') != 1) {

               if ($this->Auth->User('id') != $ac['Invoice']['user_id']) {
                    $this->Session->setFlash(__('Invalid accounts user', true));
                    die('Access Denied');
                    $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
               }
          }
          $this->layout = false;
          if (!$id) {
               $this->Session->setFlash(__('Invalid invoice', true));
               $this->redirect(array('action' => 'index'));
          }

          $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=1";
          $bank_detail_usd = ClassRegistry::init('AccountsUser')->query($query);
          $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=2";
          $bank_detail_euro = ClassRegistry::init('AccountsUser')->query($query);

          $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=4";
          $bank_detail_gbp = ClassRegistry::init('AccountsUser')->query($query);
          $query = "SELECT * FROM wire_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND wire_users.`status`=2";
          $wire_detail = ClassRegistry::init('WireUser')->query($query);
          $query = "SELECT * FROM payoneer_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND payoneer_users.`status`=2";
          $payoneer_detail = ClassRegistry::init('PayoneerUser')->query($query);

          $this->set('bank_detail_usd', $bank_detail_usd);
          $this->set('bank_detail_euro', $bank_detail_euro);
          $this->set('bank_detail_gbp', $bank_detail_gbp);

          $this->set('wire_detail', $wire_detail);
          $this->set('payoneer_detail', $payoneer_detail);
          $this->set('invoice', $this->Invoice->read(null, $id));
     }

}

