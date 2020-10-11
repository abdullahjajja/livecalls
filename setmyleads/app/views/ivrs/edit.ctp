<div id="maincontent">

     <div class="mainheading">Edit IVR</div>
     <div class="maincenterBg">
          <div class="ivrs form">
               <?php echo $this->Form->create('Ivr'); ?>
               <div style="float: left; width: 500px" >


                    <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('ivr_name', array('style' => 'margin-left: 75px; margin-top:10px', 'label' => '&nbsp;&nbsp;&nbsp;&nbsp;IVR Name'));
                    ?>

                    <div style="width:270px;margin-left:50px; margin-top: 30px;padding-bottom: 30px;">
                         <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
                         <a href="../index"> <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:right'))); ?></a>
                    </div>
               </div>
          </div>
     </div>
