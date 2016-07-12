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

$genreSt = $conn->prepare("SELECT * FROM proj_genres");
$genreSt->execute();

$platformSt = $conn->prepare("SELECT platformID, platformName FROM proj_platforms");
$platformSt->execute();

$publisherSt = $conn->prepare("SELECT publisherID, publisherName FROM proj_publishers");
$publisherSt->execute();

$developerSt = $conn->prepare("SELECT developerID, developerName FROM proj_developers");
$developerSt->execute();
?>
<html>
<head>
<title>Add video game</title>
</head>
<body>
<h1>Add Video Game Information</h1>
<form action="addGame.php" method="post" name="frmAddGame">      
<table>
<tr><td>Game Title:</td><td><input id="txtGameTitle" name="txtGameTitle" type="text" value="" placeholder="Title" /></td></tr>
<tr><td>Released Date:</td><td><input id="txtReleaseDate" name="txtReleaseDate" type="text" value="" placeholder="mm/dd/yyyy" /></td></tr>
<tr><td>Genre:</td><td><select id="selGenre" name="selGenre" />
	<?php while($row = $genreSt->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='";
			echo $row['genreID'] . "'>";
			echo $row['genreName'];
			echo "</option>\n";
		}
	echo "</select>\n"; 
	?>
	</td></tr>
<tr><td>Platform:</td><td><select id="selPlatform" name="selPlatform" />
	<?php while($row = $platformSt->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='";
			echo $row['platformID'] . "'>";
			echo $row['platformName'];
			echo "</option>\n";
		}
	echo "</select>\n"; 
	?>
</td></tr>
<tr><td>Publisher:</td><td><select id="selPublisher" name="selPublisher" />
<option value="" >None</option>
	<?php while($row = $publisherSt->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='";
			echo $row['publisherID'] . "'>";
			echo $row['publisherName'];
			echo "</option>\n";
		}
	echo "</select>\n"; 
	
	?>
</td></tr>
<tr><td>Developer:</td><td><select id="selDeveloper" name="selDeveloper" />
<option value="" >None</option>
	<?php while($row = $developerSt->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='";
			echo $row['developerID'] . "'>";
			echo $row['developerName'];
			echo "</option>\n";
		}
	echo "</select>\n"; 
	?>
</td></tr>
</table>
 <input id="btnSubmit" type="submit" value="Add New Game" />
</form>

<h1>Add Publisher Information</h1>
<form action="addPublisher.php" method="post" name="frmAddPublisher">      
<table>
<tr><td>Publisher Name:</td><td><input id="txtPublisherName" name="txtPublisherName" type="text" value="" placeholder="" /></td></tr>
<tr><td>Year Founded:</td><td><input id="txtYearFounded" name="txtYearFounded" type="text" value="" placeholder="yyyy" /></td></tr>
<tr><td>Headquarters:</td><td><input id="txtHeadquarters" name="txtHeadquarters" type="text" value="" placeholder="" /></td></tr>


</td></tr>
</table>
 <input id="btnSubmit" type="submit" value="Add New Publisher" />
</form>


<h1>Add Developer Information</h1>
<form action="addDeveloper.php" method="post" name="frmAddDeveloper">      
<table>
<tr><td>Developer Name:</td><td><input id="txtDeveloperName" name="txtDeveloperName" type="text" value="" placeholder="" /></td></tr>
<tr><td>Year Founded:</td><td><input id="txtYearFounded" name="txtYearFounded" type="text" value="" placeholder="yyyy" /></td></tr>
<tr><td>Publisher:</td><td><select id="selPublisher" name="selPublisher" />
<option value="" >None</option>
	<?php
	$publisherSt2 = $conn->prepare("SELECT publisherID, publisherName FROM proj_publishers");
	$publisherSt2->execute(); 
	while($row = $publisherSt2->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='";
			echo $row['publisherID'] . "'>";
			echo $row['publisherName'];
			echo "</option>\n";
		}
	echo "</select>\n"; 
	
	?>
</td></tr>

</table>
 <input id="btnSubmit" type="submit" value="Add New Developer" />
</form>



</body>
</html>

<?php
$sql = $conn->prepare("INSERT INTO proj_games (gameTitle, platformID, genreID, releaseDate, publisherID, developerID)" .
       "VALUES (:gameTitle, :platformID, :genreID, :releaseDate, :publisherID, :developerID)");

	   $gameTitle = $_POST['txtGameTitle'];
	   $releaseDate = $_POST['txtReleaseDate'];
	   $genreID = $_POST['selGenre'];
	   $platformID = $_POST['selPlatform'];
	   	if($_POST['selPublisher'] === ''){
			$publisherID = null;
		}else {
			$publisherID = $_POST['selPublisher'];
		}
		if($_POST['selDeveloper'] === ''){
			$developerID = null;
		}else {
			$developerID = $_POST['selDeveloper'];
		}
	   //$publisherID = $_POST['selPublisher'];
	   //$developerID = $_POST['selDeveloper'];

	   
$sql->execute(array( 
'gameTitle' => $gameTitle, 
'platformID' => $platformID,
'genreID' => $genreID, 
'releaseDate' => $releaseDate,
'publisherID' =>$publisherID,
'developerID' => $developerID
)
);

?>