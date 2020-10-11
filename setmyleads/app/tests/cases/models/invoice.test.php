<?php
/* Invoice Test cases generated on: 2014-05-29 10:35:34 : 1401359734*/
App::import('Model', 'Invoice');

class InvoiceTestCase extends CakeTestCase {
	var $fixtures = array('app.invoice', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role', 'app.numberrange', 'app.operator', 'app.routetype', 'app.did', 'app.dids_user', 'app.didrate', 'app.invoice_status');

	function startTest() {
		$this->Invoice =& ClassRegistry::init('Invoice');
	}

	function endTest() {
		unset($this->Invoice);
		ClassRegistry::flush();
	}

}
