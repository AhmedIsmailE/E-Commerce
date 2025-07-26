<?php
// Handle file upload
$imageName = "";
if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $imageName = time() . "_" . basename($_FILES['product_img']['name']);
    move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadDir . $imageName);
}

$product = [
    'product_name'       => $_POST['product_name'] ?? '',
    'product_desc'       => $_POST['product_desc'] ?? '',
    'category_id'  => $_POST['category_id'] ?? '',
    'product_quantity'   => $_POST['product_quantity'] ?? '',
    'product_price'      => $_POST['product_price'] ?? '',
    'percentage_discount'=> $_POST['percentage_discount'] ?? '',
    'online_date'        => $_POST['online_date'] ?? '',
    'product_img'        => $imageName
];

try {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "http://localhost/NTI/Final_Project/APIs/ProductsAPI.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($product),
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $json = json_decode($response, true);
    header("Location: ../Admin/add_new_product.php?mess=" . ($json['message'] ?? "Unknown response"));

} catch (Exception $e) {
    header("Location: ../Admin/add_new_product.php?mess=ERROR : " . $e->getMessage());
}
?>
