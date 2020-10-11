<div class="didsUsers index">
	<h2><?php __('Dids Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('did_id');?></th>
			<th><?php echo $this->Paginator->sort('superresseler_id');?></th>
			<th><?php echo $this->Paginator->sort('resseller_id');?></th>
			<th><?php echo $this->Paginator->sort('subresseller_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($didsUsers as $didsUser):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $didsUser['DidsUser']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($didsUser['Did']['id'], array('controller' => 'dids', 'action' => 'view', $didsUser['Did']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($didsUser['Superresseler']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Superresseler']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($didsUser['Resseller']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Resseller']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($didsUser['Subresseller']['id'], array('controller' => 'users', 'action' => 'view', $didsUser['Subresseller']['id'])); ?>
		</td>
		<td><?php echo $didsUser['DidsUser']['created']; ?>&nbsp;</td>
		<td><?php echo $didsUser['DidsUser']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $didsUser['DidsUser']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $didsUser['DidsUser']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $didsUser['DidsUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $didsUser['DidsUser']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Dids User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Dids', true), array('controller' => 'dids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Did', true), array('controller' => 'dids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Superresseler', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>