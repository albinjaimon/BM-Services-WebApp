<?php

session_start();

$page_title = 'Delete a Part used in job';

// place appropriate nav bar based on user role
if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}


echo '<h1>Delete a Part for Job</h1>';

require('mysqli_connect.php');

// Check for a valid user ID, through GET or POST:
if (isset($_GET['id'])) { // QUERY STRING from loggedin.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id']))) { // Form submission.
	$id = $_POST['id'];

} else { // No valid ID, kill the script.
	    echo '<p class="error"> This page has been accessed in error.</p>';
	    include('includes/footer.html');	    
}




// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM jobPartLink WHERE bookingID='$id' AND partID='$partid' LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The car has been deleted.</p>';

		} else { // If the query did not run OK.
			echo '<p class="error">The part could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
		}

	} else { // No confirmation of deletion.
		echo '<p>The car has NOT been deleted.</p>';
	}
	        

} else { // Show the form.

	// Retrieve the part and booking's information:
	$q = "SELECT bookingID, partID FROM jobPartLink WHERE bookingID = '$bookingID' AND partID = '$partID'  ";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the JobPart information:
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		// Display the record being deleted:
		echo "<h3>bookingID: $row[0]</h3>
		<h3>partID; $row[1]</h3>
		Are you sure you want to delete this part from the job?";

		// Create the form:
		echo '<form action="delete_jobPart.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $bookingID . '">
	<input type="hidden" name="partsid" value="' . $partID . '">
	</form>';

	} else { // Not a valid Reg Plate.
		echo '<p class="error">NO VALID PART + BOOKING ID. This page has been accessed in error.</p>';
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