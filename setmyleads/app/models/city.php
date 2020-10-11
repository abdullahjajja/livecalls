<?php

class City extends AppModel {

     var $name = 'City';
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
     );
     //The Associations below have been created with all possible keys, those that are not needed can be removed

     var $belongsTo = array(
         'State' => array(
             'className' => 'State',
             'foreignKey' => 'state_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );
     var $hasMany = array(
         'User' => array(
             'className' => 'User',
             'foreignKey' => 'city_id',
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
             'foreignKey' => 'city_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );

}
