<?php
require('database.php');
$query = 'SELECT *
          FROM categoriesPart
          ORDER BY categoryPartID';
$statement = $db->prepare($query);
$statement->execute();
$categoriesPart = $statement->fetchAll();
$statement->closeCursor();
?>


<?php 


//C: This first page is index.php    It is a php file because some processing takes place on it.
// Firstly, we have if statements to see if they exist. Obviously they won't exist when the page is first loaded
// therefore these if statement create the vars and initialise them with empty strings

    //set default value of variables for initial page load
    if (!isset($partID)) { $partID = ''; }
    if (!isset($partName)) { $partName = ''; } 
    if (!isset($partPrice)) { $partprice = ''; } 
	if (!isset($partQuantity)) { $partQuantity = ''; }
    if (!isset($categoryPartID)) { $partQuantity = ''; } 

?> 
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>BM Services</title>
    <!-- <link rel="stylesheet" type="text/css" href="main.css">  -->
	
<style>
html {
    background-color: rgb(192, 192, 192);
}
body {
    margin-top: 0;
    font-family: Arial, Helvetica, sans-serif;
    width: 760px;
    margin: 0 auto;
    background-color: white;
    border: 1px solid black;
    padding: .5em 2em;
}
header {
    margin: 0;
    border-bottom: 2px solid black;
}
header h1 {
    margin: 0;
    padding: .5em 0;
    color: black;
}
main {
    margin: 0;
}
aside {
    float: left;
    width: 150px;
}
nav ul {
    list-style-type: none;
    margin-left: 0;
    padding-left: 0;
}
nav ul li {
    padding-bottom: 0.5em;
}
section {
    float: left;
    width: 500px;
    padding-bottom: 1.5em;
}
footer {
    clear: both;
    margin-top: 1em;
    border-top: 2px solid black;
}
footer p {
    text-align: right;
    font-size: 80%;
    margin: 1em 0;
}
h1 {
    font-size: 150%;
    margin: 0;
    padding: .5em 0 .25em;
}
h2 {
    font-size: 120%;
    margin: 0;
    padding: .25em 0 .5em;
}
h1, h2 {
    color: rgb(208, 133, 4);
}
ul {
    margin: 0 0 1em 0;
    padding: 0 0 0 2.5em;
}
li {
    margin: 0;
    padding: 0;
}
a {
    color: rgb(41, 64, 124);
    font-weight: bold;
}
a:hover {
    color: rgb(208, 133, 4);
}
table {
    border: 1px solid black;
    border-collapse: collapse;
}
td, th {
    border: 1px dashed black;
    padding: .2em .5em .2em .5em;
    vertical-align: top;
    text-align: left;
}
form {
    margin: 0;
}
br {
    clear: left;
}
/* the styles for classes */
.right {
    text-align: right;
}
.last_paragraph {
	margin-bottom: 2em;	
}
.margin_top_increase {
	margin-top: 1em;	
}

/********************************************************************
* Additional styles for the Product Manager application
********************************************************************/
#add_product_form {
    margin: .5em 0 1em;
}
#add_product_form label {
    width: 6em;
    padding-right: 1em;
    padding-bottom: .5em;
    float: left;
}
#add_product_form input {
    float: left;
}
#add_product_form input[text] {
    width: 15em;
}


</style>



</head>

<!--body-->
<body>
    <header><h1>Part Manager</h1></header>

    <main>
        <h1>Add Part</h1>
        <form action="add_part.php" method="post"
              id="add_part">

            <label>PartID:</label>
            <input type="text" name="partID" value="<?php if (isset($_POST['partID'])) echo $_POST['partID']; ?>">
            <br>
            <br>

            <label>Name:</label>
            <input type="text" name="partName" value="<?php if (isset($_POST['partName'])) echo $_POST['partName']; ?>">
            <br>
            <br>

            <label>List Price:</label>
            <input type="text" name="partPrice" value="<?php if (isset($_POST['partPrice'])) echo $_POST['partPrice']; ?>">
            <br>
            <br>
			
			<label>Quantity:</label>
            <input type="text" name="partQuantity" value="<?php if (isset($_POST['partQuantity'])) echo $_POST['partQuantity']; ?>">
            <br>
            <br>

            <label>Category:</label>
            <select name="categoryPartID">
            <?php foreach ($categoriesPart as $categoryPartID) : ?>
                <option value="<?php echo $categoryPartID['categoryPartID']; ?>">
                    <?php echo $categoryPartID['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>
            <br>

            <label>&nbsp;</label>
            <input type="submit" value="Add Part">
            <br>
            <br>
        </form>
        
        <p><a href="partmanagement.php">View Part List</a></p>
    </main>

    <footer>
    <p>&copy; <?php echo date("Y"); ?> "BM Services" Stock Items.</p>
</footer></body>
</html>