<?php
require "credentials.php"; 
 
try{
	$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	echo $e->getMessage();
	die();
}



//for developers
$statement = $conn->prepare("SELECT developerID, developerName FROM proj_developers");
$statement->execute();

$post_id = $_POST['id'];
$post_value = $_POST['value'];

$tokens = explode("_", $post_id);


$sql = "UPDATE proj_developers SET " . $tokens[1] . "=? WHERE developerID=?";  
$q = $conn->prepare($sql);  
$q->execute(array($post_value,$tokens[0])); 

$sql = "SELECT " . $tokens[1] . " FROM proj_developers WHERE developerID=?";  
$q = $conn->prepare($sql);  
$q->execute(array($tokens[0])); 
$result = $q->fetchColumn();

echo $result;




?>