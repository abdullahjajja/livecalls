<style>
     a{
          color: green;
          font: 30px;

     }
</style>
<div class="wireUsers index" style='float :left; width: 100%; border-left: none; margin-left: -15px'>

     <div class="mainheading">Western Union Accounts ( On every edit, a confirmation Email will be sent at your's Email Address for Verification ) <div align="right" style="margin-top: -15px" ></div> </div>

     <table cellpadding="0" cellspacing="0">
          <tr>

               <th><?php echo 'Benificiary name'; ?></th>
               <th><?php echo 'mobile_number'; ?></th>
               <th><?php echo 'country '; ?></th>
               <th><?php echo 'status '; ?></th>



               <th class="actions"><?php __('Actions'); ?></th>
          </tr>
          <?php
          $i = 0;
          foreach ($wireUsers as $wireUser):
               $class = null;
               if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
               }
               ?>
               <tr<?php echo $class; ?>>

                    <td><?php echo $wireUser['WireUser']['name']; ?>&nbsp;</td>
                    <td><?php echo $wireUser['WireUser']['mobile_number']; ?>&nbsp;</td>

                    <td><?php echo $wireUser['WireUser']['country_name']; ?>&nbsp;</td>


                    <td><?php
                         if ($wireUser['WireUser']['status'] == 0) {
                              echo 'Details Not Added';
                         } elseif ($wireUser['WireUser']['status'] == 1) {
                              echo 'Not Verified Yet ';
                         } elseif ($wireUser['WireUser']['status'] == 2) {
                              echo 'Verified ';
                         }
                         ?>&nbsp;</td></td>






                    <td class="actions">
                         <?php echo $this->Html->link(__('View', true), array('action' => 'view', $wireUser['WireUser']['id'])); ?>
                         <?php
                         if ($user['User']['role_id'] == 2 && $user['User']['id'] == $this->Session->read('Auth.User.id')) {
                              ?>
                              <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $wireUser['WireUser']['id'])); ?>
                         <?php } ?>
                    </td>
               </tr>
          <?php endforeach; ?>
     </table>
     <p>
          <?php
          echo $this->Paginator->counter(array(
              'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
          ));
          ?>	</p>

     <div class="paging">
          <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
          | 	<?php echo $this->Paginator->numbers(); ?>
          |
          <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
     </div>
</div>
