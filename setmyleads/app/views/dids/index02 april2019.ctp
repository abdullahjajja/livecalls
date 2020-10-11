<?php
$globalvar = 0;
?>

<link href="../css/select2.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/select2.min.js"></script>

<style>
     #errormessage {
          color: #f00;
          font: bold 14px "Arial";
          text-align: left;
     }

.abutton{
     /*background-color: white;*/
     position: relative;
     float: right;
    color: white;
    border: 2px solid #4CAF50;
    padding: 2px 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin-left: 10px;
    }
    .abutton:hover{
     /*background-color: white;*/
     float: right;
    color: red;
    border: 2px solid #4CAF50;
    padding: 2px 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin-left: 10px;
    }  

</style>

<script type="text/javascript">
     var dataStore = window.sessionStorage;
     $(document).ready(function() {

        var name=getParameterByName('number');
      	$('#did').val(name);
      	
          $('#routing').prop('checked', true);
          if ($('#Routing1').is(':checked')) {

          }
          if ($('#Routing0').is(':checked')) {
               $('#ivr').hide();
               $('#ip').show();
          }
          $('#radio').click(function() {
               if ($('#Routing1').is(':checked')) {
                    $('#ip').hide();
                    $('#ivr').show();
               }
               if ($('#Routing0').is(':checked')) {
                    $('#ivr').hide();
                    $('#ip').show();
               }
          });

          // var a = $("[type=radio][name=" + routing + "]:checked").attr("value");

          // alert(a);
          var globvar = 0;
          $('#DidBuyrate').val($('#DidHdbuyrate').val());
          getdestinationgroup();

     });

     $(window).load(function() {


          var selid = dataStore.getItem('idd');
          $('#DidNumberrangeId').prop('selectedIndex', selid);
          var urll = (document.URL);
          // alert(urll);
          var n = urll.search("page");
          dataStore.setItem('pagefound', n);


     });

     function numberfilter() {
          //alert("called me");


          /** process team array here as if it were in the view **/

          var selindex = $('#DidNumberrangeId').prop("selectedIndex");
          var nmbselected = ($('#DidNumberrangeId').val());
          dataStore.setItem('idd', selindex);
          var ispagefound = dataStore.getItem('pagefound');

//alert(nmbselected);
          //window.location = ("/livecalls/dids/index?id=" + nmbselected);

          //window.location = ("/setmyleads/dids/index?id=" + nmbselected);
          window.location = ("/dids/index?id=" + nmbselected);


          return;
          $.ajax({
               url: "../dids/index",
               type: "GET",
               data: "id=" + nmbselected,
               success: function(msg) {
                    // alert("sucess");
                    // $('#maintbl').html('');
                    // $('#maintbl').append(msg);

                    alert(msg);
               },
               error: function() {

//alert("error");
               }
          });


     }


     function getdestinationgroup() {
          if (document.URL.indexOf('index') > 0) {
               // var path = "/setmyleads/api/getdestinationsmynm";
               //var path = "/api/getdestinationsmynm";
               var path = "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'getdestinationsmynm')) ?>";
          } else {

               //  var path = "/setmyleads/api/getdestinationsmynm";
               //   var path = "/api/getdestinationsmynm";
               var path = "<?php echo $this->Html->url(array('controller' => 'api', 'action' => 'getdestinationsmynm')) ?>";
          }

          $.ajax({
               url: path,
               type: "GET",
               //data:"cid=" + 1 + "& strdt=" + strdate + "& edt="+enddate + "& cld=" +called + "& clr=" +caller + "& sub=" +subcust,

               success: function(msg) {
                    //alert(msg);
                    $('#numb').html('');
                    $('#numb').append(msg);
                    $('#dest').css('display', 'none');
               },
               error: function(xhr, ajaxOptions, thrownError) {

                    //alert(thrownError);
//alert("error");
               }
          });
     }

     function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
     }


     function toggleall()
     {
          var data = $('input:checkbox[name="cbdid"[]]:not(:disabled)');
          if ($('#DidCbdidheader').attr('checked'))
          {
               data.attr('checked', 'checked');
               var didselected = '';
               data.each(function() {
                    if (didselected == '')
                    {
                         if ($(this).attr('id') != 'DidCbdidheader')
                                 //alert($(this).attr('disabled'));
                                 {
                                      didselected = $(this).attr('id');
                                 }
                    }
                    else {

                         var attr = $(this).attr('disabled');
                         if (attr == "disabled") {
//alert(attr);
                              $(this).removeAttr('checked');
                         } else {
                              didselected = didselected + "," + $(this).attr('id');

                         }
                    }
               });
               $('#DidHdnselected').val(didselected);
          }
          else
          {
               data.removeAttr('checked');
               $('#DidHdnselected').val('');
          }
     }
     function toggleone(id, test, buyrate)
     {
          $('#buyrate').val(id);
          //alert(id);
          if (test == 0) {
               var str = $('#DidHdnselected').val();
               str = str.replace(id + ",", "");
               str = str.replace(id, "");
               if ($('#' + id).attr('checked'))
               {
                    if (str == '')
                    {
                         str = id;
                    }
                    else
                    {
                         str = str + "," + id;

                    }
               }
               var brarray = JSON.parse($('#DidHdnbuyrate').val());
               if($('#' + id).prop('checked') == false){

                    var index = brarray.indexOf(buyrate);
                    if (index > -1) {
                        brarray.splice(index, 1);
                    }
               }

               else{
                    
                    brarray.push(buyrate);
               }


               $('#DidHdnselected').val(str);
              
               $('#DidHdnbuyrate').val(JSON.stringify(brarray));
          } else {
               alert("Test Dids Can't Assign");
               document.getElementById(id).checked = false;

          }
     }

     function validate()
     {
          if ($('#DidHdnselected').val() == "")
          {
               alert("Please Select DID(s)");
               return false;
          }
          if ($("#DidAssignTo").val() == "0")
          {
               alert("Please Select User");
               return false;
          }
          if (($("#DidCurrencyId").val() == "") && ('<?php echo $authUser ?>' != '1')) {
               alert("Please select currency first!");
               return false;
          }
///////////////////////////////////////////////////////////// check is applied for non admin user on 23 Jan 2014 on request of Bukhari sb
          if ($("#DidSellrate").val() == "" && ('<?php echo $authUser ?>' != '1')) {
               alert("Please Assign Selling Rate!");
               return false;
          }
//////////////////////////////////////////////////////////////
//    alert("i am here in");

//check for selling rate greater than buying rate//
          if(checkrate() == true){
                alert("Sale Rate can't be greater than buy Rate");
                $('#DidSellrate').val('');
                return false;
          }
          return true;
     }

     function validdel()
     {

          if (confirm("Are you sure you want to delete these DID's")) {
               if ($('#DidHdnselected').val() == "")
               {
                    alert("Please Select DID(s)");
                    return false;
               }

               $.ajax({
                    url: "../dids/bulkdelete",
                    type: "GET",
                    data: "hdnselected=" + $('#DidHdnselected').val(),
                    success: function(msg) {
                         alert('Numbers deleted successfully!!');
                         window.location.reload();
                    },
               });
               //    return true;
               //	document.forms[0].submit();


          }
     }

     function delete_orphan_records()
     {
          if (confirm("Are you sure you want to delete the DID's which have no Number Range!")) {
               console.log('yes');

                $.ajax({
                    url: "../dids/delete_orphan_dids",
                    type: "GET",
                    data: "",
                    success: function(msg) {
                         alert('orpahn records deleted successfully!!');
                         window.location.reload();
                    },
               });
          }
     }

