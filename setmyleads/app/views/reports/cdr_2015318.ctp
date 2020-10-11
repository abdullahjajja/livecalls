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
     .style1 {
          color: #000000;
          font-weight: bold;
     }
     .style2 {color: #FFFFFF}

     .pg-normal {
          color: black;
          font-weight: normal;
          text-decoration: none;
          cursor: pointer;
     }
     .pg-selected {
          color: black;
          font-weight: bold;
          text-decoration: underline;
          cursor: pointer;
     }






</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>
<script src="http://livecalls.hk/js/jquery.ui.timepicker.js" type="text/javascript"></script>
<script src="http://livecalls.hk/js/jquery.timePicker.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://livecalls.hk/js/timePicker.css" type="text/css" media="all" />

<script type="text/javascript" src="http://livecalls.hk/js/paging.js"></script>
<script type="text/javascript" src="http://livecalls.hk/js/oneSimpleTablePaging-1.0.js"></script>

<?php
$date = gmdate('Y-m-d', strtotime('+0 hours'))
?>


<script type="text/javascript">

     var dataStore = window.sessionStorage;

     $(window).load(function() {
          var dt = '<?php echo $date; ?>';
//alert(dt);
//document.getElementById("txtstartdate").text="hello";
          $("#txtstartdate").datepicker('setDate', dt);
          $("#txtenddate").datepicker('setDate', dt);


//var pagenow=dataStore.getItem('page');
          getsubs();
          getdestinationgroup();

     });


     function getcdrs(pagenm) {
          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();


          if (pagenm == 0) {
               var paging = 0;
               //$('#pagesnm').val('1');
               //alert($('#pagesnm').val);
          } else {
               var paging = parseInt(pagenm) * 100;
               //$('#pagesnm').val(pagenm);
          }
          dataStore.setItem('page', pagenm);

          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;

          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;

//alert(ddlnmval);
          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
               $.ajax({
                    url: "../api/GetCDRS",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& pg=" + paging + "& nmval=" + ddlnmval+ "& term=" + payment_term,
                    success: function(msg) {
                         // alert(msg);
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                         //paging();

                         $('#pageNavPosition').css("display", "inline");
                         $('#loading').css("display", "none");
                         if (pagenm == 0) {
                              $('#pagesnm').val('1');
                              var numberofpages = $('totalpages').text();
                              dataStore.setItem('totalpages', numberofpages);
                         } else {
                              $('#pagesnm').val(pagenm);
                              var numberofpages = dataStore.getItem('totalpages');
                              $('totalpages').text(numberofpages);
                         }
                    }
               });
          } else {
               window.location = ("/livecalls/pages/login");

          }
     }

     /***************************************** get Admin CDRs **********************************************/

     function getadmincdrs(pagenm) {
          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();


          if (pagenm == 0) {
               var paging = 0;
               //$('#pagesnm').val('1');
               //alert($('#pagesnm').val);
          } else {
               var paging = parseInt(pagenm) * 100;
               //$('#pagesnm').val(pagenm);
          }
          dataStore.setItem('page', pagenm);

          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;

          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;

//alert(ddlnmval);
          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
               $.ajax({
                    url: "../api/GetAdminCDRS",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& pg=" + paging + "& nmval=" + ddlnmval+ "& term=" + payment_term,
                    success: function(msg) {
                         // alert(msg);
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                         //paging();

                         $('#pageNavPosition').css("display", "inline");
                         $('#loading').css("display", "none");
                         if (pagenm == 0) {
                              $('#pagesnm').val('1');
                              var numberofpages = $('totalpages').text();
                              dataStore.setItem('totalpages', numberofpages);
                         } else {
                              $('#pagesnm').val(pagenm);
                              var numberofpages = dataStore.getItem('totalpages');
                              $('totalpages').text(numberofpages);
                         }
                    }
               });
          } else {
               window.location = ("/livecalls/pages/login");

          }
     }


     /***********************************************************************************************************/

     /***************************************** get Pre Admin CDRs **********************************************/

     function getpreadmincdrs(pagenm) {
          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();


          if (pagenm == 0) {
               var paging = 0;
               //$('#pagesnm').val('1');
               //alert($('#pagesnm').val);
          } else {
               var paging = parseInt(pagenm) * 100;
               //$('#pagesnm').val(pagenm);
          }
          dataStore.setItem('page', pagenm);

          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;

          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;

//alert(ddlnmval);
          userid = '<?php echo $userid; ?>';
          if (userid > 0) {
               $.ajax({
                    url: "../api/GetPreAdminCDRS",
                    type: "GET",
                    data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& pg=" + paging + "& nmval=" + ddlnmval+ "& term=" + payment_term,
                    success: function(msg) {
                         // alert(msg);
                         $('#tdCalls').html('');
                         $('#tdCalls').append(msg);
                         //paging();

                         $('#pageNavPosition').css("display", "inline");
                         $('#loading').css("display", "none");
                         if (pagenm == 0) {
                              $('#pagesnm').val('1');
                              var numberofpages = $('totalpages').text();
                              dataStore.setItem('totalpages', numberofpages);
                         } else {
                              $('#pagesnm').val(pagenm);
                              var numberofpages = dataStore.getItem('totalpages');
                              $('totalpages').text(numberofpages);
                         }
                    }
               });
          } else {
               window.location = ("/livecalls/pages/login");

          }
     }


     /***********************************************************************************************************/




     //setInterval( "getcdrs()", 3000 );

     function downloads() {

          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;
          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;
          $.ajax({
               url: "../api/downlaodcdr",
               type: "GET",
               cahce: false,
               data: "cid=" + 1 + "&strdt=" + strdate + "&edt=" + enddate + "&cld=" + called + "&clr=" + caller + "&stt=" + strtimee + "&endt=" + endtime + "&sub=" + ddlsub + "&dst=" + ddlnmb + "&nmval=" + ddlnmval+ "& term=" + payment_term,
               success: function(msg) {
                    $('#loading').css("display", "none");
                    $('#links').css("display", "inline");
                    $('#hdfilename').text(msg);
                    //alert($('#hdfilename').text());
                    //alert(msg);
                    // $('#tdCalls').html('');
                    // $('#tdCalls').append(msg);
               }
          });

     }

     /*****************************************************************Admin Downloads *******************************************/

     function admindownload() {
          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;
          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;
          $.ajax({
               url: "../api/downlaodadmincdr",
               type: "GET",
               cahce: false,
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& nmval=" + ddlnmval+ "& term=" + payment_term,
               success: function(msg) {
                    $('#loading').css("display", "none");
                    $('#links').css("display", "inline");
                    $('#hdfilename').text(msg);
                    // alert($('#hdfilename').text());
                    //alert(msg);
                    // $('#tdCalls').html('');
                    // $('#tdCalls').append(msg);
               }
          });
     }


     /********************************************************************************************************************************/


     /*****************************************************************Admin Pre Downloads *******************************************/

     function adminpredownload() {
          $('#loading').css("display", "inline");
          var payment_term = $('#term').val();
          var strdate = $('#txtstartdate').val();
          var enddate = $('#txtenddate').val();
          var called = $('#txtcalled').val();
          var caller = $('#txtcaller').val();
          var subcust = $('#subcustomer').val();
          var strtimee = $('#starttime').val();
          var endtime = $('#endtime').val();
          var e = document.getElementById("subcustomers");
          var ddlsub = e.options[e.selectedIndex].value;
          var e1 = document.getElementById("ddlnumber");
          var ddlnmb = e1.options[e1.selectedIndex].text;
          var ddlnmval = e1.options[e1.selectedIndex].value;
          $.ajax({
               url: "../api/downlaodpreadmincdr",
               type: "GET",
               cahce: false,
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& nmval=" + ddlnmval+ "& term=" + payment_term,
               success: function(msg) {
                    $('#loading').css("display", "none");
                    $('#links').css("display", "inline");
                    $('#hdfilename').text(msg);
                    // alert($('#hdfilename').text());
                    //alert(msg);
                    // $('#tdCalls').html('');
                    // $('#tdCalls').append(msg);
               }
          });
     }


     /********************************************************************************************************************************/

     function getsubs() {
          // alert("called");
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
                    //alert("error");
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
                    //alert("error");
               }
          });
     }



     function Getdestination() {

          var e = document.getElementById("ddlnumber");
          var selection = e.options[e.selectedIndex].value;


//var selindex=$('#subcustomer').val();
          alert(selection);
     }

     function next() {
          var currentpage = dataStore.getItem('page');
          var nextpage = parseInt(currentpage) + 1;
          var now = $('#pagesnm').val();
          var nxt = parseInt(now) + 1;
          $('#pagesnm').val(nxt);
          getcdrs(nextpage);

     }

     function previouse() {
          var currentpage = dataStore.getItem('page');
          var nextpage = parseInt(currentpage) - 1;
          var now = $('#pagesnm').val();
          var nxt = parseInt(now) - 1;
          $('#pagesnm').val(nxt);

          getcdrs(nextpage);

     }
     function recordbyinput() {
          var nextpage = $('#pagesnm').val();
          getcdrs(nextpage);


     }


