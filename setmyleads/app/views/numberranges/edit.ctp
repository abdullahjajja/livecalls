<script type="text/javascript">
     function changetype()
     {
          if ($('#NumberrangeRoutetypeId').val() == '2')
          {
               $('#divfile').show();
               $('#divtextbox').hide();
          }
          else if ($('#NumberrangeRoutetypeId').val() == '4') {
               $('#divtextbox').hide();
          }
          else
          {
               $('#divfile').hide();
               $('#divtextbox').show();
          }

     }
     function loadivr() {
          $('#selectivr').toggle();
          if ($("#selectivr").is(":hidden")) {
               $('#NumberrangeIvrpath').show();
               $('#selecttxt').html("Select IVR");
          } else {
               $('#NumberrangeIvrpath').hide();
               $('#selecttxt').html("");

          }

     }

    function validateForm() {
      if ($('#NumberrangeBuyingrate').val() < $('#NumberrangeDailyrate').val()) {
        alert("Daily Rate should be less");
        console.log('daily');
        return false;
      }

       if ($('#NumberrangeBuyingrate').val() < $('#NumberrangeSellingrate').val()) {
        alert("Weekly Rate should be less");
        console.log('week');
        return false;
      }

       if ($('#NumberrangeBuyingrate').val() < $('#NumberrangeMonthlyrate').val()) {
        alert("Monthly Rate should be less");
        console.log('month');
        return false;
      }
      return true;
    }

</script>

<div id="maincontent">

     <?php echo $this->Form->create('Numberrange', array('type' => 'file', 'onsubmit'=> 'return validateForm()')); ?>

     <div class="mainheading">Edit Number Range</div>
     <div class="maincenterBg">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
               <tr>
                    <td align="left" valign="top"><table class="addtable" border="0">
                              <tr>
                                   <td colspan="4" class="h1">Edit Number Range</td>
                              </tr>

                              <tr>
                                   <?php echo $this->Form->input('id'); ?>

                                   <td width="33%">  <?php echo $this->Form->input('name', array('label' => ' Range Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>
                                   <td width="33%" ><?php echo $this->Form->input('operator_id', array('label' => ' Operator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>
                                   <td width="30%"><?php echo $this->Form->input('routetype_id', array('label' => ' Route Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'onchange' => 'changetype();')); ?></td>
                              </tr>

                              <tr>
                                   <td width="34%" id="divfile" style="display:none" >
                                        <div>

                                             <?php
                                             /*
                                               echo $this->Form->label('Browse File');
                                               echo '<br>File Name: '. $this->data['Numberrange']['ivrpath'];
                                               echo $this->Form->hidden('hdnfname', array('value'=>$this->data['Numberrange']['ivrpath']));
                                               echo $this->Form->file('ivrpath',array('style' => 'width:150px;height:20px;margin-top:5px;','type' => 'file'));
                                              */
                                             echo "<a herf='#' onclick='loadivr();'><div id='selecttxt'>Select IVR</div> </a>";
                                             ?>

                                             <div id="selectivr" style="display:none">

                                                  <?php
                                                  echo $this->Form->input('files', array('label' => 'IVR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'type' => 'select', 'options' => $Ivrs, 'style' => 'margin-left:10px;margin-top:5px;width:152px;height:20px'));
                                                  /*
                                                    echo "<select name='files' style:'width:20px'>";
                                                    $files = array_map("htmlspecialchars", scandir("../webroot/files/ivr/"));
                                                    foreach ($files as $file)
                                                    echo "<option value='$file'>$file</option>";
                                                    echo "</select>";
                                                   */
                                                  ?>
                                             </div>


                                        </div>
                                   </td>
                                   <td width="34%" id="divtextbox">
                                        <?php
                                        echo $this->Form->input('route', array('label' => ' Route&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;'));
                                        ?>
                                   </td>
                                   <td><?php echo $this->Form->input('currency_id', array('label' => ' Currency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>
								   <td width="10%" style="height:30px;"> 
										<?php	echo $this->Form->input('isringing', array('label' => ' Ringing &nbsp;','style' => 'width:100px;height:20px;margin-top:5px;','type' => 'checkbox'));?>
									</td>
                              </tr>
                              <tr>
                                   <td></td>
                                   <td></td>
                                   <td><?php     echo $this->Form->input('isfixed', array('label' => ' Fixed &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','style' => 'width:100px;height:20px;margin-top:5px;','type' => 'checkbox'));?>
                                        
                                   </td>

                              </tr>
                              <tr>
                                   <td><?php echo $this->Form->input('buyingrate', array('value' => (float)$this->data['Numberrange']['buyingrate'],'label' => ' Buying Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'required' => 'requird')); ?></td>
                                   <td><?php echo $this->Form->input('calllimit', array('label' => 'Daily Limit/Range&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>

                                   <td><?php echo $this->Form->input('clilimit', array('label' => ' CLI Limit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'required' => 'requird')); ?></td>


                              </tr>

               </tr>

               <tr>
                    <td><?php echo $this->Form->input('minduraction', array('label' => ' Min Call Duration&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>
                    <td ><?php echo $this->Form->input('maxduration', array('label' => ' Max Call Duration&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>

                    <td><?php echo $this->Form->input('maxdailyminutes', array('label' => ' Daily Limit/DID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;')); ?></td>

               </tr>
               <tr>
                    <td><?php echo $this->Form->input('dailyrate', array('value' => (float)$this->data['Numberrange']['dailyrate'],'label' => ' Daily Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'required' => 'requird')); ?></td>

                    <td><?php echo $this->Form->input('sellingrate', array('value' => (float)$this->data['Numberrange']['sellingrate'],'label' => ' Weekly Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'required' => 'requird')); ?></td>

                    <td><?php echo $this->Form->input('monthlyrate', array('value' => (float)$this->data['Numberrange']['monthlyrate'],'label' => 'Monthly Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'width:150px;height:20px;margin-top:5px;', 'required' => 'requird')); ?></td>

                    <td></td>
               </tr>
               <tr>
                    <td><?php echo $this->Form->input('daily_title', array('options' => $dailyTitle)); ?></td>
                    <td ><?php echo $this->Form->input('weekly_title', array('options' => $weeklyTitle)); ?></td>

                    <td><?php echo $this->Form->input('monthly_title', array('options' => $monthlyTitle)); ?></td>

               </tr>
          </table></td>
          </tr>
          </table>
          <div style="width:270px;float:right;margin-right:70px;">
               <?php echo $form->submit('bt-save.png', array('style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:left'))); ?>
               <a href="../index"> <?php echo $this->Html->image('bt-cancel.png', array('name' => 'cancel', 'id' => 'cancel', 'style' => 'margin-left:5px', 'div' => array('style' => 'width:135px;float:right'))); ?></a>

          </div>
          <?php echo $form->end(); ?>
     </div>
     <div class="mainbottomBg"></div>
</div>

<?php //echo $this->element('sql_dump'); ?>


<?php if ($this->data['Numberrange']['routetype_id'] == '2') { ?>
     <script>
          changetype();
     </script>
<?php } ?>