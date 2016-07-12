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

$statement = $conn->prepare("SELECT * FROM proj_developers");
$statement->execute();


$sql = $conn->prepare("INSERT INTO proj_developers (developerName, yearFounded, publisherID)" .
       "VALUES (:developerName, :yearFounded, :publisherID)");

	    $developerName = $_POST['txtDeveloperName'];
	    $yearFounded = $_POST['txtYearFounded'];
		if($_POST['selPublisher'] === ''){
			$publisherID = null;
		}else {
			$publisherID = $_POST['selPublisher'];
		}
	   
$sql->execute(array( 
'developerName' => $developerName, 
'yearFounded' => $yearFounded,
'publisherID' => $publisherID
)
);
echo "Developer Added.";
?>