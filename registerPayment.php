<?php
require('database.php');
$query = 'SELECT *
          FROM booking
          ORDER BY bookingID';
$statement = $db->prepare($query);
$statement->execute();
$bookings = $statement->fetchAll();
$statement->closeCursor();
?>



<?php
// This script performs an INSERT query to add a record to the payment table.
session_start();
$page_title = 'Add Payment';

if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
    
} else {
   include('includes/header - Copy.html');
   
}



// Check for a valid payment ID, through GET or POST:
	if ( (isset($_GET['q']))) { // From loggedin.php
		$id = $_GET['q'];
    } elseif ( (isset($_POST['id']))) { // Form submission.
		$id = $_POST['id'];
	} else { // No valid ID, kill the script.
		echo '<p class="error">This page has been accessed in error.</p>';
		include('includes/footer.html');
		exit();
	}


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require('../mysqli_connect.php'); // Connect to the db.
	require_once('mysqli_connect.php');// Connect to the db.

	$errors = []; // Initialize an error array.

    //payment ID is auto incremented whenever a new record is made.

	//DropDown
	if (is_null($_POST['paymentMethod'])) {
		$errors[] = 'You forgot to select method.';
	} else {
		$me = mysqli_real_escape_string($dbc, trim($_POST['paymentMethod']));
	}


	// Check for an deposit:
		if (empty($_POST['deposit'])) {
			$errors[] = 'You forgot to enter your deposit amount.';
		} else {
			$de = mysqli_real_escape_string($dbc, trim($_POST['deposit']));
		}

	// Check for an amount:
	if (empty($_POST['amountPaid'])) {
		$errors[] = 'You forgot to enter the amount you have paid.';
	} else {
		$am = mysqli_real_escape_string($dbc, trim($_POST['amountPaid']));
	}


	if (empty($errors)) { // If everything's OK.

	
		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO payment (paymentDate, paymentMethod, deposit, amountPaid, bookingID) VALUES (NOW(), '$me', '$de', '$am', '$id')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>Payment is now registered!</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Payment could not be registered due to a system error. We apologize for any inconvenience.</p>';

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
<h1>Add Payment</h1>
<form action="registerPayment.php" method="post">


<!-- Value lookup -->
<label>Payment Method: </label>
    <select id="paymentMethod" name="paymentMethod" value="<?php if (isset($_POST['paymentMethod'])) echo $_POST['paymentMethod']; ?>" >                     
        <option value="null">--Select Method--</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
		<option value="Cheque">Cheque</option>
    </select>

	<p>Deposit: <input type="text" name="deposit" size="15" maxlength="7" value="<?php if (isset($_POST['deposit'])) echo $_POST['deposit']; ?>"></p>
	<p>Amount Paid: <input type="text" name="amountPaid" size="15" maxlength="50" value="<?php if (isset($_POST['amountPaid'])) echo $_POST['amountPaid']; ?>"></p>
    <input type="hidden" name="id" value="<?php echo $id?>">
	

<p><input type="submit" name="submit" value="Register Car"></p>

</form>

<?php
// Call the function 

include('includes/footer.html');
?>