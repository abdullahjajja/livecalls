  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="../js/spin.js" type="text/javascript"></script>

<div id="maincontent">
<div id="spinner"></div>
     <div class="mainheading"><div></div><div align="left">Pending Credit Note List</div> </div>
     <div class="maincenterBg">
          <table cellpadding="0" cellspacing="0">
               <table width="100%" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                         <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                   <tr>
                                        <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                       <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr>

                                                                      <td width="15%" align="left">&nbsp;<?php echo ('Credit Note Number'); ?></td>

                                                                      <td width="15%" align="left">&nbsp;<?php echo ('Login'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Name'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Billing Period'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Type'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Status'); ?></td>


                                                                      <td width="10%" align="left">&nbsp;<?php echo ('View'); ?></td>

                                                                 </tr>
                                                            </table></td>
                                                  </tr>

                                                  <tr>
                                                       <?php
                                                       $i = 0;

                                                       foreach ($invoices as $notification):

//print_r($notification);
//exit();
                                                            $class = ' class="grid2dark"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }

                                                            $idd = $notification['Invoice']['id'];
                                                            $invoice_id = date("M", strtotime($notification['Invoice']['date']));

                                                            if ($notification['Invoice']['isdaily'] == 1) {

                                                                 $type = 'Daily';
                                                                 $invoice_id.='D';
                                                            } else if ($notification['Invoice']['isdaily'] == 0) {
                                                                 $type = 'Weekly';
                                                                 $invoice_id.='W';
                                                            } else if ($notification['Invoice']['isdaily'] == 2) {
                                                                 $type = 'Monthly';
                                                                 $invoice_id.='M';
                                                            }
                                                            $invoice_id.=$idd;
                                                            ?>
                                                            <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="15%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo $invoice_id; ?>
                                                                           </td>

                                                                           <td width="15%" align="left" style="cursor: pointer;" class="gridcellborder" onclick="showAccountDetails(<?php echo $notification['User']['id'] ?>,'<?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?>')" >&nbsp;<?php echo $notification['User']['login'] ?>&nbsp;</td>
                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;<?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?>&nbsp;</td>

                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;
                                                                               <?php
                                                                                if ($notification['Invoice']['isdaily'] == 0) {
                                                                                     $ed = new DateTime($notification['Invoice']['date']);
                                                                                     $tp = date("d M", strtotime($notification['Invoice']['date'] . "-7 day")) . ' - ' . date("d M Y", strtotime($notification['Invoice']['date'] . "-1 day"));
                                                                                } else if ($notification['Invoice']['isdaily'] == 1) {
                                                                                     $ed = new DateTime($notification['Invoice']['date']);
                                                                                     $tp = date("d M", strtotime($notification['Invoice']['date'] . "-1 day")) . ' - ' . date("d M Y", strtotime($notification['Invoice']['date'] . "-1 day"));
                                                                                } else if ($notification['Invoice']['isdaily'] == 2) {
                                                                                     $ed = new DateTime($notification['Invoice']['date']);
                                                                                     $tp = date("d M", strtotime($notification['Invoice']['date'] . "-1 month")) . ' - ' . date("d M Y", strtotime($notification['Invoice']['date'] . "-1 day"));
                                                                                }


                                                                                echo $tp;
                                                                                ?>
                                                                           </td>

                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php
                                                                                echo $type;
                                                                                ?></div>
                                                                           </td>

                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;<?php
                                                                                if ($notification['Invoice']['invoice_status_id'] == 1) {
                                                                                     echo 'New';
                                                                                }
                                                                                if ($notification['Invoice']['invoice_status_id'] == 2) {
                                                                                     echo 'Paid';
                                                                                } if ($notification['Invoice']['invoice_status_id'] == 3) {
                                                                                     echo 'Rejected';
                                                                                }
                                                                                ?>&nbsp;</td>
                                                                           <td width="10%" align="center" class="gridcellborder" style="cursor: pointer"><img src='/img/card.png' onclick='popup(<?php echo $notification['Invoice']['id']; ?>)'></img> </td>
                                                                      </tr>
                                                                 </table></td>
                                                       </tr>
                                                  <?php endforeach; ?>
                                             </table></td>
                                   </tr>
                              </table></td>
                    </tr>
               </table>
               <div style="text-align:center">
                    <p>
                         <?php
                         echo $this->Paginator->counter(array(
                             'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
                         ));
                         ?>	</p>

                    <div class="paging" >
                         <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
                         | 	<?php echo $this->Paginator->numbers(); ?>
                         |
                         <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
                    </div>
               </div>
     </div>
     <div class="mainbottomBg"></div>
     <div id="overlay-back"></div>
     <div id="dialog" class="overlay" title="Bank Account Details">
  <table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
                                                           <thead class="gridtableHeader">
                                                            <tr>
                                                                
                                                                                <td width="10%" style="padding-left:10px;" align="left">Currency</td>
                                                                                <td width="15%" style="padding-left:10px;" align="left">Benificiary Name</td>
                                                                                <td width="15%" style="padding-left:10px;" align="left">Bank Name</td>
                                                                                <td width="15%" style="padding-left:10px;" align="left">Country</td>
                                                                                <td width="15%" style="padding-left:10px;" align="left">Swift Code</td>
                                                                                
                                                                                <td width="15%" style="padding-left:10px;" align="left">Account Number</td>
                                                                                <td width="15%" style="padding-left:10px;" align="left">Iban</td>
                                                                                
                                                                                
                                                                           </tr>

                                                           </thead>
 <tbody style="border: solid 1px #2f9300;">
 </tbody>
 </table>
