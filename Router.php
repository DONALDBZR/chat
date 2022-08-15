<?php
// Starting session
session_start();
// Route class
class Router
{
    // Class variables
    private string $route;
    private string $root;
    private string $path;
    private string $requestMethod;
    // Constructor method
    public function __construct(string $requestMethod, string $route, string $path)
    {
        // Setting the data needed for the router
        $this->setRoot($_SERVER['DOCUMENT_ROOT']);
        // Verifying the request method to route the connection
        $this->verifyRequestMethod($requestMethod, $route, $path);
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
    // Verify Request Method method
    public function verifyRequestMethod(string $requestMethod, string $route, string $path)
    {
        // Setting the data needed
        $this->setRequestMethod($requestMethod);
        $this->setRoute($route);
        $this->setPath($path);
        // Switch-statement to verify the request method of the route
        switch ($this->getRequestMethod()) {
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                $this->route($this->getRoute(), $this->getPath());
                break;
        }
    }
    // Route method
    public function route(string $route, string $path)
    {
        // If-statement ti verify that the route is a 404 request
        if ($route == "/404") {
            require_once "{$this->getRoot()}/{$path}";
            exit();
        }
        // Sanitizing the urel of the request
        $requestURL = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        // Trimming the url
        $requestURL = rtrim($requestURL, '/');
        // Tokenizing the url
        $requestURL = strtok($requestURL, '?');
        // Spliting the route
        $routeParts = explode('/', $route);
        // Spliting the url
        $requestURLParts = explode('/', $requestURL);
        array_shift($routeParts);
        array_shift($requestURLParts);
        // If-statement to verify that the route's elements starts with null and that the url's elements's length is 0
        if ($routeParts[0] == '' && count($requestURLParts) == 0) {
            require_once "{$this->getRoot()}/{$path}";
            exit();
        }
        // If-Statement to verify that the route and url's elements's lentgh are not equal
        if (count($routeParts) != count($requestURLParts)) {
            return;
        }
        // Initializing the parameters
        $parameters = array();
        // For-Loop to iterate over the length of the route's elements
        for ($index = 0; $index < count($routeParts); $index++) {
            // Retrieving the element at the index position
            $routePart = $routeParts[$index];
            // If-statement to verify the regex of the element
            if (preg_match("/^[$]/", $routePart)) {
                // Trimming the element
                $routePart = ltrim($routePart, '$');
                // Adding the url's element to the parameters
                array_push($parameters, $requestURLParts[$index]);
                $$routePart = $requestURLParts[$index];
            } else if ($routeParts[$index] != $requestURLParts[$index]) {
                return;
            }
        }
        // If-statement to veriy that there is a callback function
        if (is_callable($path)) {
            // Calling the function
            call_user_func($path);
            exit();
        }
        require_once "{$this->getRoot()}/{$path}";
        exit();
    }
    // Out method
    public function out(string $text)
    {
        echo htmlspecialchars($text);
    }
    // CSRF Set method
    public function csrfSet()
    {
        // If-statement to verify that there is not a csrf session variable
        if (!isset($_SESSION["csrf"])) {
            // Setting the session's variable
            $_SESSION["csrf"] = bin2hex(random_bytes(50));
        }
        echo "<input type='hidden' name='csrf' value='{$_SESSION['csrf']}' />";
    }
    // Verify CSRF method
    public function verifyCSRF()
    {
        // If-statement to the session variable and the post request are not set
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        // If-statement to the session variable and the post request are not equal
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }
        return true;
    }
}