function checkrate() {

          var sele = $('#DidSellrate').val();
          var buy = $('#DidHdnbuyrate').val();
          // alert(buy);
          buyarray = JSON.parse(buy);
          buyarray = $.unique(buyarray);
          for (var i = 0; i < buyarray.length; i++) {
               if (parseFloat(sele) > parseFloat(buyarray[i])) {
               // alert("Sale Rate can't be greateer than buy Rate");
               // $('#DidSellrate').val(' ');
                    return true;
               }    
          }

          
           return false;
      

     }

</script>
<script type="text/javascript">
     function searchuser() {
          //alert ("search called");

          if ($('#did').val()) {
               var nm = $('#did').val();
               //alert(nm);
               window.location = ("../dids/index?number=" + nm);
          }

          return;


     }
</script>
<?php if ($authUser == '1') { ?>
     <div  id="maincontent" >


          <fieldset  >
               <legend><?php __('Search DIDS'); ?></legend>
               <div style="margin-left: 15px">
                    <?php
                    echo $this->Form->input('did', array('label' => '&nbsp;Search by DID&nbsp;or Routing &nbsp;or Assign To', 'class' => 'inputbox132px', 'style' => 'width:500px;'));
                    echo $this->Form->submit('bt-search.png', array('type' => 'image', 'style' => 'float:left;margin-left:10px;margin-top:2px;', 'id' => 'btnsearch', 'name' => 'btnsearch', 'onclick' => 'searchuser();'));
                    //echo $html->link($html->image("bt-search.png"),  array('controller'=>'users/filteruser'), array('escape' => false,'id' => "btnsearch",'style'=>'float:left;margin-left:10px;margin-top:2px;'));
                    ?>
               </div>
          </fieldset  >

     </div>
<?php } ?>
<div id="maincontent" style=" background-color: #bdef9e">




     <?php echo $this->Form->create('Did', array('action' => 'index', 'type' => 'post')); ?>


     <fieldset  >
          <?php
          $pricesort = array(
              'asc' => 'Sort ASC'
          );
          ?>



          <select name="dest" style="border:1px solid #40C900;float: left;height: 20px; width: 102px;" id="dest">
               <option value="Any">Any</option>

          </select>
          <div id="numb"></div>

          <legend><?php __('DID Assignment'); ?></legend>

          <?php
          // print_r($users);
          echo $this->Form->input('assign_to', array('label' => '&nbsp;Assign To', 'type' => 'select', 'options' => $users, 'style' => 'margin-left:10px;margin-top:5px;width:122px;height:30px;color: black'));

          if ($authUser == '1') {
               //      echo "<div style='margin-left:10px;width:150px;float:left''><input type='radio' name='isdaily' value='1' checked>Weekly &nbsp <input type='radio' name='isdaily' value='0' >Daily</div>";
               echo "<div style='margin-left:10px;width:200px;float:left; border : none;'>" . $this->Form->input('isdaily', array('type' => 'radio', 'div' => false, 'legend' => 'Payment Terms', 'options' => array('1' => 'daily', '0' => 'weekly', '2' => 'monthly'), 'class' => '')) . "</div>";
          }
