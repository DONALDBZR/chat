<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Environment.php";
/**
 * A simpler version of PDO for developers to understand
 */
class PHPDataObject
{
    /**
     * The ENV that will be used
     */
    public Environment $Environment;
    /**
     * The data source name which contains the database's name, the IP address and the port of the database server
     */
    private string $dataSourceName = Environment::MySQLDataSourceName;
    /**
     * The username that is used to authenticate on MySQL server
     */
    private string $username = Environment::MySQLUsername;
    /**
     * The password of the username that is used to authenticate on MySQL server
     */
    private string $password = Environment::MySQLPassword;
    /**
     * The database handler that is being used for this application which is PHP Data Objects
     */
    private PDO $databaseHandler;
    /**
     * The SQL query that is used to interact with the database server
     */
    private $statement;
    public function __construct()
    {
        /**
         * The options that are going to be passed in the database handler while instantiating PHP Data Objects
         */
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try {
            $this->databaseHandler = new PDO($this->dataSourceName, $this->username, $this->password, $options);
        } catch (PDOException $error) {
            echo "Connection Failed: " . $error->getMessage();
        }
    }
    /**
     * Sanitizing the data that is retrieved from the front-end in order to prevent SQL injections
     */
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
    /**
     * Preparing the SQL query that is going to be handled by the database handler
     */
    public function query($query)
    {
        $this->statement = $this->databaseHandler->prepare($query);
    }
    /**
     * Executing the SQL query which will send a command to the database server
     */
    public function execute()
    {
        return $this->statement->execute();
    }
    /**
     * Fetching all the data that is requested from the command that was sent to the database server
     */
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
