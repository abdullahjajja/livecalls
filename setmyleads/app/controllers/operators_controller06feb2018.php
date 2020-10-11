<?php
class OperatorsController extends AppController {

	var $name = 'Operators';
        var $layout = 'livecalls';
	function index() {
		$this->Operator->recursive = 0;
                $this->paginate = array('order' => array('Operator.name' => 'asc'),'limit' => 100);
                  
		$this->set('operators', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid operator', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('operator', $this->Operator->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			
			$alphabet=$this->data['Operator']['alphabet'];
			$valid=1;
			if($alphabet!='')
			{
			$query="SELECT * FROM operators where `alphabet`='$alphabet'";
			$results = $this->Operator->query($query, $cachequeries = false);
			if(count($results[0])>=1)
			{
				$valid=0;
			}  }
			if($valid==1)
			{
			$this->Operator->create();
			if ($this->Operator->save($this->data)) {
				$this->Session->setFlash(__('The operator has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The operator could not be saved. Please, try again.', true));
			}
		  }
		  else
		  {
		  	$this->Session->setFlash(__("Operator Alphabet '$alphabet' already exist. Please try another.", true));
		  }
			
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid operator', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$alphabet=$this->data['Operator']['alphabet'];
			$id=$this->data['Operator']['id'];
			$valid=1;
			if($alphabet!='')
			{
			$query="SELECT * FROM operators where `alphabet`='$alphabet' and id!=$id";
			$results = $this->Operator->query($query, $cachequeries = false);
			if(count($results[0])>=1)
			{
				$valid=0;
			}  }
			if($valid==1)
			{
			
			if ($this->Operator->save($this->data)) {
				$this->Session->setFlash(__('The operator has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The operator could not be saved. Please, try again.', true));
			}
		    }
		 else
		  {
		  	$this->Session->setFlash(__("Operator Alphabet '$alphabet' already exist. Please try another.", true));
		  }
		}
		if (empty($this->data)) {
			$this->data = $this->Operator->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for operator', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Operator->delete($id)) {
			$this->Session->setFlash(__('Operator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Operator was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