//            echo $this->Form->input('ivr_id',array('label'=>'&nbsp;Buying Rate&nbsp;&nbsp;', 'disabled'=>TRUE,'class'=>'inputbox132px','style'=>'width:55px;'));
//            echo $this->Form->lable("Buying Rate");
          if ($authUser == '1') {
               echo $this->Form->input('sellrate', array('label' => '&nbsp;Selling Rate&nbsp;&nbsp;', 'class' => 'inputbox132px', 'style' => 'width:35px;height:30px;margin-top:5px;'), array('id' => 'txtselling'));
          } else {
               echo $this->Form->input('sellrate', array('label' => '&nbsp;Selling Rate&nbsp;&nbsp;', 'class' => 'inputbox132px', 'style' => 'width:35px;height:30px;;margin-top:5px;'), array('id' => 'txtselling'));
          }
          if ($authUser == '1') {
               echo "<div id='radio' style='margin-left:10px;width:100px;float:left; border : none;'>" . $this->Form->input('routing', array('type' => 'radio', 'default' => '1', 'div' => false, 'legend' => 'Routing', 'id' => 'routing', 'options' => array('1' => 'Ivr', '0' => 'Ip'))) . "</div>";
               echo'<div id="ivr">';
               echo $this->Form->input('ivr_id', array('label' => '&nbsp;IVR', 'type' => 'select', 'options' => array('Select IVR') + $Ivrs, 'default' => ' ', 'style' => 'margin-left:10px;margin-top:5px;width:122px;height:30px;color: black'));
               echo'</div>';
               echo'<div id="ip" style="display: none">';
               echo $this->Form->input('ip_id', array('label' => '&nbsp;IPS', 'type' => 'select', 'options' => array('Select IPS') + $Ips, 'default' => ' ', 'style' => 'margin-left:10px;margin-top:5px;width:122px;height:30px;color: black'));
               echo'</div>';
          }
          echo $this->Form->submit('bt-assign.png', array('type' => 'image', 'style' => 'float:left;margin-left:10px;margin-top:4px;', 'id' => 'btnassign', 'name' => 'btnassign', 'onclick' => 'return validate()'));

          echo $this->Form->hidden('hdnselected');
          echo $this->Form->hidden('hdnbuyrate', array('value' => '[]'));
          ?>
     </fieldset>
