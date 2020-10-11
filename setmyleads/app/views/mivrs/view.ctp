<style>
     .field{

          border-bottom: 1.5px solid whitesmoke;


          margin-bottom: 7px;
          margin-top: 7px;
     }
     .form{
          border: 2.5px solid whitesmoke;
          margin-right: 30px;
          margin-top: 20px;
          width: 50%;
     }
</style>
<div id="maincontent">

     <div class="mainheading">MIVR View</div>
     <div class="maincenterBg">  <div class="form" style="margin-left: 30px;">

               <dl><?php
                    $i = 0;
                    $class = ' class="altrow"';
                    ?>

                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Id'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['id']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('Name'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['name']; ?>
                         &nbsp;
                    </dd>

                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('0'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['0']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('1'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['1']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('2'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['2']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('3'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['3']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('4'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['4']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('5'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['5']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('6'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['6']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('7'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['7']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('8'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['8']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('9'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['9']; ?>
                         &nbsp;
                    </dd>
                    <div class='field'></div>
                    <dt<?php if ($i % 2 == 0) echo $class; ?>><?php __('10'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
                         <?php echo $mivr['Mivr']['10']; ?>
                         &nbsp;
                    </dd>
               </dl>
          </div>
          <div class="actions">
               <h3><?php __('Actions'); ?></h3>
               <ul>

                    <li><?php echo $this->Html->link(__('List Mivrs', true), array('action' => 'index')); ?></li>
               </ul>
          </div>
     </div>
