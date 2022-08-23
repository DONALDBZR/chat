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
            case "/User/Dashboard/{$_SESSION['User']['username']}":
                $Router = new Router("GET", "/User/Dashboard/{$_SESSION['User']['username']}", "/Views/UserDashboard.php");
                break;
            case '/User':
                $Router = new Router("GET", "/User", "/Controllers/User.php");
                break;
            case '/Sign-Out':
                $Router = new Router("GET", "/Sign-Out", "/Views/SignOut.php");
                break;
            case '/User/LogOut':
                $Router = new Router("GET", "/User/LogOut", "/Controllers/SignOut.php");
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
