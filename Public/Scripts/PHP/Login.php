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
}
