<?php
require('fpdf.php');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'mypasswd');
//define('DB_PASSWORD', 'r5dh@t');
define('DB_NAME', 'livecalls');

$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Database connection failed: " . mysql_error());

$db_select = mysql_select_db(DB_NAME, $connection) or die("Database selection failed: {$host}" . mysql_error());
class PDF extends FPDF
{
//Load data
function LoadData($file)
{
    //Read file lines
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        //$data[]=explode(';',chop($line));
		$data[]=explode(',',chop($line));
    return $data;
}


//Colored table
function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $w=array(38,38,25,30,30,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(224,235,255);
	$this->SetFillColor(202,245,175);
	
	
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row['a1'],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row['a2'],'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row['a3'],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row['a4'],'LR',0,'R',$fill);
		$this->Cell($w[4],6,$row['a5'],'LR',0,'R',$fill);
        $this->Cell($w[5],6,$row['a6'],'LR',0,'R',$fill);
		
      
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();

$header=array("Numberrange","TestNumber","Currency","Max min.","Weekly Rates","Daily Rate");

$pdf->SetFont('Arial','',14);
$pdf->AddPage();

 $query = "SELECT numberranges.`name` AS a1 ,did AS a2 ,
IFNULL(currencies.`currency_name`,'nil') AS a3 , IFNULL(numberranges.`maxdailyminutes`,'nil') AS a4,
IFNULL(numberranges.`sellingrate`,'nil') AS a5, IFNULL(numberranges.`dailyrate`,0) AS a6
FROM dids
JOIN numberranges ON numberranges.`id`=dids.`numberrange_id`
JOIN currencies ON currencies.`id`=numberranges.`currency_id`
WHERE dids.`IsTestNumber`=1 ORDER BY numberranges.`name`";
          $data = mysql_query($query) or die(mysql_error());
		  $result= array();
while($row = mysql_fetch_assoc($data))
{
	//echo $row['a4'];
    $result[] = $row;
}
		//  die(print_r($result));
		  

$pdf->FancyTable($header,$result);

//$pdf->Output();

$filename="ratecard.pdf";
$pdf->Output($filename.'.pdf','F');

?>