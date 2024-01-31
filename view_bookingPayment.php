<style>
input {
	padding: 0px 20px;
	width: 300px;
	height: 40px;
	background-color: silver;
}


button {
	width: 400px;
	height: 44px;
	font-size: 20px;
}
</style>



<?php
// This script enables a specific booking to be shown in a table, where the user can add payement or delete the job.
//The bookings shown are determined by the session varaible (user_id).
// Both owner and customer can add payments

session_start();
$userRole = $_SESSION['user_role'];

$page_title = 'View the Current Booking';
if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}


session_start();
$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

if ($userRole == 'Customer') {
    
    require_once('mysqli_connect.php');// Connect to the db.


	//The booking ID is passed over query string.
	if ( isset($_GET['q'])) { // From view_users.php
		$id = $_GET['q'];    
	} elseif ( isset($_POST['id'])) { // Form submission.
		$id = $_POST['id'];
	
	} else { // No valid ID, kill the script.
		echo '<p class="error"> This page has been accessed in error.</p>';
		include('includes/footer.html');
		exit();
	}

    echo "<h1>Booking: $id</h1>";


    // Define the query:
    //$q = "SELECT carRegPlate, carMake, carModel, carMileage, DATE_FORMAT(carDateRegistered, '%M %d, %Y') AS dr, user_id, carRegPlate FROM car ORDER BY carDateRegistered ASC";
    $q = "SELECT bookingID, DATE_FORMAT(bookingDate, '%M %d, %Y') AS bd, workDescription, carRegPlate, user_id FROM booking WHERE bookingID = '$id' ORDER BY bookingDate ASC";
    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.



	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
		
		    <h1><th align="left"><strong>Booking ID</strong></th></h1>
		    <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
		    <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>Add Payment</strong></th>
            <th align="left"><strong>Delete</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';


        //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
			
			    <td align="left">' . $row['bookingID'] . '</td>
			    <td align="left">' . $row['bd'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
			    <td align="left">' . $row['user_id'] . '</td>
                <td align="left"><a href="registerPayment.php?q=' . $row['bookingID'] . '">Add Payment</a></td>
                <td align="left"><a href="delete_bookingPayment.php?q=' . $row['bookingID'] . '">Delete</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no bookings in your name with BM Services.</p>';
    }

    mysqli_close($dbc);

} else {
    echo "<h1> All bookings: </h1>";
    require_once('mysqli_connect.php');// Connect to the db.

    // Define the query:
    //$q = "SELECT carRegPlate, carMake, carModel, carMileage, DATE_FORMAT(carDateRegistered, '%M %d, %Y') AS dr, user_id, carRegPlate FROM car ORDER BY carDateRegistered ASC";
    $q = "SELECT bookingID, DATE_FORMAT(bookingDate, '%M %d, %Y') AS bd, workDescription, carRegPlate, user_id FROM booking ORDER BY bookingDate ASC";
    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many users there are:
	    echo "<p>There is currently $num registered booking(s) with BM Services.</p>\n";
		?>

<form action="SearchBooking.php" method="post">
<br>
<label>Booking Field: </label>
    <select name="bookingField">                 
        <option value="null">--Select Field--</option>
        <option value="bookingID">Booking ID</option>
        <option value="workDescription">Work Description</option>
        <option value="carRegPlate">Car Registration Plate</option>
		<option value="user_id">User ID</option>
    </select>

<br>

<input type="text" name="search" placeholder="Type your criteria">
<button type="submit" name="submit-searchMyBooking">SUBMIT SEARCH</button>
<br>
<br>






<?php
        //<th align="left"><strong>Edit</strong></th>
	    // Table header:
	    echo '<table width="80%">
	    <thead>
	    <tr>
		
		    <th align="left"><strong>Booking ID</strong></th>
		    <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
		    <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>Add Payment</strong></th>
            <th align="left"><strong>Delete</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';


        //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
			
			    <td align="left">' . $row['bookingID'] . '</td>
			    <td align="left">' . $row['bd'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
			    <td align="left">' . $row['user_id'] . '</td>
                <td align="left"><a href="registerPayment.php?q=' . $row['bookingID'] . '">Add Payment</a></td>
                <td align="left"><a href="delete_bookingPayment.php?q=' . $row['bookingID'] . '">Delete</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no bookings with BM Services.</p>';
    }

    mysqli_close($dbc);

}

?>
<?php

echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

?>

<?php
// Call the function 

include('includes/footer.html');
?>