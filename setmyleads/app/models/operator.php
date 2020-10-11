<?php
class Operator extends AppModel {
	var $name = 'Operator';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Numberrange' => array(
			'className' => 'Numberrange',
			'foreignKey' => 'operator_id',
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
        var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'please enter oprator name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),		
	);

}
