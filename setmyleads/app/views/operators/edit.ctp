<div id="maincontent">
     <?php echo $this->Form->create('Operator'); ?>
     <div class="mainheading">Edit Operator</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table class="addtable">
                              <tr>
                                   <td colspan="3" class="h1">Edit Operator</td>
                              </tr>

                              <tr>
                                   <?php echo $this->Form->input('id'); ?>
                                   <td width="25%"></td>
                                   <td width="50%"><?php echo $this->Form->input('name', array('label' => 'Operator Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?></td>
                                   <td width="25%">&nbsp</td>
                              </tr>
                              <tr>
                                   <td> </td>
                                   <td>&nbsp;</td>
                                   <td  >&nbsp;</td>
                              </tr>
                              <tr>
                                   <td width="34%"></td>
                                   <td width="34%"><?php echo $this->Form->input('alphabet', array('label' => 'Operator Alphabet&nbsp;&nbsp;')); ?></td>
                                   <td width="32%">&nbsp</td>
                              </tr>

                              <tr>
                                   <td></td>
                                   <td>&nbsp;</td>
                                   <td  >&nbsp;</td>
                              </tr>
                              <tr>

                                   <td width="25%"></td>
                                   <td width="50%"><?php
                                        $options = array(
                                            '1' => 'Weekly',
                                            '0' => 'Monthly'
                                        );


                                        echo $this->Form->radio('isweekly', $options, array('legend' => 'Payment Terms'));
                                        ?></td>
                              <tr>
                                   <td width="25%"></td>
                                   <td width="50%"><?php echo $this->Form->input('usd_account', array('label' => 'USD Account&nbsp;&nbsp;', 'type' => 'textarea', 'style' => 'width:500px;margin-left:10px;')); ?></td>
                                   <td width="25%">&nbsp</td>
                              </tr>
                              <tr>
                                   <td width="25%"></td>
                                   <td width="50%"><?php echo $this->Form->input('euro_account', array('label' => 'EURO Account&nbsp;&nbsp;', 'type' => 'textarea', 'style' => 'width:500px;margin-left:10px;')); ?></td>
                                   <td width="25%">&nbsp</td>
                              </tr>
                              <tr>
                                   <td width="25%"></td>
                                   <td width="50%"><?php echo $this->Form->input('gbp_account', array('label' => 'GBP Account&nbsp;&nbsp;', 'type' => 'textarea', 'style' => 'width:500px;margin-left:10px;')); ?></td>
                                   <td width="25%">&nbsp</td>
                              </tr>
                              <td width="32%">&nbsp</td>
               </tr>
          </table></td>
          </tr>
          </table>
          <div style="width:270px;float:right;margin-right:357px;">
               <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
               <a href="../index"> <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:right'))); ?></a>

          </div>
          <?php echo $form->end(); ?>
     </div>
     <div class="mainbottomBg"></div>
</div>