<div class="invoices form" style='float:right'>
     <?php echo $this->Form->create('Invoice'); ?>
     <fieldset>
          <legend><?php __('Edit Invoice'); ?></legend>
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('user_id');
          echo $this->Form->input('numberrange_id');
          echo $this->Form->input('currency_id');
          echo $this->Form->input('invoice_status_id');
          echo $this->Form->input('date');
          echo $this->Form->input('minutes');
          echo $this->Form->input('rate');
          echo $this->Form->input('invoice_total');
          ?>
     </fieldset>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
