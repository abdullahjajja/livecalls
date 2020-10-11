
<script type="text/javascript">
   function getStates(){   
     
                  $.ajax({
                      url: "../selectstates",
                      type: "GET",
                      data: "cid="+$('#UserCountryId').val(),
                      success: function(msg){
                          $('#div_state').html('');
                          $('#div_state').append(msg);
                      }
                  });
              }
              
              function getCities(){   
     
                  $.ajax({
                      url: "../selectcities",
                      type: "GET",
                      data: "sid="+$('#UserStateId').val(),
                      success: function(msg){
                          $('#div_cities').html('');
                          $('#div_cities').append(msg);
                      }
                  });
              } 
</script>


<div id="maincontent">
<?php echo $this->Form->create('User');?>
<div class="mainheading">Edit User</div>
   <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table class="addtable">
                            <tr>
                              <td colspan="3" class="h1">Edit User</td>
                            </tr>
                         
	 <tr>   
          <?php echo $this->Form->input('id'); ?>
	 <td width="34%"> <?php	echo $this->Form->input('login'); ?></td>
	 <td width="34%"> <?php	echo $this->Form->input('password');?></td>
         <td width="32%"> <?php	echo $this->Form->input('first_name');?></td>
          </tr>
          <tr>
           <td width="34%"> <?php echo $this->Form->input('last_name'); ?> </td>
               <td width="34%"> <?php echo $this->Form->input('email'); ?> </td>
<!--
		<td width="32%">  <?php echo $this->Form->input('phone',array('maxLength'=>'15'));?> </td>
-->
               </tr>
  
               <tr>
<!--
		<td width="34%"> <?php echo $this->Form->input('address'); ?></td>
		<td width="34%"> <?php echo $this->Form->input('country_id',array('onchange'=>'getStates()'));?></td>               
                <td width="34%" id="div_state"> <?php echo $this->Form->input('state_id',array('onchange' => 'getCities()')); ?> </td>
-->
              </tr>

                <tr>  
<!--
		<td width="34%" id="div_cities"> <?php echo $this->Form->input('city_id'); ?> </td>               
-->
		<td width="34%"> <?php echo $this->Form->input('role_id');?> </td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td  ></td>
                </tr>
  </table></td>
                        </tr>
                      </table>
<div style="width:270px;float:right;margin-right:70px;">
<?php echo $form->submit('bt-save.png',array('style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:left'))); ?>
<a href="../index"> <?php echo $this->Html->image('bt-cancel.png',array('name' => 'cancel','id'=>'cancel','style'=>'margin-left:5px','div'=>array('style'=>'width:135px;float:right'))); ?></a>
</div>
<?php echo $form->end(); ?>
                 </div>    
 <div class="mainbottomBg"></div>
</div>

