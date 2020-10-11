<?php
/* AccountsUser Test cases generated on: 2014-05-21 17:08:17 : 1400692097*/
App::import('Model', 'AccountsUser');

class AccountsUserTestCase extends CakeTestCase {
	var $fixtures = array('app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.currency');

	function startTest() {
		$this->AccountsUser =& ClassRegistry::init('AccountsUser');
	}

	function endTest() {
		unset($this->AccountsUser);
		ClassRegistry::flush();
	}

}
