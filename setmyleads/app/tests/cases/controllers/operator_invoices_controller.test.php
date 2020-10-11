<?php
/* OperatorInvoices Test cases generated on: 2014-06-16 20:47:33 : 1402951653*/
App::import('Controller', 'OperatorInvoices');

class TestOperatorInvoicesController extends OperatorInvoicesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class OperatorInvoicesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.operator_invoice', 'app.invoice_status', 'app.operator', 'app.numberrange', 'app.routetype', 'app.currency', 'app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.did', 'app.dids_user', 'app.didrate', 'app.operator_invoice_detail');

	function startTest() {
		$this->OperatorInvoices =& new TestOperatorInvoicesController();
		$this->OperatorInvoices->constructClasses();
	}

	function endTest() {
		unset($this->OperatorInvoices);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
