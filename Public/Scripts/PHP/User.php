<?php
// Importing PDO
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/PDO.php";
// User class
class User
{
    // Class variables
    private string $username;
    private string $mailAddress;
    private string $password;
    protected PHPDataObject $PDO;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
    }
}
