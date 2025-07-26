<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to checkout.";
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Cart is empty.";
    exit;
}

foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Fetch product price from API
    $productData = file_get_contents("http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?id=$product_id");
    $product = json_decode($productData, true);

    if (!isset($product['data'][0])) {
        continue; // skip invalid product
    }

    $price = $product['data'][0]['price_after_sale'];
    $createdAt = date('Y-m-d H:i:s');
    $status = 'Processing';

    $postData = [
        'user_id'    => $_SESSION['user_id'],
        'product_id' => $product_id,
        'quantity'   => $quantity,
        'price'      => $price,
        'createdAt'  => $createdAt,
        'status'     => $status
    ];

    $ch = curl_init("http://localhost/NTI/Final_Project/APIs/OrderAPI.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
}

// Clear cart
$_SESSION['cart'] = [];

header("Location: thank_you.php");
exit;