</div>
</div>
<script type='text/javascript'>


                                                                                function popup(id) {
                                                                                     // alert(id);
                                                                                     var url = '/invoices/view/' + id;
                                                                                     var left = (screen.width / 2) - 400;
                                                                                     var top = (screen.height / 2) - 360;
                                                                                     newwindow = window.open(url, 'name', 'scrollbars=yes');
                                                                                     if (window.focus) {
                                                                                          newwindow.focus()
                                                                                     }
                                                                                     return false;
                                                                                }
$(function() {
    $( "#dialog" ).dialog({
    	autoOpen: false,
    	width: '950px',
    	//draggable: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      },
      close: function(event, ui) { $('.overlay, #overlay-back').fadeOut(500);  }
    });
    
  });

function showAccountDetails(id,name)
{
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
     
	$.ajax({
               url: "../api/getAccountDetails",
               type: "POST",
               data: "id="+id,
               cache: false,
               success: function(msg) {
               	var objData = jQuery.parseJSON(msg);
                var html="";
               
               	for (i = 0; i < objData.length; i++) {
               		var htmlclass="";
               		 if (i % 2 == 0) {
               		 	      htmlclass = 'grid2dark';
                      } else {
                          htmlclass = 'grid1light';
                             }
               		
               		html=html+"<tr class='"+htmlclass+"' style='height:50px;'><td width='10%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>"+objData[i].currency +"&nbsp;</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>&nbsp;"+objData[i].beneficiary_name+"</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>"+objData[i].bank_name +"&nbsp;</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>&nbsp;"+objData[i].country_name+"</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>"+objData[i].swift_code +"&nbsp;</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>&nbsp;"+objData[i].account_number+"</td><td width='15%' align='left' style='padding-left:5px; padding-right:5px;' class='gridcellborder'>&nbsp;"+objData[i].iban+"</td></tr>";
               		
                     }
                     $('.overlay, #overlay-back').fadeIn(500); 
                     $("#table_user tbody").empty();
                     $("#table_user tbody").append(html);
                     $("#dialog").dialog("option", "title", "Bank Account Details of "+name);
                     $("#dialog" ).dialog("open");
                     spinner.stop();
               },
           error: function(){
                  spinner.stop();
          }
              
          });
	
}


</script>
<style>

	#overlay-back {
    position   : absolute;
    top        : 0;
    left       : 0;
    width      : 100%;
    height     : 500%;
    background : #000;
    opacity    : 0.6;
    filter     : alpha(opacity=60);
    z-index    : 5;
    display    : none;
}

.overlay {
    position : absolute;
    top      : 0;
    left     : 0;
    width    : 100%;
    height   : 500%;
    z-index  : 10;
    display  : none;
} 
</style>