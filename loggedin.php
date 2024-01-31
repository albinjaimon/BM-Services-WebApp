<?php 
// The user is redirected here from login.php.
//The page displays unique information dependant on the users role held in the session variables.

session_start(); // Start the session.


// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != sha1($_SERVER['HTTP_USER_AGENT']) )) {

	// Need the functions:
	require('includes/login_functions.inc.php');
	redirect_user();

}

// Set the page title and include the HTML header:
$page_title = 'Logged In!';
?>

<!-- CSS -->
<style>
section {
    float: left;
    width: 500px;
    padding-bottom: 1.5em;
}

footer {
    clear: both;
    margin-top: 1em;
    border-top: 2px solid black;
}
footer p {
    text-align: right;
    font-size: 80%;
    margin: 1em 0;
}
h1 {
    font-size: 200%;
    margin: 0;
    padding: .5em 0 .25em;
}
h2 {
    font-size: 130%;
    margin: 0;
    padding: .25em 0 .5em;
}
h3 {
    font-size: 200%;
    margin: 0;
    padding: .5em 0 .1em;
}
h1, h2 {
    color: white;
    padding-left:5px;
    //color: rgb(208, 133, 4);
}
ul {
    margin: 0 0 1em 0;
    padding: 0 0 0 2.5em;
}

a {
    color: rgb(41, 64, 124);
    //font-weight: bold;
}
a:hover {
    color: white;
    background-color: black;
    //color: rgb(208, 133, 4);
}
table {
    border: 1px black;
    border-collapse: collapse;
}
td, th {
    border: 1.5px dashed black;
    padding: .2em .3em .2em .3em;
    vertical-align: left;
    text-align: left;
}
form {
    margin: 0;
}
br {
    clear: left;
}
/* the styles for classes */
.right {
    text-align: right;
}
.last_paragraph {
	margin-bottom: 2em;	
}
.margin_top_increase {
	margin-top: 1em;	
}
.containername {
    width: 1520px;
    height: 90px;
    background-color: black;
    margin-top: 5px;
}

</style>

<?php

//<p><a href=\"logout.php\">Logout</a></p>

// uses session ID to determine if user is customer or owner and gives different header, therefore enables access rights.

if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}

// Print a customized message:
?>

<div class="containername">

<?php
echo 
"
<h1> Welcome {$_SESSION['first_name']} </h1>

<h2> You are logged in as {$_SESSION['user_role']} </h2>
";
?>

</div>

<?php
session_start();
//Place values in session into variables for use
$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];



// If customer --> display their current bookings and completed jobs
if ($userRole == 'Customer') {

    // If custome, then display their bookings
    echo "<h3> Your bookings: </h3>";
    require_once('mysqli_connect.php');// Connect to the db.

    // Define the query:
    // Only selects the specific users current bookings for security, done through userID var set before
    $q = "SELECT bookingID, bookingDate, workDescription, carRegPlate, user_id FROM booking WHERE user_id = $userID AND complete = '0' ORDER BY bookingDate ASC";
    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many bookings there are:
	    echo "<p>There is currently $num registered booking(s) with BM Services in your name.</p>\n";


        //<th align="left"><strong>Edit</strong></th>
	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
		
		    <th align="left"><strong>Booking ID</strong></th>
		    <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
		    <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>More Actions</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';


        //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
			
			    <td align="left">' . $row['bookingID'] . '</td>
			    <td align="left">' . $row['bookingDate'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
			    <td align="left">' . $row['user_id'] . '</td>
                <td align="left"><a href="view_bookingPayment.php?q=' . $row['bookingID'] . '">More</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no bookings in your name with BM Services.</p>';
    }


    //////////////////////////////////////////////////Completed JObs FOR A CUSTOMER
    session_start();
    $userID = $_SESSION['user_id'];
    $userRole = $_SESSION['user_role'];
    echo "<h3> Completed jobs for your cars: </h3>";
    require_once('mysqli_connect.php');
    
    // Define the query:
    // Display the users completed bookings and use INNER JOIN to display the cars details
    $q = "SELECT booking.bookingID, booking.bookingDate, booking.workDescription, booking.carRegPlate, booking.user_id, booking.complete, car.carMake, car.carModel FROM (booking INNER JOIN car ON booking.carRegPlate = car.carRegPlate) 
     WHERE complete = '1' AND booking.user_id = '$userID' ORDER BY bookingDate ASC";


    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many bookings there are:
	    echo "<p>There is currently $num jobs(s) done with BM Services.</p>\n";


        //<th align="left"><strong>Edit</strong></th>
	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
            <th align="left"><strong>Booking ID</strong></th>
		    <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
            <th align="left"><strong>Car Make</strong></th>
            <th align="left"><strong>Car Model</strong></th>
            <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>View Parts Used</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';


        //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
                <td align="left">' . $row['bookingID'] . '</td>
			    <td align="left">' . $row['bookingDate'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
                <td align="left">' . $row['carMake'] . '</td>
                <td align="left">' . $row['carModel'] . '</td>
                <td align="left">' . $row['user_id'] . '</td>
                 <td align="left"><a href="view_jobPart.php?id=' . $row['bookingID'] . '">View</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no completed jobs.</p>';
    }

    mysqli_close($dbc);

