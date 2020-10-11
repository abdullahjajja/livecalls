
<?php $userid = $session->read('Auth.User.role_id') ?>
<style>
     #mydiv {
          border: .2em dotted #900;
     }
     #border {
          border-width: .2em;
          border-style: dotted;
          border-color: #900;
     }
     .style2 {
          color: #FFFFFF;
          font-weight: bold;
     }

</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>
<script src="../js/jquery.ui.timepicker.js" type="text/javascript"></script>
<script src="../js/jquery.timePicker.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../js/timePicker.css" type="text/css" media="all" />
<script type="text/javascript" src="../js/oneSimpleTablePaging-1.0.js"></script>
<script src="../js/spin.js" type="text/javascript"></script>


<?php
$date = gmdate('Y-m-d', strtotime('+0 hours'))
?>

<script type="text/javascript">
     $(window).load(function() {
          var dt = '<?php echo $date; ?>';
//alert(dt);
          var ts = 'hello';
          document.getElementById("txtenddate").value = dt;
          $("#txtstartdate").datepicker('setDate', dt);
          $("#txtenddate").datepicker('setDate', dt);

          getsubs();
          getdestinationgroup();
     });
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
     	
       
     function getvoicecall(which) {
         var target = document.getElementById('spinner');
         var spinner = new Spinner(opts).spin(target);
          $('#links').css("display", "none");
//alert(which);
//today
          if (which == "1") {
               $("#txtstartdate").datepicker('setDate', new Date());
               $("#txtenddate").datepicker('setDate', new Date());
          }
//yesterday
          if (which == "2") {
               $("#txtstartdate").datepicker('setDate', '-1');
               $("#txtenddate").datepicker('setDate', '-1');
          }

//this week
          if (which == "3") {
               $("#txtstartdate").datepicker('setDate', '-7');
               $("#txtenddate").datepicker('setDate', '+0');
          }

//last week
          if (which == "4") {
               $("#txtstartdate").datepicker('setDate', '-13');
               $("#txtenddate").datepicker('setDate', '-6');
          }

//this month
          if (which == "5") {
               var today = new Date();

               var month = today.getMonth() + 1;
               getstartend(month, 1);
//alert(month);
//$("#txtstartdate").datepicker('setDate', '-30');
//$("#txtenddate").datepicker('setDate', '+0');
          }

//this month
          if (which == "6") {
               var today = new Date();
               var month = today.getMonth();
               getstartend(month, 2);

//$("#txtstartdate").datepicker('setDate', '-60');
//$("#txtenddate").datepicker('setDate', '-30');
          }

//subtotaol
          if (which == "0") {

          }
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }
          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
          	$('#tdCalls').html('');
               $.ajax({
                    url: "../api/GetVoiceCall",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt+ "& term=" + payment_term,
//+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                    success: function(msg) {

                         spinner.stop();
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                         },
           error: function(){
                  spinner.stop();
          }
               });
          } else {
               window.location = ("../pages/login");

          }
     }

     /************************************************************** admin voice calls ********************************************************/

     function getadminvoicecall(which) {
          var target = document.getElementById('spinner');
         var spinner = new Spinner(opts).spin(target);
          $('#links').css("display", "none");
//alert(which);
//today
          if (which == "1") {
               $("#txtstartdate").datepicker('setDate', new Date());
               $("#txtenddate").datepicker('setDate', new Date());
          }
//yesterday
          if (which == "2") {
               $("#txtstartdate").datepicker('setDate', '-1');
               $("#txtenddate").datepicker('setDate', '-1');
          }

//this week
          if (which == "3") {
               $("#txtstartdate").datepicker('setDate', '-7');
               $("#txtenddate").datepicker('setDate', '+0');
          }

//last week
          if (which == "4") {
               $("#txtstartdate").datepicker('setDate', '-13');
               $("#txtenddate").datepicker('setDate', '-6');
          }

//this month
          if (which == "5") {
               var today = new Date();

               var month = today.getMonth() + 1;
               getstartend(month, 1);
//alert(month);
//$("#txtstartdate").datepicker('setDate', '-30');
//$("#txtenddate").datepicker('setDate', '+0');
          }

//this month
          if (which == "6") {
               var today = new Date();
               var month = today.getMonth();
               getstartend(month, 2);

//$("#txtstartdate").datepicker('setDate', '-60');
//$("#txtenddate").datepicker('setDate', '-30');
          }

//subtotaol
          if (which == "0") {

          }

          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }

          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
          	$('#tdCalls').html('');
               $.ajax({
                    url: "../api/GetAdminVoiceCall",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt+ "& term=" + payment_term,
//+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                    success: function(msg) {

                         spinner.stop();
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                    },
           error: function(){
                  spinner.stop();
          }
               });
          } else {
               window.location = ("../pages/login");

          }
     }
     /****************************************************************************************************************************/

     /************************************************************** admin Pre voice calls ********************************************************/

     function getpreadminvoicecall(which) {
          var target = document.getElementById('spinner');
         var spinner = new Spinner(opts).spin(target);
          $('#links').css("display", "none");
//alert(which);
//today
          if (which == "1") {
               $("#txtstartdate").datepicker('setDate', new Date());
               $("#txtenddate").datepicker('setDate', new Date());
          }
//yesterday
          if (which == "2") {
               $("#txtstartdate").datepicker('setDate', '-1');
               $("#txtenddate").datepicker('setDate', '-1');
          }

//this week
          if (which == "3") {
               $("#txtstartdate").datepicker('setDate', '-7');
               $("#txtenddate").datepicker('setDate', '+0');
          }

//last week
          if (which == "4") {
               $("#txtstartdate").datepicker('setDate', '-13');
               $("#txtenddate").datepicker('setDate', '-6');
          }

//this month
          if (which == "5") {
               var today = new Date();

               var month = today.getMonth() + 1;
               getstartend(month, 1);
//alert(month);
//$("#txtstartdate").datepicker('setDate', '-30');
//$("#txtenddate").datepicker('setDate', '+0');
          }

//this month
          if (which == "6") {
               var today = new Date();
               var month = today.getMonth();
               getstartend(month, 2);

//$("#txtstartdate").datepicker('setDate', '-60');
//$("#txtenddate").datepicker('setDate', '-30');
          }

//subtotaol
          if (which == "0") {

          }
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }

          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
          	$('#tdCalls').html('');
               $.ajax({
                    url: "../api/GetPreAdminVoiceCall",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt+ "& term=" + payment_term,
//+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                    success: function(msg) {

                         spinner.stop();
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                   },
           error: function(){
                  spinner.stop();
          }
               });
          } else {
               window.location = ("../pages/login");

          }

     }

     /****************************************************************************************************************/
     //setInterval( "getcdrs()", 3000 );

     function getstartend(mm, whmn) {

          var endday;
          if (mm == 1 || mm == 3 || mm == 5 || mm == 7 || mm == 8 || mm == 10 || mm == 12) {
               endday = 31;
          } else if (mm == 2) {
               endday = 28;

          } else if (mm == 4 || mm == 6 || mm == 9 || mm == 11) {
               endday = 30;
          }
          if (whmn == 1) {
               var year = new Date().getFullYear()
               var start = year + "-" + mm + "-01";
               var end = year + "-" + mm + "-" + endday;
               $("#txtstartdate").datepicker('setDate', start);
               $("#txtenddate").datepicker('setDate', end);
          }

          if (whmn == 2) {

               var year = new Date().getFullYear()
               var start = year + "-" + mm + "-01";
               var end = year + "-" + mm + "-" + endday;
               $("#txtstartdate").datepicker('setDate', start);
               $("#txtenddate").datepicker('setDate', end);
          }


     }




     function getsubs() {
          // alert("called");
          $('#links').css("display", "none");
          $.ajax({
               url: "../api/getsubcus",
               type: "GET",
               //data:"cid=" + 1 + "& strdt=" + strdate + "& edt="+enddate + "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {
                    //alert(msg);
                    $('#subcus').html('');
                    $('#subcus').append(msg);
                    $('#subcustomer').css('display', 'none');
               },
               error: function(xhr, ajaxOptions, thrownError) {

                    //alert(thrownError);
                    // alert("error");
               }
          });
     }

     function getdestinationgroup() {
          // alert("called");
          $.ajax({
               url: "../api/getdestinations",
               type: "GET",
               //data:"cid=" + 1 + "& strdt=" + strdate + "& edt="+enddate + "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {
                    //alert(msg);
                    $('#numb').html('');
                    $('#numb').append(msg);
                    $('#dest').css('display', 'none');
               },
               error: function(xhr, ajaxOptions, thrownError) {

                    //alert(thrownError);
                    //  alert("error");
               }
          });
     }

     function getreport(a) {
          $.ajax({
               url: "../api/download_invoice_report",
               type: "GET",
               data: 'cid=' + a,
               success: function(result) {
                    alert(result);
               }

          });

     }

     function downloads() {
           var target = document.getElementById('spinner');
         var spinner = new Spinner(opts).spin(target);
           var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }
          

          $.ajax({
               url: "../api/downloadvoicecall",
               type: "GET",
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt + "& term=" + payment_term,
               //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {

                     spinner.stop();
                    $('#links').css("display", "inline");
               },
           error: function(){
                  spinner.stop();
          }
          });
     }




     /************************************************************************** admin download ****************************************************/
     function admindownload() {
          var target = document.getElementById('spinner');
         var spinner = new Spinner(opts).spin(target);
          var strdate = $('#txtstartdate').val();
          var payment_term = $('#term').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }
          
          $.ajax({
               url: "../api/downloadadminvoicecall",
               type: "GET",
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt + "& term=" + payment_term,
               //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {
                  spinner.stop();
                    $('#links').css("display", "inline");
                     },
           error: function(){
                  spinner.stop();
          }
          });
     }

     /*******************************************************************************************************************************************************/

     /************************************************************************** Pre admin download ****************************************************/

     function preadmindownload() {
          var target = document.getElementById('spinner');
          var spinner = new Spinner(opts).spin(target);
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var ddlsub = $('#subcustomers').val();
          var ddlnmb=-1;
          var ddlnmbtxt="Any";
          var e1 = document.getElementById("ddlnumber");
          if(e1!=null)
          {  		
		   ddlnmb = e1.options[e1.selectedIndex].value;
           ddlnmbtxt = e1.options[e1.selectedIndex].text;
           }
         

          $.ajax({
               url: "../api/predownloadadminvoicecall",
               type: "GET",
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& dsttxt=" + ddlnmbtxt+ "& term=" + payment_term,
               //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {

                     spinner.stop();
                    $('#links').css("display", "inline");
                                },
           error: function(){
                  spinner.stop();
          }
          });

     }

     /*******************************************************************************************************************************************************/

     jQuery(function() {


     });


