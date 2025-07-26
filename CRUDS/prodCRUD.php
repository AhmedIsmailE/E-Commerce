<?php
require_once("../APIs/dbConnection.php");

function get_product($prodID) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE id = ?";

    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("i", $prodID);

    if (!$stmt->execute()) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => $stmt->error
        ]);
    }

    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);

    return json_encode(value: [
        "status" => "200 OK",
        "message" => "Product ID {$prodID} retrieved",
        "data" => $data
    ]);
}
function get_products_by_category($category_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE category_id = ?";

    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("i", $category_id);

    if (!$stmt->execute()) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => $stmt->error
        ]);
    }

    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);

    return json_encode(value: [
        "status" => "200 OK",
        "message" => "category ID {$category_id} retrieved",
        "data" => $data
    ]);
}
function get_all_products() {
    $conn = get_db_connection();
    $sql = "SELECT * FROM products";

    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => $stmt->error
        ]);
    }

    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);

    return json_encode([
        "status" => "200 OK",
        "message" => "All products retrieved",
        "data" => $data
    ]);
}

function insert_new_product($data) {
    $conn = get_db_connection();

    if (!empty($data['product_name']) && !empty($data['product_price'])) {
        $stmt = $conn->prepare("INSERT INTO products 
            (product_name, product_desc, category_id, product_quantity, product_price, percentage_discount, online_date, product_img) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssdiiss",
            $data['product_name'],
            $data['product_desc'],
            $data['category_id'],
            $data['product_quantity'],
            $data['product_price'],
            $data['percentage_discount'],
            $data['online_date'],
            $data['product_img']
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product created successfully."]);
        } else {
            echo json_encode(["error" => "Failed to create product."]);
        }
    } else {
        echo json_encode(["error" => "Missing required fields."]);
    }
}

function delete_product($prodID) {
    $conn = get_db_connection();
    $sql = "DELETE FROM products WHERE id = ?";

    try {
        $stmt1 = $conn->prepare("DELETE FROM orders WHERE product_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $prodID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            return json_encode([
                "status" => "200 OK",
                "message" => "Product ID {$prodID} deleted successfully"
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                "status" => "404 Not Found",
                "message" => "Product ID {$prodID} does not exist"
            ]);
        }

    } catch (Exception $e) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => "Error deleting user",
            "error" => $e->getMessage()
        ]);
    }
}

function update_product($id, $data) {
    $conn = get_db_connection();

    if (!empty($id)) {
        $stmt = $conn->prepare("UPDATE products 
            SET product_name=?, product_desc=?, category_id=?, product_quantity=?, product_price=?, percentage_discount=?, online_date=?, product_img=? 
            WHERE id=?");

        $stmt->bind_param("sssdiissi",
            $data['product_name'],
            $data['product_desc'],
            $data['category_id'],
            $data['product_quantity'],
            $data['product_price'],
            $data['percentage_discount'],
            $data['online_date'],
            $data['product_img'],
            $id
        );

        if ($stmt->execute()) {
            return json_encode([
                "status" => "200 OK",
                "message" => "Product updated successfully."
            ]);
        } else {
            return json_encode([
                "status" => "500 Internal Server Error",
                "message" => "Failed to update product: " . $stmt->error
            ]);
        }
    } else {
        return json_encode([
            "status" => "400 Bad Request",
            "message" => "Product ID is required."
        ]);
    }
}



?>