include('includes/footer.html');
}








// If owner --> Display all the current bookings and display all the completed jobs in the database
///////////////////OWNER/////////////////
else {
    echo "<h3>Upcoming MOTs: </h3>";
    require_once('mysqli_connect.php');// Connect to the db.

    // Define the query:
    // Displays all current cars which have an MOT coming up

    $q = "SELECT booking.bookingID, booking.bookingDate, booking.carRegPlate, car.carMake, car.carModel, car.carMileage
    FROM (booking INNER JOIN car ON booking.carRegPlate = car.carRegPlate) WHERE workDescription = 'MOT' AND bookingDate >=  '2021-04-05' AND bookingDate <= 'NOW()' ORDER BY bookingDate ASC";
    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many potential MOT bookings there are:
	    echo "<p>There is currently $num potential MOTs(s) for BM Services.</p>\n";


        //<th align="left"><strong>Edit</strong></th>
	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
            <th align="left"><strong>Car Registration Plate</strong></th>
            <th align="left"><strong>Car Make</strong></th>
            <th align="left"><strong>Car Model</strong></th>
            <th align="left"><strong>Car Mileage</strong></th>
		    <th align="left"><strong>Previous Booking Date</strong></th>
	    </tr>
	    </thead>
	    <tbody>
	    ';


	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
                <td align="left">' . $row['carRegPlate'] . '</td>
                <td align="left">' . $row['carMake'] . '</td>
                <td align="left">' . $row['carModel'] . '</td>
                <td align="left">' . $row['carMileage'] . '</td>
			    <td align="left">' . $row['bookingDate'] . '</td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no MOT jobs registered at BM Services.</p>';
    }
include('includes/footer.html');








    echo "<h3> Your jobs: </h3>";
    require_once('mysqli_connect.php');// Connect to the db.

    // Define the query:
    // Displays all current jobs to do and use inner join to display related fields for greater information

    $q = "SELECT booking.bookingID, booking.bookingDate, booking.workDescription, booking.carRegPlate, booking.user_id, booking.complete, car.carMake, car.carModel, car.carMileage,
    users.email, users.user_telephone FROM ((booking INNER JOIN car ON booking.carRegPlate = car.carRegPlate) 
    INNER JOIN users on car.user_id = users.user_id) WHERE complete = '0' ORDER BY bookingDate ASC";
    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many bookings there are:
	    echo "<p>There is currently $num registered jobs(s) with BM Services.</p>\n";


        //<th align="left"><strong>Edit</strong></th>
	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
		    <th align="left"><strong>Booking ID</strong></th>
            <th align="left"><strong>Complete</strong></th>
		    <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
            <th align="left"><strong>Car Make</strong></th>
            <th align="left"><strong>Car Model</strong></th>
            <th align="left"><strong>Car Mileage</strong></th>
		    <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>Email</strong></th>
            <th align="left"><strong>Tel Number</strong></th>
            <th align="left"><strong>Complete Job</strong></th>
            <th align="left"><strong>View Parts Used</strong></th>
            <th align="left"><strong>Delete</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';


	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
			    <td align="left">' . $row['bookingID'] . '</td>
                <td align="left">' . $row['complete'] . '</td>
			    <td align="left">' . $row['bookingDate'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
                <td align="left">' . $row['carMake'] . '</td>
                <td align="left">' . $row['carModel'] . '</td>
                <td align="left">' . $row['carMileage'] . '</td>
                <td align="left">' . $row['user_id'] . '</td>
			    <td align="left">' . $row['email'] . '</td>
                <td align="left">' . $row['user_telephone'] . '</td>
                <td align="left"><a href="updateComplete.php?q=' . $row['bookingID'] . '">Complete</a></td>
                <td align="left"><a href="registerJobPart.php?id=' . $row['bookingID'] . '">View</a></td>
                <td align="left"><a href="delete_bookingPayment.php?q=' . $row['bookingID'] . '">Delete Job</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no jobs currently at BM Services.</p>';
    }
