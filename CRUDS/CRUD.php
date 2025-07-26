<?php
require_once("../APIs/dbConnection.php");

function get_user($userID) {
    $conn = get_db_connection();
    $sql = "SELECT * FROM users WHERE id = ?";

    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("i", $userID);

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
        "message" => "Employee ID {$userID} retrieved",
        "data" => $data
    ]);
}

function get_all_users() {
    $conn = get_db_connection();
    $sql = "SELECT * FROM users";

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
        "message" => "All employees retrieved",
        "data" => $data
    ]);
}

function insert_new_user($data) {
    $conn = get_db_connection();
    $email = $data['email'] ?? null;

    
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        http_response_code(400);
        echo json_encode([
            "status" => "400 Bad Request",
            "errors" => ["Email is already registered."]
        ]);
        exit;
    }
    $fName  = $data["fName"] ?? null;
    $lName  = $data["lName"] ?? null;
    $password  = $data["password"] ?? null;

    $insertSql = "INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $data['fName'], $data['lName'], $data['email'], $data['password']);

    if ($stmt->execute()) {

        http_response_code(200);
        echo json_encode(["status" => "200 OK", "message" => "Registered successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "500 Internal Server Error", "message" => "Registration failed"]);
    }
}

function delete_user($userID) {
    $conn = get_db_connection();
    $sql = "DELETE FROM users WHERE id = ?";

    try {
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            return json_encode([
                "status" => "200 OK",
                "message" => "User ID {$userID} deleted successfully"
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                "status" => "404 Not Found",
                "message" => "User ID {$userID} does not exist"
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

function update_user($data){
    session_start();
    $conn = get_db_connection();
    
    $userID = $data['id'];
    $fName = $data['firstName'];
    $lName = $data['lastName'];
    $email = $data['email'];
    $password = $data['password'];
    $role = $data['role'] ?? "customer";
    
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['fname'] = $data['firstName'];
    $_SESSION['lname'] = $data['lastName'];
    $_SESSION['password'] = $data['password'];
    

    $sql = "UPDATE users SET firstName=?,lastName=?,email=?,password=?,role=?
            WHERE id = ?";

    try{
               
        $stmt = $conn->prepare($sql);
       
        $stmt->bind_param("sssssi",$fName,$lName,$email,$password,$role,$userID);
        
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
             http_response_code(200);
            return json_encode(["status" => "success 200", "message" => "user {$fName} updated successfully"]);
        } else {
            http_response_code(404);
            return json_encode(["status" => "fail 404", "message" => "No employee updated"]);
        }
    }catch(Exception $e){
        http_response_code(500);
        return json_encode(["status" => "error 500", "message" => "Error when employee updated"]);
    }

}
function check_user($data){
   
    session_start();
    $conn = get_db_connection();
    $sql = "SELECT * FROM users WHERE email = ? and password = ? ";

    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("ss", $data['email'],$data['password']);

    if (!$stmt->execute()) {
        http_response_code(500);
        return json_encode([
            "status" => "500 Internal Server Error",
            "message" => $stmt->error
        ]);
    }

    $res = $stmt->get_result();
    $result = $res->fetch_all(MYSQLI_ASSOC);
    if ($result) {
        $user = $result[0];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fname'] = $user['firstName'];
        $_SESSION['lname'] = $user['lastName'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['role'] = $user['role'];

        http_response_code(200);
        return json_encode([
            "status" => "200 OK",
            "message" => "Login successful",
            "data" => $result
        ]);
    } else {
        http_response_code(401);
        return json_encode([
            "status" => "401 Unauthorized",
            "message" => "invalid email or password"
        ]);
    }
}
?>
