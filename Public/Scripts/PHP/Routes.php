<?php
// Importing the Router
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Router.php";
// Routes class
class Routes
{
    // Class variables
    private Router $Router;
    private string $route;
    private string $requestMethod;
    // Constructor method
    public function __construct()
    {
        // Instantiating the Router
        $this->Router = new Router();
        // Setting the data needed
        $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
        $this->setRoute($_SERVER['REQUEST_URI']);
        // Routing the application
        $this->route();
    }
    // Route accessor method
    public function getRoute()
    {
        return $this->route;
    }
    // Route mutator method
    public function setRoute(string $route)
    {
        $this->route = $route;
    }
    // Request Method accessor method
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
    // Request Method mutator method
    public function setRequestMethod(string $requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }
    // Route method
    public function route()
    {
        // Switch-statement to verify the request method
        switch ($this->getRequestMethod()) {
            case 'GET':
                // Switch-statement to verify the route
                switch ($this->getRoute()) {
                    case '/':
                        $this->Router->request($this->getRequestMethod(), $this->getRoute(), "/Views/Homepage.php");
                        break;
                    case '/Login':
                        $this->Router->request($this->getRequestMethod(), $this->getRoute(), "/Views/Login.php");
                        break;
                    case '/Register':
                        $this->Router->request($this->getRequestMethod(), $this->getRoute(), "/Views/Register.php");
                        break;
                    default:
                        $this->Router->request("GET", "/404", "/Views/HTTP404.php");
                        break;
                }
            case 'POST':
            case 'PATCH':
            case 'DELETE':
            default:
                $this->Router->request("GET", "/404", "/Views/HTTP404.php");
                break;
        }
    }
}
