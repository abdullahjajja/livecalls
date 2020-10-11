<?php
/* ProfitDetail Test cases generated on: 2014-06-17 20:14:26 : 1403036066*/
App::import('Model', 'ProfitDetail');

class ProfitDetailTestCase extends CakeTestCase {
	var $fixtures = array('app.profit_detail', 'app.currency', 'app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.profit', 'app.operator', 'app.numberrange', 'app.routetype', 'app.did', 'app.dids_user', 'app.didrate');

	function startTest() {
		$this->ProfitDetail =& ClassRegistry::init('ProfitDetail');
	}

	function endTest() {
		unset($this->ProfitDetail);
		ClassRegistry::flush();
	}

}
