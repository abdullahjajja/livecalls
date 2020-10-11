<?php

class getivrnameHelper extends AppHelper {

    var $helpers = array('Html');

    function getIVRName($uploadedname) {
       App::import('Model', 'Ivr');
//		echo $uploadedname;
      $ivrs = new Ivr();
     $tempivr = $ivrs->findByivr_uploaded_name($uploadedname); 
//	 $this->Article->find('first', array('order' => array('Article.created DESC')))
//     print_r($tempivr);
     return $tempivr['Ivr']['ivr_name'];
    }

}

?>