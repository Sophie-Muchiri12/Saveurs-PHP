<?php
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default is empty
$database = "restaurant_db"; 

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash password

    // Insert into database
// SQL query to insert a new user into the "users" table
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind parameters to the prepared statement
// "sss" indicates that all three parameters (username, email, password) are strings
$stmt->bind_param("sss", $username, $email, $password);

// Execute the prepared statement
if ($stmt->execute()) {
    // If the query executes successfully, show a success message
    echo "User registered successfully!";
    
    // Redirect the user to the login page after successful registration
    header("Location: login.html");
    
    // Ensure that no further script execution happens after the redirect
    exit();
} else {
    // If an error occurs, display the error message
    echo "Error: " . $stmt->error;
}

// Close the prepared statement to free up resources
$stmt->close();
}

$conn->close();
?>
