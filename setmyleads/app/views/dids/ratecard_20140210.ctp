<?php
$globalvar=0;

?>

        
                <div  id="maincontent">
    <div class="mainheading"><div align="left">Rate Card</div> <?php if($authUser == '1') {   ?> <div align="right" style="margin-top: -15px; margin-right:75px;" ><?php echo $this->Html->link(__('Import', true), array('action' => 'uploaddid')); ?></div><div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('Add New', true), array('action' => 'add')); ?></div> <?php } ?> </div>
	   <div class="maincenterBg" id="maintbl">
	      <table width="968px" border="0" cellspacing="0" cellpadding="0" >
		<tr valign="top">                                    
			<td width="968px">	
			      <table width="968px" border="0" cellspacing="10" cellpadding="0" >
				<tr>
				  <td align="left" valign="top"><table width="950px" border="0" cellspacing="0" cellpadding="0">
				    <tr>
				      <td class="gridtable"><table width="950px" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtableHeader">
					    <tr>
						<td width="30%" align="left"><?php echo ('&nbsp;Numberrange');?></td>
						<td width="30%" align="center"><?php echo ('Test Numbers');?></td>
						<td width="10%" align="center"><?php echo ('Curr');?></td>
						<td width="10%" align="center"><?php echo ('Rate');?></td> 
						<td width="5%" align="center"><?php  echo ('Limit');?></td>		
					   </tr></table></td>
					  <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtableHeader">					   
						<td width="30%" align="left"><?php echo ('&nbsp;Numberrange');?></td>
						<td width="30%" align="center"><?php echo ('Test Numbers');?></td>
						<td width="10%" align="center"><?php echo ('Curr');?></td>
						<td width="10%" align="center"><?php echo ('Rate');?></td> 
						<td width="5%" align="center"><?php  echo ('Limit');?></td>		
					    </tr>
					  </table></td>
					</tr>

	<?php
	$i = 0;
	$counter = 0;
	$half = Round(count($dids)/2);	
	foreach ($dids as $did):
		if ($i++ % 2 == 0) {
			if($class == ' class="grid1light"') {
				$class =' class="grid2dark"' ;	
			}else { 
				$class = ' class="grid1light"';
			}
		}
		if($i == 1) { ?>
		<tr valign = "top">
		  <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable">

		<?php } ?>
<?php		
		App::import('Helper', 'getcurrency'); // loadHelper('Html'); in CakePHP 1.1.x.x
                $getcurrency = new getcurrencyHelper();
		$buy_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['admin_currency']);    
	?>
	<tr <?php echo $class;?>>
		<td width="30%" align="left" class="gridcellborder" style=\"padding-left:10px;\">&nbsp;
		<?php echo $did['Numberrange']['name']; ?>
		</td>
		<td width="30%" align="center" class="gridcellborder"><?php echo $did['Did']['did'] ; ?></td>
		<td width="10%" align="center" class="gridcellborder"><?php echo $buy_curname ; ?></td>
		<td width="10%" align="center" class="gridcellborder"><?php echo $did['Didrate'][0]['superresrate']; ?></td>
		<td width="5%" align="left" class="gridcellborder" style=\"padding-left:10px;\">
		<?php echo $did['Did']['maxdailyminutes']; ?>         
                </td>        
	</tr>
		<?php if ($i + 1 == $half) {?>
                                  </table></td>
		  <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable">                                
		<?php } ?>			
<?php endforeach; ?>

                          </table></td>
                        </tr>
                      </table>
		      </td></tr></table></td></tr></table> 
      <div style="text-align:center">         
	<p>
	<?php
/*        
       	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            
	));
     


//extract the get variables
$url = $this->params['url'];
unset($url['url']);
print_r ($url); 
echo "<br>";

$get_var = http_build_query($url);
print_r ($get_var );
echo "<br>";

$arg1 = array(); $arg2 = array();
//take the named url
if(!empty($this->params['named'])) {
	$arg1 = $this->params['named'];
print_r($arg1);
echo "<br>";
} else {
	echo ".... empty ...<br>";

}

//take the pass arguments
if(!empty($this->params['pass']))
$arg2 = $this->params['pass'];
print_r($arg2);
echo "<br>";


//merge named and pass
$args = array_merge($arg1,$arg2);
print_r($args);
echo "<br>";


//add get variables
$args["?"] = $get_var;

//$this->Paginator->options['url']['?'] = $get_var;

//$this->Paginator->options(array('url' => $this->passedArgs));

$this->Paginator->options(array('url' => $args));
/*

$urls = $this->params['url']; 
$getv = "";
foreach($urls as $key=>$value)
{
	if($key == 'url') continue; // we need to ignor the url field
	$getv .= urlencode($key)."=".urlencode($value)."&"; // making the passing parameters
}
$getv = substr_replace($getv ,"",-1); // remove the last char '&'
print_r($getv);

	
	$paginator->options(array('url' => array($this->passedArgs[0],"?"=>$getv)));

*/

//In view file before any call to Paginator Helper
//$this->params['url'] contains all the query string with key and value
//print_r ($this->params['url'] );
//echo "....<br>";

$url_param = array_filter($this->params['url']); 
//strip out any parameter which doen't have any value

unset($url_param['url']); 
//its not the query string so unset it, its the path to our action with any parameter to it

$query_string = '';
//cteate the query string with key and value
foreach($url_param as $key => $val){
	$query_string .= $key.'='.$val;
}
//echo "<br>" . $query_string . ".......<br>";

$beginning = 'foo';
$end = array(1 => 'bar');
$result = array_merge((array)$beginning, (array)$end);
//print_r($result);

//set 'url' key which will be used by paginator helper to set our query string in pagination
//$options['url'] = array_merge($this->passedArgs, array('?'=> $query_string));
$options['url'] = array('?'=> $query_string);
//echo "<br>";
//print_r($options);
//echo ("<br>");

//call the options function which will set options variable of Paginator Helpler
$this->Paginator->options($options);
//that's it. Now the Paginator will create links with our query string .	
	
	
	?>	</p>

<!--        
        
        
	<div class="paging" >
		<?php// echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php// echo $this->Paginator->numbers();?>
 |
		<?php// echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
 <?php
  //In view file before any call to Paginator Helper
  //$this->params['url'] contains all the query string with key and

  
 ?>
	</div>  -->
</div>
        <?php// echo $this->Form->end();?>

</div>
 <div class="mainbottomBg"></div>