<?php
session_start(); // Start session to access the cart

// Define the products array
$products = [
    ['name' => 'Handle', 'price' => '₱850', 'image' => 'handle.jpg'],
    ['name' => 'Helmet', 'price' => '₱2,500', 'image' => 'helmet.jpg'],
    ['name' => 'Battery', 'price' => '₱1,200', 'image' => 'battery.jpg'],
    ['name' => 'Clutch', 'price' => '₱1,500', 'image' => 'clutch.jpg'],
    ['name' => 'Tool Kit', 'price' => '₱1,000', 'image' => 'toolkit.jpg'],
    ['name' => 'Rear Wheel', 'price' => '₱3,000', 'image' => 'rear_wheel.jpg'],
    ['name' => 'Spark Plugs', 'price' => '₱300', 'image' => 'spark_plugs.jpg'],
    ['name' => 'Clutch Springs', 'price' => '₱400', 'image' => 'clutch_springs.jpg'],
    ['name' => 'Throttle', 'price' => '₱800', 'image' => 'throttle.jpg'],
    ['name' => 'Mirrors', 'price' => '₱250', 'image' => 'mirrors.jpg'],
    ['name' => 'Wheels', 'price' => '₱4,000', 'image' => 'wheels.jpg'],
    ['name' => 'Hydraulic Shock', 'price' => '₱3,500', 'image' => 'hydraulic_shock.jpg'],
    ['name' => 'Muffler', 'price' => '₱2,500', 'image' => 'muffler.jpg'],
    ['name' => 'Rim', 'price' => '₱1,500', 'image' => 'rim.jpg'],
    ['name' => 'Headlight', 'price' => '₱1,200', 'image' => 'headlight.jpg'],
    ['name' => 'Horn', 'price' => '₱150', 'image' => 'horn.jpg'],
    ['name' => 'Brake Rod', 'price' => '₱300', 'image' => 'brake_rod.jpg'],
    ['name' => 'Starter Motor', 'price' => '₱4,500', 'image' => 'starter_motor.jpg'],
    ['name' => 'Tube', 'price' => '₱250', 'image' => 'tube.jpg'],
    ['name' => 'Oil Filter', 'price' => '₱200', 'image' => 'oil_filter.jpg']
];

// Initialize total price variable
$totalPrice = 0;

// Flag to check if the order has been placed
$orderPlaced = false;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Prepare the order details message
    $orderMessage = "The product(s) you bought are:\n";
    foreach ($_SESSION['cart'] as $productName) {
        foreach ($products as $product) {
            if ($product['name'] === $productName) {
                $orderMessage .= $product['name'] . " - " . $product['price'] . "\n";
            }
        }
    }
    
    // Set orderPlaced to true to show the success message
    $orderPlaced = true;
    
    // Clear the cart after order confirmation
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Checkout</title>
    <script>
        function confirmOrder(message) {
            // Display alert with the order message
            alert(message);
            
            // Redirect to the product page
            window.location.href = "product.php";
        }
    </script>
</head>
<body>

    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="motor.jpg" alt="Motorbike Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="cart.php" style="margin-left: auto;">
                    <i class="fas fa-shopping-cart"></i> Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Checkout Section -->
    <div class="container">
        <h2 class="text-center">Checkout</h2>

        <?php if ($orderPlaced): ?>
            <!-- Trigger JavaScript to show the confirmation and redirect -->
            <script>
                confirmOrder(<?php echo json_encode($orderMessage); ?>);
            </script>
        <?php elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['cart'] as $productName) {
                        foreach ($products as $product) {
                            if ($product['name'] === $productName) {
                                // Remove '₱' and commas for calculation
                                $price = str_replace(['₱', ','], '', $product['price']);
                                $totalPrice += (float)$price; // Convert to float and add to total price

                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($productName) . '</td>';
                                echo '<td>₱' . number_format((float)$price) . '</td>';
                                echo '</tr>';
                                break;
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>₱<?php echo number_format($totalPrice); ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Place Order Form -->
            <form method="POST" action="">
                <div class="text-center">
                    <a href="cart.php" class="btn btn-primary">Back to Cart</a>
                    <button type="submit" name="place_order" class="btn btn-success">Place Order</button>
                </div>
            </form>
        <?php else: ?>
            <!-- If the cart is empty, show a message -->
            <div class="alert alert-info text-center">
                Your cart is empty. <a href="product.php">Go back to products</a>.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
