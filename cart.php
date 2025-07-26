<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])){
    header("location:Login.php");
}

// Initialize cart
$cartItems = $_SESSION['cart'] ?? [];
$total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container mt-5">
    <h2 class="mb-4">🛒 Your Cart</h2>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-danger">Your cart is currently empty.</div>
        <a href="Home.php" class="btn btn-primary" style="background-color:red; border-color:red;">Back to Home</a>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price (after sale)</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <?php
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];

                    $response = file_get_contents("http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?id=$product_id");
                    $productData = json_decode($response, true);

                    if (!isset($productData['data'][0])) continue;

                    $product = $productData['data'][0];
                    $subtotal = $product['price_after_sale'] * $quantity;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= number_format($product['price_after_sale'], 2) ?> EGP</td>
                    <td><?= $quantity ?></td>
                    <td><?= number_format($subtotal, 2) ?> EGP</td>
                    <td>
                        <a href="cart.php?remove=<?= $product_id ?>" class="btn btn-sm btn-danger">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>Total: <?= number_format($total, 2) ?> EGP</h4>
            <form method="POST" action="checkout.php">
                <a href="Home.php" class="btn btn-primary" style="background-color:red; border-color:red;">Back to Products</a>
                <button type="submit" name="checkout" class="btn btn-success">Proceed to Checkout</button>
            </form>
            
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Handle remove
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['product_id'] != $remove_id);
    header("Location: cart.php");
    exit;
}
?>
