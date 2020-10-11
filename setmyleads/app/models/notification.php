<?php
class Notification extends AppModel {
	var $name = 'Notification';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Numberrange' => array(
			'className' => 'Numberrange',
			'foreignKey' => 'numberrange_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
