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

    $('table.display').dataTable(
	{
        "columnDefs": [ 
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
    }
	
	);  


	$(".edit").editable("game_jeditable_response.php", { 
		tooltip   : "Click to edit...",
		style  : "inherit"
	});  //end of editable
	
	$(".edit2").editable("publisher_jeditable_response.php", { 
		tooltip   : "Click to edit...",
		style  : "inherit"
	});  //end of editable
	
	$(".edit3").editable("developer_jeditable_response.php", { 
		tooltip   : "Click to edit...",
		style  : "inherit"
	});  //end of editable
	
}); //end document ready 



</script>
<title>Edit Game Table</title>
</head>

<body>
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
<h1>Edit Game Information </h1>
<table border='1' id='data_table' class='display'>
<thead><tr>
	<th>Game ID</th>
	<th>Game Title</th>
	<th>Genre</th>
	<th>Platform</th>
	<th>Publisher</th>
	<th>Developer</th>
	<th>Release Date</th>
	
</tr></thead>
<?php 
$statement = $conn->prepare("SELECT g.gameID, g.gameTitle, x.genreName, y.platformName, 
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
	echo "<tr>\n";
	foreach ($row as $key => $value){

		echo "<td class='edit' id='" . $row['gameID'] . "_" . $key . "'>";
		echo $value;
		echo "</td>\n";
	}
	echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";


echo "<h1>Edit Publisher Information </h1>";
echo "<table border='1' id='data_table' class='display'>\n";
//print_r($describe->fetch(PDO::FETCH_ASSOC));
echo "<thead><tr>\n";
	echo "<th>Name</th>\n";
	echo "<th>Publisher Name</th>\n";
	echo "<th>Date Founded</th>\n";
	echo "<th>Headquarters</th>\n";
/*while($row = $describe->fetch(PDO::FETCH_NUM)){
		echo "<th>";
		echo $row[0];
		echo "</th>\n";
}
*/
echo "</tr></thead>\n";


$statement2 = $conn->prepare("SELECT * FROM proj_publishers");
$statement2->execute();

echo "<tbody>\n";
while ($row = $statement2->fetch(PDO::FETCH_ASSOC)){
	echo "<tr>\n";
	foreach ($row as $key => $value){

		echo "<td class='edit2' id='" . $row['publisherID'] . "_" . $key . "'>";
		echo $value;
		echo "</td>\n";
	}
	echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
?>

<h1>Edit Developer Information </h1>
<table border='1' id='data_table' class='display'>
<thead><tr>
	<th>developer ID </th>
	<th>Developer Name</th>
	<th>Year Founded</th>
	<th>Publisher</th>
	
</tr></thead>
<?php 

$statement3 = $conn->prepare("SELECT d.developerID, d.developerName, d.yearFounded, p.publisherName
							FROM proj_developers d LEFT JOIN proj_publishers p
								on d.publisherID = p.publisherID");
$statement3->execute();

echo "<tbody>\n";
while ($row = $statement3->fetch(PDO::FETCH_ASSOC)){
	echo "<tr>\n";
	foreach ($row as $key => $value){

		echo "<td class='edit3' id='" . $row['developerID'] . "_" . $key . "'>";
		echo $value;
		echo "</td>\n";
	}
	echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";
?>

</body>
</html>