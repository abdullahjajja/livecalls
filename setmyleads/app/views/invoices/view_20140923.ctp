
<?php
$r_id = $this->Session->read('Auth.User.role_id');
$states = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
     <head>
          <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
          <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <title>Livecalls</title>

          <style>
               .over01{width:800px;
                       height:auto;
                       float:left;
                       margin-bottom:40px;
               }
               .obj01{width:460px;
                      height:140px;
                      float:left;
                      padding:3px 0;
                      margin:0 4px;
                      margin-bottom: 10px;
                      border:#CCC 2px solid ;
                      box-shadow: 3px 3px 3px #666666;

               }
               .obj02{width:460px;
                      height:80px;
                      float:left;
                      padding:3px 0;
                      margin:0 4px;
                      margin-bottom: 10px;
                      border:#CCC 2px solid ;
                      box-shadow: 3px 3px 3px #666666;

               }
               .objlogo{width:auto;
                        height:auto;
                        float:right;

                        margin:3px 0;


               }
               .logo-01{width:auto;
                        height:auto;
                        float:left;

                        padding:3px;



               }
               .obja{width:54%;
                     padding-left:1%;
                     height:auto;
                     float:left;
                     margin:2px 0;
                     font-family:Arial, Helvetica, sans-serif;
                     font-size:14px;
                     color:#333;
                     text-align:left;
                     text-transform:capitalize;
               }
               .objb{width:44%;
                     padding-left:1%;
                     height:auto;
                     float:left;
                     margin:2px 0;

                     font-family:Arial, Helvetica, sans-serif;
                     font-size:14px;
                     color:#333;
                     text-align:left;
                     text-transform:capitalize;
               }
               /*=================invoice 2===================*/
               .cat01{width:800px;
                      height:auto;
                      float:left;


               }
               .cat01head{width:790px;
                          height:auto;
                          float:left;
                          font-family:Arial, Helvetica, sans-serif;
                          text-align:left;
                          font-size:18px;
                          font-weight:bold;
                          color:#5B5B5B;
                          padding:5px 5px;
                          background-color:#d4d4d4;


               }
               .cat2{width:100%;

                     height:auto;
                     padding:2px 0%;
                     float:left;
                     border-bottom:1px #999 solid;
                     border-top:1px #999 solid;
                     border-left:1px #999 solid;
                     display:block;

               }

               .van01{width:35%;
                      height:auto;
                      float:left;
                      border-right:1px #999 solid;

                      font-family:Arial, Helvetica, sans-serif;
                      font-size:14px;
                      font-weight:bold;
                      color:#333;
                      text-align:center;
                      text-transform:capitalize;

               }
               .van02{width:20.1%;
                      height:auto;
                      float:left;
                      border-right:1px #999 solid;

                      font-family:Arial, Helvetica, sans-serif;
                      font-size:14px;
                      font-weight:bold;
                      color:#333;
                      text-align:center;
                      text-transform:capitalize;

               }
               .van03{width:12%;
                      height:auto;
                      float:left;
                      border-right:1px #999 solid;

                      font-family:Arial, Helvetica, sans-serif;
                      font-size:14px;
                      font-weight:bold;
                      color:#333;
                      text-align:center;
                      text-transform:capitalize;

               }
               .van01b{width:35%;
                       height:auto;
                       float:left;
                       border-right:1px #999 solid;

                       font-family:Arial, Helvetica, sans-serif;
                       font-size:14px;

                       color:#333;
                       text-align:left;
                       text-transform:capitalize;

               }
               .van02b{width:20.1%;
                       height:auto;
                       float:left;
                       border-right:1px #999 solid;

                       font-family:Arial, Helvetica, sans-serif;
                       font-size:14px;

                       color:#333;
                       text-align:right;
                       text-transform:capitalize;

               }
               .van03b{width:12%;
                       height:auto;
                       float:left;
                       border-right:1px #999 solid;

                       font-family:Arial, Helvetica, sans-serif;
                       font-size:14px;

                       color:#333;
                       text-align:right;
                       text-transform:capitalize;

               }
               .van03b1{width:12%;
                        height:auto;
                        float:left;
                        border-right:1px #999 solid;

                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;

                        color:#333;
                        text-align:left;
                        text-transform:capitalize;

               }
               .van0b{width:20.2%;
                      height:auto;
                      float:right;

                      margin-top:40px;
                      font-family:Arial, Helvetica, sans-serif;
                      font-size:24px;
                      font-weight:bold;
                      color:#333;
                      text-align:center;
                      text-transform:capitalize;

               }
               .van0bx{width:20.2%;
                       height:auto;
                       float:right;

                       margin-top:10px;
                       font-family:Arial, Helvetica, sans-serif;
                       font-size:18px;
                       font-weight:bold;
                       color:#333;
                       text-align:center;
                       text-transform:capitalize;
                       background-color:#d4d4d4;

               }
               .van0bx2{width:20.2%;
                        height:auto;
                        float:left;

                        margin-top:10px;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:18px;
                        font-weight:bold;
                        color:#333;
                        text-align:center;
                        text-transform:capitalize;
                        background-color:#d4d4d4;

               }
               .cat2c{width:100%;
                      margin-bottom: 40px;
                      height:auto;
                      padding:2px 0%;
                      float:left;
                      border-bottom:1px #999 solid;


                      display:block;

               }

               .btnvan{width:22%;
                       height:30px;

                       padding:4px 0;
                       float:left;
                       background-color:#D90005;
                       border:2px solid #CCC;

                       font-family:Arial, Helvetica, sans-serif;
                       font-size:24px;
                       font-weight:bold;
                       font-style:italic;
                       color:#333;
                       text-align:center;
                       text-transform:capitalize;
                       color:#FFF;
                       margin:30px 1%;
               }
               .btnvan2{width:22%;
                        height:30px;

                        padding:4px 0;
                        float:left;
                        background-color:#1057DA;
                        border:2px solid #CCC;

                        font-family:Arial, Helvetica, sans-serif;
                        font-size:24px;
                        font-weight:bold;
                        font-style:italic;
                        color:#333;
                        text-align:center;
                        text-transform:capitalize;
                        color:#FFF;
                        margin:30px 1%;
               }
               .btnvan3{width:22%;
                        height:30px;

                        padding:4px 0;
                        float:left;
                        background-color:#009933;
                        border:2px solid #CCC;

                        font-family:Arial, Helvetica, sans-serif;
                        font-size:24px;
                        font-weight:bold;
                        font-style:italic;
                        color:#333;
                        text-align:center;
                        text-transform:capitalize;
                        color:#FFF;
                        margin:30px 1%;
               }
               .fon{

                    color: #333;

                    font-family: Arial,Helvetica,sans-serif;
                    font-size: 14px;



                    text-transform: capitalize;

               }

               .btnvan:hover{background-color:#B70004;
               }
               .btnvan2:hover{background-color:#336699;
               }
               .btnvan3:hover{background-color:#006633;
               }


               .box{width:100%;
                    height:auto;
                    float:left;
               }
               .box-border{
                    border:1px solid #CCC;

               }

               .bnkrowmain{width:99%;
                           height:25px;
                           line-height:25px;
                           float:left;
                           font-family:Arial, Helvetica, sans-serif;
                           text-transform:capitalize;
                           box-shadow:1px 2px 2px #CCC;
                           background-color:#8C8C8C;
                           font-weight:bold;
                           font-size:18px;
                           color:#333;
                           padding-left:1%;
               }
               .bnkrow{width:97%;
                       height:25px;
                       line-height:25px;
                       float:left;


                       background-color:#d4d4d4;
                       font-weight:bold;
                       color:#666;
                       padding-left:3%;
                       font-family:Arial, Helvetica, sans-serif;
               }
               .bnkrow2{width:97%;
                        height:30px;

                        float:left;

                        border-top: solid 1px #CCC;



                        color:#666;
                        padding-left:5px;
                        padding-top: 5px;
               }
               .bnkac02{width:20%;
                        height:auto;
                        font-size:14px;
                        color:#666666;
                        text-transform:capitalize;
                        text-align:left;
                        float:left;
                        font-family:Arial, Helvetica, sans-serif;
                        border:#CCC solid 1px;
               }
               .bnkac01{width:26%;
                        height:auto;
                        font-size:14px;
                        color:#666666;
                        text-transform:capitalize;
                        text-align:left;
                        float:left;
                        font-family:Arial, Helvetica, sans-serif;
                        border:#CCC solid 1px;
               }
               .bnkrow2 label{width:98%;
                              padding:2% 0 2% 0.7%;
                              font-weight:700;
                              font-family:Arial, Helvetica, sans-serif;
                              float:left;

               }
               .bnkrow2 span{width:98%;
                             padding:2% 0 2% 0.7%;
                             font-family:Arial, Helvetica, sans-serif;
                             display:block;
                             float:left;

               </style>

               <script type="text/javascript">
                    $(document).ready(function() {
                         var invoice_id = '<?php echo $invoice['Invoice']['id']; ?>';
                         $.ajax({
                              url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'GetInvoiceDetail')); ?>",
                              type: "GET",
                              data: "invoice_id=" + invoice_id,
                              //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                              success: function(msg) {
                                   // alert(msg);
                                   $('#loading').css("display", "none");
                                   $('#detail').html('');
                                   $('#detail').append(msg);
                                   //$('#main').oneSimpleTablePagination({rowsPerPage: 200});
                              }
                         });
                    });
               </script>
          </head>


          <body>
               <?php //  print_r($invoice); ?>

               <div class="over01">
                    <div class="objlogo">
                         <div class="logo-01">

                              <?php
                              echo $this->Html->image('khalltel-logo.png');
                              ?>
                         </div></div>
                    <div style="float:left; width: 500px">


                              <div class="obj01">
                                   <div class="obja">invoice by :</div>
                                   <div class="objb"><?php echo $invoice['User']['first_name'] . ' ' . $invoice['User']['last_name']; ?></div>
                                   <div class="obja">Login Id :</div>
                                   <div class="objb"> <?php echo $invoice['User']['login']; ?></div>

                                   <div class="obja">Payment Terms :</div>
                                   <div class="objb"> <?php
                                        if ($invoice['Invoice']['isdaily'] == 0) {
                                             echo 'Weekly';
                                        } if ($invoice['Invoice']['isdaily'] == 1) {
                                             echo 'Daily';
                                        }if ($invoice['Invoice']['isdaily'] == 2) {
                                             echo 'Monthly';
                                        }
                                        ?></div>
                                   <div class="obja">Billing Period:</div>
                                   <?php
                                   if ($invoice['Invoice']['isdaily'] == 0) {
                                        $ed = new DateTime($invoice['Invoice']['date']);
                                        $tp = date("d M", strtotime($invoice['Invoice']['date'] . "-7 day")) . ' - ' . date("d M Y", strtotime($invoice['Invoice']['date'] . "-1 day"));
                                   } else if ($invoice['Invoice']['isdaily'] == 1) {
                                        $ed = new DateTime($invoice['Invoice']['date']);
                                        $tp = date("d M", strtotime($invoice['Invoice']['date'] . "-1 day")) . ' - ' . date("d M Y", strtotime($invoice['Invoice']['date'] . "-1 day"));
                                   } else if ($invoice['Invoice']['isdaily'] == 2) {
                                        $ed = new DateTime($invoice['Invoice']['date']);
                                        $tp = date("d M", strtotime($invoice['Invoice']['date'] . "-1 month")) . ' - ' . date("d M Y", strtotime($invoice['Invoice']['date'] . "-1 day"));
                                   }
                                   ?>

                                   <div class="objb"> <?php echo $tp; ?></div>
                                   <div class="obja">Credit Note Date:</div>
                                   <div class="objb"><?php echo $invoice['Invoice']['date']; ?></div>
                                   <div  class="obja" style="float:left;">email :</div>
                              <div class="objb" style="float:right ;"><?php echo $invoice['User']['email']; ?>
                              </div>
                         </div>
                         <div class="obj02">
                              <div class="obja">invoice To :</div>
                              <div class="objb">Khall Telecom</div>
                              <div class="obja">Name :</div>
                              <div class="objb"> bukhari ahmad</div>
                              <div class="obja">Address :</div>
                              <div class="objb">Khall Telecom UAE</div>


                         </div>
                    </div>

                    <!---------------invoice 2===============-->
                    <div id="detail">
                         <div class="cat01">
                              <div class="cat2">
                                   <div class="van01">billing period</div>

                                   <div class="van02">minutes</div>

                                   <div class="van03">curr.</div>
                                   <div class="van02">invoice total</div>
                              </div>

                              <!--    <div class="cat2" >
                                       <div class="van01b"><?php
                              //   $oneweekfromnow = strtotime("-7 days", strtotime($invoice['Invoice']['date']));
                              if ($invoice['Invoice']['isdaily'] == 0) {
                                   $ed = new DateTime($invoice['Invoice']['date']);
                                   echo date("d/m/y", strtotime("$ed -7 day")) . ' - ' . $ed->format('d/m/y');
                              } else if ($invoice['Invoice']['isdaily'] == 0) {
                                   $ed = new DateTime($invoice['Invoice']['date']);
                                   echo date("d/m/y", strtotime("$ed -1 day")) . ' - ' . $ed->format('d/m/y');
                              }
                              ?></div>

                                       <div class="van02b"><?php // echo $invoice['Invoice']['minutes'];                                                                                                                                                                                                            ?></div>
                                       <div class="van03b"><?php // echo $invoice['Invoice']['rate'];                                                                                                                                                                                                            ?></div>
                                       <div class="van03b"><?php // echo $invoice['Currency']['currency_name'];                                                                                                                                                                                                            ?></div>
                                       <div class="van02b"><?php //echo $invoice['Invoice']['invoice_total'];                                                                                                                                                                                                            ?></div>
                                  </div>
                             </div>-->

                              <div class="cat2c">
                                   <div class="van0b"><?php echo $invoice['InvoiceStatus']['name'] ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class='cat01'>

                    <?php
                    if ($invoice['User']['preference'] == 'Bank transfer') {
                         echo'<div class="box">
                            <div class="bnkrowmain"> bank Transfer</div>
                             ';
                         if (!empty($bank_detail_usd) || !empty($bank_detail_euro) || !empty($bank_detail_gbp)) {

                              echo '
                            <div class="bnkac02">
                            <div class="bnkrow"> bank account USD</div>

                            <div class="bnkrow2" style="background-color: #ebebeb;">
                            <label>Benificiary name</label>

                                   </div>
                                   <div class="bnkrow2">
                            <label>Account Number</label>

                                   </div>
                                   <div class="bnkrow2" style="background-color: #ebebeb;">
                            <label>Bank Name</label>

                                   </div>
                                   <div class="bnkrow2">
                            <label>Bank Address</label>

                                   </div>
                                    <div class="bnkrow2" style="background-color: #ebebeb;">
                            <label>SWIFT Code</label>

                                   </div>
                                  </div>
                              ';
                         }
                         if (!empty($bank_detail_usd)) {
                              $i = 0;
                              foreach ($bank_detail_usd as $b) {
                                   echo '
                            <div class="bnkac01">
                            <div class="bnkrow"> bank account USD</div>

                            <div class="bnkrow2"style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['beneficiary_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['account_number'] . '</span>
                                   </div>
                                   <div class="bnkrow2" style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['bank_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['bank_address'] . '</span>
                                   </div>
                                    <div class="bnkrow2" style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['swift_code'] . '</span>
                                   </div>
                              ';
                              }
                              echo '
                            </div>
                            ';
                         } else {
                              echo '


                            ';
                         }

                         if (!empty($bank_detail_euro)) {

                              foreach ($bank_detail_euro as $b) {
                                   echo '
                            <div class="bnkac01">
                            <div class="bnkrow"> bank account Detail EURO</div>

                            <div class="bnkrow2" style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['beneficiary_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['account_number'] . '</span>
                                   </div>
                                   <div class="bnkrow2" style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['bank_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['bank_address'] . '</span>
                                   </div>
                                    <div class="bnkrow2" style="background-color: #ebebeb;">

                            <span>' . $b['accounts_users']['swift_code'] . '</span>
                                   </div>
                              ';
                              }
                              echo '
                            </div>
                            ';
                         } else {
                              echo '


                            ';
                         }

                         if (!empty($bank_detail_gbp)) {
                              foreach ($bank_detail_gbp as $b) {
                                   echo '
                            <div class="bnkac01">
                            <div class="bnkrow"> bank account Detail GBP</div>

                            <div class="bnkrow2">

                            <span>' . $b['accounts_users']['beneficiary_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['account_number'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['bank_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">

                            <span>' . $b['accounts_users']['bank_address'] . '</span>
                                   </div>
                                    <div class="bnkrow2">

                            <span>' . $b['accounts_users']['swift_code'] . '</span>
                                   </div>
                              ';
                              }
                              echo '
                            </div>
                            ';
                         } else {
                              echo '


                            ';
                         }

                         echo '
                            </div>';
                    } else if ($invoice['User']['preference'] == 'Payoneer Transfer') {
                         echo'<div class="box">
                            <div class="bnkrowmain"> Payoneer Transfer</div>
                             ';
                         if (!empty($payoneer_detail)) {

                              foreach ($payoneer_detail as $b) {

                                   echo '
                            <div class="bnkac01">
                            <div class="bnkrow"> Payoneer Card Detail</div>

                            <div class="bnkrow2">
                            <label>Name</label>
                            <span>' . $b['payoneer_users']['name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">
                            <label>Card Number</label>
                            <span>' . $b['payoneer_users']['card_number'] . '</span>
                                   </div>
                                   <div class="bnkrow2">
                            <label>Date of Expiry</label>
                            <span>' . $b['payoneer_users']['date_expiry'] . '</span>
                                   </div>';
                              }
                              echo '
                            </div> </div>
                            ';
                         } else {
                              echo '

                            </div>
                            ';
                         }
                    } else if ($invoice['User']['preference'] == 'Western Union  Transfer') {
                         echo'<div class="box">
                            <div class="bnkrowmain">  Western Union / Money Gram Transfer</div>';
                         if (!empty($wire_detail)) {
                              foreach ($wire_detail as $b) {
                                   echo '
                            <div class="bnkac01">
                            <div class="bnkrow"> Western Union / Money Gram</div>

                            <div class="bnkrow2">
                            <label>Benificiary name</label>
                            <span>' . $b['wire_users']['name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">
                            <label>Contact Number</label>
                            <span>' . $b['wire_users']['mobile_number'] . '</span>
                                   </div>
                                   <div class="bnkrow2">
                            <label>City</label>
                            <span>' . $b['wire_users']['city_name'] . '</span>
                                   </div>
                                   <div class="bnkrow2">
                            <label>State</label>
                            <span>' . $b['wire_users']['state_name'] . '</span>
                                   </div>
                                    <div class="bnkrow2">
                            <label>Country</label>
                            <span>' . $b['wire_users']['country_name'] . '</span>
                                   </div>
                              ';
                              }
                              echo '
                            </div>  </div>
                            ';
                         } else {
                              echo '

                            </div>
                            ';
                         }
                    } else {

                         //   print_r($bank_detail);
                    }
                    ?>
               </div>
               <div class="cat01" id='temp'>
                    <div class="btnvan2" onclick='pri()'>print
                    </div>
                    <?php if ($r_id == 1) { ?>
                         <?php if ($invoice['Invoice']['invoice_status_id'] == 1) {
                              ?>
                              <div class="btnvan" onclick='change_status(<?php echo $invoice['Invoice']['id']; ?>, 3)'>reject
                              </div>
                              <div class="btnvan3" onclick='change_status(<?php echo $invoice['Invoice']['id']; ?>, 2)'>paid
                              </div>
                         <?php }if ($invoice['Invoice']['invoice_status_id'] == 3) { ?>
                              <div class="btnvan3" onclick='change_status(<?php echo $invoice['Invoice']['id']; ?>, 2)'>paid
                              </div>
                              <?php
                         }
                    }
                    ?>

               </div>

          </body>
          <script>

                    function change_status(id, a) {

                         //alert(id + ' ' + a);
                         $.ajax({
                              url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'ChangeInvoiceStatus')); ?>",
                              type: "GET",
                              data: "id=" + id + "&change=" + a,
                              //+ "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

                              success: function(msg) {
                                   location.reload();
                                   // alert(msg);
                                   //  $('#loading').css("display", "none");
                                   //$('#tdCalls').html('');
                                   //$('#tdCalls').append(msg);
                                   //$('#main').oneSimpleTablePagination({rowsPerPage: 200});
                              }
                         });
                    }
                    function pri() {
                         document.getElementById('temp').innerHTML = "";
                         window.print();
                    }
          </script>
     </html>


