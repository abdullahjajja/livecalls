<?php

class InvoiceDetail extends AppModel {

     var $name = 'InvoiceDetail';
     var $belongsTo = array(
         'Invoice' => array(
             'className' => 'Invoice',
             'foreignKey' => 'invoice_id',
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
