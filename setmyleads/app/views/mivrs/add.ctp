<style>
     .field{

          border-bottom: 1.5px solid whitesmoke;


          margin-bottom: 7px;
          margin-top: 7px;
     }
     .mivrs form{
          border: 2.5px solid whitesmoke;
          margin-right: 30px;
          margin-top: 20px;
          width: 50%;
     }
</style>
<div id="maincontent">

     <div class="mainheading">Add New MIVR</div>
     <div class="maincenterBg">
          <div class="mivrs form" style="margin-left: 30px;">
               <?php echo $this->Form->create('Mivr', array('type' => 'file')); ?>

               <?php
               echo $this->Form->input('name', array('label' => 'Playback name', 'style' => ' margin-left:15px;margin-top:10px; width:200px;height:25px;', 'required' => 'requird'));
               // echo "<td width=\"50%\">" . $this->Form->input('ivr_name', array('label' => 'IVR Name&nbsp;', 'type' => 'file')) . "</td>";
               //echo "<td width=\"50%\">" . $this->Form->input('ivr_uploaded_name', array('label' => '', 'style' => 'display:none;')) . "</td>";
               echo "<div class='field'></div>";

               echo $this->Form->input('0', array('label' => ' Starting IVR&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('1', array('label' => 'IVR Track 1&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('2', array('label' => 'IVR Track 2&nbsp;', 'type' => 'file', 'style' => 'margin-left:25px', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('3', array('label' => 'IVR Track 3&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('4', array('label' => 'IVR Track 4&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('5', array('label' => 'IVR Track 5&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('6', array('label' => 'IVR Track 6&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('7', array('label' => 'IVR Track 7&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('8', array('label' => 'IVR Track 8&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('9', array('label' => 'IVR Track 9&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));
               echo "<div class='field'></div>";
               echo $this->Form->input('10', array('label' => 'IVR Track 10&nbsp;', 'type' => 'file', 'style' => ' margin-left:25px;', 'required' => 'requird'));

               echo "<div class='field'></div>";
               //echo $this->Form->input('4');
               //echo $this->Form->input('5');
               //echo $this->Form->input('6');
               //echo $this->Form->input('7');
               //echo $this->Form->input('8');
               //echo $this->Form->input('9');
               //echo $this->Form->input('10');
               ?>

               <div style="width:270px;margin-left:15px; margin-top: 2px;padding-bottom: 30px;">
                    <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
               </div>
          </div>
          <div class="actions">
               <h3><?php __('Actions'); ?></h3>
               <ul>

                    <li><?php echo $this->Html->link(__('List Mivrs', true), array('action' => 'index')); ?></li>
               </ul>
          </div>
     </div>
</div>
