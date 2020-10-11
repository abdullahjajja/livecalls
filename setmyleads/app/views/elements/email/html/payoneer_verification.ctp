<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br /></h4>

<h3 style="font-family:arial; color:#093">User Bank Accounts Detail:</h3>
<table width="100%" border="1" cellspacing="1" cellpadding="1" 
 style="background-color:#C3F8AA; text-align:left; font-family:arial; 
 font-size:14px; text-transform:capitalize;">
 <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Card Holder  Name</th>
    <td  style="padding-left:6px;"><?php echo $User['PayoneerUser']['name']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Card number</th>
    <td  style="padding-left:6px;"><?php echo $User['PayoneerUser']['card_number']; ?></td>
  </tr>
  <tr  style="background-color:#F5F5F5;">
   <th scope="row"  style="padding:6px 10px;">Date of expiry</th>
    <td  style="padding-left:6px;"><?php echo $User['PayoneerUser']['date_expiry']; ?></td>
  </tr>
 
 </table>
    

     <h4><a href="http://www.livecalls.hk/payoneer_users/update_status/<?php echo $User['PayoneerUser']['id']; ?>">Click Here To Confirm your changes<a></h4>