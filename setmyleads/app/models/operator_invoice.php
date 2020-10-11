<?php
class OperatorInvoice extends AppModel {
	var $name = 'OperatorInvoice';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'InvoiceStatus' => array(
			'className' => 'InvoiceStatus',
			'foreignKey' => 'invoice_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Operator' => array(
			'className' => 'Operator',
			'foreignKey' => 'operator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'OperatorInvoiceDetail' => array(
			'className' => 'OperatorInvoiceDetail',
			'foreignKey' => 'operator_invoice_id',
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
