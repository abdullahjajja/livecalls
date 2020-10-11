<?php

class Profit extends AppModel {

     var $name = 'Profit';
     //The Associations below have been created with all possible keys, those that are not needed can be removed

     var $belongsTo = array(
         'Operator' => array(
             'className' => 'Operator',
             'foreignKey' => 'operator_id',
             'conditions' => '',
             'fields' => '',
             'order' => ''
         )
     );
     var $hasMany = array(
         'ProfitDetail' => array(
             'className' => 'ProfitDetail',
             'foreignKey' => 'profit_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => '',
             'order' => '',
             'limit' => '',
             'offset' => '',
             'exclusive' => '',
             'finderQuery' => '',
             'counterQuery' => ''
         )
     );

}
