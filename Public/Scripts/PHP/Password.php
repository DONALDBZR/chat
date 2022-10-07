<?php
// Importing PDO
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/PDO.php";
/**
 * • The class that stores all the properties that are related to the password as well as all the actions that are going to be performed in the application by the application.
 * • The class variables are set the same way as the fields in the Users table.  In fact, the class represents a record.
 */
class Password
{
    /**
     * The ID of the record
     */
    private int $id;
    /**
     * The salt of the password
     */
    private string $salt;
    /**
     * The plain text of the password
     */
    private string $password;
    /**
     * The hash of the password
     */
    private string $hash;
    /**
     * PDO which will interact with the database server
     */
    protected PHPDataObject $PDO;
    /**
     * The one-time password needed for the user to complete the login process
     */
    private string $otp;
    /**
     * The domain of the application
     */
    public $domain = "http://chat.local";
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
    }
    // ID accessor method
    public function getID()
    {
        return $this->id;
    }
    // ID mutator method
    public function setID(int $id)
    {
        $this->id = $id;
    }
    // Salt accessor method
    public function getSalt()
    {
        return $this->salt;
    }
    // Salt mutator method
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }
    // Password accessor method
    public function getPassword()
    {
        return $this->password;
    }
    // Password mutator method
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    // Hash accessor method
    public function getHash()
    {
        return $this->hash;
    }
    // Hash mutator method
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }
    // One-Time Password accessor method
    public function getOtp()
    {
        return $this->otp;
    }
    // One-Time Password mutator method
    public function setOtp(string $otp)
    {
        $this->otp = $otp;
    }
    /**
     * Generating the salt that will be appended the password in its plain form before inserting it in the database
     * @return string
     */
    public function generateSalt()
    {
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-*/.';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($index = 0; $index < $length; $index++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Generating a password for the user
     */
    public function generatePassword()
    {
        $length = 16;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-*/.';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($index = 0; $index < $length; $index++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Generating an one-time password for the user
     */
    public function otpGenerate()
    {
        $length = 6;
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($index = 0; $index < $length; $index++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Verifying the one-time password that was sent to the user
     */
    public function otpVerify()
    {
        $JSON = json_decode(file_get_contents('php://input'));
        $this->setOtp($_SESSION['User']['otp']);
        if ($JSON->oneTimePassword == $this->getOtp()) {
            unset($_SESSION['User']['otp']);
            $json = array(
                "success" => "success",
                "url" => "{$this->domain}/Users/Dashboard/{$_SESSION['User']['username']}",
                "message" => "You will be connected to the service as soon as possible..."
            );
            header('Content-Type: application/json', true, 200);
            echo json_encode($json);
        } else {
            unset($_SESSION['User']);
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}/",
                "message" => "The Password does not correspond to the one that was sent to you!"
            );
            header('Content-Type: application/json', true, 200);
            echo json_encode($json);
        }
    }
}
