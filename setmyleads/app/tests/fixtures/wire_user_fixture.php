<?php
/* WireUser Fixture generated on: 2014-05-23 14:59:09 : 1400857149 */
class WireUserFixture extends CakeTestFixture {
	var $name = 'WireUser';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mobile_number' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 15),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'mobile_number' => 1,
			'country_id' => 1,
			'city_id' => 1,
			'user_id' => 1,
			'state_id' => 1
		),
	);
}
