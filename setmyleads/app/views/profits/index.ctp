<html>
     <head>
          <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>
          <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
          <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />

          <script src="http://livecalls.hk/js/jquery.ui.timepicker.js" type="text/javascript"></script>
          <script src="http://livecalls.hk/js/jquery.timePicker.min.js" type="text/javascript"></script>
          <link rel="stylesheet" href="http://livecalls.hk/js/timePicker.css" type="text/css" media="all" />
          <script type="text/javascript" src="http://livecalls.hk/js/oneSimpleTablePaging-1.0.js"></script>



     </head>
     <body>






          <div id="maincontent" >
               <div class="mainheading">Invoice Filter </div>
               <div class="maincenterBg">

                    <?php echo $this->Form->create('Reports', array('action' => 'index', 'type' => 'post')); ?>
                    <table width="953" border="0">



                         <tr>
                              <td ><span style="margin-left:2px"></span></td>
                              <td>
                                   <span style="margin-left:2px">Start Date:</span>
                                   <input type="text" name="txtstartdate" style="width:250px ; height: 25px" id="txtstartdate"/>

                              </td>
                              <td </td>
                              <td><span style="margin-left:2px">End Date:</span>
                                   <input type="text"  name="txtenddate" style="width:250px ; height: 25px" id="txtenddate"/>

                              </td>    <td width="105">
                         </tr>

                         <tr> </tr>
                         <tr> </tr>
                         <tr> </tr>
                         <tr>
                              <td >

                              </td>

                              <td>

                                   <label>

                                        <div id="numb"></div>
                                   </label> <?php
                                   //    echo  $this->Form->input('currency_id', array('id' => 'currency', 'empty' => 'All'));
                                   ?>
                              </td>
                              <td>

                              </td>
                              <td>
                                   <?php
                                   //   echo $this->Form->input('invoice_status_id', array('id' => 'status', 'empty' => 'Any'));
                                   ?>
                              </td>
                         </tr>

                         <tr>
                              <td >

                              </td>

                              <td></td>
                              <td>

                              </td>
                              <td><a href="#" onclick="getadminvoicecall(1)"><?php echo $this->Html->image('this-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                                   <a href="#" onclick="getadminvoicecall(2)"><?php echo $this->Html->image('last-month.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              </td>
                         </tr>

                         <tr>
                              <td> </td>
                              <td>
                                   <!--
                                    <a href="#" onclick="getvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt' => __('Invoice List', true), 'width' => '107', 'height' => '28')); ?></a>
                                   <a href="#" onclick="getvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt' => __('Invoice List', true), 'width' => '107', 'height' => '28')); ?></a>
                                   -->
                              </td>
                              <td></td>
                              <td onclick='getadminvoicecall(0)' ><a href="#" ><?php echo $this->Html->image('get-sab.png', array('alt' => __('Invoice List', true), 'width' => '107', 'height' => '28')); ?></a>

                                   <div style="display:none;" id="links">
                                        <?php echo $this->Html->link(__('Download File', true), array('controller' => 'api/downloadsb'), array('pass' => array('export.csv'))); ?>
                                   </div>
                                   <img src="../img/loading.gif" width="20" height="20" style="display:none" id="loading" />
                              </td>
                         </tr>





                         <tr>
                              <td> </td>

                              <td></td>

                         </tr>




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
               <div class="mainheading">Invoice List <div align="right" style="margin-top: -15px" ></div> </div>

               <div class="maincenterBg">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="14%" height="29px" align="center">Invoice Number </td>
                                                                           <td width="14%" height="29px" align="center">Invoice Period </td>
                                                                           <td width="7%" align="center">View</td>

                                                                      </tr>
                                                                 </table></td>
                                                       </tr>
                                                       <tr>



                                                       </tr>
                                                  </table></td>
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

                                         $("#txtenddate").datepicker();
                                         $('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
                                         $("#txtenddate").datepicker('setDate', new Date());



                                    });
                                    $(function() {

                                         $("#txtstartdate").datepicker();
                                         $('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');
                                         $("#txtstartdate").datepicker('setDate', new Date());



                                    });


          </script>

          <script type="text/javascript">


               function getLastWeek() {
                    var today = new Date();

                    var lastWeek = new Date(today.getYear(), today.getMonth(), today.getDay() - 7);
                    return lastWeek;
               }

               function getadminvoicecall(which) {
                    // alert(getLastWeek());



                    $('#loading').css("display", "inline");
                    $('#links').css("display", "none");



                    var strdate = $('#txtstartdate').val();
                    var enddate = $('#txtenddate').val();


                    // alert(enddate);
//                    var e = document.getElementById("currency");
                    //                  var currency = e.options[e.selectedIndex].value;
                    var currency = '';
                    //  var e1 = document.getElementById("status");
                    //var status = e1.options[e1.selectedIndex].value;
                    //  var ddlnmbtxt = e1.options[e1.selectedIndex].text;
                    var status = '';

                    if (strdate != '') {
                         strdate = strdate + ' 00:00:00';
                    }
                    if (enddate != '') {
                         enddate = enddate + ' 23:59:59';
                    }
                    //  alert(strdate);

                    //   var userid = '<?php // echo $ida;     ?>';
                    //  alert(userid);
                    var userid = 1;
                    if (userid > 0) {
                         $.ajax({
                              url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'GetProfit')); ?>",
                              type: "GET",
                              data: "cid=" + which + "&strdate=" + strdate + "&edt=" + enddate + "&user_id=" + userid + "&status=" + status + "&currency=" + currency,
                              //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                              success: function(msg) {
                                   // alert(msg);
                                   $('#loading').css("display", "none");
                                   $('#tdCalls').html('');
                                   $('#tdCalls').append(msg);
                                   //$('#main').oneSimpleTablePagination({rowsPerPage: 200});
                              }
                         });
                    } else {
                         //  window.location = ("../pages/login");

                    }
               }

          </script>







     </body>
     <script>
          function popup(id) {
               // alert(id);
               var url = '/profits/view/' + id;
               var left = (screen.width / 2) - 400;
               var top = (screen.height / 2) - 360;
               newwindow = window.open(url, 'name', 'scrollbars=yes');
               if (window.focus) {
                    newwindow.focus()
               }
               return false;
          }
     </script>


</html>