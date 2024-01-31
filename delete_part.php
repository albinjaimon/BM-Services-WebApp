<?php
require_once('database.php');

// Get IDs
$partID = filter_input(INPUT_POST, 'partID', FILTER_VALIDATE_INT);
$categoryPartID = filter_input(INPUT_POST, 'categoryPartID', FILTER_VALIDATE_INT);

// Delete the part from the database
if ($partID != false && $categoryPartID != false) {
    $query = 'DELETE FROM parts
              WHERE partID = :partID';
    $statement = $db->prepare($query);
    $statement->bindValue(':partID', $partID);
    $success = $statement->execute();
    $statement->closeCursor();    

    // Display the Product List page
    include('partmanagement.php');
}
?>