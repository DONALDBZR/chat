<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Router.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Public/Pages/Login.html";
$Router = new Router();
echo $_SERVER["REQUEST_URI"];
