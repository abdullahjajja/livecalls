<h4>Dear <?php echo $User['User']['first_name'] . ' ' . $User['User']['last_name'] ?>,<br />

     <div style="background-color: green">
          <div>
               <h2> User Bank Accounts Detail </h2>
          </div>
          <div>

               <div style='float:left'>
                    <h4>  <strong> Beneficiary Name </strong></h4>
                    <br>
                    <h4>     <strong> Mobile number </strong></h4>
                    <br>
                    <h4> <strong> Country </strong></h4>
                    <br>
                    <h4>    <strong> State </strong></h4>
                    <br>
                    <h4>   <strong> City </strong></h4>
                    <br>



               </div>
               <div style='float:left;margin-left: 20px;background-color: greenyellow'>
                    <h4> <strong><?php echo $User['WireUser']['name']; ?> </strong></h4>
                    <br>
                    <h4> <strong><?php echo $User['WireUser']['mobile_number']; ?> </strong></h4>

                    <br>
                    <h4> <strong><?php echo $User['WireUser']['city_name']; ?> </strong></h4>

                    <br>
                    <h4>  <strong><?php echo $User['WireUser']['state_name']; ?> </strong></h4>
                    <br>
                    <h4> <strong><?php echo $User['WireUser']['country_name']; ?> </strong></h4>
                    <br>

               </div>
          </div>

     </div>

     <h4><a href="http://www.livecalls.hk/wire_users/update_status/<?php echo $User['WireUser']['id']; ?>">Click Here To Confirm your changes<a></h4><?php
                    /*
                     * To change this template, choose Tools | Templates
                     * and open the template in the editor.
                     */
                    ?>