</div>
<?php if ($authUser == '1') { ?>
<div  id="maincontent">


     <fieldset>
          <legend><?php __('Actions'); ?></legend>

          <?php 
          
          echo $this->Html->link(__('Add New', true), array('controller' => 'dids', 'action' => 'add'),array('class' => 'abutton'));
          echo $this->Html->link(__('Import', true), array('controller' => 'dids', 'action' => 'uploaddid'),array('class' => 'abutton'));
          echo $this->Html->link(__('Export CSV', true), array('controller' => 'api', 'action' => 'export_dids'),array('class' => 'abutton'));
          echo $this->Html->link(__('Add IP', true), array('controller' => 'ips', 'action' => 'index'),array('class' => 'abutton'));
          echo $this->Html->link(__('Del Dids', true), array('action' => 'delete_dids_csv'),array('class' => 'abutton'));


         
          ?>
           <div class="abutton" cursor:pointer;" id="del_orph_rec" onclick="return delete_orphan_records()">Del. orphan Dids</div>
            <div align="right" class="abutton" id = "btndelete" onclick="return validdel()">  <?php
                    if ($authUser == '1') {
                         echo 'Delete';
                         //   echo $this->Form->button('Delete', array('type' => 'text', 'id' => 'btndelete', 'name' => 'btndelete', 'onclick' => 'return validdel()'));
                    }
                    ?></div>

     </fieldset>

</div>
 <?php } ?> 

