<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing Password
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Password.php";
// Importing User
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/User.php";
// Instantiating User
$User = new User();
// If-statement to verify that there is a json
if (json_decode(file_get_contents("php://input")) != null) {
    // If-statement to verify that the JSON does not have any null value
    if (!empty(json_decode(file_get_contents("php://input"))->mailAddress)) {
        // Resetting the password
        $User->forgotPassword();
    } else {
        // JSON to be encoded and sent to the client
        $json = array(
            "success" => "failure",
            "url" => "{$User->domain}/ForgotPassword",
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
        "url" => "{$User->domain}/ForgotPassword",
        "message" => "The form must be completely filled!"
    );
    // Preparing the header for the JSON
    header('Content-Type: application/json', true, 200);
    // Sending the JSON
    echo json_encode($json);
}
