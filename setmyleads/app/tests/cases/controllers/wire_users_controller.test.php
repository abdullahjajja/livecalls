<?php
/* WireUsers Test cases generated on: 2014-05-23 15:00:15 : 1400857215*/
App::import('Controller', 'WireUsers');

class TestWireUsersController extends WireUsersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class WireUsersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.wire_user', 'app.country', 'app.state', 'app.city', 'app.user', 'app.role', 'app.accounts_user', 'app.currency');

	function startTest() {
		$this->WireUsers =& new TestWireUsersController();
		$this->WireUsers->constructClasses();
	}

	function endTest() {
		unset($this->WireUsers);
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
