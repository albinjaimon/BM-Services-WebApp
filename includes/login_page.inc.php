<?php # Script 12.1 - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include('includes/header.html');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br>';
	foreach ($errors as $msg) {
		echo " - $msg<br>\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?>

<html>
<body>
<style>
.container{
	width: 400px;
	background-color: grey;
	padding: 30px;
	font-size:20px;
    position: relative;
    top: 30%;
    left: 45%;
    margin-top: 100px;
    margin-left: -140px;
    
	
}

.login{
    font-family: "Garamond", Times, serif;
}



</style>
</body>
</html>

<div class="container">

<h1 class="login"> Login </h1>
<form action="login.php" method="post">
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60"> </p>
	<p>Password: <input type="password" name="pass" size="20" maxlength="20"></p>
	<p><input type="submit" name="submit" value="Login"></p>
</form>


<!-- This provides an additonal button which acts as a link to the register page, which does not allow any other functions such as nav bar. -->
<input type="submit" value="Register" onClick="myFunction()"/>
    <script>
      function myFunction() {
        window.location.href="registerCustomer.php";
      }
    </script>

</div>

