<?php
// Database credentials
$servername = 'localhost';
$username = 'gnytldve_masterdscdata051024ug';
$password = 'Pe0aTMArew~pfKaqUi';
$dbname = 'gnytldve_masterdscdata051024ug';

// Timezone setup for India
date_default_timezone_set('Asia/Kolkata');

// Establish a connection using mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection and handle errors securely
if (!$conn) {
    // Log the error message to the server logs (do not display it to the user)
    error_log('Connection failed: ' . mysqli_connect_error());
    die("ERROR: Could not connect to the database.");
}

// Set the character set to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Set the MySQL session time zone to India Standard Time (IST)
mysqli_query($conn, "SET time_zone = '+05:30'");

?>
