<?php
/* Notification Test cases generated on: 2014-07-02 06:15:07 : 1404281707*/
App::import('Model', 'Notification');

class NotificationTestCase extends CakeTestCase {
	var $fixtures = array('app.notification', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role', 'app.user_type', 'app.numberrange', 'app.operator', 'app.routetype', 'app.did', 'app.dids_user', 'app.didrate');

	function startTest() {
		$this->Notification =& ClassRegistry::init('Notification');
	}

	function endTest() {
		unset($this->Notification);
		ClassRegistry::flush();
	}

}
