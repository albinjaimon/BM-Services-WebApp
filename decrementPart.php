<?php
// this file is used to decrement the quanity value in part inventory

require_once('database.php');

// Get IDs
$partID = filter_input(INPUT_POST, 'partID', FILTER_VALIDATE_INT);

// Delete the product from the database
if ($partID != false) {
    $query = 'UPDATE parts SET partQuantity = partQuantity - 1
              WHERE partID = :partID';
    $statement = $db->prepare($query);
    $statement->bindValue(':partID', $partID);
    $success = $statement->execute();
    $statement->closeCursor();    

    // Display the part inventroy page
    include('partmanagement.php');
}
?>