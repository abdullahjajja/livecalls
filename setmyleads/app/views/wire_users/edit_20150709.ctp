<div class="wireUsers form"  style='float:left'>
     <?php echo $this->Form->create('WireUser'); ?>
     <fieldset>
          <legend  style='color: green' ><?php __('Edit Wire User'); ?></legend>
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('name');
          echo $this->Form->input('mobile_number');
          echo $this->Form->input('city_name');
          echo $this->Form->input('state_name');
          echo $this->Form->input('country_name');
          $uid = $this->Session->read('Auth.User.id');
          echo $this->Form->input('user_id', array('default' => $uid, 'type' => 'hidden'));
          echo $this->Form->input('status', array('id' => 'a', 'type' => 'hidden'));
          echo $this->Form->input('status', array('id' => 'a', 'type' => 'hidden', 'default' => 1));
          ?>
     </fieldset>
     <script>
          // $('#a').val('1');
     </script>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
