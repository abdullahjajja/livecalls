<?php

class getcurrencyHelper extends AppHelper {

    var $helpers = array('Html');

    function getcurrencyNameById($id) {
       App::import('Model', 'Currency');
       
      $Currency = new Currency();
     $tempcry = $Currency->findById($id,array('fields'=>'id','currency_name')); 
     //print_r($tempcry);
     return $tempcry['Currency']['currency_name'];
    }

}

?>
