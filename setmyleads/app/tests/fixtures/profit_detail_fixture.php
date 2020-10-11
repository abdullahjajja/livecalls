<?php
/* ProfitDetail Fixture generated on: 2014-06-17 20:14:25 : 1403036065 */
class ProfitDetailFixture extends CakeTestFixture {
	var $name = 'ProfitDetail';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'currency_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'profit_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'minutes' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'sellingrate' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'selling_total' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'buyingrate' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'buying_total' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'profit' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'operator_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'numberrange_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'currency_id' => 1,
			'profit_id' => 1,
			'minutes' => 1,
			'sellingrate' => 1,
			'selling_total' => 1,
			'buyingrate' => 1,
			'buying_total' => 1,
			'profit' => 1,
			'operator_name' => 'Lorem ipsum dolor sit amet',
			'numberrange_name' => 'Lorem ipsum dolor sit amet'
		),
	);
}
