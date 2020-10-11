<?php

class getuserHelper extends AppHelper {

    var $helpers = array('Html');

    
    function getUserNameById($id) {
           App::import('Model', 'User');
       
      $User = new User();
     $tempusr = $User->findById($id,array('fields'=>'login')); 
       return $tempusr['user']['login'];
    }

    function getAllSubs($id) {
      //echo $id;
     App::import('Model', 'User');
     $User = new User();
     $data = $User->find('count', array(
     'conditions' => array('user.created_by'=>$id), //array of conditions
      ));
     //print_r($data);
      return $data;
    }
    
    function DelAllsub($id) {
   
    App::import('Model', 'User');
     $User = new User();
     $query="";
    $query="update users set users.created_by='0' where users.created_by=".$id. ";";
     $result = $User->query($query, $cachequeries = false);
     if($result>0){
     return true;
     }else{
        
         return false;
     }
     
     function updateroot($id,$role) {
   
    App::import('Model', 'DidsUser');
     $DidUser = new DidsUser();
     $query="";
     $query="update dids_users set dids_users.superresseler_id=".$role. " where dids_users.did_id=".$id.";";
    //$query="update users set users.created_by='0' where users.created_by=".$id. ";";
     $result = $DidUser->query($query, $cachequeries = false);
     if($result>0){
     return true;
     }else{
        
         return false;
     }
     }
     
     function reassignment($id,$role) {
         echo "called";
         exit;
     App::import('Model', 'DidsUser');
     $DidUser = new DidsUser();
     $query="";
   
     if($role==1){
         
         $query= "update dids_users set dids_users.resseller_id=0 and dids_users.subresseller_id=0 where dids_users.did_id=".$id.";";
     }else  if($role==2){
         $query= "update dids_users set dids_users.subresseller_id=0 where dids_users.did_id=".$id.";";
     }            
     $result = $DidUser->query($query, $cachequeries = false);
     if($result>0){
     return true;
     }else{
        
         return false;
     }
     
     }
     
   
    
     
     
}

 function updatetest($id) {
   //echo $id;
   
   
    App::import('Model', 'DidsUser');
     $DidUser = new DidsUser();
     $query="";
     $query="update dids_users set dids_users.superresseler_id=20 where dids_users.did_id=".$id.";";
    //$query="update users set users.created_by='0' where users.created_by=".$id. ";";
     $result = $DidUser->query($query, $cachequeries = false);
     if($result>0){
     return true;
     }else{
        
         return false;
     }
     }


}
?>
