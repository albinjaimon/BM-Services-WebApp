<?php
// This page is for deleting a booking record.

session_start();
$userRole = $_SESSION['user_role'];

$page_title = 'Delete a Booking';

if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}


echo '<h1>Delete a Booking</h1>';

require('mysqli_connect.php');

// Check for a valid user ID, through GET or POST:
if ( isset($_GET['q'])) { // From view_bookingPayment.php
	$id = $_GET['q'];    
} elseif ( isset($_POST['id'])) { // From Form submission.
	$id = $_POST['id'];

} else { // No valid ID, kill the script.
	echo '<p class="error"> This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}




// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM booking WHERE bookingID='$id' LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The booking has been deleted.</p>';

		} else { // If the query did not run OK.
			echo '<p class="error">The booking could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
		}

	} else { // No confirmation of deletion.
		echo '<p>The booking has NOT been deleted.</p>';
	}
	        

} else { // Show the form, for confirmation to the user.

	// Retrieve the booking information:
	$q = "SELECT bookingID, workDescription FROM booking WHERE bookingID = '$id' ";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// place the data into variable
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		// Display the record being deleted:
		echo "<h3>BookingId: $row[0]</h3>
		Are you sure you want to delete this booking?";

		// Create the form:
		echo '<form action="delete_bookingPayment.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $id . '">
	</form>';

	} else { // Not a valid Booking ID.
		echo '<p class="error">NO VALID BOOKING ID. This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.
mysqli_close($dbc);


?>

<?php

echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

?>
<?php
// Call the function 

include('includes/footer.html');
?>