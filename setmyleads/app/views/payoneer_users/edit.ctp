<div class="payoneerUsers form" style="float: left">
     <?php echo $this->Form->create('PayoneerUser'); ?>
     <fieldset>
          <legend style='color: green'><?php __('Edit Payoneer User'); ?></legend>
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('name');
          echo $this->Form->input('card_number');
          echo $this->Form->input('date_expiry');
          $uid = $this->Session->read('Auth.User.id');
          echo $this->Form->input('status', array('id' => 'a', 'type' => 'hidden'));
          echo $this->Form->input('user_id', array('default' => $uid, 'type' => 'hidden'));
          ?>
     </fieldset>
     <script>
          $('#a').val('1');
     </script>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
