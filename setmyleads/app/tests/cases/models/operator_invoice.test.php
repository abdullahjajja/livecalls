<?php
/* OperatorInvoice Test cases generated on: 2014-06-16 20:46:52 : 1402951612*/
App::import('Model', 'OperatorInvoice');

class OperatorInvoiceTestCase extends CakeTestCase {
	var $fixtures = array('app.operator_invoice', 'app.invoice_status', 'app.operator', 'app.numberrange', 'app.routetype', 'app.currency', 'app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.did', 'app.dids_user', 'app.didrate', 'app.operator_invoice_detail');

	function startTest() {
		$this->OperatorInvoice =& ClassRegistry::init('OperatorInvoice');
	}

	function endTest() {
		unset($this->OperatorInvoice);
		ClassRegistry::flush();
	}

}
