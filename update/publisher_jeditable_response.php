<?php
require "credentials.php"; 
 
try{
	$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	echo $e->getMessage();
	die();
}

//for publishers
$statement = $conn->prepare("SELECT * FROM proj_publishers");
$statement->execute();

$post_id = $_POST['id'];
$post_value = $_POST['value'];

$tokens = explode("_", $post_id);


$sql = "UPDATE proj_publishers SET " . $tokens[1] . "=? WHERE publisherID=?";  
$q = $conn->prepare($sql);  
$q->execute(array($post_value,$tokens[0])); 

$sql = "SELECT " . $tokens[1] . " FROM proj_publishers WHERE publisherID=?";  
$q = $conn->prepare($sql);  
$q->execute(array($tokens[0])); 
$result = $q->fetchColumn();

echo $result;




?>