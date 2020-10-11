
<script type="text/javascript">
  function getCalls(){   
     
                  $.ajax({
                      url: "../api/getCalls",
                      type: "GET",
                      data: "cid=1",
                      success: function(msg){
                          $('#tdCalls').html('');
                          $('#tdCalls').append(msg);
                      }
                  });
              }
  setInterval( "getCalls()", 3000 );
</script>

<div id="searchReport">
<?php echo $this->Form->create('Reports',array('action'=>'index','type' =>'post'));?>
<table>
<tr>
<td>
<!--
<?php echo $this->Form->input('startdate', array('label'=>'Start Date ','div' => false));	?>
-->
Start Date:<input type="text" id="startdate" />
</td>
<td>
<!--
<?php echo $this->Form->input('enddate', array('label'=>'End Date ','div' => false,));	?>
-->
End Date:<input type="text" id="enddate" />
<input type="submit" id="btnsubmit" value="Search" onclick="getCalls();"/>
</td>
</tr>
<tr>
<td >
<!--
<?php echo $form->submit('Search',array('id'=>'btnSearch', 'name'=>'btnSearch',  'style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
-->

</td>
</tr>
</table>

<?php echo $form->end(); ?>
</div>
<div id="maincontent">
    <div class="mainheading"><div></div><div align="left">Live Calls</div>  </div>
    <div class="maincenterBg">
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="gridtable" id="tdCalls" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="10%" align="center">Called Number</td>
                                                    <td width="10%" align="center">Customer</td>
                                                    <td width="10%" align="center">Sub Customer</td>
                                                    <td width="26%" align="center">Duration</td>
                                                    <td width="10%" align="center">Calling Number</td>	        

                                                </tr>
                                            </table></td>
                                    </tr>

                                   
                                        <?php
                                        $i = 0;
                                        foreach ($calls as $call):
                                            $class = ' class="grid2dark"';
                                            if ($i++ % 2 == 0) {
                                                $class = ' class="grid1light"';
                                            }
                                            ?>
                                            <tr <?php echo $class;?>><td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                        <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                        <td width="26%" align="center" class="gridcellborder">&nbsp;</td>
                                                        <td width="10%" align="center" class="gridcellborder">&nbsp;</td>
                                                        <td width="22%" align="center" class="gridcellborder">&nbsp;</td>

                                                   </tr>
                                  </table></td>
                                </tr>
                                    <?php endforeach; ?>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>



    </div>
    <div class="mainbottomBg"></div>
</div>
<script type="text/javascript">
	$(function() {
		$("#ReportsStartdate").datepicker();
	});
$(function() {
		$("#ReportsEnddate").datepicker();
	});

	</script>
