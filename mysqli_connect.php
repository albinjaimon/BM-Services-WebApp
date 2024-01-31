<?php

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:
define('DB_USER', 'epiz_29965872');
define('DB_PASSWORD', 'KkRFLmN67GEvpq');
define('DB_HOST', 'sql306.epizy.com');
define('DB_NAME', 'epiz_29965872_prototype');

// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding
mysqli_set_charset($dbc, 'utf8');


