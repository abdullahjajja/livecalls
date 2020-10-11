<?php
/* PayoneerUser Fixture generated on: 2014-05-23 14:38:21 : 1400855901 */
class PayoneerUserFixture extends CakeTestFixture {
	var $name = 'PayoneerUser';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'card_number' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 16),
		'date_expiry' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'card_number' => 1,
			'date_expiry' => '2014-05-23',
			'created' => '2014-05-23 14:38:21',
			'modified' => '2014-05-23 14:38:21',
			'user_id' => 1
		),
	);
}
