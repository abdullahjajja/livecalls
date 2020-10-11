<div class="notifications view">
<h2><?php  __('Notification');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notification['Notification']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($notification['User']['id'], array('controller' => 'users', 'action' => 'view', $notification['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Numberrange'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($notification['Numberrange']['name'], array('controller' => 'numberranges', 'action' => 'view', $notification['Numberrange']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notification['Notification']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Assign Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notification['Notification']['assign_total']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Notification', true), array('action' => 'edit', $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Notification', true), array('action' => 'delete', $notification['Notification']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('controller' => 'numberranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add')); ?> </li>
	</ul>
</div>