include('includes/footer.html');

    //////////////////////////////////////////////////PAST JOBS////////////////////////////
    echo "<h3> Completed Jobs: </h3>";

    // Define the query:
    // Display all the past bookings that have been completed with business, use for governement inspections etc.
    $q = "SELECT booking.bookingID, booking.bookingDate, booking.workDescription, booking.carRegPlate, booking.user_id, booking.complete, car.carMake, car.carModel, car.carMileage,
    users.email, users.user_telephone FROM ((booking INNER JOIN car ON booking.carRegPlate = car.carRegPlate) 
    INNER JOIN users on car.user_id = users.user_id) WHERE complete = '1' ORDER BY bookingDate ASC";

    $r = @mysqli_query($dbc, $q);

    // Count the number of returned rows:
    $num = mysqli_num_rows($r);

    if ($num > 0) { // If it ran OK, display the records.

	    // Print how many complated bookings there are:
	    echo "<p>There is currently $num past jobs(s) with BM Services.</p>\n";


	    // Table header:
	    echo '<table width="100%">
	    <thead>
	    <tr>
            <th align="left"><strong>Booking ID</strong></th>
            <th align="left"><strong>Complete</strong></th>
            <th align="left"><strong>Booking Date</strong></th>
            <th align="left"><strong>Work Description</strong></th>
            <th align="left"><strong>Car Registration Plate</strong></th>
            <th align="left"><strong>Car Make</strong></th>
            <th align="left"><strong>Car Model</strong></th>
            <th align="left"><strong>Car Mileage</strong></th>
            <th align="left"><strong>User ID</strong></th>
            <th align="left"><strong>Email</strong></th>
            <th align="left"><strong>Tel Number</strong></th>
            <th align="left"><strong>View Parts Used</strong></th>
            <th align="left"><strong>Delete</strong></th>

	    </tr>
	    </thead>
	    <tbody>
	    ';

        
	    // Fetch and print all the records:
	    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		    echo '<tr>
                <td align="left">' . $row['bookingID'] . '</td>
                <td align="left">' . $row['complete'] . '</td>
                <td align="left">' . $row['bookingDate'] . '</td>
                <td align="left">' . $row['workDescription'] . '</td>
                <td align="left">' . $row['carRegPlate'] . '</td>
                <td align="left">' . $row['carMake'] . '</td>
                <td align="left">' . $row['carModel'] . '</td>
                <td align="left">' . $row['carMileage'] . '</td>
                <td align="left">' . $row['user_id'] . '</td>
                <td align="left">' . $row['email'] . '</td>
                <td align="left">' . $row['user_telephone'] . '</td>
                <td align="left"><a href="view_jobPart.php?id=' . $row['bookingID'] . '">View</a></td>
                <td align="left"><a href="delete_bookingPayment.php?q=' . $row['bookingID'] . '">Delete Job</a></td>
		    </tr>
		    ';
	    }

	    echo '</tbody></table>';
	    mysqli_free_result ($r);

    } else { // If no records were returned.
	    echo '<p class="error">There are currently no completed jobs at BM Services.</p>';
    }

    mysqli_close($dbc);
    include('includes/footer.html');
}


?>