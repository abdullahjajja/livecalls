<?php
$globalvar = 0;
?>

   <link href="../DataTables/css/demo_table.css" rel="stylesheet" />
   <link href="../DataTables/css/CustomTable.css" rel="stylesheet" />
   <link href="../DataTables/css/demo_table_jui.css" rel="stylesheet" />
   <script type="text/javascript" src="../DataTables/js/jquery.dataTables.js"></script>
   <script src="../js/spin.js" type="text/javascript"></script>

<script type="text/javascript">
     
     var opts = {
  lines: 13, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: '50%', // Top position relative to parent
  left: '50%' // Left position relative to parent
};
     function activateUser(id)
      {
      	var target = document.getElementById('spinner');
        var spinner = new Spinner(opts).spin(target);
      	$.ajax({
               url: "../api/activateUser",
               type: "POST",
               data: "id="+id,
               cache: false,
               success: function(msg) {
                   	$('#row_'+id).remove();
                   	$("#errormessage").text("User activated successfully");
                   	spinner.stop();
               },
           error: function(){
                  spinner.stop();
          }
          });
      
         // alert(editId);
      }
  
      $(document).ready(function() {
      	$('#table_user').DataTable({
      		 "aaSorting": [],
      		 "iDisplayLength": 50
      	});
      	});
     
</script>

<div  id="maincontent">
<div id="spinner"></div>
     <div class="mainheading"><div align="left">De-activated Users List</div> </div>
         
     
        

                        
                                                  <table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
                                                           <thead class="gridtableHeader">
                                                            <tr>
                                                                
                                                                                <td width="10%" style="padding-left:10px;" align="left">Login</td>
                                                                                <td width="20%" style="padding-left:10px;" align="left">Password</td>
                                                                                <td width="10%" style="padding-left:10px;" align="left">First Name</td>
                                                                                <td width="10%" style="padding-left:10px;" align="left">Last Name</td>
                                                                                <td width="20%" style="padding-left:10px;" align="left">Email</td>
                                                                                <td width="10%" style="padding-left:10px;" align="left">Role</td>
                                                                                <td width="10%" align="center">Actions</td>
                                                                                
                                                                           </tr>

                                                           </thead>
 <tbody style="border: solid 1px #2f9300;">
                                                            <?php
                                                            $i = 0;
                                                            $counter = 0;

                                                      foreach ($users as $user):

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
                                                                               
                                                                                <tr id="row_<?php echo $user['users']['id'];?>" <?php echo $class; ?>>
                                                                                     <td width="10%"  align="left" style="padding-left:10px;" class="gridcellborder" >&nbsp;
                                                                                          <?php echo $user['users']['login']; ?>
                                                                                     </td>
                                                                                     <td width="20%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $user['users']['password']; ?></td>
                                                                                     <td width="10%" align="left" style="padding-left:10px;" class="gridcellborder"><?php echo $user['users']['first_name']; ?></td>
                                                                                     <td width="15%" align="left" style="padding-left:10px;" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                          <?php echo $user['users']['last_name']; ?>
                                                                                     </td>
                                                                                     <td width="20%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $user['users']['email']; ?></td>
                                                                                     <td width="10%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $user['roles']['name']; ?></td>
                                                                                     <td width="10%" align="center" class="gridcellborder"><span style="cursor: pointer;" onclick="activateUser(<?php echo $user['users']['id'];?>)"> Activate</span></td>
                                                                                     

                                                                 </tr>

                                                            <?php endforeach; ?>
 </tbody>
                                        </table>
                                   
          
      

     
  
   