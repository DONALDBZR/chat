<?php
// Importing Conversation
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Coversation.php";
/**
 * • The class that stores all the properties related to the messages given that it should inherit from the conversation
 */
class Message extends Conversation
{
    /**
     * Primary Key of the record
     */
    private int $id;
    /**
     * Plain text to be encrypted
     */
    private string $plainText;
    /**
     * Cipher text to be decrypted
     */
    private string $cipherText;
    /**
     * Sender of the message
     */
    private string $sender;
    /**
     * Time at which the message was sent
     */
    private string $timestamp;
    /**
     * • The class that stores all the properties related to the conversations given that it is a class which is composed of Contact and Group Member
     */
    private Conversation $Conversation;
    // Constructor method
    public function __construct()
    {
        // Instantiating PDO
        $this->PDO = new PHPDataObject();
        // Instantiating Conversation
        $this->Conversation = new Conversation();
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
    // Plain Text accessor method
    public function getPlainText()
    {
        return $this->plainText;
    }
    // Plain Text mutator method
    public function setPlainText(string $plain_text)
    {
        $this->plainText = $plain_text;
    }
    // Cipher Text accessor method
    public function getCipherText()
    {
        return $this->cipherText;
    }
    // Cipher Text mutator method
    public function setCipherText(string $cipher_text)
    {
        $this->cipherText = $cipher_text;
    }
    // Conversation.ID accessor method
    public function getConversationId()
    {
        $this->Conversation->getId();
    }
    // Conversation.ID mutator method
    public function setConversationId(int $conversation_id)
    {
        $this->Conversation->setID($conversation_id);
    }
    // Sender accessor method
    public function getSender()
    {
        return $this->sender;
    }
    // Sender mutator method
    public function setSender(string $sender)
    {
        $this->sender = $sender;
    }
    // Timestamp accessor method
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    // Timestamp mutator method
    public function setTimestamp(string $timestamp)
    {
        $this->timestamp = $timestamp;
    }
}
