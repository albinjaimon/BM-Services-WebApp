<?php
// This page displays the results from the search car function
session_start();
$page_title = 'View the Current Cars';
#include('includes/header.html');
include('includes/header - Copy.html');

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


<h1>Search Results for Car</h1>
<?php

echo "<p><a href=\"view_allcars.php\">Return to all cars</a></p>";

?>
<h5>RESULT(S) </h5>

<!-- CONTAINER CLASS -->
<div class = "container">
<?php 

	if (isset($_POST['submit-searchMyCar'])){
		$criteria = filter_input(INPUT_POST,'search');
        $carField = $_POST['carField'];
		//$sql = "SELECT * FROM users WHERE user_id LIKE '%$criteria%'";
		$sql = "SELECT car.carRegPlate, car.carMake, car.carModel, car.carMileage, car.carDateRegistered, car.user_id, users.first_name,
		users.last_name, users.email, users.user_telephone, users.user_address FROM users INNER JOIN car ON users.user_id = car.user_id WHERE $carField LIKE '%$criteria%'";
		$result = mysqli_query($dbc,$sql);
		$queryResultReords = mysqli_num_rows($result);
	
	if ($queryResultReords >0) {
        echo "<h1>$carField: $criteria</h1>";
		while ($row = mysqli_fetch_assoc($result)) {
            //data output class
            
            // table
			echo "<div class ='dataoutput'>
			<h2>Reg Plate: ".$row['carRegPlate']."</h2>
			<h3>Make: ".$row['carMake']."</h3>
			<h3>Model: ".$row['carModel']."</h3>
            <h3>Mileage: ".$row['carMileage']."</h3>
            <h3>Date Registered: ".$row['carDateRegistered']."</h3>
            <h3>UserID: ".$row['user_id']."</h3>
            <h4>Forename: ".$row['first_name']."</h4>
            <h4>Surname: ".$row['last_name']."</h4>
            <h4>Email: ".$row['email']."</h4>
            <h4>Email: ".$row['user_telephone']."</h4>
            <h4>Home Address: ".$row['user_address']."</h4>
            
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





