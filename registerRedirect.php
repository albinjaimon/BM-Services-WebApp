<?php
// The user is redirected here from login.php.

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
include('includes/header - Copy.html');
?>






<?php # Script - register.php 
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register User';


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require('../mysqli_connect.php'); // Connect to the db.
	require_once('mysqli_connect.php');// Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}

	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for an user address:
	if (empty($_POST['user_address'])) {
		$errors[] = 'You forgot to enter your address.';
	} else {
		$ad = mysqli_real_escape_string($dbc, trim($_POST['user_address']));
	}

	// Check for an user telephone:
	if (empty($_POST['user_telephone'])) {
		$errors[] = 'You forgot to enter your telephone number.';
	} else {
		    $tl = mysqli_real_escape_string($dbc, trim($_POST['user_telephone']));
	}

    // telephone number format check
    if (preg_match("/^[0]{1}[7]{1}[0-9]{9}$/",($_POST['user_telephone']))) {
        $tl = mysqli_real_escape_string($dbc, trim($_POST['user_telephone']));
    } else {
        $errors[] = 'please use the telephone format 07000000000';
    }
    

	// Check for an user role:
	if (empty($_POST['user_role'])) {
		$errors[] = 'You forgot to enter your user role.';
	} else {
		$rl = mysqli_real_escape_string($dbc, trim($_POST['user_role']));
	}

	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}

	if (empty($errors)) { // If everything's OK.

		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO users (first_name, last_name, email, pass, user_address, user_telephone, user_role, registration_date) VALUES ('$fn', '$ln', '$e', SHA2('$p', 512), '$ad', '$tl', '$rl', NOW() )";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>The user is now registered.!</p><p><br></p>';

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
<h1>Register User</h1>
<form action="registerRedirect.php" method="post">
	<p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></p>
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>User Address: <input type="text" name="user_address" size="20" maxlength="50" value="<?php if (isset($_POST['user_address'])) echo $_POST['user_address']; ?>" > </p>
	<p>User Telephone: <input type="text" name="user_telephone" size="20" maxlength="11" value="<?php if (isset($_POST['user_telephone'])) echo $_POST['user_telephone']; ?>" > </p>


    <!-- Value lookup -->
    <label>User Role: </label>
    <select id="user_role" name="user_role" value="<?php if (isset($_POST['user_role'])) echo $_POST['user_role']; ?>" >                     
        <option value="null">--Select Role--</option>
        <option value="Customer">Customer</option>
        <option value="Owner">Owner</option>
    </select>
    
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>

<?php
// Call the function 

include('includes/footer.html');
?>