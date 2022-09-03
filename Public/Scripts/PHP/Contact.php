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
        return $this->id;
    }
    // User mutator method
    public function setUser(int $id)
    {
        $this->id = $id;
    }
    // Friend accessor method
    public function getFriend()
    {
        return $this->friend;
    }
    // Friend mutator method
    public function setFriend(int $friend)
    {
        $this->friend = $friend;
    }
    /**
     * Getting all the contacts that the current user has to send to the client as a response.
     */
    public function getContacts()
    {
        $contacts = array();
        $this->PDO->query("SELECT * FROM Chat.Contacts WHERE ContactsUser = :ContactsUser");
        $this->PDO->bind(":ContactsUser", $_SESSION["User"]["username"]);
        $this->PDO->execute();
        if (!empty($this->PDO->resultSet())) {
            for ($index = 0; $index < count($this->PDO->resultSet()); $index++) {
                $this->setId($this->PDO->resultSet()[$index]['ContactsId']);
                $this->setUser($this->PDO->resultSet()[$index]['ContactsUser']);
                $this->setFriend($this->PDO->resultSet()[$index]['ContactsFriend']);
                $contact = array(
                    "id" => $this->getId(),
                    "user" => $this->getUser(),
                    "friend" => $this->getFriend()
                );
                array_push($contacts, $contact);
            }
            $json = array(
                "message" => "",
                "contacts" => $contacts
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            $json = array(
                "message" => "You do not have any contact yet!",
                "contacts" => $contacts
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
}
