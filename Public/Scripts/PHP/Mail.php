<?php
// Importing the requisities of PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

require_once "{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/PHPMailer.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/Exception.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/SMTP.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Public/Scripts/PHP/Environment.php";
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
        $this->PHPMailer = new PHPMailer(true);
        $this->configure();
    }
}
