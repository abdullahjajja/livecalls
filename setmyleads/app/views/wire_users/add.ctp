<div class="wireUsers form" style='float:left'>
     <?php echo $this->Form->create('WireUser'); ?>
     <fieldset>
          <legend style='color: green'><?php __('Add Wire User'); ?></legend>
          <?php
          echo $this->Form->input('name');
          echo $this->Form->input('mobile_number');
          echo $this->Form->input('country_id');
          echo $this->Form->input('state_id');
          echo $this->Form->input('city_id');
          $uid = $this->Session->read('Auth.User.id');
          echo $this->Form->input('user_id', array('default' => $uid, 'type' => 'hidden'));
          ?>
     </fieldset>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
