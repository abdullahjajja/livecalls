

<style>
#mydiv {
border: .2em dotted #900;
}
#border {
border-width: .2em;
border-style: dotted;
border-color: #900;
}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}

</style> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
  function getvoicecall(which){ 
//alert(which);
//today  
if(which=="1"){
$("#txtstartdate").datepicker('setDate', new Date());
$("#txtenddate").datepicker('setDate', new Date());
}
//yesterday
if(which=="2"){
$("#txtstartdate").datepicker('setDate', '-1');
$("#txtenddate").datepicker('setDate', '-1');
}

//this week
if(which=="3"){
$("#txtstartdate").datepicker('setDate', '-7');
$("#txtenddate").datepicker('setDate', '+0');
} 

//last week
if(which=="4"){
$("#txtstartdate").datepicker('setDate', '-13');
$("#txtenddate").datepicker('setDate', '-6');
}

//this month
if(which=="5"){
$("#txtstartdate").datepicker('setDate', '-30');
$("#txtenddate").datepicker('setDate', '+0');
} 

//this month
if(which=="6"){
$("#txtstartdate").datepicker('setDate', '-60');
$("#txtenddate").datepicker('setDate', '-30');
} 

//subtotaol
if(which=="0"){

}

     var strdate=$('#txtstartdate').val();
     var enddate=$('#txtenddate').val();
     
                  $.ajax({
                      url: "../api/GetVoiceCall",
                      type: "GET",

                        data:"cid=" + 1 + "& strdt=" + strdate + "& edt="+enddate, 
//+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,
                      
                      success: function(msg){
                      // alert(msg);
                          $('#tdCalls').html('');
                          $('#tdCalls').append(msg);
                      }
                  });
              }
  //setInterval( "getcdrs()", 3000 );


</script>




<table>
<tr>
<td>

</td>
<td>

</td>
</tr>
<tr>
<td colspan="2">

</td>
</tr>
</table>





            	<div id="maincontent">
                	<div class="mainheading">Sub Total </div>
                    <div class="maincenterBg">
                 
<?php echo $this->Form->create('Reports',array('action'=>'index','type' =>'post'));?>
                        <table width="953" border="0">
  <tr>
<td ><span style="margin-left:176px">Start Date:</span></td>
  <td><input type="text" name="txtstartdate" style="width:200px" id="txtstartdate"/></td>
     <td>End Date:</td>
    <td><input type="text" name="txtenddate" style="width:200px" id="txtenddate"/></td>    <td width="105">
</tr>

<tr> </tr>
<tr> </tr>
<tr> </tr>
  <tr>
    <td >
     
</td>

<td><a href="#" onclick="getvoicecall(1);"><?php echo $this->Html->image('today.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
<a href="#" onclick="getvoicecall(2);"><?php echo $this->Html->image('yesday.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
</td>
<td>
    
</td>
     <td> 
     <a href="#" onclick="getvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
<a href="#" onclick="getvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
  
</td>
  </tr>

<tr>
<td> </td>
    <td>  
<!--
 <a href="#" onclick="getvoicecall(5);"><?php echo $this->Html->image('this-month.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
<a href="#" onclick="getvoicecall(6);"><?php echo $this->Html->image('last-month.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a>
-->
      </td>
  <td></td>
    <td ><a href="#" onclick="getvoicecall(0);"><?php echo $this->Html->image('get-sab.png', array('alt'=> __('numberrange', true), 'width'=>'107', 'height'=>'28')); ?></a></td>
  </tr>

<tr>

    <td width="249">
  <tr>
  </tr>
</table>



<?php echo $form->end(); ?>


                </div>
                    <div class="mainbottomBg"></div>
                </div>
                
                <div id="maincontent">
                	<div class="mainheading">Sub Totals <div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('CDRs', true), array('action' => 'cdr'));?></div> </div>
					
                    <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable" id="tdCalls"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="7%" height="29px" align="center">Sub Customer </td>
                                     <td width="14%" height="29px" align="center">Number Range </td>
                                     <td width="14%" height="29px" align="center">Number </td>
                                      <td width="14%" align="center">Calls</td>
                                      <td width="14%" align="center">Minutes</td>
                                     
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  
                                      
                                     
                                    </tr>
                                  </table></td>
                                </tr>
                               				
								
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                </div>
                
           
            </div>
         
    

<script type="text/javascript">
	$(function() {
		
		$("#txtstartdate").datepicker();
$('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');
       
        
	});
$(function() {
		$("#txtenddate").datepicker();
$('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
	});

	</script>