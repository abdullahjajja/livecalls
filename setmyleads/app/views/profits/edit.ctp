<div class="profits form">
<?php echo $this->Form->create('Profit');?>
	<fieldset>
		<legend><?php __('Edit Profit'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('date');
		echo $this->Form->input('operator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Profit.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Profit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Profits', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Operators', true), array('controller' => 'operators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operator', true), array('controller' => 'operators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profit Details', true), array('controller' => 'profit_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profit Detail', true), array('controller' => 'profit_details', 'action' => 'add')); ?> </li>
	</ul>
</div>