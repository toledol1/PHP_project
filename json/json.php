<!DOCTYPE HTML>
<html>
	<head>
		<title>Get Publisher Information</title>
	</head>
	<body>
		<h1>Get Publisher Information from Publisher ID</h1>
		<form action="json.php" method="get" name="frmJSON">
		<label for="txtID">Enter Publisher ID: </label>
		<input id="txtPublisherID" name="txtPublisherID" placeholder="1" />
		<input id="btnSubmit" type="Submit" value="Submit Publisher ID"  />
		</form>
	</body>
</html>

<?php
	error_reporting(E_ALL);  
	$id = $_GET['txtPublisherID'];
	//echo $id;

	require "credentials.php";  //The credentials file contains the variables $hostname, $database, $username, $password
 
	try{
		$conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e){
		echo $e->getMessage();
		die();
	}

	$statement = $conn->prepare("SELECT * FROM proj_publishers WHERE publisherID = ?");
	//http://stackoverflow.com/questions/1457131/php-pdo-prepared-statements
	
	$statement->execute(array($id));
	$results = $statement->fetch(PDO::FETCH_OBJ);  //should be at most one result
	print_r(json_encode($results));
?>
