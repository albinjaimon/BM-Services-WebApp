<?php
require_once('database.php');

// Get all categories
$query = 'SELECT * FROM categoriesPart
                       ORDER BY categoryPartID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Parts Inventory</title>
	
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




</style>
</head>

<!-- the body section -->
<body>
<header><h1>Part Manager</h1></header>
<main>
    <h1>Category List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>        
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?php echo $category['categoryName']; ?></td>
            <td>
                <form action="delete_category_part.php" method="post">
                    <input type="hidden" name="categoryPartID"
                           value="<?php echo $category['categoryPartID']; ?>"/>
                    <input type="submit" value="Delete"/>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>    
    </table>

<!--ADD CATEGORY -->
    <h2 class="margin_top_increase">Add Category</h2>
    <form action="add_category_part.php" method="post" id="add_category_part" >
    
        <label>Name:</label>
        <input type="text" name="name" />
        <input id="add_category_button" type="submit" value="Add"/>
    </form>
    
    <p><a href="partmanagement.php">List Products</a></p>

</main>
<footer>
<!-- details for footer -->
    <p>&copy; <?php echo date("Y"); ?> "BM Services" Stock Items, IPN.</p>
</footer>
</body>
</html>