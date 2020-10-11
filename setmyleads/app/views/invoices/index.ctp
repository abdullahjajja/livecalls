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
               <div class="mainheading">Credit Notes Filter
                    <?php
                    $tp = date("d m y h:m:s");
                    //   echo $tp;
                    ?></div>
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
                                   // echo $this->Form->input('currency_id', array('id' => 'currency', 'empty' => 'All'));
                                   ?>
                              </td>
                              <td>

                              </td>
                              <td>
                                   <?php
                                   echo $this->Form->input('invoice_status_id', array('id' => 'status', 'empty' => 'Any'));
                                   ?>
                              </td>
                         </tr>

                         <tr>
                              <td >

                              </td>

                              <td><a href="#" onclick="getadminvoicecall(1)"><?php echo $this->Html->image('today.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                                   <a href="#" onclick="getadminvoicecall(2)"><?php echo $this->Html->image('yesday.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                              </td>
                              <td>

                              </td>
                              <td>
                                   <a href="#" onclick='getadminvoicecall(3)'><?php echo $this->Html->image('this-week.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>
                                   <a href="#" onclick='getadminvoicecall(4)'><?php echo $this->Html->image('last-week.png', array('alt' => __('numberrange', true), 'width' => '107', 'height' => '28')); ?></a>

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
               <div class="mainheading">Credit Notes List <div align="right" style="margin-top: -15px;margin-right: 15px" ><?php echo $user['User']['login']; ?></div> </div>

               <div class="maincenterBg">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">

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
                                        var date = new Date();
                                        var a = new Date(date.getFullYear(), date.getMonth(), date.getDay());

                                        $("#txtenddate").datepicker();
                                        $('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
                                        $("#txtenddate").datepicker('setDate', new Date());
                                        //  alert(a);


                                   });
                                   $(function() {

                                        $("#txtstartdate").datepicker();
                                        $('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');
                                        $("#txtstartdate").datepicker('setDate', new Date());



                                   });


          </script>

          <script type="text/javascript">


               Date.prototype.daysMoreLess = Date.prototype.daysMoreLess ||
                       function(days) {
                            days = days || 0;
                            var ystrdy = new Date(this.setDate(this.getDate() + days));
                            this.setDate(this.getDate() + -days);
                            return ystrdy;
                       };
               Date.prototype.getWeek = function(start)
               {
                    //Calcing the starting point
                    start = start || 0;
                    var today = new Date(this.setHours(0, 0, 0, 0));
                    var day = today.getDay() - start;
                    var date = today.getDate() - day;

                    // Grabbing Start/End Dates
                    var StartDate = new Date(today.setDate(date));
                    var EndDate = new Date(today.setDate(date + 6));
                    return [StartDate, EndDate];
               }
               Date.prototype.getLastWeek = function(start)
               {
                    //Calcing the starting point
                    start = start || 0;
                    var today = new Date(this.setHours(0, 0, 0, 0));
                    var day = today.getDay() - start;
                    var date = today.getDate() - day;

                    // Grabbing Start/End Dates
                    var StartDate = new Date(today.setDate(date - 7));
                    var EndDate = new Date(today.setDate(date - 1));
                    return [StartDate, EndDate];
               }


               function getadminvoicecall(which) {
                    // alert(getLastWeek());



                    $('#loading').css("display", "inline");
                    $('#links').css("display", "none");

                    var dateObj = new Date();
                    if (which == 1) {

                         var a = dateObj.daysMoreLess(-1);

                         // $("#txtstartdate").datepicker('setDate', a);
                         $("#txtstartdate").datepicker('setDate', new Date());
                         $("#txtenddate").datepicker('setDate', new Date());
                    }
                    if (which == 2) {

                         var b = dateObj.daysMoreLess(-1);
                         var a = dateObj.daysMoreLess(-2);

                         $("#txtenddate").datepicker('setDate', b);
                         $("#txtstartdate").datepicker('setDate', b);
                    }
                    if (which == 3) {
                         var Dates = new Date().getWeek();
                         //  alert(Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());

                         var a = Dates[0];

                         $("#txtstartdate").datepicker('setDate', a);
                         var b = Dates[1];

                         $("#txtenddate").datepicker('setDate', b);
                         //  $("#txtenddate").datepicker('setDate', new Date());
                    }
                    if (which == 4) {

                         var Dates = new Date().getLastWeek();
                         //  alert(Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
                         var b = Dates[1];
                         var a = Dates[0];

                         $("#txtenddate").datepicker('setDate', b);
                         $("#txtstartdate").datepicker('setDate', a);
                    }


                    var strdate = $('#txtstartdate').val();
                    var enddate = $('#txtenddate').val();


                    // alert(enddate);
                    //    var e = document.getElementById("currency");
                    //  var currency = e.options[e.selectedIndex].value;
                    var currency = '';

                    var e1 = document.getElementById("status");
                    var status = e1.options[e1.selectedIndex].value;
                    //  var ddlnmbtxt = e1.options[e1.selectedIndex].text;

                    if (strdate != '') {
                         strdate = strdate + ' 00:00:00';
                    } else {
                         alert('Start Date is not Given');
                         return false;
                    }
                    if (enddate != '') {
                         enddate = enddate + ' 23:59:59';
                    } else {
                         alert('End Date is not Given');
                         return false;
                    }


                    //  alert(strdate);
                    which = 0;
                    var userid = '<?php echo $ida; ?>';
                    //  alert(userid);
                    if (userid > 0) {
                         $.ajax({
                              url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'GetInvoice')); ?>",
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
               var url = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'view')) ?>" + '/' + id;

               //  var url = '/invoices/view/' + id;
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