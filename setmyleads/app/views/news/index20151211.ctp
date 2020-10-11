<?php $user_role = $this->Session->read('Auth.User.role_id') ?>
<div class="news index">
<!--	<h2><?php __('News'); ?></h2 -->


     <div  id="maincontent">
          <div class="mainheading"><div></div>
               <div align="left">All News</div>
               <div align="right" style="margin-top: -15px" >

                    <?php
                    if ($user_role == 1) {

                         echo $this->Html->link(__('Add New', true), array('action' => 'add',));
                    }
                    ?>
               </div> </div>
          <div class="maincenterBg">
               <table width="100%" border="0" cellspacing="0" cellpadding="10">
                    <tr style="height: auto;">
                         <td align="center" valign="top" style="height: auto;"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                   <tr style="height: auto;">
                                        <td class="gridtable" style="height: auto;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr style="height: auto;">
                                                       <td class="gridtableHeader" style="height: auto;"><table width="100%" h border="0" cellspacing="0" cellpadding="0">
                                                                 <tr style="height: auto;">




                                                                      <td width="70%" style="height: auto;">

                                                                           <?php echo ('Latest News'); ?>

                                                                      </td>

                                                                      <?php if ($user_role == 1) { ?>
                                                                           <td class="actions" width="15%"><?php __('Actions'); ?></td>
                                                                      <?php } ?>

                                                                 </tr>
                                                            </table></td>
                                                  </tr>

                                                  <tr style="height: auto;">



                                                       <?php
                                                       $i = 0;
                                                       foreach ($news as $news):
                                                            $class = ' class="grid1light"';
                                                            if ($i++ % 2 == 0) {
                                                                 $class = ' class="grid1light"';
                                                            }
                                                            ?>
                                                            <td <?php echo $class; ?> style="height: auto;"><table width="100%" border="0" cellspacing="0" cellpadding="10">
                                                                      <tr style="height: auto;">
                                                                      <div class="grid2dark">
                                                                           <div style="float: left;margin-top: 3px;margin-left: 15px;"><strong><?php echo $news['News']['title']; ?></strong></div> <div style="float: right;margin-top: 5px;margin-right: 15px;"><?php echo $news['News']['modified']; ?></div>
                                                                           <div style = "float: left;background: -webkit-linear-gradient(left, rgba(153,84,53,1), rgba(53,84,53,0));background: -o-linear-gradient(right, rgba(53,84,53,1), rgba(53,84,53,0)); background: -moz-linear-gradient(right, rgba(53,84,53,1), rgba(53,84,53,0));background: linear-gradient(to right, rgba(53,84,53,1), rgba(53,84,53,0));;width:95%; height:5px; margin:10px 15px 0px 15px;"></div>
                                                                      </div>
                                                                      <td width = "85%" style="height: auto;">
                                                                           <?php
                                                                           $restult = "";
                                                                           $lng = strlen($news['News']['detail']);
                                                                           //  if ($lng > 10) {
                                                                           //  $restult = substr($news['News']['detail'], 0, 5);
                                                                           //    $restult = $restult . "...";
                                                                           // } else {
                                                                           $restult = $news['News']['detail'];
                                                                           // }
                                                                           ?>

                                                                           <pre style="margin-top: 0px; margin-bottom: 0px;"> <?php echo $restult; ?>&nbsp</pre>  </td>




                                                                      <?php
                                                                      if ($user_role == 1) {
                                                                           echo'<td class="actions" style="text-align: center;"><span>';
                                                                          
                                                                           echo $this->Html->link(__('Edit', true), array('action' => 'edit', $news['News']['id']));
                                                                           echo'</span><span style="margin-left:10px;">';
                                                                           echo $this->Html->link(__('Delete', true), array('action' => 'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id']));
                                                                           echo '</span></td>';
                                                                      }
                                                                      ?>


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
          </div>

          <div class="mainbottomBg"></div>
