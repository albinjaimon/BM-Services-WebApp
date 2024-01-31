<?php
// presents table for parts inventroy to be displayed.

require_once('database.php');

// Get category ID
if (!isset($categoryPartID)) {
    $categoryPartID = filter_input(INPUT_GET, 'categoryPartID', 
            FILTER_VALIDATE_INT);
    if ($categoryPartID == NULL || $categoryPartID == FALSE) {
        $categoryPartID = 1;
    }
}
// Get name for selected category
$queryCategory = 'SELECT * FROM categoriesPart
                  WHERE categoryPartID = :categoryPartID';
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':categoryPartID', $categoryPartID);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['categoryName'];
$statement1->closeCursor();


// Get all categories
$query = 'SELECT * FROM categoriesPart
                       ORDER BY categoryPartID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

// Get products for selected category
$queryParts = 'SELECT * FROM parts
                  WHERE categoryPartID = :categoryPartID
                  ORDER BY partID';
$statement3 = $db->prepare($queryParts);
$statement3->bindValue(':categoryPartID', $categoryPartID);
$statement3->execute();
$parts = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->

<!-- CSS -->

<head>
    <title>BM Parts Inventory</title>
    <!-- <link rel="stylesheet" type="text/css" href="main.css" />  -->
	
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
    background-color: black;
}
aside {
    float: left;
    width: 150px;
    background-color: white;
    padding-right:10px;
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
    width: 600px;
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
    border: 1.5px dashed black;
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
    <h1>Part List</h1>

    <aside>
        <!-- display a list of categories -->
        <h2>Part Categories</h2>
        <nav>
        <ul>
            <?php foreach ($categories as $category) : ?>
            <li><a href="?categoryPartID=<?php echo $category['categoryPartID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>          
    </aside>

    <section>
        <!-- display a table of products -->
        <h2><?php echo $category_name; ?></h2>
        <table>
            <tr>
                <th>Part ID</th>
                <th>Part Name</th>
                <th>Part Price</th>
                <th>Part Quantity</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>

            </tr>

            <?php foreach ($parts as $part) : ?>
            <tr>
                
                <td><?php echo $part['partID']; ?></td>
                <td><?php echo $part['partName']; ?></td>
                <td class="right"><?php echo $part['partPrice']; ?></td>
                <td><?php echo $part['partQuantity']; ?></td>

                <td><form action="incrementPart.php" method="post">

                    <input type="hidden" name="partID" value="<?php echo $part['partID']; ?>">

                    <input type="submit" value="Increment">
                </form></td>

                <td><form action="decrementPart.php" method="post">

                    <input type="hidden" name="partID" value="<?php echo $part['partID']; ?>">

                    <input type="submit" value="Decrement">
                </form></td>

                <td><form action="delete_part.php" method="post">

                    <input type="hidden" name="partID" value="<?php echo $part['partID']; ?>">

                    <input type="hidden" name="categoryPartID" value="<?php echo $part['categoryPartID']; ?>">
                    <input type="submit" value="Delete">
                </form></td>

            </tr>
            
            <?php endforeach; ?>
        </table>

        <!-- Links to other pages -->
        
        <p><a href="add_part_form.php">Add Part</a></p>

        <p><a href="category_list_part.php">List Part Categories</a></p>

        <p><a href="loggedin.php">Back to Main Menu</a></p>

        <!-- link end -->

    </section>


</main>

<footer> <!-- Footer utilises the current year seleceted from system -->
    <p>&copy; <?php echo date("Y"); ?> "BM Services" Part Stock Inventory.</p>
</footer>

</body>
</html>