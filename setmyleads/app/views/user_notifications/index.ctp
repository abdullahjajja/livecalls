

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
                                                                      <td width="85%" align="left">&nbsp;<?php echo ('Detail'); ?></td>


                                                                 </tr>
                                                            </table></td>
                                                  </tr>

                                                  <tr>
                                                       <?php
                                                       $i = 0;
                                                       foreach ($userNotifications as $userNotification):
                                                            $class = ' class="grid2dark"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }
                                                            ?>
                                                            <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;<?php echo $userNotification['UserNotification']['id']; ?>&nbsp;</td>
                                                                           <td width="85%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo '<pre>' . $userNotification['UserNotification']['detail'] . '</pre>'; ?>&nbsp;</td>





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
<script type="text/javascript">

     $(document).ready(function() {

          // alert(u_id);
          var u_id =<?php echo $userNotification['UserNotification']['user_id']; ?>;

          $.ajax({
               url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'ChangeUsereNotificationStatus')); ?>",
               data: 'id=' + u_id,
               type: 'post',
               success: function(result) {
                    // alert(result);
               }
          });

     });
</script>
