<?php
// Route class
class Router
{
    // Class variables
    private string $route;
    private string $root;
    private string $requestMethod;
    // Constructor method
    public function __construct()
    {
        // Setting the data needed for the router
        $this->setRoot($_SERVER['DOCUMENT_ROOT']);
        $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
        $this->setRoute($_SERVER['REQUEST_URI']);
        // Initializing the router
        $this->initialize();
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
    // Route method
    public function route()
    {
        // Switch-statement to verify the request method
        switch ($this->getRequestMethod()) {
            case 'GET':
                // Switch-statement to verify the route
                switch ($this->getRoute()) {
                    case '/':
                        require_once "{$this->getRoot()}/Views/Homepage.php";
                        break;
                    case '/Login':
                        require_once "{$this->getRoot()}/Views/Login.php";
                        break;
                    case '/Register':
                        require_once "{$this->getRoot()}/Views/Register.php";
                        break;
                    default:
                        http_response_code(404);
                        require_once "{$this->getRoot()}/Views/HTTP404.php";
                        break;
                }
                break;
        }
    }
    // Initialize method
    public function initialize()
    {
        // Routing the application
        $this->route();
    }
}
