<div class="ips view">
<h2><?php  __('Ip');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ip['Ip']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Owner Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ip['Ip']['owner_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ip Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ip['Ip']['ip_address']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ip', true), array('action' => 'edit', $ip['Ip']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ip', true), array('action' => 'delete', $ip['Ip']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ip['Ip']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ips', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ip', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
