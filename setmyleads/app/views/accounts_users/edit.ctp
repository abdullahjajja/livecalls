<div class="accountsUsers form" style="float: left">
     <?php echo $this->Form->create('AccountsUser'); ?>
     <fieldset>
          <legend style='color: green'><?php __('Edit Yours ' . ($cc['Currency']['currency_name']) . ' Account'); ?></legend>
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('beneficiary_name',array('placeholder'=>"Your's Name", 'required' => 'requird'));
          echo $this->Form->input('beneficiary_address',array('placeholder'=>"Your's Adress"));
          echo $this->Form->input('bank_name',array('placeholder'=>"Your's Bank Name", 'required' => 'requird'));
          echo $this->Form->input('bank_address',array('placeholder'=>"Your's Bank Address"));
          echo $this->Form->input('swift_code',array('placeholder'=>"Your's SWIFT Code"));
          echo $this->Form->input('iban',array('placeholder'=>"Your's IBAN number", 'required' => 'requird'));
          echo $this->Form->input('account_number',array('placeholder'=>"Your's Account Number"));
          echo $this->Form->input('city_name',array('placeholder'=>"Your's City Name"));
          echo $this->Form->input('state_name',array('placeholder'=>"Your's State Name"));
          echo $this->Form->input('country_name',array('placeholder'=>"Your's Country Name"));

          echo $this->Form->input('user_id', array('type' => 'hidden'));
          echo $this->Form->input('status', array('id' => 'a', 'type' => 'hidden', 'default' => 1));
          ?>
     </fieldset>
     <script>
          $('#a').val('1');
     </script>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
