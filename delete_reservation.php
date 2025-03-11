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

$deleted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $deleted = true;
    } else {
        $error = "Error deleting record: " . $stmt->error;
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
    <title>Reservation Deleted</title>
    <link rel="stylesheet" href="reservationcard.css">
    <style>
        .message-container {
            text-align: center;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .message-container h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .message-container p {
            font-size: 16px;
            color: #555;
        }

        .back-home {
            display: block;
            margin-top: 20px;
            padding: 10px 30px;
            background-color: #bb9356;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .back-home:hover {
            background-color: #a57948;
        }

        /* Snackbar styling */
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
        }

        #snackbar.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h2>Reservation Deleted</h2>
        <p>Your reservation has been successfully deleted.</p>
        <p>Come again at <strong>Saveurs du Monde</strong>!</p>
        <a href="index.html" class="back-home">Back to Home</a>
    </div>

    <!-- Snackbar Notification -->
    <div id="snackbar">Your reservation has been deleted.</div>

    <script>
        function showSnackbar() {
            var snackbar = document.getElementById("snackbar");
            snackbar.classList.add("show");
            setTimeout(function() {
                snackbar.classList.remove("show");
            }, 3000); 
        }

        <?php if ($deleted): ?>
            showSnackbar();
        <?php endif; ?>
    </script>
</body>
</html>
