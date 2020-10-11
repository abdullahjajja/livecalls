<?php
$globalvar = 0;
?>
<script src="../js/spin.js" type="text/javascript"></script>
<script type="text/javascript">
     function searchNumberRange() {
          //alert ("search called");
          var name = $('#rangeNameTxt').val();
         
          window.location = ("../dids/ratecard?name=" + name);
          return;
     }
     function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
     }
      $(document).ready(function() {
      	
      	var name=getParameterByName('name');
      	$('#rangeNameTxt').val(name);
      	});
     
</script>

<div  id="maincontent">


     <fieldset  >
          <legend><?php __('Search By Number Range or Number'); ?></legend>
          <?php
          echo $this->Form->input('rangeNameTxt', array('label' => '&nbsp;Range Name&nbsp;or Number', 'class' => 'inputbox132px', 'style' => 'width:200px;'));
          echo $this->Form->submit('bt-search.png', array('type' => 'image', 'style' => 'float:left;margin-left:10px;margin-top:2px;', 'id' => 'btnsearch', 'name' => 'btnsearch', 'onclick' => 'searchNumberRange();'));
          //echo $html->link($html->image("bt-search.png"),  array('controller'=>'users/filteruser'), array('escape' => false,'id' => "btnsearch",'style'=>'float:left;margin-left:10px;margin-top:2px;'));
          ?>
     </fieldset  >

</div>
<div  id="maincontent">
<div id="spinner"></div>
     <div class="mainheading"><div align="left">Rate Card</div>
     <?php if ($session->read('Auth.User.role_id') == '1') { ?>
	 	<div style="float:left;  margin-top: -14px; margin-left:640px;" >
	 	<a href="ratecard_log">Logs</a>
	 	 </div>
	 <?php } ?> 
     
          <?php if ($session->read('Auth.User.role_id') == '1' || $session->read('Auth.User.role_id') == '2') { ?>
               <div align="right" style="margin-top: -14px; margin-right:100px;" ><?php echo $this->Html->link(__('Export CSV', true), array('controller' => 'api', 'action' => 'export_ratecard')); ?> </div>
               <div align="right" style="margin-top: -16px; margin-right:5px;" ><?php echo $this->Html->link(__('Export PDF', true), array('controller' => 'api', 'action' => 'export_ratecard_pdf')); ?></div>

          <?php } ?> </div>
     <div class="maincenterBg" id="maintbl">
          <table width="968px" border="0" cellspacing="0" cellpadding="0" >
               <tr valign="top">
                    <td width="968px">

                         <table width="968px" border="0" cellspacing="10" cellpadding="0" >
                              <tr>
                                   <td align="left" valign="top"><table width="950px" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtable"><table width="950px" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtableHeader">
                                                                           <tr>
                                                                                <td width="15%" style="padding-left:10px;" align="left"><?php echo ('Number Range'); ?></td>
                                                                                <td width="15%" style="padding-left:10px;" align="left"><?php echo ('Test Number'); ?></td>
                                                                                <td width="8%" align="center"><?php echo ('Curr.'); ?></td>
                                                                                <td width="8%" align="center"><?php echo ('Limit'); ?></td>
                                                                                <td width="8%" align="center"><?php echo ('Weekly Rate'); ?></td>
                                                                                <td width="8%" align="center"><?php echo ('Monthly Rate'); ?></td>

                                                                                <td width="18%" align="center"><?php echo ('Weekly Order'); ?></td>
                                                                                <td width="18%" align="center"><?php echo ('Monthly Order'); ?></td>
                                                                           </tr></table></td>

                                                            </tr>

                                                            <?php
                                                            $i = 0;
                                                            $counter = 0;


                                                            foreach ($dids as $did):

                                                                 //die(print_r($did));
                                                                 $class = '';
                                                                 if ($i++ % 2 == 0) {
                                                                           $class = ' class="grid2dark"';
                                                                      } else {
                                                                           $class = ' class="grid1light"';
                                                                      }
                                                               
                                                                 if ($i == 1) {
                                                                      ?>
                                                                      <tr valign = "top">
                                                                           <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable">

                                                                                <?php } ?>
                                                                                
                                                                                <tr <?php echo $class; ?>>
                                                                                     <td width="15%" align="left" class="gridcellborder" >&nbsp;
                                                                                          <?php echo $did['numberranges']['name']; ?>
                                                                                     </td>
                                                                                     <td width="15%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $did['dids']['did']; ?></td>
                                                                                     <td width="8%" align="center" class="gridcellborder"><?php echo $did['currencies']['currency_name']; ?></td>
                                                                                     <td width="8%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                          <?php echo $did['numberranges']['maxdailyminutes']; ?>
                                                                                     </td>
                                                                                     <td width="8%" align="center" class="gridcellborder"><?php echo $did['numberranges']['sellingrate']; ?></td>
                                                                                     <td width="8%" align="center" class="gridcellborder"><?php echo $did['numberranges']['monthlyrate']; ?></td>
                                                                                <input type="hidden" value="<?php echo $did['numberranges']['name']; ?>" id="<?php echo $did['numberranges']['id']; ?>"></input>
                                                                                <td width="18%" align="center" class="gridcellborder"  style="cursor:pointer" onclick='autoorder(<?php echo $did['numberranges']['id'] ?>, 0)'> <div style="margin-left: 20px; width: 117px;" class="green-button">Req. With <?php if($did['numberranges']['weekly_title']==NULL)
                                                                       	  echo 'Weekly 7/7';
																	    else echo $did['numberranges']['weekly_title'];
                                                                           	 ?>
                                                                               </div></td>
                                                                                <td width="18%" align="center" class="gridcellborder" style="cursor:pointer"  onclick="autoorder(<?php echo $did['numberranges']['id'] ?>, 2)">  <div style="margin-left: 20px; width: 117px;" class="green-button">Req. With 
                                                                          <?php if($did['numberranges']['monthly_title']==NULL)
                                                                       	  echo 'Monthly 30/30';
																	    else echo $did['numberranges']['monthly_title'];
                                                                           	 ?></div>    	
                                                                                </td>

                                                                 </tr>

                                                            <?php endforeach; ?>

                                                       </table></td>
                                             </tr>
                                        </table>
                                   </td></tr></table></td></tr></table>
          </td></tr></table>
          
          <?php // echo $this->Form->end();   ?>

     </div>
     <script type='text/javascript'>

                                                                                function autoorder(id, isdaily) {
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
     	  var target = document.getElementById('spinner');
          var spinner = new Spinner(opts).spin(target);

                                                                                     var na = $('#' + id).val();

                                                                                     $.ajax({
                                                                                          // url: "../api/auto_assign",
                                                                                          url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'auto_assign')); ?>",
                                                                                          data: 'n_id=' + id + '&isdaily=' + isdaily + '&name=' + na,
                                                                                          type: 'post',
                                                                                          success: function(result) {
                                                                                               spinner.stop();
                                                                                               if (result == 'a') {
                                                                                                    alert('No number is avalible in ' + na + ' .Kindly contact System Administrator ');
                                                                                               } else {
                                                                                                    alert(result);
                                                                                               }
                                                                                               
                                                                                          }
                                                                                     });
                                                                                }


     </script>
     <div class="mainbottomBg"></div>
     </div>