<?php
class Router
{
    public function __construct()
    {
        $this->initialize();
    }
    public function __destruct()
    {
    }
    public function route($uri)
    {
        switch ($uri) {
            case "":
            case "/":
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Views/Homepage.php";
                break;
            case "/Register":
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Views/Register.php";
                break;
            default:
                http_response_code(404);
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Views/HTTP404.php";
                break;
        }
    }
    public function initialize()
    {
        $this->route($_SERVER["REQUEST_URI"]);
    }
}
