<div  id="maincontent">
    <?php echo $this->Form->create('Did', array('type' => 'file')); ?>

    <div class="mainheading">Import CSV DID(s)</div>
    <div class="maincenterBg">
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td align="left" valign="top"><table class="addtable">
                        <tr>
                            <td colspan="3" class="h1">Import</td>
                        </tr>
                        <tr>  
                            <td width="34%"> <?php echo $this->Form->input('numberrange_id',array('label'=> 'Number Range')); ?> </td>
                            <td width="34%"> <div>
                                  <?php echo $this->Form->label('Browse File');?>
                                    &nbsp; <br>
                                    <?php echo $this->Form->file('did', array('type' => 'file')); ?>
                            </td>
                            <td width="32%">&nbsp;</td>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td  >&nbsp; </td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <div style="width:270px;float:right;margin-right:396px;">
<?php echo $form->submit('bt-save.png',array('style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
<a href="index"> <?php echo $this->Html->image('bt-cancel.png',array('name' => 'cancel','id'=>'cancel','style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:right'))); ?></a>

</div>
<?php echo $form->end(); ?>
    </div>
  <div class="mainbottomBg"></div>
</div>