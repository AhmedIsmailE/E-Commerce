<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ ."/../CRUDS/orderCRUD.php";

$request_method = $_SERVER['REQUEST_METHOD'] ?? '';

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $orderID = intval($_GET['id']);
            echo get_order($orderID);
        }else if(isset($_GET['user_id']) && is_numeric($_GET['user_id'])){
            $user_id=$_GET['user_id'];
            echo get_orders_by_userid($user_id);
        }else if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
            $product_id=$_GET['product_id'];
            echo get_orders_by_productid($product_id);
        }
         else {
            echo get_all_orders();
        }
        break;

    case 'POST':
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        if (empty($data)) {
            http_response_code(400);
            echo json_encode([
                "status" => "400 Bad Request",
                "message" => "Invalid JSON data or empty body"
            ]);
            exit;
        }

        echo insert_new_order($data);
        break;
    case 'PUT':
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            http_response_code(400);
            echo json_encode([
                "status" => "400 Bad Request",
                "message" => "Missing or invalid 'id' for update"
            ]);
            exit;
        }
        if (json_last_error() != JSON_ERROR_NONE || empty($data)) {
            http_response_code(400);
            echo json_encode([
                "status" => "400 Bad Request",
                "message" => "Invalid JSON data or empty body"
            ]);
            exit;
        } else {
            echo update_order(intval($_GET['id']), $data);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $orderID = intval($_GET['id']);
            echo delete_order($orderID);
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => "400 Bad Request",
                "message" => "Missing 'id' parameter"
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            "status" => "405 Method Not Allowed",
            "message" => "Allowed methods: GET, POST, DELETE, PUT"
        ]);
        break;
}
?>
