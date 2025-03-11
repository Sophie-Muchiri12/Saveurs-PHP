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

// Fetch all reservations
$sql = "SELECT user_id, username, phone, date, time, guests, requests, status FROM reservations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Table Reservations</title>
  <link rel="stylesheet" href="displayreservation.css">
</head>
<body>
  <div class="container">
    <h2><a href="displayreservation.php" class="heading-link">Table Reservations</a></h2>
    
    <form method="POST" class="search-form">
      <a href="admintest.php" class="home-button">Home</a>
      <input type="text" name="searchQuery" placeholder="Search..." >
      <button type="submit" name="search">Search</button>
    </form>

    <table class="reservation-table">
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Phone Number</th>
        <th>Date</th>
        <th>Time</th>
        <th>Number of Guests</th>
        <th>Special Requests</th>
        <th>Status</th>
      </tr>

      <?php 
      // Check if there are reservations and display them
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . htmlspecialchars($row['user_id']) . "</td>
                      <td>" . htmlspecialchars($row['username']) . "</td>
                      <td>" . htmlspecialchars($row['phone']) . "</td>
                      <td>" . htmlspecialchars($row['date']) . "</td>
                      <td>" . htmlspecialchars($row['time']) . "</td>
                      <td>" . htmlspecialchars($row['guests']) . "</td>
                      <td>" . htmlspecialchars($row['requests']) . "</td>
                      <td>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='8' style='text-align:center;'>No reservations found</td></tr>";
      }
      ?>
    </table>
  </div>

  <script src="script.js"></script>
</body>
</html>

<?php $conn->close(); ?> <!-- Close the database connection -->
