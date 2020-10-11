<div class="userNotifications view">
<h2><?php  __('User Notification');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userNotification['UserNotification']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($userNotification['User']['id'], array('controller' => 'users', 'action' => 'view', $userNotification['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Detail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userNotification['UserNotification']['detail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userNotification['UserNotification']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Notification', true), array('action' => 'edit', $userNotification['UserNotification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Notification', true), array('action' => 'delete', $userNotification['UserNotification']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userNotification['UserNotification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Notifications', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Notification', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
