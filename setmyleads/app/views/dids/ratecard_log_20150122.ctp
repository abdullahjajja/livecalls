<?php
$globalvar = 0;
?>
<script src="../js/spin.js" type="text/javascript"></script>
<script type="text/javascript">
     function search() {
          var name = $('#userName').val();
         
          window.location = ("../dids/ratecard_log?name=" + name);
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
      	$('#userName').val(name);
      	});
     
</script>

<div  id="maincontent">


     <fieldset  >
          <legend><?php __('Search By Customer'); ?></legend>
          <?php
          echo $this->Form->input('userName', array('label' => '&nbsp;Customer Name', 'class' => 'inputbox132px', 'style' => 'width:200px;'));
          echo $this->Form->submit('bt-search.png', array('type' => 'image', 'style' => 'float:left;margin-left:10px;margin-top:2px;', 'id' => 'btnsearch', 'name' => 'btnsearch', 'onclick' => 'search();'));
          
          ?>
     </fieldset  >

</div>
<div  id="maincontent">
     <div class="mainheading"><div align="left">Rate Card Logs</div> </div>
         
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
                                                                                <td width="15%" style="padding-left:10px;" align="left"><?php echo ('Customer'); ?></td>
                                                                                <td width="30%" style="padding-left:10px;" align="left"><?php echo ('Log Text'); ?></td>
                                                                                <td width="40%" align="center"><?php echo ('Assigned DID(s)'); ?></td>
                                                                                <td width="15%" align="center"><?php echo ('Created'); ?></td>
                                                                                
                                                                           </tr></table></td>

                                                            </tr>

                                                            <?php
                                                            $i = 0;
                                                            $counter = 0;


                                                            foreach ($logs as $log):

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
                                                                                     <td width="15%"  align="left" class="gridcellborder" >&nbsp;
                                                                                          <?php echo $log['users']['login']; ?>
                                                                                     </td>
                                                                                     <td width="30%" style="padding-left:10px;" align="left" class="gridcellborder"><?php echo $log['ratecard_log']['log_text']; ?></td>
                                                                                     <td width="40%" align="left" class="gridcellborder"><?php echo $log['ratecard_log']['assigned_dids']; ?></td>
                                                                                     <td width="15%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                          <?php echo $log['ratecard_log']['created']; ?>
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
  
     <div class="mainbottomBg"></div>
     </div>