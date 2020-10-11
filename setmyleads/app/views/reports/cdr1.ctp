
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
<script src="http://184.154.5.83/livecalls/app/webroot/js/jquery.ui.timepicker.js" type="text/javascript"></script>
<script src="http://184.154.5.83/livecalls/app/webroot/js/jquery.timePicker.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://184.154.5.83/livecalls/app/webroot/js/timePicker.css" type="text/css" media="all" />

<script type="text/javascript" src="http://184.154.5.83/livecalls/app/webroot/js/paging.js"></script>
<script type="text/javascript" src="http://184.154.5.83/livecalls/app/webroot/js/oneSimpleTablePaging-1.0.js"></script>




<script type="text/javascript">

     var dataStore = window.sessionStorage;

     $(window).load(function() {
          $("#txtstartdate").datepicker('setDate', new Date());
          $("#txtenddate").datepicker('setDate', new Date());
//var pagenow=dataStore.getItem('page');
          getsubs();
          getdestinationgroup();

     });


     function getcdrs(pagenm) {
          $('#loading').css("display", "inline");
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
          $.ajax({
               url: "../api/GetCDRS",
               type: "GET",
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& pg=" + paging + "& nmval=" + ddlnmval,
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
     }
     //setInterval( "getcdrs()", 3000 );

     function download() {
          $('#loading').css("display", "inline");
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
               data: "cid=" + 1 + "& strdt=" + strdate + "& edt=" + enddate + "& cld=" + called + "& clr=" + caller + "&stt=" + strtimee + "& endt=" + endtime + "& sub=" + ddlsub + "& dst=" + ddlnmb + "& nmval=" + ddlnmval,
               success: function(msg) {
                    $('#loading').css("display", "none");
                    $('#links').css("display", "inline");
                    //alert(msg);
                    // $('#tdCalls').html('');
                    // $('#tdCalls').append(msg);
               }
          });
     }

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
                    alert("error");
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
                    alert("error");
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

          <fieldset  >
               <table width="100%" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                         <td align="left" valign="top">
                              <div class="border" id="mydiv>">
                                   <table width="946" border="0">
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
                                             <td width="239">Sub-Customer:</td>
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
                                             <td><input type="text" name="txtstartdate" style="width:100px" id="txtstartdate"/>
                                                  <input type="text" id="starttime" size="10px" value="00:00" />
                                             </td>
                                             <td>End Date:</td>
                                             <td><input type="text" name="txtenddate" style="width:100px" id="txtenddate"/>
                                                  <input type="text" id="endtime" size="10px" value="23:59" />

                                             </td>
                                             <!--
                                                                             <td colspan="2"><?php echo $this->Form->input('startdate', array('label' => 'Start Date: ', 'div' => false)); ?></td>


                                                                             <td colspan="2" ><?php echo $this->Form->input('enddate', array('label' => 'End Date: ', 'div' => false,)); ?></td>

                                             -->
                                        </tr>
                                        <tr>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                             <td>
                                                  <a href="#" onclick="getcdrs(0);"><?php echo $this->Html->image('bt-search.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>  <a href="#" onclick="download();" ><?php echo $this->Html->image('bt-download.png', array('action' => 'download'), array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?>
                                                  </a>
                                                  <img src="/livecalls/img/loading.gif" width="20" height="20" style="display:none" id="loading" />
                                                  <div style="display:none;" id="links">
                                                       <?php echo $this->Html->link(__('Download File', true), array('controller' => 'api/download')); ?>
                                                  </div>






                                             </td>
                                             <td>&nbsp;</td>
                                        </tr>
                                   </table>
                              </div>
                              </fieldset>
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
                                                            <tr>
                                                                 <td width="7%" height="29px" align="center">Date/Time</td>
                                                                 <td width="14%" align="center">Destination Group </td>
                                                                 <td width="14%" align="center">Caller</td>
                                                                 <td width="10%" align="center">Called</td>
                                                                 <td width="7%" align="center">Duration(Sec)</td>




                                                            </tr>
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