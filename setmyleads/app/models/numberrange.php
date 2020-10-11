<?php
class Numberrange extends AppModel {
	var $name = 'Numberrange';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
        
        var $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            'message' => 'Please provide name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'This range name has already been taken.'
            )
        ),
    );
        
	var $belongsTo = array(
		'Operator' => array(
			'className' => 'Operator',
			'foreignKey' => 'operator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Routetype' => array(
			'className' => 'Routetype',
			'foreignKey' => 'routetype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
            'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Did' => array(
			'className' => 'Did',
			'foreignKey' => 'numberrange_id',
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
