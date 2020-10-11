<?php

class OperatorInvoiceDetail extends AppModel {

     var $name = 'OperatorInvoiceDetail';
     var $belongsTo = array(
         'OperatorInvoice' => array(
             'className' => 'OperatorInvoice',
             'foreignKey' => 'operator_invoice_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
         'Currency' => array(
             'className' => 'Currency',
             'foreignKey' => 'currency_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
     );

}

?>
