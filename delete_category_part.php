<?php
// Get ID
$categoryPartID = filter_input(INPUT_POST, 'categoryPartID', FILTER_VALIDATE_INT);

// Validate inputs
if ($categoryPartID == null || $categoryPartID == false) {
    $error = "Invalid category ID.";
    include('error.php');
} else {
    require_once('database.php');

    // Delete category from the database  
    $query = 'DELETE FROM categoriesPart
              WHERE categoryPartID = :categoryPartID';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryPartID', $categoryPartID);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('category_list_part.php');
}
?>