<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br /></h4>


<h3 style="font-family:arial; color:#093">User Bank Accounts Detail:</h3>
<table width="100%" border="1" cellspacing="1" cellpadding="1" 
 style="background-color:#C3F8AA; text-align:left; font-family:arial; 
 font-size:14px; text-transform:capitalize;">
 
 <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Beneficiary Name</th>
    <td  style="padding-left:6px;"><?php echo $User['WireUser']['name']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Mobile number</th>
    <td  style="padding-left:6px;"><?php echo $User['WireUser']['mobile_number']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Country</th>
    <td  style="padding-left:6px;"><?php echo $User['WireUser']['country_name']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">State</th>
    <td  style="padding-left:6px;"><?php echo $User['WireUser']['state_name']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">City</th>
    <td  style="padding-left:6px;"><?php echo $User['WireUser']['city_name']; ?></td>
  </tr>
 </table>

     <h4><a href="http://www.livecalls.hk/wire_users/update_status/<?php echo $User['WireUser']['id']; ?>">Click Here To Confirm your changes<a></h4><?php
                    /*
                     * To change this template, choose Tools | Templates
                     * and open the template in the editor.
                     */
                    ?>
