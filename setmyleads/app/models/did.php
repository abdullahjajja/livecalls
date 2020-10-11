<?php

class Did extends AppModel {

     var $name = 'Did';
     //The Associations below have been created with all possible keys, those that are not needed can be removed

     var $belongsTo = array(
         'Numberrange' => array(
             'className' => 'Numberrange',
             'foreignKey' => 'numberrange_id',
             'conditions' => '',
             'fields' => 'id,name,dailyrate,monthlyrate,sellingrate',
             'order' => ''
         )
     );
     var $hasMany = array(
         'DidsUser' => array(
             'className' => 'DidsUser',
             'foreignKey' => 'did_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => 'id,did_id,superresseler_id,resseller_id,subresseller_id,isdaily,modified',
             'order' => '',
             'limit' => '',
             'offset' => '',
             'exclusive' => '',
             'finderQuery' => '',
             'counterQuery' => ''
         ),
         'Didrate' => array(
             'className' => 'Didrate',
             'foreignKey' => 'did_id',
             'dependent' => false,
             'conditions' => '',
             'fields' => 'id,did_id,adminbuyrate,superresrate,ressellerrate,subresrate,currency_id,admin_currency,supres_currency, reseller_currency, subres_currency',
             'order' => '',
             'limit' => '',
             'offset' => '',
             'exclusive' => '',
             'finderQuery' => '',
             'counterQuery' => ''
         )
     );

}
