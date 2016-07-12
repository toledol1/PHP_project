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

$statement = $conn->prepare("SELECT * FROM proj_games");
$statement->execute();

$statement2 = $conn->prepare("SELECT * FROM proj_publishers");
$statement2->execute();

$statement3 = $conn->prepare("SELECT * FROM proj_developers");
$statement3->execute();


?>
<html>
	<head>
		<title>Delete Video Game</title>
	</head>
	<body>
		<h1>Delete Video Game</h1>
		<form action="deleteGame.php" method="post" name="frmDeleteGame"> 
		<?php
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				echo "<input type='checkbox' name='chGame[]' id='chGame";
				echo $row['gameID'] . "' value='" . $row['gameID'] . "' />";
				echo "<label for='chGame" . $row['gameID'] . "'>" . $row['gameTitle'];
				echo "</label><br />\n";
			}

		?>
		<input id="btnSubmit" type="submit" value="Delete Games" />
		</form>
		
		<h1>Delete Publisher</h1>
		<form action="deletePublisher.php" method="post" name="frmDeletePublisher"> 
		<?php
			while($row = $statement2->fetch(PDO::FETCH_ASSOC)){
				echo "<input type='checkbox' name='chPublisher[]' id='chPublisher";
				echo $row['publisherID'] . "' value='" . $row['publisherID'] . "' />";
				echo "<label for='chPublisher" . $row['publisherID'] . "'>" . $row['publisherName'];
				echo "</label><br />\n";
			}

		?>
		<input id="btnSubmit" type="submit" value="Delete Publisher" />
		</form>
		
		<h1>Delete Developer</h1>
		<form action="deleteDeveloper.php" method="post" name="frmDeleteDeveloper"> 
		<?php
			while($row = $statement3->fetch(PDO::FETCH_ASSOC)){
				echo "<input type='checkbox' name='chDeveloper[]' id='chDeveloper";
				echo $row['developerID'] . "' value='" . $row['developerID'] . "' />";
				echo "<label for='chDeveloper" . $row['developerID'] . "'>" . $row['developerName'];
				echo "</label><br />\n";
			}

		?>
		<input id="btnSubmit" type="submit" value="Delete Developer" />
		</form>
		
	</body>
</html> 
<?php
$aGame = $_POST['chGame'];

if(empty($aGame)){
	echo "You didn't select any game.";
}else{
	$count = count($aGame);
	//echo "You're deleting the follow game(s): ";
	echo "Deleted Game.";
	
	for($i = 0; $i < $count; $i++) {
	//echo $aGame[$i] . " ";
       $sql = $conn->prepare("DELETE FROM proj_games WHERE gameID=" .$aGame[$i]."");
	   $sql->execute();
	}
}


?>
