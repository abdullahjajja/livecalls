<?php

class State extends AppModel {

     var $name = 'State';
     var $validate = array(
         'name' => array(
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
     );
     //The Associations below have been created with all possible keys, those that are not needed can be removed

     var $belongsTo = array(
         'Country' => array(
             'className' => 'Country',
             'foreignKey' => 'country_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );
     var $hasMany = array(
         'City' => array(
             'className' => 'City',
             'foreignKey' => 'state_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => '',
             'limit' => '',
             'offset' => '',
             'exclusive' => '',
             'finderQuery' => '',
             'counterQuery' => ''
         ),
         'User' => array(
             'className' => 'User',
             'foreignKey' => 'state_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => '',
             'limit' => '',
             'offset' => '',
             'exclusive' => '',
             'finderQuery' => '',
             'counterQuery' => ''
         ),
         'AccountsUser' => array(
             'className' => 'AccountsUser',
             'foreignKey' => 'state_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );

}
