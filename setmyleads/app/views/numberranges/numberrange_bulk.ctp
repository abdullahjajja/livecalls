
<?php $userid = $session->read('Auth.User.role_id') ?>
<div  id="maincontent">
     <fieldset>
          <legend><?php __('List Controls'); ?></legend>
     </fieldset  >

</div>

<div id="maincontent">
     <div class="mainheading" ><div></div><div align="left">Rate List</div>
     <div align="right" style="position:relative;float:right;margin-top: -18px" >
     <?php echo $this->Html->link(__('Update Rate List', true), array('action' => 'uploadbulkratelist')); ?>
      </div>
      <div style="position:relative;float:right;margin-top: -18px;margin-right: 140px;" >
     <?php echo $this->Html->link(__('Apply to All', true), array('action' => 'applyratelist'), '', sprintf(__('Are you sure you want to Apply ?', true), '')); ?>

      </div>
 	</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 
                                                                 <td width="10%" align="left">&nbsp;<?php echo ('Buying rate'); ?></td>
                                                                 <td width="15%" align="left">&nbsp;<?php echo ('Monthly rate'); ?></td>
                                                                 <td width="15%" align="left">&nbsp;<?php echo ('Weekly rate'); ?></td>
                                                            </tr>
                                                       </table></td>
                                             </tr>

                                             <tr>
                                                  <?php
                                                  $i = 0;
                                                  foreach ($results as $val):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
						
                                                       ?>
                                                       <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr>
<?php //var_dump($val)?>
                                                                      
                                                                      <td width="10%" align="left" class="gridcellborder">&nbsp;<?php echo (float) $val['numberrange_rate_list']['buyinrate']; ?></td>
                                                                      <td width="15%" align="left" class="gridcellborder">&nbsp;<?php echo (float)$val['numberrange_rate_list']['monthly']; ?></td>
                                                                      <td width="15%" align="left" class="gridcellborder">&nbsp;<?php echo (float)$val['numberrange_rate_list']['weekly']; ?></td>
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