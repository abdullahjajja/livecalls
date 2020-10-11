<?php
class ProfitDetail extends AppModel {
	var $name = 'ProfitDetail';
	var $displayField = 'operator_name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Profit' => array(
			'className' => 'Profit',
			'foreignKey' => 'profit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
