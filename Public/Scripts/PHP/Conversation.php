<?php
// Importing Group Member
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/GroupMember.php";
// Importing Contact
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Contact.php";
/**
 * • The class that stores all the properties related to the conversations given that it is a class which is composed of Contact and Group Member
 */
class Conversation
{
    /**
     * Primary Key of the record
     */
    private int $id;
    /**
     * • The class that stores all the properties that are related to the group members
     */
    private GroupMember $GroupMember;
    /**
     * • The class that stores all the properties that are related to the contacts given that it should inherit the user class
     */
    private Contact $Contact;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
        // Instantiating Group Member
        $this->GroupMember = new GroupMember();
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
    // Contact.ID accessor method
    public function getContactId()
    {
        $this->Contact->getId();
    }
    // Contact.ID mutator method
    public function setContactId(int $contact_id)
    {
        $this->Contact->setId($contact_id);
    }
    // GroupMember.ID accessor method
    public function getGroupMemberId()
    {
        $this->GroupMember->getId();
    }
    // GroupMember.ID mutator method
    public function setGroupMemberId(int $groupMember_id)
    {
        $this->GroupMember->setId($groupMember_id);
    }
}
