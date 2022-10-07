<?php

/**
 * • The class that stores all the properties related to the conversations given that it should inherit from the contact
 */
class Conversation extends Contact
{
    /**
     * Primary Key of the record
     */
    private int $id;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
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
}
