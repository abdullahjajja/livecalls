<?php

class WireUser extends AppModel {

     var $name = 'WireUser';
     var $displayField = 'name';
     var $validate = array(
         'id' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
             //'message' => 'Your custom message here',
             //'allowEmpty' => false,
             //'required' => false,
             //'last' => false, // Stop validation after this rule
             //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),
         'status' => array(
             'notempty' => array(
                 'rule' => array('notempty')
             )
         )
         ,
         'user_id' => array(
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
     //The Associations below have been created with all possible keys, those that are not needed can be removed

     var $belongsTo = array(
         'Country' => array(
             'className' => 'Country',
             'foreignKey' => 'country_id',
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
         ),
         'State' => array(
             'className' => 'State',
             'foreignKey' => 'state_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ), 'City' => array(
             'className' => 'City',
             'foreignKey' => 'city_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         ),
     );

}
