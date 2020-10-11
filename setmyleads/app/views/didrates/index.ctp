<div class="didrates index">
	<h2><?php __('Didrates');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('did_id');?></th>
			<th><?php echo $this->Paginator->sort('adminbuyrate');?></th>
			<th><?php echo $this->Paginator->sort('adminsellrate');?></th>
			<th><?php echo $this->Paginator->sort('superresrate');?></th>
			<th><?php echo $this->Paginator->sort('ressellerrate');?></th>
			<th><?php echo $this->Paginator->sort('subresrate');?></th>
			<th><?php echo $this->Paginator->sort('assignedBy');?></th>
			<th><?php echo $this->Paginator->sort('currency_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($didrates as $didrate):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $didrate['Didrate']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($didrate['Did']['id'], array('controller' => 'dids', 'action' => 'view', $didrate['Did']['id'])); ?>
		</td>
		<td><?php echo $didrate['Didrate']['adminbuyrate']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['adminsellrate']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['superresrate']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['ressellerrate']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['subresrate']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['assignedBy']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($didrate['Currency']['id'], array('controller' => 'currencies', 'action' => 'view', $didrate['Currency']['id'])); ?>
		</td>
		<td><?php echo $didrate['Didrate']['created']; ?>&nbsp;</td>
		<td><?php echo $didrate['Didrate']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $didrate['Didrate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $didrate['Didrate']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $didrate['Didrate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $didrate['Didrate']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Didrate', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies', true), array('controller' => 'currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Currency', true), array('controller' => 'currencies', 'action' => 'add')); ?> </li>
	</ul>
</div>