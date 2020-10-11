<?php

class AccountsUser extends AppModel {

     var $name = 'AccountsUser';
     var $displayField = 'beneficiary_name';
     var $validate = array(
         'status' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             ),
         ),
         'beneficiary_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'country_id' => array(
             'numeric' => array(
                 'rule' => array('numeric'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'state_id' => array(
             'numeric' => array(
                 'rule' => array('numeric'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'city_id' => array(
             'numeric' => array(
                 'rule' => array('numeric'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'bank_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
                 //'message' => 'Your custom message here',
                 'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'iban' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
                 //'message' => 'Your custom message here',
                 'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'currency_id' => array(
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

     var $belongsTo = array(
         'Country' => array(
             'className' => 'Country',
             'foreignKey' => 'country_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
         'State' => array(
             'className' => 'State',
             'foreignKey' => 'state_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
         'City' => array(
             'className' => 'City',
             'foreignKey' => 'city_id',
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
         'User' => array(
             'className' => 'User',
             'foreignKey' => 'user_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );

}