</script>




<table>
     <tr>
          <td>

          </td>
          <td>

          </td>
     </tr>
     <tr>
          <td colspan="2">

          </td>
     </tr>
</table>



<?php
if ($this->Session->read('Auth.User.role_id') == 1) {
     ?>

     <div id = "maincontent">
     <div id="spinner"></div>
          <div class = "mainheading">Download Invoice Report </div>
          <div class = "maincenterBg" style = "clear :both">
               <div style = "margin-top: 20px; margin-bottom: 30px; margin-left: 10px;">
                    <a pass = "" href = " <?php echo $this->Html->url(array('controller' => 'api', 'action' => 'download_invoice_report', 2)) ?>"><?php echo $this->Html->image('monthly.jpg', array('alt' => __('Daily', true), 'width' => '107', 'height' => '28'));
     ?></a>
                    <a pass = "" href=  " <?php echo $this->Html->url(array('controller' => 'api', 'action' => 'download_invoice_report', 0)) ?>"><?php echo $this->Html->image('weekly.png', array('alt' => __('Weekly', true), 'width' => '107', 'height' => '28'));
     ?></a>

                    <a pass = "" href = "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'export_users_weekly_report')) ?>"><?php echo $this->Html->image('users-report.png', array('alt' => __('Users Report', true), 'width' => '107', 'height' => '28'));
     ?></a>
                    <a pass = "" href=  "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'export_operators_weekly_report')) ?>" ><?php echo $this->Html->image('operators-report.png', array('alt' => __('Operators Report', true), 'width' => '107', 'height' => '28'));
     ?></a>

                    <a pass = "" href = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'index2')) ?>" style="float:right; margin-right: 20px;"><?php echo $this->Html->image('pending.png', array('alt' => __('Pending Amounts', true), 'width' => '107', 'height' => '28'));
     ?></a>
                    <a pass = "" href = " <?php echo $this->Html->url(array('controller' => 'profits', 'action' => 'index')) ?> " style="float:right; margin-right: 20px;"><?php echo $this->Html->image('profit-report.png', array('alt' => __('Profit Repot', true), 'width' => '107', 'height' => '28'));
     ?></a>

               </div>


          </div>
     </div>
