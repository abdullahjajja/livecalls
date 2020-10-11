<?php
class ReportsController extends AppController {

    //var $name = 'Apis';
    var $uses = array('Currency','Did','DidsUser','Numberrange','Operator','Routetype','user');
    var $helpers = array('Html');
    var $layout = 'livecalls';
    
    function beforeFilter() {
        //$this->Auth->allow( '*' );
          $this->Auth->autoRedirect = false;		
//		$this->Auth->allow(array('testcalls'));
    ini_set('memory_limit', '-1');
    }

    function index() {
        
        
           if (!empty($this->data)) {  
               
                if(isset($this->params['form']['btnSearch']))
                {
                    
                    echo $this->data['Reports']['startdate'];
                    
                }
                }
        
        $calls = array('top' => 'Верх', 'left' => 'Левое', 'right' => 'Правое', 'bottom' => 'Нижнее');
        $this->set('calls', $calls);
    }
    
    function cdr( )
    {
        //var $name = 'Reports';

        //$startdate=$this->data['Reports']['startdate'];
        //$enddate=$this->data['Reports']['enddate'];
        //$data = $this->cdrs->query("select * from cdrs");
        //where start_stamp between".$startdate. "and". $enddate. ";");
       
      //$data = $this->Reports->find('all', array('conditions' => array('cdrs.start_stamp' => '2012-07-24 13:31:24')));
       //$data=$this->set('Reports', $this->cdrs->find('all'));
        
       //$this->paginate['cdrs'] = array('order'=>array('cdrs.start_stamp DESC'),'limit'=>5,'recursive'=>0);      
        //$data=$this->set('Reports', $this->paginate('cdr')); 
        
        
        

        //return $data;
    }
    
    function voicecall()
    {
        
    }
    
    function tnlogs()
    {
        
    }

    function access_cdr(){

      if(isset($this->params['form']['caller_id_num']) && !empty($this->params['form']['caller_id_num'])){
        $caller_id_num = $this->params['form']['caller_id_num'];

         $query          = "SELECT  GROUP_CONCAT(DISTINCT unmatch_did_cdrs.`destination_number`) AS 'destination_number',unmatch_did_cdrs.`caller_id_name`,COALESCE(NULLIF(unmatch_did_cdrs.`numberrange_name`,''),'N/A') AS 'numberrange_name', COALESCE(numberranges.`sellingrate`,'N/A') AS 'sellingrate', numberranges.`id`,COALESCE(dids.`did`, 'N/A') AS 'Testnumber' 
                        FROM unmatch_did_cdrs
                        LEFT JOIN numberranges ON numberranges.`name` = unmatch_did_cdrs.`numberrange_name` AND LENGTH(numberranges.`name`) > 0
                        LEFT JOIN dids ON dids.`numberrange_id` = numberranges.`id` AND dids.`IsTestNumber` = 1
                        WHERE unmatch_did_cdrs.`caller_id_name` LIKE '{$caller_id_num}%' AND start_stamp  >= DATE_SUB(NOW(),INTERVAL 1 DAY)
                        AND unmatch_did_cdrs.`billsec`= 0
                        GROUP BY unmatch_did_cdrs.`numberrange_name`";

//         $query = "SELECT GROUP_CONCAT(DISTINCT cdrs.`destination_number`) AS 'destination_number',cdrs.`caller_id_name`,COALESCE(NULLIF(cdrs.`numberrange_name`,''),'N/A') AS 'numberrange_name',
// COALESCE(numberranges.`sellingrate`,'N/A') AS 'sellingrate'
// ,COALESCE(dids.`did`, 'N/A') AS 'Testnumber'
// FROM cdrs
// LEFT JOIN numberranges ON numberranges.`name` = cdrs.`numberrange_name` AND LENGTH(numberranges.`name`) > 0
// LEFT JOIN dids ON dids.`numberrange_id` = numberranges.`id` AND dids.`IsTestNumber` = 1
// WHERE cdrs.`caller_id_name` LIKE '3464001285%' OR cdrs.`caller_id_name` LIKE '79540574136%' OR cdrs.`caller_id_name` LIKE '91799720621%'
// AND cdrs.`billsec`= 0
// GROUP BY cdrs.`numberrange_name`";
                        // print_r($query);exit();
            if($results = mysql_query($query) or die(mysql_error())){
                   $this->set('results', $results);
            }

      }
      else{
         $this->set('results', array());
      }
      $results= array();

      

      // $results = $this->__get_call_id_network("3464001285");
         // $this->set('results', $results);
    }


    function download($filename){
      $this->autoRender = false; 

  //$filename="";
  //$path = "http://184.154.5.83/livecalls/app/webroot/"; 

  //$latest_ctime = 0;
  //$latest_filename = '';    

  //$d = dir($path);
  //while (false !== ($entry = $d->read())) {
    //$filepath = "{$path}/{$entry}";
    // could do also other checks than just checking whether the entry is a file
    //if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
      //  $latest_ctime = filectime($filepath);
        //$filename= $entry;
      //}
    //}

   //echo "this".$filename;
  //exit; 
  //header("Cache-Control: public"); 
  //header("Content-Type: application/octet-stream");
  //header("Content-Disposition: attachment; filename="http://184.154.5.83/livecalls/app/webroot/export.csv");
  //$this->redirect('http://184.154.5.83/livecalls/app/webroot/export.csv');
      header("Pragma: public");
      header("Expires: 0"); 
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: text/x-csv");
      header("Content-Disposition: attachment;filename=\".$filename.\""); 




    }
	

}
?>