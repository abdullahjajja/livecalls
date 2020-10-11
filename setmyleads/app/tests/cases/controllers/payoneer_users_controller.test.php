<?php
/* PayoneerUsers Test cases generated on: 2014-05-23 14:39:36 : 1400855976*/
App::import('Controller', 'PayoneerUsers');

class TestPayoneerUsersController extends PayoneerUsersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PayoneerUsersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.payoneer_user', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role');

	function startTest() {
		$this->PayoneerUsers =& new TestPayoneerUsersController();
		$this->PayoneerUsers->constructClasses();
	}

	function endTest() {
		unset($this->PayoneerUsers);
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
