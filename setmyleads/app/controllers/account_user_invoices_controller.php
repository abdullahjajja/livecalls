<?php
class AccountUserInvoicesController extends AppController {

	var $name = 'AccountUserInvoices';

	function index() {
		$this->AccountUserInvoice->recursive = 0;
		$this->set('accountUserInvoices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid account user invoice', true), array('action' => 'index'));
		}
		$this->set('accountUserInvoice', $this->AccountUserInvoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->AccountUserInvoice->create();
			if ($this->AccountUserInvoice->save($this->data)) {
				$this->flash(__('Accountuserinvoice saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$currencies = $this->AccountUserInvoice->Currency->find('list');
		$users = $this->AccountUserInvoice->User->find('list');
		$invoices = $this->AccountUserInvoice->Invoice->find('list');
		$this->set(compact('currencies', 'users', 'invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid account user invoice', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->AccountUserInvoice->save($this->data)) {
				$this->flash(__('The account user invoice has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AccountUserInvoice->read(null, $id);
		}
		$currencies = $this->AccountUserInvoice->Currency->find('list');
		$users = $this->AccountUserInvoice->User->find('list');
		$invoices = $this->AccountUserInvoice->Invoice->find('list');
		$this->set(compact('currencies', 'users', 'invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid account user invoice', true)), array('action' => 'index'));
		}
		if ($this->AccountUserInvoice->delete($id)) {
			$this->flash(__('Account user invoice deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Account user invoice was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
