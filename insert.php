<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
}

$data = json_decode(file_get_contents("php://input"));

if ($data) {
    $name = isset($data->name) ? $data->name : null;
    $lname = isset($data->lname) ? $data->lname : null;
    $password = isset($data->password) ? $data->password : null;
    $mobile = isset($data->mobile) ? $data->mobile : null;
    $email = isset($data->email) ? $data->email : null;
    $uni = isset($data->uni) ? $data->uni : null;
    $address = isset($data->address) ? $data->address : null;

    $con = mysqli_connect("localhost", "root", "", "react-login") or die("could not connect: " . mysqli_connect_error());

   // ... (previous code)

if ($name && $lname && $password && $mobile && $email && $uni && $address) {
    $sql = "INSERT INTO register (name, lname, password, mobile, email, uni, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $lname, $password, $mobile, $email, $uni, $address);
    mysqli_stmt_execute($stmt);

    if ($stmt) {
        $response['status'] = 'valid';
        echo json_encode($response);
    } else {
        $response['status'] = 'invalid';
        echo json_encode($response);
    }
} else {
    $response['status'] = 'invalid';
    $response['message'] = 'Missing or invalid data fields';
    echo json_encode($response);
}

} else {
    $response['status'] = 'invalid';
    $response['message'] = 'No data received';
    echo json_encode($response);
}


?>