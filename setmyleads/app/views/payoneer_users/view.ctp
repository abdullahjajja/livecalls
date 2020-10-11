<div class="payoneerUsers view" style="float: left">
     <h2 style='color: green'><?php __('Payoneer Card Detail'); ?>
          <?php
          if ($payoneerUser['PayoneerUser']['status'] == 0) {
               echo ' ( Details Not Added)';
          } elseif ($payoneerUser['PayoneerUser']['status'] == 1) {
               echo ' (Not Verified Yet )';
          } elseif ($payoneerUser['PayoneerUser']['status'] == 2) {
               echo ' ( Verified )';
          }
          ?>
     </h2>
     <dl><?php
          $i = 0;
          $class = ' class="altrow"';
          ?>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Id'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['id']; ?>
               &nbsp;
          </dd>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Name'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['name']; ?>
               &nbsp;
          </dd>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Card Number'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['card_number']; ?>
               &nbsp;
          </dd>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Date Expiry'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['date_expiry']; ?>
               &nbsp;
          </dd>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Created'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['created']; ?>
               &nbsp;
          </dd>
          <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Modified'); ?></dt>
          <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
               <?php echo $payoneerUser['PayoneerUser']['modified']; ?>
               &nbsp;
          </dd>

     </dl>
</div>

