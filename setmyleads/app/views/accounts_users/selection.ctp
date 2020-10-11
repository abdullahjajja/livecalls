<?php
//$user_role = $this->Session->read('Auth.User.role_id');

$user_id = $user['User']['id'];
?>
<html >
     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <title>Untitled Document</title>
          <style>

               .bglcs{width:589px;
                      height:200px;
                      padding-top:5px;

                      background-color:#efefef;
                      border:#2f9300 solid 1px;
                      border-radius:15px;

                      margin:auto;
                      clear: both;
               }
               .objbox{width:311px;
                       height:auto;
                       margin:auto;

               }
               .bglcs2{width:589px;
                       height:80px;
                       padding-top:5px;

                       background-color:#efefef;
                       border:#2f9300 solid 1px;
                       border-radius:15px;

                       margin:auto;
                       clear: both;
                       margin-bottom: 10px;
               }
               .objbox2{width:311px;
                        height:auto;
                        margin:auto;

               }
               .aa{width:308px;

                   float:left;
                   border:1px solid #2f9300;
                   background-color:#e9f1e3;

                   margin-bottom:8px;
                   padding-left:1px;
               }
               .aa:hover{background-color:#d2ddc9;
               }

          </style>
          <script type='text/javascript'>
               $(document).ready(function() {
                    $.ajax({
                         // url: "/livecalls/api/get_status",
                         url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'get_status')); ?>",
                         type: "GET",
                         data: "pref=",
                         success: function(result) {
                              //   alert(result);
                              var res = result.charAt(0);

                              if (res == 'B') {
                                   $("#p1").attr('checked', 'checked');

                              }
                              if (res == 'W') {
                                   $("#p2").attr('checked', 'checked');
                              }
                              if (res == 'P') {
                                   $("#p3").attr('checked', 'checked');

                              }
                         }
                    });
                    $('#p1,#p2,#p3').change(function() {
                         var pref = '';
                         if ($("#p1").is(":checked")) {
                              pref = $("#p1").val();
                              change_stat(pref);
                         }
                         else if ($("#p2").is(":checked")) {
                              pref = $("#p2").val();
                              change_stat(pref);
                         }
                         else if ($("#p3").is(":checked")) {
                              pref = $("#p3").val();
                              change_stat(pref);
                         }
                    });
                    function change_stat(pref) {

                         $.ajax({
                              //url: "/livecalls/api/change_status",
                              url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'change_status')); ?>",
                              type: "GET",
                              data: "pref=" + pref,
                              success: function(result) {
                                   alert(result);
                              }
                         });
                    }

               });
          </script>
     </head>

     <body>
          <div class="mainheading">Accounts </div>
          <div class="bglcs2">

               <div class="objbox2">
                    <?php
                    echo $this->Html->link(
                            $this->Html->image('tab04.png', array('class' => 'aa')), array('controller' => 'invoices', 'action' => 'index', $user_id), array('escape' => false)
                    );
                    ?>
               </div>
          </div>
          <?php
          if ($this->Session->read('Auth.User.role_id') == 2) {
               ?>
               <div class="bglcs2">
                    <strong>Payment Preference </strong>
                    <div class="objbox2">
                         <div style="height: 20px">
                              <input type="radio" id='p1' name='preference'value='Bank transfer' style='float:left'>Bank Transfer<br>
                         </div>
                         <div  style="height: 20px">
                              <input type="radio" id='p2' name='preference' value='Western Union  Transfer' style='float:left'>Western Union  Transfer<br>
                         </div>
                         <div  style="height: 20px">
                              <input type="radio" id='p3' name='preference' value='Payoneer Transfer' style='float:left'>Payoneer Transfer<br>
                         </div>




                    </div>
               </div>
               <?php
          }
          ?>
          <div class="bglcs">

               <div class="objbox">

                    <?php
                    echo $this->Html->link(
                            $this->Html->image('tab01.png', array('class' => 'aa')), array('controller' => 'accounts_users', 'action' => 'index', $user_id), array('escape' => false)
                    );
                    ?>
                    <?php
                    echo $this->Html->link(
                            $this->Html->image('tab02.png', array('class' => 'aa')), array('controller' => 'wire_users', 'action' => 'index', $user_id), array('escape' => false)
                    );
                    ?>
                    <?php
                    echo $this->Html->link(
                            $this->Html->image('tab03.png', array('class' => 'aa')), array('controller' => 'payoneer_users', 'action' => 'index', $user_id), array('escape' => false)
                    );
                    ?>

               </div>
          </div>

     </body>
</html>
