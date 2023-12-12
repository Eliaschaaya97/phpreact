<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

$conn = new mysqli("localhost", "root", "", "react-login");
if (mysqli_connect_error()) {
    echo json_encode(array("result" => mysqli_connect_error()));
    exit();
}

$eData = file_get_contents("php://input");
$dData = json_decode($eData, true);
$email = $dData['email'];
$password = $dData['password'];

$result = "";

if ($email != "" && $password != "") {
    $sql = "SELECT * FROM register WHERE email ='$email';";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) != 0) {
        $row = mysqli_fetch_assoc($res);
        $hashedPassword = $row['password'];

        // Use password_verify to check if the provided password matches the hashed password
        if (password_verify($password, $hashedPassword)) {
            $result = "loggedin successfully!";
        } else {
            $result = "Invalid username or password!";
        }
    } else {
        $result = "Invalid username or password!";
    }
} else {
    $result = "All fields are required!";
}

$conn->close();
$response[] = array("result" => $result);
echo json_encode($response);

?>
