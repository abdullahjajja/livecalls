<div class="operators view">
<h2><?php  __('Operator');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $operator['Operator']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $operator['Operator']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Operator', true), array('action' => 'edit', $operator['Operator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Operator', true), array('action' => 'delete', $operator['Operator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $operator['Operator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Operators', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Operator', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Numberranges', true), array('controller' => 'numberranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Numberranges');?></h3>
	<?php if (!empty($operator['Numberrange'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Number Ranges'); ?></th>
		<th><?php __('Operator Id'); ?></th>
		<th><?php __('Route'); ?></th>
		<th><?php __('Routetype Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($operator['Numberrange'] as $numberrange):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $numberrange['id'];?></td>
			<td><?php echo $numberrange['number_ranges'];?></td>
			<td><?php echo $numberrange['operator_id'];?></td>
			<td><?php echo $numberrange['route'];?></td>
			<td><?php echo $numberrange['routetype_id'];?></td>
			<td><?php echo $numberrange['created'];?></td>
			<td><?php echo $numberrange['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'numberranges', 'action' => 'view', $numberrange['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'numberranges', 'action' => 'edit', $numberrange['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'numberranges', 'action' => 'delete', $numberrange['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $numberrange['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Numberrange', true), array('controller' => 'numberranges', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
