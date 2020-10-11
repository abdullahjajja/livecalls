<style>
     dt{
          width: 15em;
     }
     dd{
          margin-left: 15em;
     }

     dl{
          width: 70%;
     }
</style>
<div  id="maincontent" style="margin-left: 0px;">
     <div class="mainheading"><div></div><div align="left">

               <?php __('User Bank Detail'); ?>

               <?php
               if ($accountsUser['AccountsUser']['status'] == 0) {
                    echo '(Details Not Added)';
               } elseif ($accountsUser['AccountsUser']['status'] == 1) {
                    echo '(Not Verified Yet) ';
               } elseif ($accountsUser['AccountsUser']['status'] == 2) {
                    echo '(Verified) ';
               }
               ?>

          </div> <div align="right" style="margin-top: -15px" ><?php
               ?>


          </div>

     </div>
     <div class="accountsUsers view" style="float: left; border: none">

          <dl><?php
               $i = 0;
               $class = ' class="altrow"';
               ?>

               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Beneficiary Name'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['beneficiary_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Country'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo$accountsUser['AccountsUser']['country_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('State'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo$accountsUser['AccountsUser']['state_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('City'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['city_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Beneficiary Address'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['beneficiary_address']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Bank Name'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['bank_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Bank Address'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['bank_address']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Swift Code'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['swift_code']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Iban'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['iban']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Account Number'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['account_number']; ?>
                    &nbsp;
               </dd>


               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Created'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['created']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Modified'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $accountsUser['AccountsUser']['modified']; ?>
                    &nbsp;
               </dd>

          </dl>
     </div>
     <?php
     $url = $this->params['pass'];
     ?>

