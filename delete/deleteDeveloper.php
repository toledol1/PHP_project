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

$aDeveloper = $_POST['chDeveloper'];

if(empty($aDeveloper)){
	echo "You didn't select a developer.";
}else{
	$count = count($aDeveloper);
	//echo "You're deleting the follow game(s): ";
	
	for($i = 0; $i < $count; $i++) {
	//echo $aGame[$i] . " ";
       $sql = $conn->prepare("DELETE FROM proj_developers WHERE developerID=" .$aDeveloper[$i]."");
	   $sql->execute();
	}
}

echo "Deleted Developer.";
?>