<div  id="maincontent">
     <div class="mainheading"><div align="left">DIDs List</div> <?php if ($authUser == '1') { ?>
    
               
                <?php } ?> </div>
     <div class="maincenterBg" id="maintbl">
          <table width="100%" border="0" cellspacing="0" cellpadding="10" >
               <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                   <td class="gridtable" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr>
                                                  <td class="gridtableHeader"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                                                            <tr>


                                                                 <td width="5%" align="center"><?php echo $this->Form->input('cbdidheader', array('label' => false, 'type' => 'checkbox', 'onclick' => 'toggleall()')); ?></td>
                                                                 <td width="10%" align="left" style=\"padding-left:10px;\"><?php echo ('&nbsp;Numberrange'); ?></td>
                                                                 <td width="10%" align="right" style="padding-right: 10px;"><?php echo ('DID'); ?></td>
                                                                 <td width="6%" align="center"><?php echo ('Buy Curr.'); ?></td>
                                                                 <td width="6%" align="center"><?php echo ('Sell Curr.'); ?></td>
                                                                 <td width="5%" align="center"><?php echo ('Buying Rt'); ?></td>

                                                                 <td width="5%" align="center"><?php echo ('Selling Rate'); ?></td>


                                                                 <?php
                                                                 if ($authUser != '4') {
                                                                      echo "<td width=\"12%\" align=\"left\" style=\"padding-left:10px;\"> Assigned To</td>";
                                                                 }
                                                                 ?>
                                                                 <?php if ($authUser == '1') { ?>
                                                                      <td width="5%" align="center"><?php echo ('Daily Limit'); ?></td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!--                      <td width="5%" align="center"><?php echo ('&nbsp;CLI Limit&nbsp;'); ?></td> -->
                                                                      <td width="10%" align="center"><?php echo ('Routing'); ?></td>
                                                                      <td width="10%" align="center"><?php echo ('Last Used Stamp'); ?></td>
                                                                      <td width="8%" align="center"><?php __('Actions'); ?></td>
                                                                 <?php } ?>

                                                            </tr>
                                                       </table></td>
                                             </tr>

                                             <tr>

                                                  <?php
                                                  $i = 0;

                                                  foreach ($dids as $did):
                                                       $class = ' class="grid2dark"';
                                                       if ($i++ % 2 == 0) {
                                                            $class = ' class="grid1light"';
                                                       }
                                                       ?>

                                                       <td <?php echo $class; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                                                 <tr>
                                                                      <?php
                                                                      $IsTest = 'false';
                                                                      if ($did['Did']['IsTestNumber'] == 1) {
                                                                           $IsTest = 'true';
                                                                      }
                                                                      ?>


                                                                      <td width="5%" align="center" class="gridcellborder"> <?php
                                                                      if ($authUser == '1') { 
                                                                           $buyratee = $did['Didrate'][0]['adminbuyrate'];
                                                                      }
                                                                      if($authUser == '2'){
                                                                           $buyratee = $did['Didrate'][0]['superresrate']; 
                                                                      }
                                                                      if ($authUser == '3') {
                                                                              $buyratee = $did['Didrate'][0]['ressellerrate'];                                                                            }

                                                                       echo $this->Form->input('cbdid_' . $did['Did']['id'], array('label' => false, 'id' => $did['Did']['id'], 'name' => 'cbdid', 'type' => 'checkbox', 'disabled' => $IsTest, 'onclick' => 'toggleone(' . $did['Did']['id'] . ',' . $did['Did']['IsTestNumber'] .','. $buyratee .')')); ?>  </td>

                                                                      <td width="10%" align="left" class="gridcellborder" style=\"padding-left:10px;\">&nbsp;
                                                                           <?php echo $did['Numberrange']['name'];
                                                                           ?>
                                                                      </td>
                                                                      <td width="10%" align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo $did['Did']['did']; ?></td>


                                                                      <?php
                                                                      $assignedto = 'N/A';
                                                                      if ($authUser == '1') {
                                                                           if (isset($did['DidsUser'][0]['superresseler_id'])) {
                                                                                $assignedto = $getuser->getUserNameById($did['DidsUser'][0]['superresseler_id']);
                                                                           }
                                                                      } else if ($authUser == '2') {
                                                                           if (isset($did['DidsUser']['resseller_id'])) {
                                                                                $assignedto = $getuser->getUserNameById($did['DidsUser']['resseller_id']);

                                                                                echo $this->Form->hidden('hdbuyrate', array('value' => $did['Didrate'][0]['superresrate']));
                                                                           }
                                                                      } else if ($authUser == '3') {
                                                                           if (isset($did['DidsUser']['subresseller_id'])) {
                                                                                $assignedto = $getuser->getUserNameById($did['DidsUser']['subresseller_id']);
                                                                                echo $this->Form->hidden('hdbuyrate', array('value' => $did['Didrate'][0]['ressellerrate']));
                                                                           }
                                                                      }
                                                                      ?>
                                                                      <?php
