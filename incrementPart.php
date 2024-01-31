<?php
require_once('database.php');

// Get IDs
$partID = filter_input(INPUT_POST, 'partID', FILTER_VALIDATE_INT);

// Update the quantity - increment by one
if ($partID != false) {
    $query = 'UPDATE parts SET partQuantity = partQuantity + 1
              WHERE partID = :partID';
    $statement = $db->prepare($query);
    $statement->bindValue(':partID', $partID);
    $success = $statement->execute();
    $statement->closeCursor();    

    // Display the Part List page
    include('partmanagement.php');
}
?>