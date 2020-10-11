<?php

class Currency extends AppModel {

     var $displayField = 'currency_name';
     var $name = 'Currency';
     var $validate = array(
         'currency_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
     );
     var $hasMany = array(
         'AccountsUser' => array(
             'className' => 'AccountsUser',
             'foreignKey' => 'currency_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );

}
