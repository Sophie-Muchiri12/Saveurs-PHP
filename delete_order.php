<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = intval($_POST['order_id']);

    // Delete order from database
    $delete_query = "DELETE FROM orders WHERE id=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $deleted = true;
    } else {
        $deleted = false;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled</title>
    <link rel="stylesheet" href="reservationcard.css">
    <style>
        .message-container {
            text-align: center;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            margin: auto;
            margin-top: 50px;
        }

        .message-container h2 {
            color: #d9534f;
            font-size: 24px;
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

        #snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 16px;
            position: fixed;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
            z-index: 1000;
            border-radius: 5px;
            transform: translateX(-50%);
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
        <h2>Order Cancelled</h2>
        <p>Your order has been successfully cancelled.</p>
        <p>Come again at <strong>Saveurs du Monde</strong>!</p>
        <a href="index.html" class="back-home">Back to Home</a>
    </div>

    <div id="snackbar">Your order has been deleted.</div>

    <script>
        function showSnackbar() {
            var snackbar = document.getElementById("snackbar");
            snackbar.classList.add("show");
            setTimeout(function() {
                snackbar.classList.remove("show");
            }, 3000);
        }

        showSnackbar();
    </script>
</body>
</html>
