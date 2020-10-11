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
     <div class="mainheading"><div align="left">Random Numbers Logs</div> </div>
         

     <table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
      <thead class="gridtableHeader">
        <tr>

          <td width="20%" style="padding-left:10px;" align="left"><?php echo ('Range Given'); ?></td>
          <td width="5%" style="padding-left:10px;" align="left"><?php echo ('Qty'); ?></td>
          <td width="30%" style="padding-left:10px;" align="left"><?php echo ('Inserted Log'); ?></td>
          <td width="30%" style="padding-left:10px;" align="left"><?php echo ('Duplicate Log'); ?></td>
          <td width="15%" align="center"><?php echo ('Created'); ?></td>

        </tr>

      </thead>
      <tbody style="border: solid 1px #2f9300;">
        <?php
        $i = 0;
        $counter = 0;
// die(var_dump($dids));
 // 'id' => string '13' (length=2)
 //          'start_did' => string '923004004786' (length=12)
 //          'end_did' => string '923004004800' (length=12)
 //          'qty' => string '3' (length=1)
 //          'inserted_log' => string ' 923004004796' (length=13)
 //          'duplicate_log' => string 'duplicate enteries are  923004004787 923004004786' (length=49)
 //          'created' => string '2018-02-20 17:08:49' (length=19)

        foreach ($dids as $log):
          
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
              <td width="20%"  align="left" class="gridcellborder" >&nbsp;
                <?php echo $log['randomdid_log']['start_did']." - ".$log['randomdid_log']['end_did']; ?>
              </td>
              <td width="5%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $log['randomdid_log']['qty']; ?></td>
              <td width="30%" align="left" style="padding-left:10px;" class="gridcellborder"><?php echo $log['randomdid_log']['inserted_log']; ?></td>
               <td width="30%" align="left" style="padding-left:10px;" class="gridcellborder"><?php echo $log['randomdid_log']['duplicate_log']; ?></td>
              <td width="15%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
                <?php echo $log['randomdid_log']['created']; ?>
              </td>


            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>
                                   
          
      

     
  
   