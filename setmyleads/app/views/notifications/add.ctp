<div class="notifications form">
<?php echo $this->Form->create('Notification');?>
	<fieldset>
		<legend><?php __('Add Notification'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('numberrange_id');
		echo $this->Form->input('status');
		echo $this->Form->input('assign_total');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Notifications', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('controller' => 'numberranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add')); ?> </li>
	</ul>
</div>