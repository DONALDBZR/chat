<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing User
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/User.php";
// Importing Login
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Login.php";
// Instantiating Login
$Login = new Login();
// If-statement to verify that there is a json
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify that the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->username) && !empty(json_decode(file_get_contents("php://input"))->password)) {
        // Starting the login process
        $Login->trackIn();
    } else {
        // JSON to be encoded and sent to the client
        $json = array(
            "success" => "failure",
            "url" => $Login->domain . "/Login",
            "message" => "The form must be completely filled!"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json');
        // Sending the JSON
        echo json_encode($json);
    }
} else {
    // JSON to be encoded and sent to the client
    $json = array(
        "success" => "failure",
        "url" => $Login->domain . "/Login",
        "message" => "The form must be completely filled!"
    );
    // Preparing the header for the JSON
    header('Content-Type: application/json');
    // Sending the JSON
    echo json_encode($json);
}
