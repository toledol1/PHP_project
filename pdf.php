<?php
//fpdf library location 
//downloaded from http://www.fpdf.org/
require("fpdf17/fpdf.php");

class MyPDF extends FPDF
{
	// change the empty footer method
	function footer(){
		$this->setY(-15);  // 1.5 cm from the bottom of the page
		$this->setFont("Arial","I", 8);
		$this->Cell(0,10,  $this->PageNo() . " of " . '{nb}',0,0,'R');	
	}	
}

$pdf = new MyPDF('L');   //  !!NOTE now instantiating an object of the extended class!!
$pdf->AliasNbPages();  // this is related to the {nb} above

//add the first page
$pdf->addPage();
$pdf->SetMargins(12,25.4,12,25.4);

//main title
$pdf->setFont("Arial", "B", 16); 
$pdf->cell(0,20,"Full Game Data");
$pdf->ln();

require "credentials.php";

try{
	$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	//echo "<p>Database Connection OK.<p>";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	//echo "Could not open database.";
	echo $e->getMessage();
	die();
}

$fields = array("Game Title","Genre","Platform","Publisher","Developer","Release Date");
$col_width = array(40,40,40,40,40,40);
$i=0;

$pdf->setFont("Arial", "B", 10); 
foreach($fields as $aField){
		$pdf->cell($col_width[$i],10,$aField,1,0);
		$i++;
}
$pdf->ln();

		
$statement = $conn->prepare("SELECT g.gameTitle, x.genreName, y.platformName, 
							p.publisherName, d.developerName, g.releaseDate
							FROM proj_games g LEFT JOIN proj_genres x
								on g.genreID = x.genreID
							LEFT JOIN proj_platforms y
								on g.platformID = y.platformID
							LEFT JOIN proj_publishers p
								on g.publisherID = p.publisherID
							LEFT JOIN proj_developers d
								on g.developerID = d.developerID");
$statement->execute();

$pdf->setFont("Arial", "", 10);	
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	//using an associative array approach
	$i=0;
	foreach ($row as $key => $value){
		$pdf->cell($col_width[$i],10,$value,1,0);
		$i++;
	}
	$pdf->ln();
}


$pdf->output();

?>