<?php
session_start(); // Start the session to handle the cart

// Define the products array (this should be the same as in your cart.php)
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

// Initialize the cart in the session if it's not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle the search input
$search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

// Filter products based on the search input
$filteredProducts = array_filter($products, function($product) use ($search) {
    return empty($search) || strpos(strtolower($product['name']), $search) !== false;
});

// Check if the "Add to Cart" button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productName = $_POST['product_name'];

    // Check if the product is already in the cart
    if (!in_array($productName, $_SESSION['cart'])) {
        // Add the product to the cart if it's not already there
        $_SESSION['cart'][] = $productName;
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
    <title>Products</title>
</head>
<style>
.product-item {
    text-align: center; /* Ensure that the container centers the content */
}

.product-item img {
    width: 150px; /* Set the width to your desired size */
    height: 150px; /* Set the height to your desired size */
    object-fit: cover; /* Ensures the image covers the box without distortion */
    border-radius: 5px; /* Optional: Add a slight rounding for nicer aesthetics */
    margin-bottom: 10px; /* Add some spacing below the image */
    display: block; /* Make the image a block-level element */
    margin: 0 auto; /* Center the image horizontally */
}

</style>
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
                    <i class="fas fa-shopping-cart"></i> Cart (<?php echo count($_SESSION['cart']); ?>)
                </a></li>
            </ul>
        </nav>
    </header>

    <!-- Products Section -->
    <div class="container">
        <h2 class="text-center">Products</h2>
        
        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" class="form-control" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
        </form>

        <div class="product-list">
            <?php
            if (empty($filteredProducts)) {
                echo "<p class='text-center'>No products found.</p>";
            } else {
                foreach ($filteredProducts as $product): ?>
                    <div class="product-item text-center">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-responsive" data-toggle="modal" data-target="#paymentModal" onclick="setProduct('<?php echo addslashes($product['name']); ?>', '<?php echo $product['price']; ?>')">
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                        <p><?php echo $product['price']; ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach;
            }
            ?>
        </div>

        <div class="pagination">
            <ul class="pagination">
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
            </ul>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="product-name"></h4>
                    <p id="product-price"></p>
                    <form method="POST" action="">
                        <input type="hidden" name="product_name" id="hidden-product-name">
                        
                        <div class="form-group">
                            <label for="payment-method">Payment Method:</label><br>
                            <input type="radio" name="payment_method" value="cod" id="cod" onclick="showPaymentFields('cod')"> Cash on Delivery<br>
                            <input type="radio" name="payment_method" value="paymaya" id="paymaya" onclick="showPaymentFields('paymaya')"> Paymaya<br>
                            <input type="radio" name="payment_method" value="bank" id="bank" onclick="showPaymentFields('bank')"> Bank Account<br>
                        </div>

                        <div id="cod-fields" style="display: none;">
                            <p>Thank you for choosing Cash on Delivery!</p>
                        </div>

                        <div id="paymaya-fields" style="display: none;">
                            <input type="text" name="card_number" placeholder="Card Number" class="form-control" required>
                            <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)" class="form-control" required>
                            <input type="text" name="cvv" placeholder="CVV" class="form-control" required>
                        </div>

                        <div id="bank-fields" style="display: none;">
                            <label for="bank-name">Select Bank:</label>
                            <select id="bank-name" name="bank_name" class="form-control" required>
                                <option value="">-- Select a Bank --</option>
                                <option value="bdo">BDO Unibank, Inc.</option>
                                <option value="bpi">Bank of the Philippine Islands (BPI)</option>
                                <option value="metrobank">Metrobank</option>
                                <option value="unionbank">Union Bank of the Philippines</option>
                                <option value="securitybank">Security Bank</option>
                                <option value="landbank">Land Bank of the Philippines</option>
                                <option value="rcbc">RCBC (Rizal Commercial Banking Corporation)</option>
                                <option value="eastwest">EastWest Banking Corporation</option>
                            </select>
                            <label for="bank-account-number" style="margin-top: 10px;">Bank Account Number:</label>
                            <input type="text" id="bank-account-number" name="bank_account_number" class="form-control" placeholder="Enter Bank Account Number" required>
                        </div>

                        
                        <button type="button" class="btn btn-success" onclick="orderNow()">Order Now</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setProduct(name, price) {
            document.getElementById('product-name').innerText = name;
            document.getElementById('product-price').innerText = price;
            document.getElementById('hidden-product-name').value = name; // Set hidden input
        }

        function showPaymentFields(selectedMethod) {
            document.getElementById('cod-fields').style.display = selectedMethod === 'cod' ? 'block' : 'none';
            document.getElementById('paymaya-fields').style.display = selectedMethod === 'paymaya' ? 'block' : 'none';
            document.getElementById('bank-fields').style.display = selectedMethod === 'bank' ? 'block' : 'none';
        }

        function orderNow() {
            const productName = document.getElementById('hidden-product-name').value;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            if (!paymentMethod) {
                alert("Please select a payment method.");
                return;
            }

            const methodValue = paymentMethod.value;
            let message = "You have chosen to order: " + productName + "\nPayment Method: " + methodValue;

            if (methodValue === 'cod') {
                message += "\nThank you for choosing Cash on Delivery!";
            } else if (methodValue === 'paymaya') {
                const cardNumber = document.querySelector('input[name="card_number"]').value;
                const expiryDate = document.querySelector('input[name="expiry_date"]').value;
                const cvv = document.querySelector('input[name="cvv"]').value;
                message += `\nCard Number: ${cardNumber}\nExpiry Date: ${expiryDate}\nCVV: ${cvv}`;
            } else if (methodValue === 'bank') {
                const bankAccountNumber = document.getElementById('bank-account-number').value; // Capture the bank account number
                const bankName = document.getElementById('bank-name').value; // Optionally capture the bank name if needed
                message += `\nBank Name: ${bankName}\nBank Account Number: ${bankAccountNumber}`; // Include bank account number in the message
            }

            alert(message);
            // Here you can redirect to the order page or perform another action
            // window.location.href = 'order_page.php?product=' + productName; // Example redirect
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
