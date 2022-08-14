<?php
// Importing the Router
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Router.php";
// Routes class
class Routes
{
    // Class variables
    private Router $Router;
    // Constructor method
    public function __construct()
    {
        // Instantiating the Router
        $this->Router = new Router();
        // Routing the application
        $this->route();
    }
    // Route method
    public function route()
    {
        $this->Router->request("GET", "/", "/Views/Homepage.php");
        $this->Router->request("GET", "/Login", "/Views/Login.php");
        $this->Router->request("GET", "/Register", "/Views/Register.php");
        $this->Router->request("GET", "/404", "/Views/HTTP404.php");
    }
}
