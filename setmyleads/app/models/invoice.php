<?php

class Invoice extends AppModel {

     var $name = 'Invoice';
     var $displayField = 'date';
     var $validate = array(
         'user_id' => array(
             'numeric' => array(
                 'rule' => array('numeric'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
     );
     //The Associations below have been created with all possible keys, those that are not needed can be removed
     var $hasMany = array(
         'InvoiceDetail' => array(
             'className' => 'InvoiceDetail',
             'foreignKey' => 'invoice_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );
     var $belongsTo = array(
         'User' => array(
             'className' => 'User',
             'foreignKey' => 'user_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
         'InvoiceStatus' => array(
             'className' => 'InvoiceStatus',
             'foreignKey' => 'invoice_status_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );

}
