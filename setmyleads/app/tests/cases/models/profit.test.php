<?php
/* Profit Test cases generated on: 2014-06-17 20:12:06 : 1403035926*/
App::import('Model', 'Profit');

class ProfitTestCase extends CakeTestCase {
	var $fixtures = array('app.profit', 'app.operator', 'app.numberrange', 'app.routetype', 'app.currency', 'app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.did', 'app.dids_user', 'app.didrate', 'app.profit_detail');

	function startTest() {
		$this->Profit =& ClassRegistry::init('Profit');
	}

	function endTest() {
		unset($this->Profit);
		ClassRegistry::flush();
	}

}
