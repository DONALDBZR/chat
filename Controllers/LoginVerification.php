<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing Password
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Password.php";
// Instantiating Password
$Password = new Password();
// If-statement to verify that there is a json
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify that the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->oneTimePassword)) {
        // Starting the verification process of the one-time password
        $Password->otpVerify();
    } else {
        // JSON to be encoded and sent to the client
        $json = array(
            "success" => "failure",
            "url" => "{$Password->domain}/Logins/Verification",
            "message" => "The form must be completely filled!"
        );
        // Preparing the header for the JSON
        header('Content-Type: application/json', true, 200);
        // Sending the JSON
        echo json_encode($json);
    }
} else {
    // JSON to be encoded and sent to the client
    $json = array(
        "success" => "failure",
        "url" => "{$Password->domain}/Logins/Verification",
        "message" => "The form must be completely filled!"
    );
    // Preparing the header for the JSON
    header('Content-Type: application/json', true, 200);
    // Sending the JSON
    echo json_encode($json);
}
