

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <title>Welcome to Live Calls</title>
          <link href="css/style.css" rel="stylesheet" type="text/css" />
          <script type="text/javascript" src="../js/jquery.js"></script>
          <script type="text/javascript">

               function blink() {
                    $('#btntest').delay(100).fadeTo(100, 0.5).delay(100).fadeTo(100, 1, blink);
               }
               $(window).load(function() {
                    blink();
                    // alert("ye");
               });
               $( document ).ready(function() {
                   var termschecked =  $("#terms").is(':checked');
                    if(!termschecked)
                    {
							$('#submit').attr('disabled','disabled');
					}
                     $("#terms").click( function(){
                      if( $(this).is(':checked') ) {
                      	   $('#submit').removeAttr('disabled');
                      	}
                      else
                      {
					  	//alert("unchecked");
					  	$('#submit').attr('disabled','disabled');
					  }
                   });
            });

          </script>
     </head>
     <body class="bodylogin">

          <div id="container">
               <div id="containerInner">
                    <div id="loginbg"><table class="logintable" width="340px" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                   <td height="50px">
                                        <?php echo $form->create('User', array('action' => 'login')); ?>


                                   </td>
                              </tr>
                              <tr>
                                   <td align="left" class="loginnowhead">Login Here!</td>
                              </tr>
                              <tr>
                                   <td height="20px" style="font:bold 11px Arial;color: #F00;" > <?php echo $this->Session->flash();
                                        echo $this->Session->flash('auth');
                                        ?></td>
                              </tr>
                              <tr>
                                   <td align="left"><?php echo $form->input('login'); ?><br />
                                   </td>
                              </tr>

                              <tr>
                                   <td align="left"><?php echo $form->input('password'); ?><br />
                                   </td>
                              </tr>
                               <tr >
                                   <td height="20px" align="left" style="padding-top: 7px;"><input id="terms" type="checkbox" name="terms">
<a style="text-decoration: underline; font-size: 11px;" target="_blank" href="http://livecalls.hk/users/terms"> I accept the Terms & Conditions</a><br />
                                   </td>
                              </tr>
                              <tr>
                                   <td height="15px"></td>
                              </tr>
                              <tr>
                                   <td align="left"> </td>
                              </tr>
                         </table>

<?php echo $form->submit('bt-login.png', array('id' => 'submit','style' => 'margin-left:-195px')); ?>

                         <div style="float: left;
                              margin-left: 526px;
                              margin-top: -32px;">

<?php // echo $html->link($html->image("bt_testroom.png"), array('controller'=>'reports', 'action' => 'testcalls'), array('escape' => false,'id' => "btntest")); ?>



                         </div>
                    </div>
                    <!--<div id="footer">© 2012 Live Call. All rights reserved.</div>-->
               </div>
          </div>
     </body>
</html>

