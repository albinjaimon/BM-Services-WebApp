<?php
require('database.php');
$query = 'SELECT *
          FROM users
          ORDER BY user_id';
$statement = $db->prepare($query);
$statement->execute();
$users = $statement->fetchAll();
$statement->closeCursor();
?>



<?php
// This script performs an INSERT query to add a record to the cars table, but the foreign key is automatically set to the users.
session_start();
$page_title = 'Register Car';

if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
    
} else {
   include('includes/header - Copy.html');
   
}


session_start();
// user ID from session variable is placed into a vraible for the user to insert a car.
if(isset($_SESSION['user_id'])) {
	$id = $_SESSION['user_id'];
}


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require('../mysqli_connect.php'); // Connect to the db.
	require_once('mysqli_connect.php');// Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a reg:
	if (empty($_POST['carRegPlate'])) {
		$errors[] = 'You forgot to enter your Reg Plate.';
	} else {
		$rg = mysqli_real_escape_string($dbc, trim($_POST['carRegPlate']));
	}

    // Format check on the reg plate
    if (preg_match("/^[A-Z]{2}[0-9]{2}[A-Z]{3}$/",($_POST['carRegPlate']))) {
        $rg = mysqli_real_escape_string($dbc, trim($_POST['carRegPlate']));
    } else {
        $errors[] = 'Ensure Reg Plate is in correct format!';
    }

	// Check for a make:
	if (empty($_POST['carMake'])) {
		$errors[] = 'You forgot to enter your Car Make.';
	} else {
		$ma = mysqli_real_escape_string($dbc, trim($_POST['carMake']));
	}

	// Check for an model:
	if (empty($_POST['carModel'])) {
		$errors[] = 'You forgot to enter your Model.';
	} else {
		$mo = mysqli_real_escape_string($dbc, trim($_POST['carModel']));
	}

	// Check for an mileage:
	if (empty($_POST['carMileage'])) {
		$errors[] = 'You forgot to enter your mileage.';
	} else {
		$mi = mysqli_real_escape_string($dbc, trim($_POST['carMileage']));
	}


	if (empty($errors)) { // If everything's OK.

	
		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO car (carRegPlate, carMake, carModel, carMileage, carDateRegistered, user_id) VALUES ('$rg', '$ma', '$mo', '$mi', NOW(), '$id')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>Car is now registered. We will use this later to be able to book for your car!</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>

<!-- Form -->

<h1>Register Car</h1>
<form action="registerCarCust.php" method="post">
	<p>Registration Plate: <input type="text" name="carRegPlate" size="15" maxlength="7" value="<?php if (isset($_POST['carRegPlate'])) echo $_POST['carRegPlate']; ?>"></p>
	<p>Car Make: <input type="text" name="carMake" size="15" maxlength="50" value="<?php if (isset($_POST['carMake'])) echo $_POST['carMake']; ?>"></p>
	<p>Car Model: <input type="text" name="carModel" size="15" maxlength="50" value="<?php if (isset($_POST['carModel'])) echo $_POST['carModel']; ?>" > </p>
	<p>Car Mileage: <input type="carMileage" name="carMileage" size="20" maxlength="6" value="<?php if (isset($_POST['carMileage'])) echo $_POST['carMileage']; ?>" ></p>

    <p><input type="submit" name="submit" value="Register Car"></p>
</form>

<?php
// Call the function 

include('includes/footer.html');
?>