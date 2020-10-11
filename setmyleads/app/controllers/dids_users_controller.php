<?php
class DidsUsersController extends AppController {

	var $name = 'DidsUsers';

	function index() {
		$this->DidsUser->recursive = 0;
		$this->set('didsUsers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dids user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('didsUser', $this->DidsUser->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->DidsUser->create();
			if ($this->DidsUser->save($this->data)) {
				$this->Session->setFlash(__('The dids user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dids user could not be saved. Please, try again.', true));
			}
		}
		$dids = $this->DidsUser->Did->find('list');
		$superresselers = $this->DidsUser->Superresseler->find('list');
		$ressellers = $this->DidsUser->Resseller->find('list');
		$subressellers = $this->DidsUser->Subresseller->find('list');
		$this->set(compact('dids', 'superresselers', 'ressellers', 'subressellers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dids user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->DidsUser->save($this->data)) {
				$this->Session->setFlash(__('The dids user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dids user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->DidsUser->read(null, $id);
		}
		$dids = $this->DidsUser->Did->find('list');
		$superresselers = $this->DidsUser->Superresseler->find('list');
		$ressellers = $this->DidsUser->Resseller->find('list');
		$subressellers = $this->DidsUser->Subresseller->find('list');
		$this->set(compact('dids', 'superresselers', 'ressellers', 'subressellers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dids user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->DidsUser->delete($id)) {
			$this->Session->setFlash(__('Dids user deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Dids user was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
