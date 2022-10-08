<?php
// Importing Group
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Group.php";
/**
 * • The class that stores all the properties that are related to the group members
 */
class GroupMember extends User
{
    /**
     * The primary key of the Group Members table
     */
    private int $id;
    /**
     * • The class that stores all the properties that are related to the groups
     */
    private Group $Group;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
        // Instantiating Group
        $this->Group = new Group();
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
    // Group.ID accessor method
    public function getGroupId()
    {
        $this->Group->getId();
    }
    // Group.ID mutator method
    public function setGroupId(int $group_id)
    {
        $this->Group->setId($group_id);
    }
    // User.Username accessor method
    public function getUserUsername()
    {
        $this->getUsername();
    }
    // User.Username mutator method
    public function setUserUsername(string $user_username)
    {
        $this->setUsername($user_username);
    }
}
