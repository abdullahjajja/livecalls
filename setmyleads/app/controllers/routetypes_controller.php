<?php
class RoutetypesController extends AppController {

	var $name = 'Routetypes';

	function index() {
		$this->Routetype->recursive = 0;
		$this->set('routetypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid routetype', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('routetype', $this->Routetype->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Routetype->create();
			if ($this->Routetype->save($this->data)) {
				$this->Session->setFlash(__('The routetype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The routetype could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid routetype', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Routetype->save($this->data)) {
				$this->Session->setFlash(__('The routetype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The routetype could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Routetype->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for routetype', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Routetype->delete($id)) {
			$this->Session->setFlash(__('Routetype deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Routetype was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
