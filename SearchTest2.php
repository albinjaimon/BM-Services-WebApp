<?php 
//prototype for search users

session_start();
#include('includes/header.html');
include('includes/header - Copy.html');

require_once('mysqli_connect.php');// Connect to the db.

?>

<html>
<body>
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

//echo "<p><a href=\"loggedin.php\">Return to authorised user menu</a></p>";

//value="<?php if (isset($_POST['user_role'])) echo $_POST['user_role'];"
?>

<form action="Search.php" method="post">
<br>
<label>User Field: </label>

    <select name="userField">                 
        <option value="null">--Select Field--</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email">Email Address</option>
        <option value="user_address">Home Address</option>
        <option value="user_role">Role</option>
    </select>

  

<br>
<input type="text" name="search" placeholder="Type your criteria">
<button type="submit" name="submit-search">SUBMIT SEARCH</button>

<?php

?>

<h2>Quick test to state how many records are in users table</h2>

<?php 

$sql = "SELECT * FROM users";
$result = mysqli_query($dbc,$sql);
$queryResultReords = mysqli_num_rows($result);

echo $queryResultReords  


//if ($queryResultReords >0) {
	//while ($row = mysqli_fetch_assoc($result)) {
		//echo "<div>
			//<h2>".$row['user_id']."</h2>
			//<h3>".$row['first_name']."</h3>
			//<h3>".$row['last_name']."</h3>
			//<h3>".$row['registration_date']."</h3>
			//</div>";
	//}
	
//}

?>

</form>
</body>
</html>





