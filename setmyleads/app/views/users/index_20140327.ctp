<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
  function searchuser(){   
      //alert ("search called");
      var nm=$('#Usertxt').val();
        //var nm=document.getElementById("txtuser").text;
      //alert(nm);
      window.location=("../users/index?id="+nm);
      return;
             
      
  } 
</script>
<div  id="maincontent">
    <fieldset  > 
    <legend><?php __('Search User'); ?></legend>
           <?php  
             echo $this->Form->input('Usertxt',array('label'=>'&nbsp;User&nbsp;&nbsp;','class'=>'inputbox132px','style'=>'width:100px;'));
             echo $this->Form->submit('bt-search.png', array('type'=>'image', 'style'=>'float:left;margin-left:10px;margin-top:2px;', 'id'=>'btnsearch', 'name'=>'btnsearch','onclick'=>'searchuser();'));
             
            //echo $html->link($html->image("bt-search.png"),  array('controller'=>'users/filteruser'), array('escape' => false,'id' => "btnsearch",'style'=>'float:left;margin-left:10px;margin-top:2px;'));
             
             
             
            ?>
     </fieldset  >
</div>    
  <div  id="maincontent">  
    <div class="mainheading"><div></div><div align="left">Users List</div> <div align="right" style="margin-top: -15px" ><?php if($userrole != 4){  echo $this->Html->link(__('Add New', true), array('action' => 'add')); }?></div>
    
    </div>
	   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
			
			<td width="10%" align="left" style="padding-left:10px; "><?php echo ('Login');?></td>
			<td width="10%" align="left"><?php echo ('Password');?></td>
			<td width="10%" align="left"><?php echo ('First Name');?></td>
			<td width="10%" align="left"><?php echo ('Last Name');?></td>
			<td width="20%" align="left"><?php echo ('Email');?></td>
<!--
			<td width="8%" align="center"><?php echo ('Phone');?></td>			

			<td width="7%" align="center"><?php echo $this->Paginator->sort('country_id');?></td>
			<td width="7%" align="center"><?php echo $this->Paginator->sort('state_id');?></td>
			<td width="7%" align="center"><?php echo $this->Paginator->sort('city_id');?></td>
-->
			<td width="10%" align="right" style="padding-right:20px;"><?php echo ('Role');?></td>			
			<td width="15%" align="right" style="padding-right:10px;"><?php __('Actions');?></td>
                          </tr>
                                  </table></td>
                                </tr>
                                
                                  <tr>
                        
	<?php
	$i = 0;
	foreach ($users as $user):
		$class =' class="grid2dark"' ;
		if ($i++ % 2 == 0) {
			$class = ' class="grid1light"';
		}
	?>
           <td <?php echo $class;?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
		
		<td width="10%" align="left" class="gridcellborder" style="padding-left:10px;"><?php echo $user['User']['login']; ?></td>
		<td width="10%" align="left" class="gridcellborder"><?php echo $user['User']['password']; ?></td>
		<td width="10%" align="left" class="gridcellborder"><?php echo $user['User']['first_name']; ?></td>
		<td width="10%" align="left" class="gridcellborder"><?php echo $user['User']['last_name']; ?></td>
		<td width="20%" align="left" class="gridcellborder"><?php echo $user['User']['email']; ?></td>
<!--
		<td width="8%" align="center" class="gridcellborder"><?php echo $user['User']['phone']; ?></td>	

	
		<td width="7%" align="center" class="gridcellborder">
			<?php echo $user['Country']['name']; ?>
		</td>
		<td width="7%" align="center" class="gridcellborder">
			<?php echo $user['State']['name']; ?>
		</td>
		<td width="7%" align="center" class="gridcellborder">
		      <?php echo $user['City']['name']; ?>
		</td>
-->

		<td width="10%" align="right" class="gridcellborder">
			<?php echo $user['Role']['name']; ?>
		</td>
		
		<td width="15%" align="right" class="gridcellborder" style="padding-right:10px;">			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
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

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
        </div>
</div>
     <div class="mainbottomBg"></div>

<?php



$date=gmdate('Y-m-d H:i:s', strtotime('+5 hours'));
//echo $date;

?>

