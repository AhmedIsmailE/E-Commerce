<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-Action");

require_once("../CRUDS/CRUD.php");

//$token = bin2hex(random_bytes(16));
// $token = '1234abcd';
// $headers=getallheaders();
// "Bearer 1234abcd";
// $auth_token=$headers['Authorization'] ?? '';
// if($auth_token !== "Bearer ".$token){
//    http_response_code(400);
//             echo json_encode([
//                 "status" => "400 unauthorized",
//                 "message" => "Invalid api token"
//             ]);
//     exit;

// }

$request_method = $_SERVER['REQUEST_METHOD'] ?? '';

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $userID = intval($_GET['id']);
             echo get_user($userID); 
        } else {
             echo get_all_users(); 
        }
        break;

    case 'POST':
        $action = $_SERVER['HTTP_X_ACTION'] ?? '';

        if ($action === 'register'){
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);
            if (json_last_error() != JSON_ERROR_NONE || empty($data)) {
                http_response_code(400);
                echo json_encode([
                    "status" => "400 Bad Request",
                    "message" => "Invalid JSON data or empty body"
                ]);
                exit;
            } else {
                echo insert_new_user($data); 
            }
         }
        elseif ($action === 'login'){
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);

            if (json_last_error() != JSON_ERROR_NONE || empty($data)) {
                http_response_code(400);
                echo json_encode([
                    "status" => "400 Bad Request",
                    "message" => "Invalid JSON data or empty body"
                ]);
                exit;
            } else {
                echo check_user($data);
            }
        }
        break;

    case 'PUT':
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        
        if (json_last_error() != JSON_ERROR_NONE || empty($data)) {
            http_response_code(400);
            echo json_encode([
                "status" => "400 Bad Request",
                "message" => "Invalid JSON data or empty body"
            ]);
            exit;
        } else {

            echo update_user($data); 
        }
    break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $userID = intval($_GET['id']);
            echo delete_user($userID); 
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
