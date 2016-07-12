<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<link rel="StyleSheet" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css" type="text/css" />
<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script>
$(document).ready(function() {

    $('#data_table').DataTable();

});

</script>
<title>Database Connection</title>
</head>

<body>
<h1>Video Games DataTable</h1>
<table border='1' id='data_table'>
<?php
error_reporting(E_ALL);  

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
?>

<thead><tr>
	<th>Game Title</th>
	<th>Genre</th>
	<th>Platform</th>
	<th>Publisher</th>
	<th>Developer</th>
	<th>Release Date</th>
	
</tr></thead>

<?php
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
echo "<tbody>\n";
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
	//using an associative array approach
	echo "<tr>\n";
	foreach ($row as $key => $value){
		echo "<td>";
		echo $value;
		echo "</td>\n";
	}
	echo "</tr>\n";
}
echo "</tbody>\n";


?>

</table>

<h3> Do one of the following: </h3>
<a href='add/addGame.php' > Add new game, publisher, or developer </a></br>
<a href='delete/deleteGame.php' > Delete a game, publisher, or developer </a></br>
<a href='update/update.php' > Edit a game, publisher, or developer </a></br>
<a href='pdf/pdf.php' > Make PDF </a></br>
<a href='json/json.php' > Make JSON </a></br>
<a href='#' > Advanced Search</a></br>

</body>
</html>