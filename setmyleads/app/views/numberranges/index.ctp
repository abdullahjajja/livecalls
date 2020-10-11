<?php $userid = $session->read('Auth.User.role_id') ?>
<script type="text/javascript">
     function searchNumberRange() {
          //alert ("search called");
          var name = $('#rangeNameTxt').val();
          name     = $.trim(name);
          //var nm=document.getElementById("txtuser").text;
          //alert(nm);
          window.location = ("../numberranges/index?name=" + name);
          return;


     }
</script>
<style>
.abutton{
     /*background-color: white;*/
     position: relative;
     float: right;
    color: white;
    border: 2px solid #4CAF50;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    margin-left: 20px;
    }
    .abutton:hover{
     /*background-color: white;*/
     float: right;
    color: red;
    border: 2px solid #4CAF50;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    margin-left: 20px;
    }  
</style>
<div  id="maincontent">


     <fieldset  >
          <legend><?php __('Search Number Range'); ?></legend>
          <?php
          echo $this->Form->input('rangeNameTxt', array('label' => '&nbsp;Range Name&nbsp;&nbsp;', 'class' => 'inputbox132px', 'style' => 'width:100px;'));
          echo $this->Form->submit('bt-search.png', array('type' => 'image', 'style' => 'float:left;margin-left:10px;margin-top:2px;', 'id' => 'btnsearch', 'name' => 'btnsearch', 'onclick' => 'searchNumberRange();'));
          // echo $html->link($html->image("bt-search.png"),  array('controller'=>'users/filteruser'), array('escape' => false,'id' => "btnsearch",'style'=>'float:left;margin-left:10px;margin-top:2px;'));
          ?>
          <?php 
          if($userid == 1){
               echo $this->Html->link(__('Rate List', true), array('action' => 'numberrange_bulk'),array('class' => 'abutton'));
                echo $this->Html->link(__('Random Dids', true), array('action' => 'uploadrandomnumbers'),array('class' => 'abutton'));
                 echo $this->Html->link(__('Random Logs', true), array('action' => 'randnum_log'),array('class' => 'abutton')); 
          }
          ?>
     </fieldset  >

</div>
<div id="maincontent">
     <div class="mainheading" ><div></div><div align="left">Number Range List</div> <div align="right" style="margin-top: -18px" >
    <?php echo $this->Html->link(__('NR Logs', true), array('action' => 'numberrange_log')); ?>
     <?php echo $this->Html->link(__('Delete Orph', true), array('action' => 'delete_orphan_ranges')); ?><a pass = "" href = "payment_terms" style="">Payment Terms </a> <a pass = "" href = "/api/export_numberranges" style="">Export CSV </a> <?php echo $this->Html->link(__('Import CSV', true), array('action' => 'importrange')); ?><?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?></div> </div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="10%" align="left">&nbsp;<?php echo ('Operator'); ?></td>
                                                                 <td width="15%" align="left">&nbsp;<?php echo ('Name'); ?></td>
                                                                 <td width="10%" align="left">&nbsp;<?php echo ('Route'); ?></td>
                                                                 <td width="11%" align="left">&nbsp;<?php echo ('Routetype'); ?></td>
                                                                 <td width="13%" align="left">&nbsp;<?php echo ('Ivrpath'); ?></td>
                                                                 <td width="5%" align="left">&nbsp;<?php echo ('Currency'); ?></td>
                                                                 <td width="5%" align="left">&nbsp;<?php echo ('Buying Rate'); ?></td>
                                                                 <td width="6%" align="left">&nbsp;<?php echo ('Min duration'); ?></td>
                                                                 <td width="6%" align="left">&nbsp;<?php echo ('Max duration'); ?></td>
                                                                 <td width="6%" align="left">&nbsp;<?php echo ('Call Limit'); ?></td>
                                                                 <td width="6%" align="left">&nbsp;<?php echo ('CLI Limit'); ?></td>
                                                                 <td width="7%" align="right"><?php __('Actions'); ?>&nbsp;</td>
                                                            </tr>
                                                       </table></td>
                                             </tr>

                                             <tr>
                                                  <?php
                                                  $i = 0;
                                                  foreach ($numberranges as $numberrange):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
													    App::import('Helper', 'getivrname'); // loadHelper('Html'); in CakePHP 1.1.x.x
														$getivr = new getivrnameHelper();																	  
														$ivrname = $getivr->getIVRName($numberrange['Numberrange']['ivrpath']);
                                                       ?>
                                                       <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr>

                                                                      <td width="10%" align="left" class="gridcellborder">&nbsp;<?php echo $numberrange['Operator']['name']; ?></td>
                                                                      <td width="15%" align="left" class="gridcellborder">&nbsp;
                                                                      <?php 
                                                                      if(strtotime($numberrange['Numberrange']['created']) > strtotime('1 month ago'))
                                                                      { echo $this->Html->image('new.gif'); } echo " ".$numberrange['Numberrange']['name'];
                                                                       ?>

                                                                      </td>
                                                                      <td width="10%" align="left" class="gridcellborder">&nbsp;<?php echo $numberrange['Numberrange']['route']; ?></td>
                                                                      <td width="11%" align="left" class="gridcellborder">&nbsp;<?php echo $numberrange['Routetype']['name']; ?></td>
                                                                      <td width="13%" align="left" class="gridcellborder">&nbsp;<?php echo $ivrname; ?></td>
                                                                      <td width="5%" align="left" class="gridcellborder">&nbsp;<?php echo $numberrange['Currency']['currency_name']; ?></td>
                                                                      <td width="5%" align="right" style="padding-right: 3px;" class="gridcellborder">&nbsp;<?php echo number_format((float)$numberrange['Numberrange']['buyingrate'], 3, '.', ''); ?></td>
                                                                      <td width="6%" align="right" style="padding-right: 3px;" class="gridcellborder">&nbsp;<?php echo $numberrange['Numberrange']['minduraction']; ?></td>
                                                                      <td width="6%" align="right" style="padding-right: 3px;" class="gridcellborder">&nbsp;<?php echo $numberrange['Numberrange']['maxduration']; ?></td>
                                                                      <td width="6%" align="right" style="padding-right: 3px;" class="gridcellborder">&nbsp;<?php echo $numberrange['Numberrange']['calllimit']; ?></td>
                                                                      <td width="6%" align="right" style="padding-right: 3px;" class="gridcellborder">&nbsp;<?php echo $numberrange['Numberrange']['clilimit']; ?></td>
                                                                      <td width="7%" align="right" class="gridcellborder">
                                                                           <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $numberrange['Numberrange']['id'])); ?>
                                                                           <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $numberrange['Numberrange']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $numberrange['Numberrange']['id'])); ?>
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
