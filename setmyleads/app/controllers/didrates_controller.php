<?php
class DidratesController extends AppController {

	var $name = 'Didrates';

	function index() {
		$this->Didrate->recursive = 0;
		$this->set('didrates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid didrate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('didrate', $this->Didrate->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Didrate->create();
			if ($this->Didrate->save($this->data)) {
				$this->Session->setFlash(__('The didrate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The didrate could not be saved. Please, try again.', true));
			}
		}
		$dids = $this->Didrate->Did->find('list',array('fields'=>array('id','did')));		
		$currencies = $this->Didrate->Currency->find('list',array('fields'=>array('id','currency_name')));
		$this->set(compact('dids', 'currencies'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid didrate', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Didrate->save($this->data)) {
				$this->Session->setFlash(__('The didrate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The didrate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Didrate->read(null, $id);
		}
		$dids = $this->Didrate->Did->find('list',array('fields'=>array('id','did')));		
		$currencies = $this->Didrate->Currency->find('list',array('fields'=>array('id','currency_name')));
		$this->set(compact('dids', 'currencies'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for didrate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Didrate->delete($id)) {
			$this->Session->setFlash(__('Didrate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Didrate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
