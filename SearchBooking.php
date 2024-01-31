<?php
// This page displays the results from the search booking function
session_start();
$page_title = 'View the Current Bookings';
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

<?php

echo "<p><a href=\"view_bookingPayment.php\">Return to all bookings</a></p>";

?>
<h5>RESULT(S) </h5>

<!-- CONTAINER CLASS -->
<div class = "container">
<?php 

	if (isset($_POST['submit-searchMyBooking'])){
		$criteria = filter_input(INPUT_POST,'search');
        $bookingField = $_POST['bookingField'];

        
		//$sql = "SELECT * FROM users WHERE user_id LIKE '%$criteria%'";
		$sql = "SELECT booking.bookingID, booking.bookingDate, booking.WorkDescription, booking.carRegPlate, booking.user_id, car.carMake, car.carModel,
		users.first_name, users.last_name, users.email, users.user_telephone FROM ((booking INNER JOIN car ON booking.carRegPlate = car.carRegPlate) 
		INNER JOIN users on car.user_id = users.user_id)
		WHERE $bookingField LIKE '%$criteria%'";

		$result = mysqli_query($dbc,$sql);
		$queryResultReords = mysqli_num_rows($result);
	
	if ($queryResultReords >0) {
		while ($row = mysqli_fetch_assoc($result)) {

            //data output class

            // echo below shows the field and the criteria for the users benefit 
            echo "<h1>$bookingField: $criteria</h1>";

            // table
			echo "<div class ='dataoutput'>
			<h2>Booking ID: ".$row['bookingID']."</h2>
			<h3>Booking Date: ".$row['bookingDate']."</h3>
			<h3>Work Description: ".$row['WorkDescription']."</h3>
            <h2>Reg Plate: ".$row['carRegPlate']."</h2>
			<h4>Car Make: ".$row['carMake']."</h4>
            <h4>Car Model: ".$row['carModel']."</h4>
            <h2>UserID: ".$row['user_id']."</h2>
            <h4>Forename: ".$row['first_name']."</h4>
            <h4>Surname: ".$row['last_name']."</h4>
			<h4>Email Address: ".$row['email']."</h4>
            <h4>Tel Number: ".$row['user_telephone']."</h4>
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





