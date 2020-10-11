<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br />

     <div style="background-color: green">
          <div>
               <h2> User Bank Accounts Detail ( <?php echo $User['Currency']['currency_name']; ?>)</h2>
          </div>
          <div>

               <div style='float:left'>
                    <h4>  <strong> Beneficiary Name </strong></h4>
                    <br>
                    <h4>     <strong> Beneficiary Address </strong></h4>
                    <br>
                    <h4> <strong> Bank Name </strong></h4>
                    <br>
                    <h4>    <strong> Bank address </strong></h4>
                    <br>
                    <h4>   <strong> swift code </strong></h4>
                    <br>
                    <h4>   <strong> IBAN </strong></h4>
                    <br>
                    <h4>    <strong> Account Number</strong></h4>


               </div>
               <div style='float:left;margin-left: 20px;background-color: greenyellow'>
                    <h4> <strong><?php echo $User['AccountsUser']['beneficiary_name']; ?> </strong></h4>
                    <br>
                    <h4> <strong><?php echo $User['AccountsUser']['beneficiary_address']; ?> </strong></h4>

                    <br>
                    <h4> <strong><?php echo $User['AccountsUser']['bank_name']; ?> </strong></h4>

                    <br>
                    <h4>  <strong><?php echo $User['AccountsUser']['bank_address']; ?> </strong></h4>
                    <br>
                    <h4> <strong><?php echo $User['AccountsUser']['swift_code']; ?> </strong></h4>
                    <br>
                    <h4>  <strong><?php echo $User['AccountsUser']['iban']; ?> </strong></h4>
                    <br>
                    <h4><strong><?php echo $User['AccountsUser']['account_number']; ?> </strong></h4>
               </div>
          </div>

     </div>

     &nbsp;&nbsp;&nbsp;Thank you for using our product . we will contact u soon .</h4>

<h4><a href="http://www.livecalls.hk/accounts_users/update_status/<?php echo $User['AccountsUser']['id']; ?>">Click Here To Confirm your changes<a></h4>