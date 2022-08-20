<?php
// Starting session
session_start();
/**
 * The router that will route all the requests to the application.
 */
class Router
{
    /**
     * The request address
     */
    private string $route;
    /**
     * The server on which the application is being hosted
     */
    private string $root;
    /**
     * The path of the response
     */
    private string $path;
    /**
     * The method of the request
     */
    private string $requestMethod;
    // Constructor method
    public function __construct(string $requestMethod, string $route, string $path)
    {
        $this->setRoot($_SERVER['DOCUMENT_ROOT']);
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
    /**
     * Verifying the request method before setting the route of the request for generating the adequate response
     */
    public function verifyRequestMethod(string $requestMethod, string $route, string $path)
    {
        $this->setRequestMethod($requestMethod);
        $this->setRoute($route);
        $this->setPath($path);
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
    /**
     * Setting the route of the request to get an adequate response
     */
    public function route(string $route, string $path)
    {
        if ($route == "/404") {
            require_once "{$this->getRoot()}/{$path}";
            exit();
        }
        $requestURL = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $requestURL = rtrim($requestURL, '/');
        $requestURL = strtok($requestURL, '?');
        $routeParts = explode('/', $route);
        $requestURLParts = explode('/', $requestURL);
        array_shift($routeParts);
        array_shift($requestURLParts);
        if ($routeParts[0] == '' && count($requestURLParts) == 0) {
            require_once "{$this->getRoot()}/{$path}";
            exit();
        }
        if (count($routeParts) != count($requestURLParts)) {
            return;
        }
        $parameters = array();
        for ($index = 0; $index < count($routeParts); $index++) {
            $routePart = $routeParts[$index];
            if (preg_match("/^[$]/", $routePart)) {
                $routePart = ltrim($routePart, '$');
                array_push($parameters, $requestURLParts[$index]);
                $$routePart = $requestURLParts[$index];
            } else if ($routeParts[$index] != $requestURLParts[$index]) {
                return;
            }
        }
        if (is_callable($path)) {
            call_user_func($path);
            exit();
        }
        require_once "{$this->getRoot()}/{$path}";
        exit();
    }
    /**
     * Displaying HTML elements
     */
    public function out(string $text)
    {
        echo htmlspecialchars($text);
    }
    /**
     * Preventing Cross-Site Request Forgery
     */
    public function csrfSet()
    {
        if (!isset($_SESSION["csrf"])) {
            $_SESSION["csrf"] = bin2hex(random_bytes(50));
        }
        echo "<input type='hidden' name='csrf' value='{$_SESSION['csrf']}' />";
    }
    /**
     * Verifying the session variable that was set in order to prevent cross-site request forgery
     */
    public function verifyCSRF()
    {
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }
        return true;
    }
}
