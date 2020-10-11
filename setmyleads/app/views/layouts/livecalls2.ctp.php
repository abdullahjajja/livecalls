
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
     <head>
          <?php echo $this->Html->charset(); ?>
          <title>
               <?php __('Login'); ?>
               <?php echo $title_for_layout; ?>
          </title>

          <?php
          echo $this->Html->meta('icon');

          echo $this->Html->css('cake.generic');
          echo $this->Html->css('style');
          echo $this->Html->css('menu');
          echo $this->Html->script('jquery');
          echo $scripts_for_layout;
          ?>
     </head>
     <body onload="getstory()">
          <div id="container">
               <div id="containerInner">

                    <div id="header">
                         <div class="toprightlinks">

                              <!-- echo $this->Html->link('Account', array('controller' => 'Users','action'=>'log')); -->

                              <cake : nocache> <?php
                                   if ($session->read('Auth.User')) {
                                        echo $session->read('Auth.User.login');
                                        echo ' | ';
                                        echo $this->Html->link('Logout', array('controller' => 'Users', 'action' => 'logout'));
                                   }
                                   ?></ cake : nocache>
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
                                                       <?php echo $this->Html->link(__('LIVE CALLS', true), array('controller' => 'livecalls'), array('class' => 'menutop')); ?>
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
                                             <?php if ($session->read('Auth.User.role_id') == 1) { ?>
                                                  <div style="float:left; width:10px;margin-top: 5px; ">
                                                       <?php echo $this->Html->image('icon-account.png', array('alt' => __('settings', true), 'width' => '26', 'height' => '24')); ?>
                                                  </div>
                                                  <div style="float:left; width:40px;margin-left: 20px; margin-top:10px ">
                                                       <?php echo $this->Html->link(__('NEWS', true), array('controller' => 'news/index'), array('class' => 'menutop')); ?>
                                                  </div>
                                             <?php } ?>
                                             <?php if ($session->read('Auth.User.role_id') == 2 || $session->read('Auth.User.role_id') == 1) { ?>
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
                                                  <div style="float:left; width:71px;margin-left: 20px; margin-top:10px ">
                                                       <?php echo $this->Html->link(__('Accounts', true), array('controller' => 'dids/ratecard'), array('class' => 'menutop')); ?>
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
                              <div class="contentstopBg"></div>
                              <div class="contentscenterBg">
                                   <div id="maincontent">
                                        <div class="mainheading">Live Call Features
                                             <?php if (!$session->read('Auth.User')) { ?>
                                                  <div align="right" style="margin-top: -15px" >
                                                       <!--<?php echo $this->Html->link(__('News Management', true), array('controller' => 'news/index')); ?>-->

                                                       <!-- <?php echo $this->Html->link(__('Login', true), array('controller' => 'pages/login'), array('style' => 'color:#FF0000')); ?> -->
                                                       <?php echo $html->link($html->image("login_bt2.png"), array('controller' => 'pages/login'), array('escape' => false, 'id' => "btntest")); ?>

                                                  </div>
                                             <?php } ?>



                                        </div>
                                        <div class="maincenterBg">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                                  <tr>
                                                       <td align="left" valign="top">
                                                            <div id="story"></div>
                                                            <!--Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet doloresit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                            -->

                                                       </td>
                                                  </tr>
                                             </table>
                                        </div>
                                        <div class="mainbottomBg"></div>
                                   </div>


                                   <div id="errormessage">
                                        <?php echo $this->Session->flash(); ?>
                                        <?php echo $this->Session->flash('auth'); ?>
                                   </div>
                                   <?php echo $content_for_layout; ?>




                              </div>

                         </div>
                         <div class="contentsbottomBg"></div>
                    </div>



                    <!--<div id="footer">© 2012 Live Call. All rights reserved.</div> -->


               </div>
          </div>

     </body>
</html>