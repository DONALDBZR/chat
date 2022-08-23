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
}
