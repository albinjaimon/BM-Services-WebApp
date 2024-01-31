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


<?php # Script - view_users2.php 
// This script retrieves all the records from the users table.
// This new version links to edit and delete pages.
session_start();

$page_title = 'View the Current Users';
include('includes/header - Copy.html');
echo '<h1>All Registered Users on the System</h1>';

require_once('mysqli_connect.php');// Connect to the db.

// Define the query:
$q = "SELECT last_name, first_name, email, user_telephone, user_address, user_role, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC";
$r = @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered users.</p>\n";
	?>

<form action="SearchUser.php" method="post">
<br>
<label>User Field: </label>
    <select name="userField">                 
        <option value="null">--Select Field--</option>
        <option value="user_id">User ID</option>
        <option value="first_name">Forename</option>
        <option value="last_name">Surname</option>
		<option value="email">Email</option>
		<option value="user_telephone">Telephone Num</option>
		<option value="user_address">Address</option>
		<option value="user_role">Role</option>
    </select>

<br>
<input type="text" name="search" placeholder="Type your criteria">
<button type="submit" name="submit-searchUser">SUBMIT SEARCH</button>
<br>
<br>


<?php
	// Table header:
	echo '<table width="100%">
	<thead>
	<tr>
		<th align="left"><strong>Edit</strong></th>
		<th align="left"><strong>Delete</strong></th>
		<th align="left"><strong>Last Name</strong></th>
		<th align="left"><strong>First Name</strong></th>
        <th align="left"><strong>Email</strong></th>
        <th align="left"><strong>Telephone Num</strong></th>
        <th align="left"><strong>Home Address</strong></th>
        <th align="left"><strong>User Role</strong></th>
		<th align="left"><strong>Date Registered</strong></th>
	</tr>
	</thead>
	<tbody>
	';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr>
			<td align="left"><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>
			<td align="left"><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>
			<td align="left">' . $row['last_name'] . '</td>
			<td align="left">' . $row['first_name'] . '</td>
            <td align="left">' . $row['email'] . '</td>
            <td align="left">' . $row['user_telephone'] . '</td>
            <td align="left">' . $row['user_address'] . '</td>
            <td align="left">' . $row['user_role'] . '</td>
			<td align="left">' . $row['dr'] . '</td>
		</tr>
		';
	}

	echo '</tbody></table>';
	mysqli_free_result ($r);

} else { // If no records were returned.
	echo '<p class="error">There are currently no registered users.</p>';
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