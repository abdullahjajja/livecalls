<?php
/* Invoice Fixture generated on: 2014-05-29 10:28:33 : 1401359313 */
class InvoiceFixture extends CakeTestFixture {
	var $name = 'Invoice';
	var $table = 'invoice';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'numberrange_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'currency_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'invoice_status_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'minutes' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'rate' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'invoice_total' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'numberrange_id' => 1,
			'currency_id' => 1,
			'invoice_status_id' => 1,
			'date' => '2014-05-29 10:28:33',
			'minutes' => 1,
			'rate' => 1,
			'invoice_total' => 1
		),
	);
}
