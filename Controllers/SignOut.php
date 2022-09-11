<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing Password
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Password.php";
// Importing User
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/User.php";
// Importing Login
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Login.php";
// Instantiating Login
$Login = new Login();
// Recording the logging out time of the user
$Login->trackOut();
