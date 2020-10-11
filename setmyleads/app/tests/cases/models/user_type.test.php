<?php
/* UserType Test cases generated on: 2014-06-30 06:29:00 : 1404109740*/
App::import('Model', 'UserType');

class UserTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.user_type', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role');

	function startTest() {
		$this->UserType =& ClassRegistry::init('UserType');
	}

	function endTest() {
		unset($this->UserType);
		ClassRegistry::flush();
	}

}
