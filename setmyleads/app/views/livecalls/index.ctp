
<?php $userid = $session->read('Auth.User.role_id') ?>


<script type="text/javascript">
     var userid = 0;
     var bFirstTime = 0;
     function getCalls() {


          $.ajax({
               url: "../api/getCalls",
               type: "GET",
               data: "cid=1",
               cache: false,
               success: function(msg) {
                    $('#inner').html('');
                    $('#inner').append(msg);

               },
               complete: function() {
              //call the 'getCalls' when current one is complete
              setTimeout(getCalls, 15000);
          }
          });
     }
     userid = '<?php echo $userid; ?>';
//alert(userid);
     if (userid > 0) {
                 getCalls();
               //setInterval("getCalls()", 15000);
     } else {
          window.location = ("../pages/login");

     }
</script>
<cake: nocache>
     <div id="maincontent">
          <div id="inner">
               <div class="mainheading"><div></div><div align="left">Live Calls  <div style="float:right; margin-right:100px;">Total Calls in Progress<div id="nm" style="float:right;margin-left:10px">0</div></div></div>  </div>
               <div class="maincenterBg">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                         <tr>
                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                             <td class="gridtable" id="tdCalls" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                       <tr>
                                                            <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="10%" align="center">Sr.No</td>
                                                                           <td width="10%" align="center">Customer</td>
                                                                           <td width="10%" align="center">Number Range</td>
                                                                           <td width="26%" align="center">Called Number</td>
                                                                           <td width="10%" align="center">Duration</td>
                                                                           <td width="10%" align="center">Calling Number</td>

                                                                      </tr>
                                                                 </table></td>
                                                       </tr>


                                                       <?php
                                                       $i = 0;
                                                       foreach ($calls as $call):
                                                            $class = ' class="grid2dark"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }
                                                            ?>
                                                            <tr <?php echo $class; ?>><td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                           <tr>
                                                                                <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                                                <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                                                <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                                                <td width="26%" align="center" class="gridcellborder">&nbsp;</td>
                                                                                <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                                                <td width="10%" align="center" class="gridcellborder">&nbsp;</td>

                                                                           </tr>
                                                                      </table></td>
                                                            </tr>
                                                       <?php endforeach; ?>
                                                  </table></td>
                                        </tr>
                                   </table></td>
                         </tr>
                    </table>



               </div>
               <div class="mainbottomBg"></div>
          </div>
     </div>
</cake:nocache>