<?php
session_start(); // Start the session to access cart items

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

// Check if delete action is requested
if (isset($_POST['delete'])) {
    $productNameToDelete = $_POST['product_name'];
    // Remove the product from the cart
    if (($key = array_search($productNameToDelete, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        // Reindex the array to ensure sequential keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Shopping Cart</title>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
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

    <!-- Cart Section -->
    <div class="container">
        <h2 class="text-center">Shopping Cart</h2>

        <?php if (empty($_SESSION['cart'])): ?>
            <p class="text-center">Your cart is empty.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $productName) {
                        // Ensure $productName is a string
                        if (is_array($productName)) {
                            error_log("Expected string, found array: " . print_r($productName, true));
                            continue; // Skip this iteration
                        }

                        // Initialize price
                        $price = 0; 
                        foreach ($products as $product) {
                            if ($product['name'] === $productName) {
                                // Remove '₱' and commas for calculation
                                $price = str_replace(['₱', ','], '', $product['price']);
                                $totalPrice += (float)$price; // Convert to float and add to total price
                                break;
                            }
                        }
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($productName) . '</td>'; // Ensure product name is a string
                        echo '<td>₱' . number_format((float)$price) . '</td>'; // Convert to float for formatting
                        echo '<td>';
                        // Form to delete product
                        echo '<form action="" method="POST" style="display:inline;">';
                        echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($productName) . '">';
                        echo '<button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Delete</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>₱<?php echo number_format($totalPrice); ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div class="text-center">
    <a href="product.php" class="btn btn-primary">Continue Shopping</a>

    <!-- Form to submit the cart for checkout -->
    <form action="checkout.php" method="POST" style="display: inline;">
        <input type="hidden" name="checkout" value="1">
        <button type="submit" class="btn btn-success">Proceed to Checkout</button>
    </form>
</div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
