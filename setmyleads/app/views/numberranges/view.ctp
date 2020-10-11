<div class="numberranges view">
<h2><?php  __('Numberrange');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $numberrange['Numberrange']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $numberrange['Numberrange']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Operator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($numberrange['Operator']['name'], array('controller' => 'operators', 'action' => 'view', $numberrange['Operator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Route'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $numberrange['Numberrange']['route']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Routetype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($numberrange['Routetype']['name'], array('controller' => 'routetypes', 'action' => 'view', $numberrange['Routetype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $numberrange['Numberrange']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $numberrange['Numberrange']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Numberrange', true), array('action' => 'edit', $numberrange['Numberrange']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Numberrange', true), array('action' => 'delete', $numberrange['Numberrange']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $numberrange['Numberrange']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Operators', true), array('controller' => 'operators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operator', true), array('controller' => 'operators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Routetypes', true), array('controller' => 'routetypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Routetype', true), array('controller' => 'routetypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Dids');?></h3>
	<?php if (!empty($numberrange['Did'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Numberrange Id'); ?></th>
		<th><?php __('Did'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($numberrange['Did'] as $did):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $did['id'];?></td>
			<td><?php echo $did['numberrange_id'];?></td>
			<td><?php echo $did['did'];?></td>
			<td><?php echo $did['created'];?></td>
			<td><?php echo $did['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'dids', 'action' => 'view', $did['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'dids', 'action' => 'edit', $did['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'dids', 'action' => 'delete', $did['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $did['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
