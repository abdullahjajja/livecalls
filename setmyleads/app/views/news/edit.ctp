<div id="maincontent">
     <?php echo $this->Form->create('News'); ?>
     <div class="mainheading">Edit News</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="center" valign="top"><table class="addtable">
                              <tr>
                                   <td colspan="3" class="h1">Add News</td>
                              </tr>

                              <tr>


                                   <td width="33%"><?php echo $this->Form->input('title', array('label' => 'Title&nbsp;&nbsp;', 'style' => 'margin-left:8px;')); ?> </td>
                              </tr>
                              <tr>
                                   <td width="33%"><?php echo $this->Form->input('detail', array('label' => 'Detail&nbsp;&nbsp;', 'class' => 'jqte-test', 'cols' => '80')); ?></td>
                              </tr>
                              <tr>
                                   <td width="33%"> <b>Status</b>  <?php echo $this->Form->input('status', array('label' => '', 'div' => false)); ?></td>
                              </tr>
                         </table></td>
               </tr>
          </table>

          <div style="width:270px;float:left;margin-left:125px;">


               <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
               <a href="../index"> <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:right'))); ?></a>

          </div>
          <?php echo $form->end(); ?>
     </div>
     <div class="mainbottomBg"></div>
</div>
<script>
     //$('.jqte-test').jqte();

     // settings of status
     var jqteStatus = true;
     $(".status").click(function()
     {
          jqteStatus = jqteStatus ? false : true;
          $('.jqte-test').jqte({"status": jqteStatus})
     });
</script>