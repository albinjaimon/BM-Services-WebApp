<?php
// This page updates the boolean value of the job complete field.

session_start();

$page_title = 'Update Complete';

if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
    
} else {
   include('includes/header - Copy.html');
   
}

echo '<h1>Update Job Status</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['q'])) && (is_numeric($_GET['q'])) ) { // From view_users.php
	$id = $_GET['q'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}

require('mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
        // Ensure that the complete is = 0 before UPDATE
		$q = "UPDATE booking SET complete = '1' WHERE bookingID = $id AND complete = '0'";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The job has been updated.</p>';

		} else { // If the query did not run OK.
			echo '<p class="error">The process can not be comeplete due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
		}

	} else { // No confirmation of deletion.
		echo '<p>The job has not been set to complete.</p>';
	}

} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT bookingID FROM booking WHERE bookingID=$id";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		// Display the record being updated:
		echo "<h3>Booking ID: $row[0]</h3>
		Are you sure you want to process this job as complete?";

		// Create the form:
		echo '<form action="updateComplete.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $id . '">
	</form>';

	} else { // Not a valid booking ID.
		echo '<p class="error">This page has been accessed in error.</p>';
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