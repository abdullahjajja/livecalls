<div class="didrates form">
<?php echo $this->Form->create('Didrate');?>
	<fieldset>
		<legend><?php __('Add Didrate'); ?></legend>
	<?php
		echo $this->Form->input('did_id');
		echo $this->Form->input('adminbuyrate');
		echo $this->Form->input('adminsellrate');
		echo $this->Form->input('superresrate');
		echo $this->Form->input('ressellerrate');
		echo $this->Form->input('subresrate');
		echo $this->Form->input('assignedBy');
		echo $this->Form->input('currency_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Didrates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies', true), array('controller' => 'currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Currency', true), array('controller' => 'currencies', 'action' => 'add')); ?> </li>
	</ul>
</div>