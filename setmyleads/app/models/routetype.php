<?php
class Routetype extends AppModel {
	var $name = 'Routetype';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Numberrange' => array(
			'className' => 'Numberrange',
			'foreignKey' => 'routetype_id',
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
