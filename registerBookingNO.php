<?php
// select all the users
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
session_start();
// place value in the session variable into a variable for use
$userIDSelect = $_SESSION['user_id'];

require('database.php');
// select all the cars which have the foreign key from the session variable
$query = "SELECT *
          FROM car
          WHERE user_id = '$userIDSelect' ORDER BY carRegPlate";
$statement = $db->prepare($query);
$statement->execute();
$CarReg = $statement->fetchAll();
$statement->closeCursor();


session_start();
// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != sha1($_SERVER['HTTP_USER_AGENT']) )) {

	// Need the functions:
	require('includes/login_functions.inc.php');
	redirect_user();

}

?>

<?php
// This script performs an INSERT query to add a record to the booking table.
session_start();
$page_title = 'Make a booking';


if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}

session_start();
// place the users ID and role into variables
$userID = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require('../mysqli_connect.php'); // Connect to the db.
	require_once('mysqli_connect.php');// Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a make:
	if (empty($_POST['bookingDate'])) {
		$errors[] = 'You forgot to enter your bookingDate.';
	} else {
		$da = mysqli_real_escape_string($dbc, trim($_POST['bookingDate']));
	}

	// Check for an model:
	if (empty($_POST['WorkDescription'])) {
		$errors[] = 'You forgot to enter WorkDescription.';
	} else {
		$wd = mysqli_real_escape_string($dbc, trim($_POST['WorkDescription']));
	}

	// Check for an mileage:
	if (empty($_POST['carRegPlate'])) {
		$errors[] = 'You forgot to enter your CarRegPlate.';
	} else {
		$re = mysqli_real_escape_string($dbc, trim($_POST['carRegPlate']));
	}



	if (empty($errors)) { // If everything's OK.

	
		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO booking (bookingDate, WorkDescription, carRegPlate, user_id) VALUES ('$da', '$wd', '$re', '$userID')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		    <p>Your booking has been made! </p><p><br></p>';
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

<h1>Make Booking</h1>

<form action="registerBookingNO.php" method="post">
<body>
 
<?php
echo $email
?>

<label for="bookingDate">Booking Date:</label>
<input type="date" id="bookingDate" name="bookingDate" value="<?php if (isset($_POST['bookingDate'])) echo $_POST ['bookingDate']; ?>">

<br>


<p>Work Description: <input type="text" name="WorkDescription" size="15" maxlength="50" value="<?php if (isset($_POST['WorkDescription'])) echo $_POST ['WorkDescription']; ?>"></p>

<!-- place each car into the dropdown -->
<label>Car Reg:</label>
<select name="carRegPlate">
<?php foreach ($CarReg as $reg) : ?>
    <option value="<?php echo $reg['carRegPlate']; ?>">
        <?php echo $reg['carRegPlate']; ?>
        <?php echo $reg['carMake']; ?>
        <?php echo $reg['carModel']; ?>
    </option>
<?php endforeach; ?>
</select>

<br> 

 
    
<p><input type="submit" name="submit" value="Make Booking"></p>

</form>
</body>

<?php
// Call the function 

include('includes/footer.html');
?>