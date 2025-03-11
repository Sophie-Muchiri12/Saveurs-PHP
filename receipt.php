<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$order_query = "SELECT o.*, m.name AS menu_name, m.price FROM orders o 
                JOIN menu m ON o.menu_id = m.id WHERE o.id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .receipt {
            width: 320px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .receipt h2 {
            margin-bottom: 10px;
        }
        .receipt p {
            margin: 5px 0;
            font-size: 14px;
        }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        .download-btn {
            background-color: #bb9356;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
                }
        .download-btn:hover {
            background: #218838;
        }

        .update-btn{
            background-color: #bb9356;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="receipt" id="receipt">
    <h2>Saveurs du Monde</h2>
    <p>Order ID: <strong><?= $order['id'] ?></strong></p>
    <p>Date: <strong><?= date('Y-m-d H:i:s') ?></strong></p>
    <div class="divider"></div>
    <p><strong>Item:</strong> <?= htmlspecialchars($order['menu_name']) ?></p>
    <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
    <p><strong>Price per Item:</strong> Ksh <?= number_format($order['price'], 2) ?></p>
    <div class="divider"></div>
    <p><strong>Total:</strong> Ksh <?= number_format($order['total_amount'], 2) ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
    <p><strong>Delivery Address:</strong> <?= htmlspecialchars($order['delivery_address']) ?></p>
    <div class="divider"></div>
    <p><strong>Paybill:</strong> 12345</p> <br>
    <p><strong>Make Payment after delivery</strong> </p>

    <p>Thank you for your order!</p>

    <button class="download-btn" onclick="downloadReceipt()">Download Receipt</button>
    <button class="update-btn" onclick="window.location.href='update_order.php?order_id=<?= $order['id'] ?>'">Update Order</button>

</div>

<script>
async function downloadReceipt() {
    const { jsPDF } = window.jspdf;
    const receiptElement = document.getElementById("receipt");

    const canvas = await html2canvas(receiptElement);
    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF("p", "mm", "a4");
    const imgWidth = 180;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    pdf.addImage(imgData, "PNG", 15, 20, imgWidth, imgHeight);
    pdf.save("Order_Receipt.pdf");
}
</script>

</body>
</html>
