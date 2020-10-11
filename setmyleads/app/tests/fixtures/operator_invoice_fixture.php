<?php
/* OperatorInvoice Fixture generated on: 2014-06-16 20:46:48 : 1402951608 */
class OperatorInvoiceFixture extends CakeTestFixture {
	var $name = 'OperatorInvoice';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_status_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'date' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'operator_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'invoice_status_id' => 1,
			'date' => 1402951608,
			'operator_id' => 1
		),
	);
}
