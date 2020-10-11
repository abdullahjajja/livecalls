<div id="maincontent">
<?php echo $this->Form->create('Did');?>

      <div class="mainheading">Edit Number Range</div>
   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table class="addtable">
                            <tr>
                              <td colspan="6" class="h1">Edit DID</td>
                            </tr>

	 <tr>  
<!--    
             <?php// echo $this->Form->input('id'); ?>
	 <td width="34%"><?php//	echo $this->Form->input('numberrange_id');?></td>
	 <td width="34%"><?php//	echo $this->Form->input('did');?></td>
          <td width="34%"><?php//	echo $this->Form->input('IsTestNumber');?></td>
            <td width="34%"><?php// echo $this->Form->input('callduration');?></td>
              <td width="34%"><?php//	echo $this->Form->input('perclilimit');?></td>
           
	<td width="32%">&nbsp;</td>
           </tr>
           
	<tr>
                <td>&nbsp;</td>
                <td></td>
                <td>&nbsp;</td>
                </tr>
  -->
             <?php echo $this->Form->input('id'); ?>
	 <td width="25%" style="height:30px;"><?php	echo $this->Form->input('numberrange_id', array('label' => ' Number Range&nbsp;','style' => 'width:150px;height:20px;margin-top:5px;'));?></td>
	 <td width="13%" style="height:30px;"><?php	echo $this->Form->input('did', array('label' => ' DID&nbsp;','style' => 'width:100px;height:20px;margin-top:5px;'));?></td>
           <td width="17%" style="height:30px;"><?php	echo $this->Form->input('maxdailyminutes', array('label' => ' Daily Max Min&nbsp;','style' => 'width:100px;height:20px;margin-top:5px;'));?></td>
           <td width="17%" style="height:30px;"><?php	echo $this->Form->input('perclilimit', array('label' => ' CLI Limit&nbsp;','style' => 'width:100px;height:20px;margin-top:5px;'));?></td>
           
	<td width="1%" style="height:30px;">&nbsp;</td>
           </tr>
           
	<tr>
         <td width="10%" style="height:30px;"><?php	echo $this->Form->input('IsTestNumber', array('label' => ' Test Number&nbsp;','style' => 'width:100px;height:20px;margin-top:5px;'));?></td>
                <td></td>
                <td colspan="4">&nbsp;</td>
                </tr>
  
  </table></td>
                        </tr>
                      </table>
                      <div style="width:270px;float:right;margin-right:360px;">
<?php echo $form->submit('bt-save.png',array('style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
<a href="../index"> <?php echo $this->Html->image('bt-cancel.png',array('name' => 'cancel','id'=>'cancel','style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:right'))); ?></a>

</div>
<?php echo $form->end(); ?>
</div>
<div class="mainbottomBg"></div>
</div>