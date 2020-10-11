<?php
/* Invoices Test cases generated on: 2014-05-29 10:36:27 : 1401359787*/
App::import('Controller', 'Invoices');

class TestInvoicesController extends InvoicesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class InvoicesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.invoice', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role', 'app.numberrange', 'app.operator', 'app.routetype', 'app.did', 'app.dids_user', 'app.didrate', 'app.invoice_status');

	function startTest() {
		$this->Invoices =& new TestInvoicesController();
		$this->Invoices->constructClasses();
	}

	function endTest() {
		unset($this->Invoices);
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
