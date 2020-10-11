<?php
class DidsUser extends AppModel {
	var $name = 'DidsUser';
	var $validate = array(
		'did_id' => array(
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
		'Did' => array(
			'className' => 'Did',
			'foreignKey' => 'did_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Superresseler' => array(
			'className' => 'User',
			'foreignKey' => 'superresseler_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Resseller' => array(
			'className' => 'User',
			'foreignKey' => 'resseller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subresseller' => array(
			'className' => 'User',
			'foreignKey' => 'subresseller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
