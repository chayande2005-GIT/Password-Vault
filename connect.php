<?php
// Use environment variables (or a separate config file)
$server = "localhost";
$port = "3307"; // Change if necessary
$username = "root";
$password = "";
$dbname = "vault";

// Create a database connection with error logging
$conn = new mysqli($server, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}
?>
