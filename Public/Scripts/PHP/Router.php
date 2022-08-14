<?php
// Route class
class Router
{
    // Class variables
    private string $route;
    private string $path;
    private string $root;
    private string $requestMethod;
    // Constructor method
    public function __construct()
    {
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
    // Path accessor method
    public function getPath()
    {
        return $this->path;
    }
    // Path mutator method
    public function setPath(string $path)
    {
        $this->path = $path;
    }
    // Root accessor method
    public function getRoot()
    {
        return $this->root;
    }
    // Root mutator method
    public function setRoot(string $root)
    {
        $this->root = $root;
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
    // Request method
    public function request(string $requestMethod, string $route, string $path)
    {
        // Switch-statement to verify the request method of the route
        switch ($requestMethod) {
            case 'GET':
            case 'POST':
            case 'PATCH':
            case 'DELETE':
            default:
                // Routing the route
                $this->route($route, $path);
                break;
        }
    }
    // Route method
    public function route($uri)
    {
        switch ($uri) {
            case "":
            case "/":
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Views/Homepage.php";
                break;
            case "/Login":
                require_once $_SERVER["DOCUMENT_ROOT"] . "/Views/Login.php";
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
}
