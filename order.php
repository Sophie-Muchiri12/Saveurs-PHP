<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="reservation.css"> <!-- Link to external CSS file for styling -->
    
    <script>
        // Function to calculate the total order amount based on quantity
        function calculateTotal() {
            let price = parseFloat(document.getElementById('price').value); // Get the price of the item
            let quantity = parseInt(document.getElementById('quantity').value); // Get the quantity input by the user
            
            // Check if the quantity is greater than 0
            if (quantity > 0) {
                document.getElementById('total').innerText = "Total Amount: Ksh. " + (price * quantity).toFixed(2);
            } else {
                document.getElementById('total').innerText = "Total Amount: Ksh. 0.00"; // Display zero if no valid quantity is entered
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Place Your Order</h2>

    <?php
    // Database connection credentials
    $host = "localhost";
    $user = "root"; 
    $password = "";
    $dbname = "restaurant_db"; 
    
    // Establish a connection to the database
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // If connection fails, terminate script with an error message
    }

    // Get menu item ID from the URL query string
    $menu_id = isset($_GET['menu_id']) ? intval($_GET['menu_id']) : 0;

    // Query to fetch details of the selected menu item
    $menu_query = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($menu_query);
    $stmt->bind_param("i", $menu_id); // Bind the menu_id parameter to prevent SQL injection
    $stmt->execute();
    $menu_result = $stmt->get_result();
    $menu_item = $menu_result->fetch_assoc(); // Fetch the menu item data as an associative array
    
    // Check if the form has been submitted (handling form submission)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $menu_id = intval($_POST['menu_id']); // Retrieve menu ID from form
        $name = htmlspecialchars($_POST['name']); // Sanitize user input for security
        $phone = htmlspecialchars($_POST['phone']); 
        $address = htmlspecialchars($_POST['address']); 
        $payment = htmlspecialchars($_POST['payment']); 
        $quantity = intval($_POST['quantity']); 
        $total_amount = $quantity * floatval($_POST['price']); // Calculate total amount

        // SQL query to insert order details into the "orders" table
        $order_query = "INSERT INTO orders (menu_id, name, phone, delivery_address, payment_method, quantity, total_amount) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($order_query);
        $stmt->bind_param("issssii", $menu_id, $name, $phone, $address, $payment, $quantity, $total_amount);

        // Execute the query and check if the order was placed successfully
        if ($stmt->execute()) {
            // Redirect the user to the receipt page with the newly created order ID
            header("Location: receipt.php?order_id=" . $conn->insert_id);
            exit();
        } else {
            echo "Error: " . $conn->error; // Display an error message if the query fails
        }
    }
    ?>

    <!-- Check if the menu item exists before displaying the form -->
    <?php if ($menu_item): ?>
        <h3 style="text-align: center; color: #333;">Ordering: <?= htmlspecialchars($menu_item['name']) ?></h3>
        
        <!-- Order form -->
        <form method="POST">
            <input type="hidden" name="menu_id" value="<?= $menu_item['id'] ?>"> <!-- Hidden field to store menu ID -->
            <input type="hidden" id="price" name="price" value="<?= $menu_item['price'] ?>"> <!-- Hidden field to store price -->

            <label>Name:</label>
            <input type="text" name="name" required> <!-- Input field for customer name -->

            <label>Phone Number:</label>
            <input type="text" name="phone" required> <!-- Input field for phone number -->

            <label>Delivery Address:</label>
            <textarea name="address" required></textarea> <!-- Textarea for delivery address -->

            <label>Payment Method:</label>
            <select name="payment" required> <!-- Dropdown for selecting payment method -->
                <option value="Cash">Cash</option>
                <option value="Mpesa">Mpesa</option>
                <option value="PayPal">PayPal</option>
            </select>

            <label>Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required oninput="calculateTotal()"> 
            <!-- Quantity input with event listener to calculate total -->

            <p id="total" style="font-weight: bold; color: #333;">Total Amount: Ksh. 0.00</p> <!-- Display total amount -->

            <button type="submit">Place Order</button> <!-- Submit button for order placement -->
        </form>

    <?php else: ?>
        <p style="text-align:center; color: red;">Invalid menu item selected.</p> <!-- Error message if menu item doesn't exist -->
    <?php endif; ?>

</div>

</body>
</html>

<?php $conn->close(); // Close the database connection ?>
