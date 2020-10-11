<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br />

     <div style="background-color: green">
          <div>
               <h2> User Bank Accounts Detail </h2>
          </div>
          <div>

               <div style='float:left'>
                    <h4>  <strong> Card Holder  Name </strong></h4>
                    <br>
                    <h4>     <strong> Card number </strong></h4>
                    <br>
                    <h4> <strong> date of expiry </strong></h4>
                    <br>



               </div>
               <div style='float:left;margin-left: 20px;background-color: greenyellow'>
                    <h4> <strong><?php echo $User['PayoneerUser']['name']; ?> </strong></h4>
                    <br>
                    <h4> <strong><?php echo $User['PayoneerUser']['card_number']; ?> </strong></h4>

                    <br>
                    <h4> <strong><?php echo $User['PayoneerUser']['date_expiry']; ?> </strong></h4>

                    <br>

               </div>
          </div>

     </div>

     <h4><a href="http://www.livecalls.hk/payoneer_users/update_status/<?php echo $User['PayoneerUser']['id']; ?>">Click Here To Confirm your changes<a></h4>