<?php
require('database.php');
$query = 'SELECT *
          FROM car
          ORDER BY user_id';
$statement = $db->prepare($query);
$statement->execute();
$users = $statement->fetchAll();
$statement->closeCursor();



// Page that displays results from customer car search


$page_title = 'Search your Current Cars';
#include('includes/header.html');
include('includes/header - Customer.html');

require_once('mysqli_connect.php');// Connect to the db.

?>
<html>

<body>

<style>

body {
	background-color: white;
	font-family: arial;
}


.container{
	width: 800px;
	background-color: white;
	padding: 30px;
	font-size:10px;
	
}

.dataoutput {
	padding-bottom: 25px;
    background-color: #bfbcb2;
    font-size:13px;
}
</style>


<h1>RESULTS: </h1>
<?php

echo "<p><a href=\"view_mycars.php\">Return to view cars page</a></p>";

?>


<!-- CONTAINER CLASS -->
<div class = "container">
<?php 


//pass query string value into variable
	if (isset($_POST['submit-searchMyCar'])){
		$criteria = filter_input(INPUT_POST,'search');
        $carField = $_POST['carField'];

// set userID to variable
        session_start();
        $userID = $_SESSION['user_id'];

		$sql = "SELECT * FROM car WHERE $carField LIKE '%$criteria%' AND user_id = $userID ";


		$result = mysqli_query($dbc,$sql);
		$queryResultReords = mysqli_num_rows($result);
	
// check if records have been collected    
	if ($queryResultReords >0) {
		while ($row = mysqli_fetch_assoc($result)) {
            //data output class
			echo "<div class ='dataoutput'>
			<h2>".$row['carRegPlate']."</h2>
			<h3>Make: ".$row['carMake']."</h3>
			<h3>Model: ".$row['carModel']."</h3>
            <h3>Mileage: ".$row['carMileage']."</h3> 
            <h3>Date Registered: ".$row['carDateRegistered']."</h3>
			</div>";
		} 
    } else {
		echo "No records";
	}

}




?>
<div>

</body>
</html>





