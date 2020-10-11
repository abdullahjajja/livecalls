<div class="ivrs view">
<h2><?php  __('Ivr');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ivr['Ivr']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ivr Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ivr['Ivr']['ivr_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ivr Uploaded Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ivr['Ivr']['ivr_uploaded_name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ivr', true), array('action' => 'edit', $ivr['Ivr']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ivr', true), array('action' => 'delete', $ivr['Ivr']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ivr['Ivr']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ivrs', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ivr', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
