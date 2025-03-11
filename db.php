<?php
// Database connection details
$host = "localhost";  // Server hostname (default is "localhost" for local development)
$user = "root";       // Database username (default is "root" for XAMPP/MAMP/LAMP)
$pass = "";           // Database password (default is empty for local development)
$dbname = "restaurant_db";  // Name of the database to connect to

// Create a new connection to the MySQL database using MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
   
    die("Connection failed: " . $conn->connect_error);
}


?>
