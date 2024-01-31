<?php
// This page displays the results from the search users function

session_start();
$page_title = 'View the Current Users';
#include('includes/header.html');
include('includes/header - Copy.html');

require_once('mysqli_connect.php');// Connect to the db.

?>
<html>

<body>

<style>

body {
	background-color: white;
	font-family: arial;
}


.container{
	width: 800px;
	background-color: white;
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

echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

?>
<h5>RESULT(S) </h5>

<!-- CONTAINER CLASS -->
<div class = "container">
<?php 

	if (isset($_POST['submit-search'])){
		$criteria = filter_input(INPUT_POST,'search');
        $userField = $_POST['userField'];
		//$sql = "SELECT * FROM users WHERE user_id LIKE '%$criteria%'";
		$sql = "SELECT * FROM users WHERE $userField LIKE '%$criteria%'";
		$result = mysqli_query($dbc,$sql);
		$queryResultReords = mysqli_num_rows($result);
	
	if ($queryResultReords >0) {
		while ($row = mysqli_fetch_assoc($result)) {
            //data output class
			echo "<div class ='dataoutput'>
			<h2>".$row['user_id']."</h2>
			<h3>".$row['first_name']."</h3>
			<h3>".$row['last_name']."</h3>
            <h3>".$row['email']."</h3>
            <h3>".$row['user_role']."</h3>
            <h3>".$row['user_address']."</h3>
			<h3>".$row['registration_date']."</h3>
			</div>";
		} 
    } else {
		echo "No records";
	}

}




?>
<div>

</body>
</html>





