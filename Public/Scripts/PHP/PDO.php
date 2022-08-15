<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Environment.php";
class PHPDataObject
{
    public Environment $Environment;
    private string $dataSourceName = "mysql:dbname=Chat;host=localhost:3306";
    private string $username = $this->Environment->mySqlUsername;
    private string $password = $this->Environment->mySqlPassword;
    private PDO $databaseHandler;
    private $statement;
    public function __construct()
    {
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try {
            $this->databaseHandler = new PDO($this->dataSourceName, $this->username, $this->password, $options);
        } catch (PDOException $error) {
            echo "Connection Failed: " . $error->getMessage();
        }
    }
    public function bind($parameter, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    public function query($query)
    {
        $this->statement = $this->databaseHandler->prepare($query);
    }
    public function execute()
    {
        return $this->statement->execute();
    }
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
