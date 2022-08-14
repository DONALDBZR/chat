<?php
// Importing the Router
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Router.php";
// Routes class
class Routes {
    // Class variables
    private Router $Router;
    // Constructor method
    public function __construct() {
        // Instantiating the Router
        $this->Router = new Router();
    }
}