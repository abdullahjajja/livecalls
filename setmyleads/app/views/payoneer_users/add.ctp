<div class="payoneerUsers form">
     <?php echo $this->Form->create('PayoneerUser'); ?>
     <fieldset>
          <legend><?php __('Add Payoneer User'); ?></legend>
          <?php
          echo $this->Form->input('name');
          echo $this->Form->input('card_number');
          echo $this->Form->input('date_expiry');
          $uid = $this->Session->read('Auth.User.id');
          echo $this->Form->input('user_id', array('default' => $uid, 'type' => 'hidden'));
          ?>
     </fieldset>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
