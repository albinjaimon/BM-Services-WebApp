<?php
// This page enables the owner to add parts to be used in a booking
require('database.php');
$query = 'SELECT *
          FROM parts
          ORDER BY partID';
$statement = $db->prepare($query);
$statement->execute();
$part = $statement->fetchAll();
$statement->closeCursor();

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
// This script performs an INSERT query to add a record to the jobPart link table.
session_start();
$page_title = 'Add part to job';


if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}

// The booking ID is placed into variable after passed through query string
if (isset($_GET['id'])) { // QUERY STRING from loggedin.php
	$id = $_GET['id'];
    } elseif ( (isset($_POST['id']))) { // Form submission.
		$id = $_POST['id'];

    } else { // No valid ID, kill the script.
	    echo '<p class="error"> This page has been accessed in error.</p>';
	    include('includes/footer.html');	    
}



// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require('../mysqli_connect.php'); // Connect to the db.
	require_once('mysqli_connect.php');// Connect to the db.

	$errors = []; // Initialize an error array.
    

	// Check for a make:

	// Check for an mileage:

    if (empty($_POST['partID'])){
        $errors[]= "Select part ";
    } else {
		$pa = mysqli_real_escape_string($dbc, trim($_POST['partID']));
	}


    if (empty($_POST['amountUsed'])){
        $errors[]= "amount ";
    } else {
		$am = mysqli_real_escape_string($dbc, trim($_POST['amountUsed']));
	}





	if (empty($errors)) { // If everything's OK.

	
		// Register the user in the database...

		// Make the query, this query selects name and price from part table based of the part ID selected from dropdown.
		$q = "INSERT INTO jobPartLink (bookingID, partID, partName, partPrice, amountUsed) VALUES ('$id', '$pa', (SELECT partName FROM parts WHERE partID = $pa), (SELECT partPrice FROM parts WHERE partID = $pa),'$am')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		    <p>Part has been added for the job! </p><p><br></p>';
		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Part could not be registered due to a system error. We apologize for any inconvenience.</p>';

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


<!-- FORM FOR ADD PART FOR JOB-->
<h1>Add parts for a job</h1>

<form action="registerJobPart.php" method="post">
<body>

<!-- Job ID passed over through GET -->
<input type="hidden" name="id" value="<?php echo $id?>">


<!-- Table Lookup, on the foreign key -->
<label>Part ID:</label>
<select name="partID">
<?php foreach ($part as $parts) : ?>
    <option value="<?php echo $parts['partID']; ?>">
        <?php echo $parts['partID']; ?>
        <?php echo $parts['partName']; ?>
    </option>
<?php endforeach; ?>
</select>

<br>
<br>

<!-- Value Lookup, hard coded -->
<label>Amount Used: </label>
    <select id="amountUsed" name="amountUsed" value="<?php if (isset($_POST['amountUsed'])) echo $_POST['amountUsed']; ?>" >                     
        <option value="null">--Select Quanitity--</option>
        <option value="1">1</option>
        <option value="2">2</option>
		<option value="3">3</option>
    </select>
<br> 
    
<p><input type="submit" name="submit" value="Register Part Use"></p>

</form>
<br>
<br>


<h1> Current Parts in use</h1>

<?php
//VIEW CURRENT PARTS USED IN SPECIFIC BOOKING
require_once('mysqli_connect.php');
$q = "SELECT bookingID, partID, partName, partPrice, amountUsed FROM jobPartLink WHERE bookingID = $id ";
$r = @mysqli_query($dbc, $q);
$sum_total = $partPrice * $amountUsed;

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered parts for this jobs.</p>\n";




    //<th align="left"><strong>Edit</strong></th>
	// Table header:
	echo '<table width="100%">
	<thead>
	<tr>
		
		<th align="left"><strong>Booking ID</strong></th>
		<th align="left"><strong>Part ID</strong></th>
        <th align="left"><strong>Part Name</strong></th>
        <th align="left"><strong>Part Price</strong></th>
		<th align="left"><strong>Amount Used</strong></th>


	</tr>
	</thead>
	<tbody>
	';

    //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr>
			
			<td align="left">' . $row['bookingID'] . '</td>
			<td align="left">' . $row['partID'] . '</td>
            <td align="left">' . $row['partName'] . '</td>
            <td align="left">' . $row['partPrice'] . '</td>
			<td align="left">' . $row['amountUsed'] . '</td>

		</tr>
		';
	}

	echo '</tbody></table>';
	mysqli_free_result ($r);

} else { // If no records were returned.
	echo '<p class="error">There are currently no parts registered for this booking.</p>';
}

mysqli_close($dbc);
?>

</body>

<?php
// Call the function 

include('includes/footer.html');
?>