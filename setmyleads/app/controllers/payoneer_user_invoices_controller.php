<?php
class PayoneerUserInvoicesController extends AppController {

	var $name = 'PayoneerUserInvoices';

	function index() {
		$this->PayoneerUserInvoice->recursive = 0;
		$this->set('payoneerUserInvoices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid payoneer user invoice', true), array('action' => 'index'));
		}
		$this->set('payoneerUserInvoice', $this->PayoneerUserInvoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PayoneerUserInvoice->create();
			if ($this->PayoneerUserInvoice->save($this->data)) {
				$this->flash(__('Payoneeruserinvoice saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$users = $this->PayoneerUserInvoice->User->find('list');
		$invoices = $this->PayoneerUserInvoice->Invoice->find('list');
		$this->set(compact('users', 'invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid payoneer user invoice', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PayoneerUserInvoice->save($this->data)) {
				$this->flash(__('The payoneer user invoice has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PayoneerUserInvoice->read(null, $id);
		}
		$users = $this->PayoneerUserInvoice->User->find('list');
		$invoices = $this->PayoneerUserInvoice->Invoice->find('list');
		$this->set(compact('users', 'invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid payoneer user invoice', true)), array('action' => 'index'));
		}
		if ($this->PayoneerUserInvoice->delete($id)) {
			$this->flash(__('Payoneer user invoice deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Payoneer user invoice was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
