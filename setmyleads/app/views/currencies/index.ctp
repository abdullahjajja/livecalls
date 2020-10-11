<div class="currencies index">
	<div  id="maincontent">
    <div class="mainheading"><div></div>
   <div align="left">All Currencies</div> 
   <div align="right" style="margin-top: -15px" >
    <?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?>
   </div> </div>
	   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>

			
			<td width="15%"><?php echo $this->Paginator->sort('currency_name');?></td>
			<td width="15%"><?php echo $this->Paginator->sort('symbol');?></td>
			<td width="15%"><?php echo $this->Paginator->sort('rate');?></td>
			<td width="15%"><?php echo $this->Paginator->sort('created');?></td>
			<td width="15%"><?php echo $this->Paginator->sort('modified');?></td>
			<td class="actions" width="15%"><?php __('Actions');?></td>
	</tr>
                                  </table></td>
                                </tr>
                                
                                  <tr>
	<?php
	$i = 0;
	foreach ($currencies as $currency):
		$class =' class="grid2dark"' ;
		if ($i++ % 2 == 0) {
			$class = ' class="grid1light"';
		}
	?>
	<td <?php echo $class;?>><table width="100%" border="0" cellspacing="0" cellpadding="10">
		
		<td width="15%"><?php echo $currency['Currency']['currency_name']; ?>&nbsp;</td>
		<td width="15%"><?php echo $currency['Currency']['symbol']; ?>&nbsp;</td>
		<td width="15%"><?php echo $currency['Currency']['rate']; ?>&nbsp;</td>
		<td width="15%"><?php echo $currency['Currency']['created']; ?>&nbsp;</td>
		<td width="15%"><?php echo $currency['Currency']['modified']; ?>&nbsp;</td>
		<td class="actions" width="15%">
			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $currency['Currency']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $currency['Currency']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $currency['Currency']['id'])); ?>
		</td>
	</tr>
                         </table></td>
                                </tr>
<?php endforeach; ?>
	 </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
               
               
            <div style="text-align:center">   
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
        </div>
        
         <div class="mainbottomBg"></div>
 