<?php
// Get the category data
$categoryName = filter_input(INPUT_POST, 'name');

// Validate inputs
if ($categoryName == null) {
    $error = "Invalid category data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the categroies to the database  
    $query = 'INSERT INTO categoriesPart (categoryName)
              VALUES (:categoryName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryName', $categoryName);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('category_list_part.php');
}
?>