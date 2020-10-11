
<?php $userid = $session->read('Auth.User.role_id') ?>

<script src="../js/spin.js" type="text/javascript"></script>
  
<script type="text/javascript">
     var userid = 0;
     var bFirstTime = 0;
     
     
     function getLiveCallsReport() {


          $.ajax({
               url: "../api/getLiveCallsRangeReport",
               type: "GET",
               data: "cid=1",
               cache: false,
               success: function(msg) {
               	var objData = jQuery.parseJSON(msg);
              		var html="";
              		var totalCalls=0;
               	for (i = 0; i < objData.length; i++) {
               		totalCalls=totalCalls+ Number(objData[i].total);
               		html=html+"<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='grid1light' ><td width='50%' align='center' class='gridcellborder'>"+objData[i].name +"&nbsp;</td><td width='50%' align='center' class='gridcellborder'>&nbsp;"+objData[i].total+"</td></tr></table>";
               		
                     }
                       $('#rangeReport').html(html);
                       $('#userReport').height($('#rangeReport').height());
                       $('#totalRangeCalls').text("("+totalCalls+" calls)");
               }
              
          });
          
          $.ajax({
               url: "../api/getLiveCallsUserReport",
               type: "GET",
               data: "cid=1",
               cache: false,
               success: function(msg) {
               	var objData = jQuery.parseJSON(msg);
                var html="";
                var totalCalls=0;
               	for (i = 0; i < objData.length; i++) {
               		totalCalls=totalCalls +  Number(objData[i].total);
               		html=html+"<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='grid1light'><td width='50%' align='center' class='gridcellborder' style='cursor:pointer;' onclick=\"getReportByUser("+objData[i].id+",'"+objData[i].name+"')\">"+objData[i].name +"&nbsp;</td><td width='50%' align='center' class='gridcellborder'>&nbsp;"+objData[i].total+"</td></tr></table>";
               		
                     }
                       $('#userReport').html(html);
                       $('#totalCustomerCalls').text("("+totalCalls+" calls)");
               }
              
          });
     }
     userid = '<?php echo $userid; ?>';
if (userid > 0) {
     	       getLiveCallsReport();
     	       setInterval("getLiveCallsReport()", 10000);
           
     } else {
          window.location = ("../pages/login");

     }
     
     function getReportByUser(userId,username) {
     	
     	$("#dialog").hide();
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
               url: "../api/getReportByUser",
               type: "GET",
               data: "userId="+userId,
               cache: false,
               success: function(msg) {
               	var objData = jQuery.parseJSON(msg);
               //alert(objData);
                var html="";
               for (i = 0; i < objData.length; i++) {
               	
               		html=html+"<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr class='grid1light' ><td width='20%' align='left' style='padding-left: 10px;' class='gridcellborder'>"+username +"&nbsp;</td><td width='20%' align='left' style='padding-left: 10px;' class='gridcellborder'>"+objData[i].range +"&nbsp;</td><td width='20%' align='left' style='padding-left: 10px;' class='gridcellborder'>&nbsp;"+objData[i].dest+"</td><td width='20%' align='left' style='padding-left: 10px;' class='gridcellborder'>"+objData[i].cid_num +"&nbsp;</td><td width='20%' align='center' class='gridcellborder'>&nbsp;"+objData[i].duration+"</td></tr></table>";
               		
                     }
                       $('#userReportDialog').html(html);
                      $("#dialog").show();
                     spinner.stop();
               },
           error: function(){
           	getReportByUser(userId,username);
                  spinner.stop();
          }
              
          });
     }
   
</script>

<cake: nocache>
<div id="foo"></div>
 <div id="maincontent">
 <div id="spinner"></div>
          <div id="inner">
               <div class="mainheading"><div align="left">Customer Based Report <span id="totalCustomerCalls"></span><div style="float:right; margin-right:100px;">Range Based Report <span id="totalRangeCalls"></span></div></div>  </div>
               <div class="maincenterBg">
                    <table width="50%" style="float: left;" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="50%" align="center">Customer</td>
                                                                           <td width="50%" align="center">No. Of Calls</td>

                                                                      </tr>
                                                                 </table></td>
                                                       </tr>


                                                      <tr  class="grid2dark" valign="top">
                                                       <td id="userReport">
                                                       	
                                                       </td>
                                                       </tr>
                                                  </table></td>
                                        </tr>
                                   </table></td>
                         </tr>
                    </table>

<table width="50%" style="float: right;" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="50%" align="center">Name</td>
                                                                           <td width="50%" align="center">No. Of Calls</td>
                                                                          
                                                                      </tr>
                                                                 </table></td>
                                                       </tr>


                                                       <tr  class="grid2dark">
                                                       <td id="rangeReport">
                                                       	
                                                       </td>
                                                       </tr>
                                                  </table></td>
                                        </tr>
                                   </table></td>
                         </tr>
                    </table>

               </div>
               <div class="mainbottomBg"></div>
               
               
               
          </div>

<div id="dialog" style="display:none;">
  <table width="100%" style="float: left;" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="20%" align="left" style='padding-left: 10px;'>Customer</td>
                                                                           <td width="20%" align="left" style='padding-left: 10px;'>Range Name</td>
                                                                           <td width="20%" align="left" style='padding-left: 10px;'>Called Number</td>
                                                                           <td width="20%" align="left" style='padding-left: 10px;'>Calling Number</td>
                                                                           <td width="20%" align="center">Duration</td>

                                                                      </tr>
                                                                 </table></td>
                                                       </tr>


                                                      <tr  class="grid2dark" valign="top">
                                                       <td id="userReportDialog">
                                                       	
                                                       </td>
                                                       </tr>
                                                  </table></td>
                                        </tr>
                                   </table></td>
                         </tr>
                    </table>
</div>
     </div>

   
</cake:nocache>
