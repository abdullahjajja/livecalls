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

	function operator_ips($id)
	{
		if (!$id) {
			$this->Session->setFlash(__('Invalid operator', true));
			$this->redirect(array('action' => 'index'));
		}
		// $this->set('data', $this->Operator->read(null, $id));
		$query="SELECT * FROM operator_ips
			     JOIN operators ON operators.`id` = operator_ips.`operator_id`
			     WHERE operators.`id` = {$id}";

		$results = $this->Operator->query($query, $cachequeries = false);
		$this->set('operators', $results);
		$this->set('oper', $this->Operator->read(null, $id));
	}

	function insert_operator_ip(){

		$ip 		= $this->params['form']['ip'];
		$oper_id 	= $this->params['form']['operator_id_field'];

		if(isset($ip) && isset($oper_id)){

			if(!empty($ip) && !empty($oper_id)){
				$checkquery  =  "SELECT * from operator_ips where ip = '{$ip}'";
				// if($res = mysql_query($checkquery) or die(mysql_error())){
				// 	$res_count = mysql_num_rows($res);
				// 	if ($res_count > 0) {
				// 		$this->Session->setFlash(__('IP address already Assigned', true));
				// 		$this->redirect(array('action' => 'operator_ips', $oper_id));
				// 	}
				// }

				$query = "INSERT INTO operator_ips (ip,operator_id,created_at,updated_at) VALUE('{$ip}',{$oper_id},NOW(), NOW())";
                var_dump($query);
                if(mysql_query($query) or die(mysql_error())){
                	$this->Session->setFlash(__('IP added', true));
					$this->redirect(array('action' => 'operator_ips', $oper_id));
                }
			}
		}
		
	}

	function delete_op_ip(){

		$oper_ip_id = $this->params['url']['oper_ip_id'];
		$oper_id 	= $this->params['url']['oper_id'];

		$query = "DELETE FROM  operator_ips WHERE id = {$oper_ip_id}";

                if(mysql_query($query) or die(mysql_error())){
                	$this->Session->setFlash(__('Ip deleted !', true));
					$this->redirect(array('action' => 'operator_ips', $oper_id));
                }
                else{
                	$this->Session->setFlash(__('invalid operations', true));
                	$this->redirect(array('action' => 'operator_ips', $oper_id));
                }
	}

}
