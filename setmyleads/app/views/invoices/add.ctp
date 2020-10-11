<div class="invoices form">
<?php echo $this->Form->create('Invoice');?>
	<fieldset>
		<legend><?php __('Add Invoice'); ?></legend>
	<?php
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Invoices', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('controller' => 'numberranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies', true), array('controller' => 'currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Currency', true), array('controller' => 'currencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Statuses', true), array('controller' => 'invoice_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Status', true), array('controller' => 'invoice_statuses', 'action' => 'add')); ?> </li>
	</ul>
</div>