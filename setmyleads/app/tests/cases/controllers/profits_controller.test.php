<?php
/* Profits Test cases generated on: 2014-06-17 20:12:47 : 1403035967*/
App::import('Controller', 'Profits');

class TestProfitsController extends ProfitsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProfitsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.profit', 'app.operator', 'app.numberrange', 'app.routetype', 'app.currency', 'app.accounts_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.did', 'app.dids_user', 'app.didrate', 'app.profit_detail');

	function startTest() {
		$this->Profits =& new TestProfitsController();
		$this->Profits->constructClasses();
	}

	function endTest() {
		unset($this->Profits);
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
