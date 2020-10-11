   
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
     
     var editId=0;
     function deleteterm(id)
      {
      	var target = document.getElementById('spinner');
        var spinner = new Spinner(opts).spin(target);
      	$.ajax({
               url: "../api/deletePaymentTerm",
               type: "POST",
               data: "id="+id,
               cache: false,
               success: function(msg) {
                   	$('#row_'+id).remove();
                   	$("#errormessage").text("Record deleted successfully");
                   	spinner.stop();
               },
           error: function(){
                  spinner.stop();
          }
          });
      
         // alert(editId);
      }  	
      function editterm(id)
      {
      	editId=id;
      var title =	$("#title_"+id).text();
      $("#title").val(title);
      var type = $("#type_"+id).text();
      switch(type)
      {
	  	case 'Daily':
	  	$("#type").val(1);
	  	break;
	  	case 'Weekly':
	  	$("#type").val(2);
	  	break;
	  	case 'Monthly':
	  	$("#type").val(3);
	  	break;
	  }   }
	    	
      $(document).ready(function() {
     	$('#table_user').DataTable({
      		 "aaSorting": [],
      		 "iDisplayLength": 25
      	});
      	
     $("#save").click(function() {
     	
         var type= $("#type").val();
         var title= $("#title").val();
          if(title!='')
          {
          	var target = document.getElementById('spinner');
            var spinner = new Spinner(opts).spin(target);
		  		$.ajax({
               url: "../api/savePaymentTerm",
               type: "POST",
               data:{"id":editId ,"type":type,"title":title},
               cache: false,
               success: function(msg) {
               	
					$("#errormessage").text(msg);
				    location.reload();
					editId=0;
					$("#title").val("");
					$("#type").val(1);
               spinner.stop();
               },
           error: function(){
                  spinner.stop();
          }
          });
		  }
          else
          {
		  	$("#errormessage").text("Please enter the title");
		  }
       });
      	$("#cancel").click(function() {
      		editId=0;
					$("#title").val("");
					$("#type").val(1);
      		
      	});
      	});
     
</script>


<div id="maincontent">
<div id="spinner"></div>
     
     <div class="mainheading">Add New Payment Term</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
         
                              <tr>
                           <td width="20%"> <span style="font-size: 12px !important;"  >Payment Type</span>   </td>
                           <td width="80%"> <select id="type" style="width: 185px;" >
                           	<option value="1">Daily </option>
                           	<option value="2">Weekly </option>
                           	<option value="3">Monthly </option>
                           </select>  </td>
                              </tr>
                              <tr>
                           <td width="20%"> <span style="font-size: 12px !important;"  >Payment Term</span>   </td>
                           <td width="80%"> <input  id="title" type="text" value="" style="width: 180px;"/>  </td>
                              </tr>

                       

             

          </table>
          <div style="width:270px;float:left;margin-left:70px; margin-top:30px;">
               <?php echo $this->Html->image('bt-save.png', array('style' => 'margin-left:5px; cursor:pointer', 'id' => 'save', 'div' => array('style' => 'width:135px;float:left'))); ?>
               <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px; cursor:pointer', 'div' => array('style' => 'width:135px;float:right;'))); ?>

          </div>
          
     </div>
     
    
     
    
     <div class="mainbottomBg"></div>
</div>

<div id="maincontent" style="padding-top: 20px;">

     
     <div class="mainheading">Payment Terms</div>
     <div class="maincenterBg">
  <table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
                                                           <thead class="gridtableHeader">
                                                            <tr>
                                                                
                                                                                <td width="20%" style="padding-left:10px;" align="left"><?php echo ('Type'); ?></td>
                                                                                <td width="40%" style="padding-left:10px;" align="left"><?php echo ('Term'); ?></td>
                                                                                <td width="40%" align="center"><?php echo ('Actions'); ?></td>
                                                                                
                                                                           </tr>

                                                           </thead>
 <tbody style="border: solid 1px #2f9300;">
                                                            <?php
                                                            $i = 0;
                                                            $counter = 0;


                                                            foreach ($terms as $term):

                                                                 $class = '';
                                                                 if ($i++ % 2 == 0) {
                                                                           $class = ' class="grid2dark"';
                                                                      } else {
                                                                           $class = ' class="grid1light"';
                                                                      }
                                                                
                                                                 if ($i == 1) {
                                                                      ?>
                                                                     

                                                                                <?php } ?>
                                                                               
                                                                                <tr id="row_<?php echo $term['payment_terms']['id'];?>" <?php echo $class; ?>>
                                                                                     <td width="20%"  align="left" class="gridcellborder" >&nbsp;
                                                                                          <?php 
                                                                                          $id=$term['payment_terms']['id'];
                                                                                          switch($term['payment_terms']['type'])
                                                                                          {
																						  	case 1:
																						  	echo "<span id='type_$id'>Daily</span>";
																						  	break;
																						  	case 2:
																						  	echo "<span id='type_$id'>Weekly</span>";
																						  	break;
																						  	case 3:
																						  	echo "<span id='type_$id'>Monthly</span>";
																						  	break;
																						  }
                                                                                           ?>
                                                                                     </td>
                                                                                     <td width="40%" style="padding-left:10px;" align="left" class="gridcellborder"><span id="title_<?php echo $term['payment_terms']['id'];?>"><?php echo $term['payment_terms']['title']; ?> </span></td>
                                                                                     <td width="40%" align="center" style="padding-left:10px;" class="gridcellborder"><span style="cursor: pointer;" onclick="editterm(<?php echo $term['payment_terms']['id'];?>)"> Edit</span>  <span style="margin-left: 50px; cursor: pointer;" onclick="deleteterm(<?php echo $term['payment_terms']['id'];?>)"> Delete</span></td>
                                                                                     

                                                                 </tr>

                                                            <?php endforeach; ?>
 </tbody>
                                        </table>

 <div class="mainbottomBg"></div>
</div>

