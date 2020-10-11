
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
     <head>
          <?php echo $this->Html->charset(); ?>
          <title>
               <?php __('Welcome to Live Calls'); ?>
               <?php echo $title_for_layout; ?>



               <?php

               function ae_nocache() {
                    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");
               }

               ae_nocache();
               ?>



          </title>

          <?php
          //if($this->params['controller'] == 'reports') {
          //echo $this->Html->script('../../jquery.ui.datepicker');
          // echo $this->Html->css('../../demos');
          //echo $this->Html->script('../../jquery.ui.widget');
          // echo $this->Html->script('../../jquery.ui.core');
          //echo $this->Html->script('../../jquery-1.7.2');
          //      }
          ?>

          <style>
               .a{
                    float:right;

                    width:140px;
               }
               .notice01{width:54px;
                         height:auto;
                         float:right;
                         position:absolute;
                         cursor:pointer
               }
               .not02{ position:relative;
                       left:25px;
                       top:17px;
                       z-index:9999;

                       padding:1px;
                       width:18px;
                       height:auto;

                       border-radius:50px;
                       border:2px #FFF solid;
                       background-color:#e4002c;
                       font-family:Arial,sans-serif;
                       font-size: 14px;
                       color: #FFF;
                       font-weight:bold;
                       text-align:center;
                       cursor:pointer;


               }

          </style>

          <script type="text/javascript">
               //('#count').hide();
               function getstory() {

                    get_notification_count();
                    $.ajax({
                         url: "/api/getstory",
                         type: "GET",
                         success: function(msg) {
                              //alert(msg);
                              $('#story').html('');
                              $('#story').append(msg);

<?php ae_nocache(); ?>

                         },
                         error: function() {

                              //alert("error");
                         }
                    });
               }
               function get_notification_count() {
                    $.ajax({
                         //url: '../api/get_notification_count',
                         url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'get_notification_count')); ?>",
                         type: 'GET',
                         success: function(result) {
                              //alert(result);
                              if (result > 0) {
                                   $('#count').html('');
                                   $('#count').html(' <div class=\'not02\' >' + result + '</div>');
                              }

                         },
                         error: function() {

                              //alert("error");
                         }
                    });
               }


               //setInterval( "getstory()", 3000 );
          </script>


          <?php
          echo $this->Html->meta('icon');
          echo $this->Html->css('style');
          echo $this->Html->css('menu');
          echo $this->Html->script('jquery');
          echo $scripts_for_layout;
          ?>

     </head>
     <!-- onload="getstory()" -->
     <body onload="get_notification_count()">
          <div id="container">
               <div id="containerInner">

                    <div id="header" style=" height: auto">
                         <div class="toprightlinks">

                              <!-- echo $this->Html->link('Account', array('controller' => 'Users','action'=>'log')); -->

                              <cake : nocache> <?php
                                   if ($session->read('Auth.User.role_id') == 1) {

                                        echo"<div class='a'>
                                              <a href=" . $this->Html->url(array('controller' => 'notifications', 'action' => 'index')) . ">
                                              <div  id='count'>
                                                  <div class='not02' style=' visibility: hidden'>0</div>
                                        </div>
                                        <div class='notice01'>" .
                                        $this->Html->image('notification.png') . "

                                        </div>
                                        </a>
                                             ";
                                   }
                                   if ($session->read('Auth.User.role_id') == 2) {

                                        echo"<div class='a'>
                                            <a href=" . $this->Html->url(array('controller' => 'user_notifications', 'action' => 'index')) . ">
                                             <div  id='count'>
                                                  <div class='not02' style=' visibility: hidden'>0</div>
                                        </div>
                                        <div class='notice01'>" .
                                        $this->Html->image('notification.png') . "

                                        </div>
                                        </a>
                                             ";
                                   }
                                   if ($session->read('Auth.User')) {
                                        echo $session->read('Auth.User.login');
                                        echo ' | ';
                                        echo $this->Html->link('Logout', array('controller' => 'Users', 'action' => 'logout'));
                                   }
                                   ?></ cake : nocache>
                         </div>
                    </div>

