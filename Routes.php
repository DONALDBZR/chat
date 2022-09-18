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
            case "/Users/Dashboard/{$_SESSION['User']['username']}":
                $Router = new Router("GET", "/User/Dashboard/{$_SESSION['User']['username']}", "/Views/UserDashboard.php");
                break;
            case '/Users/CurrentUser':
                $Router = new Router("GET", "/User", "/Controllers/CurrentUser.php");
                break;
            case '/Sign-Out':
                $Router = new Router("GET", "/Sign-Out", "/Views/SignOut.php");
                break;
            case '/LogOut':
                $Router = new Router("GET", "/User/LogOut", "/Controllers/SignOut.php");
                break;
            case "/Logins/Verification/{$_SESSION['Login']['id']}":
                $Router = new Router("GET", "/Logins/Verification/{$_SESSION['Login']['id']}", "/Views/LoginVerification.php");
                break;
            case '/ForgotPassword':
                $Router = new Router("GET", "/ForgotPassword", "/Views/ForgotPassword.php");
                break;
            case '/Contacts/Get':
                $Router = new Router("GET", "/Contacts/Get", "/Controllers/GetContacts.php");
                break;
            case "/Users/Profile/{$_SESSION['User']['username']}":
                $Router = new Router("GET", "/User/Profile/{$_SESSION['User']['username']}", "/Views/UserProfile.php");
                break;
            case "/Users/Profile/{$_SESSION['User']['username']}/Edit":
                $Router = new Router("GET", "/User/Profile/{$_SESSION['User']['username']}/Edit", "/Views/UserEditProfile.php");
                break;
            case "/Users/Account/{$_SESSION['User']['username']}":
                $Router = new Router("GET", "/User/Account/{$_SESSION['User']['username']}", "/Views/UserAccount.php");
                break;
            case "/Users/Search":
                $Router = new Router("GET", "/Users/Search", "/Views/UsersSearch.php");
                break;
            case "/Users":
                $Router = new Router("GET", "/Users", "/Controllers/Users.php");
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
            case '/Login/Verification':
                $Router = new Router("POST", "/Login/Verification", "/Controllers/LoginVerification.php");
                break;
            case '/ForgotPassword':
                $Router = new Router("POST", "/ForgotPassword", "/Controllers/ForgotPassword.php");
                break;
            case "/User/Profile/{$_SESSION['User']['username']}/Edit":
                $Router = new Router("POST", "/User/Profile/{$_SESSION['User']['username']}/Edit", "/Controllers/UserEditProfile.php");
                break;
            case "/User/Account/{$_SESSION['User']['username']}":
                $Router = new Router("POST", "/User/Account/{$_SESSION['User']['username']}", "/Controllers/UserAccount.php");
                break;
        }
        break;
}
