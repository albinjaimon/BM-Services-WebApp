<?php
// this script is an developmental example of an inner join which I based all of my others on. This utilises the car table.

session_start();
$page_title = 'View the Current Cars';
include('includes/header - Copy.html');
echo '<h1>INNER JOIN EXAMPLE</h1>';

require_once('mysqli_connect.php');// Connect to the db.

// Define the query:
$q = "SELECT car.carRegPlate, car.carMake, car.carModel, car.user_id, users.first_name, users.last_name, users.email 
FROM users INNER JOIN car ON users.user_id = car.user_id";
$r = @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many cars there are:
	echo "<p>There are currently $num registered cars.</p>\n";


    //<th align="left"><strong>Edit</strong></th>
	// Table header:
	echo '<table width="80%">
	<thead>
	<tr>
		
		<th align="left"><strong>Car Registration Plate</strong></th>
		<th align="left"><strong>Car Make</strong></th>
        <th align="left"><strong>Car Model</strong></th>
		<th align="left">User ID</th>
		<th align="left"><strong>Forename</strong></th>
		<th align="left"><strong>Last Name</strong></th>
		<th align="left"><strong>Email</strong></th>

	</tr>
	</thead>
	<tbody>
	';


	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr>
			<td align="left">' . $row['carRegPlate'] . '</td>
			<td align="left">' . $row['carMake'] . '</td>
            <td align="left">' . $row['carModel'] . '</td>
			<td align="left">' . $row['user_id'] . '</td>
			<td align="left">' . $row['first_name'] . '</td>
			<td align="left">' . $row['last_name'] . '</td>
			<td align="left">' . $row['email'] . '</td>
		</tr>
		';
	}

	echo '</tbody></table>';
	mysqli_free_result ($r);

} else { // If no records were returned.
	echo '<p class="error">There are currently no registered cars.</p>';
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