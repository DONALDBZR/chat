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
        // Setting the data needed for the router
        $this->setRequestMethod($requestMethod);
        $this->setRoute($route);
        $this->setPath($path);
        // Switch-statement to verify the request method of the route
        switch ($this->getRequestMethod()) {
            case 'GET':
            case 'POST':
            case 'PATCH':
            case 'DELETE':
            default:
                // Routing the route
                $this->route($this->getRoute(), $this->getPath());
                break;
        }
    }
    // Route method
    public function route(string $route, string $path)
    {
        // Setting the root of the router
        $this->setRoot($_SERVER['DOCUMENT_ROOT']);
        // If-statement to verify that the route is a HTTP 404
        if ($route === "/404") {
            // Importing the response for the request
            require_once "{$this->getRoot()}/{$path}";
            // Exiting the application
            exit();
        } else {
            // Sanitizing the url
            $requestUrl = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
            // Trimming the url
            $requestUrl = rtrim($requestUrl, '/');
            // Tokenizing the url
            $requestUrl = strtok($requestUrl, '?');
            // Seperating the route
            $routeParts = explode('/', $route);
            // Seperating the url
            $requestUrlParts = explode('/', $requestUrl);
            // Shifting the elements of the route
            array_shift($routeParts);
            // Shifting the elements of the request url
            array_shift($requestUrlParts);
            // If-statement to verify that the beginnin gof the route's elements and that the length of the url's elements are 0
            if ($routeParts[0] === '' && count($requestUrlParts) === 0) {
                // Importing the response needed
                require_once "{$this->getRoot()}/{$path}";
                // Exiting the application
                exit();
            } else if (count($routeParts) !== count($requestUrlParts)) {
                // Initializing the parameters
                $parameters = array();
                // For-loop to iterate over the elements of the route
                for ($index = 0; $index < count($routeParts); $index++) {
                    // Setting the element at the index positions
                    $routePart = $routeParts[$index];
                    // If-statement to verify the route element
                    if (preg_match("/^[$]/", $routePart)) {
                        // Trimming the element
                        $routePart = ltrim($routePart, '$');
                        // Adding the element of the url at the index's position
                        array_push($parameters, $requestUrlParts[$index]);
                        $$routePart = $requestUrlParts[$index];
                    } else if ($routeParts[$index] !== $requestUrlParts[$index]) {
                        return;
                    }
                }
            } else if (is_callable($path)) {
                // Calling the callback function
                call_user_func($path);
                exit();
            } else {
                // Importing the response
                require_once "{$this->getRoot()}/{$path}";
                // Exitting the application
                exit();
            }
        }
    }
    // Out method
    public function out(string $text)
    {
        // Converting the text into an HTML file
        echo htmlspecialchars($text);
    }
}
