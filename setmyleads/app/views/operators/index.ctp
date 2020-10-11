<div id="maincontent">
     <div class="mainheading"><div></div><div align="left">Users List</div> <div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?></div> </div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="center" valign="top"><table width="50%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="40%" align="left" style="padding-left:20px;"><?php echo ('Operator Name'); ?></td>
                                                                 <td width="30%" align="left" style="padding-left:30px;"><?php echo ('Operator Alphabet'); ?></td>

                                                                 <td width="30%" align="center"><?php __('Actions'); ?></td>
                                                            </tr>
                                                       </table></td>
                                             </tr>

                                             <tr>
                                                  <?php
                                                  $i = 0;
                                                  foreach ($operators as $operator):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
                                                       ?>
                                                  <tr<?php echo $class; ?>>
                                                       <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr><td width="40%" align="left" class="gridcellborder" style="padding-left:20px;"><?php echo $operator['Operator']['name']; ?></td>
                                                                      <td width="30%" align="left" class="gridcellborder" style="padding-left:20px;"><?php echo $operator['Operator']['alphabet']; ?></td>


                                                                      <td width="30%" align="center" class="gridcellborder">
                                                                           <?php echo $this->Html->link(__('Invoice', true), array('controller' => 'operator_invoices', 'action' => 'index', $operator['Operator']['id'])) . ' '; ?>
                                                                           <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $operator['Operator']['id'])) . ' '; ?>
                                                                           <?php echo $this->Html->link(__('IP Addr', true), array('action' => 'operator_ips', $operator['Operator']['id'])) . ' '; ?>
                                                                           <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $operator['Operator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $operator['Operator']['id'])); ?>
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
          <div style="text-align:center">
               <p>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
                    ));
                    ?>	</p>

               <div class="paging">
                    <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
                    | 	<?php echo $this->Paginator->numbers(); ?>
                    |
                    <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
               </div>
          </div>
          <div class="mainbottomBg"></div>
     </div>
