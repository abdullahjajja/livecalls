<div class="didsUsers form">
<?php echo $this->Form->create('DidsUser');?>
	<fieldset>
		<legend><?php __('Edit Dids User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('did_id');
		echo $this->Form->input('superresseler_id');
		echo $this->Form->input('resseller_id');
		echo $this->Form->input('subresseller_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('DidsUser.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('DidsUser.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dids Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Superresseler', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>