//		print_r($did);
                                                                      App::import('Helper', 'getcurrency'); // loadHelper('Html'); in CakePHP 1.1.x.x
                                                                      $getcurrency = new getcurrencyHelper();

                                                                      App::import('Helper', 'getivrname'); // loadHelper('Html'); in CakePHP 1.1.x.x
																		$getivr = new getivrnameHelper();																	  
																	  
																	  $ivrname = $getivr->getIVRName($did['Did']['ivr_id']);
																	  
                                                                      if ($authUser == '1') {
                                                                           if (isset($did['Didrate'][0]['admin_currency'])) {
                                                                                $buy_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['admin_currency']);
                                                                                $sell_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['supres_currency']);
                                                                           }
                                                                      } else if ($authUser == '2') {
                                                                           if (isset($did['Didrate'][0]['supres_currency'])) {
                                                                                $buy_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['supres_currency']);
                                                                                $sell_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['reseller_currency']);
                                                                           }
                                                                      } else if ($authUser == '3') {
                                                                           if (isset($did['Didrate'][0]['reseller_currency'])) {
                                                                                $buy_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['reseller_currency']);
                                                                                $sell_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['subres_currency']);
                                                                           }
                                                                      } else if ($authUser == '4') {
                                                                           if (isset($did['Didrate'][0]['subres_currency'])) {

                                                                                $buy_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['subres_currency']);
                                                                                $sell_curname = $getcurrency->getcurrencyNameById($did['Didrate'][0]['subres_currency']);
                                                                           }
                                                                      }
                                                                      ?>

                                                                      <td width="6%" align="left" style="padding-left: 5px;" class="gridcellborder"><?php echo $buy_curname; ?></td>
                                                                      <td width="6%" align="left" style="padding-left: 5px;" class="gridcellborder"><?php echo $sell_curname; ?></td>
                                                                      <?php if ($authUser == '1') { ?>
                                                                           <td width="5%" align="right" style="padding-right: 5px;"  class="gridcellborder"><?php echo number_format((float)$did['Didrate'][0]['adminbuyrate'], 3, '.', '');
                                                                           ?></td>
                                                                           <td width="5%"  align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo number_format((float)$did['Didrate'][0]['superresrate'], 3, '.', ''); ?></td>
                                                                      <?php } elseif ($authUser == '2') { ?>
                                                                           <td width="5%"  align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo $did['Didrate'][0]['superresrate']; ?></td>
                                                                           <td width="5%"  align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo $did['Didrate'][0]['ressellerrate']; ?></td>
                                                                      <?php } elseif ($authUser == '3') { ?>
                                                                           <td width="5%"  align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo $did['Didrate'][0]['ressellerrate']; ?></td>
                                                                           <td width="5%"  align="right" style="padding-right: 5px;" class="gridcellborder"><?php echo $did['Didrate'][0]['subresrate']; ?></td>
                                                                      <?php } ?>
                                                                      <?php
                                                                      if ($authUser != '4') {
                                                                           echo "<td width=\"12%\" align=\"left\" class=\"gridcellborder\" style=\"padding-left:10px;\">" . $assignedto . "</td>";
                                                                           echo $this->Form->hidden('hdbuyrate', array('value' => $did['Didrate'][0]['subresrate']));
                                                                      }
                                                                      ?>
                                                                      <?php if ($authUser == '1') { ?>
                                                                           <td width="5%" align="right" style="padding-right: 5px;" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                <?php echo $did['Did']['maxdailyminutes']; ?>
                                                                           </td>
                                                                           <!--
                                                                                          <td width="5%" align="left" class="gridcellborder" style=\"padding-left:10px;\">
                                                                           <?php // echo $did['Did']['perclilimit'];    ?>
                                                                                         </td>
                                                                         !-->
                                                                           <td width="10%" align="left" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                <!--<?php echo $did['Did']['ivr_id']; ?> -->
                                                                                <?php echo preg_replace("/\\.[^.\\s]{3,4}$/", "", $ivrname); ?>

                                                                           </td>
                                                                           <td width="10%" align="left" class="gridcellborder" style=\"padding-left:10px;\">
                                                                                <?php 
                                                                               if(strtotime($did['DidsUser'][0]['modified']) > strtotime($did['Did']['last_used']))
                                                                                      { 
                                                                                      echo "<span style='color: green;'>". $did['DidsUser'][0]['modified']. "</span>"; }
                                                                                       else{
																					   	    echo "<span style='color: red;'>". $did['Did']['last_used']. "</span>"; }
                                                                                
                                                                                ?>
                                                                           </td>

                                                                           <td width="8%" align="center" class="gridcellborder">
                                                                                <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $did['Did']['id'])); ?>
                                                                                <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $did['Did']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $did['Did']['id'])); ?>
                                                                           </td>
                                                                      <?php } ?>
                                                                 </tr>
                                                            </table></td>
                                                  </tr>
                                             <?php endforeach; ?>
                                        </table></td>
                              </tr>
                         </table></td>
               </tr>
          </table>
          <div style="text-align:center">
               <p>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
                    ));

                    /*

                      //extract the get variables
                      $url = $this->params['url'];
                      unset($url['url']);
                      print_r ($url);
                      echo "<br>";

                      $get_var = http_build_query($url);
                      print_r ($get_var );
                      echo "<br>";

                      $arg1 = array(); $arg2 = array();
                      //take the named url
                      if(!empty($this->params['named'])) {
                      $arg1 = $this->params['named'];
                      print_r($arg1);
                      echo "<br>";
                      } else {
                      echo ".... empty ...<br>";

                      }

                      //take the pass arguments
                      if(!empty($this->params['pass']))
                      $arg2 = $this->params['pass'];
                      print_r($arg2);
                      echo "<br>";


                      //merge named and pass
                      $args = array_merge($arg1,$arg2);
                      print_r($args);
                      echo "<br>";


                      //add get variables
                      $args["?"] = $get_var;

                      //$this->Paginator->options['url']['?'] = $get_var;

                      //$this->Paginator->options(array('url' => $this->passedArgs));

                      $this->Paginator->options(array('url' => $args));
                      /*

                      $urls = $this->params['url'];
                      $getv = "";
                      foreach($urls as $key=>$value)
                      {
                      if($key == 'url') continue; // we need to ignor the url field
                      $getv .= urlencode($key)."=".urlencode($value)."&"; // making the passing parameters
                      }
                      $getv = substr_replace($getv ,"",-1); // remove the last char '&'
                      print_r($getv);


                      $paginator->options(array('url' => array($this->passedArgs[0],"?"=>$getv)));

                     */

