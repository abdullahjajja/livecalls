<!--
<div class="ivrs form">
<?php //echo $this->Form->create('Ivr');?>
      <fieldset>
            <legend><?php // __('Add Ivr');  ?></legend>
<?php
//		echo $this->Form->input('ivr_name');
//		echo $this->Form->input('ivr_uploaded_name');
?>
      </fieldset>
<?php //echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
      <h3><?php // __('Actions');  ?></h3>
      <ul>

            <li><?php // echo $this->Html->link(__('List Ivrs', true), array('action' => 'index')); ?></li>
      </ul>
</div>
-->


<div id="maincontent">

     <div class="mainheading">Add New IVR</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table class="addtable" border="0">
                              <tr>
                                   <td colspan="3">
                                        <?php //echo $this->Form->create('Ivr');?>
                                        <?php echo $this->Form->create('Ivr', array('type' => 'file')); ?>
                                        <fieldset>
                                             <legend><?php __('Add Ivr'); ?></legend>
                                             <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                  <tr>
                                                       <?php
                                                       echo "<td width=\"50%\">" . $this->Form->input('ivr_name', array('label' => 'IVR Name&nbsp;', 'type' => 'file')) . "</td>";
                                                       echo "<td width=\"50%\">" . $this->Form->input('ivr_uploaded_name', array('label' => '', 'style' => 'display:none;')) . "</td>";
                                                       ?>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2"> <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?></td>
                                                  </tr>
                                             </table>
                                        </fieldset>
                                   </td></tr></table>
                    </td></tr></table>


     </div>