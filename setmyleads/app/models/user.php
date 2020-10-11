<?php

class user extends AppModel {

     //  public $query9 = "($r[0],$r2['currenciesid'],$r2['duration'],$r2['superresrate'],$r2['totalCost']),";

     var $name = 'user';
     var $validate = array(
         'login' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
             array(
                 'rule' => 'isUnique',
                 'message' => 'This login has already been taken.'
             )
         ),
         'password' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'first_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'last_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'email' => array(
             'email' => array(
                 'rule' => array('email'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'phone' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
             array(
                 'rule' => array('Numeric'),
                 'message' => 'not a number',
             ),
         ),
     );
     //The Associations below have been created with all possible keys, those that are not needed can be removed
     var $hasMany = array(
         'AccountsUser' => array(
             'className' => 'AccountsUser',
             'foreignKey' => 'user_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );
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
         'Role' => array(
             'className' => 'Role',
             'foreignKey' => 'role_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
         'UserType' => array(
             'className' => 'UserType',
             'foreignKey' => 'user_type_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
     );

     function hashPasswords($data) {
          if (isset($data['User']['password'])) {
               $data['User']['password'] = $data['User']['password'];
               return $data;
          }
          return $data;
     }

}
