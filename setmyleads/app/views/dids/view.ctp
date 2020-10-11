<div class="dids view">
<h2><?php  __('Did');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $did['Did']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Numberrange'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($did['Numberrange']['name'], array('controller' => 'numberranges', 'action' => 'view', $did['Numberrange']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Did'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $did['Did']['did']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $did['Did']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $did['Did']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Did', true), array('action' => 'edit', $did['Did']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Did', true), array('action' => 'delete', $did['Did']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $did['Did']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('controller' => 'numberranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add')); ?> </li>
	</ul>
</div>
