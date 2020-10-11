<div  id="maincontent">
    <?php echo $this->Form->create('Numberrange'); ?>

    <div class="mainheading">Upload Random Numbers
    </div>
    <div class="maincenterBg">
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td align="left" valign="top"><table class="addtable">
                        <tr>
                            <td colspan="3" class="h1">Random Dids Upload</td>
                        </tr>
                        <tr>  
                            <td width="34%"> <?php echo $this->Form->input('numberrange_id',array('label'=> 'Number Range')); ?> </td>
                            <td width="20%">
                                <?php echo $this->Form->input('didrangestart', array('label' => 'Range Start&nbsp;&nbsp;', 'class' => 'inputbox132px required')); ?>
                            </td>
                            <td width="20%"> <?php echo $this->Form->input('didrangeend', array('label' => '&nbsp;Range End&nbsp;&nbsp;', 'class' => 'inputbox132px required')); ?></td>

                             <td width="20%"> <?php echo $this->Form->input('rangeqty', array('label' => '&nbsp;Quantity&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;', 'class' => 'inputbox132px required')); ?></td>
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


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
     $(function(){
          $( "#NumberrangeUploadrandomnumbersForm" ).validate({
            rules: {
              "data[Numberrange][didrangestart]": {
                required: true,
                digits: true,
                minlength: 4
              },
              "data[Numberrange][didrangeend]": {
                required: true,
                digits: true,
                minlength: 4
              },
              "data[Numberrange][rangeqty]": {
                required: true,
                digits: true,
              }
            }
          });
     })
</script>