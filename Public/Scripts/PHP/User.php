<?php
// Importing PDO
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/PDO.php";
// Importing Mail
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Mail.php";
/**
 * • The class that stores all the properties that are related to the user as well as all the actions that are going to be performed in the application by any user.
 * • The class variables are set the same way as the fields in the Users table.  In fact, the class represents a record.
 */
class User
{
    /**
     * The username of the username which is also the primary key
     */
    private string $username;
    /**
     * The mail address of the user
     */
    private string $mailAddress;
    /**
     * The password of the user
     */
    private string $password;
    /**
     * The one-time password needed for the user to complete the login process
     */
    private string $otp;
    /**
     * The domain of the application
     */
    public $domain = "http://chat.local";
    /**
     * PDO which will interact with the database server
     */
    protected PHPDataObject $PDO;
    /**
     * Mail which will interact with PHPMailer
     */
    protected Mail $Mail;
    /**
     * Profile Picture of the user
     */
    private $profilePicture;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
        // Instantiating Mail
        $this->Mail = new Mail();
    }
    // Username accessor method
    public function getUsername()
    {
        return $this->username;
    }
    // Username mutator method
    public function setUsername($username)
    {
        $this->username = $username;
    }
    // Mail Address accessor method
    public function getMailAddress()
    {
        return $this->mailAddress;
    }
    // Mail Address mutator method
    public function setMailAddress(string $mailAddress)
    {
        $this->mailAddress = $mailAddress;
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
    // Profile Picture accessor method
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }
    // Profile Picture mutator method
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }
    /**
     * 1. Checking whether the mail address or username retrieved from the JSON exists in the database.
     * 2. In the condition that the mail address or username existed, verify that the password retrieved is the same as the one that is in the database.
     * 3. In the condition that the passwords are actually the same, a session variable will be created with all the data within that record.
     * 4. A JSON will then be generated as a response which will be sent to the front-end.
     */
    public function login()
    {
        $json = json_decode(file_get_contents('php://input'));
        $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersUsername = :UsersUsername");
        $this->PDO->bind(":UsersUsername", $json->username);
        $this->PDO->execute();
        if (!empty($this->PDO->resultSet())) {
            $this->setUsername($this->PDO->resultSet()[0]['UsersUsername']);
            $this->setMailAddress($this->PDO->resultSet()[0]['UsersMailAddress']);
            $this->setPassword($this->PDO->resultSet()[0]['UsersPassword']);
            $this->setProfilePicture($this->PDO->resultSet()[0]['UsersProfilePicture']);
            if (password_verify($json->password, $this->getPassword())) {
                $user = array(
                    "username" => $this->getUsername(),
                    "mailAddress" => $this->getMailAddress(),
                    "password" => $this->getPassword(),
                    "domain" => $this->domain,
                    "profilePicture" => $this->getProfilePicture()
                );
                $_SESSION['User'] = $user;
                $this->setOtp($this->otpGenerate());
                $_SESSION['User']['otp'] = $this->getOtp();
                $this->Mail->send($this->getMailAddress(), "Verification Needed!", "Your one-time password is {$this->getOtp()}.  Please use this password to complete the log in process on {$this->domain}/Login/Verification");
                $json = array(
                    "success" => "success",
                    "url" => "{$this->domain}/Login/Verification",
                    "message" => "You will be redirected to the verification process just to be sure and a password has been sent to you for that! 🙏"
                );
                header('Content-Type: application/json');
                echo json_encode($json);
            } else {
                $json = array(
                    "success" => "failure",
                    "url" => "{$this->domain}/Login",
                    "message" => "Your password is incorrect!"
                );
                header('Content-Type: application/json');
                echo json_encode($json);
            }
        } else {
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}",
                "message" => "This account does not exist!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    /**
     * 1. Checking whether the mail address or username retrieved from the JSON exists in the database.
     * 2. In the condition that the mail address or username existed, verify that the passwords retrieved are the same.
     * 3. In the condition that the passwords are actually the same, an account will be created.
     * 4. A JSON will then be generated as a response which will be sent to the front-end.
     */
    public function register()
    {
        $json = json_decode(file_get_contents('php://input'));
        $this->setUsername($json->username);
        $this->setMailAddress($json->mailAddress);
        $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersUsername = :UsersUsername AND UsersMailAddress = :UsersMailAddress");
        $this->PDO->bind(":UsersUsername", $this->getUsername());
        $this->PDO->bind(":UsersMailAddress", $this->getMailAddress());
        $this->PDO->execute();
        if (empty($this->PDO->resultSet())) {
            $this->setPassword($this->generatePassword());
            $this->Mail->send($this->getMailAddress(), "Registration Complete", "Your account with username, {$this->getUsername()} and password, {$this->getPassword()} has been created.  Please consUsernameer to change it after logging in!");
            $this->PDO->query("INSERT INTO Chat.Users(UsersUsername, UsersMailAddress, UsersPassword) VALUES (:UsersUsername, :UsersMailAddress, :UsersPassword)");
            $this->PDO->bind(":UsersUsername", $this->getUsername());
            $this->PDO->bind(":UsersMailAddress", $this->getMailAddress());
            $this->PDO->bind(":UsersPassword", password_hash($this->getPassword(), PASSWORD_ARGON2I));
            $this->PDO->execute();
            $json = array(
                "success" => "success",
                "url" => "{$this->domain}/Login",
                "message" => "Account created!  Please check your mail to obtain your password!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}/Login",
                "message" => "Account exists!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    /**
     * Logging out the user from the application
     */
    public function logout()
    {
        unset($_SESSION['User']);
        $json = array(
            "success" => "success",
            "url" => "{$this->domain}",
            "message" => "You have been successfully logged out!"
        );
        header('Content-Type: application/json');
        echo json_encode($json);
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
            $this->setUsername($_SESSION['User']['username']);
            $json = array(
                "success" => "success",
                "url" => "{$this->domain}/User/Dashboard/{$this->getUsername()}",
                "message" => "You will be connected to the service as soon as possible..."
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            unset($_SESSION['User']);
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}/",
                "message" => "The Password does not correspond to the one that was sent to you!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    /**
     * Resetting the password, updating it and sending it back to the user
     */
    public function forgotPassword()
    {
        $JSON = json_decode(file_get_contents('php://input'));
        $this->setMailAddress($JSON->mailAddress);
        $this->PDO->query("SELECT * FROM Chat.Users WHERE UsersMailAddress = :UsersMailAddress");
        $this->PDO->bind(":UsersMailAddress", $this->getMailAddress());
        $this->PDO->execute();
        if (!empty($this->PDO->resultSet())) {
            $this->setPassword($this->generatePassword());
            $this->Mail->send($this->getMailAddress(), "Password Reset!", "Your new password is {$this->getPassword()} and please consUsernameer to change it after logging in!");
            $this->PDO->query("UPDATE Chat.Users SET UsersPassword = :UsersPassword WHERE UsersMailAddress = :UsersMailAddress");
            $this->PDO->bind(":UsersPassword", password_hash($this->getPassword(), PASSWORD_ARGON2I));
            $this->PDO->bind(":UsersMailAddress", $this->getMailAddress());
            $this->PDO->execute();
            $json = array(
                "success" => "success",
                "url" => "{$this->domain}/Login",
                "message" => "Password Reset!  Please check your mail to obtain your new password!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            $json = array(
                "success" => "failure",
                "url" => "{$this->domain}",
                "message" => "There is no account that is linked to this mail address!"
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    /**
     * Changing the profile picture of the user
     */
    public function changeProfilePicture()
    {
        $this->setUsername($_SESSION['User']['username']);
        $imageDirectory = "/Public/Images/ProfilePictures/";
        $imageFile = $imageDirectory . $this->getUsername() . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadedPath = $_SERVER['DOCUMENT_ROOT'] . $imageFile;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedPath)) {
            $this->setProfilePicture($imageFile);
            $this->PDO->query("UPDATE Chat.Users UsersProfilePicture = :UsersProfilePicture WHERE UsersUsername = :UsersUsername");
            $this->PDO->bind(":UsersProfilePicture", $this->getProfilePicture());
            $this->PDO->bind(":UsersUsername", $this->getUsername());
            $this->PDO->execute();
            $_SESSION['User']['profilePicture'] = $this->getProfilePicture();
            $json = array(
                "success" => "success",
                "url" => "{$this->domain}/User/Profile/{$this->getUsername()}",
                "message" => "Your profile picture has been changed."
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
}
