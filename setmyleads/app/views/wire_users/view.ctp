
<div  id="maincontent" style="margin-left: 0px;">
     <div class="mainheading"><div></div><div align="left">

               <?php __('Western Union User details '); ?>
               <?php
               if ($wireUser['WireUser']['status'] == 0) {
                    echo ' ( Details Not Added)';
               } elseif ($wireUser['WireUser']['status'] == 1) {
                    echo ' ( Not Verified Yet ) ';
               } elseif ($wireUser['WireUser']['status'] == 2) {
                    echo '( Verified ) ';
               }
               ?>

          </div> <div align="right" style="margin-top: -15px" ><?php
               ?>


          </div>

     </div>
     <div class="wireUsers view" style='float:left;border: none'>

          <dl><?php
               $i = 0;
               $class = ' class="altrow"';
               ?>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Id'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['id']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Name'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Mobile Number'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['mobile_number']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Country'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['country_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('State'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['state_name']; ?>
                    &nbsp;
               </dd>
               <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('City'); ?></dt>
               <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                    <?php echo $wireUser['WireUser']['city_name']; ?>
                    &nbsp;
               </dd>
          </dl>
     </div>
