<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ ."/../CRUDS/prodCRUD.php";

$request_method = $_SERVER['REQUEST_METHOD'] ?? '';

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $productID = intval($_GET['id']);
            echo get_product($productID);
        }else if(isset($_GET['category_id']) && is_numeric($_GET['category_id'])){
            $category_id=$_GET['category_id'];
            echo get_products_by_category($category_id);
        } else {
            echo get_all_products();
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

        echo insert_new_product($data);
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
            echo update_product($_GET['id'], $data);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $productID = intval($_GET['id']);
            echo delete_product($productID);
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
