<?php
/* WireUser Test cases generated on: 2014-05-23 14:59:09 : 1400857149*/
App::import('Model', 'WireUser');

class WireUserTestCase extends CakeTestCase {
	var $fixtures = array('app.wire_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.accounts_user', 'app.currency');

	function startTest() {
		$this->WireUser =& ClassRegistry::init('WireUser');
	}

	function endTest() {
		unset($this->WireUser);
		ClassRegistry::flush();
	}

}
