<div id="maincontent">
     <div class="mainheading"><div></div><div align="left">Pending Credit Note List</div> </div>
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

                                                                      <td width="15%" align="left">&nbsp;<?php echo ('Credit Note Number'); ?></td>

                                                                      <td width="15%" align="left">&nbsp;<?php echo ('Login'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Name'); ?></td>
                                                                      <td width="20%" align="left">&nbsp;<?php echo ('Billing Period'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Type'); ?></td>
                                                                      <td width="10%" align="left">&nbsp;<?php echo ('Status'); ?></td>


                                                                      <td width="10%" align="left">&nbsp;<?php echo ('View'); ?></td>

                                                                 </tr>
                                                            </table></td>
                                                  </tr>

                                                  <tr>
                                                       <?php
                                                       $i = 0;

                                                       foreach ($invoices as $notification):


                                                            $class = ' class="grid2dark"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }

                                                            $idd = $notification['Invoice']['id'];
                                                            $invoice_id = date("M", strtotime($notification['Invoice']['date']));

                                                            if ($notification['Invoice']['isdaily'] == 1) {

                                                                 $type = 'Daily';
                                                                 $invoice_id.='D';
                                                            } else if ($notification['Invoice']['isdaily'] == 0) {
                                                                 $type = 'Weekly';
                                                                 $invoice_id.='W';
                                                            } else if ($notification['Invoice']['isdaily'] == 2) {
                                                                 $type = 'Monthly';
                                                                 $invoice_id.='M';
                                                            }
                                                            $invoice_id.=$idd;
                                                            ?>
                                                            <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                           <td width="15%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php echo $invoice_id; ?>
                                                                           </td>

                                                                           <td width="15%" align="left" class="gridcellborder">&nbsp;<?php echo $notification['User']['login'] ?>&nbsp;</td>
                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;<?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?>&nbsp;</td>

                                                                           <td width="20%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php
                                                                                if ($notification['Invoice']['isdaily'] == 0) {
                                                                                     $ed = new DateTime($notification['Invoice']['date']);
                                                                                     $tp = date("d M", strtotime($notification['Invoice']['date'] . "-7 day")) . ' - ' . $ed->format('d M Y');
                                                                                } else if ($notification['Invoice']['isdaily'] == 1) {
                                                                                     $ed = new DateTime($notification['Invoice']['date']);
                                                                                     $tp = date("d M", strtotime($notification['Invoice']['date'] . "-1 day")) . ' - ' . $ed->format('d M Y');
                                                                                }
                                                                                echo $tp;
                                                                                ?>
                                                                           </td>

                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;
                                                                                <?php
                                                                                if ($notification['Invoice']['isdaily'] == 0) {
                                                                                     echo 'Weekly';
                                                                                } else {
                                                                                     echo 'Daily';
                                                                                }
                                                                                ?></div>
                                                                           </td>

                                                                           <td width="10%" align="left" class="gridcellborder">&nbsp;<?php
                                                                                if ($notification['Invoice']['invoice_status_id'] == 1) {
                                                                                     echo 'New';
                                                                                }
                                                                                if ($notification['Invoice']['invoice_status_id'] == 2) {
                                                                                     echo 'Paid';
                                                                                } if ($notification['Invoice']['invoice_status_id'] == 3) {
                                                                                     echo 'Rejected';
                                                                                }
                                                                                ?>&nbsp;</td>
                                                                           <td width="10%" align="center" class="gridcellborder" style="cursor: pointer"><img src='/img/card.png' onclick='popup(<?php echo $notification['Invoice']['id']; ?>)'></img> </td>
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


                                                                           function popup(id) {
                                                                                alert('0');
                                                                                var url = '/invoices/view/' + id;
                                                                                var left = (screen.width / 2) - 400;
                                                                                var top = (screen.height / 2) - 360;
                                                                                newwindow = window.open(url, 'name', 'scrollbars=yes');
                                                                                if (window.focus) {
                                                                                     newwindow.focus()
                                                                                }
                                                                                return false;
                                                                           }


</script>