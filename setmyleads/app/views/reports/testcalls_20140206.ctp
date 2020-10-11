<style>
#mydiv {
border: .2em dotted #900;
}
#border {
border-width: .2em;
border-style: dotted;
border-color: #900;
}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
</style> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript" src="http://108.178.8.201/livecalls/app/webroot/js/paging.js"></script>
<script type="text/javascript" src="http://108.178.8.201/livecalls/app/webroot/js/oneSimpleTablePaging-1.0.js"></script>
<script type="text/javascript">
/*
$(window).load(function(){
//getstory();

});
*/
$(document).ready(function() {
	hidemenu();
	GetTestNmLog();
	  $.ajax({
	      url: "../api/GetTestNumbers",
	      type: "GET",
	      success: function(msg){
		//alert(msg);
		  $('#tdCalls3').html('');
		  $('#tdCalls3').append(msg);
		//$('#main').oneSimpleTablePagination({rowsPerPage: 200});
	      },
		error:function(){
			alert("error");
		}

	  });
 });
  //setInterval( "GetTestNm()", 3000 );


function GetTestNmLog(){
	$.ajax({
	      url: "../api/GetTestNumbersLog",
	      type: "GET",
	      success: function(msg){
		  $('#tdCalls2').html('');
		  $('#tdCalls2').append(msg);
	       // $('#main2').oneSimpleTablePagination({rowsPerPage: 200});
                },
		error:function(){
			alert("error");
		}
	});
}

function hidemenu(){

	var querystring = location.search.replace('?', '').split('=')[1];
	if(querystring==1){
		$('#livecalllay').css("display","inline");
	}else{
		$('#livecalllay').css("display","none");
	}
	$('#story').css("display","none");

}


//function GetTestLiveCalls(){
//$.ajax({
  //                    url: "../api/getTestCalls",
    //                  type: "GET",

      //                success: function(msg){
                       // alert(msg);
        //                  $('#tdCalls1').html('');
          //                $('#tdCalls1').append(msg);
            //          },
//error:function(){

//alert("error");
//}
  //                });

//}

function getCalls(){   
	$.ajax({
	      url: "../api/getTestLiveCalls",
	      type: "GET",
	      data: "cid=1",
	      success: function(msg){
			$('#tdCalls1').html('');
			$('#tdCalls1').append(msg);
			//$('#main3').oneSimpleTablePagination({rowsPerPage: 200});
		}
	});
}

//setInterval( "GetTestLiveCalls()", 3000 );
setInterval( "getCalls()", 5000 );

</script>





<table>
<tr>
<td>

</td>
<td>

</td>
</tr>
<tr>
<td colspan="2">

</td>
</tr>
</table>

  <div id="maincontent">
<div id="inner">
                	<div class="mainheading">Live Calls <div align="right" style="margin-top: -15px" >
</div> </div>
					
                    <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable" id="tdCalls1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="7%" height="29px" align="center">Call Date </td>
                                     
                                      
                                      <td width="14%" align="center">Number Range</td>
                                     <td width="14%" align="center">Number</td>
                                    <td width="14%" align="center">Dur.Sec</td>
                                    <td width="14%" align="center">Cli</td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  
                                      
                                     
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td class="grid2dark"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                     
                                      
                                    </tr>
                                  </table></td>
                                </tr>
                                								
								
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
  <div class="mainbottomBg"></div>   

</div>    

</div>        
  </div>         
           	<div id="maincontent">
                	<div class="mainheading">Test Numbers </div>
                    <div class="maincenterBg">


<table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable" id="tdCalls3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="7%" height="29px" align="center">Number Range </td>
                                     
                                      <td width="14%" align="center">Number</td>
                                      
                                     
                                    </tr>
                                  </table></td>
                                </tr>
                                								
								
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                 
                </div>
             
     </div>           
            
   
<div id="maincontent">
                	<div class="mainheading">Top 100 Live Calls <div align="right" style="margin-top: -15px" >
</div> </div>
					
                    <div class="maincenterBg">
                      <table width="100%" border="0" cellspacing="0" cellpadding="10">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="gridtable" id="tdCalls2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="gridtableHeader"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="7%" height="29px" align="center">Call Date </td>
                                     
                                      
                                      <td width="14%" align="center">Number Range</td>
                                     <td width="14%" align="center">CLI</td>
                                    <td width="14%" align="center">Duration(Sec)</td>
                                    <td width="14%" align="center">Number</td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  
                                      
                                     
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td class="grid2dark"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                     
                                      
                                    </tr>
                                  </table></td>
                                </tr>
                                								
								
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>



                </div>
             

                </div>

<script type="text/javascript">
	$(function() {
		
		$("#txtstartdate").datepicker();
$('#txtstartdate').datepicker('option', 'dateFormat', 'yy-mm-dd');
       
        
	});
$(function() {
		$("#txtenddate").datepicker();
$('#txtenddate').datepicker('option', 'dateFormat', 'yy-mm-dd');
	});

	</script>