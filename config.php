<?php
    // Define database connection constants
    define('DB_SERVER', '127.0.0.1');
    define('DB_USERNAME', 'aptease');
    define('DB_PASSWORD', 'aptease123');
    define('DB_NAME', 'AptEase');
    // Attempt to connect to the database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // Check if the connection is unsuccessful
    if($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    // Set time zone
    date_default_timezone_set('Asia/Manila');
?>
