<?php
class LivecallsController extends AppController {

    //var $name = 'Apis';
    var $uses = array('Currency','Did','DidsUser','Numberrange','Operator','Routetype','user');
    var $helpers = array('Html');
    var $layout = 'livecalls';
    
    function beforeFilter() {
        //$this->Auth->allow( '*' );
    }


    function index() {
        $calls = array('top' => 'Верх', 'left' => 'Левое', 'right' => 'Правое', 'bottom' => 'Нижнее');
        $this->set('calls', $calls);
    }

    

}
?>