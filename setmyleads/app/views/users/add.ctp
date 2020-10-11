<script type="text/javascript">
     function getStates() {

          $.ajax({
               url: "selectstates",
               type: "GET",
               data: "cid=" + $('#UserCountryId').val(),
               success: function(msg) {
                    $('#div_state').html('');
                    $('#div_state').append(msg);
               }
          });
     }

     function getCities() {

          $.ajax({
               url: "selectcities",
               type: "GET",
               data: "sid=" + $('#UserStateId').val(),
               success: function(msg) {
                    $('#div_cities').html('');
                    $('#div_cities').append(msg);
               }
          });
     }
</script>
<div id="maincontent">
     <?php echo $this->Form->create('User'); ?>
     <div class="mainheading">Add New User</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table class="addtable">
                              <tr>
                                   <td colspan="3" class="h1">Add User</td>
                              </tr>

                              <tr>
                                   <td width="34%"> <?php echo $this->Form->input('login', array('label' => 'Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?></td>
                                   <td width="34%"> <?php echo $this->Form->input('password', array('label' => 'Password&nbsp;&nbsp;&nbsp;&nbsp;')); ?></td>
                                   <td width="32%"> <?php echo $this->Form->input('first_name', array('label' => 'First Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?></td>
                              </tr>
                              <tr>
                                   <td width="34%"> <?php echo $this->Form->input('last_name', array('label' => 'Last Name&nbsp;')); ?> </td>
                                   <td width="34%"> <?php echo $this->Form->input('email', array('label' => 'Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?> </td>
                                   <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                                        <td><?php echo $this->Form->input('add_on', array('label' => 'AddOn&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?> </td>
                                   <?php } ?>

                                   <!--
                                               <td width="32%">  <?php echo $this->Form->input('phone', array('maxLength' => '15')); ?> </td>
                                   -->
                              </tr>

                              <tr>
                           <!-- <td width="34%"> <?php echo $this->Form->input('address'); ?></td>
                           <td width="34%"> <?php echo $this->Form->input('country_id', array('onchange' => 'getStates()')); ?></td>
                               <td width="34%" id="div_state"> <?php echo $this->Form->input('state_id', array('onchange' => 'getCities()')); ?> </td>
                                   -->
                              </tr>
                            <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                              <tr>
								<td width="34%"> <?php echo $this->Form->input('skype', array('label' => 'Skype&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')); ?> </td>
                                <td> </td>
                                <td >&nbsp; </td>
                              </tr>
							<?php } ?>  
                              <tr>
                          <!--<td width="34%" id="div_cities"> <?php echo $this->Form->input('city_id'); ?> </td>              -->
                                   <td width="34%"> <?php echo $this->Form->input('role_id'); ?> </td>
                                   <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                                        <td width="34%"> <?php
                                             echo $this->Form->input('user_type_id', array('options' => $usertype));
                                             ?></td>

                                   <?php } ?>

                              </tr>
                              <tr>
                                   <td> </td>
                                   <td >&nbsp; </td>

                              </tr>
                         </table></td>
               </tr>
          </table>
          <div style="width:270px;float:right;margin-right:70px;">
               <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
               <a href="index"> <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:right'))); ?></a>

          </div>
          <?php echo $form->end(); ?>
     </div>
     <div class="mainbottomBg"></div>
</div>
