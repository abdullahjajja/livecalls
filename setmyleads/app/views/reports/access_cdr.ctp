<?php $userid = $session->read('Auth.User.role_id'); ?>
<?php $actuall_userid = $session->read('Auth.User.id'); ?>

<?php 

$duplicate_numberranges = '';

App::import('Helper', 'getnetwork');
$getnetwork = new getnetworkHelper();  

// $c = $getnetwork->get_test_numbers('402');
// var_dump($c);
// exit();
// while($row = mysql_fetch_assoc($results))
//     {
//         var_dump($row);
//     }
// $d= $getnetwork->get_numberrabges_trim('24103273552');
// $e= $getnetwork->get_numberrabges_trim('123465479987984654654654654');
// var_dump($d, $e);
// exit();
?>

     <div  id="maincontent" >


     <fieldset>
     <legend><?php __('CDR Analyzer'); ?></legend>
          <div style="margin-left: 15px">
               <form action="" method="post" accept-charset="utf-8" id="cdr_access_from">
                    <label for="caller_id_num">CLI :</label>
                    <input type="text" name="caller_id_num" value="" id="caller_id_num" placeholder="">
                    <input type="submit" name="submit" value="Submit" style="background: green; color: white;">
                   
               </form>
                <img src="../img/loading2.gif" id="loading_gif" alt="" style="display: none;">
          </div>
      </fieldset>

     </div>


     <div id="maincontent">
     <div class="mainheading"><div></div>
          <div align="left">Access CDR</div>
          <div align="right" style="margin-top: -15px" ></div>
     </div>
     <div class="maincenterBg">
          <table class="table" width="100%" border="1" cellspacing="0" cellpadding="10" class="gridtable" bordercolor="white">
               <thead>
                    <tr class="">
                         <th>Caller id number</th>
                         <th>Country</th>
                         <th>Network</th>
                         <th>Range name</th>
                         <!-- <th>Rate</th> -->
                         <th>Test number</th>
                    </tr>
               </thead>
               <tbody>
                    <?php if(empty($results)){ ?>
                    <tr class="">
                         <td colspan="7"></td>
                    </tr>
                    <?php } else {?>
               <?php
                    $k = 0;
                    while($row = mysql_fetch_assoc($results)){
                         $networkname = $getnetwork->get_call_id_network($row['caller_id_name']);
                         $resulted_country_oper   = explode('_',$networkname);

                         $country1                = $resulted_country_oper[0];
                         $network1                = $resulted_country_oper[1];
                         $prefix_length           = $resulted_country_oper[2];

                         $class                   = ' class="grid2dark"';
                         if ($k++ % 2 == 0) {
                              $class              = ' class="grid1light"';
                         }

                         if($row['numberrange_name'] == 'N/A'){
                              $destinations = explode(',', $row['destination_number']);
                              foreach ($destinations as $dest) {
                                   $trim_result = $getnetwork->get_numberrabges_trim($dest);

                                   $trim_result_numberrangesname        =  explode(',',$trim_result['numberrangesname']);
                                   $trim_result_numberrangetestnumbers  =  explode(',',$trim_result['numberrangetestnumbers']);
                                   // $trim_result = trim($trim_result);
                                   // var_dump($trim_result_numberrangesname);
                                   // var_dump($trim_result_numberrangetestnumbers);
                                 
                                  
                                  
                                   foreach ($trim_result_numberrangesname as $ind => $the_value){
                                      if( strpos( $duplicate_numberranges, $the_value ) == false ) {
                                        if($trim_result_numberrangetestnumbers[$ind] != " "){
                                    

                                   ?>

                                    <tr<?php echo $class; ?>>
                                       <td><?php echo substr_replace($row['caller_id_name'],'x',$prefix_length); ?></td>
                                       <td><?php echo $country1; ?></td>
                                       <td><?php echo $network1; ?></td>
                                       <td><?php echo  $the_value; ?></td>
                                       
                                      
                                       <td><?php echo $trim_result_numberrangetestnumbers[$ind]; ?></td>
                                    </tr>
                                  
                                    
                              <?php
                                $duplicate_numberranges = $duplicate_numberranges .','. $the_value;
                                      
                                      }
                                    }
                                  } 
                                // }
                              }
                                                 
                            } else { 
                          ?>
                    <tr<?php echo $class; ?>>
                         <td><?php echo substr_replace($row['caller_id_name'],'x',$prefix_length); ?></td>
                         <td><?php echo $country1; ?></td>
                         <td><?php echo $network1; ?></td>
                         <td><?php echo $row['numberrange_name']; ?></td>
                         <!-- <td><?php echo (float)$row['sellingrate']; ?></td> -->
                         <td><?php echo $row['Testnumber']; ?></td>
                    </tr>
                    <?php } } }?>


               </tbody>
          </table>
     </div>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
     $(function(){
          $( "#cdr_access_from" ).validate({
            rules: {
              caller_id_num: {
                required: true,
                digits: true,
                minlength: 4
              }
            },
            submitHandler: function(form) {
                $("#loading_gif").fadeIn();
                return true;
            }
          });
     })
</script>

<style type="text/css" media="screen">
 
 #caller_id_num-error{
          color:yellow;
 }

 #loading_gif{
          left: 50%;
          margin-left: -32px;
          margin-top: -32px;
          position: absolute;
          top: 50%;
}

</style>
