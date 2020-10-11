<div id="maincontent">
     <div class="mainheading"><div></div><div align="left">Notification List</div> </div>
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
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Notification Id'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Login'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Name'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Number Range Name'); ?></td>
                                                                      <td width="15%" align="left">&nbsp;<?php echo ('Already Assigned'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Billing'); ?></td>
                                                                      <td width="15%" align="right"><?php __('Actions'); ?>&nbsp;</td>
                                                                 </tr>
                                                            </table></td>
                                                  </tr>

                                                  <tr>
                                                       <?php
                                                       $i = 0;
                                                       foreach ($notifications as $notification):
                                                            $class = ' class="grid2dark"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }
                                                            ?>
                                                            <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;<?php echo $notification['Notification']['id']; ?>&nbsp;</td>
                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo $notification['User']['login']; ?>
                                                                           </td>
                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?>
                                                                           </td>
                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo $notification['Numberrange']['name']; ?>
                                                                           </td>
                                                                           <td width="15%" align="left" class="gridcellborder">&nbsp;<?php echo $notification['Notification']['assign_total']; ?>&nbsp;</td>
                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php
                                                                                if ($notification['Notification']['isdaily'] == 1) {
                                                                                     echo"daily";
                                                                                } else {
                                                                                     echo"weekly";
                                                                                }
                                                                                ?>
                                                                           </td>


                                                                           <td width="15%" align="right" class="gridcellborder"> &nbsp;
                                                                                <span onclick="approve(<?php echo $notification['Numberrange']['id'] ?>,<?php echo $notification['User']['id'] ?>,<?php echo $notification['Notification']['isdaily'] ?>)"  style="cursor:pointer"><a> Approve </a></span> &nbsp;
                                                                                <span onclick="reject(<?php echo $notification['Notification']['id'] ?>)"  style="cursor:pointer"><a>Reject</a> </span>

                                                                                &nbsp;</td>
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
</div>
<script type='text/javascript'>

                                                                                     function approve(id, a, b) {
                                                                                          // alert(id + ' ' + a + ' ' + b);
                                                                                          //  return false;
                                                                                          $.ajax({
                                                                                               url: "/api/notification_assign",
                                                                                               data: 'n_id=' + id + '&u_id=' + a + '&isdaily=' + b,
                                                                                               type: 'post',
                                                                                               success: function(result) {
                                                                                                    alert(result);
                                                                                                    location.reload();
                                                                                                    history.go(0);
                                                                                                    location.href = location.href;
                                                                                                    window.location.reload();
                                                                                               }
                                                                                          });
                                                                                     }
                                                                                     function reject(id) {
                                                                                          $.ajax({
                                                                                               url: "/api/notification_reject",
                                                                                               type: 'post',
                                                                                               data: 'id=' + id,
                                                                                               success: function(result) {
                                                                                                    location.reload();
                                                                                                    history.go(0);
                                                                                                    location.href = location.href;
                                                                                                    window.location.reload();
                                                                                               }
                                                                                          });
                                                                                     }

</script>