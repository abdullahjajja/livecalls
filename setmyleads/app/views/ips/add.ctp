<div id="maincontent">
     <?php echo $this->Form->create('Ips'); ?>
     <div class="mainheading">Add New IPS</div>
     <div class="maincenterBg">
          <div class="ips form">
               <?php echo $this->Form->create('Ip'); ?>

               <fieldset style="margin-top: 20px">
                    <legend><?php __('Add  Ip'); ?></legend>
                    <?php
                    echo $this->Form->input('owner_name', array('label' => 'Owner Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'margin-top:20px'));
                    echo $this->Form->input('ip_address', array('label' => 'Ip Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'margin-top:20px'));
                    ?>
               </fieldset>

          </div>
          <div style="width:270px;margin-left:50px; margin-top: 15px;padding-bottom: 15px;">
               <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
          </div>
     </div>

     <div class="mainbottomBg"></div>
</div>