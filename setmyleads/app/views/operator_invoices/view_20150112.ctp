
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
          <title>Untitled Document</title>

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
               .cat01{width:700px;
                      height:auto;
                      float:left;


               }
               .cat01head{width:690px;
                          height:auto;
                          float:left;
                          font-family:Arial, Helvetica, sans-serif;
                          text-align:left;
                          font-size:18px;
                          font-weight:bold;
                          color:#5B5B5B;
                          padding:5px 5px;
                          background-color:#EBEBEB;


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
                       background-color:#EBEBEB;

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
                        background-color:#EBEBEB;

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
               .btnvan:hover{background-color:#B70004;
               }
               .btnvan2:hover{background-color:#336699;
               }
               .btnvan3:hover{background-color:#006633;
               }


               .bank_detail{
                    width:700px;
                    height:auto;
                    float:left;

                    margin-top:20px;
                    font-family:Arial, Helvetica, sans-serif;
                    font-size:16px;
                    font-weight:bold;
                    color:#333;
                    text-align:center;
                    text-transform:capitalize;
               }



          </style>

          <script type="text/javascript">
               $(document).ready(function() {
                    var invoice_id = '<?php echo $operatorInvoice['OperatorInvoice']['id']; ?>';
                    $.ajax({
                         url: "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'GetOperatorInvoiceDetail')); ?>",
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
          <div >
               <div class="over01">
                    <div class="objlogo">
                         <div class="logo-01">

                              <?php
                              echo $this->Html->image('khalltel-logo.png');
                              ?>
                         </div></div>
                            <div style="float:left; width: 500px">
                        <div class="obj01">
                         <div class="obja">invoice By</div>
                         <div class="objb">Khall Telecom</div>
                         <div class="obja">Nmae</div>
                         <div class="objb"> bukhari ahmad</div>
                         <div class="obja">Address</div>
                         <div class="objb">Khall Telecom UAE</div>


                    </div>


                    <div class="obj02">
                         <div class="obja">invoice to</div>
                         <div class="objb"><?php echo $operatorInvoice['Operator']['name']; ?></div>

                         <div class="obja">Billing Period </div>
                         <?php
                         // echo $operatorInvoice['Operator']['isweekly'];
                         if ($operatorInvoice['Operator']['isweekly'] == 0) {
                              $ed = new DateTime($operatorInvoice['OperatorInvoice']['date']);
                              $tp = date("d/m/y", strtotime($operatorInvoice['OperatorInvoice']['date'] . "-1 month")) . ' - ' . $ed->format('d/m/y');
                         } else if ($operatorInvoice['Operator']['isweekly'] == 1) {

                              $ed = new DateTime($operatorInvoice['OperatorInvoice']['date']);
                              $tp = date("d/m/y", strtotime($operatorInvoice['OperatorInvoice']['date'] . "-7 day")) . ' - ' . $ed->format('d/m/y');
                         }
                         ?>
                         <div class="objb"> <?php echo $tp; ?></div>
                         <div class="obja">date</div>
                         <div class="objb"><?php echo $operatorInvoice['OperatorInvoice']['date']; ?></div>

                    </div>
                  </div>
               </div>

               <!---------------invoice 2===============-->
               <div id="detail">
                    <div class="cat01">
                         <div class="cat2">
                              <div class="van01">billing period</div>

                              <div class="van02">minutes</div>

                              <div class="van03">cur.</div>
                              <div class="van02">invoice total</div>
                         </div>

                         <!--    <div class="cat2" >
                                  <div class="van01b"><?php
                         //   $oneweekfromnow = strtotime("-7 days", strtotime($invoice['Invoice']['date']));
//                         if ($invoice['Invoice']['isdaily'] == 0) {
//                              $ed = new DateTime($invoice['Invoice']['date']);
//                              echo date("d/m/y", strtotime("$ed -7 day")) . ' - ' . $ed->format('d/m/y');
//                         } else if ($invoice['Invoice']['isdaily'] == 0) {
//                              $ed = new DateTime($invoice['Invoice']['date']);
//                              echo date("d/m/y", strtotime("$ed -1 day")) . ' - ' . $ed->format('d/m/y');
//                         }
                         ?></div>

                                  <div class="van02b"><?php // echo $invoice['Invoice']['minutes'];                                                                            ?></div>
                                  <div class="van03b"><?php // echo $invoice['Invoice']['rate'];                                                                            ?></div>
                                  <div class="van03b"><?php // echo $invoice['Currency']['currency_name'];                                                                            ?></div>
                                  <div class="van02b"><?php //echo $invoice['Invoice']['invoice_total'];                                                                            ?></div>
                             </div>
                        </div>-->

                         <div class="cat2c">
                              <div class="van0b"><?php // echo $invoice['InvoiceStatus']['name']                                        ?>
                              </div>
                         </div>
                    </div>

               </div>
          </div>
          <div class='bank_detail'>
               <?php
               if ($operatorInvoice['Operator']['usd_account'] != '') {
                    echo '<div>';
                    echo 'USD Account  <br> <pre>' . $operatorInvoice['Operator']['usd_account'];
                    echo '</pre></div>';
               }
               if ($operatorInvoice['Operator']['euro_account'] != '') {
                    echo '<div>';
                    echo 'EURO Account <br> <pre>' . $operatorInvoice['Operator']['euro_account'];
                    echo '</pre></div>';
               }
               if ($operatorInvoice['Operator']['gbp_account'] != '') {
                    echo '<div>';
                    echo 'DBP Account  <br> <pre>' . $operatorInvoice['Operator']['gbp_account'];
                    echo '</pre></div>';
               }
               ?>
          </div>
          <div class="cat01" id='temp'>
               <div class="btnvan2" onclick='pri()'>print
               </div>


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


