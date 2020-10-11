<div class="didsUsers view">
<h2><?php  __('Dids User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $didsUser['DidsUser']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Did'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($didsUser['Did']['id'], array('controller' => 'dids', 'action' => 'view', $didsUser['Did']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Superresseler'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($didsUser['Superresseler']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Superresseler']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resseller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($didsUser['Resseller']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Resseller']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subresseller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($didsUser['Subresseller']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Subresseller']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $didsUser['DidsUser']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $didsUser['DidsUser']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dids User', true), array('action' => 'edit', $didsUser['DidsUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Dids User', true), array('action' => 'delete', $didsUser['DidsUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $didsUser['DidsUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dids Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dids User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Superresseler', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
