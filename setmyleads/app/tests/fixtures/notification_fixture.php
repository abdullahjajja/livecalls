<?php
/* Notification Fixture generated on: 2014-07-02 06:15:07 : 1404281707 */
class NotificationFixture extends CakeTestFixture {
	var $name = 'Notification';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'numberrange_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => 'Notification Status 1 for new ,2 for approve ,3 for reject'),
		'assign_total' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'numberrange_id' => 1,
			'status' => 1,
			'assign_total' => 1
		),
	);
}
