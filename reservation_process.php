<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";  
$password = "";      
$database = "restaurant_db"; 

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phonenumber']);
    $date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d"); // Ensure date format is correct
    $time = date("H:i:s", strtotime($_POST['time'])); // Convert to proper TIME format
    $guests = intval($_POST['numberofguest']); 
    $special_request = trim($_POST['specialrequest']);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO reservations (customer_name, email, phone, reservation_date, reservation_time, guests, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $guests, $special_request);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id; // Get the inserted ID
        header("Location: reservation_process.php?id=$last_id&name=$name&phone=$phone&date=$date&time=$time&guests=$guests&request=$special_request");
        exit();
    }
    
    else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="reservationcard.css">
</head>
<body>
    <div class="card-container">
        <div class="reservation-card">
            <h2 class="title">Table Reservation</h2>
            <p class="names"><strong>Name:</strong> <span id="res-username"></span></p>
            <p class="date-time"><strong>Date:</strong> <span id="res-date"></span> <br>
                <strong>Time:</strong> <span id="res-time"></span></p>
            <p class="guests"><strong>Guests:</strong> <span id="res-guests"></span></p>
            <p class="phone"><strong>Phone Number:</strong> <span id="res-phone"></span></p>
            <p class="special-request"><strong>Special Requests:</strong> <span id="res-request"></span></p>
            
            <button onclick="goBack()">Saveurs du Monde</button>
            <button onclick="downloadCard()">Download Reservation</button>
            <button onclick="editReservation()">Edit Reservation</button>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function editReservation() {
    const reservationId = getQueryParam("id"); // Get ID from URL
    if (reservationId) {
        window.location.href = `edit_reservation.php?id=${reservationId}`;
    } else {
        alert("Reservation ID not found. Please make sure your reservation is correctly recorded.");
    }
}


        // Function to get URL parameters
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Populate the reservation card dynamically
        document.getElementById("res-username").textContent = getQueryParam("name") || "N/A";
        document.getElementById("res-phone").textContent = getQueryParam("phone") || "N/A";
        document.getElementById("res-date").textContent = getQueryParam("date") || "N/A";
        document.getElementById("res-time").textContent = getQueryParam("time") || "N/A";
        document.getElementById("res-guests").textContent = getQueryParam("guests") || "N/A";
        document.getElementById("res-request").textContent = getQueryParam("request") || "None";

        function goBack() {
            window.location.href = "index.html"; // Change this to your homepage
        }

        async function downloadCard() {
            const jsPDF = window.jspdf.jsPDF;
            const cardElement = document.querySelector(".reservation-card");

            // Convert to image
            const canvas = await html2canvas(cardElement);
            const imgData = canvas.toDataURL("image/png");

            // Create PDF
            const pdf = new jsPDF("p", "mm", "a4");
            const imgWidth = 180;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            pdf.addImage(imgData, "PNG", 15, 20, imgWidth, imgHeight);
            pdf.save("Reservation_Confirmation.pdf");
        }


      

    </script>
</body>
</html>
