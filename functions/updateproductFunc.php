<?php
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid Product ID");
}

// Handle file upload
$imageName = $_POST['current_img'] ?? "";
if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir =  "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $imageName = time() . "_" . basename($_FILES['product_img']['name']);
    move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadDir . $imageName);
}

// Prepare product data
$product = [
    'product_name'        => $_POST['product_name'] ?? '',
    'product_desc'        => $_POST['product_desc'] ?? '',
    'category_id'   => $_POST['category_id'] ?? '',
    'product_quantity'    => $_POST['product_quantity'] ?? 0,
    'product_price'       => $_POST['product_price'] ?? 0,
    'percentage_discount' => $_POST['percentage_discount'] ?? 0,
    'online_date'         => $_POST['online_date'] ?? '',
    'product_img'         => ($imageName)?$imageName:$_POST['old_img']
];

// Send PUT request to API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?id=$id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => json_encode($product),
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
]);

$response = curl_exec($curl);
curl_close($curl);

$json = json_decode($response, true);
$message = $json['message'] ?? $json['error'] ?? 'Unknown response';

header("Location: ../Admin/edit_product.php?id=$id&mess=" . urlencode($message));
