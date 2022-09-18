<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing Password
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Password.php";
// Importing User
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/User.php";
// Instantiating User
$User = new User();
if ($_SERVER['REQUEST_URI'] == '/Users/Search' && json_decode(file_get_contents("php://input")) == null || $_SERVER['REQUEST_URI'] == '/Users/Search' && !empty(json_decode(file_get_contents("php://input"))->input)) {
    // JSON to be encoded and sent to the client
    $json = array(
        "success" => "failure",
        "url" => "{$User->domain}/Users/Search",
        "message" => "The form must be completely filled!"
    );
    // Preparing the header for the JSON
    header('Content-Type: application/json', true, 200);
    // Sending the JSON
    echo json_encode($json);
} else {
    // Searching the user
    $User->search();
}
