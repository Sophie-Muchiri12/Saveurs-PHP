<?php

// Database connection credentials
$host = "localhost";  // Server hostname (localhost for local development)
$user = "root";       // Database username
$password = "";       // Database password (empty for local development)
$dbname = "restaurant_db"; // Name of the database

// Create a connection to the MySQL database
$conn = new mysqli($host, $user, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // If connection fails, show an error message and terminate the script
}

// SQL query to fetch all menu items from the "menu" table
$sql = "SELECT * FROM menu";
$result = $conn->query($sql); // Execute the query and store the result
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    
    <!-- Link to external stylesheet for styling -->
    <link rel="stylesheet" href="style.css"> 
    
    <!-- Google Font for styling -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    
    <style>
        /* Set background color for the page */
        body {
            background-color: #a57948;
        }
    </style>
</head>
<body>
    
<!-- Page title -->
<h1 style="text-align:center; font-family: 'Great Vibes', cursive; color:white; font-size: 46px; padding-top:60px;">
    Welcome to Saveurs du Monde Menu Page
</h1>

<!-- Container to hold all menu items -->
<div class="c-container">

    <!-- Loop through each row in the "menu" table and display its details -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="c-card">
            <div class="c-imgBx">
                <!-- Display the menu item image -->
                <img src="<?= htmlspecialchars($row['imageUrl']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            </div>
            <div class="c-content">
                <!-- Display menu item name -->
                <h2><?= htmlspecialchars($row['name']) ?></h2><br>
                
                <!-- Display menu item description -->
                <p><?= htmlspecialchars($row['description']) ?></p><br>
                
                <!-- Display menu item price -->
                <p style="font-weight: bold;">Ksh.<?= htmlspecialchars($row['price']) ?></p>

                <!-- "Order Now" button: Redirects user to order page with the selected menu item ID -->
                <button class="order-btn" onclick="window.location.href='order.php?menu_id=<?= $row['id'] ?>'">Order Now</button>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php
// Close the database connection after retrieving menu items
$conn->close();
?> 
