<?php
/* Notifications Test cases generated on: 2014-07-02 06:15:59 : 1404281759*/
App::import('Controller', 'Notifications');

class TestNotificationsController extends NotificationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class NotificationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.notification', 'app.user', 'app.country', 'app.state', 'app.city', 'app.accounts_user', 'app.currency', 'app.role', 'app.user_type', 'app.numberrange', 'app.operator', 'app.routetype', 'app.did', 'app.dids_user', 'app.didrate');

	function startTest() {
		$this->Notifications =& new TestNotificationsController();
		$this->Notifications->constructClasses();
	}

	function endTest() {
		unset($this->Notifications);
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