//In view file before any call to Paginator Helper
//$this->params['url'] contains all the query string with key and value
//print_r ($this->params['url'] );
//echo "....<br>";

                    $url_param = array_filter($this->params['url']);
//strip out any parameter which doen't have any value

                    unset($url_param['url']);
//its not the query string so unset it, its the path to our action with any parameter to it

                    $query_string = '';
//cteate the query string with key and value
                    foreach ($url_param as $key => $val) {
                         $query_string .= $key . '=' . $val;
                    }
//echo "<br>" . $query_string . ".......<br>";

                    $beginning = 'foo';
                    $end = array(1 => 'bar');
                    $result = array_merge((array) $beginning, (array) $end);
//print_r($result);
//set 'url' key which will be used by paginator helper to set our query string in pagination
//$options['url'] = array_merge($this->passedArgs, array('?'=> $query_string));
                    $options['url'] = array('?' => $query_string);
//echo "<br>";
//print_r($options);
//echo ("<br>");
//call the options function which will set options variable of Paginator Helpler
                    $this->Paginator->options($options);
//that's it. Now the Paginator will create links with our query string .
                    ?>	</p>




               <div class="paging" >
                    <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
                    | 	<?php echo $this->Paginator->numbers(); ?>
                    |
                    <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
                    <?php
                    //In view file before any call to Paginator Helper
                    //$this->params['url'] contains all the query string with key and
                    ?>
               </div>
          </div>
          <?php echo $this->Form->end(); ?>

     </div>
     <style>

          #DidNumberrangeId{
               margin-top: 5px;
          }

     </style>
     <div class="mainbottomBg"></div>
    <?php echo "livecalls"; ?>
    <?php 
echo $this->element('sql_dump');
 ?>
