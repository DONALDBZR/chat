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
    public $domain = "http://chat.local";
    protected PHPDataObject $PDO;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
    }
    // Username accessor method
    public function getUsername()
    {
        return $this->username;
    }
    // Username mutator method
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    // Mail Address accessor method
    public function getMailAddress()
    {
        return $this->mailAddress;
    }
    // Mail Address mutator method
    public function setMailAddress(string $mailAddress)
    {
        $this->mailAddress = $mailAddress;
    }
    // Password accessor method
    public function getPassword()
    {
        return $this->password;
    }
    // Password mutator method
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    // Login method
    public function login()
    {
        // Retrieving and decoding the JSON from the front-end
        $json = json_decode(file_get_contents('php://input'));
        // Selecting the data from the database
        $this->PDO->query("SELECT * FROM Chat.Users WHERE UserMailAddress = :UserMailAddress OR UserUsername = :UserUsername");
        $this->PDO->bind(":UserMailAddress", $json->name);
        $this->PDO->bind(":UserUsername", $json->name);
        $this->PDO->execute();
        // If-statement to verify that the user exists
        if (!empty($this->PDO->resultSet())) {
            // Storing the data needed before further verification
            $this->setUsername($this->PDO->resultSet()[0]['UserUsername']);
            $this->setMailAddress($this->PDO->resultSet()[0]['UserMailAddress']);
            // If-statement to verify the passwords
            if (password_verify($json->password, $this->PDO->resultSet()[0]['UserPassword'])) {
                // Starting the session
                session_start();
                // Creating the session object
                $user = array(
                    "username" => $this->getUsername(),
                    "mailAddress" => $this->getMailAddress(),
                    "password" => $this->getPassword()
                );
                // Setting the session variable
                $_SESSION['user'] = $user;
                // JSON to be encoded and to be sent to the client
                $json = array(
                    "success" => "success",
                    "url" => "{$this->domain}/User/{$this->getUsername()}",
                    "message" => "You will be connected to the service as soon as possible..."
                );
                // Preparing the header for the JSON
                header('Content-Type: application/json');
                // Sending the JSON
                echo json_encode($json);
            } else {
                // JSON to be encoded and to be sent to the client
                $json = array(
                    "success" => "failure",
                    "url" => "{$this->domain}/Login",
                    "message" => "Your password is incorrect!"
                );
                // Preparing the header for the JSON
                header('Content-Type: application/json');
                // Sending the JSON
                echo json_encode($json);
            }
        } else {
            // JSON to be encoded and to be sent to the client
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}/",
                "message" => "You do not have an account!"
            );
            // Preparing the header for the JSON
            header('Content-Type: application/json');
            // Sending the JSON
            echo json_encode($json);
        }
    }
}
