<?php

/**
 * • The class that stores all the properties that are related to the contacts given that it should inherit the user class
 */
class Contacts extends User
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
}
