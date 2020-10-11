<?php
$globalvar = 0;
?>

   <link href="../DataTables/css/demo_table.css" rel="stylesheet" />
   <link href="../DataTables/css/CustomTable.css" rel="stylesheet" />
   <link href="../DataTables/css/demo_table_jui.css" rel="stylesheet" />
   <script type="text/javascript" src="../DataTables/js/jquery.dataTables.js"></script>

<script type="text/javascript">
     
      $(document).ready(function() {
      	
      	
      	
      	$('#table_user').DataTable({
      		 "aaSorting": [],
      		 "iDisplayLength": 50
      	});
      	});
     
</script>

<div  id="maincontent">
     <div class="mainheading"><div align="left">Rate Card Logs</div> </div>
         
     
        

                        
                                                  <table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
                                                           <thead class="gridtableHeader">
                                                            <tr>
                                                                
                                                                                <td width="15%" style="padding-left:10px;" align="left"><?php echo ('Customer'); ?></td>
                                                                                <td width="30%" style="padding-left:10px;" align="left"><?php echo ('Log Text'); ?></td>
                                                                                <td width="40%" align="center"><?php echo ('Assigned Dids'); ?></td>
                                                                                <td width="15%" align="center"><?php echo ('Created'); ?></td>
                                                                                
                                                                           </tr>

                                                           </thead>
 <tbody style="border: solid 1px #2f9300;">
                                                            <?php
                                                            $i = 0;
                                                            $counter = 0;

                                                      foreach ($dids as $log):

                                                                 //die(print_r($did));
                                                                 $class = '';
                                                                 if ($i++ % 2 == 0) {
                                                                           $class = ' class="grid2dark"';
                                                                      } else {
                                                                           $class = ' class="grid1light"';
                                                                      }
                                                                
                                                                 if ($i == 1) {
                                                                      ?>
                                                                     

                                                                                <?php } ?>
                                                                               
                                                                                <tr <?php echo $class; ?>>
                                                                                     <td width="15%"  align="left" class="gridcellborder" >&nbsp;
                                                                                          <?php echo $log['users']['login']; ?>
                                                                                     </td>
                                                                                     <td width="30%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $log['ratecard_log']['log_text']; ?></td>
                                                                                     <td width="40%" align="left" style="padding-left:10px;" class="gridcellborder"><?php echo $log['ratecard_log']['assigned_dids']; ?></td>
                                                                                     <td width="15%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                          <?php echo $log['ratecard_log']['created']; ?>
                                                                                     </td>
                                                                                     

                                                                 </tr>

                                                            <?php endforeach; ?>
 </tbody>
                                        </table>
                                   
          
      

     
  
   