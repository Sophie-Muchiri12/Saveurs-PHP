<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order details
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated values from the form
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $payment = htmlspecialchars($_POST['payment']);
    $quantity = intval($_POST['quantity']);
    $total_amount = $quantity * floatval($order['price']); // Recalculate total

    // Update order in database
    $update_query = "UPDATE orders SET name=?, phone=?, delivery_address=?, payment_method=?, quantity=?, total_amount=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssidi", $name, $phone, $address, $payment, $quantity, $total_amount, $order_id);

    if ($stmt->execute()) {
        echo "<script>window.location.href='receipt.php?order_id=$order_id';</script>";
        exit();
    } else {
        echo "Error updating order: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>

<div class="container">
    <h2>Update Your Order</h2>
    
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($order['name']) ?>" required>

        <label>Phone Number:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($order['phone']) ?>" required>

        <label>Delivery Address:</label>
        <textarea name="address" required><?= htmlspecialchars($order['delivery_address']) ?></textarea>

        <label>Payment Method:</label>
        <select name="payment" required>
            <option value="Cash" <?= $order['payment_method'] == "Cash" ? "selected" : "" ?>>Cash</option>
            <option value="Mpesa" <?= $order['payment_method'] == "Mpesa" ? "selected" : "" ?>>Mpesa</option>
            <option value="PayPal" <?= $order['payment_method'] == "PayPal" ? "selected" : "" ?>>PayPal</option>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" value="<?= $order['quantity'] ?>" required>

        <button type="submit">Update Order</button>
    </form>

    <form action="delete_order.php" method="POST">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <button type="submit" class="cancel-btn" style="background-color:black;">Cancel Order</button>
    </form>
</div>

</body>
</html>
