<style>
     a{
          color: green;
          font: 30px;

     }
</style>
<div class="accountsUsers index" style='float :left; width: 100%; border-left: none; margin-left: -15px'>


     <div class="mainheading">Bank Detail ( On every edit, a confirmation Email will be sent at your's Email Address for Verification ) <div align="right" style="margin-top: -15px" ></div> </div>

     <table cellpadding="0" cellspacing="0">
          <tr>
               <th><?php echo'Currency'; ?></th>
               <th><?php echo 'Benificiary Name'; ?></th>


               <th><?php echo 'Bank Name'; ?></th>

               <th><?php echo 'Status'; ?></th>



               <th class="actions"><?php __('Actions'); ?></th>

          </tr>
          <?php
          $i = 0;
          foreach ($accountsUsers as $accountsUser):
               $class = null;
               ?>
               <tr>
                    <td><?php echo $accountsUser['Currency']['currency_name']; ?>&nbsp;</td>
                    <td>
                         <?php echo $accountsUser['AccountsUser']['beneficiary_name']; ?>&nbsp;
                    </td>

                    <td><?php echo $accountsUser['AccountsUser']['bank_name']; ?>&nbsp;</td>

                    <td><?php
                         if ($accountsUser['AccountsUser']['status'] == 0) {
                              echo 'Details Not Added';
                         } elseif ($accountsUser['AccountsUser']['status'] == 1) {
                              echo 'Not Verified Yet ';
                         } elseif ($accountsUser['AccountsUser']['status'] == 2) {
                              echo 'Verified ';
                         }
                         ?>&nbsp;</td>


                    <td class="actions">

                         <?php echo $this->Html->link(__('View', true), array('action' => 'view', $accountsUser['AccountsUser']['id'])); ?>
                         <?php
                         if ($user['User']['role_id'] == 2 && $user['User']['id'] == $this->Session->read('Auth.User.id')) {
                              ?>
                              <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $accountsUser['AccountsUser']['id'])); ?>

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
