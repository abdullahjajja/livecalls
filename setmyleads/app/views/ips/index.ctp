<div id="maincontent">
     <div class="mainheading"><div></div><div align="left">IPSs List</div> <div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?></div> </div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="10%" align="left">&nbsp;<?php echo ('IPs id'); ?></td>
                                                                 <td width="30%" align="left">&nbsp;<?php echo ('Ips Name'); ?></td>
                                                                 <td width="30%" align="left">&nbsp;<?php echo ('Ips Address'); ?></td>
                                                                 <td width="25%" align="left"><?php __('Actions'); ?>&nbsp;</td>
                                                            </tr>
                                                       </table></td>
                                             </tr>
                                             <tr>

                                                  <?php
                                                  // print_r($ips);
                                                  $i = 0;
                                                  foreach ($ips as $ip):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
                                                       ?>
                                                       <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr>
                                                                      <td width="10%" >&nbsp;<?php echo $ip['Ip']['id']; ?>&nbsp;</td>
                                                                      <td width="30%" >&nbsp;<?php echo $ip['Ip']['owner_name']; ?>&nbsp;</td>
                                                                      <td width="30%" >&nbsp;<?php echo $ip['Ip']['ip_address']; ?>&nbsp;</td>
                                                          <!--		<td width="20%" ><?php echo $ip['Ivr']['ivr_uploaded_name']; ?>&nbsp;</td>		-->
                                                                      <td width="25%" class="actions">&nbsp;
                                                                           <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $ip['Ip']['id'])); ?>
                                                                           <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $ip['Ip']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ip['Ip']['id'])); ?>
                                                                      </td>
                                                                 </tr>
                                                            </table></td>
                                                  </tr>
                                             <?php endforeach; ?>
                                        </table></td>
                              </tr>
                         </table></td>
               </tr>
          </table>
          <p>
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

          <!--
          <div class="actions">
                <h3><?php __('Actions'); ?></h3>
                <ul>
                      <li><?php echo $this->Html->link(__('New Ivr', true), array('action' => 'add')); ?></li>
                      <li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
                      <li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
                </ul>
          </div>
          -->