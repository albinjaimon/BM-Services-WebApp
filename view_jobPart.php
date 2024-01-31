<style>
input {
	padding: 0px 20px;
	width: 300px;
	height: 40px;
	background-color: silver;
}


button {
	width: 400px;
	height: 44px;
	font-size: 20px;
}
</style>



<?php
// This page is linked from the loggedin page and displays all the parts used in a booking

// create session and collect user details
session_start();
$userID = $_SESSION['user_id'];


$page_title = 'View the parts for job';



if (isset($_GET['id'])) { // QUERY STRING from loggedin.php
	$id = $_GET['id'];
    } elseif ( (isset($_POST['id']))) { // Form submission.
		$id = $_POST['id'];

    } else { // No valid ID, kill the script.
	    echo '<p class="error"> This page has been accessed in error.</p>';
	    include('includes/footer.html');	    
}



if ($_SESSION['user_role'] == 'Customer') {
    include('includes/header - Customer.html');
} else {
   include('includes/header - Copy.html'); 
}

echo "<h1>Parts used on Booking No. $id </h1>"; 


require_once('mysqli_connect.php');// Connect to the db.

// Define the query:
$q = "SELECT bookingID, partID, partName, partPrice, amountUsed FROM jobPartLink WHERE bookingID = '$id' ";
$r = @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many parts there are:
	echo "<p>There are currently $num registered parts for this job.</p>\n";
?>


<?php
	// Table header:
	echo '<table width="80%">
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

    $str = "bookingID={bookingID} & partID = {partID}";
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
<?php

echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

?>

<?php
// Call the function 

include('includes/footer.html');
?>