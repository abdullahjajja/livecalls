<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br />

<h3 style="font-family:arial; color:#093">User Bank Accounts Detail (<?php echo $User['Currency']['currency_name']; ?>)</h3>
<table width="100%" border="1" cellspacing="1" cellpadding="1" 
 style="background-color:#C3F8AA; text-align:left; font-family:arial; 
 font-size:14px; text-transform:capitalize;">
 
 <tr>
     <th scope="row"  style="padding:6px 10px;">Beneficiary Name</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['beneficiary_name']; ?></td>
  </tr>
  
  <tr>
     <th scope="row"  style="padding:6px 10px;">Beneficiary Address</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['beneficiary_address']; ?></td>
  </tr>
   <tr>
     <th scope="row"  style="padding:6px 10px;">Bank Name</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['bank_name']; ?></td>
  </tr>
   <tr>
     <th scope="row"  style="padding:6px 10px;">Bank address</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['bank_address']; ?></td>
  </tr>
   <tr>
     <th scope="row"  style="padding:6px 10px;">swift code</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['swift_code']; ?></td>
  </tr>
   <tr>
     <th scope="row"  style="padding:6px 10px;">IBAN</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['iban']; ?></td>
  </tr>
   <tr>
     <th scope="row"  style="padding:6px 10px;">Account Number</th>
    <td  style="padding-left:6px;"><?php echo $User['AccountsUser']['account_number']; ?></td>
  </tr>
   
 </table>

     &nbsp;&nbsp;&nbsp;Thank you for using our product . we will contact u soon .</h4>

<h4><a href="http://www.livecalls.hk/accounts_users/update_status/<?php echo $User['AccountsUser']['id']; ?>">Click Here To Confirm your changes<a></h4>