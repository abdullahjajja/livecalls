<?php
 // var_dump($oper);
 // exit();
?>

<div id="maincontent">
     <div class="mainheading"><div></div><div align="left">IPs List</div><div align="right" style="margin-top: -15px" ><?php echo $this->Html->link(__('Operator List', true), array('action' => 'index')); ?></div><div align="right" style="margin-top: -15px" ></div> </div>
     <div class="maincenterBg">
     	<center>
     		<form action="../insert_operator_ip" method="post" accept-charset="utf-8">
	     	<label>Enter Ip Address : <input type="text" name="ip" required pattern="^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$" value=""></label>
	     	<label>Operator : <input type="text" name="operator" value="<?php echo $oper['Operator']['name']; ?>" disabled="disabled"></label>
	     	<input type="hidden" name="operator_id_field" id="operator_id_field" value="<?php echo $oper['Operator']['id']; ?>">
	     	<input type="submit" name="submit" value="Submit" style="background: green; color: white;">
	     	</form>
	    </center>
     	


          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="center" valign="top"><table width="50%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                 <td width="30%" align="left" style="padding-left:20px;"><?php echo ('Operator ips'); ?></td>
                                                                 <td width="30%" align="left" style="padding-left:30px;"><?php echo ('Operator Name'); ?></td>

                                                                 <td width="30%" align="center"><?php __('Created at'); ?></td>
                                                                 <td width="10%" align="center"><?php __('Actions'); ?></td>
                                                            </tr>
                                                       </table></td>
                                             </tr>

                                             <tr>
                                                  <?php
                                                  $i = 0;
                                                 
                                                  foreach ($operators as $operator):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
                                                       ?>
                                                  <tr<?php echo $class; ?>>
                                                       <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                 <tr><td width="30%" align="left" class="gridcellborder" style="padding-left:20px;"><?php //var_dump($operator); 
                                                                 echo $operator['operator_ips']['ip'];  ?></td>
                                                                      <td width="30%" align="left" class="gridcellborder" style="padding-left:20px;"><?php echo $operator['operators']['name']; ?></td>


                                                                      <td width="30%" align="center" class="gridcellborder">
                                                                          <?php echo $operator['operator_ips']['created_at']; ?>
                                                                      </td width="10%">
                                                                      <td><?php echo $this->Html->link(__('delete', true), array('action' => 'delete_op_ip',  $operator['operator_ips']['id'], '?' => array('oper_id' => $oper['Operator']['id'], 'oper_ip_id' => $operator['operator_ips']['id']))); ?></td>
                                                                 </tr>
                                                            </table></td>
                                                  </tr>
                                             <?php
                                              endforeach; 
                                              ?>
                                        </table></td>
                              </tr>
                         </table></td>
               </tr>
          </table>
          <div class="mainbottomBg"></div>
     </div>
