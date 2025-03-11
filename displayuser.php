<?php
// Database connection details
$host = "localhost";
$user = "root";
$password = "";
$dbname = "restaurant_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$sql = "SELECT username, email, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Management</title>
  <link rel="stylesheet" type="text/css" href="displayuser.css">
</head>
<body>
<div class="container">
    <h2>Customer Management</h2>
    <div class="header">
      <div class="button-container">
        <button class="home-button"><a href="index.html">Home</a></button>
      </div>
      <form method="POST" class="search-container">
        <input type="text" id="search-input" name="search-input" placeholder="Search..." >
        <button type="submit" id="search-button" name="submit-search">Search</button>
      </form>
    </div>
    
    <table class="user-table">
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
      </tr>
      
      <?php 
      // Check if there are results and display them
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . htmlspecialchars($row['username']) . "</td>
                      <td>" . htmlspecialchars($row['email']) . "</td>
                      <td>" . htmlspecialchars($row['password']) . "</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='3' style='text-align:center;'>No users found</td></tr>";
      }
      ?>
    </table>
</div>

<?php $conn->close(); ?> <!-- Close the database connection -->

</body>
</html>
