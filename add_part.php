<?php
// Get the product data
$partID = filter_input(INPUT_POST, 'partID', FILTER_VALIDATE_INT);
$partName = filter_input(INPUT_POST, 'partName');
$partPrice = filter_input(INPUT_POST, 'partPrice', FILTER_VALIDATE_FLOAT);
$partQuantity = filter_input(INPUT_POST, 'partQuantity');
$categoryPartID = filter_input(INPUT_POST, 'categoryPartID', FILTER_VALIDATE_INT);

// Validate inputs
if ( $partID == NULL ) {
        $error_message = 'Presence check on ID!!!'; 
		include('error.php');

    ///validate name
    } else if ( $partName == NULL )  {
        $error_message = 'Presence check on name!!!'; 
		include('error.php');

    // validate part price
    } else if ( $partPrice == FALSE ) {
        $error_message = 'price invalid.'; 
		include('error.php');

    // validate part quantity
	} else if ( $partQuantity == NULL )  {
        $error_message = 'Presence check on quantity!!!'; 
		include('error.php');

    
    // validate category ID 
    } else if ( $categoryPartID == NULL )  {
        $error_message = 'Presence check on Foreign Key!!!'; 
		include('error.php');
    
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
		
		require_once('database.php');

    // Add the parts to the database
    
    $query = 'INSERT INTO parts
                 (partID, partName, partPrice, partQuantity, categoryPartID)
              VALUES
                 (:partID, :partName, :partPrice, :partQuantity, :categoryPartID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':partID', $partID);
    $statement->bindValue(':partName', $partName);
    $statement->bindValue(':partPrice', $partPrice);
    $statement->bindValue(':partQuantity', $partQuantity);
    $statement->bindValue(':categoryPartID', $categoryPartID);
    $statement->execute();
    $statement->closeCursor();
    

    // Display the Part List page
    include('add_part_form.php');
   
    
} 
?>