<?php } ?>
<div id="maincontent">
     <div class="mainheading">Sub Total </div>
     <div class="maincenterBg">

          <?php echo $this->Form->create('Reports', array('action' => 'index', 'type' => 'post')); ?>
          <table width="953" border="0">

               <tr>
                    <td width="169">Destination Group: </td>
                    <td width="266">
                         <!--<?php echo $this->Form->input('numberrange_id', array('style' => 'border: 1px solid #40C900;float: left;height: 30px; width: 102px;')); ?>-->
                         <label>
                              <select name="dest" style="width:200px" id="dest">
                                   <option value="Any">Any</option>

                              </select>
                              <div id="numb"></div>
                         </label>


                    </td>
                    <td width="239">Customer:</td>
                    <td width="244"><select name="subcustomer" style="width:200px" id="subcustomer">
                              <option value="-1">Any</option>

                         </select>
                         <div id="subcus"></div>

                    </td>
               </tr>

               <tr>
                    <td ><span style="margin-left:2px">Start Date:</span></td>
                    <td>
                         <input type="text" name="txtstartdate" style="width:100px" id="txtstartdate"/>
                         <input type="text" id="starttime" size="10px" value="00:00" />
                    </td>
                    <td>End Date:</td>
                    <td><input type="text"  name="txtenddate" style="width:100px" id="txtenddate"/>
                         <input type="text" id="endtime" size="10px" value="23:59" />
                    </td>    <td width="105">
               </tr>
              <?php if ($userid == 1 || $userid == 2 ) { ?>
               <tr>
                    <td width="239">Payment Term:</td>
                    <td width="244">
                         <select name="payment_term" style="width:200px" id="term">
                              <option value="-1">Any</option>
                              <option value="0">Weekly</option>
                              <option value="2">Monthly</option>
                              <option value="1">Daily</option>
                         </select>
                         <div id="subcus"></div>

                    </td>
               </tr>
                <?php } ?>
               <tr> </tr>
               <tr> </tr>
               <tr>
                    <td >

                    </td>

                    <td ><a href="javascript:void(0);" onclick="getvoicecall(1);"><?php echo $this->Html->image('today.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         <a href="javascript:void(0);" onclick="getvoicecall(2);"><?php echo $this->Html->image('yesday.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                    </td>
                    <td>

                    </td>
                    <td>
                         <a href="javascript:void(0);" onclick="getvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         <a href="javascript:void(0);" onclick="getvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>

                    </td>
                    <?php if ($userid == 1) { ?>
                    <td style="font-weight: bold;"> Add-ons Data</td>
                     <?php } ?>
               </tr>

               <tr>
                    <td> </td>
                    <td>
                         <!--
                          <a href="#" onclick="getvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         <a href="#" onclick="getvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         -->
                    </td>
                    <td></td>
                    <td ><a href="javascript:void(0);" onclick="getvoicecall(0);"><?php echo $this->Html->image('get-sab.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         <a href="javascript:void(0);" onclick="downloads();" ><?php echo $this->Html->image('bt-download.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                         </a>
                         <div style="display:none;" id="links">
                              <?php echo $this->Html->link(__('Download File', true), array('controller' => 'api/downloadsb'), array('pass' => array('export.csv'))); ?>
                         </div>
                    </td>
                    
               </tr>

               <?php if ($userid == 1) { ?>
                    <tr>
                         <td >

                         </td>

                         <td><a href="javascript:void(0);" onclick="getadminvoicecall(1);"><?php echo $this->Html->image('today.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="javascript:void(0);" onclick="getadminvoicecall(2);"><?php echo $this->Html->image('yesday.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                         </td>
                         <td>

                         </td>
                         <td>
                              <a href="javascript:void(0);" onclick="getadminvoicecall(5);"><?php echo $this->Html->image('btn_athis_month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="javascript:void(0);" onclick="getadminvoicecall(6);"><?php echo $this->Html->image('btn_alast_month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>

                         </td>
                         <td style="font-weight: bold;">Without Add-ons Data</td>
                    </tr>

                    <tr>
                         <td> </td>
                         <td>
                              <!--
                               <a href="#" onclick="getadminvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="#" onclick="getadminvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              -->
                         </td>
                         <td></td>
                         <td ><a href="javascript:void(0);" onclick="getadminvoicecall(0);"><?php echo $this->Html->image('btn_asubtotal.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="javascript:void(0);" onclick="admindownload();" ><?php echo $this->Html->image('btn_adownload.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                              </a>
                              <div style="display:none;" id="links">
                                   <?php echo $this->Html->link(__('Download File', true), array('controller' => 'api/downloadsb'), array('pass' => array('export.csv'))); ?>
                              </div>
                             
                         </td>
                         
                    </tr>

                    <tr>
                         <td> </td>
                         <td>
                              <!--
                               <a href="#" onclick="getadminvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="#" onclick="adminvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              -->
                         </td>
                         <td></td>
                         <td ><a href="javascript:void(0);" onclick="getpreadminvoicecall(0);"><?php echo $this->Html->image('subtotal-pre-3.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              <a href="javascript:void(0);" onclick="preadmindownload();" ><?php echo $this->Html->image('download-pre-3.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                              </a>
                              <div style="display:none;" id="links">
                                   <?php echo $this->Html->link(__('Download File', true), array('controller' => 'api/downloadsb'), array('pass' => array('export.csv'))); ?>
                              </div>
                            
                         </td>
                         <td style="font-weight: bold;"> Old Data</td>
                    </tr>
               <?php } ?>




               <tr>

                    <td width="249">
               <tr>
               </tr>
          </table>



          <?php echo $form->end(); ?>


     </div>
     <div class="mainbottomBg"></div>
</div>

<div id="maincontent">
     <div class="mainheading">Sub Totals <div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('CDRs', true), array('action' => 'cdr')); ?></div> </div>

     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable" id="tdCalls"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="7%" height="29px" align="center">Customer </td>
                                                                 <td width="14%" height="29px" align="center">Number Range </td>
                                                                 <td width="14%" height="29px" align="center">Number </td>
                                                                 <td width="14%" align="center">Payment Term</td>
                                                                 <td width="14%" align="center">Calls</td>
                                                                 <td width="14%" align="center">Minutes</td>

                                                            </tr>
                                                       </table></td>
                                             </tr>
                                             <tr>



                                             </tr>
                                        </table></td>
                              </tr>


                         </table></td>
               </tr>
          </table>
     </div>


</div>



<script type="text/javascript">
     $(function() {

          $("#txtstartdate").datepicker();
          $('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');
          $("#starttime").timePicker(
                  {
                       startTime: "02.00", // Using string. Can take string or Date object.
                       endTime: new Date(0, 0, 0, 15, 30, 0), // Using Date object here.
                       show24Hours: true,
                       separator: '.',
                       width: 20,
                       step: 15});


     });
     $(function() {
          $("#txtenddate").datepicker();
          $('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
          $("#endtime").timePicker();
     });

</script>
