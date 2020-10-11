<?php 
if($session->read('Auth.User.role_id')) {
?>
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

<script type="text/javascript" src="http://108.178.8.202/livecalls/app/webroot/js/paging.js"></script>
<script type="text/javascript" src="http://108.178.8.202/livecalls/app/webroot/js/oneSimpleTablePaging-1.0.js"></script>
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
	      url: "../api/GetTNList",
	      type: "GET",
	      success: function(msg){
		//alert(msg);
		  $('#tdCalls3').html('');
		  $('#tdCalls3').append(msg);
		//$('#main').oneSimpleTablePagination({rowsPerPage: 200});
	      },
		error:function(){
			//alert("error");
		}

	  });
 });
  //setInterval( "GetTestNm()", 3000 );
function searchAlphabet(alpha) {

	  $.ajax({
	      url: "../api/GetTNList?alpha=" + alpha,
	      type: "GET",
	      success: function(msg){
		//alert(msg);
		  $('#tdCalls3').html('');
		  $('#tdCalls3').append(msg);
		//$('#main').oneSimpleTablePagination({rowsPerPage: 200});
	      },
		error:function(){
			//alert("error");
		}

	  });

}

function GetTestNmLog(){
	$.ajax({
	      url: "../api/GetTNLog",
	      type: "GET",
	      success: function(msg){
		  $('#tdCalls2').html('');
		  $('#tdCalls2').append(msg);
	       // $('#main2').oneSimpleTablePagination({rowsPerPage: 200});
                },
		error:function(){
			//alert("error");
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
	      url: "../api/getTNActiveCalls",
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
								<td>
									<a href="#" onclick = "searchAlphabet('A');">A</a>
									<a href="#" onclick = "searchAlphabet('B');">B</a>
									<a href="#" onclick = "searchAlphabet('C');">C</a>
									<a href="#" onclick = "searchAlphabet('D');">D</a>
									<a href="#" onclick = "searchAlphabet('E');">E</a>
									<a href="#" onclick = "searchAlphabet('F');">F</a>
									<a href="#" onclick = "searchAlphabet('G');">G</a>
									<a href="#" onclick = "searchAlphabet('H');">H</a>
									<a href="#" onclick = "searchAlphabet('I');">I</a>
									<a href="#" onclick = "searchAlphabet('J');">J</a>
									<a href="#" onclick = "searchAlphabet('K');">K</a>
									<a href="#" onclick = "searchAlphabet('L');">L</a>
									<a href="#" onclick = "searchAlphabet('M');">M</a>
									<a href="#" onclick = "searchAlphabet('N');">N</a>
									<a href="#" onclick = "searchAlphabet('O');">O</a>
									<a href="#" onclick = "searchAlphabet('P');">P</a>
									<a href="#" onclick = "searchAlphabet('Q');">Q</a>
									<a href="#" onclick = "searchAlphabet('R');">R</a>
									<a href="#" onclick = "searchAlphabet('S');">S</a>
									<a href="#" onclick = "searchAlphabet('T');">T</a>
									<a href="#" onclick = "searchAlphabet('U');">U</a>
									<a href="#" onclick = "searchAlphabet('V');">V</a>
									<a href="#" onclick = "searchAlphabet('W');">W</a>
									<a href="#" onclick = "searchAlphabet('X');">X</a>
									<a href="#" onclick = "searchAlphabet('Y');">Y</a>
									<a href="#" onclick = "searchAlphabet('Z');">Z</a>
								</td>
							</tr>	                            
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
                	<div class="mainheading">Top 100 Live Calls <div align="right" style="margin-top: -15px" >Duplicate Test calls on same destination numbers will not be displayed&nbsp;&nbsp;
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


<?php } ?>