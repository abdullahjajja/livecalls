<div class="operatorInvoices form">
     <?php echo $this->Form->create('OperatorInvoice'); ?>
     <fieldset>
          <legend><?php __('Add Operator Invoice'); ?></legend>
          <?php
          echo $this->Form->input('invoice_status_id');
          echo $this->Form->input('date');
          echo $this->Form->input('operator_id');
          ?>
     </fieldset>
     <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
