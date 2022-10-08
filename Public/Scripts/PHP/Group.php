<?php
// Importing PDO
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/PDO.php";
/**
 * • The class that stores all the properties that are related to the groups
 */
class Group
{
    /**
     * The primary key of the Groups table
     */
    private int $id;
    /**
     * The name of the group
     */
    private string $name;
    /**
     * PDO which will interact with the database server
     */
    protected PHPDataObject $PDO;
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
    // Name accessor method
    public function getName()
    {
        return $this->name;
    }
    // Name mutator method
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
