<?php

/**
 * • The class that stores all the properties that are related to the login session as well as all the actions that are going to be performed in the application by the system.
 * • The class variables are set the same way as the fields in the Logins table.  In fact, the class represents a record.
 */
class Login extends User
{
    /**
     * The ID of the session which is also the primary key
     */
    private int $id;
    /**
     * The username of the user which is also the foreign key
     */
    private string $user;
    /**
     * The time at which the user has logged in the application
     */
    private string $timeIn;
    /**
     * The time at which the user has logged out the application
     */
    private string $timeOut;
    // Constructor method
    public function __construct()
    {
    }
    // ID accessor method
    public function getId()
    {
        return $this->id;
    }
    // ID mutator method
    public function setId(int $id)
    {
        $this->id = $id;
    }
    // User accessor method
    public function getUser()
    {
        return $this->user;
    }
    // User mutator method
    public function setUser(string $user)
    {
        $this->user = $user;
    }
    // Time In accessor method
    public function getTimeIn()
    {
        return $this->timeIn;
    }
    // Time In mutator method
    public function setTimeIn()
    {
        date_default_timezone_set('Indian/Mauritius');
        $this->timeIn = date("Y-m-d H:i:s");
    }
    // Time Out accessor method
    public function getTimeOut()
    {
        return $this->timeOut;
    }
    // Time Out mutator method
    public function setTimeOut()
    {
        date_default_timezone_set('Indian/Mauritius');
        $this->timeOut = date("Y-m-d H:i:s");
    }
    /**
     * Tracking the login time of the user
     * 1. Verifying whether the user exists before allowing it to log into the application.
     */
    public function trackIn()
    {
        $JSON = json_decode(file_get_contents('php://input'));
        $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersUsername = :UsersUsername");
        $this->PDO->bind(":UsersUsername", $JSON->username);
        $this->PDO->execute();
        if (!empty($this->PDO->resultSet())) {
            $this->setUsername($this->PDO->resultSet()[0]['UsersUsername']);
            $this->setMailAddress($this->PDO->resultSet()[0]['UsersMailAddress']);
            $this->setPassword($this->PDO->resultSet()[0]['UsersPassword']);
            $this->setUser($this->getUsername());
            $this->setTimeIn();
            $this->PDO->query("INSERT INTO Chat.Logins (LoginsUser, LoginsTimeIn) VALUES (:LoginsUser, :LoginsTimeIn)");
            $this->PDO->bind(":LoginsUser", $this->getUser());
            $this->PDO->bind(":LoginsTimeIn", $this->getTimeIn());
            $this->PDO->execute();
            $this->PDO->query("SELECT * FROM Chat.Logins WHERE LoginsUser = :LoginsUser AND LoginsTimeIn = :LoginsTimeIn");
            $this->PDO->bind(":LoginsUser", $this->getUser());
            $this->PDO->bind(":LoginsTimeIn", $this->getTimeIn());
            $this->PDO->execute();
            $this->setId($this->PDO->resultSet()[0]['LoginsId']);
            $login = array(
                "id" => $this->getId(),
                "user" => $this->getUser(),
                "timeIn" => $this->getTimeIn()
            );
            $_SESSION['Login'] = $login;
            $this->login();
        } else {
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}/",
                "message" => "You do not have an account!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
}
