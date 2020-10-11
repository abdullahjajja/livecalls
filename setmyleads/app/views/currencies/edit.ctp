<div id="maincontent">
<?php echo $this->Form->create('Currency');?>
<div class="mainheading">Edit Currency</div>
   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table class="addtable">
                            <tr>
                              <td colspan="3" class="h1">Edit Currency</td>
                            </tr>
                         
	    <tr>   
	<?php
		echo $this->Form->input('id');
                ?>
                
                
	<td> <?php	echo $this->Form->input('currency_name'); ?>
		<td> <?php echo $this->Form->input('symbol');?>
		<td> <?php echo $this->Form->input('rate');?>
</tr>
                                           
                      </table></td></tr></table>
       
       <div style="width:270px;float:right;margin-right:357px;">
	

<?php echo $form->submit('bt-save.png',array('style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
<a href="../index"> <?php echo $this->Html->image('bt-cancel.png',array('name' => 'cancel','id'=>'cancel','style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:right'))); ?></a>

</div>
<?php echo $form->end(); ?>
                  </div>   
  <div class="mainbottomBg"></div>
</div>