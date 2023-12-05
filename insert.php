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

// Login part
// Login part

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
//         header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
//     }
//     exit(0);
// }


// //mn hon 
// $data = json_decode(file_get_contents("php://input"));
// $response = array();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Login part
//     if ($data && isset($data->email) && isset($data->password)) {
//         $email = $data->email;
//         $password = $data->password;


//         $con = mysqli_connect("localhost", "root", "", "react-login") or die("could not connect: " . mysqli_connect_error());

//         // Check if the email and password match a record in the database
//         $loginQuery = "SELECT * FROM register WHERE email = ? AND password = ?";
//         $stmt = mysqli_prepare($con, $loginQuery);
//         mysqli_stmt_bind_param($stmt, "ss", $email, $password);
//         mysqli_stmt_execute($stmt);

//         $loginResult = mysqli_stmt_get_result($stmt);

//         if (mysqli_num_rows($loginResult) > 0) {
//             // Login successful
//             $response['status'] = 'valid';
//             $response['message'] = 'Login successful';
//         } else {
//             // Login failed - user not found or incorrect password
//             $response['status'] = 'invalid';
//             $response['message'] = 'Invalid email or password';
//         }
//     } else {
//         // Invalid or missing data
//         $response['status'] = 'invalid';
//         $response['message'] = 'Invalid or missing data fields';
//     }

// }

?>