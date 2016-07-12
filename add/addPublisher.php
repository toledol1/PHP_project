<?php
error_reporting(E_ALL);  

require "credentials.php";

try{
	$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	//echo "<p>Database Connection OK.<p>";
} catch(PDOException $e){
	$conn->setArribute(PDO::ATT_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Could not open database.";
}

$statement = $conn->prepare("SELECT * FROM proj_publishers");
$statement->execute();


$sql = $conn->prepare("INSERT INTO proj_publishers (publisherName, dateFounded, headquarters)" .
       "VALUES (:publisherName, :dateFounded, :headquarters)");

	   $publisherName = $_POST['txtPublisherName'];
	   $dateFounded = $_POST['txtYearFounded'];
	   $headquarters = $_POST['txtHeadquarters'];

	   
$sql->execute(array( 
'publisherName' => $publisherName, 
'dateFounded' => $dateFounded,
'headquarters' => $headquarters
)
);
echo "Publisher Added.";
?>