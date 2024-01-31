<html>
<?php


$page_title = 'Add payment';
include('includes/header - Copy.html');
echo '<h1>Payments</h1>';

// Check for a valid booking ID, through GET or POST:
if ( (isset($_GET['id'])) ) {
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	//exit();
}

require('mysqli_connect.php');// Connect to the db.
?>


<!-- CONTAINER CLASS -->


<style>
body {
	background-color: white;
	font-family: arial;
}


.container{
	width: 800px;
	padding: 30px;
	font-size:10px;
	
}

.dataoutput {
	padding-bottom: 25px;
    background-color: #bfbcb2;
    font-size:13px;
}
</style>


<?php 
	if (isset($_GET['id'])){
        //$userField = $_POST['id'];
		//$sql = "SELECT * FROM users WHERE user_id LIKE '%$criteria%'";
		//$sql = "SELECT bookingID, DATE_FORMAT(bookingDate, '%M %d, %Y') AS dr, WorkDescription, carRegPlate, user_id FROM booking WHERE bookingID = $userField";
		$sql = "SELECT paymentID, paymentDate, paymentMethod, deposit, amountPaid, bookingID FROM payment WHERE bookingID=$id";
        
		$result = mysqli_query($dbc,$sql);
		$queryResultRecords = mysqli_num_rows($result);
        


	
	if ($queryResultRecords >0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //data output class
			echo "<div class = dataoutput>
			<h3>Payment ID: ".$row['paymentID']."</h3>
            <h3>Payment Date: ".$row['paymentDate']."</h3>
            <h3>Payment Method: ".$row['paymentMethod']."</h3>
            <h3>Deposit Paid: ".$row['deposit']."</h3>
            <h3>Total Amount Paid: ".$row['amountPaid']."</h3>
            <h3>Booking ID: ".$row['bookingID']."</h3>
            ";
            echo '<a href="#placeholder">Add Payment</a>';
		}
	} else {
		echo "No records/payments for booking";
        ?>
        <br>
        <br>
        <?php
        echo '<a href="#placeholder">Add Payment</a>';
	}
}
?>
</div>
</html>

<?php
mysqli_close($dbc);
?>



<?php

echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

?>

<?php
// Call the function 

include('includes/footer.html');
?>