<?php
/* PayoneerUser Test cases generated on: 2014-05-23 14:38:21 : 1400855901*/
App::import('Model', 'PayoneerUser');

class PayoneerUserTestCase extends CakeTestCase {
	var $fixtures = array('app.payoneer_user', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role');

	function startTest() {
		$this->PayoneerUser =& ClassRegistry::init('PayoneerUser');
	}

	function endTest() {
		unset($this->PayoneerUser);
		ClassRegistry::flush();
	}

}
