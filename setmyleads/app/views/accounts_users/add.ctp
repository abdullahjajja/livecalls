<div class="accountsUsers form" style="float: left">
     <div class="mainheading">Add Back Account <div align="right" style="margin-top: -15px" ></div> </div>
     <?php echo $this->Form->create('AccountsUser'); ?>
     <fieldset>


          <?php
          echo $this->Form->input('beneficiary_name');

          echo $this->Form->input('beneficiary_address');
          echo $this->Form->input('bank_name');
          echo $this->Form->input('bank_address');
          echo $this->Form->input('swift_code');
          echo $this->Form->input('iban');
          echo $this->Form->input('account_number');
          echo $this->Form->input('comment');
          echo $this->Form->input('currency_id');
          echo $this->Form->input('city');
          echo $this->Form->input('state');
          echo $this->Form->input('country');

          $uid = $this->Session->read('Auth.User.id');
          echo $this->Form->input('user_id', array('default' => $uid, 'type' => 'hidden'));
          ?>
     </fieldset>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
