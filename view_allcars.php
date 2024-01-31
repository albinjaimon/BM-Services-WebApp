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



<?php # Script - view_allcars.php 
// This script retrieves all the records from the car table and enables the owner to delete car.

session_start();
$userID = $_SESSION['user_id'];

#$_SESSION['user_role'] = array();
#$_SESSION['user_role']= '$role';


$page_title = 'View the all  Cars';
include('includes/header - Copy.html');
echo '<h1>All Cars Registered on Database</h1>'; 


require_once('mysqli_connect.php');// Connect to the db.

// Define the query:
//$q = "SELECT carRegPlate, carMake, carModel, carMileage, DATE_FORMAT(carDateRegistered, '%M %d, %Y') AS dr, user_id, carRegPlate FROM car ORDER BY carDateRegistered ASC";
$q = "SELECT carRegPlate, carMake, carModel, carMileage, DATE_FORMAT(carDateRegistered, '%M %d, %Y') AS dr, user_id, carRegPlate FROM car ORDER BY carDateRegistered ASC";
$r = @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered car at BM Services.</p>\n";
    ?>

<!-- Integrated search function, that posts the criteria to the result page -->    
<form action="SearchCar.php" method="post">
<br>
<label>Car Field: </label>
    <select name="carField">                 
        <option value="null">--Select Field--</option>
        <option value="carRegPlate">Car Registration Plate</option>
        <option value="carMake">Car Make</option>
        <option value="carModel">Car Model</option>
    </select>

<br>
<input type="text" name="search" placeholder="Type your criteria">
<button type="submit" name="submit-searchMyCar">SUBMIT SEARCH</button>
<br>
<br>
<?php
    //<th align="left"><strong>Edit</strong></th>
	// Table header:
	echo '<table width="80%">
	<thead>
	<tr>
		
		<th align="left"><strong>Delete</strong></th>
		<th align="left"><strong>Car Registration Plate</strong></th>
		<th align="left"><strong>Car Make</strong></th>
        <th align="left"><strong>Car Model</strong></th>
        <th align="left"><strong>Car Mileage</strong></th>
		<th align="left"><strong>Date Registered</strong></th>

	</tr>
	</thead>
	<tbody>
	';


    //<td align="left"><a href="edit_car.php?id=' . $row['carRegPlate'] . '">Edit</a></td>
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr>
			
			<td align="left"><a href="delete_car.php?q=' . $row['carRegPlate'] . '">Delete</a></td>
			<td align="left">' . $row['carRegPlate'] . '</td>
			<td align="left">' . $row['carMake'] . '</td>
            <td align="left">' . $row['carModel'] . '</td>
            <td align="left">' . $row['carMileage'] . '</td>
			<td align="left">' . $row['dr'] . '</td>
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