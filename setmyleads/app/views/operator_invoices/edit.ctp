<div class="operatorInvoices form">
<?php echo $this->Form->create('OperatorInvoice');?>
	<fieldset>
		<legend><?php __('Edit Operator Invoice'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('invoice_status_id');
		echo $this->Form->input('date');
		echo $this->Form->input('operator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('OperatorInvoice.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('OperatorInvoice.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Operator Invoices', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Invoice Statuses', true), array('controller' => 'invoice_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Status', true), array('controller' => 'invoice_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Operators', true), array('controller' => 'operators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operator', true), array('controller' => 'operators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Operator Invoice Details', true), array('controller' => 'operator_invoice_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operator Invoice Detail', true), array('controller' => 'operator_invoice_details', 'action' => 'add')); ?> </li>
	</ul>
</div>