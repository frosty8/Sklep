<?php 
require_once '../Controllers/DatabaseManager.php';
require('../fpdf/fpdf.php');

header("Content-type: text/html; charset=iso-8859-2");

$databaseManager = new DatabaseManager();
$query = "SELECT O_ID, ord_date, final_price, status FROM `orders` WHERE orders.O_ID=".$_GET['order'];

if ($result = $databaseManager->getFromDatabase($query)) {

	$row = $result->fetch_assoc();		
	$friendlyFinal_price = str_replace(".", ",", $row['final_price'])." PLN";
/////////////////////////////////////////// Get the details (array) ///////////////////////////////////////
	$header = 'Order details';
	$details = array(
		'date' => 'Order date: '.$row['ord_date'],
		'cost' => 'Overall cost: '.$friendlyFinal_price,
		'orderID' => 'Order number: '.$row['O_ID'],
		'status' => $row['status']
	); 
/*////////////////////////////////////////////// Create PDF //////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial', 'B',16);
//////////////////////////////////////////////// Set header ///////////////////////////////////////////////////////
	$pdf->Cell(0,20,$header,1,1,'C');
	$pdf->Ln();
//////////////////////////////////////////////// Set details //////////////////////////////////////////////////////
	$pdf->SetFont('Times', '',16);
	foreach ($details as $row => $text) {
		$pdf->Cell(0,10,$text,0,1);
	}
//////////////////////////////////////////////// Show document ////////////////////////////////////////////////////
	$pdf->Output();
}
//////////////////////////////////////////////// UTF - 8 (UNSOLVED) //////////////////////////////////////////////////
$diakrytyczne = 'Zażółć gęślą jaźń';
$str = iconv('utf-8', 'iso-8859-2', $diakrytyczne); // UTF-8 Does not work... meh
?>