</script>



<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>

<div id="maincontent">
     <div class="mainheading">CDRs</div>
     <div class="maincenterBg">
          <?php echo $this->Form->create('Reports', array('action' => 'index', 'type' => 'post')); ?>

         
               <table width="100%" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                         <td align="left" valign="top">
                              <div class="border" id="mydiv>">
                                   <table width="946" border="0">
                                        <tr>
                                        <input type="hidden" name="hdfilename" id="hdfilename" />
                                        <td width="169">Range Name: </td>
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
                                             <td>Called:</td>
                                             <td>
                                                  <label>
                                                       <input type="text" name="txtcalled" style="width:194px" id="txtcalled" />
                                                  </label>
                                             </td>
                                             <td>Caller:</td>
                                             <td><input type="text" name="txtcaller" style="width:194px" id="txtcaller"/></td>
                                        </tr>
                                        <tr>

                                             <td>Start Date:</td>
                                             <td><input type="text" name="txtstartdate" style="width:100px" id="txtstartdate" value="<?php echo $date; ?>"/>
                                                  <input type="text" id="starttime" size="10px" value="00:00" />
                                             </td>
                                             <td>End Date:</td>
                                             <td><input type="text" name="txtenddate" style="width:100px" id="txtenddate" value="<?php echo $date; ?>"/>
                                                  <input type="text" id="endtime" size="10px" value="23:59" />

                                             </td>
                                             <!--
                                                                             <td colspan="2"><?php echo $this->Form->input('startdate', array('label' => 'Start Date: ', 'div' => false)); ?></td>


                                                                             <td colspan="2" ><?php echo $this->Form->input('enddate', array('label' => 'End Date: ', 'div' => false,)); ?></td>

                                             -->
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
                                        <?php  } ?>
                                        <tr>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                             <td>
                                                  <a href="#" onclick="getcdrs(0);"><?php echo $this->Html->image('bt-search.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>  <a href="#" onclick="downloads();" ><?php echo $this->Html->image('bt-download.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                                                  </a>
                                                  <img src="/livecalls/img/loading.gif" width="20" height="20" style="display:none" id="loading" />
                                                  <div style="display:none;" id="links">
                                                       <?php
                                                       echo $_GET['hdfilename'];
                                                       ?>

                                                       <?php
                                                       echo $html->link('Download File', array(
                                                           'controller' => 'api',
                                                           'action' => 'download',
                                                           'file1' => $_POST['hdfilename'],
                                                       ));

                                                       echo $_POST['hdfilename'];
                                                       ?>

                                                       <!--
                                                       <?php // echo $this->Html->link(__('Download File', true), array('controller' => 'api/download'),array('pass'=>array('munawar'))); ?>
                                                       -->
                                                  </div>






                                             </td>
                                             <td>&nbsp;</td>
                                        </tr>

                                        <?php if ($userid == 1) { ?>
                                             <tr>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>
                                                       <a href="#" onclick="getadmincdrs(0);"><?php echo $this->Html->image('btn_asearch.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>  <a href="#" onclick="admindownload();" ><?php echo $this->Html->image('btn_adownload.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                                                       </a>
                                                       <img src="/livecalls/img/loading.gif" width="20" height="20" style="display:none" id="loading" />
                                                       <div style="display:none;" id="links">
                                                  </td>
                                                  <td>&nbsp;</td>
                                             </tr>
                                             <tr>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td>
                                                       <a href="#" onclick="getpreadmincdrs(0);"><?php echo $this->Html->image('search-pre-3.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>  <a href="#" onclick="adminpredownload();" ><?php echo $this->Html->image('download-pre-3.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                                                       </a>
                                                       <img src="/livecalls/img/loading.gif" width="20" height="20" style="display:none" id="loading" />
                                                       <div style="display:none;" id="links">
                                                  </td>
                                                  <td>&nbsp;</td>
                                             </tr>
                                             <?php
                                             echo $_GET['hdfilename'];
                                        }
                                        ?>

                                   </table>
                              </div>
                             
                         </td>
                    </tr>
               </table>
               <?php echo $form->end(); ?>
     </div>
     <div class="mainbottomBg"></div>
</div>

<div id="maincontent">
     <div class="mainheading">CDR List <div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('Sub Total', true), array('action' => 'voicecall')); ?></div> </div>

     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top">
                         <table width="100%" border="0" cellspacing="0" cellpadding="0" id="out">
                              <tr>
                                   <td class="gridtable" id="tdCalls">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="inner">
                                             <tr>
                                                  <td class="gridtableHeader" >
                                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                       </table>

                                                  </td>
                                             </tr>


                                        </table></td>
                              </tr>
                         </table></td>
               </tr>
          </table>
          <!--
           <div id="pageNavPosition" style="display:none;">
          <div style=" margin-left:434px;">
          <table id="navigations">
          <tr>
          <td><a href="#" onclick="previouse();"><img src="/livecalls/img/Previous.png" width="16" height="16"  /></a></td>
          <td>Page<input type="text" id="pages" style="width:20px;" />of </td>
          <td><a href="#"  onclick="next();"><img src="/livecalls/img/Next.png" width="16" height="16"  /> </a></td>
          </tr>
          </table>
          </div>
          </div>
          -->
     </div>
     <div class="mainbottomBg"></div>
</div>




<script type="text/javascript">
     $(function() {
          $("#starttime").timePicker();
          $("#txtstartdate").datepicker();
          $('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');


     });
     $(function() {
          $("#txtenddate").datepicker();
          $('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
          $("#endtime").timePicker();
     });





</script>
