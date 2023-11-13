<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,Origin,  Accept");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');




error_reporting(E_ALL);
ini_set('display_errors', 1);

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
};

$data = json_decode(file_get_contents("php://input"));

if ($data) {
    $name = isset($data->name) ? $data->name : null;
    $lname = isset($data->lname) ? $data->lname : null;
    $Uni = isset($data->Uni) ? $data->Uni : null;
    $mobile = isset($data->mobile) ? $data->mobile : null;
    $email = isset($data->email) ? $data->email : null;
    $address1 = isset($data->address1) ? $data->address1 : null;
    $address2 = isset($data->address2) ? $data->address2 : null;

    $con = mysqli_connect("localhost", "root", "", "react-login") or die("could not connect: " . mysqli_connect_error());

    if ($name && $lname && $Uni && $mobile && $email && $address1 && $address2) {
        $sql = "INSERT INTO register (name, lname, Uni, mobile, email, address1, address2)
                VALUES ('$name', '$lname', '$Uni', '$mobile', '$email', '$address1', '$address2')";

        $result = mysqli_query($con, $sql);

        if ($result) {
            $response['data'] = array('status' => 'valid');
            echo json_encode($response);
        } else {
            $response['data'] = array('status' => 'invalid');
            echo json_encode($response);
        }
    } else {
        $response['data'] = array('status' => 'invalid', 'message' => 'Missing or invalid data fields');
        echo json_encode($response);
    }
} else {
    $response['data'] = array('status' => 'invalid', 'message' => 'No data received');
    echo json_encode($response);
}
?>
