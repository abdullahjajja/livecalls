<div class="accountsUsers form" style="float: left">
     <?php echo $this->Form->create('AccountsUser'); ?>
     <fieldset>
          <legend style='color: green'><?php __('Edit Yours ' . ($cc['Currency']['currency_name']) . ' Account'); ?></legend>
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('beneficiary_name');
          echo $this->Form->input('beneficiary_address');
          echo $this->Form->input('bank_name');
          echo $this->Form->input('bank_address');
          echo $this->Form->input('swift_code');
          echo $this->Form->input('iban');
          echo $this->Form->input('account_number');
          echo $this->Form->input('city_name');
          echo $this->Form->input('state_name');
          echo $this->Form->input('country_name');

          echo $this->Form->input('user_id', array('type' => 'hidden'));
          echo $this->Form->input('status', array('id' => 'a', 'type' => 'hidden', 'default' => 1));
          ?>
     </fieldset>
     <script>
          $('#a').val('1');
     </script>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
