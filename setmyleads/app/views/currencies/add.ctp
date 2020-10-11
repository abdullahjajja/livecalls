<div id="maincontent">
<?php echo $this->Form->create('Currency');?>
<div class="mainheading">Add New Currency</div>
   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table class="addtable">
                            <tr>
                              <td colspan="3" class="h1">Add Currency</td>
                            </tr>
                         
	 <tr>                
	<td ></td>
	
		<td><?php echo $this->Form->input('currency_name'); ?></td>
		<td><?php echo $this->Form->input('symbol');?></td>
		 <td><?php echo $this->Form->input('rate');?></td>
	
	
</tr>
	</table></td>
                        </tr>
                      </table>
<div style="width:270px;float:right;margin-right:357px;">
<?php echo $form->submit('bt-save.png',array('style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
<a href="index"> <?php echo $this->Html->image('bt-cancel.png',array('name' => 'cancel','id'=>'cancel','style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:right'))); ?></a>

</div>
<?php echo $form->end(); ?>
                  </div>   
 <div class="mainbottomBg"></div>
</div>