<!--	<div class="logo"><a href="#"><?php echo $this->Html->image('logo.png', array('alt' => __('logo', true), 'width' => '138', 'height' => '78')); ?></a></div>
                    -->
                    <div id="menutop">

                         <div class="menuleftbg" id="menuleft"></div>
                         <div class="menucenterbg" id="menubg">



                              <!-- main div> -->
                              <div style="width:auto;float: right;right: 50%;position: relative;" id="livecalllay">
                                   <!-- first child -->

                                   <div style="width:auto;float: right;right: -50%;position: relative;">
                                        <?php if ($session->read('Auth.User.role_id') == 1 || $session->read('Auth.User.role_id') == 2 || $session->read('Auth.User.role_id') == 3 || $session->read('Auth.User.role_id') == 4) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-settings.png', array('alt' => __('live calls', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:74px;margin-left: 20px; margin-top: 10px ">
                                                  <?php echo $this->Html->link(__('Live Report', true), array('controller' => 'report'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 1 || $session->read('Auth.User.role_id') == 2 || $session->read('Auth.User.role_id') == 3) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-users.png', array('alt' => __('user', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:45px;margin-left: 20px; margin-top: 10px ">
                                                  <?php echo $this->Html->link(__('USERS', true), array('controller' => 'users/index'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-settings.png', array('alt' => __('IVRS', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:30px;margin-left: 20px; margin-top: 10px ">
                                                  <?php echo $this->Html->link(__('IVRS', true), array('controller' => 'ivrs/index'), array('class' => 'menutop')); ?>
                                             </div>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-operators.png', array('alt' => __('operators', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:40px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link('OPER', array('controller' => 'operators/index'), array('class' => 'menutop')); ?>
                                             </div>

                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-numberrange.png', array('alt' => __('numberrange', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:70px;margin-left: 20px; margin-top: 10px ">
                                                  <?php echo $this->Html->link(__('NUM RANGE', true), array('controller' => 'numberranges/index'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 1 || $session->read('Auth.User.role_id') == 2 || $session->read('Auth.User.role_id') == 3 || $session->read('Auth.User.role_id') == 4) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-billing.png', array('alt' => __('reports', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:71px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('TEST ROOM', true), array('controller' => 'reports/testcalls?id=1'), array('class' => 'menutop')); ?>
                                             </div>

                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-billing1.png', array('alt' => __('reports', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:29px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('CDR', true), array('controller' => 'reports/cdr'), array('class' => 'menutop')); ?>
                                             </div>

                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-billing2.png', array('alt' => __('reports', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:65px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('SUB TOTAL', true), array('controller' => 'reports/voicecall'), array('class' => 'menutop')); ?>
                                             </div>

                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-import.png', array('alt' => __('import', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:80px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('MY NUMBERS', true), array('controller' => 'dids/index'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>

                                        <?php if ($session->read('Auth.User.role_id') == 1 || $session->read('Auth.User.role_id') == 2) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('icon-account.png', array('alt' => __('settings', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:40px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('NEWS', true), array('controller' => 'news/index'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('card.png', array('alt' => __('Rates', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:71px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('RATE CARD', true), array('controller' => 'dids/ratecard'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 2) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('card.png', array('alt' => __('Rates', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:150px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('RATE CARD/Add Number', true), array('controller' => 'dids/ratecard'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>
                                        <?php if ($session->read('Auth.User.role_id') == 2) { ?>
                                             <div style="float:left; width:10px;margin-top: 5px; ">
                                                  <?php echo $this->Html->image('accounts_-icon.png', array('alt' => __('Rates', true), 'width' => '26', 'height' => '24')); ?>
                                             </div>
                                             <div style="float:left; width:71px;margin-left: 20px; margin-top:10px ">
                                                  <?php echo $this->Html->link(__('Accounts', true), array('controller' => 'accounts_users', 'action' => 'selection'), array('class' => 'menutop')); ?>
                                             </div>
                                        <?php } ?>

                                   </div>
                              </div>
                         </div>
                         <div class="menurightbg"></div>
                    </div>
               </div>

               <div id="bodycontents">
                    <div id="contents">





                         <div id="errormessage">
                              <?php echo $this->Session->flash(); ?>
                              <?php echo $this->Session->flash('auth'); ?>
                         </div>
                         <?php echo $content_for_layout; ?>





                    </div>

               </div>



               <!--<div id="footer">© 2012 Live Call. All rights reserved.</div> -->


          </div>
          </div>

     </body>
</html>