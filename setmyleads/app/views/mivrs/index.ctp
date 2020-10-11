<div id="maincontent">
     <div class="mainheading"><div></div><div align="left" style="float: left;">MIVRs List</div> <div align="right" ><?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?></div> </div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="20%" align="left">&nbsp;<?php echo ('ID'); ?></td>
                                                                 <td width="60%" align="left">&nbsp;<?php echo ('IVR Name'); ?></td>
                                                                 <td width="20%" align="left"><?php __('Actions'); ?>&nbsp;</td>
                                                            </tr>
                                                       </table></td>
                                             </tr>
                                             <tr>

                                                  <?php
                                                  $i = 0;
                                                  foreach ($mivrs as $mivr):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
                                                       ?>
                                                       <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr>
                                                                      <td width="20%" >&nbsp;<?php echo $mivr['Mivr']['id']; ?>&nbsp;</td>
                                                                      <td width="60%" >&nbsp;<?php echo $mivr['Mivr']['name']; ?>&nbsp;</td>
                                                          <!--		<td width="20%" ><?php echo $ivr['Ivr']['ivr_uploaded_name']; ?>&nbsp;</td>		-->
                                                                      <td class="actions">&nbsp;
                                                                           <?php echo $this->Html->link(__('View', true), array('action' => 'view', $mivr['Mivr']['id'])); ?>
                                                                           <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $mivr['Mivr']['id'])); ?>
                                                                           <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $mivr['Mivr']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ivr['Ivr']['id'])); ?>
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
           <td class="actions">
          <?php echo $this->Html->link(__('View', true), array('action' => 'view', $mivr['Mivr']['id'])); ?>
          <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $mivr['Mivr']['id'])); ?>
          <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $mivr['Mivr']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mivr['Mivr']['id'])); ?>
                              </td>
          -->


     </div>