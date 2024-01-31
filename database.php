
<?php
// file containing the database details required for connection

    $dsn = 'mysql:host=sql306.epizy.com;dbname=epiz_29965872_prototype';
    $username = 'epiz_29965872';
    $password = 'KkRFLmN67GEvpq';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>