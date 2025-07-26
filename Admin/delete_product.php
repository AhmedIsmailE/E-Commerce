<?php
session_start();
require_once("../CRUDS/prodCRUD.php"); // Make sure path is correct

// 1. Check admin permissions
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Home.php");
    exit();
}

// 2. Validate input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Missing or invalid product ID.");
}

$productID = intval($_GET['id']);

// 3. Call the delete function from the Products CRUD
$response = json_decode(delete_product($productID), true);

// 4. Redirect or show message based on response
if ($response && $response['status'] === "200 OK") {
    header("Location: get_all_products.php?deleted=success");
    exit();
} else {
    echo "<h3>Error deleting product</h3>";
    echo "<p>" . ($response['message'] ?? "Unknown error") . "</p>";
}
?>
