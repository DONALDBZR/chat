<?php

/**
 * • The class that stores all the properties that are related to the contacts given that it should inherit the user class
 */
class Contact extends User
{
    /**
     * Primary Key of the record
     */
    private int $id;
    /**
     * The user which has the contact list
     */
    private string $user;
    /**
     * The contact of the user
     */
    private string $friend;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
        // Instantiating Mail
        $this->Mail = new Mail();
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
    // Friend accessor method
    public function getFriend()
    {
        return $this->friend;
    }
    // Friend mutator method
    public function setFriend(string $friend)
    {
        $this->friend = $friend;
    }
    /**
     * Getting all the contacts that the current user has to send to the client as a response.
     */
    public function get()
    {
        $contacts = array();
        $this->PDO->query("SELECT * FROM Chat.Contacts WHERE ContactsUser = :ContactsUser OR ContactsFriend = :ContactsFriend");
        $this->PDO->bind(":ContactsUser", $_SESSION["User"]["username"]);
        $this->PDO->bind(":ContactsFriend", $_SESSION["User"]["username"]);
        $this->PDO->execute();
        if (!empty($this->PDO->resultSet())) {
            for ($index = 0; $index < count($this->PDO->resultSet()); $index++) {
                $this->setId($this->PDO->resultSet()[$index]['ContactsId']);
                $this->setUser($this->PDO->resultSet()[$index]['ContactsUser']);
                $this->setFriend($this->PDO->resultSet()[$index]['ContactsFriend']);
                if ($this->getUser() != $_SESSION['User']['username']) {
                    $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersUsername = :UsersUsername");
                    $this->PDO->bind(":UsersUsername", $this->getUser());
                    $this->PDO->execute();
                    $this->setProfilePicture($this->PDO->resultSet()[0]['UsersProfilePicture']);
                } else if ($this->getFriend() != $_SESSION['User']['username']) {
                    $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersUsername = :UsersUsername");
                    $this->PDO->bind(":UsersUsername", $this->getFriend());
                    $this->PDO->execute();
                    $this->setProfilePicture($this->PDO->resultSet()[0]['UsersProfilePicture']);
                }
                $contact = array(
                    "id" => $this->getId(),
                    "user" => $this->getUser(),
                    "friend" => $this->getFriend(),
                    "profilePicture" => $this->getProfilePicture()
                );
                array_push($contacts, $contact);
            }
            $json = array(
                "class" => "contact",
                "message" => "",
                "contacts" => $contacts
            );
            header('Content-Type: application/json', true, 200);
            echo json_encode($json);
        } else {
            $json = array(
                "class" => "foreverAlone",
                "message" => "You do not have any contact yet! 😢",
                "contacts" => $contacts
            );
            header('Content-Type: application/json', true, 200);
            echo json_encode($json);
        }
    }
    /**
     * Adding contact for both users
     */
    public function add()
    {
        $JSON = json_decode(file_get_contents("php://input"));
        $this->setUser($_SESSION['User']['username']);
        $this->setFriend($JSON->username);
        $this->PDO->query("INSERT INTO Chat.Contacts (ContactsUser, ContactsFriend) VALUES (:ContactsUser, :ContactsFriend)");
        $this->PDO->bind(":ContactsUser", $this->getUser());
        $this->PDO->bind(":ContactsFriend", $this->getFriend());
        $this->PDO->execute();
        $JSON = array(
            "url" => "{$this->domain}/Users/Dashboard/{$this->getUser()}"
        );
        header('Content-Type: application/json', true, 200);
        echo json_encode($JSON);
    }
}
