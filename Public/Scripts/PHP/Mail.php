<?php
// Importing the requisities of PHPMailer
require_once "{$_SERVER['DOCUMENT_ROOT']}/Modules/PHPMailer/src/PHPMailer.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/Modules/PHPMailer/src/Exception.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/Modules/PHPMailer/src/SMTP.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Environment.php";
/**
 * Simplifying the use of PHPMailer
 */
class Mail
{
    /**
     * The recipient of the mail
     */
    private string $recipient;
    /**
     * Subject of the mail
     */
    private string $subject;
    /**
     * body of the mail
     */
    private string $message;
    /**
     * PHPMailer
     */
    protected $PHPMailer;
    /**
     * Instantiating PHPMailer and setting its configuration
     */
    public function __construct()
    {
        $this->PHPMailer = new PHPMailer\PHPMailer\PHPMailer(true);
    }
    // Recipient accessor method
    public function getRecipient()
    {
        return $this->recipient;
    }
    // Recipient mutator method
    public function setRecipient(string $recipient)
    {
        $this->recipient = $recipient;
    }
    // Subject accessor method
    public function getSubject()
    {
        return $this->subject;
    }
    // Subject mutator method
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }
    // Message accessor method
    public function getMessage()
    {
        return $this->message;
    }
    // Message mutator method
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
    /**
     * Sending the mail after having configured PHPMailer
     */
    public function send(string $recipient, string $subject, string $message)
    {
        $this->setRecipient($recipient);
        $this->setSubject($subject);
        $this->setMessage($message);
        $this->PHPMailer->isSMTP();
        $this->PHPMailer->CharSet = "UTF-8";
        $this->PHPMailer->Host = "smtp-mail.outlook.com";
        $this->PHPMailer->SMTPDebug = 0;
        $this->PHPMailer->Port = 587;
        $this->PHPMailer->SMTPSecure = 'tls';
        $this->PHPMailer->SMTPAuth = true;
        $this->PHPMailer->isHTML(true);
        $this->PHPMailer->Username = Environment::MailUsername;
        $this->PHPMailer->Password = Environment::MailPassword;
        $this->PHPMailer->setFrom($this->PHPMailer->Username);
        $this->PHPMailer->addAddress($this->getRecipient());
        $this->PHPMailer->Subject = $this->getSubject();
        $this->PHPMailer->Body = $this->getMessage();
        $this->PHPMailer->send();
    }
}
