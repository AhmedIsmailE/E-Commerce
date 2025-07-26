<?php
function getRelatedProducts($category_id, $exclude_id, $limit = 4) {
    $apiURL = "http://localhost/NTI/Final_Project/APIs/ProductsAPI.php?category_id=" . $category_id;
    $data = file_get_contents($apiURL);
    $response = json_decode($data, true);

    $products = $response['data'] ?? [];

    // Filter out the current product
    $products = array_filter($products, function($p) use ($exclude_id) {
        return $p['id'] != $exclude_id;
    });

    // Limit to 4 products
    return array_slice($products, 0, $limit);
}
?>