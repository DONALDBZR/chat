<?php
// Importing the Router
require_once "{$_SERVER['DOCUMENT_ROOT']}/Router.php";
// Switch-statement to verify the request method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // If-statement to verify the url
        if ($_SERVER['REQUEST_URI'] == '/') {
            $Router = new Router("GET", "/", "/Views/Homepage.php");
        } else if ($_SERVER['REQUEST_URI'] == '/Login') {
            $Router = new Router("GET", "/Login", "/Views/Login.php");
        } else if ($_SERVER['REQUEST_URI'] == '/Register') {
            $Router = new Router("GET", "/Register", "/Views/Register.php");
        } else if (str_contains($_SERVER['REQUEST_URI'], '/User/Dashboard')) {
            $Router = new Router("GET", "/User/Dashboard", "/Views/UserDashboard.php");
        }
        break;
    case 'POST':
        // If-statement to verify the url
        if ($_SERVER['REQUEST_URI'] == '/Login') {
            $Router = new Router("POST", "/Login", "/Controllers/Login.php");
        } else if ($_SERVER['REQUEST_URI'] == '/Register') {
            $Router = new Router("POST", "/Register", "/Controllers/Register.php");
        }
        break;
}
