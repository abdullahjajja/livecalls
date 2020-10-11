<div class="routetypes view">
<h2><?php  __('Routetype');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $routetype['Routetype']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $routetype['Routetype']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Routetype', true), array('action' => 'edit', $routetype['Routetype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Routetype', true), array('action' => 'delete', $routetype['Routetype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $routetype['Routetype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Routetypes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Routetype', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
