<?php
require_once("../APIs/dbConnection.php");

function get_order($orderID) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE id = ?";

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
        "message" => "Product ID {$orderID} retrieved",
        "data" => $data
    ]);
}
function get_orders_by_userid($user_id) {
    $conn = get_db_connection();
    $sql = "SELECT 
                o.id,  
                p.product_name AS product_name,
                o.quantity, 
                o.price, 
                o.status 
            FROM orders o
            JOIN products p ON o.product_id = p.id 
            WHERE o.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

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
        "message" => "Orders for user ID {$user_id} retrieved",
        "data" => $data
    ]);
}
function get_orders_by_productid($product_id) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE product_id = ?";

    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("i", $product_id);

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
        "message" => "product ID {$product_id} retrieved",
        "data" => $data
    ]);
}
function get_all_orders() {
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders";

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
        "message" => "All orders retrieved",
        "data" => $data
    ]);
}

function insert_new_order($data) {
    $conn = get_db_connection();

    if (!empty($data['user_id']) && !empty($data['product_id'])) {
        $stmt = $conn->prepare("INSERT INTO orders 
            (user_id, product_id, quantity, price, createdAt, status) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiss",
            $data['user_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price'],
            $data['createdAt'],
            $data['status']
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Order created successfully."]);
        } else {
            echo json_encode(["error" => "Failed to create order."]);
        }
    } else {
        echo json_encode(["error" => "Missing required fields."]);
    }
}

function delete_order($orderID) {
    $conn = get_db_connection();
    $sql = "DELETE FROM orders WHERE id = ?";

    try {

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            return json_encode([
                "status" => "200 OK",
                "message" => "order ID {$orderID} deleted successfully"
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                "status" => "404 Not Found",
                "message" => "order ID {$orderID} does not exist"
            ]);
        }

    } catch (Exception $e) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => "Error deleting order",
            "error" => $e->getMessage()
        ]);
    }
}

function update_order($id, $data) {
    $conn = get_db_connection();

    if (!empty($id)) {
        $stmt = $conn->prepare("UPDATE orders 
            SET user_id=?, product_id=?, quantity=?, price=?, createdAt=?, status=? WHERE id=?");

        $stmt->bind_param("iiiissi",
            $data['user_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price'],
            $data['createdAt'],
            $data['status'],
            $id
        );

        if ($stmt->execute()) {
            return json_encode([
                "status" => "200 OK",
                "message" => "Order updated successfully."
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
            "message" => "Order ID is required."
        ]);
    }
}



?>
