<?php
class WireUserInvoicesController extends AppController {

	var $name = 'WireUserInvoices';

	function index() {
		$this->WireUserInvoice->recursive = 0;
		$this->set('wireUserInvoices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid wire user invoice', true), array('action' => 'index'));
		}
		$this->set('wireUserInvoice', $this->WireUserInvoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->WireUserInvoice->create();
			if ($this->WireUserInvoice->save($this->data)) {
				$this->flash(__('Wireuserinvoice saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$users = $this->WireUserInvoice->User->find('list');
		$invoices = $this->WireUserInvoice->Invoice->find('list');
		$this->set(compact('users', 'invoices'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid wire user invoice', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->WireUserInvoice->save($this->data)) {
				$this->flash(__('The wire user invoice has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WireUserInvoice->read(null, $id);
		}
		$users = $this->WireUserInvoice->User->find('list');
		$invoices = $this->WireUserInvoice->Invoice->find('list');
		$this->set(compact('users', 'invoices'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid wire user invoice', true)), array('action' => 'index'));
		}
		if ($this->WireUserInvoice->delete($id)) {
			$this->flash(__('Wire user invoice deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Wire user invoice was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
