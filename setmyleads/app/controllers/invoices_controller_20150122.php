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
          $this->Auth->allow('download');
          $this->Auth->allow('downloadview');
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
          //  $users = $this->Invoice->User->find('all');
          $user = $this->Invoice->User->findById($id);

          // $numberranges = $this->Invoice->Numberrange->find('list');
          // $currencies = $this->Invoice->Currency->find('list');
          $invoiceStatuses = $this->Invoice->InvoiceStatus->find('list');
          $ida = $id;
          $this->set('user', $user);
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
          //  $user = $this->Invoice->User->findById($id);
          // $user = $this->Invoice->User->find('first', array('conditions' => array('User.id' => $id)));
          $this->Invoice->recursive = 0;
          $this->paginate = array(
              "conditions" => array('invoice_status_id !=' => 2),
              "order" => array('date' => 'DESC', 'User.login' => 'ASC'),
              'limit' => 100
          );
          //   $this->set('user', $user);
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


          $bank_detail_usd = array();
          $bank_detail_euro = array();
          $bank_detail_gbp = array();
          $wire_detail = array();
          $payoneer_detail = array();
          if ($ac['Invoice']['invoice_status_id'] == 2) {




               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=1";
               $objA = ClassRegistry::init('AccountUserInvoice')->query($query);

               if (!empty($objA)) {
                    $bank_detail_usd = array();
                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA as $b) {

                         $bank_detail_usd['accounts_users']['accounts_users']['beneficiary_name'] = $objA[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_usd['accounts_users']['accounts_users']['account_number'] = $objA[0]['account_user_invoices']['account_number'];
                         $bank_detail_usd['accounts_users']['accounts_users']['bank_name'] = $objA[0]['account_user_invoices']['bank_name'];
                         $bank_detail_usd['accounts_users']['accounts_users']['bank_address'] = $objA[0]['account_user_invoices']['bank_address'];
                         $bank_detail_usd['accounts_users']['accounts_users']['swift_code'] = $objA[0]['account_user_invoices']['swift_code'];
                    }
               }


               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=2";
               $objA1 = ClassRegistry::init('AccountUserInvoice')->query($query);

               if (!empty($objA1)) {
                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA1 as $b) {

                         $bank_detail_euro['accounts_users']['accounts_users']['beneficiary_name'] = $objA1[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_euro['accounts_users']['accounts_users']['account_number'] = $objA1[0]['account_user_invoices']['account_number'];
                         $bank_detail_euro['accounts_users']['accounts_users']['bank_name'] = $objA1[0]['account_user_invoices']['bank_name'];
                         $bank_detail_euro['accounts_users']['accounts_users']['bank_address'] = $objA1[0]['account_user_invoices']['bank_address'];
                         $bank_detail_euro['accounts_users']['accounts_users']['swift_code'] = $objA1[0]['account_user_invoices']['swift_code'];
                    }
               }
               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=4";
               $objA2 = ClassRegistry::init('AccountUserInvoice')->query($query);
               //  die(print_r($objA2));
               if (!empty($objA2)) {

                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA2 as $b) {

                         $bank_detail_gbp['accounts_users']['accounts_users']['beneficiary_name'] = $objA2[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['account_number'] = $objA2[0]['account_user_invoices']['account_number'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['bank_name'] = $objA2[0]['account_user_invoices']['bank_name'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['bank_address'] = $objA2[0]['account_user_invoices']['bank_address'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['swift_code'] = $objA2[0]['account_user_invoices']['swift_code'];
                    }
               }

               $query = "SELECT * FROM wire_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'];
               $objA3 = ClassRegistry::init('WireUserInvoice')->query($query);
               if (!empty($objA3)) {

                    $ac['User']['preference'] = 'Western Union  Transfer';
                    foreach ($objA3 as $b) {

                         $wire_detail['wire_users']['wire_users']['name'] = $objA3[0]['wire_user_invoices']['name'];
                         $wire_detail['wire_users']['wire_users']['mobile_number'] = $objA3[0]['wire_user_invoices']['mobile_number'];
                         $wire_detail['wire_users']['wire_users']['city_name'] = $objA3[0]['wire_user_invoices']['city_name'];
                         $wire_detail['wire_users']['wire_users']['state_name'] = $objA3[0]['wire_user_invoices']['state_name'];
                         $wire_detail['wire_users']['wire_users']['country_name'] = $objA3[0]['wire_user_invoices']['country_name'];
                    }
               }
               $query = "SELECT * FROM payoneer_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'];
               $objA4 = ClassRegistry::init('PayoneerUserInvoice')->query($query);
               if (!empty($objA4)) {

                    $ac['User']['preference'] = 'Payoneer Transfer';
                    foreach ($objA4 as $b) {

                         $payoneer_detail['payoneer_users']['payoneer_users']['name'] = $objA4[0]['payoneer_user_invoices']['name'];
                         $payoneer_detail['payoneer_users']['payoneer_users']['card_number'] = $objA4[0]['payoneer_user_invoices']['card_number'];
                         $payoneer_detail['payoneer_users']['payoneer_users']['date_expiry'] = $objA4[0]['payoneer_user_invoices']['date_expiry'];
                    }
               }
          } else {
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
          }
          $this->set('bank_detail_usd', $bank_detail_usd);
          $this->set('bank_detail_euro', $bank_detail_euro);
          $this->set('bank_detail_gbp', $bank_detail_gbp);

          $this->set('wire_detail', $wire_detail);
          $this->set('payoneer_detail', $payoneer_detail);
          $this->set('invoiceid', $id);
          $this->set('invoice', $ac);
     }

     function downloadview($id = null) {
          $ac = $this->Invoice->findById($id);

          $this->layout = false;
          if (!$id) {
               $this->Session->setFlash(__('Invalid invoice', true));
               $this->redirect(array('action' => 'index'));
          }

          $bank_detail_usd = array();
          $bank_detail_euro = array();
          $bank_detail_gbp = array();
          $wire_detail = array();
          $payoneer_detail = array();
          if ($ac['Invoice']['invoice_status_id'] == 2) {




               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=1";
               $objA = ClassRegistry::init('AccountUserInvoice')->query($query);

               if (!empty($objA)) {
                    $bank_detail_usd = array();
                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA as $b) {

                         $bank_detail_usd['accounts_users']['accounts_users']['beneficiary_name'] = $objA[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_usd['accounts_users']['accounts_users']['account_number'] = $objA[0]['account_user_invoices']['account_number'];
                         $bank_detail_usd['accounts_users']['accounts_users']['bank_name'] = $objA[0]['account_user_invoices']['bank_name'];
                         $bank_detail_usd['accounts_users']['accounts_users']['bank_address'] = $objA[0]['account_user_invoices']['bank_address'];
                         $bank_detail_usd['accounts_users']['accounts_users']['swift_code'] = $objA[0]['account_user_invoices']['swift_code'];
                    }
               }


               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=2";
               $objA1 = ClassRegistry::init('AccountUserInvoice')->query($query);

               if (!empty($objA1)) {
                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA1 as $b) {

                         $bank_detail_euro['accounts_users']['accounts_users']['beneficiary_name'] = $objA1[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_euro['accounts_users']['accounts_users']['account_number'] = $objA1[0]['account_user_invoices']['account_number'];
                         $bank_detail_euro['accounts_users']['accounts_users']['bank_name'] = $objA1[0]['account_user_invoices']['bank_name'];
                         $bank_detail_euro['accounts_users']['accounts_users']['bank_address'] = $objA1[0]['account_user_invoices']['bank_address'];
                         $bank_detail_euro['accounts_users']['accounts_users']['swift_code'] = $objA1[0]['account_user_invoices']['swift_code'];
                    }
               }
               $query = "SELECT * FROM account_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'] . "  AND currency_id=4";
               $objA2 = ClassRegistry::init('AccountUserInvoice')->query($query);
               //  die(print_r($objA2));
               if (!empty($objA2)) {

                    $ac['User']['preference'] = 'Bank transfer';
                    foreach ($objA2 as $b) {

                         $bank_detail_gbp['accounts_users']['accounts_users']['beneficiary_name'] = $objA2[0]['account_user_invoices']['beneficiary_name'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['account_number'] = $objA2[0]['account_user_invoices']['account_number'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['bank_name'] = $objA2[0]['account_user_invoices']['bank_name'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['bank_address'] = $objA2[0]['account_user_invoices']['bank_address'];
                         $bank_detail_gbp['accounts_users']['accounts_users']['swift_code'] = $objA2[0]['account_user_invoices']['swift_code'];
                    }
               }

               $query = "SELECT * FROM wire_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'];
               $objA3 = ClassRegistry::init('WireUserInvoice')->query($query);
               if (!empty($objA3)) {

                    $ac['User']['preference'] = 'Western Union  Transfer';
                    foreach ($objA3 as $b) {

                         $wire_detail['wire_users']['wire_users']['name'] = $objA3[0]['wire_user_invoices']['name'];
                         $wire_detail['wire_users']['wire_users']['mobile_number'] = $objA3[0]['wire_user_invoices']['mobile_number'];
                         $wire_detail['wire_users']['wire_users']['city_name'] = $objA3[0]['wire_user_invoices']['city_name'];
                         $wire_detail['wire_users']['wire_users']['state_name'] = $objA3[0]['wire_user_invoices']['state_name'];
                         $wire_detail['wire_users']['wire_users']['country_name'] = $objA3[0]['wire_user_invoices']['country_name'];
                    }
               }
               $query = "SELECT * FROM payoneer_user_invoices WHERE invoice_id=" . $ac['Invoice']['id'];
               $objA4 = ClassRegistry::init('PayoneerUserInvoice')->query($query);
               if (!empty($objA4)) {

                    $ac['User']['preference'] = 'Payoneer Transfer';
                    foreach ($objA4 as $b) {

                         $payoneer_detail['payoneer_users']['payoneer_users']['name'] = $objA4[0]['payoneer_user_invoices']['name'];
                         $payoneer_detail['payoneer_users']['payoneer_users']['card_number'] = $objA4[0]['payoneer_user_invoices']['card_number'];
                         $payoneer_detail['payoneer_users']['payoneer_users']['date_expiry'] = $objA4[0]['payoneer_user_invoices']['date_expiry'];
                    }
               }
          } else {
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
          }

          $query = "SELECT * FROM invoice_details
JOIN invoices ON invoices.id=invoice_details.invoice_id
JOIN currencies ON currencies.id=invoice_details.currency_id
JOIN invoice_statuses ON invoice_statuses.`id`=invoices.invoice_status_id
WHERE invoice_id=" . $id . " GROUP BY invoice_details.`numberrange_name` ASC";
          //  $calls = $this->InvoiceDetail->query($query, $cachequeries = false);
          $ca = ClassRegistry::init('InvoiceDetail')->query($query);

          $this->set('calls', $ca);

          $this->set('bank_detail_usd', $bank_detail_usd);
          $this->set('bank_detail_euro', $bank_detail_euro);
          $this->set('bank_detail_gbp', $bank_detail_gbp);

          $this->set('wire_detail', $wire_detail);
          $this->set('payoneer_detail', $payoneer_detail);
          $this->set('invoiceid', $id);
          $this->set('invoice', $ac);
     }

     function download($id = null) {
          // Include Component
          App::import('Component', 'Pdf');
          // Make instance
          $Pdf = new PdfComponent();
          // Invoice name (output name)
          $Pdf->filename = 'invoice' . $id; // Without .pdf
          // You can use download or browser here
          $Pdf->output = 'download';
          $Pdf->init();
          // Render the view
          $Pdf->process(Router::url('/', true) . 'invoices/downloadview/' . $id);
          $this->render(false);
     }

     function ChangeInvoiceStatus() {
          $this->autoRender = false;
          $id = $_GET['id'];
          $c_id = $_GET['change'];
          $this->Invoice->updateAll(
                  array('Invoice.invoice_status_id' => $c_id), array('Invoice.id' => $id)
          );

          $ac = $this->Invoice->findById($id);
          if ($ac['User']['preference'] == 'Bank transfer') {
               $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=1";
               $bank_detail_usd = ClassRegistry::init('AccountsUser')->query($query);

               if (!empty($bank_detail_usd)) {

                    foreach ($bank_detail_usd as $b) {
                         $objA = ClassRegistry::init('AccountUserInvoice')->create();
                         $objA['AccountUserInvoice']['beneficiary_name'] = $b['accounts_users']['beneficiary_name'];
                         $objA['AccountUserInvoice']['account_number'] = $b['accounts_users']['account_number'];
                         $objA['AccountUserInvoice']['bank_name'] = $b['accounts_users']['bank_name'];
                         $objA['AccountUserInvoice']['bank_address'] = $b['accounts_users']['bank_address'];
                         $objA['AccountUserInvoice']['swift_code'] = $b['accounts_users']['swift_code'];
                         $objA['AccountUserInvoice']['currency_id'] = 1;
                         $objA['AccountUserInvoice']['invoice_id'] = $ac['Invoice']['id'];
                         $objA['AccountUserInvoice']['user_id'] = $ac['User']['id'];
                         ClassRegistry::init('AccountUserInvoice')->save($objA);
                    }
               }
               $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=4";
               $bank_detail_gbp = ClassRegistry::init('AccountsUser')->query($query);
               if (!empty($bank_detail_gbp)) {

                    foreach ($bank_detail_gbp as $b) {
                         $objA = ClassRegistry::init('AccountUserInvoice')->create();
                         $objA['AccountUserInvoice']['beneficiary_name'] = $b['accounts_users']['beneficiary_name'];
                         $objA['AccountUserInvoice']['account_number'] = $b['accounts_users']['account_number'];
                         $objA['AccountUserInvoice']['bank_name'] = $b['accounts_users']['bank_name'];
                         $objA['AccountUserInvoice']['bank_name'] = $b['bank_address']['bank_address'];
                         $objA['AccountUserInvoice']['swift_code'] = $b['accounts_users']['swift_code'];
                         $objA['AccountUserInvoice']['currency_id'] = 4;
                         $objA['AccountUserInvoice']['invoice_id'] = $ac['Invoice']['id'];
                         $objA['AccountUserInvoice']['user_id'] = $ac['User']['id'];
                         ClassRegistry::init('AccountUserInvoice')->save($objA);
                    }
               }

               $query = "SELECT * FROM accounts_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND accounts_users.`status`=2 AND currency_id=2";
               $bank_detail_euro = ClassRegistry::init('AccountsUser')->query($query);
               if (!empty($bank_detail_euro)) {

                    foreach ($bank_detail_euro as $b) {
                         $objA = ClassRegistry::init('AccountUserInvoice')->create();
                         $objA['AccountUserInvoice']['beneficiary_name'] = $b['accounts_users']['beneficiary_name'];
                         $objA['AccountUserInvoice']['account_number'] = $b['accounts_users']['account_number'];
                         $objA['AccountUserInvoice']['bank_name'] = $b['accounts_users']['bank_name'];
                         $objA['AccountUserInvoice']['bank_address'] = $b['accounts_users']['bank_address'];
                         $objA['AccountUserInvoice']['swift_code'] = $b['accounts_users']['swift_code'];
                         $objA['AccountUserInvoice']['currency_id'] = 2;
                         $objA['AccountUserInvoice']['invoice_id'] = $ac['Invoice']['id'];
                         $objA['AccountUserInvoice']['user_id'] = $ac['User']['id'];
                         ClassRegistry::init('AccountUserInvoice')->save($objA);
                    }
               }
          }

          if ($ac['User']['preference'] == 'Payoneer Transfer') {

               $query = "SELECT * FROM payoneer_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND payoneer_users.`status`=2";
               $payoneer_detail = ClassRegistry::init('PayoneerUser')->query($query);
               if (!empty($payoneer_detail)) {
                    foreach ($payoneer_detail as $b) {
                         $objP = ClassRegistry::init('PayoneerUserInvoice')->create();
                         $objP['PayoneerUserInvoice']['name'] = $b['payoneer_users']['name'];
                         $objP['PayoneerUserInvoice']['card_number'] = $b['payoneer_users']['card_number'];
                         $objP['PayoneerUserInvoice']['date_expiry'] = $b['payoneer_users']['date_expiry'];
                         $objP['PayoneerUserInvoice']['invoice_id'] = $ac['Invoice']['id'];
                         $objP['PayoneerUserInvoice']['user_id'] = $ac['User']['id'];
                         ClassRegistry::init('PayoneerUserInvoice')->save($objP);
                    }
               }
          }
          if ($ac['User']['preference'] == 'Western Union  Transfer') {

               $query = "SELECT * FROM wire_users WHERE user_id=" . $ac['Invoice']['user_id'] . " AND wire_users.`status`=2";
               $wire_detail = ClassRegistry::init('WireUser')->query($query);
               if (!empty($wire_detail)) {
                    foreach ($wire_detail as $b) {
                         $objP = ClassRegistry::init('WireUserInvoice')->create();
                         $objP['WireUserInvoice']['name'] = $b['wire_users']['name'];
                         $objP['WireUserInvoice']['mobile_number'] = $b['wire_users']['mobile_number'];
                         $objP['WireUserInvoice']['city_name'] = $b['wire_users']['city_name'];
                         $objP['WireUserInvoice']['state_name'] = $b['wire_users']['state_name'];
                         $objP['WireUserInvoice']['country_name'] = $ac['wire_users']['country_name'];
                         $objP['WireUserInvoice']['invoice_id'] = $ac['Invoice']['id'];
                         $objP['WireUserInvoice']['user_id'] = $ac['User']['id'];
                         ClassRegistry::init('WireUserInvoice')->save($objP);
                    }
               }
          }


          echo '1';
     }

}

