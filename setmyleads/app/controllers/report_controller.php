<?php
class ReportController extends AppController {

    //var $name = 'Apis';
    var $uses = array('Currency','Did','DidsUser','Numberrange','Operator','Routetype','user');
    var $helpers = array('Html');
    var $layout = 'livecalls';
    
    function beforeFilter() {
        //$this->Auth->allow( '*' );
    }


    function index() {
        $calls = array('top' => '????', 'left' => '?????', 'right' => '??????', 'bottom' => '??????');
        $this->set('calls', $calls);
    }
    
    function operator() {
        $calls = array('top' => '????', 'left' => '?????', 'right' => '??????', 'bottom' => '??????');
        $this->set('calls', $calls);
    }

    

}
?>