<?php
// Importing the Router
require_once "{$_SERVER['DOCUMENT_ROOT']}/Router.php";
// Switch-statement to verify the request method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Switch-statement to verify the url
        switch ($_SERVER['REQUEST_URI']) {
            case '/':
                $Router = new Router("GET", "/", "/Views/Homepage.php");
                break;
            case '/Login':
                $Router = new Router("GET", "/Login", "/Views/Login.php");
                break;
            case '/Register':
                $Router = new Router("GET", "/Register", "/Views/Register.php");
                break;
        }
        break;
    case 'POST':
        // Switch-statement to verify the url
        switch ($_SERVER['REQUEST_URI']) {
            case '/Login':
                $Router = new Router("POST", "/Login", "/Controllers/Login.php");
                break;
            case '/Register':
                $Router = new Router("POST", "/Register", "/Controllers/Register.php");
                break;
        }
        break;
}
