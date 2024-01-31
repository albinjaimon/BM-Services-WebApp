<?php
// This page is for deleting a car record.
// This page is accessed through view_allcars.php view_carsCust.php.

session_start();

$page_title = 'Delete a Car';

// determine the user access, and show according nav bar.
if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}


echo '<h1>Delete a Car</h1>';

require('mysqli_connect.php');

// Check for a valid user ID, through GET or POST:
if ( isset($_GET['q'])) { // From view_users.php
	$id = $_GET['q'];    
} elseif ( isset($_POST['id'])) { // Form submission.
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
		$q = "DELETE FROM car WHERE carRegPlate='$id' LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The car has been deleted.</p>';

		} else { // If the query did not run OK.
			echo '<p class="error">The car could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
		}

	} else { // No confirmation of deletion.
		echo '<p>The car has NOT been deleted.</p>';
	}
	        

} else { // Show the form.

	// Retrieve the car informations only when the car is registered to the user logged in. This provides better security:
	$q = "SELECT carRegPlate FROM car WHERE carRegPlate = '$id' ";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid Reg Plate, show the form.

		// Get the car information:
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		// Display the record being deleted:
		echo "<h3>CarRegPlate: $row[0]</h3>
		Are you sure you want to delete this car?";

		// Create the form:
		echo '<form action="delete_car.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $id . '">
	</form>';

	} else { // Not a valid Reg Plate.
		echo '<p class="error">NO VALID REG. This page has been accessed in error.</p>';
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