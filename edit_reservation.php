<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (!isset($_GET['id'])) {
    die("Error: Reservation ID is missing.");
}

$id = intval($_GET['id']);

// Fetch existing reservation data
$query = "SELECT * FROM reservations WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$reservation = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phonenumber']);
    $date = $_POST['date'];
    $time = date("H:i:s", strtotime($_POST['time'])); 
    $guests = intval($_POST['numberofguest']);
    $special_request = trim($_POST['specialrequest']);

    // Update SQL query
    $stmt = $conn->prepare("UPDATE reservations SET customer_name = ?, email = ?, phone = ?, reservation_date = ?, reservation_time = ?, guests = ?, special_requests = ? WHERE id = ?");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Corrected bind_param with matching number of parameters
    $stmt->bind_param("sssssisi", $name, $email, $phone, $date, $time, $guests, $special_request, $id);

    if ($stmt->execute()) {
        header("Location: reservation_process.php?id=$id&name=$name&phone=$phone&date=$date&time=$time&guests=$guests&request=$special_request&updated=true");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
    <div class="container">
        <h2>Edit Reservation</h2>
        <form action="edit_reservation.php?id=<?= $id ?>" method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($reservation['customer_name']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($reservation['email']) ?>" required>

            <label>Phone Number:</label>
            <input type="text" name="phonenumber" value="<?= htmlspecialchars($reservation['phone']) ?>" required>

            <label>Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($reservation['reservation_date']) ?>" required>

            <label>Time:</label>
            <input type="time" name="time" value="<?= htmlspecialchars($reservation['reservation_time']) ?>" required>

            <label>Guests:</label>
            <input type="number" name="numberofguest" value="<?= htmlspecialchars($reservation['guests']) ?>" required>

            <label>Special Requests:</label>
            <textarea name="specialrequest"><?= htmlspecialchars($reservation['special_requests']) ?></textarea>

            <button type="submit">Update Reservation</button>
        </form>
        
        <form action="delete_reservation.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit" class="delete-button">Delete Reservation</button>
        </form>
    </div>
</body>
</html>
